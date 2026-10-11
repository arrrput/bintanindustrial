<?php

namespace App\Http\Controllers;

use App\Models\Bie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Helpers\LogHelper;
use App\Helpers\ImageCompressor;

class BieController extends Controller
{
    private array $pageGroupViews = [
        'bie'    => 'cms.bies.create-bie',
        'work'   => 'cms.bies.create-work',
        'bintan' => 'cms.bies.create-bintan',
    ];

    private array $pageGroupEditViews = [
        'bie'    => 'cms.bies.edit-bie',
        'work'   => 'cms.bies.edit-work',
        'bintan' => 'cms.bies.edit-bintan',
    ];

    /**
     * Where each kind of item lives in the CMS: [label, permission, CMS page route, log page name].
     * "work" items are split by category across the Profiles and OSS pages.
     */
    private const SECTIONS = [
        'bie'                => ['Our Industrial Estate', 'home.manage', 'cms.home.index', 'Home'],
        'bintan'             => ['Bintan Island', 'profiles.manage', 'cms.profiles.index', 'Profiles'],
        'work.main_section'  => ['Business Opportunity', 'profiles.manage', 'cms.profiles.index', 'Profiles'],
        'work.service_suite' => ['One Stop Service Suite', 'oss.manage', 'cms.oss.index', 'OSS'],
        'work.facility'      => ['Facilities', 'oss.manage', 'cms.oss.index', 'OSS'],
    ];

    public function index()
    {
        return redirect()->route('cms.profiles.index');
    }

    public function create(Request $request)
    {
        $pageGroup = in_array($request->page_group, ['bie', 'work', 'bintan'])
            ? $request->page_group
            : 'bie';
        $category = $request->query('category');

        $this->authorizeSection($pageGroup, $category);

        return view($this->pageGroupViews[$pageGroup], compact('pageGroup', 'category'));
    }

    public function store(Request $request)
    {
        $pageGroup = $request->input('page_group', 'bie');
        $category = $request->input('category') ?? 'main_section';

        $this->authorizeSection($pageGroup, $category);
        $request->validate($this->validationRules($pageGroup, $category));

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = ImageCompressor::store($request->file('image'), $category === 'facility' ? 'facilities' : $pageGroup);
        }

        $order = $request->order;
        if (is_null($order)) {
            $query = Bie::where('page_group', $pageGroup);
            if ($pageGroup === 'work') {
                $query->where('category', $category);
            }
            $maxOrder = $query->max('order');
            $order = $maxOrder ? $maxOrder + 1 : 1;
        }

        $bie = Bie::create([
            'page_group'    => $pageGroup,
            'badge'         => $request->badge,
            'title'         => $request->title,
            'subtitle'      => $request->subtitle,
            'description'   => $request->description,
            'image'         => $imagePath,
            'icon'          => $request->icon,
            'layout_style'  => $request->layout_style,
            'extra_content' => $request->extra_content,
            'category'      => $category,
            'order'         => $order,
        ]);

        LogHelper::log('CREATE', $this->logModule($bie), "Added: {$bie->title}");

        return redirect()->route($this->section($bie->page_group, $bie->category)[2])
                         ->with('success', 'Content successfully added!');
    }

    public function edit($id)
    {
        $bie = Bie::findOrFail($id);
        $this->authorizeSection($bie->page_group, $bie->category);

        $view = $this->pageGroupEditViews[$bie->page_group] ?? 'cms.bies.edit-bie';
        return view($view, compact('bie'));
    }

    public function update(Request $request, $id)
    {
        $bie = Bie::findOrFail($id);
        $pageGroup = $bie->page_group;
        $category = $request->input('category') ?? $bie->category;

        // Moving an item to another section needs access to both sections
        $this->authorizeSection($pageGroup, $bie->category);
        $this->authorizeSection($pageGroup, $category);
        $request->validate($this->validationRules($pageGroup, $category, $bie));

        $imagePath = $bie->image;
        if ($request->hasFile('image')) {
            if ($bie->image && Storage::disk('public')->exists($bie->image)) {
                Storage::disk('public')->delete($bie->image);
            }
            $imagePath = ImageCompressor::store($request->file('image'), $category === 'facility' ? 'facilities' : $pageGroup);
        }

        $bie->update([
            'badge'         => $request->badge,
            'title'         => $request->title,
            'subtitle'      => $request->subtitle,
            'description'   => $request->description,
            'image'         => $imagePath,
            'icon'          => $request->icon,
            'layout_style'  => $request->layout_style ?? $bie->layout_style,
            'extra_content' => $request->extra_content ?? $bie->extra_content,
            'category'      => $category,
        ]);

        LogHelper::log('UPDATE', $this->logModule($bie), "Updated: {$bie->title}");

        return redirect()->route($this->section($bie->page_group, $bie->category)[2])
                         ->with('success', 'Content successfully updated!');
    }

    public function destroy($id)
    {
        $bie = Bie::findOrFail($id);
        $this->authorizeSection($bie->page_group, $bie->category);

        $title = $bie->title;
        $module = $this->logModule($bie);
        $route = $this->section($bie->page_group, $bie->category)[2];

        if ($bie->image && Storage::disk('public')->exists($bie->image)) {
            Storage::disk('public')->delete($bie->image);
        }

        $bie->delete();

        LogHelper::log('DELETE', $module, "Deleted: {$title}");

        return redirect()->route($route)->with('success', 'Content successfully deleted!');
    }

    /**
     * Drag & drop reordering: receives the ids of one list (same section) in their new order.
     */
    public function reorder(Request $request)
    {
        $data = $request->validate([
            'ids'   => 'required|array|min:1',
            'ids.*' => 'integer|distinct|exists:bies,id',
        ]);

        $items = Bie::whereIn('id', $data['ids'])->get()->keyBy('id');

        // Every item must belong to the same list, otherwise the order makes no sense
        $sections = $items->map(fn ($bie) => $bie->page_group === 'work' ? 'work.' . $bie->category : $bie->page_group)->unique();
        abort_if($sections->count() !== 1, 422, 'Items from different sections cannot be ordered together.');

        $first = $items->first();
        $this->authorizeSection($first->page_group, $first->category);

        DB::transaction(function () use ($data, $items) {
            foreach (array_values($data['ids']) as $position => $id) {
                $items[$id]->update(['order' => $position + 1]);
            }
        });

        [$label] = $this->section($first->page_group, $first->category);
        LogHelper::log('UPDATE', $this->logModule($first), "Reordered {$label}");

        return response()->json(['message' => 'Order saved.']);
    }

    private function section(string $pageGroup, ?string $category): array
    {
        $key = $pageGroup === 'work' ? 'work.' . ($category ?: 'main_section') : $pageGroup;

        return self::SECTIONS[$key] ?? self::SECTIONS['bie'];
    }

    private function authorizeSection(string $pageGroup, ?string $category): void
    {
        abort_unless(auth()->user()->can($this->section($pageGroup, $category)[1]), 403);
    }

    private function logModule(Bie $bie): string
    {
        [$label, , , $page] = $this->section($bie->page_group, $bie->category);

        return "{$page} - {$label}";
    }

    private function validationRules(string $pageGroup, ?string $category, ?Bie $existing = null): array
    {
        $base = [
            'title'    => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'image'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'icon'     => 'nullable|string|max:255',
        ];

        if (!$existing) {
            $base['order'] = 'nullable|integer';
        }

        $group = match ($pageGroup) {
            'bie' => [
                'badge'       => 'nullable|string|max:255',
                'description' => 'required',
                'category'    => 'required|in:main_section,pillar_card',
            ],
            'work' => [
                // Facilities are photo cards: image + icon, description optional
                'description' => $category === 'facility' ? 'nullable' : 'required',
                'category'    => 'required|in:main_section,service_suite,facility',
                'icon'        => in_array($category, ['service_suite', 'facility']) ? 'required|string|max:255' : 'nullable|string|max:255',
                'image'       => $category === 'facility' && !$existing?->image
                    ? 'required|image|mimes:jpeg,png,jpg,webp|max:2048'
                    : 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            ],
            'bintan' => [
                'description'  => 'nullable',
                'layout_style' => 'required|string',
            ],
            default => ['description' => 'required'],
        };

        return array_merge($base, $group);
    }
}

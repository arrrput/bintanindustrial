<?php

namespace App\Http\Controllers;

use App\Models\Bie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Helpers\LogHelper;

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

    private array $moduleMap = [
        'bie'    => 'BIE',
        'work'   => 'Facilities & Work',
        'bintan' => 'Bintan Island',
    ];

    public function index()
    {
        return redirect()->route('cms.bie-page.index');
    }

    public function create(Request $request)
    {
        $pageGroup = in_array($request->page_group, ['bie', 'work', 'bintan'])
            ? $request->page_group
            : 'bie';
        return view($this->pageGroupViews[$pageGroup], compact('pageGroup'));
    }

    public function store(Request $request)
    {
        $pageGroup = $request->input('page_group', 'bie');

        $request->validate($this->validationRules($pageGroup));

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store($pageGroup, 'public');
        }

        $order = $request->order;
        if (is_null($order)) {
            $maxOrder = Bie::where('page_group', $pageGroup)->max('order');
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
            'category'      => $request->category ?? 'main_section',
            'order'         => $order,
        ]);

        LogHelper::log('CREATE', 'BIE Page - ' . ($this->moduleMap[$pageGroup] ?? $pageGroup), "Added: {$bie->title}");

        return redirect()->route('cms.bie-page.index')
                         ->with('success', 'Content successfully added!');
    }

    public function edit($id)
    {
        $bie = Bie::findOrFail($id);
        $view = $this->pageGroupEditViews[$bie->page_group] ?? 'cms.bies.edit-bie';
        return view($view, compact('bie'));
    }

    public function update(Request $request, $id)
    {
        $bie = Bie::findOrFail($id);
        $pageGroup = $bie->page_group;

        $request->validate($this->validationRules($pageGroup, isUpdate: true));

        $imagePath = $bie->image;
        if ($request->hasFile('image')) {
            if ($bie->image && Storage::disk('public')->exists($bie->image)) {
                Storage::disk('public')->delete($bie->image);
            }
            $imagePath = $request->file('image')->store($pageGroup, 'public');
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
            'category'      => $request->category ?? $bie->category,
        ]);

        LogHelper::log('UPDATE', 'BIE Page - ' . ($this->moduleMap[$pageGroup] ?? $pageGroup), "Updated: {$bie->title}");

        return redirect()->route('cms.bie-page.index')
                         ->with('success', 'Content successfully updated!');
    }

    public function destroy($id)
    {
        $bie = Bie::findOrFail($id);
        $title = $bie->title;
        $pageGroup = $bie->page_group;

        if ($bie->image && Storage::disk('public')->exists($bie->image)) {
            Storage::disk('public')->delete($bie->image);
        }

        $bie->delete();

        LogHelper::log('DELETE', 'BIE Page - ' . ($this->moduleMap[$pageGroup] ?? $pageGroup), "Deleted: {$title}");

        return redirect()->route('cms.bie-page.index')
                         ->with('success', 'Content successfully deleted!');
    }

    private function validationRules(string $pageGroup, bool $isUpdate = false): array
    {
        $base = [
            'title'    => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'image'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'icon'     => 'nullable|string|max:255',
        ];

        if (!$isUpdate) {
            $base['order'] = 'nullable|integer';
        }

        $group = match ($pageGroup) {
            'bie' => [
                'badge'       => 'nullable|string|max:255',
                'description' => 'required',
                'category'    => 'required|in:main_section,pillar_card',
            ],
            'work' => [
                'description' => 'required',
                'category'    => 'required|in:main_section,service_suite',
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

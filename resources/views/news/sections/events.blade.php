{{-- Section: Events --}}
@php use Illuminate\Support\HtmlString; @endphp

<section class="page-content section pb-0">
    <div class="container">
        @forelse ($eventProgram as $index => $item)
            @include('news.partials.program-row', [
                'reversed' => $index % 2 != 0,
                'rowClass' => 'mb-5',
                'image' => $item->image ? asset('storage/' . $item->image) : asset('assets/img/Bintan/image8.jpeg'),
                'alt' => $item->image ? $item->title : 'Event at BIE',
                'headingTag' => 'h2',
                'headingClass' => 'text-primary fw-bold mb-3',
                'title' => $item->title,
                'subtitle' => $item->subtitle,
                'description' => new HtmlString(nl2br(e($item->description))),
                'descriptionClass' => 'description-content',
            ])
        @empty
            {{-- Fallback content when no event program exists yet --}}
            @include('news.partials.program-row', [
                'reversed' => false,
                'rowClass' => 'mb-5',
                'image' => asset('assets/img/Bintan/image8.jpeg'),
                'alt' => 'Event at BIE',
                'headingTag' => 'h2',
                'headingClass' => 'text-primary fw-bold mb-3',
                'title' => 'EVENTS AT BIE',
                'subtitle' => '"Bringing our community of tenants and partners together."',
                'description' => new HtmlString(
                    '<p>Each year, Bintan Industrial Estate hosts gatherings and celebrations that bring together tenants, employees and partners across the estate. From cultural festivities to milestone celebrations, these events strengthen the sense of community within our self-contained industrial township.</p>' .
                    '<p>These occasions are also an opportunity to recognize the contributions of our tenants and workforce, reinforcing the collaborative spirit that has helped BIE grow into a thriving industrial hub.</p>'
                ),
            ])
        @endforelse
    </div>
</section>

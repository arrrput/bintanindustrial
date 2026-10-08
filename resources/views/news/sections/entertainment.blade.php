{{-- Section: Entertainment (image starts on the right) --}}
@php use Illuminate\Support\HtmlString; @endphp

<section class="page-content section pt-0 pb-0">
    <div class="container">
        @forelse ($entertainmentProgram as $index => $item)
            @include('news.partials.program-row', [
                'reversed' => $index % 2 == 0,
                'rowClass' => 'mt-5 pt-4',
                'image' => $item->image ? asset('storage/' . $item->image) : asset('assets/img/Bintan/image9.jpeg'),
                'alt' => $item->image ? $item->title : 'Resort-Style Entertainment',
                'headingTag' => 'h3',
                'headingClass' => 'fw-bold mb-3',
                'title' => $item->title,
                'subtitle' => $item->subtitle,
                'description' => new HtmlString(nl2br(e($item->description))),
                'descriptionClass' => 'description-content mb-4',
                'cta' => $loop->first,
            ])
        @empty
            {{-- Fallback content when no entertainment program exists yet --}}
            @include('news.partials.program-row', [
                'reversed' => true,
                'rowClass' => 'mt-5 pt-4',
                'image' => asset('assets/img/Bintan/image9.jpeg'),
                'alt' => 'Resort-Style Entertainment',
                'headingTag' => 'h3',
                'headingClass' => 'fw-bold mb-3',
                'title' => new HtmlString('Resort-Style <span class="text-primary">ENTERTAINMENT</span>'),
                'description' => new HtmlString(
                    '<p>The sun, sand and sea beckon at Bintan International Resorts, an award-winning integrated tropical beach resort destination. Situated on the northern coast of the island, the destination is home to a collection of beautiful beach resorts, designer golf courses and a multitude of recreational facilities and leisure attractions.</p>' .
                    '<p>From sunbathing on endless stretches of white, sandy beaches to exhilarating water sports and everything in between, tenants and employees of Bintan Industrial Estate can unwind in the relaxing embrace of the resorts just minutes away.</p>'
                ),
                'cta' => true,
            ])
        @endforelse
    </div>
</section>

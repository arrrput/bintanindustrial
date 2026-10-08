{{-- Section: Corporate Social Responsibility --}}
@php use Illuminate\Support\HtmlString; @endphp

<section class="page-content section pt-0">
    <div class="container">
        @forelse ($csrProgram as $index => $item)
            @include('program.partials.program-row', [
                'reversed' => $index % 2 != 0,
                'rowClass' => 'mt-5 pt-4',
                'image' => $item->image ? asset('storage/' . $item->image) : asset('assets/img/Bintan/image10.jpeg'),
                'alt' => $item->image ? $item->title : 'Corporate Social Responsibility',
                'headingTag' => 'h3',
                'headingClass' => 'fw-bold mb-3',
                'title' => $item->title,
                'subtitle' => $item->subtitle,
                'description' => new HtmlString(nl2br(e($item->description))),
                'descriptionClass' => 'description-content',
            ])
        @empty
            {{-- Fallback content when no CSR program exists yet --}}
            @include('program.partials.program-row', [
                'reversed' => false,
                'rowClass' => 'mt-5 pt-4',
                'image' => asset('assets/img/Bintan/image10.jpeg'),
                'alt' => 'Corporate Social Responsibility',
                'headingTag' => 'h3',
                'headingClass' => 'fw-bold mb-3',
                'title' => new HtmlString('Corporate Social <span class="text-primary">RESPONSIBILITY</span>'),
                'subtitle' => '"Giving back to the community and environment we grow in."',
                'description' => new HtmlString(
                    '<p>Bintan Industrial Estate is committed to supporting the local community through education, environmental sustainability and social welfare initiatives. Our CSR programs include scholarship support for local students, environmental conservation efforts and partnerships with nearby villages.</p>' .
                    '<p>We believe that sustainable business growth goes hand in hand with the wellbeing of the communities and environment surrounding our estate.</p>'
                ),
            ])
        @endforelse
    </div>
</section>

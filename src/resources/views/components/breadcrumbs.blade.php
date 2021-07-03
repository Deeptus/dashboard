@if (count($breadcrumbs))

    <h1 class="h3 mb-0 text-gray-800">
        @foreach ($breadcrumbs as $breadcrumb)

            @if ($breadcrumb->url && !$loop->last)
                <a href="{{ $breadcrumb->url }}">{{ $breadcrumb->title }}</a> >
            @else
                {{ $breadcrumb->title }}
            @endif

        @endforeach
    </h1>

@endif

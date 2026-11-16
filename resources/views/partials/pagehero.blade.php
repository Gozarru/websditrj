<section class="phero"><div class="wrap">
    <nav class="crumbs" aria-label="Breadcrumb">
        <a href="{{ route('home') }}">Beranda</a>
        @foreach($crumbs as $label => $url)
            <svg class="ic"><use href="#i-right"/></svg>
            @if($url)<a href="{{ $url }}">{{ $label }}</a>@else<span aria-current="page">{{ $label }}</span>@endif
        @endforeach
    </nav>
    <p class="eyebrow">{{ $eyebrow }}</p>
    <h1>{{ $title }}</h1>
    @if(!empty($subtitle))<p class="sub">{{ $subtitle }}</p>@endif
</div></section>

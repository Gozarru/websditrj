<div class="card arow static">
    <span class="dbox"><b>{{ $a->starts_on->format('j') }}</b><small>{{ $a->starts_on->translatedFormat('M Y') }}</small></span>
    <span class="atxt">
        <h3>{{ $a->title }}</h3>
        <p class="ameta">{{ $a->dateLabel() }}@if($a->time_text) · {{ $a->time_text }}@endif @if($a->location) · {{ $a->location }}@endif</p>
        @if($a->description)<p>{{ $a->description }}</p>@endif
    </span>
</div>

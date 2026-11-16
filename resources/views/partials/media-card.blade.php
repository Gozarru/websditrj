<a class="card mcard" href="{{ $m->url }}" target="_blank" rel="noopener">
    <span class="badge">{{ $m->type }}</span>
    <h3>{{ $m->title }}</h3>
    @if($m->description)<p>{{ $m->description }}</p>@endif
    <span class="open">Buka materi<svg class="ic ne"><use href="#i-ne"/></svg></span>
</a>

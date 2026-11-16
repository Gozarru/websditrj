<aside class="side">
    <p class="side-label">{{ $label }}</p>
    <nav aria-label="{{ $label }}">
        @foreach($items as $it)
            <a href="{{ $it['url'] }}" class="{{ $it['on'] ? 'on' : '' }}" @if($it['on']) aria-current="page" @endif>
                <span>{{ $it['label'] }}</span>
                @if(isset($it['count']))<small>{{ $it['count'] }}</small>@endif
            </a>
        @endforeach
    </nav>
</aside>

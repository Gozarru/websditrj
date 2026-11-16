<div class="prest">
    @foreach($achievements as $a)
    <div class="r">
        <span class="yr">{{ $a->year }}</span>
        <span class="t"><b>{{ $a->title }}</b>@if($a->description)<small>{{ $a->description }}</small>@endif</span>
        <span class="lv">{{ $a->level }}</span>
    </div>
    @endforeach
</div>

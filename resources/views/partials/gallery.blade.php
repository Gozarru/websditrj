<div class="gal" data-gallery>
    @foreach($photos as $ph)
    <a href="{{ upload_url($ph->image) }}" data-lightbox data-caption="{{ $ph->caption }}">
        <img src="{{ upload_url($ph->image) }}" alt="{{ $ph->caption ?: 'Foto kegiatan sekolah' }}" loading="lazy">
        @if($ph->caption)<span>{{ $ph->caption }}</span>@endif
    </a>
    @endforeach
</div>

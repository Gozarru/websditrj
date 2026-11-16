@php
    $keys = array_keys(\App\Support\PostWorkflow::STEPS);
    $cur = $post->status === 'scheduled' ? 4 : array_search($post->status, $keys);
    $stepLabels = \App\Support\PostWorkflow::STEPS;
    if ($post->status === 'scheduled') { $stepLabels['published'] = 'Terjadwal'; }
    $future = $post->published_at && $post->published_at->isFuture() ? $post->published_at : null;
@endphp
<div class="card">
    <div class="bar" style="margin-bottom:12px"><h2 style="margin:0">Alur publikasi</h2><span class="badge s-{{ $post->status }}">{{ $post->statusLabel() }}</span></div>
    <ol class="steps" aria-label="Tahap publikasi">
        @foreach($stepLabels as $k => $label)
            @php $idx = array_search($k, $keys); $state = $post->status === 'published' || $idx < $cur ? 'done' : ($idx === $cur ? 'cur' : ''); @endphp
            <li class="{{ $state }}"><i></i>{{ $label }}</li>
        @endforeach
    </ol>

    @if($post->status === 'draft' && $post->review_note)
        <div class="note"><b>Dikembalikan dengan catatan:</b><br>{{ $post->review_note }}</div>
    @endif

    <dl class="meta">
        <div><dt>Penulis</dt><dd>{{ $post->author?->name ?? '—' }}</dd></div>
        @if($post->submitted_at)<div><dt>Diajukan</dt><dd>{{ $post->submitted_at->translatedFormat('j M Y H:i') }}</dd></div>@endif
        @if($post->checked_at)<div><dt>Diperiksa oleh</dt><dd>{{ $post->checker?->name ?? '—' }} <small class="muted">· {{ $post->checked_at->translatedFormat('j M H:i') }}</small></dd></div>@endif
        @if($post->approved_at)<div><dt>Disetujui oleh</dt><dd>{{ $post->approver?->name ?? '—' }} <small class="muted">· {{ $post->approved_at->translatedFormat('j M H:i') }}</small></dd></div>@endif
        @if($post->published_at && in_array($post->status, ['published', 'scheduled']))<div><dt>{{ $post->status === 'scheduled' ? 'Jadwal tayang' : 'Tayang sejak' }}</dt><dd>{{ $post->published_at->translatedFormat('j M Y H:i') }}</dd></div>@endif
    </dl>

    @if($actions)
    <div class="acts">
        @foreach($actions as $a)
            @php [$label, $cls] = \App\Support\PostWorkflow::ACTIONS[$a]; $url = route('admin.posts.transition', [$post, $a]); @endphp
            @if($a === 'return')
            <details class="ab"><summary>{{ $label }}</summary>
                <form method="POST" action="{{ $url }}">@csrf
                    <label for="note-{{ $a }}">Catatan untuk penulis <small>(wajib)</small></label>
                    <textarea id="note-{{ $a }}" name="note" required style="min-height:80px" placeholder="Apa yang perlu diperbaiki?"></textarea>
                    <p style="margin:10px 0 0"><button class="btn del" type="submit">Kembalikan</button></p>
                </form>
            </details>
            @elseif($a === 'publish')
            <details class="ab" open><summary>{{ $label }} atau jadwalkan</summary>
                <form method="POST" action="{{ $url }}">@csrf
                    <label for="publish_at">Jadwal tayang <small>(kosongkan untuk tayang sekarang; isi tanggal &amp; jam untuk dijadwalkan otomatis)</small></label>
                    <input id="publish_at" type="datetime-local" name="publish_at" value="{{ $future?->format('Y-m-d\TH:i') }}">
                    <p style="margin:10px 0 0"><button class="btn gold" type="submit">Terbitkan / jadwalkan</button></p>
                </form>
            </details>
            @elseif($a === 'unpublish')
            <form method="POST" action="{{ $url }}" data-confirm="Tarik tulisan ini dari website?">@csrf<button class="btn sec" type="submit">{{ $label }}</button></form>
            @else
            <form method="POST" action="{{ $url }}">@csrf<button class="{{ $cls }}" type="submit">{{ $label }}</button></form>
            @endif
        @endforeach
    </div>
    @else
    <p class="help" style="margin:0">@switch($post->status)
        @case('draft')Menunggu penulis mengajukan tulisan ini untuk diperiksa.@break
        @case('submitted')Menunggu Operator atau Admin memeriksa tulisan ini.@break
        @case('checked')Menunggu persetujuan Kepala Sekolah.@break
        @case('approved')Sudah disetujui, menunggu diterbitkan.@break
        @default Tidak ada tindakan yang tersedia untuk peran Anda pada tahap ini.
    @endswitch</p>
    @endif
</div>

<div class="card">
    <h2>Riwayat tulisan ini</h2>
    @if($history->isNotEmpty())
    <ul class="log">
        @foreach($history as $h)<li>{{ $h->description }}<small>{{ $h->user_name }} · {{ $h->created_at->translatedFormat('j M Y H:i') }}</small></li>@endforeach
    </ul>
    @else<p class="empty">Belum ada riwayat.</p>@endif
</div>

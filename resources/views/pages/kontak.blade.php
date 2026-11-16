@extends('layouts.site')
@section('title', 'Kontak — '.site('school_name'))

@section('content')
@include('partials.pagehero', ['crumbs' => ['Kontak' => null], 'eyebrow' => 'Kontak', 'title' => 'Hubungi Kami', 'subtitle' => 'Silakan datang langsung atau hubungi sekolah pada jam kerja.'])
<section class="sec"><div class="wrap kgrid">
    <div class="klist">
        @if(site('address'))<div class="kc"><svg class="ic"><use href="#i-pin"/></svg><div><b>Alamat</b><p>{!! nl2br(e(site('address'))) !!}</p></div></div>@endif
        @if(site('phone'))<a class="kc" href="tel:{{ preg_replace('/[^\d+]/', '', site('phone')) }}"><svg class="ic"><use href="#i-phone"/></svg><div><b>Telepon</b><p>{{ site('phone') }}</p></div></a>@endif
        @if(wa_link(site('whatsapp')))<a class="kc" href="{{ wa_link(site('whatsapp')) }}" target="_blank" rel="noopener"><svg class="ic"><use href="#i-chat"/></svg><div><b>WhatsApp</b><p>{{ site('whatsapp') }}</p></div></a>@endif
        @if(site('email'))<a class="kc" href="mailto:{{ site('email') }}"><svg class="ic"><use href="#i-mail"/></svg><div><b>Email</b><p>{{ site('email') }}</p></div></a>@endif
        @if(site('spmb_url'))<a class="btn primary" href="{{ site('spmb_url') }}" target="_blank" rel="noopener">{{ site('spmb_button') ?: 'Daftar Sekarang' }}<svg class="ic ne"><use href="#i-ne"/></svg></a>@endif
    </div>
    @if(site('address'))
    <div class="map"><iframe title="Peta lokasi sekolah" src="https://www.google.com/maps?q={{ urlencode(site('school_name').' '.site('address')) }}&amp;output=embed" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe></div>
    @endif
</div></section>
@endsection

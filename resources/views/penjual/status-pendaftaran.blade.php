@php
    // Data contoh untuk tampilan. Nanti diganti data pendaftaran dari database.
    $loginUrl    = Route::has('login') ? route('login') : '#';
    $registerUrl = route('daftar.penjual');
    $states = [
        'terkirim' => ['tone' => 'info', 'badge' => 'Pendaftaran terkirim', 'icon' => '✓',
            'title' => 'Terima kasih, pengajuanmu sudah kami terima',
            'text' => 'Tim pengelola akan memeriksa data dalam 2-3 hari kerja.',
            'steps' => null, 'cta' => ['Lihat Status Pendaftaran', route('penjual.status-pendaftaran', 'menunggu'), 'primary']],
        'menunggu' => ['tone' => 'info', 'badge' => 'Menunggu', 'icon' => '✓',
            'title' => 'Pengajuan sedang diperiksa',
            'text' => 'Dokumenmu masuk antrean verifikasi. Kami akan mengirim kabar melalui email.',
            'steps' => ['done', 'wait', 'wait'], 'cta' => ['Kembali ke Beranda', $loginUrl, 'primary']],
        'revisi' => ['tone' => 'warn', 'badge' => 'Perlu Revisi', 'icon' => '✓',
            'title' => 'Ada dokumen yang perlu diperbaiki',
            'text' => 'Catatan admin: Foto KTP kurang jelas dan nomor NIB tidak terbaca.',
            'steps' => ['done', 'wait', 'wait'], 'cta' => ['Perbaiki dokumen', $registerUrl, 'primary']],
        'ditolak' => ['tone' => 'danger', 'badge' => 'Ditolak', 'icon' => '!',
            'title' => 'Pengajuan belum dapat disetujui',
            'text' => 'Alasan: Jenis usaha belum sesuai dengan kurasi tenant Foodcourt UNESA.',
            'steps' => ['done', 'wait', 'wait'], 'cta' => ['Ajukan ulang', $registerUrl, 'ghost']],
        'disetujui' => ['tone' => 'success', 'badge' => 'Disetujui', 'icon' => '✓',
            'title' => 'Selamat, stand kamu disetujui!',
            'text' => 'Akun tenant sudah aktif. Silakan masuk dan lengkapi menu pertama.',
            'steps' => ['done', 'done', 'done'], 'cta' => ['Masuk ke Dashboard', $loginUrl, 'primary']],
    ];
    $tones = [
        'info' => 'bg-pill text-pill-text', 'warn' => 'bg-warn-bg text-warn',
        'danger' => 'bg-danger-bg text-danger', 'success' => 'bg-success-bg text-success',
    ];
    $s = $states[$status];
    $toneCls = $tones[$s['tone']];
    $labels = [
        ['Pengajuan dikirim', '12 Jun, 09:41'],
        ['Verifikasi admin', $status === 'menunggu' ? 'Sedang berlangsung' : '14 Jun, 15:20'],
        ['Keputusan', $s['badge']],
    ];
@endphp
<x-layouts.tamu title="Status Pendaftaran" width="max-w-sm">
    <div class="text-center">
        <div class="mx-auto grid size-14 place-items-center rounded-full text-2xl font-bold {{ $toneCls }}">{{ $s['icon'] }}</div>
        <span class="mt-4 inline-block rounded-full px-3 py-1 text-[11px] font-bold {{ $toneCls }}">{{ $s['badge'] }}</span>
        <h1 class="mt-3 text-2xl font-medium leading-snug text-navy">{{ $s['title'] }}</h1>
        <p class="mt-3 text-xs leading-relaxed text-muted">{{ $s['text'] }}</p>
    </div>

    @if ($s['steps'])
        <ol class="mx-auto mt-6 max-w-[220px]">
            @foreach ($s['steps'] as $i => $state)
                <li class="relative flex gap-3 pb-5 last:pb-0">
                    @unless ($loop->last)<span class="absolute left-[5px] top-3 h-full w-px bg-line"></span>@endunless
                    <span class="relative mt-1 size-3 shrink-0 rounded-full {{ $state === 'done' ? 'bg-success' : 'bg-line' }}"></span>
                    <div class="text-left">
                        <p class="text-xs font-bold">{{ $labels[$i][0] }}</p>
                        <p class="text-[11px] text-muted">{{ $labels[$i][1] }}</p>
                    </div>
                </li>
            @endforeach
        </ol>
    @endif

    <a href="{{ $s['cta'][1] }}" class="{{ $s['cta'][2] === 'ghost' ? 'btn-ghost' : 'btn-primary' }} mt-6 w-full">{{ $s['cta'][0] }}</a>
    <p class="mt-4 text-center text-[11px] text-muted">Nomor pengajuan: <b class="text-ink">REG-2025-0182</b></p>

    {{-- Pratinjau 5 status (hapus saat backend jadi) --}}
    <div class="mt-5 flex flex-wrap justify-center gap-1.5 border-t border-line pt-4">
        @foreach (array_keys($states) as $key)
            <a href="{{ route('penjual.status-pendaftaran', $key) }}"
               class="rounded-full px-2.5 py-1 text-[10px] font-bold {{ $key === $status ? 'bg-navy text-white' : 'bg-surface text-muted hover:text-navy' }}">{{ $key }}</a>
        @endforeach
    </div>
</x-layouts.tamu>
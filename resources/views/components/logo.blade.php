@props(['href' => '/'])
<a href="{{ $href }}" {{ $attributes->class('inline-flex items-center gap-2.5') }}>
    <span class="relative grid size-10 place-items-center rounded-xl bg-navy text-lg font-extrabold text-brand">
        U
        <span class="absolute inset-x-0 bottom-0 h-1 rounded-b-xl bg-brand"></span>
    </span>
    <span class="leading-none">
        <span class="block text-[17px] font-extrabold text-navy">Foodcourt</span>
        <span class="mt-0.5 block text-[9px] font-bold tracking-[0.25em] text-navy">UNESA</span>
    </span>
</a>
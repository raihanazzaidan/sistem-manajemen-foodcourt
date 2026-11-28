@php
    // Aman walau route halaman lain belum dibuat anggota lain.
    $forgotUrl   = Route::has('password.request') ? route('password.request') : '#';
    $registerUrl = Route::has('daftar.penjual') ? route('daftar.penjual') : '#';
@endphp
<x-layouts.tamu title="Masuk">
    <div x-data="formMasuk({
            demo: true,
            email: @js(old('email', '')),
            role: @js(old('role', 'mahasiswa')),
            serverError: @js($errors->first('email')),
        })">

        <p class="mb-5 rounded-full bg-pill py-2 text-center text-[11px] font-extrabold tracking-wide text-pill-text">
            PORTAL FOODCOURT UNESA
        </p>

        <h1 class="text-[28px] font-medium leading-tight text-navy">Selamat datang kembali</h1>
        <p class="mt-2 text-sm text-muted">Masuk untuk melanjutkan aktivitasmu.</p>

        <div class="mt-6 grid grid-cols-3 gap-1 rounded-xl bg-surface p-1" role="tablist" aria-label="Pilih peran">
            <template x-for="(r, key) in roles" :key="key">
                <button type="button" role="tab" :aria-selected="role === key" @click="setRole(key)"
                        class="rounded-lg px-2 py-2.5 text-xs font-semibold transition"
                        :class="role === key ? 'bg-white text-navy shadow-sm' : 'text-ink/70 hover:text-navy'"
                        x-text="r.label"></button>
            </template>
        </div>

        <form x-ref="form" method="POST" action="{{ url('/masuk') }}" class="mt-5 space-y-4"
              @submit.prevent="submit" novalidate>
            @csrf
            <input type="hidden" name="role" :value="role">

            <div>
                <label for="email" class="field-label">Email universitas</label>
                <input id="email" name="email" type="email" x-model="email" :placeholder="current.placeholder"
                       autocomplete="username" class="field-input" :class="{ 'is-invalid': errors.email }"
                       :aria-invalid="!!errors.email">
                <p class="field-error" x-show="errors.email" x-text="errors.email" x-cloak role="alert"></p>
            </div>

            <div>
                <label for="password" class="field-label">Password</label>
                <div class="relative">
                    <input id="password" name="password" :type="showPassword ? 'text' : 'password'" x-model="password"
                           placeholder="••••••••" autocomplete="current-password"
                           class="field-input pr-28" :class="{ 'is-invalid': errors.password }"
                           :aria-invalid="!!errors.password">
                    <button type="button" @click="showPassword = !showPassword"
                            class="absolute inset-y-0 right-4 text-xs font-bold text-navy hover:underline"
                            x-text="showPassword ? 'Sembunyikan' : 'Tampilkan'"></button>
                </div>
                <p class="field-error" x-show="errors.password" x-text="errors.password" x-cloak role="alert"></p>
            </div>

            <div class="flex items-center justify-between text-xs">
                <label class="flex cursor-pointer items-center gap-2 text-ink/80">
                    <input type="checkbox" name="remember" x-model="remember" class="size-4 rounded border-line accent-navy">
                    Ingat saya
                </label>
                <a href="{{ $forgotUrl }}" class="font-bold text-navy hover:underline">Lupa password?</a>
            </div>

            <button type="submit" class="btn-primary" :disabled="locked">
                Masuk sebagai&nbsp;<span x-text="current.label"></span>
            </button>

            <p class="alert-danger" x-show="locked" x-text="lockMessage" x-cloak role="alert"></p>
            <p class="alert-success" x-show="demoMessage" x-text="demoMessage" x-cloak role="status"></p>
        </form>

        <div class="mt-6 border-t border-line pt-4 text-xs">
            <p class="font-bold text-ink">Khusus Pengelola</p>
            <p class="mt-1 leading-relaxed text-muted">
                Admin wajib menggunakan email universitas. Pemilik stand dapat masuk setelah registrasi disetujui.
            </p>
            <p class="mt-4 text-center text-muted">
                Belum punya akun?
                <a href="{{ $registerUrl }}" class="font-bold text-navy hover:underline">Daftar sekarang</a>
            </p>
        </div>
    </div>
</x-layouts.tamu>
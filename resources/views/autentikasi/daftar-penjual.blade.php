<x-layouts.pendaftaran title="Registrasi Pemilik Stand">
    <div x-data="formDaftar({ demo: true, statusUrl: '{{ route('penjual.status-pendaftaran', 'terkirim') }}' })">

        <div class="text-center">
            <p class="text-[11px] font-extrabold tracking-widest text-accent" x-text="`LANGKAH ${step} DARI 3`"></p>
            <h1 class="mt-2 text-3xl font-medium text-navy" x-text="heading.t"></h1>
            <p class="mt-2 text-sm text-muted" x-text="heading.s"></p>
        </div>

        {{-- Stepper --}}
        <ol class="mx-auto mt-6 flex max-w-xl items-center" aria-label="Langkah registrasi">
            <template x-for="(s, idx) in steps" :key="s.n">
                <li class="flex items-center" :class="idx < 2 ? 'flex-1' : ''" :aria-current="step === s.n ? 'step' : null">
                    <span class="grid size-7 shrink-0 place-items-center rounded-full text-xs font-bold transition"
                          :class="step >= s.n ? 'bg-navy text-white' : 'bg-line text-muted'" x-text="s.n"></span>
                    <span class="ml-2 hidden text-xs font-bold sm:inline" :class="step >= s.n ? 'text-ink' : 'text-muted'" x-text="s.label"></span>
                    <span x-show="idx < 2" class="mx-3 h-px flex-1 bg-line"></span>
                </li>
            </template>
        </ol>

        <form x-ref="form" method="POST" action="#" enctype="multipart/form-data" novalidate
              class="mt-8 rounded-2xl bg-white p-5 ring-1 ring-line sm:p-7" @submit.prevent="next">
            @csrf

            {{-- Langkah 1: Data pemilik --}}
            <div x-show="step === 1" class="grid gap-4 sm:grid-cols-2">
                <div>
                    <label for="owner_name" class="field-label">Nama lengkap</label>
                    <input id="owner_name" name="owner_name" x-model="form.ownerName" autocomplete="name" placeholder="Siti Rahmawati"
                           class="field-input" :class="{ 'is-invalid': errors.ownerName }">
                    <p class="field-error" x-show="errors.ownerName" x-text="errors.ownerName" x-cloak></p>
                </div>
                <div>
                    <label for="email" class="field-label">Email</label>
                    <input id="email" name="email" type="email" x-model="form.email" autocomplete="email" placeholder="siti@usahaku.id"
                           class="field-input" :class="{ 'is-invalid': errors.email }">
                    <p class="field-error" x-show="errors.email" x-text="errors.email" x-cloak></p>
                </div>
                <div>
                    <label for="phone" class="field-label">Nomor HP</label>
                    <input id="phone" name="phone" type="tel" x-model="form.phone" autocomplete="tel" placeholder="0812 3456 7890"
                           class="field-input" :class="{ 'is-invalid': errors.phone }">
                    <p class="field-error" x-show="errors.phone" x-text="errors.phone" x-cloak></p>
                </div>
                <div x-data="{ show: false }">
                    <label for="password" class="field-label">Password</label>
                    <div class="relative">
                        <input id="password" name="password" :type="show ? 'text' : 'password'" x-model="form.password"
                               autocomplete="new-password" placeholder="Minimal 8 karakter"
                               class="field-input pr-28" :class="{ 'is-invalid': errors.password }">
                        <button type="button" @click="show = !show" x-text="show ? 'Sembunyikan' : 'Tampilkan'"
                                class="absolute inset-y-0 right-4 text-xs font-bold text-navy hover:underline"></button>
                    </div>
                    <p class="field-error" x-show="errors.password" x-text="errors.password" x-cloak></p>
                </div>
                <div class="sm:col-span-2">
                    <label for="ktp_number" class="field-label">Nomor KTP</label>
                    <input id="ktp_number" name="ktp_number" inputmode="numeric" maxlength="19" x-model="form.ktp" placeholder="16 digit nomor KTP"
                           class="field-input" :class="{ 'is-invalid': errors.ktp }">
                    <p class="field-error" x-show="errors.ktp" x-text="errors.ktp" x-cloak></p>
                </div>
            </div>

            {{-- Langkah 2: Data stand --}}
            <div x-show="step === 2" x-cloak class="grid gap-4 sm:grid-cols-2">
                <div>
                    <label for="stand_name" class="field-label">Nama stand</label>
                    <input id="stand_name" name="stand_name" x-model="form.standName" placeholder="Dapur Bu Siti"
                           class="field-input" :class="{ 'is-invalid': errors.standName }">
                    <p class="field-error" x-show="errors.standName" x-text="errors.standName" x-cloak></p>
                </div>
                <div>
                    <label for="category" class="field-label">Kategori</label>
                    <select id="category" name="category" x-model="form.category" class="field-input" :class="{ 'is-invalid': errors.category }">
                        <option value="">Pilih kategori</option>
                        <template x-for="c in categories" :key="c"><option :value="c" x-text="c"></option></template>
                    </select>
                    <p class="field-error" x-show="errors.category" x-text="errors.category" x-cloak></p>
                </div>
                <div>
                    <label for="description" class="field-label">Deskripsi singkat</label>
                    <textarea id="description" name="description" rows="3" x-model="form.description"
                              placeholder="Masakan rumahan halal, hangat, dan terjangkau."
                              class="field-input" :class="{ 'is-invalid': errors.description }"></textarea>
                    <p class="field-error" x-show="errors.description" x-text="errors.description" x-cloak></p>
                </div>
                <div>
                    <span class="field-label">Logo stand</span>
                    <div class="flex items-center gap-3 rounded-xl border border-line p-3">
                        <span class="grid size-11 shrink-0 place-items-center rounded-lg bg-pill text-lg font-bold text-navy"
                              x-text="(form.standName || 'D').charAt(0).toUpperCase()"></span>
                        <div class="min-w-0 flex-1">
                            <p class="truncate text-xs font-bold" x-text="files.logo ? files.logo.name : 'Logo stand'"></p>
                            <p class="text-[11px] text-muted" x-text="files.logo ? files.logo.size : 'PNG/JPG, maks. 2MB'"></p>
                        </div>
                        <label class="cursor-pointer text-xs font-bold text-navy hover:underline">
                            <span x-text="files.logo ? 'Ganti' : 'Pilih Logo'"></span>
                            <input type="file" name="logo" accept="image/png,image/jpeg" class="sr-only" @change="pick('logo', $event)">
                        </label>
                    </div>
                    <p class="field-error" x-show="errors.logoFile" x-text="errors.logoFile" x-cloak></p>
                </div>
            </div>

            {{-- Langkah 3: Dokumen --}}
            <div x-show="step === 3" x-cloak>
                <div class="grid gap-4 sm:grid-cols-2">
                    @foreach ([['ktp', 'KTP Pemilik', 'ktp_file', 'ktpFile'], ['nib', 'NIB / Izin Usaha', 'nib_file', 'nibFile']] as [$key, $label, $name, $err])
                        <div>
                            <div class="flex items-center gap-3 rounded-xl border border-line p-4"
                                 :class="{ 'border-danger/60 bg-danger-bg': errors.{{ $err }} }">
                                <span class="grid size-12 shrink-0 place-items-center rounded-lg bg-pill text-xs font-extrabold text-navy">PDF</span>
                                <div class="min-w-0 flex-1">
                                    <p class="text-xs font-bold">{{ $label }}</p>
                                    <p class="truncate text-[11px] text-muted"
                                       x-text="files.{{ $key }} ? files.{{ $key }}.name + ' · ' + files.{{ $key }}.size : 'Belum ada file (PDF/JPG, maks. 2MB)'"></p>
                                    <p class="text-[11px] font-semibold text-success" x-show="files.{{ $key }}" x-cloak>Siap diunggah</p>
                                </div>
                                <label class="cursor-pointer text-xs font-bold text-navy hover:underline">
                                    <span x-text="files.{{ $key }} ? 'Ganti' : 'Pilih'"></span>
                                    <input type="file" name="{{ $name }}" accept=".pdf,image/png,image/jpeg" class="sr-only"
                                           @change="pick('{{ $key }}', $event)">
                                </label>
                            </div>
                            <p class="field-error" x-show="errors.{{ $err }}" x-text="errors.{{ $err }}" x-cloak></p>
                        </div>
                    @endforeach
                </div>

                <label class="mt-4 flex items-start gap-2.5 text-xs text-ink/80">
                    <input type="checkbox" name="agree" x-model="form.agree" class="mt-0.5 size-4 rounded accent-navy">
                    Saya menyetujui syarat, kebijakan data, dan tata tertib Foodcourt UNESA.
                </label>
                <p class="field-error" x-show="errors.agree" x-text="errors.agree" x-cloak></p>
            </div>

            <div class="mt-7 flex items-center justify-between">
                <button type="button" @click="prev" :class="{ 'invisible': step === 1 }"
                        class="px-2 py-2 text-sm font-bold text-navy hover:underline">Kembali</button>
                <button type="submit" class="btn-primary !w-auto px-7" x-text="step < 3 ? 'Lanjutkan' : 'Kirim Pendaftaran'"></button>
            </div>
        </form>
    </div>
</x-layouts.pendaftaran>
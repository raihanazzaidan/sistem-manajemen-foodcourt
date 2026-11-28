import Alpine from 'alpinejs';

const EMAIL_RE = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
const MAX_FILE = 2 * 1024 * 1024; // 2 MB

/**
 * Registrasi pemilik stand (3 langkah).
 * config: { demo: true, statusUrl: '/status-pendaftaran/terkirim' }
 */
Alpine.data('formDaftar', (config = {}) => ({
    demo: config.demo ?? true,
    statusUrl: config.statusUrl || '#',
    step: 1,
    form: { ownerName: '', email: '', phone: '', password: '', ktp: '', standName: '', category: '', description: '', agree: false },
    files: { logo: null, ktp: null, nib: null },
    errors: {},
    categories: ['Makanan Indonesia', 'Makanan Berat', 'Bakso & Mi', 'Minuman', 'Snack & Camilan', 'Dessert'],
    steps: [
        { n: 1, label: 'Data Pemilik' },
        { n: 2, label: 'Data Stand' },
        { n: 3, label: 'Dokumen' },
    ],
    headings: [
        { t: 'Data Pemilik', s: 'Lengkapi identitas penanggung jawab stand.' },
        { t: 'Data Stand', s: 'Ceritakan sedikit tentang usaha yang akan bergabung.' },
        { t: 'Dokumen', s: 'Unggah dokumen jelas dan masih berlaku.' },
    ],
    get heading() { return this.headings[this.step - 1]; },

    fileSize(f) {
        return f.size > 1048576 ? (f.size / 1048576).toFixed(1) + ' MB' : Math.max(1, Math.round(f.size / 1024)) + ' KB';
    },
    pick(key, event) {
        const file = event.target.files[0];
        if (!file) return;
        const errKey = key + 'File';
        if (file.size > MAX_FILE) {
            this.errors[errKey] = 'Ukuran file maksimal 2 MB.';
            this.files[key] = null;
            event.target.value = '';
            return;
        }
        delete this.errors[errKey];
        this.files[key] = { name: file.name, size: this.fileSize(file) };
    },

    validate() {
        const e = {}, f = this.form;
        if (this.step === 1) {
            if (f.ownerName.trim().length < 3) e.ownerName = 'Nama lengkap wajib diisi.';
            if (!EMAIL_RE.test(f.email.trim())) e.email = 'Isi alamat email yang valid.';
            if (!/^(\+62|62|0)8\d{7,12}$/.test(f.phone.replace(/[\s-]/g, ''))) e.phone = 'Nomor HP tidak valid.';
            if (f.password.length < 8) e.password = 'Password minimal 8 karakter.';
            if (!/^\d{16}$/.test(f.ktp.replace(/\s/g, ''))) e.ktp = 'Nomor KTP harus 16 digit.';
        } else if (this.step === 2) {
            if (f.standName.trim().length < 3) e.standName = 'Nama stand wajib diisi.';
            if (!f.category) e.category = 'Pilih kategori stand.';
            if (f.description.trim().length < 10) e.description = 'Deskripsi minimal 10 karakter.';
        } else {
            if (!this.files.ktp) e.ktpFile = 'Unggah KTP pemilik.';
            if (!this.files.nib) e.nibFile = 'Unggah NIB / izin usaha.';
            if (!f.agree) e.agree = 'Kamu perlu menyetujui syarat dan ketentuan.';
        }
        const keep = {};
        ['logoFile', 'ktpFile', 'nibFile'].forEach((k) => { if (this.errors[k] && !e[k]) keep[k] = this.errors[k]; });
        this.errors = { ...keep, ...e };
        return Object.keys(e).length === 0;
    },

    next() {
        if (!this.validate()) return;
        if (this.step < 3) {
            this.step++;
            window.scrollTo({ top: 0, behavior: 'smooth' });
            return;
        }
        if (this.demo) window.location.href = this.statusUrl;
        else this.$refs.form.submit();
    },
    prev() { if (this.step > 1) this.step--; },
}));
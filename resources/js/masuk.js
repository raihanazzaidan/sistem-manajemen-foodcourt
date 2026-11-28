import Alpine from 'alpinejs';

const EMAIL_RE = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

// Nilai key sama dengan kolom users.role di database (admin | penjual | mahasiswa).
const ROLES = {
    mahasiswa: {
        label: 'Mahasiswa',
        placeholder: 'nama@mhs.unesa.ac.id',
        domains: ['@mhs.unesa.ac.id'],
        domainError: 'Gunakan email dengan domain @mhs.unesa.ac.id',
    },
    admin: {
        label: 'Admin',
        placeholder: 'pengelola@unesa.ac.id',
        // '@foodcourt.test' hanya untuk akun seeder saat development. Hapus sebelum dikumpulkan.
        domains: ['@unesa.ac.id', '@foodcourt.test'],
        domainError: 'Khusus pengelola dengan email universitas',
    },
    penjual: {
        label: 'Pemilik Stand',
        placeholder: 'pemilik@email.com',
        domains: null,
        domainError: '',
    },
};

Alpine.data('formMasuk', (config = {}) => ({
    roles: ROLES,
    role: config.role || 'mahasiswa',
    email: config.email || '',
    password: '',
    remember: false,
    showPassword: false,
    errors: { email: config.serverError || '', password: '' },

    // true = hanya simulasi. Ubah ke false di Blade saat route login backend sudah ada.
    demo: config.demo ?? true,
    demoMessage: '',

    attempts: 0,
    lockSeconds: 0,

    get current() { return this.roles[this.role]; },
    get locked() { return this.lockSeconds > 0; },
    get lockMessage() {
        return `Terlalu banyak percobaan, coba lagi dalam ${Math.ceil(this.lockSeconds / 60)} menit.`;
    },

    setRole(key) {
        this.role = key;
        this.errors = { email: '', password: '' };
        this.demoMessage = '';
    },

    validate() {
        this.errors = { email: '', password: '' };
        const email = this.email.trim().toLowerCase();

        if (!email) this.errors.email = 'Email wajib diisi.';
        else if (!EMAIL_RE.test(email)) this.errors.email = 'Format email tidak valid.';
        else if (this.current.domains && !this.current.domains.some((d) => email.endsWith(d))) {
            this.errors.email = this.current.domainError;
        }

        if (!this.password) this.errors.password = 'Password wajib diisi.';
        else if (this.password.length < 6) this.errors.password = 'Password minimal 6 karakter.';

        return !this.errors.email && !this.errors.password;
    },

    submit() {
        if (this.locked) return;

        if (!this.validate()) {
            if (++this.attempts >= 5) this.lock(180);
            return;
        }

        if (this.demo) {
            this.demoMessage = `Validasi berhasil sebagai ${this.current.label} (mode demo, backend belum tersambung).`;
            return;
        }
        this.$refs.form.submit(); // kirim ke backend (POST + CSRF)
    },

    lock(seconds) {
        this.lockSeconds = seconds;
        const timer = setInterval(() => {
            if (--this.lockSeconds <= 0) { clearInterval(timer); this.attempts = 0; }
        }, 1000);
    },
}));
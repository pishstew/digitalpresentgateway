/**
 * SIJA Presensi — theme-mode.js
 *
 * KONVENSI PILIHAN A:
 *   Toggle OFF (abu gelap, icon 🌙) = Dark mode  ← DEFAULT
 *   Toggle ON  (kuning, icon ☀️)   = Light mode
 *
 * Sistem: body.light-mode (bukan html.dark)
 * Checkbox checked = light mode aktif
 */
(function () {
    var STORAGE_KEY = 'sija-theme';
    var body        = document.body;

    function getSaved() { return localStorage.getItem(STORAGE_KEY); }
    function setSaved(t){ localStorage.setItem(STORAGE_KEY, t); }

    function applyTheme(theme) {
        setSaved(theme);
        var isLight = (theme === 'light');

        // Toggle class di <body> — dipakai seluruh CSS (theme-mode.css & welcome inline)
        if (isLight) {
            body.classList.add('light-mode');
        } else {
            body.classList.remove('light-mode');
        }

        // Sync semua checkbox: checked = light (ON = terang, sesuai Pilihan A)
        document.querySelectorAll('.dpg-theme-checkbox').forEach(function (cb) {
            cb.checked = isLight;
        });

        // Sync label teks
        document.querySelectorAll('.theme-label').forEach(function (el) {
            el.textContent = isLight ? 'Light' : 'Dark';
        });
    }

    // Inisialisasi — default: dark
    applyTheme(getSaved() || 'dark');

    // Event listener untuk semua checkbox toggle di halaman
    document.addEventListener('change', function (e) {
        if (e.target && e.target.classList.contains('dpg-theme-checkbox')) {
            // checked = ON = Light mode (Pilihan A)
            applyTheme(e.target.checked ? 'light' : 'dark');
        }
    });
})();
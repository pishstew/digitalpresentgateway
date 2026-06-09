(function () {
    var STORAGE_KEY = 'sija-theme';
    var body = document.body;

    function getSaved() { return localStorage.getItem(STORAGE_KEY); }
    function setSaved(t) { localStorage.setItem(STORAGE_KEY, t); }

    function applyTheme(theme) {
        setSaved(theme);
        var isLight = (theme === 'light');

        if (isLight) {
            body.classList.add('light-mode');
        } else {
            body.classList.remove('light-mode');
        }

        document.querySelectorAll('.dpg-theme-checkbox').forEach(function (cb) {
            cb.checked = isLight;
        });

        document.querySelectorAll('.theme-label').forEach(function (el) {
            el.textContent = isLight ? 'Light' : 'Dark';
        });
    }

    applyTheme(getSaved() || 'dark');

    document.addEventListener('change', function (e) {
        if (e.target && e.target.classList.contains('dpg-theme-checkbox')) {
            applyTheme(e.target.checked ? 'light' : 'dark');
        }
    });
})();
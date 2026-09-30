<button type="button" class="theme-toggle" id="themeToggle" title="Cambiar modo claro/oscuro" aria-label="Cambiar modo claro/oscuro">🌙</button>
<script>
    (function () {
        var btn = document.getElementById('themeToggle');
        var root = document.documentElement;
        if (!btn) return;

        function render() {
            btn.textContent = root.getAttribute('data-bs-theme') === 'dark' ? '☀️' : '🌙';
        }

        btn.addEventListener('click', function () {
            var next = root.getAttribute('data-bs-theme') === 'dark' ? 'light' : 'dark';
            root.setAttribute('data-bs-theme', next);
            localStorage.setItem('theme', next);
            render();
        });

        render();
    })();
</script>

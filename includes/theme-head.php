<script>
    (function () {
        var t = localStorage.getItem('theme') ||
            (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
        document.documentElement.setAttribute('data-bs-theme', t);
    })();
</script>
<style>
    .theme-toggle {
        position: fixed;
        top: .75rem;
        right: .75rem;
        border: none;
        background: transparent;
        font-size: 1.15rem;
        line-height: 1;
        padding: .35rem .5rem;
        border-radius: .5rem;
        cursor: pointer;
        z-index: 1000;
    }

    .theme-toggle:hover {
        background: rgba(128, 128, 128, .2);
    }

    .logo-dark {
        display: none;
    }

    [data-bs-theme="dark"] .logo-light {
        display: none;
    }

    [data-bs-theme="dark"] .logo-dark {
        display: inline-block;
    }

    [data-bs-theme="dark"] body.bg-light {
        background-color: #212529 !important;
    }
</style>

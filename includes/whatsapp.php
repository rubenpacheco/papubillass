<a href="https://wa.me/51916377263?text=Hola,%20estoy%20interesado%20en%20el%20software"
   class="whatsapp-bubble" target="_blank">
    <div class="whatsapp-icon">
        <img src="https://img.icons8.com/color/48/000000/whatsapp--v1.png" alt="WhatsApp">
    </div>
    <div class="whatsapp-message">
        💬 ¿Adquiere tu Sistema o software?
    </div>
</a>

<style>
    .whatsapp-bubble {
        position: fixed;
        bottom: 25px;
        right: 20px;
        display: flex;
        align-items: center;
        background-color: #ffffff;
        border-radius: 30px;
        padding: 6px 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
        text-decoration: none;
        z-index: 9999;
        animation: floatIn 0.4s ease-in-out;
        cursor: grab;
        touch-action: none;
        user-select: none;
    }

    .whatsapp-bubble.dragging {
        cursor: grabbing;
        animation: none;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
    }

    .whatsapp-icon img {
        width: 36px;
        height: 36px;
    }

    .whatsapp-message {
        margin-left: 10px;
        font-size: 14px;
        font-weight: 500;
        color: #075e54;
        white-space: nowrap;
    }

    [data-bs-theme="dark"] .whatsapp-bubble {
        background-color: #343a40;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
    }

    [data-bs-theme="dark"] .whatsapp-message {
        color: #4ade80;
    }

    @keyframes floatIn {
        from {
            transform: translateY(40px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }
</style>

<script>
(function () {
    const bubble = document.querySelector('.whatsapp-bubble');
    if (!bubble) return;

    const KEY = 'waBubblePos';
    let dragging = false, moved = false, startX = 0, startY = 0, startL = 0, startT = 0;

    function clamp(left, top) {
        const r = bubble.getBoundingClientRect();
        return {
            left: Math.min(Math.max(left, 0), Math.max(window.innerWidth - r.width, 0)),
            top: Math.min(Math.max(top, 0), Math.max(window.innerHeight - r.height, 0))
        };
    }

    function apply(left, top) {
        const p = clamp(left, top);
        bubble.style.left = p.left + 'px';
        bubble.style.top = p.top + 'px';
        bubble.style.right = 'auto';
        bubble.style.bottom = 'auto';
    }

    try {
        const saved = JSON.parse(localStorage.getItem(KEY) || 'null');
        if (saved && typeof saved.left === 'number' && typeof saved.top === 'number') {
            apply(saved.left, saved.top);
        }
    } catch (e) {}

    window.addEventListener('resize', function () {
        const r = bubble.getBoundingClientRect();
        if (bubble.style.left) apply(r.left, r.top);
    });

    bubble.addEventListener('pointerdown', function (e) {
        if (e.button !== undefined && e.button !== 0) return;
        const r = bubble.getBoundingClientRect();
        dragging = true; moved = false;
        startX = e.clientX; startY = e.clientY;
        startL = r.left; startT = r.top;
        bubble.classList.add('dragging');
        try { bubble.setPointerCapture(e.pointerId); } catch (err) {}
    });

    bubble.addEventListener('pointermove', function (e) {
        if (!dragging) return;
        const dx = e.clientX - startX, dy = e.clientY - startY;
        if (!moved && Math.sqrt(dx * dx + dy * dy) < 6) return;
        moved = true;
        apply(startL + dx, startT + dy);
    });

    function endDrag(e) {
        if (!dragging) return;
        dragging = false;
        bubble.classList.remove('dragging');
        if (moved) {
            const r = bubble.getBoundingClientRect();
            try { localStorage.setItem(KEY, JSON.stringify({ left: r.left, top: r.top })); } catch (err) {}
            if (e && e.preventDefault) e.preventDefault();
        }
    }

    bubble.addEventListener('pointerup', endDrag);
    bubble.addEventListener('pointercancel', function () {
        dragging = false;
        bubble.classList.remove('dragging');
    });

    bubble.addEventListener('click', function (e) {
        if (moved) {
            e.preventDefault();
            e.stopPropagation();
            moved = false;
        }
    });
})();
</script>

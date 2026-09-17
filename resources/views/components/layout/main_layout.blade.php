<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Filedesk — Download software you can trust</title>

<script src="https://cdn.tailwindcss.com"></script>
<script>
  tailwind.config = {
    darkMode: 'class',
    theme: {
      extend: {
        fontFamily: {
          sans: ['Inter', 'sans-serif'],
          mono: ['JetBrains Mono', 'monospace'],
        },
        colors: {
          ink: '#0B0D12',
          sub: '#5B6472',
          faint: '#8A93A3',
          line: '#E7E9ED',
          surface: '#F7F8FA',
          brand: {
            DEFAULT: '#4F46E5',
            dark: '#4338CA',
            light: '#EEF0FF',
          },
          win: { DEFAULT: '#0F7BE0', light: '#EAF4FF', dark: '#0B5FB3' },
          mac: { DEFAULT: '#171821', light: '#F1F1F3', dark: '#26272E' },
          android: { DEFAULT: '#2FB170', light: '#E9FBF1', dark: '#1F8F58' },
          /* dark-theme surfaces, kept separate from platform brand colors */
          dbg: '#0A0B0F',
          dsurface: '#111318',
          dcard: '#15171E',
          dline: 'rgba(255,255,255,0.09)',
          dtext: '#E7E9EE',
          dsub: '#9BA3B4',
        },
        boxShadow: {
          card: '0 1px 2px rgba(15,17,23,0.04), 0 1px 1px rgba(15,17,23,0.03)',
          cardHover: '0 16px 32px -12px rgba(15,17,23,0.14), 0 4px 12px -4px rgba(15,17,23,0.08)',
          nav: '0 1px 0 rgba(15,17,23,0.06)',
        },
      },
    },
  };
</script>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">

<style>
  html { scroll-behavior: smooth; }
  body { font-family: 'Inter', sans-serif; color: #0B0D12; background: #FFFFFF; transition: background-color .35s ease, color .35s ease; }
  html.dark body { color: #E7E9EE; background: #0A0B0F; }
  .font-mono { font-family: 'JetBrains Mono', monospace; }

  ::selection { background: #4F46E5; color: #fff; }

  ::-webkit-scrollbar { height: 8px; width: 8px; }
  ::-webkit-scrollbar-thumb { background: #D9DCE3; border-radius: 8px; }
  ::-webkit-scrollbar-track { background: transparent; }

  .no-scrollbar::-webkit-scrollbar { display: none; }
  .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

  /* ============ Cards ============ */
  .app-row {
    position: relative;
    transition: border-color .25s ease, box-shadow .35s cubic-bezier(.16,1,.3,1), background-color .25s ease, transform .35s cubic-bezier(.16,1,.3,1);
  }
  .app-row:hover {
    transform: translateY(-3px);
    box-shadow: 0 20px 40px -16px rgba(15,17,23,0.18), 0 6px 16px -6px rgba(15,17,23,0.08);
  }
  .app-row:active { transform: translateY(-1px) scale(.995); }

  .app-row.glow-win:hover { border-color: #9FD1F7; }
  .app-row.glow-mac:hover { border-color: #C7C9D1; }
  .app-row.glow-android:hover { border-color: #9DECC2; }

  /* left accent bar that grows in on hover, ties card to its platform color */
  .app-row::before {
    content: '';
    position: absolute;
    left: 0; top: 14px; bottom: 14px;
    width: 3px;
    border-radius: 0 3px 3px 0;
    background: currentColor;
    opacity: 0;
    transform: scaleY(.4);
    transform-origin: center;
    transition: opacity .25s ease, transform .3s cubic-bezier(.16,1,.3,1);
  }
  .app-row.glow-win::before { color: #0F7BE0; }
  .app-row.glow-mac::before { color: #171821; }
  .app-row.glow-android::before { color: #2FB170; }
  .app-row:hover::before { opacity: 1; transform: scaleY(1); }

  .icon-tile { transition: transform .35s cubic-bezier(.16,1,.3,1), box-shadow .35s ease; }
  .app-row:hover .icon-tile { transform: scale(1.06) rotate(-2deg); }

  /* ============ Buttons (with real press feedback) ============ */
  .dl-btn {
    transition: background-color .2s ease, color .2s ease, transform .15s ease, box-shadow .2s ease, border-color .2s ease;
    will-change: transform;
  }
  .dl-btn:hover { transform: translateY(-1px); }
  .dl-btn:active { transform: translateY(0) scale(.94); transition-duration: .08s; }

  .dl-win:hover { background:#0F7BE0; color:#fff; box-shadow: 0 8px 18px -8px rgba(15,123,224,0.55); }
  .dl-win:active { background:#0B5FB3; box-shadow: 0 2px 8px -2px rgba(11,95,179,0.6); }

  .dl-mac:hover { background:#171821; color:#fff; box-shadow: 0 8px 18px -8px rgba(23,24,33,0.4); }
  .dl-mac:active { background:#000000; box-shadow: 0 2px 8px -2px rgba(0,0,0,0.55); }

  .dl-android:hover { background:#2FB170; color:#fff; box-shadow: 0 8px 18px -8px rgba(47,177,112,0.55); }
  .dl-android:active { background:#1F8F58; box-shadow: 0 2px 8px -2px rgba(31,143,88,0.6); }

  /* generic press-state for any button/pill in the page */
  button, .cat-pill, .submit-btn { -webkit-tap-highlight-color: transparent; }
  button:active, .submit-btn:active { transform: scale(.95); }

  @keyframes fadeUp { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
  .fade-up { animation: fadeUp .6s cubic-bezier(.16,1,.3,1) both; }

  @media (prefers-reduced-motion: reduce) {
    .app-row, .icon-tile, .dl-btn, button, .cat-pill { transition: none !important; }
    .fade-up { animation: none !important; }
  }

  .glass { background: rgba(255,255,255,0.86); backdrop-filter: blur(14px) saturate(180%); -webkit-backdrop-filter: blur(14px) saturate(180%); }

  /* ============ Category nav — premium glass segmented control ============ */
  .cat-bar {
    background: linear-gradient(180deg, #14161d 0%, #0B0D12 100%);
    border-top: 1px solid rgba(255,255,255,0.06);
    border-bottom: 1px solid rgba(255,255,255,0.06);
  }
  .cat-pill {
    position: relative;
    color: rgba(255,255,255,0.5);
    transition: color .2s ease, background-color .2s ease, transform .15s ease, box-shadow .2s ease;
  }
  .cat-pill:hover {
    color: rgba(255,255,255,0.92);
    background: rgba(255,255,255,0.05);
    transform: translateY(-1px);
  }
  .cat-pill:active { transform: translateY(0) scale(.97); }
  .cat-pill.active {
    color: #ffffff;
    background: linear-gradient(180deg, rgba(255,255,255,0.10), rgba(255,255,255,0.025));
    box-shadow: inset 0 0 0 1px rgba(255,255,255,0.09), inset 0 1px 0 rgba(255,255,255,0.12);
  }
  .cat-pill.active::after {
    content: '';
    position: absolute;
    left: 16px; right: 16px; bottom: 0;
    height: 2px;
    border-radius: 2px 2px 0 0;
    background: linear-gradient(90deg, #38BDF8, #818CF8);
    box-shadow: 0 0 10px rgba(129,140,248,0.6);
  }
  .cat-icon {
    width: 26px; height: 26px;
    border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    background: rgba(255,255,255,0.06);
    transition: background-color .2s ease, color .2s ease;
  }
  .cat-pill:hover .cat-icon,
  .cat-pill.active .cat-icon { background: rgba(255,255,255,0.13); }
  .cat-pill.active .cat-icon { color: #A5B4FC; }

  .search-input:focus { box-shadow: 0 0 0 4px rgba(79,70,229,0.12); }

  .star { color: #F5A623; letter-spacing: -1px; }

  .tag-chip { transition: background-color .2s ease, color .2s ease; }

  .dot-grid {
    background-image: radial-gradient(circle, rgba(255,255,255,0.14) 1px, transparent 1px);
    background-size: 20px 20px;
  }

  /* ============ Footer links: underline + white on hover ============ */
  .footer-link {
    position: relative;
    display: inline-block;
    padding-bottom: 1px;
    background-image: linear-gradient(currentColor, currentColor);
    background-repeat: no-repeat;
    background-position: 0 100%;
    background-size: 0% 1.5px;
    transition: background-size .25s cubic-bezier(.16,1,.3,1), color .2s ease;
  }
  .footer-link:hover { background-size: 100% 1.5px; }
  .footer-social {
    transition: background-color .2s ease, color .2s ease, border-color .2s ease, transform .2s ease;
  }
  .footer-social:hover { transform: translateY(-2px); }
  .footer-social:active { transform: translateY(0) scale(.92); }

  /* ============ Section header banners: full-width, professional strip ============ */
  .section-banner {
    position: relative;
    overflow: hidden;
    isolation: isolate;
  }
  .section-banner::after {
    content: '';
    position: absolute;
    inset: 0;
    background-image: radial-gradient(circle, currentColor 1px, transparent 1px);
    background-size: 16px 16px;
    opacity: .05;
    z-index: -1;
    -webkit-mask-image: linear-gradient(to right, black, transparent 65%);
    mask-image: linear-gradient(to right, black, transparent 65%);
  }
</style>
</head>

<body class="antialiased bg-white text-ink dark:bg-dbg dark:text-dtext">

<!-- ================= NAVBAR ================= -->
<x-basic.navbar/>

{{$slot}}

<!-- ================= FOOTER ================= -->
<x-basic.footer />

<script>
  (function () {
    var btn = document.getElementById('darkModeToggle');
    var icon = document.getElementById('darkModeIcon');
    var sun = '<path d="M12 5V2.5M12 21.5V19M19 12H21.5M2.5 12H5M17.7 6.3L19.4 4.6M4.6 19.4L6.3 17.7M17.7 17.7L19.4 19.4M4.6 4.6L6.3 6.3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><circle cx="12" cy="12" r="4.5" fill="currentColor"/>';
    var moon = '<path d="M21 12.8A9 9 0 1 1 11.2 3 7 7 0 0 0 21 12.8Z" fill="currentColor"/>';
    var on = false;
    btn.addEventListener('click', function () {
      on = !on;
      // proper class-based dark mode — no filter-invert, so brand colors
      // (platform banners, buttons) stay exactly as designed instead of flipping to white/black.
      document.documentElement.classList.toggle('dark', on);
      icon.innerHTML = on ? sun : moon;
    });
  })();
</script>
</body>
</html>
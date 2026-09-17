<x-layout.main_layout>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Software Directory — Filedesk</title>

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
          brand: { DEFAULT: '#4F46E5', dark: '#4338CA', light: '#EEF0FF' },
          win: { DEFAULT: '#0F7BE0', light: '#EAF4FF', dark: '#0B5FB3' },
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

  /* ============ THEME TOKENS ============
     Every category inherits its own accent purely through these
     CSS variables — no component below is redefined per category. */
  body[data-theme="windows"] {
    --accent: #0F7BE0; --accent-dark:#0B5FB3; --accent-darker:#083D71;
    --accent-light:#EAF4FF; --accent-rgb:15,123,224; --accent-border:#9FD1F7;
  }
  body[data-theme="mac"] {
    --accent:#15171D; --accent-dark:#000000; --accent-darker:#000000;
    --accent-light:#EFEFF1; --accent-rgb:20,22,27; --accent-border:#C9CBD1;
  }
  body[data-theme="android"] {
    --accent:#0E9F6E; --accent-dark:#059669; --accent-darker:#065F46;
    --accent-light:#E6FBF1; --accent-rgb:14,159,110; --accent-border:#86EFAC;
  }

  /* ============ Full-bleed category banner ============ */
  .banner-hero {
    position: relative;
    overflow: hidden;
    isolation: isolate;
    background: linear-gradient(135deg, var(--accent-dark), var(--accent-darker));
    border-bottom: 1px solid rgba(var(--accent-rgb), 0.35);
  }
  .banner-hero::after {
    content: '';
    position: absolute;
    inset: 0;
    background-image: radial-gradient(circle, rgba(255,255,255,0.5) 1px, transparent 1px);
    background-size: 16px 16px;
    opacity: .08;
    z-index: -1;
    -webkit-mask-image: linear-gradient(to right, black, transparent 65%);
    mask-image: linear-gradient(to right, black, transparent 65%);
  }
  .banner-hero::before {
    content: '';
    position: absolute;
    top: -40%; right: -10%;
    width: 55%; padding-bottom: 55%;
    background: radial-gradient(circle, rgba(255,255,255,0.16), transparent 70%);
    border-radius: 50%;
    z-index: -1;
  }

  /* ============ Subcategory chips (theme-aware) ============ */
  .chip {
    position: relative;
    transition: border-color .25s ease, background-color .25s ease, transform .25s cubic-bezier(.16,1,.3,1), box-shadow .3s ease, color .25s ease;
  }
  .chip .chip-icon {
    transition: background-color .25s ease, color .25s ease, transform .3s cubic-bezier(.16,1,.3,1);
    background: var(--accent-light);
    color: var(--accent);
  }
  .chip:hover {
    transform: translateY(-2px);
    border-color: var(--accent-border);
    box-shadow: 0 12px 26px -14px rgba(var(--accent-rgb),0.30);
  }
  .chip:hover .chip-icon { transform: scale(1.08); }
  .chip:active { transform: translateY(0) scale(.98); }
  .chip.active {
    background: linear-gradient(135deg, var(--accent), var(--accent-dark));
    border-color: transparent;
    box-shadow: 0 14px 28px -12px rgba(var(--accent-rgb),0.45);
  }
  .chip.active .chip-label { color: #fff; font-weight: 700; }
  .chip.active .chip-count { color: rgba(255,255,255,0.72); }
  .chip.active .chip-icon { background: rgba(255,255,255,0.18); color: #fff; }
  .chip.active:hover { transform: translateY(-2px); }

  /* ============ Software rows (identical component, theme via var) ============ */
  .app-row {
    position: relative;
    transition: border-color .25s ease, box-shadow .35s cubic-bezier(.16,1,.3,1), background-color .25s ease, transform .35s cubic-bezier(.16,1,.3,1);
  }
  .app-row:hover {
    transform: translateY(-3px);
    box-shadow: 0 20px 40px -16px rgba(15,17,23,0.18), 0 6px 16px -6px rgba(15,17,23,0.08);
  }
  .app-row:active { transform: translateY(-1px) scale(.995); }
  .app-row.glow-theme:hover { border-color: var(--accent-border); }
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
  .app-row.glow-theme::before { color: var(--accent); }
  .app-row:hover::before { opacity: 1; transform: scaleY(1); }
  .app-row.is-hidden { display: none; }

  .icon-tile { transition: transform .35s cubic-bezier(.16,1,.3,1), box-shadow .35s ease; }
  .app-row:hover .icon-tile { transform: scale(1.06) rotate(-2deg); }

  .dl-btn {
    transition: background-color .2s ease, color .2s ease, transform .15s ease, box-shadow .2s ease, border-color .2s ease;
    will-change: transform;
  }
  .dl-btn:hover { transform: translateY(-1px); }
  .dl-btn:active { transform: translateY(0) scale(.94); transition-duration: .08s; }
  .dl-theme:hover { background: var(--accent); color:#fff; box-shadow: 0 8px 18px -8px rgba(var(--accent-rgb),0.55); }
  .dl-theme:active { background: var(--accent-dark); box-shadow: 0 2px 8px -2px rgba(var(--accent-rgb),0.6); }

  .text-theme { color: var(--accent); }
  a.hover-theme:hover { color: var(--accent); }

  button, .chip, .submit-btn { -webkit-tap-highlight-color: transparent; }
  button:active, .submit-btn:active { transform: scale(.95); }

  .star { color: #F5A623; letter-spacing: -1px; }
  .tag-chip { transition: background-color .2s ease, color .2s ease; background: var(--accent-light); color: var(--accent); }

  .page-btn { transition: background-color .2s ease, color .2s ease, border-color .2s ease, transform .15s ease; }
  .page-btn:hover { background: #F7F8FA; }
  html.dark .page-btn:hover { background: rgba(255,255,255,0.06); }
  .page-btn.active { background: #4F46E5; color: #fff; border-color: #4F46E5; }
  .page-btn:active { transform: scale(.92); }

  .dot-grid {
    background-image: radial-gradient(circle, rgba(255,255,255,0.14) 1px, transparent 1px);
    background-size: 20px 20px;
  }

  /* Demo-only theme switcher — not part of the site chrome, just a way to
     preview how the same template re-skins itself per category. */
  .demo-switcher { position: fixed; bottom: 18px; right: 18px; z-index: 50; }
  .demo-switcher button.active { background: var(--accent); color: #fff; border-color: transparent; }

  @media (prefers-reduced-motion: reduce) {
    .app-row, .icon-tile, .dl-btn, .chip, button { transition: none !important; }
  }
</style>
</head>

<body class="antialiased bg-white text-ink dark:bg-dbg dark:text-dtext" data-theme="windows">

<!-- ================= BREADCRUMB (contained) ================= -->
<section class="pt-8 sm:pt-10">
  <div class="max-w-7xl mx-auto px-5 sm:px-8">
    <nav class="flex items-center gap-1.5 text-[12.5px] text-faint dark:text-dsub mb-5">
      <a href="#" class="hover-theme transition-colors">Home</a>
      <svg width="12" height="12" viewBox="0 0 24 24" fill="none" class="shrink-0"><path d="M9 6L15 12L9 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
      <span id="crumbCurrent" class="text-ink dark:text-white font-medium">Windows</span>
    </nav>
  </div>
</section>

<!-- ================= FULL-BLEED CATEGORY BANNER ================= -->
<section id="bannerHero" class="banner-hero">
  <div class="max-w-7xl mx-auto px-5 sm:px-8 py-10 sm:py-14 flex flex-col sm:flex-row sm:items-center gap-6 sm:gap-8 text-white">
    <span id="bannerIcon" class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl bg-white/15 flex items-center justify-center shrink-0"></span>
    <div class="min-w-0 flex-1">
      <div class="flex flex-wrap items-center gap-3">
        <h1 id="bannerTitle" class="text-2xl sm:text-3xl font-extrabold tracking-tight leading-tight">Windows Software</h1>
        <span id="bannerCount" class="text-[12.5px] font-mono font-semibold px-2.5 py-1 rounded-full bg-white/15">1,240 programs</span>
      </div>
      <p id="bannerDesc" class="mt-3 text-[14.5px] text-white/75 leading-relaxed max-w-2xl"></p>
    </div>
  </div>
</section>

<!-- ================= SUBCATEGORIES ================= -->
<section class="mt-8 sm:mt-10">
  <div class="max-w-7xl mx-auto px-5 sm:px-8">
    <h2 class="text-[13.5px] font-bold uppercase tracking-wide text-faint dark:text-dsub mb-4">Browse Subcategories</h2>
    <div id="chipRow" class="flex flex-wrap gap-3"></div>
  </div>
</section>

<!-- ================= SOFTWARE LIST + PAGINATION ================= -->
<section class="max-w-7xl mx-auto px-5 sm:px-8 mt-9 sm:mt-11 pb-16 sm:pb-20">

  <div class="flex items-center justify-between mb-4">
    <p id="resultsLine" class="text-[13px] text-sub dark:text-dsub"></p>
  </div>

  <div id="appList" class="flex flex-col gap-3"></div>

  <!-- Pagination (unchanged design) -->
  <div class="flex items-center justify-between mt-8 pt-6 border-t border-line dark:border-dline">
    <p class="text-[12.5px] text-faint dark:text-dsub hidden sm:block">Page 1 of 96</p>
    <div class="flex items-center gap-1.5 mx-auto sm:mx-0">
      <button class="page-btn w-9 h-9 rounded-lg border border-line dark:border-dline flex items-center justify-center text-sub dark:text-dsub" disabled>
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none"><path d="M15 6L9 12L15 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
      </button>
      <button class="page-btn active w-9 h-9 rounded-lg border border-line dark:border-dline text-[13px] font-semibold">1</button>
      <button class="page-btn w-9 h-9 rounded-lg border border-line dark:border-dline text-[13px] font-semibold text-ink dark:text-white">2</button>
      <button class="page-btn w-9 h-9 rounded-lg border border-line dark:border-dline text-[13px] font-semibold text-ink dark:text-white">3</button>
      <span class="w-9 h-9 flex items-center justify-center text-[13px] text-faint dark:text-dsub">…</span>
      <button id="lastPageBtn" class="page-btn w-9 h-9 rounded-lg border border-line dark:border-dline text-[13px] font-semibold text-ink dark:text-white">96</button>
      <button class="page-btn w-9 h-9 rounded-lg border border-line dark:border-dline flex items-center justify-center text-sub dark:text-dsub">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none"><path d="M9 6L15 12L9 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
      </button>
    </div>
  </div>

</section>

<!-- ================= NEWSLETTER (unchanged) ================= -->
<section class="max-w-7xl mx-auto px-5 sm:px-8 py-16 sm:py-20">
  <div class="relative rounded-[28px] p-[1.5px] bg-gradient-to-br from-white/25 via-white/5 to-transparent shadow-[0_30px_70px_-20px_rgba(15,17,23,0.55)] dark:shadow-[0_16px_36px_-18px_rgba(0,0,0,0.6)]">
    <div class="relative overflow-hidden rounded-[26px] bg-ink px-6 py-12 sm:px-14 sm:py-16">
      <div class="absolute inset-0 dot-grid [mask-image:radial-gradient(ellipse_70%_80%_at_30%_30%,black,transparent)]"></div>
      <div class="absolute -top-20 -right-20 w-80 h-80 rounded-full bg-brand/25 dark:bg-brand/15 blur-[90px]"></div>
      <div class="absolute -bottom-24 -left-10 w-80 h-80 rounded-full bg-win/15 dark:bg-win/10 blur-[90px]"></div>
      <div class="absolute top-0 left-1/2 -translate-x-1/2 w-2/3 h-px bg-gradient-to-r from-transparent via-white/40 to-transparent"></div>

      <div class="relative flex flex-col lg:flex-row items-center lg:items-center justify-between gap-10">
        <div class="text-center lg:text-left max-w-md">
          <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/10 border border-white/10 text-white/80 text-[12px] font-mono font-semibold">
            <span class="w-1.5 h-1.5 rounded-full bg-win animate-pulse"></span>
            Weekly digest · 68,400+ subscribers
          </span>
          <h2 id="newsletterTitle" class="mt-5 text-[26px] sm:text-[32px] font-bold tracking-tight text-white leading-[1.15]">
            New Windows releases, straight to your inbox
          </h2>
          <p class="mt-3 text-white/55 text-[14.5px] leading-relaxed">
            One short email a week — hand-picked updates. No spam, unsubscribe anytime.
          </p>
        </div>

        <div class="w-full max-w-sm shrink-0">
          <form class="flex flex-col gap-3 p-1.5 rounded-2xl bg-white/[0.04] border border-white/10">
            <label class="relative block">
              <span class="sr-only">Email address</span>
              <svg class="absolute left-4 top-1/2 -translate-y-1/2 text-white/40" width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M3 6L12 13L21 6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/><rect x="3" y="4" width="18" height="16" rx="2.5" stroke="currentColor" stroke-width="1.8"/></svg>
              <input
                type="email"
                required
                placeholder="you@email.com"
                class="w-full h-12 pl-11 pr-4 rounded-xl bg-white/[0.07] border border-white/15 text-white placeholder:text-white/35 text-[14px] outline-none focus:bg-white/[0.1] focus:border-white/30 transition-colors"
              />
            </label>
            <button type="submit" class="submit-btn h-12 px-6 rounded-xl bg-white text-ink text-[14px] font-semibold hover:bg-brand hover:text-white transition-colors shadow-[0_10px_24px_-8px_rgba(255,255,255,0.25)]">
              Subscribe
            </button>
          </form>
          <p class="mt-3 text-[11.5px] text-white/35 font-mono text-center lg:text-left">No spam, ever. Unsubscribe in one click.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Demo-only switcher: lets you preview how the template re-skins per category -->
<div class="demo-switcher flex items-center gap-1 p-1 rounded-full bg-white/95 dark:bg-dcard border border-line dark:border-dline shadow-cardHover backdrop-blur">
  <button data-demo="windows" class="demo-btn active px-3 py-1.5 rounded-full text-[12px] font-semibold border border-transparent text-ink dark:text-white">Windows</button>
  <button data-demo="mac" class="demo-btn px-3 py-1.5 rounded-full text-[12px] font-semibold border border-transparent text-ink dark:text-white">Mac</button>
  <button data-demo="android" class="demo-btn px-3 py-1.5 rounded-full text-[12px] font-semibold border border-transparent text-ink dark:text-white">Android</button>
</div>

<script>
/* =========================================================================
   ICON LIBRARY — small, reusable path/shape defs shared across categories.
   Each returns inner SVG markup (no <svg> wrapper) so callers control size/fill.
   ========================================================================= */
const ICONS = {
  windows: '<path d="M3 5.5L10.5 4.5V11.3H3V5.5Z"/><path d="M11.5 4.4L21 3V11.2H11.5V4.4Z"/><path d="M3 12.3H10.5V19.1L3 18.1V12.3Z"/><path d="M11.5 12.3H21V20.5L11.5 19.2V12.3Z"/>',
  apple: '<path d="M15.3 2.1c0 1.06-.42 2.05-1.14 2.77-.77.78-2.03 1.38-3.08 1.3-.13-1.04.39-2.13 1.08-2.81.77-.77 2.09-1.34 3.14-1.26zM19.3 15.9c-.5 1.16-.75 1.68-1.4 2.7-.93 1.45-2.24 3.26-3.86 3.28-1.45.02-1.82-.93-3.78-.93-1.96 0-2.38.91-3.83.91-1.62-.02-2.85-1.63-3.78-3.08-2.6-4.02-2.87-8.74-1.27-11.25 1.14-1.78 2.93-2.82 4.6-2.82 1.72 0 2.8.95 4.23.95 1.38 0 2.24-.95 4.23-.95 1.49 0 3.08.81 4.2 2.22-3.7 2.03-3.1 7.31.66 8.97z"/>',
  android: '<path d="M6.5 9.2v6.4a1 1 0 0 0 1 1h9a1 1 0 0 0 1-1V9.2H6.5Z"/><path d="M5 9.2h14v0a1 1 0 0 0-1-1H6a1 1 0 0 0-1 1v0Z" opacity="0"/><rect x="5" y="9.2" width="14" height="7.6" rx="1.4"/><rect x="4.2" y="10.2" width="1.6" height="5" rx="0.8"/><rect x="18.2" y="10.2" width="1.6" height="5" rx="0.8"/><rect x="9.5" y="17.4" width="1.6" height="3.4" rx="0.8"/><rect x="12.9" y="17.4" width="1.6" height="3.4" rx="0.8"/><circle cx="9" cy="12.4" r="1" fill="white"/><circle cx="15" cy="12.4" r="1" fill="white"/><path d="M8.3 5.7L7 4.1M15.7 5.7L17 4.1" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/><path d="M8 8.4c0-2.2 1.8-4 4-4s4 1.8 4 4" fill="none" stroke="currentColor" stroke-width="0" />',
};

// generic subcategory glyphs (stroke-based, currentColor) shared across themes
const GLYPH = {
  grid:   '<rect x="3" y="4" width="7" height="7" rx="1.5" stroke="currentColor" stroke-width="2"/><rect x="14" y="4" width="7" height="7" rx="1.5" stroke="currentColor" stroke-width="2"/><rect x="3" y="13" width="7" height="7" rx="1.5" stroke="currentColor" stroke-width="2"/><rect x="14" y="13" width="7" height="7" rx="1.5" stroke="currentColor" stroke-width="2"/>',
  shield: '<path d="M12 3L20 6.5V11.5C20 16 16.9 19.9 12 21C7.1 19.9 4 16 4 11.5V6.5L12 3Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/><path d="M9 12L11 14L15.5 9.5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>',
  office: '<rect x="3" y="4" width="18" height="14" rx="2" stroke="currentColor" stroke-width="1.8"/><path d="M9 21H15M12 17V21" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>',
  code:   '<rect x="3" y="5" width="18" height="14" rx="2" stroke="currentColor" stroke-width="1.8"/><path d="M7 9L10 12L7 15" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/><path d="M12 15H16" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>',
  globe:  '<circle cx="12" cy="12" r="8.5" stroke="currentColor" stroke-width="1.8"/><path d="M8.5 8.5L15.5 12L8.5 15.5V8.5Z" fill="currentColor"/>',
  media:  '<rect x="3" y="4" width="18" height="12" rx="1.8" stroke="currentColor" stroke-width="1.8"/><path d="M9 20H15M12 16V20" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/><path d="M8 9.5L11 12L8 14.5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>',
  box:    '<path d="M6 3L18 3L21 8V19C21 20.1 20.1 21 19 21H5C3.9 21 3 20.1 3 19V8L6 3Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/><path d="M3 8H21" stroke="currentColor" stroke-width="1.8"/>',
  backup: '<path d="M4 12C4 7.6 7.6 4 12 4C15.3 4 18.1 6 19.3 8.9" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/><path d="M20 12C20 16.4 16.4 20 12 20C8.7 20 5.9 18 4.7 15.1" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/><path d="M19 5V9H15" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/><path d="M5 19V15H9" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>',
  chip:   '<rect x="4" y="4" width="16" height="16" rx="3" stroke="currentColor" stroke-width="1.8"/><path d="M4 9H2M4 15H2M22 9H20M22 15H20M9 4V2M15 4V2M9 22V20M15 22V20" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>',
  wrench: '<path d="M4 6.5C4 5.1 5.1 4 6.5 4H17.5C18.9 4 20 5.1 20 6.5V15.5C20 16.9 18.9 18 17.5 18H6.5C5.1 18 4 16.9 4 15.5V6.5Z" stroke="currentColor" stroke-width="1.8"/><path d="M9 21H15M12 18V21" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>',
  camera: '<path d="M4 8.5C4 7.4 4.9 6.5 6 6.5H8L9.3 4.5H14.7L16 6.5H18C19.1 6.5 20 7.4 20 8.5V17C20 18.1 19.1 19 18 19H6C4.9 19 4 18.1 4 17V8.5Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/><circle cx="12" cy="12.5" r="3.3" stroke="currentColor" stroke-width="1.8"/>',
  message:'<path d="M4 5.5H20V16H9L5 19.5V16H4V5.5Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>',
  game:   '<rect x="3" y="7" width="18" height="11" rx="4" stroke="currentColor" stroke-width="1.8"/><path d="M8 10.5V14.5M6 12.5H10" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/><circle cx="15.5" cy="11.5" r="1" fill="currentColor"/><circle cx="17.5" cy="13.5" r="1" fill="currentColor"/>',
  layout: '<rect x="3" y="4" width="18" height="16" rx="2" stroke="currentColor" stroke-width="1.8"/><path d="M3 9H21" stroke="currentColor" stroke-width="1.8"/><path d="M9 9V20" stroke="currentColor" stroke-width="1.8"/>',
};

function iconSvg(path, {size=14, fill='none', stroke=false} = {}) {
  return `<svg width="${size}" height="${size}" viewBox="0 0 24 24" fill="${fill}">${path}</svg>`;
}

/* =========================================================================
   THEME / CATEGORY DATA
   Each category carries: identity (label, description, count, button label,
   icon), its own subcategory chips, and its own sample software list.
   Swapping `current` re-skins the entire page from these tokens alone.
   ========================================================================= */
const THEMES = {
  windows: {
    label: 'Windows',
    seo: "Free and paid Windows programs, hand-tested and updated daily — from system cleanup and antivirus to developer tools and media players. Every download is scanned before it's listed.",
    total: 1240,
    button: 'Download',
    iconPath: ICONS.windows,
    iconFillRule: 'currentColor',
    subcategories: [
      { key:'all', label:'All', count:1240, glyph:GLYPH.grid },
      { key:'antivirus', label:'Antivirus', count:96, glyph:GLYPH.shield },
      { key:'office', label:'Office', count:64, glyph:GLYPH.office },
      { key:'developer-tools', label:'Developer Tools', count:118, glyph:GLYPH.code },
      { key:'browsers', label:'Browsers', count:31, glyph:GLYPH.globe },
      { key:'media-players', label:'Media Players', count:57, glyph:GLYPH.media },
      { key:'compression', label:'Compression', count:42, glyph:GLYPH.box },
      { key:'backup', label:'Backup', count:38, glyph:GLYPH.backup },
      { key:'drivers', label:'Drivers', count:29, glyph:GLYPH.chip },
      { key:'utilities', label:'Utilities', count:265, glyph:GLYPH.wrench },
    ],
    apps: [
      { name:'Nexus Cleaner', desc:'Deep system cleanup & startup optimizer.', sub:'utilities', tag:'Utilities', initials:'Nx', grad:'from-win to-blue-700', downloads:'842K', rating:4.8, stars:5 },
      { name:'QuickBoot Manager', desc:'Control startup apps in one dashboard.', sub:'utilities', tag:'Utilities', initials:'Qb', grad:'from-sky-400 to-cyan-600', downloads:'610K', rating:4.7, stars:5 },
      { name:'Vault Archiver', desc:'Fast compression with AES encryption.', sub:'compression', tag:'Compression', initials:'Vt', grad:'from-indigo-500 to-purple-600', downloads:'1.2M', rating:4.9, stars:5 },
      { name:'FrameCast Recorder', desc:'Lightweight, GPU-accelerated screen recorder.', sub:'media-players', tag:'Media Players', initials:'Fc', grad:'from-slate-700 to-slate-900', downloads:'356K', rating:4.6, stars:4 },
      { name:'TimeMint', desc:'Menu-bar time tracker for freelancers.', sub:'utilities', tag:'Utilities', initials:'Tm', grad:'from-emerald-400 to-teal-600', downloads:'520K', rating:4.8, stars:5 },
      { name:'DriveRestore', desc:'Recover deleted files from any disk.', sub:'backup', tag:'Backup', initials:'Dr', grad:'from-rose-400 to-red-600', downloads:'278K', rating:4.4, stars:4 },
      { name:'ShieldGuard Antivirus', desc:'Real-time malware & ransomware protection.', sub:'antivirus', tag:'Antivirus', initials:'Sh', grad:'from-amber-400 to-orange-600', downloads:'2.1M', rating:4.8, stars:5 },
      { name:'DriverSync Pro', desc:'Finds and updates outdated drivers.', sub:'drivers', tag:'Drivers', initials:'Dv', grad:'from-teal-400 to-cyan-700', downloads:'495K', rating:4.5, stars:4 },
      { name:'CodeForge IDE', desc:'Lightweight code editor with Git built-in.', sub:'developer-tools', tag:'Developer Tools', initials:'Cd', grad:'from-fuchsia-500 to-purple-700', downloads:'733K', rating:4.9, stars:5 },
      { name:'BackupVault', desc:'Automated cloud & local backup scheduler.', sub:'backup', tag:'Backup', initials:'Bk', grad:'from-lime-400 to-green-600', downloads:'312K', rating:4.6, stars:4 },
      { name:'Switchboard', desc:'Keyboard-first window snapping layouts.', sub:'utilities', tag:'Utilities', initials:'Sw', grad:'from-indigo-400 to-blue-700', downloads:'433K', rating:4.9, stars:5 },
      { name:'NoteForge', desc:'Markdown notes with instant sync.', sub:'office', tag:'Office', initials:'Nt', grad:'from-pink-400 to-rose-600', downloads:'201K', rating:4.5, stars:4 },
      { name:'PerfMonitor', desc:'Live CPU, GPU & RAM usage overlay.', sub:'utilities', tag:'Utilities', initials:'Pf', grad:'from-slate-500 to-slate-700', downloads:'158K', rating:4.3, stars:4 },
    ],
  },

  mac: {
    label: 'Mac',
    seo: "Free and paid macOS apps, reviewed for Apple Silicon and Intel — from menu-bar utilities and creative tools to developer environments. Every download is verified before it's listed.",
    total: 860,
    button: 'Get',
    iconPath: ICONS.apple,
    subcategories: [
      { key:'all', label:'All', count:860, glyph:GLYPH.grid },
      { key:'menu-bar', label:'Menu Bar Tools', count:74, glyph:GLYPH.layout },
      { key:'productivity', label:'Productivity', count:112, glyph:GLYPH.office },
      { key:'developer-tools', label:'Developer Tools', count:96, glyph:GLYPH.code },
      { key:'security', label:'Security', count:53, glyph:GLYPH.shield },
      { key:'media', label:'Media', count:61, glyph:GLYPH.media },
      { key:'utilities', label:'Utilities', count:180, glyph:GLYPH.wrench },
    ],
    apps: [
      { name:'MenuFlow', desc:'Clutter-free menu-bar app organizer.', sub:'menu-bar', tag:'Menu Bar Tools', initials:'Mf', grad:'from-slate-700 to-slate-900', downloads:'298K', rating:4.7, stars:5 },
      { name:'Focusly', desc:'Distraction-free writing with live word goals.', sub:'productivity', tag:'Productivity', initials:'Fc', grad:'from-zinc-600 to-zinc-800', downloads:'410K', rating:4.8, stars:5 },
      { name:'Terminus X', desc:'GPU-accelerated terminal with split panes.', sub:'developer-tools', tag:'Developer Tools', initials:'Tx', grad:'from-neutral-700 to-black', downloads:'522K', rating:4.9, stars:5 },
      { name:'VaultLock', desc:'On-device encrypted notes and passwords.', sub:'security', tag:'Security', initials:'Vl', grad:'from-gray-700 to-gray-900', downloads:'187K', rating:4.6, stars:4 },
      { name:'Waveform Player', desc:'Hi-res audio player with EQ presets.', sub:'media', tag:'Media', initials:'Wf', grad:'from-stone-600 to-stone-800', downloads:'265K', rating:4.5, stars:4 },
      { name:'CleanDock', desc:'Frees disk space and manages caches.', sub:'utilities', tag:'Utilities', initials:'Cd', grad:'from-slate-600 to-slate-800', downloads:'611K', rating:4.7, stars:5 },
      { name:'Snapstack', desc:'Keyboard-driven window tiling for macOS.', sub:'utilities', tag:'Utilities', initials:'Sk', grad:'from-neutral-600 to-neutral-900', downloads:'349K', rating:4.8, stars:5 },
      { name:'Buildhouse', desc:'Local build & deploy pipelines, no cloud needed.', sub:'developer-tools', tag:'Developer Tools', initials:'Bh', grad:'from-zinc-700 to-black', downloads:'204K', rating:4.6, stars:4 },
    ],
  },

  android: {
    label: 'Android',
    seo: 'Free and paid Android apps, tested across devices — from photography and productivity to games and personalization. Every APK is scanned before it\'s listed.',
    total: 1580,
    button: 'Install',
    iconPath: ICONS.android,
    subcategories: [
      { key:'all', label:'All', count:1580, glyph:GLYPH.grid },
      { key:'photo-video', label:'Photo & Video', count:142, glyph:GLYPH.camera },
      { key:'communication', label:'Communication', count:88, glyph:GLYPH.message },
      { key:'tools', label:'Tools', count:231, glyph:GLYPH.wrench },
      { key:'games', label:'Games', count:305, glyph:GLYPH.game },
      { key:'productivity', label:'Productivity', count:97, glyph:GLYPH.office },
      { key:'security', label:'Security', count:64, glyph:GLYPH.shield },
    ],
    apps: [
      { name:'SnapEdit Pro', desc:'AI photo retouching with batch presets.', sub:'photo-video', tag:'Photo & Video', initials:'Sn', grad:'from-emerald-400 to-green-600', downloads:'3.4M', rating:4.7, stars:5 },
      { name:'ChatterBox', desc:'Encrypted messaging with vanishing media.', sub:'communication', tag:'Communication', initials:'Cb', grad:'from-teal-400 to-emerald-700', downloads:'1.9M', rating:4.5, stars:4 },
      { name:'TaskFlow Lite', desc:'Widget-first to-do list with reminders.', sub:'productivity', tag:'Productivity', initials:'Tf', grad:'from-lime-400 to-green-600', downloads:'720K', rating:4.6, stars:5 },
      { name:'BatteryGuard', desc:'Extends battery life with adaptive charging.', sub:'tools', tag:'Tools', initials:'Bg', grad:'from-green-400 to-emerald-700', downloads:'2.6M', rating:4.8, stars:5 },
      { name:'Skyfall Arena', desc:'Fast-paced battle royale, low-end friendly.', sub:'games', tag:'Games', initials:'Sf', grad:'from-emerald-500 to-teal-700', downloads:'5.1M', rating:4.4, stars:4 },
      { name:'SafeShield Mobile', desc:'Real-time app permission & malware scanner.', sub:'security', tag:'Security', initials:'Ss', grad:'from-green-500 to-emerald-800', downloads:'1.3M', rating:4.7, stars:5 },
      { name:'PixelCast', desc:'Screen recorder with one-tap live streaming.', sub:'photo-video', tag:'Photo & Video', initials:'Pc', grad:'from-teal-500 to-green-700', downloads:'980K', rating:4.5, stars:4 },
      { name:'FileHive', desc:'Unified file manager for local & cloud storage.', sub:'tools', tag:'Tools', initials:'Fh', grad:'from-emerald-400 to-teal-600', downloads:'845K', rating:4.6, stars:4 },
    ],
  },
};

let current = 'windows';
let activeSub = 'all';

function bannerIconMarkup(theme, {size=34, colorClass=''} = {}) {
  return `<svg width="${size}" height="${size}" viewBox="0 0 24 24" fill="white" class="${colorClass}">${theme.iconPath}</svg>`;
}
function rowIconMarkup(theme) {
  return `<svg width="11" height="11" viewBox="0 0 24 24" fill="currentColor">${theme.iconPath}</svg>`;
}
function starString(n) {
  return '★★★★★'.slice(0, n) + '☆☆☆☆☆'.slice(0, 5 - n);
}

function renderChips(theme) {
  const chipRow = document.getElementById('chipRow');
  chipRow.innerHTML = theme.subcategories.map(sc => `
    <a href="#" data-sub="${sc.key}" class="chip ${sc.key === activeSub ? 'active' : ''} shrink-0 flex items-center gap-2.5 pl-2.5 pr-4 py-2.5 rounded-full border border-line dark:border-dline bg-white dark:bg-dcard">
      <span class="chip-icon w-7 h-7 rounded-full flex items-center justify-center shrink-0">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none">${sc.glyph}</svg>
      </span>
      <span class="chip-label text-[13px] font-semibold text-ink dark:text-white">${sc.label}</span>
      <span class="chip-count text-[11px] font-mono text-faint dark:text-dsub">${sc.count.toLocaleString()}</span>
    </a>
  `).join('');

  chipRow.querySelectorAll('.chip').forEach(el => {
    el.addEventListener('click', e => {
      e.preventDefault();
      activeSub = el.getAttribute('data-sub');
      renderChips(theme);
      renderApps(theme);
    });
  });
}

function renderApps(theme) {
  const list = document.getElementById('appList');
  const rowIcon = rowIconMarkup(theme);
  const filtered = activeSub === 'all' ? theme.apps : theme.apps.filter(a => a.sub === activeSub);

  list.innerHTML = filtered.map(app => `
    <article class="app-row glow-theme flex items-center gap-3 sm:gap-4 bg-white dark:bg-dcard border border-line dark:border-dline rounded-xl px-3 py-2.5 sm:px-4 sm:py-3 cursor-pointer shadow-card dark:shadow-none">
      <span class="icon-tile w-11 h-11 sm:w-12 sm:h-12 rounded-lg bg-gradient-to-br ${app.grad} flex items-center justify-center text-white font-bold shrink-0 text-[13px]">${app.initials}</span>
      <div class="min-w-0 flex-1">
        <h3 class="font-bold text-[14px] sm:text-[14.5px] text-ink dark:text-white truncate">${app.name}</h3>
        <p class="text-[12px] text-faint dark:text-dsub mt-0.5 truncate">${app.desc}</p>
        <span class="tag-chip inline-block mt-1.5 text-[10px] font-semibold px-2 py-0.5 rounded-full">${app.tag}</span>
      </div>
      <span class="hidden md:block w-px h-9 bg-line dark:bg-dline shrink-0"></span>
      <div class="hidden md:flex flex-col items-center justify-center gap-1 w-[100px] shrink-0">
        <span class="flex items-center gap-1.5 text-[12px] font-semibold text-theme">${rowIcon} ${theme.label}</span>
        <span class="text-[11px] font-mono text-faint dark:text-dsub">${app.downloads} downloads</span>
      </div>
      <span class="hidden sm:block w-px h-9 bg-line dark:bg-dline shrink-0"></span>
      <div class="hidden sm:flex flex-col items-center justify-center gap-0.5 w-[84px] shrink-0 rounded-lg bg-amber-50 dark:bg-amber-400/10 py-1.5">
        <span class="text-[9px] font-semibold uppercase tracking-wider text-amber-500/80 dark:text-amber-300/80">Rating</span>
        <span class="flex items-center gap-1 text-[12.5px] font-bold text-amber-500"><span class="star">${starString(app.stars)}</span></span>
        <span class="text-[10px] font-mono text-amber-600/70 dark:text-amber-300/70">${app.rating}</span>
      </div>
      <button class="dl-btn dl-theme h-9 px-4 sm:px-5 rounded-lg bg-surface dark:bg-white/10 text-ink dark:text-white text-[13px] font-semibold shrink-0">${theme.button}</button>
    </article>
  `).join('');

  const activeChip = theme.subcategories.find(s => s.key === activeSub);
  const shown = filtered.length;
  document.getElementById('resultsLine').innerHTML =
    `Showing <span class="font-semibold text-ink dark:text-white">1–${shown}</span> of <span class="font-semibold text-ink dark:text-white">${activeChip.count.toLocaleString()}</span> results`;
}

function renderTheme(key) {
  current = key;
  activeSub = 'all';
  const theme = THEMES[key];

  document.body.setAttribute('data-theme', key);
  document.getElementById('crumbCurrent').textContent = theme.label;
  document.getElementById('bannerTitle').textContent = `${theme.label} Software`;
  document.getElementById('bannerCount').textContent = `${theme.total.toLocaleString()} programs`;
  document.getElementById('bannerDesc').textContent = theme.seo;
  document.getElementById('bannerIcon').innerHTML = bannerIconMarkup(theme);
  document.getElementById('newsletterTitle').textContent = `New ${theme.label} releases, straight to your inbox`;
  document.getElementById('lastPageBtn').textContent = Math.max(2, Math.ceil(theme.total / 13));
  document.title = `${theme.label} Software — ${theme.total.toLocaleString()} Programs | Filedesk`;

  renderChips(theme);
  renderApps(theme);

  document.querySelectorAll('.demo-btn').forEach(b => b.classList.toggle('active', b.getAttribute('data-demo') === key));
}

document.querySelectorAll('.demo-btn').forEach(b => {
  b.addEventListener('click', () => renderTheme(b.getAttribute('data-demo')));
});

renderTheme('windows');

(function () {
  var btn = document.getElementById('darkModeToggle');
  if (!btn) return;
  var icon = document.getElementById('darkModeIcon');
  var sun = '<path d="M12 5V2.5M12 21.5V19M19 12H21.5M2.5 12H5M17.7 6.3L19.4 4.6M4.6 19.4L6.3 17.7M17.7 17.7L19.4 19.4M4.6 4.6L6.3 6.3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><circle cx="12" cy="12" r="4.5" fill="currentColor"/>';
  var moon = '<path d="M21 12.8A9 9 0 1 1 11.2 3 7 7 0 0 0 21 12.8Z" fill="currentColor"/>';
  var on = localStorage.getItem('theme') === 'dark';
  document.documentElement.classList.toggle('dark', on);
  icon.innerHTML = on ? sun : moon;
  btn.addEventListener('click', function () {
    on = !on;
    document.documentElement.classList.toggle('dark', on);
    icon.innerHTML = on ? sun : moon;
    localStorage.setItem('theme', on ? 'dark' : 'light');
  });
})();
</script>
</body>
</html>
</x-layout.main_layout>
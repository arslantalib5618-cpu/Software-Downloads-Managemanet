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
            mac: { DEFAULT: '#171821', light: '#F1F1F3', dark: '#26272E' },
            android: { DEFAULT: '#2FB170', light: '#E9FBF1', dark: '#1F8F58' },
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
<header class="sticky top-0 z-50">
  <div class="glass dark:bg-dbg/90 shadow-nav dark:shadow-none dark:border-b dark:border-white/8">
    <div class="w-full px-5 sm:px-8 lg:px-12 xl:px-16">
      <div class="flex items-center gap-5 lg:gap-8 h-16">

        <!-- Logo -->
        <a href="#" class="flex items-center gap-2.5 shrink-0">
          <span class="w-10 h-10 rounded-lg bg-ink dark:bg-white flex items-center justify-center">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" class="dark:hidden">
              <path d="M12 2L21 7V17L12 22L3 17V7L12 2Z" stroke="white" stroke-width="1.8" stroke-linejoin="round"/>
              <path d="M12 12L21 7M12 12V22M12 12L3 7" stroke="white" stroke-width="1.8" stroke-linejoin="round"/>
            </svg>
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" class="hidden dark:block">
              <path d="M12 2L21 7V17L12 22L3 17V7L12 2Z" stroke="#0B0D12" stroke-width="1.8" stroke-linejoin="round"/>
              <path d="M12 12L21 7M12 12V22M12 12L3 7" stroke="#0B0D12" stroke-width="1.8" stroke-linejoin="round"/>
            </svg>
          </span>
          <span class="text-[24px] font-extrabold tracking-tight">Filedesk</span>
        </a>

        <!-- Search bar (always visible, main navbar) -->
        <div class="flex-1 max-w-3xl">
          <form class="relative block" onsubmit="return false;">
            <span class="sr-only">Search software</span>
            <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 text-faint dark:text-dsub" width="16" height="16" viewBox="0 0 24 24" fill="none">
              <circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2"/>
              <path d="M21 21L16.65 16.65" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            </svg>
            <input
              type="text"
              placeholder="Search for software, apps, games..."
              class="search-input w-full h-11 pl-10 pr-12 rounded-full bg-surface dark:bg-dsurface border border-line dark:border-dline text-[14px] placeholder:text-faint dark:placeholder:text-dsub outline-none transition-shadow focus:bg-white dark:focus:bg-dsurface focus:border-brand"
            />
            <button type="submit" aria-label="Search" class="dl-btn absolute right-1.5 top-1/2 -translate-y-1/2 w-8 h-8 rounded-full bg-ink dark:bg-white text-white dark:text-ink flex items-center justify-center hover:bg-brand dark:hover:bg-brand dark:hover:text-white">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
                <circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2.2"/>
                <path d="M21 21L16.65 16.65" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/>
              </svg>
            </button>
          </form>
        </div>

        <!-- Right actions -->
        <div class="flex items-center gap-5 lg:gap-6 shrink-0">
          <div class="hidden md:flex items-center gap-5 lg:gap-6 pr-1">
            <span class="text-[13px] font-semibold text-sub dark:text-dsub hover:text-ink dark:hover:text-white transition-colors cursor-default whitespace-nowrap">Top Rated Software</span>
            <span class="w-px h-4 bg-line dark:bg-dline"></span>
            <span class="text-[13px] font-semibold text-sub dark:text-dsub hover:text-ink dark:hover:text-white transition-colors cursor-default whitespace-nowrap">Top Downloads</span>
          </div>
          <button id="darkModeToggle" aria-label="Toggle dark mode" class="dl-btn w-10 h-10 flex items-center justify-center rounded-full bg-ink dark:bg-white text-white dark:text-ink hover:bg-brand dark:hover:bg-brand dark:hover:text-white shrink-0">
            <svg id="darkModeIcon" width="17" height="17" viewBox="0 0 24 24" fill="none">
              <path d="M21 12.8A9 9 0 1 1 11.2 3 7 7 0 0 0 21 12.8Z" fill="currentColor"/>
            </svg>
          </button>
          <button class="lg:hidden w-10 h-10 flex items-center justify-center rounded-lg hover:bg-surface dark:hover:bg-dsurface transition-colors" aria-label="Menu">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M4 7H20M4 12H20M4 17H20" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
          </button>
        </div>

      </div>
    </div>
  </div>

  <!-- ============= CATEGORY NAVBAR (premium segmented control, full width) ============= -->
  <div class="cat-bar">
    <div class="w-full px-5 sm:px-8 lg:px-12 xl:px-16">
      <div class="flex items-stretch gap-1.5 h-14 sm:h-16 overflow-x-auto no-scrollbar">

        <a href="#windows" class="cat-pill active shrink-0 flex-1 flex items-center justify-center gap-2.5 text-[14px] sm:text-[15px] font-semibold px-6 sm:px-10 rounded-lg">
          <span class="cat-icon"><svg width="14" height="14" viewBox="0 0 24 24" fill="none"><path d="M3 5.5L10.5 4.5V11.3H3V5.5Z" fill="currentColor"/><path d="M11.5 4.4L21 3V11.2H11.5V4.4Z" fill="currentColor"/><path d="M3 12.3H10.5V19.1L3 18.1V12.3Z" fill="currentColor"/><path d="M11.5 12.3H21V20.5L11.5 19.2V12.3Z" fill="currentColor"/></svg></span>
          Windows
        </a>
        <a href="#macos" class="cat-pill shrink-0 flex-1 flex items-center justify-center gap-2.5 text-[14px] sm:text-[15px] font-medium px-6 sm:px-10 rounded-lg">
          <span class="cat-icon"><svg width="14" height="14" viewBox="0 0 24 24" fill="none"><path d="M16.5 2.5C16.7 3.7 16.2 4.9 15.5 5.8C14.7 6.7 13.4 7.4 12.2 7.3C12 6.1 12.6 4.9 13.3 4.1C14.1 3.2 15.4 2.5 16.5 2.5Z" fill="currentColor"/><path d="M20.5 17.6C20 18.9 19.5 20 18.7 21C17.9 22 17.1 23 15.9 23C14.8 23 14.4 22.3 13.1 22.3C11.8 22.3 11.3 23 10.3 23C9.1 23 8.2 21.9 7.4 20.9C5.7 18.7 4.3 14.9 6.1 12.3C7 11 8.5 10.2 10 10.2C11.2 10.2 12 11 12.9 11C13.8 11 14.4 10.2 15.9 10.2C17.2 10.2 18.6 10.9 19.5 12.1C16.9 13.5 17.3 17 20.5 17.6Z" fill="currentColor"/></svg></span>
          Mac
        </a>
        <a href="#android" class="cat-pill shrink-0 flex-1 flex items-center justify-center gap-2.5 text-[14px] sm:text-[15px] font-medium px-6 sm:px-10 rounded-lg">
          <span class="cat-icon"><svg width="14" height="14" viewBox="0 0 24 24" fill="none"><path d="M6 9.5V17C6 17.6 6.4 18 7 18H8V21C8 21.6 8.4 22 9 22C9.6 22 10 21.6 10 21V18H14V21C14 21.6 14.4 22 15 22C15.6 22 16 21.6 16 21V18H17C17.6 18 18 17.6 18 17V9.5H6Z" fill="currentColor"/><path d="M6.5 8.5H17.5C17.3 6.5 16.1 4.8 14.4 3.9L15.3 2.3C15.4 2.1 15.3 1.9 15.2 1.8C15 1.7 14.8 1.8 14.7 1.9L13.7 3.6C12.9 3.3 12 3.1 11 3.1C10 3.1 9.1 3.3 8.3 3.6L7.3 1.9C7.2 1.8 7 1.7 6.8 1.8C6.7 1.9 6.6 2.1 6.7 2.3L7.6 3.9C5.9 4.8 6.7 6.5 6.5 8.5Z" fill="currentColor"/><rect x="3.5" y="9.5" width="1.8" height="6.5" rx="0.9" fill="currentColor"/><rect x="18.7" y="9.5" width="1.8" height="6.5" rx="0.9" fill="currentColor"/></svg></span>
          Android
        </a>
        <a href="#" class="cat-pill shrink-0 flex-1 flex items-center justify-center gap-2.5 text-[14px] sm:text-[15px] font-medium px-6 sm:px-10 rounded-lg">
          <span class="cat-icon"><svg width="14" height="14" viewBox="0 0 24 24" fill="none"><rect x="2" y="6" width="20" height="13" rx="3" stroke="currentColor" stroke-width="1.8"/><path d="M7 10V15M4.5 12.5H9.5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/><circle cx="16" cy="10.5" r="1" fill="currentColor"/><circle cx="18.5" cy="13" r="1" fill="currentColor"/></svg></span>
          Games
        </a>
        <a href="#" class="cat-pill shrink-0 flex-1 flex items-center justify-center gap-2.5 text-[14px] sm:text-[15px] font-medium px-6 sm:px-10 rounded-lg">
          <span class="cat-icon"><svg width="14" height="14" viewBox="0 0 24 24" fill="none"><circle cx="5" cy="12" r="2" fill="currentColor"/><circle cx="12" cy="12" r="2" fill="currentColor"/><circle cx="19" cy="12" r="2" fill="currentColor"/></svg></span>
          Other
        </a>

      </div>
    </div>
  </div>
</header>
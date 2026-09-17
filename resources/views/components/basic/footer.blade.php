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
<section class="max-w-7xl mx-auto px-5 sm:px-8 py-16 sm:py-20">
  <div class="relative rounded-[28px] p-[1.5px] bg-gradient-to-br from-white/25 via-white/5 to-transparent shadow-[0_30px_70px_-20px_rgba(15,17,23,0.55)] dark:shadow-[0_16px_36px_-18px_rgba(0,0,0,0.6)]">
    <div class="relative overflow-hidden rounded-[26px] bg-ink px-6 py-12 sm:px-14 sm:py-16">
      <div class="absolute inset-0 dot-grid [mask-image:radial-gradient(ellipse_70%_80%_at_30%_30%,black,transparent)]"></div>
      <div class="absolute -top-20 -right-20 w-80 h-80 rounded-full bg-brand/25 dark:bg-brand/15 blur-[90px]"></div>
      <div class="absolute -bottom-24 -left-10 w-80 h-80 rounded-full bg-android/15 dark:bg-android/10 blur-[90px]"></div>
      <div class="absolute top-0 left-1/2 -translate-x-1/2 w-2/3 h-px bg-gradient-to-r from-transparent via-white/40 to-transparent"></div>

      <div class="relative flex flex-col lg:flex-row items-center lg:items-center justify-between gap-10">
        <div class="text-center lg:text-left max-w-md">
          <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/10 border border-white/10 text-white/80 text-[12px] font-mono font-semibold">
            <span class="w-1.5 h-1.5 rounded-full bg-android animate-pulse"></span>
            Weekly digest · 68,400+ subscribers
          </span>
          <h2 class="mt-5 text-[26px] sm:text-[32px] font-bold tracking-tight text-white text-balance leading-[1.15]">
            New releases, straight to your inbox
          </h2>
          <p class="mt-3 text-white/55 text-[14.5px] leading-relaxed">
            One short email a week — hand-picked updates across Windows, Mac, and Android. No spam, unsubscribe anytime.
          </p>
        </div>

        <div class="w-full max-w-sm shrink-0">
          <form action="{{ route('newsletter.store') }}" method="POST"
      class="flex flex-col gap-3 p-1.5 rounded-2xl bg-white/[0.04] border border-white/10">

    @csrf

    <label class="relative block">
        <span class="sr-only">Email address</span>

        <svg class="absolute left-4 top-1/2 -translate-y-1/2 text-white/40"
             width="16" height="16" viewBox="0 0 24 24" fill="none">
            <path d="M3 6L12 13L21 6"
                  stroke="currentColor"
                  stroke-width="1.8"
                  stroke-linecap="round"
                  stroke-linejoin="round"/>
            <rect x="3" y="4" width="18" height="16" rx="2.5"
                  stroke="currentColor"
                  stroke-width="1.8"/>
        </svg>

        <input
            type="email"
            name="email"
            value="{{ old('email') }}"
            required
            placeholder="you@email.com"
            class="w-full h-12 pl-11 pr-4 rounded-xl bg-white/[0.07] border border-white/15 text-white placeholder:text-white/35 text-[14px] outline-none focus:bg-white/[0.1] focus:border-white/30 transition-colors"
        />
    </label>

    <button
        type="submit"
        class="submit-btn h-12 px-6 rounded-xl bg-white text-ink text-[14px] font-semibold hover:bg-brand hover:text-white transition-colors shadow-[0_10px_24px_-8px_rgba(255,255,255,0.25)]">
        Subscribe
    </button>

</form>
          <p class="mt-3 text-[11.5px] text-white/35 font-mono text-center lg:text-left">No spam, ever. Unsubscribe in one click.</p>
        </div>
      </div>
    </div>
  </div>
</section>
<footer class="relative bg-surface dark:bg-dsurface border-t border-line dark:border-white/10">
  <!-- hairline accent so the footer reads as a distinct, deliberate block under the newsletter -->
  <div class="h-px w-full bg-gradient-to-r from-transparent via-line dark:via-white/15 to-transparent"></div>

  <div class="max-w-7xl mx-auto px-5 sm:px-8 pt-14 pb-10">

    <div class="grid grid-cols-2 sm:grid-cols-5 gap-x-8 gap-y-10 pb-10 border-b border-line dark:border-white/10">

      <div class="col-span-2 sm:col-span-2">
        <a href="#" class="flex items-center gap-2.5">
          <span class="w-9 h-9 rounded-lg bg-ink dark:bg-white flex items-center justify-center">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" class="dark:hidden"><path d="M12 2L21 7V17L12 22L3 17V7L12 2Z" stroke="white" stroke-width="1.8" stroke-linejoin="round"/><path d="M12 12L21 7M12 12V22M12 12L3 7" stroke="white" stroke-width="1.8" stroke-linejoin="round"/></svg>
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" class="hidden dark:block"><path d="M12 2L21 7V17L12 22L3 17V7L12 2Z" stroke="#0B0D12" stroke-width="1.8" stroke-linejoin="round"/><path d="M12 12L21 7M12 12V22M12 12L3 7" stroke="#0B0D12" stroke-width="1.8" stroke-linejoin="round"/></svg>
          </span>
          <span class="text-[17px] font-bold tracking-tight">Filedesk</span>
        </a>
        <p class="mt-3.5 text-[13.5px] text-sub dark:text-dsub leading-relaxed max-w-[260px]">
          A faster, cleaner way to find trusted software for every platform — scanned, mirrored, and ready to install.
        </p>
        <div class="flex items-center gap-2 mt-5">
          <a href="#" aria-label="X" class="footer-social w-9 h-9 rounded-lg bg-white dark:bg-white/5 border border-line dark:border-white/10 flex items-center justify-center text-sub dark:text-dsub hover:text-white hover:bg-ink dark:hover:bg-white dark:hover:text-ink hover:border-ink dark:hover:border-white">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M18.9 2H22L14.5 10.6L23.3 22H16.4L11 15.1L4.8 22H1.7L9.7 12.8L1.3 2H8.4L13.3 8.3L18.9 2ZM17.7 20H19.6L7 3.9H5L17.7 20Z"/></svg>
          </a>
          <a href="#" aria-label="GitHub" class="footer-social w-9 h-9 rounded-lg bg-white dark:bg-white/5 border border-line dark:border-white/10 flex items-center justify-center text-sub dark:text-dsub hover:text-white hover:bg-ink dark:hover:bg-white dark:hover:text-ink hover:border-ink dark:hover:border-white">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.5 2 2 6.6 2 12.3C2 16.8 4.9 20.6 8.9 22C9.4 22.1 9.6 21.8 9.6 21.5V19.5C6.7 20.1 6.1 18 6.1 18C5.6 16.8 4.9 16.4 4.9 16.4C3.9 15.7 5 15.7 5 15.7C6.1 15.8 6.7 16.9 6.7 16.9C7.7 18.6 9.3 18.1 9.9 17.8C10 17.1 10.3 16.6 10.6 16.3C8.3 16.1 5.9 15.2 5.9 11.2C5.9 10.1 6.3 9.1 7 8.4C6.9 8.1 6.5 6.9 7.1 5.4C7.1 5.4 8 5.1 9.9 6.4C10.7 6.2 11.5 6.1 12.3 6.1C13.1 6.1 13.9 6.2 14.7 6.4C16.6 5.1 17.5 5.4 17.5 5.4C18.1 6.9 17.7 8.1 17.6 8.4C18.3 9.1 18.7 10.1 18.7 11.2C18.7 15.2 16.3 16.1 14 16.3C14.4 16.7 14.7 17.4 14.7 18.4V21.5C14.7 21.8 14.9 22.1 15.4 22C19.4 20.6 22.3 16.8 22.3 12.3C22 6.6 17.5 2 12 2Z"/></svg>
          </a>
        </div>
      </div>

      <div>
        <h4 class="text-[11.5px] font-semibold text-ink dark:text-white font-mono uppercase tracking-wide">Platforms</h4>
        <ul class="mt-4 space-y-2.5">
          <li><a href="#windows" class="footer-link text-[13.5px] text-sub hover:text-ink dark:text-dsub dark:hover:text-white">Windows</a></li>
          <li><a href="#macos" class="footer-link text-[13.5px] text-sub hover:text-ink dark:text-dsub dark:hover:text-white">Mac</a></li>
          <li><a href="#android" class="footer-link text-[13.5px] text-sub hover:text-ink dark:text-dsub dark:hover:text-white">Android</a></li>
          <li><a href="#" class="footer-link text-[13.5px] text-sub hover:text-ink dark:text-dsub dark:hover:text-white">Games</a></li>
        </ul>
      </div>

      <div>
        <h4 class="text-[11.5px] font-semibold text-ink dark:text-white font-mono uppercase tracking-wide">Company</h4>
        <ul class="mt-4 space-y-2.5">
          <li><a href="#" class="footer-link text-[13.5px] text-sub hover:text-ink dark:text-dsub dark:hover:text-white">About</a></li>
          <li><a href="#" class="footer-link text-[13.5px] text-sub hover:text-ink dark:text-dsub dark:hover:text-white">Blog</a></li>
          <li><a href="#" class="footer-link text-[13.5px] text-sub hover:text-ink dark:text-dsub dark:hover:text-white">Contact</a></li>
        </ul>
      </div>

      <div>
        <h4 class="text-[11.5px] font-semibold text-ink dark:text-white font-mono uppercase tracking-wide">Legal</h4>
        <ul class="mt-4 space-y-2.5">
          <li><a href="#" class="footer-link text-[13.5px] text-sub hover:text-ink dark:text-dsub dark:hover:text-white">Privacy</a></li>
          <li><a href="#" class="footer-link text-[13.5px] text-sub hover:text-ink dark:text-dsub dark:hover:text-white">Terms</a></li>
          <li><a href="#" class="footer-link text-[13.5px] text-sub hover:text-ink dark:text-dsub dark:hover:text-white">DMCA</a></li>
        </ul>
      </div>

    </div>

    <div class="pt-6 flex flex-col sm:flex-row items-center justify-between gap-3">
      <p class="text-[12px] text-faint dark:text-dsub/70 font-mono">© 2026 Filedesk. All rights reserved.</p>
      <p class="text-[12px] text-faint dark:text-dsub/70 font-mono">Built for people who just want the app to work.</p>
    </div>

  </div>
</footer>
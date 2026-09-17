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

  button, .cat-pill, .submit-btn { -webkit-tap-highlight-color: transparent; }
  button:active, .submit-btn:active { transform: scale(.95); }

  @keyframes fadeUp { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
  .fade-up { animation: fadeUp .6s cubic-bezier(.16,1,.3,1) both; }

  @media (prefers-reduced-motion: reduce) {
    .app-row, .icon-tile, .dl-btn, button, .cat-pill { transition: none !important; }
    .fade-up { animation: none !important; }
  }

  .glass { background: rgba(255,255,255,0.86); backdrop-filter: blur(14px) saturate(180%); -webkit-backdrop-filter: blur(14px) saturate(180%); }

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

<x-basic.navbar/>

<section id="windows" class="pt-10 pb-16 sm:pt-12 sm:pb-20">
  <div class="section-banner text-white flex items-center justify-between gap-4 mb-8 w-full bg-gradient-to-r from-win-dark to-[#094a89] px-5 sm:px-8 py-5 sm:py-6">
    <div class="max-w-7xl mx-auto w-full flex items-center justify-between gap-4">
      <div class="flex items-center gap-4">
        <span class="w-1 self-stretch rounded-full bg-white/70 shrink-0"></span>
        <span class="w-10 h-10 rounded-xl bg-white/15 flex items-center justify-center shrink-0">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M3 5.5L10.5 4.5V11.3H3V5.5Z" fill="white"/><path d="M11.5 4.4L21 3V11.2H11.5V4.4Z" fill="white"/><path d="M3 12.3H10.5V19.1L3 18.1V12.3Z" fill="white"/><path d="M11.5 12.3H21V20.5L11.5 19.2V12.3Z" fill="white"/></svg>
        </span>
        <div>
          <p class="text-[10.5px] font-mono font-semibold uppercase tracking-widest text-white/50">Platform</p>
          <h2 class="text-xl sm:text-2xl font-bold tracking-tight text-white leading-tight">Windows Software</h2>
          <p class="text-[13px] text-white/70 mt-0.5">Handpicked tools that run clean on Windows 10 &amp; 11</p>
        </div>
      </div>
      <a href="#" class="hidden sm:flex items-center gap-1.5 text-[13.5px] font-semibold text-white/80 hover:text-white transition-colors shrink-0 group">
        View all <svg width="14" height="14" viewBox="0 0 24 24" fill="none" class="transition-transform group-hover:translate-x-0.5"><path d="M9 6L15 12L9 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
      </a>
    </div>
  </div>
  @foreach($softwares->where('category.name', 'Windows') as $software)

<a href="{{ route('detail', $software->slug) }}">
  <div class="max-w-7xl mx-auto px-5 sm:px-8 flex flex-col gap-3">
    <article class="app-row glow-win flex items-center gap-3 sm:gap-4 bg-white dark:bg-dcard border border-line dark:border-dline rounded-xl px-3 py-2.5 sm:px-4 sm:py-3 cursor-pointer shadow-card dark:shadow-none">
@if($software->icon)
    <img
        src="{{ asset('storage/' . $software->icon) }}"
        alt="{{ $software->title }}"
class="w-28 h-28 rounded-2xl object-cover shadow-lg shrink-0"    >
@else
    <span class="icon-tile w-11 h-11 sm:w-12 sm:h-12 rounded-lg bg-gradient-to-br from-win to-blue-700 flex items-center justify-center text-white font-bold shrink-0 text-[13px]">
        {{ strtoupper(substr($software->title, 0, 2)) }}
    </span>
@endif      <div class="min-w-0 flex-1">
        <h3 class="font-bold text-[14px] sm:text-[14.5px] text-ink dark:text-white truncate">{{ $software->title }}</h3>
        <p class="text-[12px] text-faint dark:text-dsub mt-0.5 truncate">{{ $software->short_description }}</p>
        <span class="tag-chip inline-block mt-1.5 text-[10px] font-semibold px-2 py-0.5 rounded-full bg-win-light dark:bg-white/10 text-win dark:text-white/85">{{ $software->subcategory->name }}</span>
      </div>
      <span class="hidden md:block w-px h-9 bg-line dark:bg-dline shrink-0"></span>
      <div class="hidden md:flex flex-col items-center justify-center gap-1 w-[100px] shrink-0">
        <span class="flex items-center gap-1.5 text-[12px] font-semibold text-win"><svg width="11" height="11" viewBox="0 0 24 24" fill="none"><path d="M3 5.5L10.5 4.5V11.3H3V5.5Z" fill="currentColor"/><path d="M11.5 4.4L21 3V11.2H11.5V4.4Z" fill="currentColor"/><path d="M3 12.3H10.5V19.1L3 18.1V12.3Z" fill="currentColor"/><path d="M11.5 12.3H21V20.5L11.5 19.2V12.3Z" fill="currentColor"/></svg> {{ $software->category->name }}</span>
        <span class="text-[11px] font-mono text-faint dark:text-dsub">{{ $software->downloads_count }}k Downloads</span>
      </div>
      <span class="hidden sm:block w-px h-9 bg-line dark:bg-dline shrink-0"></span>
      <div class="hidden sm:flex flex-col items-center justify-center gap-0.5 w-[84px] shrink-0 rounded-lg bg-amber-50 dark:bg-amber-400/10 py-1.5">
        <span class="text-[9px] font-semibold uppercase tracking-wider text-amber-500/80 dark:text-amber-300/80">Rating</span>
        <span class="flex items-center gap-1 text-[12.5px] font-bold text-amber-500"><span class="star">★★★★★</span></span>
        <span class="text-[10px] font-mono text-amber-600/70 dark:text-amber-300/70">{{ $software->rating }}</span>
      </div>
      <button class="dl-btn dl-win h-9 px-4 sm:px-5 rounded-lg bg-surface dark:bg-white/10 text-ink dark:text-white text-[13px] font-semibold shrink-0">Download</button>
    </article>


  </div>
  </a>
  @endforeach
</section>

<section id="macos" class="bg-surface dark:bg-dsurface border-y border-line dark:border-dline py-16 sm:py-20">
  <div class="section-banner text-white flex items-center justify-between gap-4 mb-8 w-full bg-gradient-to-r from-mac-dark to-[#141519] px-5 sm:px-8 py-5 sm:py-6">
    <div class="max-w-7xl mx-auto w-full flex items-center justify-between gap-4">
      <div class="flex items-center gap-4">
        <span class="w-1 self-stretch rounded-full bg-white/70 shrink-0"></span>
        <span class="w-10 h-10 rounded-xl bg-white/15 flex items-center justify-center shrink-0">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M16.5 2.5C16.7 3.7 16.2 4.9 15.5 5.8C14.7 6.7 13.4 7.4 12.2 7.3C12 6.1 12.6 4.9 13.3 4.1C14.1 3.2 15.4 2.5 16.5 2.5Z" fill="white"/><path d="M20.5 17.6C20 18.9 19.5 20 18.7 21C17.9 22 17.1 23 15.9 23C14.8 23 14.4 22.3 13.1 22.3C11.8 22.3 11.3 23 10.3 23C9.1 23 8.2 21.9 7.4 20.9C5.7 18.7 4.3 14.9 6.1 12.3C7 11 8.5 10.2 10 10.2C11.2 10.2 12 11 12.9 11C13.8 11 14.4 10.2 15.9 10.2C17.2 10.2 18.6 10.9 19.5 12.1C16.9 13.5 17.3 17 20.5 17.6Z" fill="white"/></svg>
        </span>
        <div>
          <p class="text-[10.5px] font-mono font-semibold uppercase tracking-widest text-white/50">Platform</p>
          <h2 class="text-xl sm:text-2xl font-bold tracking-tight text-white leading-tight">Mac Software</h2>
          <p class="text-[13px] text-white/70 mt-0.5">Native-feeling apps for Apple Silicon &amp; Intel</p>
        </div>
      </div>
      <a href="#" class="hidden sm:flex items-center gap-1.5 text-[13.5px] font-semibold text-white/80 hover:text-white transition-colors shrink-0 group">
        View all <svg width="14" height="14" viewBox="0 0 24 24" fill="none" class="transition-transform group-hover:translate-x-0.5"><path d="M9 6L15 12L9 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
      </a>
    </div>
  </div>
@foreach($softwares->where('category.name', 'MacOS') as $software)
<a href="{{ route('detail', $software->slug) }}">
  <div class="max-w-7xl mx-auto px-5 sm:px-8">
    <div class="flex flex-col gap-3">
      <article class="app-row glow-mac flex items-center gap-3 sm:gap-4 bg-white dark:bg-dcard border border-line dark:border-dline rounded-xl px-3 py-2.5 sm:px-4 sm:py-3 cursor-pointer shadow-card dark:shadow-none">
@if($software->icon)
    <img
        src="{{ asset('storage/' . $software->icon) }}"
        alt="{{ $software->title }}"
class="w-28 h-28 rounded-2xl object-cover shadow-lg shrink-0"    >
@else   
  <span class="icon-tile w-11 h-11 sm:w-12 sm:h-12 rounded-lg bg-gradient-to-br from-win to-blue-700 flex items-center justify-center text-white font-bold shrink-0 text-[13px]">
        {{ strtoupper(substr($software->title, 0, 2)) }}
    </span>
@endif
   <div class="min-w-0 flex-1">
        <h3 class="font-bold text-[14px] sm:text-[14.5px] text-ink dark:text-white truncate">{{ $software->title }}</h3>
        <p class="text-[12px] text-faint dark:text-dsub mt-0.5 truncate">{{ $software->short_description }}</p>
        <span class="tag-chip inline-block mt-1.5 text-[10px] font-semibold px-2 py-0.5 rounded-full bg-mac-light dark:bg-white/10 text-mac dark:text-white/85">{{ $software->subcategory->name }}</span>
      </div>
      <span class="hidden md:block w-px h-9 bg-line dark:bg-dline shrink-0"></span>
      <div class="hidden md:flex flex-col items-center justify-center gap-1 w-[100px] shrink-0">
        <span class="flex items-center gap-1.5 text-[12px] font-semibold text-mac dark:text-dtext"><svg width="11" height="11" viewBox="0 0 24 24" fill="none"><path d="M16.5 2.5C16.7 3.7 16.2 4.9 15.5 5.8C14.7 6.7 13.4 7.4 12.2 7.3C12 6.1 12.6 4.9 13.3 4.1C14.1 3.2 15.4 2.5 16.5 2.5Z" fill="currentColor"/><path d="M20.5 17.6C20 18.9 19.5 20 18.7 21C17.9 22 17.1 23 15.9 23C14.8 23 14.4 22.3 13.1 22.3C11.8 22.3 11.3 23 10.3 23C9.1 23 8.2 21.9 7.4 20.9C5.7 18.7 4.3 14.9 6.1 12.3C7 11 8.5 10.2 10 10.2C11.2 10.2 12 11 12.9 11C13.8 11 14.4 10.2 15.9 10.2C17.2 10.2 18.6 10.9 19.5 12.1C16.9 13.5 17.3 17 20.5 17.6Z" fill="currentColor"/></svg>{{ $software->category->name }}</span>
        <span class="text-[11px] font-mono text-faint dark:text-dsub">{{ $software->downloads_count }}k downloads</span>
      </div>
      <span class="hidden sm:block w-px h-9 bg-line dark:bg-dline shrink-0"></span>
      <div class="hidden sm:flex flex-col items-center justify-center gap-0.5 w-[84px] shrink-0 rounded-lg bg-amber-50 dark:bg-amber-400/10 py-1.5">
        <span class="text-[9px] font-semibold uppercase tracking-wider text-amber-500/80 dark:text-amber-300/80">Rating</span>
        <span class="flex items-center gap-1 text-[12.5px] font-bold text-amber-500"><span class="star">★★★★★</span></span>
        <span class="text-[10px] font-mono text-amber-600/70 dark:text-amber-300/70">{{ $software->rating }}</span>
      </div>
      <button class="dl-btn dl-mac h-9 px-4 sm:px-5 rounded-lg bg-surface dark:bg-white/10 text-ink dark:text-white text-[13px] font-semibold shrink-0">Get</button>
    </article>
    </div>
  </div>
  </a>
  @endforeach
</section>

<section id="android" class="py-16 sm:py-20">
  <div class="section-banner text-white flex items-center justify-between gap-4 mb-8 w-full bg-gradient-to-r from-android-dark to-[#146641] px-5 sm:px-8 py-5 sm:py-6">
    <div class="max-w-7xl mx-auto w-full flex items-center justify-between gap-4">
      <div class="flex items-center gap-4">
        <span class="w-1 self-stretch rounded-full bg-white/70 shrink-0"></span>
        <span class="w-10 h-10 rounded-xl bg-white/15 flex items-center justify-center shrink-0">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M6 9.5V17C6 17.6 6.4 18 7 18H8V21C8 21.6 8.4 22 9 22C9.6 22 10 21.6 10 21V18H14V21C14 21.6 14.4 22 15 22C15.6 22 16 21.6 16 21V18H17C17.6 18 18 17.6 18 17V9.5H6Z" fill="white"/><path d="M6.5 8.5H17.5C17.3 6.5 16.1 4.8 14.4 3.9L15.3 2.3C15.4 2.1 15.3 1.9 15.2 1.8C15 1.7 14.8 1.8 14.7 1.9L13.7 3.6C12.9 3.3 12 3.1 11 3.1C10 3.1 9.1 3.3 8.3 3.6L7.3 1.9C7.2 1.8 7 1.7 6.8 1.8C6.7 1.9 6.6 2.1 6.7 2.3L7.6 3.9C5.9 4.8 6.7 6.5 6.5 8.5Z" fill="white"/><rect x="3.5" y="9.5" width="1.8" height="6.5" rx="0.9" fill="white"/><rect x="18.7" y="9.5" width="1.8" height="6.5" rx="0.9" fill="white"/></svg>
        </span>
        <div>
          <p class="text-[10.5px] font-mono font-semibold uppercase tracking-widest text-white/50">Platform</p>
          <h2 class="text-xl sm:text-2xl font-bold tracking-tight text-white leading-tight">Android Apps</h2>
          <p class="text-[13px] text-white/70 mt-0.5">APKs scanned for malware, mirrored for speed</p>
        </div>
      </div>
      <a href="#" class="hidden sm:flex items-center gap-1.5 text-[13.5px] font-semibold text-white/80 hover:text-white transition-colors shrink-0 group">
        View all <svg width="14" height="14" viewBox="0 0 24 24" fill="none" class="transition-transform group-hover:translate-x-0.5"><path d="M9 6L15 12L9 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
      </a>
    </div>
  </div>
@foreach($softwares->where('category.name', 'Android') as $software)
  <a href="{{ route('detail', $software->slug) }}">
  <div class="max-w-7xl mx-auto px-5 sm:px-8 flex flex-col gap-3">

    <article class="app-row glow-android flex items-center gap-3 sm:gap-4 bg-white dark:bg-dcard border border-line dark:border-dline rounded-xl px-3 py-2.5 sm:px-4 sm:py-3 cursor-pointer shadow-card dark:shadow-none">
@if($software->icon)
    <img
        src="{{ asset('storage/' . $software->icon) }}"
        alt="{{ $software->title }}"
class="w-28 h-28 rounded-2xl object-cover shadow-lg shrink-0"    >
@else   
  <span class="icon-tile w-11 h-11 sm:w-12 sm:h-12 rounded-lg bg-gradient-to-br from-win to-blue-700 flex items-center justify-center text-white font-bold shrink-0 text-[13px]">
        {{ strtoupper(substr($software->title, 0, 2)) }}
    </span>
@endif      <div class="min-w-0 flex-1">
        <h3 class="font-bold text-[14px] sm:text-[14.5px] text-ink dark:text-white truncate">{{ $software->title }}</h3>
        <p class="text-[12px] text-faint dark:text-dsub mt-0.5 truncate">{{ $software->short_description }}</p>
        <span class="tag-chip inline-block mt-1.5 text-[10px] font-semibold px-2 py-0.5 rounded-full bg-android-light dark:bg-white/10 text-android dark:text-white/85">{{ $software->category->name }}</span>
      </div>
      <span class="hidden md:block w-px h-9 bg-line dark:bg-dline shrink-0"></span>
      <div class="hidden md:flex flex-col items-center justify-center gap-1 w-[100px] shrink-0">
        <span class="flex items-center gap-1.5 text-[12px] font-semibold text-android"><svg width="11" height="11" viewBox="0 0 24 24" fill="none"><path d="M6 9.5V17C6 17.6 6.4 18 7 18H8V21C8 21.6 8.4 22 9 22C9.6 22 10 21.6 10 21V18H14V21C14 21.6 14.4 22 15 22C15.6 22 16 21.6 16 21V18H17C17.6 18 18 17.6 18 17V9.5H6Z" fill="currentColor"/><path d="M6.5 8.5H17.5C17.3 6.5 16.1 4.8 14.4 3.9L15.3 2.3C15.4 2.1 15.3 1.9 15.2 1.8C15 1.7 14.8 1.8 14.7 1.9L13.7 3.6C12.9 3.3 12 3.1 11 3.1C10 3.1 9.1 3.3 8.3 3.6L7.3 1.9C7.2 1.8 7 1.7 6.8 1.8C6.7 1.9 6.6 2.1 6.7 2.3L7.6 3.9C5.9 4.8 6.7 6.5 6.5 8.5Z" fill="currentColor"/><rect x="3.5" y="9.5" width="1.8" height="6.5" rx="0.9" fill="currentColor"/><rect x="18.7" y="9.5" width="1.8" height="6.5" rx="0.9" fill="currentColor"/></svg> {{ $software->category->name }}</span>
        <span class="text-[11px] font-mono text-faint dark:text-dsub">{{ $software->downloads_count }}k Downloads</span>
      </div>
      <span class="hidden sm:block w-px h-9 bg-line dark:bg-dline shrink-0"></span>
      <div class="hidden sm:flex flex-col items-center justify-center gap-0.5 w-[84px] shrink-0 rounded-lg bg-amber-50 dark:bg-amber-400/10 py-1.5">
        <span class="text-[9px] font-semibold uppercase tracking-wider text-amber-500/80 dark:text-amber-300/80">Rating</span>
        <span class="flex items-center gap-1 text-[12.5px] font-bold text-amber-500"><span class="star">★★★★★</span></span>
        <span class="text-[10px] font-mono text-amber-600/70 dark:text-amber-300/70">{{ $software->rating }}</span>
      </div>
      <button class="dl-btn dl-android h-9 px-4 sm:px-5 rounded-lg bg-surface dark:bg-white/10 text-ink dark:text-white text-[13px] font-semibold shrink-0">Install</button>
    </article>

    

  </div>
</a>
@endforeach
</section>



<x-basic.footer />

<script>
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
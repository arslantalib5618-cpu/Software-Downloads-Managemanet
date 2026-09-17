<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Dashboard — Filedesk Admin</title>

<!--
  NOTE FOR LARAVEL INTEGRATION
  This file is a self-contained preview. When wiring into the existing
  Laravel layout: keep the <style> block (or move it to a compiled
  admin.css), drop the Tailwind CDN script (already compiled in the app
  layout), and lift everything inside <body> into your
  @extends('layouts.admin') / @section('content') files. The three
  regions are clearly commented below: SIDEBAR, HEADER, MAIN CONTENT.
-->

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
          gold: { DEFAULT: '#C8A030', light: '#FBF3DC', dark: '#9C7B1F' },
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
  body { font-family: 'Inter', sans-serif; }
  .font-mono { font-family: 'JetBrains Mono', monospace; }
  ::-webkit-scrollbar { height: 8px; width: 8px; }
  ::-webkit-scrollbar-thumb { background: #D9DCE3; border-radius: 8px; }
  ::-webkit-scrollbar-track { background: transparent; }
  .sidebar::-webkit-scrollbar { width: 6px; }
  .sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.12); border-radius: 8px; }

  /* ============ Sidebar ============ */
  .sidebar {
    background: #0B0D12;
    transition: transform .35s cubic-bezier(.16,1,.3,1);
  }
  .side-link {
    position: relative;
    transition: background-color .2s ease, color .2s ease, transform .2s ease;
  }
  .side-link::before {
    content: '';
    position: absolute;
    left: 0; top: 8px; bottom: 8px;
    width: 3px;
    border-radius: 0 3px 3px 0;
    background: #C8A030;
    opacity: 0;
    transform: scaleY(.4);
    transform-origin: center;
    transition: opacity .25s ease, transform .3s cubic-bezier(.16,1,.3,1);
  }
  .side-link:hover { background: rgba(255,255,255,0.05); color: #fff; }
  .side-link:hover::before { opacity: .5; transform: scaleY(1); }
  .side-link.active { background: rgba(200,160,48,0.12); color: #fff; }
  .side-link.active::before { opacity: 1; transform: scaleY(1); }
  .side-link.active .side-icon { background: rgba(200,160,48,0.18); color: #E8C568; }
  .side-icon { transition: background-color .2s ease, color .2s ease; }

  /* ============ Cards & rows (same language as the frontend) ============ */
  .stat-card, .qa-card, .panel-card {
    transition: border-color .25s ease, box-shadow .35s cubic-bezier(.16,1,.3,1), transform .3s cubic-bezier(.16,1,.3,1);
  }
  .stat-card:hover, .qa-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 20px 40px -16px rgba(15,17,23,0.14), 0 6px 16px -6px rgba(15,17,23,0.06);
  }
  .icon-tile { transition: transform .35s cubic-bezier(.16,1,.3,1); }
  .stat-card:hover .icon-tile, .qa-card:hover .icon-tile { transform: scale(1.06) rotate(-2deg); }

  .table-row { transition: background-color .2s ease; }
  .table-row:hover { background-color: #F7F8FA; }

  .act-btn { transition: background-color .2s ease, color .2s ease, transform .15s ease; }
  .act-btn:active { transform: scale(.9); }

  .dropdown-menu {
    opacity: 0; visibility: hidden; transform: translateY(-6px);
    transition: opacity .18s ease, transform .18s cubic-bezier(.16,1,.3,1), visibility .18s;
  }
  .dropdown-menu.open { opacity: 1; visibility: visible; transform: translateY(0); }

  .timeline-item { position: relative; padding-left: 2rem; }
  .timeline-item::before {
    content: '';
    position: absolute; left: 11px; top: 28px; bottom: -20px;
    width: 1.5px; background: #E7E9ED;
  }
  .timeline-item:last-child::before { display: none; }
  .timeline-dot {
    position: absolute; left: 0; top: 2px;
    width: 24px; height: 24px; border-radius: 9999px;
    display: flex; align-items: center; justify-content: center;
  }

  button, a, .side-link { -webkit-tap-highlight-color: transparent; }

  @media (prefers-reduced-motion: reduce) {
    .sidebar, .side-link, .stat-card, .qa-card, .icon-tile, .dropdown-menu { transition: none !important; }
  }

  @media (max-width: 1023px) {
    .sidebar { position: fixed; z-index: 50; transform: translateX(-100%); }
    .sidebar.open { transform: translateX(0); }
  }
</style>
</head>

<body class="antialiased bg-surface text-ink">

<div class="flex min-h-screen">

  <!-- ================= SIDEBAR ================= -->
  <aside id="sidebar" class="sidebar w-[260px] shrink-0 h-screen lg:sticky top-0 flex flex-col overflow-y-auto">

    <!-- Brand -->
    <div class="flex items-center gap-2.5 px-6 h-[68px] shrink-0 border-b border-white/[0.07]">
      <span class="w-9 h-9 rounded-xl bg-gradient-to-br from-gold to-gold-dark flex items-center justify-center shrink-0 shadow-card">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M12 2L20 6.5V17.5L12 22L4 17.5V6.5L12 2Z" stroke="white" stroke-width="1.8" stroke-linejoin="round"/><path d="M9 11.5L11.2 13.7L15.5 9" stroke="white" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
      </span>
      <div class="min-w-0">
        <p class="text-[14.5px] font-extrabold text-white tracking-tight leading-tight truncate">Filedesk</p>
        <p class="text-[10.5px] font-mono text-white/40 leading-tight">Admin Panel</p>
      </div>
    </div>

    <!-- Nav -->
    <nav class="flex-1 px-3 py-5 flex flex-col gap-1">
      <p class="px-3 mb-2 text-[10.5px] font-bold uppercase tracking-wider text-white/30">Main</p>

      <a href="#" class="side-link active flex items-center gap-3 px-3 py-2.5 rounded-xl text-white/70 text-[13.5px] font-semibold">
        <span class="side-icon w-8 h-8 rounded-lg bg-white/[0.06] flex items-center justify-center shrink-0">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><rect x="3" y="3" width="8" height="8" rx="1.6" stroke="currentColor" stroke-width="1.8"/><rect x="13" y="3" width="8" height="8" rx="1.6" stroke="currentColor" stroke-width="1.8"/><rect x="3" y="13" width="8" height="8" rx="1.6" stroke="currentColor" stroke-width="1.8"/><rect x="13" y="13" width="8" height="8" rx="1.6" stroke="currentColor" stroke-width="1.8"/></svg>
        </span>
        <span>Dashboard</span>
      </a>

      <a href="#" class="side-link flex items-center gap-3 px-3 py-2.5 rounded-xl text-white/70 text-[13.5px] font-semibold">
        <span class="side-icon w-8 h-8 rounded-lg bg-white/[0.06] flex items-center justify-center shrink-0">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M6 3L18 3L21 8V19C21 20.1 20.1 21 19 21H5C3.9 21 3 20.1 3 19V8L6 3Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/><path d="M3 8H21" stroke="currentColor" stroke-width="1.8"/></svg>
        </span>
        <span>All Software</span>
      </a>

      <a href="#" class="side-link flex items-center gap-3 px-3 py-2.5 rounded-xl text-white/70 text-[13.5px] font-semibold">
        <span class="side-icon w-8 h-8 rounded-lg bg-white/[0.06] flex items-center justify-center shrink-0">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M3 6L12 13L21 6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/><rect x="3" y="4" width="18" height="16" rx="2.5" stroke="currentColor" stroke-width="1.8"/></svg>
        </span>
        <span>Newsletter</span>
      </a>
    </nav>

    <!-- Sidebar footer -->
    <div class="p-4 mx-3 mb-4 rounded-xl bg-white/[0.04] border border-white/[0.06]">
      <p class="text-[11.5px] font-semibold text-white/70">Storage used</p>
      <div class="mt-2 h-1.5 rounded-full bg-white/10 overflow-hidden">
        <div class="h-full w-[62%] rounded-full bg-gradient-to-r from-gold to-gold-dark"></div>
      </div>
      <p class="mt-1.5 text-[10.5px] font-mono text-white/35">62% · 310GB of 500GB</p>
    </div>
  </aside>

  <!-- Mobile overlay -->
  <div id="sidebarOverlay" class="fixed inset-0 bg-ink/50 z-40 hidden lg:hidden"></div>

  <!-- ================= MAIN WRAPPER ================= -->
  <div class="flex-1 min-w-0 flex flex-col">

    <!-- ================= HEADER ================= -->
    <header class="sticky top-0 z-30 bg-white/95 backdrop-blur border-b border-line">
      <div class="h-[68px] px-4 sm:px-6 flex items-center gap-3 sm:gap-4">

        <!-- Mobile menu toggle -->
        <button id="menuToggle" class="lg:hidden w-9 h-9 rounded-lg border border-line flex items-center justify-center text-sub shrink-0">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M4 6H20M4 12H20M4 18H20" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
        </button>

        <!-- Title + breadcrumb -->
        <div class="min-w-0 shrink-0">
          <h1 class="text-[15.5px] sm:text-[17px] font-extrabold text-ink tracking-tight leading-tight">Dashboard</h1>
          <nav class="hidden sm:flex items-center gap-1.5 text-[11.5px] text-faint">
            <span>Admin</span>
            <svg width="10" height="10" viewBox="0 0 24 24" fill="none"><path d="M9 6L15 12L9 18" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            <span class="text-ink font-medium">Dashboard</span>
          </nav>
        </div>

        <!-- Search -->
        <div class="hidden md:block flex-1 max-w-md ml-2">
          <label class="relative block">
            <span class="sr-only">Search</span>
            <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 text-faint" width="15" height="15" viewBox="0 0 24 24" fill="none"><circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2"/><path d="M21 21L16.5 16.5" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
            <input type="text" placeholder="Search software, users…" class="w-full h-10 pl-10 pr-3 rounded-lg bg-surface border border-line text-[13px] text-ink placeholder:text-faint outline-none focus:border-brand/50 focus:bg-white transition-colors" />
          </label>
        </div>

        <div class="flex-1 md:flex-none"></div>

        <!-- Notifications -->
        <div class="relative shrink-0">
          <button id="notifBtn" class="relative w-9 h-9 rounded-lg border border-line flex items-center justify-center text-sub hover:bg-surface transition-colors">
            <svg width="17" height="17" viewBox="0 0 24 24" fill="none"><path d="M12 3C9.24 3 7 5.24 7 8V11.5L5.2 14.6C4.9 15.1 5.26 15.75 5.84 15.75H18.16C18.74 15.75 19.1 15.1 18.8 14.6L17 11.5V8C17 5.24 14.76 3 12 3Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/><path d="M9.5 18.5C9.8 19.6 10.8 20.4 12 20.4C13.2 20.4 14.2 19.6 14.5 18.5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
            <span class="absolute top-1.5 right-1.5 w-2 h-2 rounded-full bg-gold ring-2 ring-white"></span>
          </button>
          <div id="notifMenu" class="dropdown-menu absolute right-0 mt-2 w-72 bg-white border border-line rounded-xl shadow-cardHover p-2 z-40">
            <p class="px-3 py-2 text-[11.5px] font-bold uppercase tracking-wide text-faint">Notifications</p>
            <a href="#" class="flex gap-3 px-3 py-2.5 rounded-lg hover:bg-surface transition-colors">
              <span class="w-8 h-8 rounded-lg bg-gold-light text-gold-dark flex items-center justify-center shrink-0"><svg width="14" height="14" viewBox="0 0 24 24" fill="none"><path d="M12 5V19M5 12H19" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg></span>
              <span class="min-w-0"><span class="block text-[12.5px] font-semibold text-ink">New software submitted</span><span class="block text-[11px] text-faint mt-0.5">CodeForge IDE v2.4 · 12m ago</span></span>
            </a>
            <a href="#" class="flex gap-3 px-3 py-2.5 rounded-lg hover:bg-surface transition-colors">
              <span class="w-8 h-8 rounded-lg bg-win-light text-win flex items-center justify-center shrink-0"><svg width="14" height="14" viewBox="0 0 24 24" fill="none"><path d="M3 6L12 13L21 6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/><rect x="3" y="4" width="18" height="16" rx="2.5" stroke="currentColor" stroke-width="1.8"/></svg></span>
              <span class="min-w-0"><span class="block text-[12.5px] font-semibold text-ink">42 new subscribers</span><span class="block text-[11px] text-faint mt-0.5">Newsletter · Today</span></span>
            </a>
            <a href="#" class="block text-center mt-1 px-3 py-2 rounded-lg text-[12px] font-semibold text-brand hover:bg-brand-light transition-colors">View all notifications</a>
          </div>
        </div>

        <!-- Profile dropdown -->
        <div class="relative shrink-0">
          <button id="profileBtn" class="flex items-center gap-2 pl-1.5 pr-2.5 py-1.5 rounded-lg border border-line hover:bg-surface transition-colors">
            <span class="w-7 h-7 rounded-full bg-gradient-to-br from-brand to-brand-dark flex items-center justify-center text-white text-[11.5px] font-bold shrink-0">AR</span>
            <span class="hidden sm:block text-[13px] font-semibold text-ink">Arjun</span>
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" class="text-faint"><path d="M6 9L12 15L18 9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </button>
          <div id="profileMenu" class="dropdown-menu absolute right-0 mt-2 w-56 bg-white border border-line rounded-xl shadow-cardHover p-1.5 z-40">
            <div class="px-3 py-2.5 border-b border-line mb-1">
              <p class="text-[13px] font-bold text-ink truncate">Arjun Rathore</p>
              <p class="text-[11.5px] text-faint truncate">admin@filedesk.com</p>
            </div>
            <a href="#" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-[12.5px] font-medium text-sub hover:bg-surface hover:text-ink transition-colors">
              <svg width="15" height="15" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="8" r="3.4" stroke="currentColor" stroke-width="1.8"/><path d="M4.5 20C5.6 16.6 8.5 14.5 12 14.5C15.5 14.5 18.4 16.6 19.5 20" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
              My Profile
            </a>
            <a href="#" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-[12.5px] font-medium text-sub hover:bg-surface hover:text-ink transition-colors">
              <svg width="15" height="15" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.8"/><path d="M19.4 13.5C19.5 13 19.5 12.5 19.4 12L21 10.5L19.5 8L17.6 8.6C17.2 8.2 16.7 7.9 16.2 7.7L15.8 5.7H12.2L11.8 7.7C11.3 7.9 10.8 8.2 10.4 8.6L8.5 8L7 10.5L8.6 12C8.5 12.5 8.5 13 8.6 13.5L7 15L8.5 17.5L10.4 16.9C10.8 17.3 11.3 17.6 11.8 17.8L12.2 19.8H15.8L16.2 17.8C16.7 17.6 17.2 17.3 17.6 16.9L19.5 17.5L21 15L19.4 13.5Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/></svg>
              Settings
            </a>
            <div class="h-px bg-line my-1"></div>
            <a href="#" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-[12.5px] font-medium text-red-500 hover:bg-red-50 transition-colors">
              <svg width="15" height="15" viewBox="0 0 24 24" fill="none"><path d="M9 21H5C3.9 21 3 20.1 3 19V5C3 3.9 3.9 3 5 3H9" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/><path d="M16 17L21 12L16 7" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/><path d="M21 12H9" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
              Log Out
            </a>
          </div>
        </div>
      </div>
    </header>

    <!-- ================= MAIN CONTENT ================= -->
    <main class="flex-1 p-4 sm:p-6 lg:p-8">

      <!-- Welcome row -->
      <div class="flex flex-wrap items-center justify-between gap-4 mb-6 sm:mb-8">
        <div>
          <h2 class="text-[19px] sm:text-[22px] font-extrabold tracking-tight text-ink">Welcome back, Arjun 👋</h2>
          <p class="mt-1 text-[13px] text-sub">Here's what's happening with your software directory today.</p>
        </div>
        <button class="flex items-center gap-2 h-10 px-4 rounded-xl bg-ink text-white text-[13px] font-semibold shadow-card hover:shadow-cardHover hover:-translate-y-0.5 transition-all">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none"><path d="M12 5V19M5 12H19" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/></svg>
          Add New Software
        </button>
      </div>

      <!-- Stats cards -->
      <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 sm:gap-5">

        <div class="stat-card bg-white border border-line rounded-2xl p-5 shadow-card">
          <div class="flex items-start justify-between">
            <span class="icon-tile w-11 h-11 rounded-xl bg-gradient-to-br from-brand to-brand-dark flex items-center justify-center shrink-0">
              <svg width="19" height="19" viewBox="0 0 24 24" fill="none"><path d="M6 3L18 3L21 8V19C21 20.1 20.1 21 19 21H5C3.9 21 3 20.1 3 19V8L6 3Z" stroke="white" stroke-width="1.8" stroke-linejoin="round"/><path d="M3 8H21" stroke="white" stroke-width="1.8"/></svg>
            </span>
            <span class="flex items-center gap-1 text-[11.5px] font-semibold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-full">
              <svg width="10" height="10" viewBox="0 0 24 24" fill="none"><path d="M4 15L10 9L14 13L20 6" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
              8.2%
            </span>
          </div>
          <p class="mt-4 text-[26px] font-extrabold text-ink font-mono tracking-tight">1,240</p>
          <p class="mt-1 text-[12.5px] text-sub">Total Software</p>
        </div>

        <div class="stat-card bg-white border border-line rounded-2xl p-5 shadow-card">
          <div class="flex items-start justify-between">
            <span class="icon-tile w-11 h-11 rounded-xl bg-gradient-to-br from-win to-win-dark flex items-center justify-center shrink-0">
              <svg width="19" height="19" viewBox="0 0 24 24" fill="none"><path d="M12 3V15M12 15L7 10M12 15L17 10" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M5 17V19C5 20.1 5.9 21 7 21H17C18.1 21 19 20.1 19 19V17" stroke="white" stroke-width="2" stroke-linecap="round"/></svg>
            </span>
            <span class="flex items-center gap-1 text-[11.5px] font-semibold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-full">
              <svg width="10" height="10" viewBox="0 0 24 24" fill="none"><path d="M4 15L10 9L14 13L20 6" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
              12.4%
            </span>
          </div>
          <p class="mt-4 text-[26px] font-extrabold text-ink font-mono tracking-tight">4.8M</p>
          <p class="mt-1 text-[12.5px] text-sub">Total Downloads</p>
        </div>

        <div class="stat-card bg-white border border-line rounded-2xl p-5 shadow-card">
          <div class="flex items-start justify-between">
            <span class="icon-tile w-11 h-11 rounded-xl bg-gradient-to-br from-fuchsia-500 to-purple-700 flex items-center justify-center shrink-0">
              <svg width="19" height="19" viewBox="0 0 24 24" fill="none"><path d="M2 12C4 7 8 4.5 12 4.5C16 4.5 20 7 22 12C20 17 16 19.5 12 19.5C8 19.5 4 17 2 12Z" stroke="white" stroke-width="1.8" stroke-linejoin="round"/><circle cx="12" cy="12" r="3" stroke="white" stroke-width="1.8"/></svg>
            </span>
            <span class="flex items-center gap-1 text-[11.5px] font-semibold text-red-500 bg-red-50 px-2 py-1 rounded-full">
              <svg width="10" height="10" viewBox="0 0 24 24" fill="none"><path d="M4 9L10 15L14 11L20 18" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
              2.1%
            </span>
          </div>
          <p class="mt-4 text-[26px] font-extrabold text-ink font-mono tracking-tight">982K</p>
          <p class="mt-1 text-[12.5px] text-sub">Total Views</p>
        </div>

        <div class="stat-card bg-white border border-line rounded-2xl p-5 shadow-card">
          <div class="flex items-start justify-between">
            <span class="icon-tile w-11 h-11 rounded-xl bg-gradient-to-br from-gold to-gold-dark flex items-center justify-center shrink-0">
              <svg width="19" height="19" viewBox="0 0 24 24" fill="none"><path d="M3 6L12 13L21 6" stroke="white" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/><rect x="3" y="4" width="18" height="16" rx="2.5" stroke="white" stroke-width="1.8"/></svg>
            </span>
            <span class="flex items-center gap-1 text-[11.5px] font-semibold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-full">
              <svg width="10" height="10" viewBox="0 0 24 24" fill="none"><path d="M4 15L10 9L14 13L20 6" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
              5.6%
            </span>
          </div>
          <p class="mt-4 text-[26px] font-extrabold text-ink font-mono tracking-tight">68,412</p>
          <p class="mt-1 text-[12.5px] text-sub">Newsletter Subscribers</p>
        </div>
      </div>

      <!-- Lower grid: table + sidebar column -->
      <div class="grid grid-cols-1 xl:grid-cols-3 gap-5 sm:gap-6 mt-6 sm:mt-8">

        <!-- Recent Software table -->
        <div class="panel-card xl:col-span-2 bg-white border border-line rounded-2xl shadow-card overflow-hidden">
          <div class="flex items-center justify-between px-5 sm:px-6 pt-5 sm:pt-6">
            <div>
              <h3 class="text-[15px] font-bold text-ink">Recent Software</h3>
              <p class="text-[12px] text-faint mt-0.5">Latest programs added to the directory</p>
            </div>
            <a href="#" class="text-[12.5px] font-semibold text-brand hover:text-brand-dark transition-colors">View all</a>
          </div>

          <div class="mt-4 overflow-x-auto">
            <table class="w-full min-w-[720px] text-left border-collapse">
              <thead>
                <tr class="text-[11px] font-bold uppercase tracking-wide text-faint border-y border-line">
                  <th class="px-5 sm:px-6 py-3 font-bold">Software</th>
                  <th class="px-3 py-3 font-bold">Category</th>
                  <th class="px-3 py-3 font-bold">Version</th>
                  <th class="px-3 py-3 font-bold">Downloads</th>
                  <th class="px-3 py-3 font-bold">Status</th>
                  <th class="px-3 py-3 font-bold">Date</th>
                  <th class="px-5 sm:px-6 py-3 font-bold text-right">Action</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-line">

                <tr class="table-row">
                  <td class="px-5 sm:px-6 py-3.5">
                    <div class="flex items-center gap-3">
                      <span class="w-9 h-9 rounded-lg bg-gradient-to-br from-win to-blue-700 flex items-center justify-center text-white font-bold text-[11px] shrink-0">Nx</span>
                      <span class="text-[13px] font-semibold text-ink whitespace-nowrap">Nexus Cleaner</span>
                    </div>
                  </td>
                  <td class="px-3 py-3.5"><span class="text-[11px] font-semibold px-2 py-1 rounded-full bg-win-light text-win whitespace-nowrap">Utilities</span></td>
                  <td class="px-3 py-3.5"><span class="text-[12px] font-mono text-sub">v4.2.1</span></td>
                  <td class="px-3 py-3.5"><span class="text-[12.5px] font-mono text-ink">842K</span></td>
                  <td class="px-3 py-3.5"><span class="text-[11px] font-semibold px-2 py-1 rounded-full bg-emerald-50 text-emerald-600 whitespace-nowrap">Published</span></td>
                  <td class="px-3 py-3.5"><span class="text-[12px] text-faint whitespace-nowrap">Jul 24, 2026</span></td>
                  <td class="px-5 sm:px-6 py-3.5">
                    <div class="flex items-center justify-end gap-1">
                      <button class="act-btn w-8 h-8 rounded-lg hover:bg-win-light hover:text-win text-faint flex items-center justify-center"><svg width="14" height="14" viewBox="0 0 24 24" fill="none"><path d="M2 12C4 7 8 4.5 12 4.5C16 4.5 20 7 22 12C20 17 16 19.5 12 19.5C8 19.5 4 17 2 12Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/><circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.8"/></svg></button>
                      <button class="act-btn w-8 h-8 rounded-lg hover:bg-brand-light hover:text-brand text-faint flex items-center justify-center"><svg width="14" height="14" viewBox="0 0 24 24" fill="none"><path d="M4 20L4.7 16.6L16.2 5.1C16.9 4.4 18 4.4 18.7 5.1L19.9 6.3C20.6 7 20.6 8.1 19.9 8.8L8.4 20.3L4 20Z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/></svg></button>
                      <button class="act-btn w-8 h-8 rounded-lg hover:bg-red-50 hover:text-red-500 text-faint flex items-center justify-center"><svg width="14" height="14" viewBox="0 0 24 24" fill="none"><path d="M4 7H20M9 7V5C9 4.4 9.4 4 10 4H14C14.6 4 15 4.4 15 5V7M18 7L17.3 19C17.2 20.1 16.3 21 15.2 21H8.8C7.7 21 6.8 20.1 6.7 19L6 7" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></button>
                    </div>
                  </td>
                </tr>

                <tr class="table-row">
                  <td class="px-5 sm:px-6 py-3.5">
                    <div class="flex items-center gap-3">
                      <span class="w-9 h-9 rounded-lg bg-gradient-to-br from-fuchsia-500 to-purple-700 flex items-center justify-center text-white font-bold text-[11px] shrink-0">Cd</span>
                      <span class="text-[13px] font-semibold text-ink whitespace-nowrap">CodeForge IDE</span>
                    </div>
                  </td>
                  <td class="px-3 py-3.5"><span class="text-[11px] font-semibold px-2 py-1 rounded-full bg-brand-light text-brand whitespace-nowrap">Developer Tools</span></td>
                  <td class="px-3 py-3.5"><span class="text-[12px] font-mono text-sub">v2.4.0</span></td>
                  <td class="px-3 py-3.5"><span class="text-[12.5px] font-mono text-ink">733K</span></td>
                  <td class="px-3 py-3.5"><span class="text-[11px] font-semibold px-2 py-1 rounded-full bg-amber-50 text-amber-600 whitespace-nowrap">Pending</span></td>
                  <td class="px-3 py-3.5"><span class="text-[12px] text-faint whitespace-nowrap">Jul 23, 2026</span></td>
                  <td class="px-5 sm:px-6 py-3.5">
                    <div class="flex items-center justify-end gap-1">
                      <button class="act-btn w-8 h-8 rounded-lg hover:bg-win-light hover:text-win text-faint flex items-center justify-center"><svg width="14" height="14" viewBox="0 0 24 24" fill="none"><path d="M2 12C4 7 8 4.5 12 4.5C16 4.5 20 7 22 12C20 17 16 19.5 12 19.5C8 19.5 4 17 2 12Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/><circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.8"/></svg></button>
                      <button class="act-btn w-8 h-8 rounded-lg hover:bg-brand-light hover:text-brand text-faint flex items-center justify-center"><svg width="14" height="14" viewBox="0 0 24 24" fill="none"><path d="M4 20L4.7 16.6L16.2 5.1C16.9 4.4 18 4.4 18.7 5.1L19.9 6.3C20.6 7 20.6 8.1 19.9 8.8L8.4 20.3L4 20Z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/></svg></button>
                      <button class="act-btn w-8 h-8 rounded-lg hover:bg-red-50 hover:text-red-500 text-faint flex items-center justify-center"><svg width="14" height="14" viewBox="0 0 24 24" fill="none"><path d="M4 7H20M9 7V5C9 4.4 9.4 4 10 4H14C14.6 4 15 4.4 15 5V7M18 7L17.3 19C17.2 20.1 16.3 21 15.2 21H8.8C7.7 21 6.8 20.1 6.7 19L6 7" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></button>
                    </div>
                  </td>
                </tr>

                <tr class="table-row">
                  <td class="px-5 sm:px-6 py-3.5">
                    <div class="flex items-center gap-3">
                      <span class="w-9 h-9 rounded-lg bg-gradient-to-br from-amber-400 to-orange-600 flex items-center justify-center text-white font-bold text-[11px] shrink-0">Sh</span>
                      <span class="text-[13px] font-semibold text-ink whitespace-nowrap">ShieldGuard Antivirus</span>
                    </div>
                  </td>
                  <td class="px-3 py-3.5"><span class="text-[11px] font-semibold px-2 py-1 rounded-full bg-red-50 text-red-500 whitespace-nowrap">Security</span></td>
                  <td class="px-3 py-3.5"><span class="text-[12px] font-mono text-sub">v9.1.3</span></td>
                  <td class="px-3 py-3.5"><span class="text-[12.5px] font-mono text-ink">2.1M</span></td>
                  <td class="px-3 py-3.5"><span class="text-[11px] font-semibold px-2 py-1 rounded-full bg-emerald-50 text-emerald-600 whitespace-nowrap">Published</span></td>
                  <td class="px-3 py-3.5"><span class="text-[12px] text-faint whitespace-nowrap">Jul 21, 2026</span></td>
                  <td class="px-5 sm:px-6 py-3.5">
                    <div class="flex items-center justify-end gap-1">
                      <button class="act-btn w-8 h-8 rounded-lg hover:bg-win-light hover:text-win text-faint flex items-center justify-center"><svg width="14" height="14" viewBox="0 0 24 24" fill="none"><path d="M2 12C4 7 8 4.5 12 4.5C16 4.5 20 7 22 12C20 17 16 19.5 12 19.5C8 19.5 4 17 2 12Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/><circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.8"/></svg></button>
                      <button class="act-btn w-8 h-8 rounded-lg hover:bg-brand-light hover:text-brand text-faint flex items-center justify-center"><svg width="14" height="14" viewBox="0 0 24 24" fill="none"><path d="M4 20L4.7 16.6L16.2 5.1C16.9 4.4 18 4.4 18.7 5.1L19.9 6.3C20.6 7 20.6 8.1 19.9 8.8L8.4 20.3L4 20Z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/></svg></button>
                      <button class="act-btn w-8 h-8 rounded-lg hover:bg-red-50 hover:text-red-500 text-faint flex items-center justify-center"><svg width="14" height="14" viewBox="0 0 24 24" fill="none"><path d="M4 7H20M9 7V5C9 4.4 9.4 4 10 4H14C14.6 4 15 4.4 15 5V7M18 7L17.3 19C17.2 20.1 16.3 21 15.2 21H8.8C7.7 21 6.8 20.1 6.7 19L6 7" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></button>
                    </div>
                  </td>
                </tr>

                <tr class="table-row">
                  <td class="px-5 sm:px-6 py-3.5">
                    <div class="flex items-center gap-3">
                      <span class="w-9 h-9 rounded-lg bg-gradient-to-br from-emerald-400 to-teal-600 flex items-center justify-center text-white font-bold text-[11px] shrink-0">Tm</span>
                      <span class="text-[13px] font-semibold text-ink whitespace-nowrap">TimeMint</span>
                    </div>
                  </td>
                  <td class="px-3 py-3.5"><span class="text-[11px] font-semibold px-2 py-1 rounded-full bg-emerald-50 text-emerald-600 whitespace-nowrap">Productivity</span></td>
                  <td class="px-3 py-3.5"><span class="text-[12px] font-mono text-sub">v1.8.4</span></td>
                  <td class="px-3 py-3.5"><span class="text-[12.5px] font-mono text-ink">520K</span></td>
                  <td class="px-3 py-3.5"><span class="text-[11px] font-semibold px-2 py-1 rounded-full bg-gray-100 text-gray-500 whitespace-nowrap">Draft</span></td>
                  <td class="px-3 py-3.5"><span class="text-[12px] text-faint whitespace-nowrap">Jul 19, 2026</span></td>
                  <td class="px-5 sm:px-6 py-3.5">
                    <div class="flex items-center justify-end gap-1">
                      <button class="act-btn w-8 h-8 rounded-lg hover:bg-win-light hover:text-win text-faint flex items-center justify-center"><svg width="14" height="14" viewBox="0 0 24 24" fill="none"><path d="M2 12C4 7 8 4.5 12 4.5C16 4.5 20 7 22 12C20 17 16 19.5 12 19.5C8 19.5 4 17 2 12Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/><circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.8"/></svg></button>
                      <button class="act-btn w-8 h-8 rounded-lg hover:bg-brand-light hover:text-brand text-faint flex items-center justify-center"><svg width="14" height="14" viewBox="0 0 24 24" fill="none"><path d="M4 20L4.7 16.6L16.2 5.1C16.9 4.4 18 4.4 18.7 5.1L19.9 6.3C20.6 7 20.6 8.1 19.9 8.8L8.4 20.3L4 20Z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/></svg></button>
                      <button class="act-btn w-8 h-8 rounded-lg hover:bg-red-50 hover:text-red-500 text-faint flex items-center justify-center"><svg width="14" height="14" viewBox="0 0 24 24" fill="none"><path d="M4 7H20M9 7V5C9 4.4 9.4 4 10 4H14C14.6 4 15 4.4 15 5V7M18 7L17.3 19C17.2 20.1 16.3 21 15.2 21H8.8C7.7 21 6.8 20.1 6.7 19L6 7" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></button>
                    </div>
                  </td>
                </tr>

                <tr class="table-row">
                  <td class="px-5 sm:px-6 py-3.5">
                    <div class="flex items-center gap-3">
                      <span class="w-9 h-9 rounded-lg bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold text-[11px] shrink-0">Vt</span>
                      <span class="text-[13px] font-semibold text-ink whitespace-nowrap">Vault Archiver</span>
                    </div>
                  </td>
                  <td class="px-3 py-3.5"><span class="text-[11px] font-semibold px-2 py-1 rounded-full bg-win-light text-win whitespace-nowrap">Compression</span></td>
                  <td class="px-3 py-3.5"><span class="text-[12px] font-mono text-sub">v6.0.2</span></td>
                  <td class="px-3 py-3.5"><span class="text-[12.5px] font-mono text-ink">1.2M</span></td>
                  <td class="px-3 py-3.5"><span class="text-[11px] font-semibold px-2 py-1 rounded-full bg-emerald-50 text-emerald-600 whitespace-nowrap">Published</span></td>
                  <td class="px-3 py-3.5"><span class="text-[12px] text-faint whitespace-nowrap">Jul 17, 2026</span></td>
                  <td class="px-5 sm:px-6 py-3.5">
                    <div class="flex items-center justify-end gap-1">
                      <button class="act-btn w-8 h-8 rounded-lg hover:bg-win-light hover:text-win text-faint flex items-center justify-center"><svg width="14" height="14" viewBox="0 0 24 24" fill="none"><path d="M2 12C4 7 8 4.5 12 4.5C16 4.5 20 7 22 12C20 17 16 19.5 12 19.5C8 19.5 4 17 2 12Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/><circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.8"/></svg></button>
                      <button class="act-btn w-8 h-8 rounded-lg hover:bg-brand-light hover:text-brand text-faint flex items-center justify-center"><svg width="14" height="14" viewBox="0 0 24 24" fill="none"><path d="M4 20L4.7 16.6L16.2 5.1C16.9 4.4 18 4.4 18.7 5.1L19.9 6.3C20.6 7 20.6 8.1 19.9 8.8L8.4 20.3L4 20Z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/></svg></button>
                      <button class="act-btn w-8 h-8 rounded-lg hover:bg-red-50 hover:text-red-500 text-faint flex items-center justify-center"><svg width="14" height="14" viewBox="0 0 24 24" fill="none"><path d="M4 7H20M9 7V5C9 4.4 9.4 4 10 4H14C14.6 4 15 4.4 15 5V7M18 7L17.3 19C17.2 20.1 16.3 21 15.2 21H8.8C7.7 21 6.8 20.1 6.7 19L6 7" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></button>
                    </div>
                  </td>
                </tr>

              </tbody>
            </table>
          </div>

          <div class="px-5 sm:px-6 py-4 flex items-center justify-between border-t border-line mt-1">
            <p class="text-[12px] text-faint">Showing <span class="font-semibold text-ink">5</span> of <span class="font-semibold text-ink">1,240</span></p>
            <a href="#" class="text-[12.5px] font-semibold text-brand hover:text-brand-dark transition-colors">View full list →</a>
          </div>
        </div>

        <!-- Right column: Quick Actions + Activity -->
        <div class="flex flex-col gap-5 sm:gap-6">

          <!-- Quick actions -->
          <div class="panel-card bg-white border border-line rounded-2xl shadow-card p-5 sm:p-6">
            <h3 class="text-[15px] font-bold text-ink mb-4">Quick Actions</h3>
            <div class="flex flex-col gap-2.5">

              <a href="#" class="qa-card flex items-center gap-3 p-3 rounded-xl border border-line hover:border-gold/50">
                <span class="icon-tile w-10 h-10 rounded-lg bg-gold-light text-gold-dark flex items-center justify-center shrink-0">
                  <svg width="17" height="17" viewBox="0 0 24 24" fill="none"><path d="M12 5V19M5 12H19" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/></svg>
                </span>
                <span class="min-w-0 flex-1">
                  <span class="block text-[13px] font-semibold text-ink">Add New Software</span>
                  <span class="block text-[11.5px] text-faint mt-0.5">Submit a new listing</span>
                </span>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" class="text-faint shrink-0"><path d="M9 6L15 12L9 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
              </a>

              <a href="#" class="qa-card flex items-center gap-3 p-3 rounded-xl border border-line hover:border-brand/40">
                <span class="icon-tile w-10 h-10 rounded-lg bg-brand-light text-brand flex items-center justify-center shrink-0">
                  <svg width="17" height="17" viewBox="0 0 24 24" fill="none"><path d="M6 3L18 3L21 8V19C21 20.1 20.1 21 19 21H5C3.9 21 3 20.1 3 19V8L6 3Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/><path d="M3 8H21" stroke="currentColor" stroke-width="1.8"/></svg>
                </span>
                <span class="min-w-0 flex-1">
                  <span class="block text-[13px] font-semibold text-ink">View All Software</span>
                  <span class="block text-[11.5px] text-faint mt-0.5">Browse the full catalog</span>
                </span>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" class="text-faint shrink-0"><path d="M9 6L15 12L9 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
              </a>

              <a href="#" class="qa-card flex items-center gap-3 p-3 rounded-xl border border-line hover:border-win/40">
                <span class="icon-tile w-10 h-10 rounded-lg bg-win-light text-win flex items-center justify-center shrink-0">
                  <svg width="17" height="17" viewBox="0 0 24 24" fill="none"><path d="M3 6L12 13L21 6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/><rect x="3" y="4" width="18" height="16" rx="2.5" stroke="currentColor" stroke-width="1.8"/></svg>
                </span>
                <span class="min-w-0 flex-1">
                  <span class="block text-[13px] font-semibold text-ink">Newsletter Subscribers</span>
                  <span class="block text-[11.5px] text-faint mt-0.5">68,412 people subscribed</span>
                </span>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" class="text-faint shrink-0"><path d="M9 6L15 12L9 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
              </a>

            </div>
          </div>

          <!-- Activity timeline -->
          <div class="panel-card bg-white border border-line rounded-2xl shadow-card p-5 sm:p-6">
            <h3 class="text-[15px] font-bold text-ink mb-5">Recent Activity</h3>
            <div class="flex flex-col gap-5">

              <div class="timeline-item">
                <span class="timeline-dot bg-gold-light text-gold-dark">
                  <svg width="12" height="12" viewBox="0 0 24 24" fill="none"><path d="M12 5V19M5 12H19" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"/></svg>
                </span>
                <p class="text-[13px] font-semibold text-ink">Software Added</p>
                <p class="text-[12px] text-sub mt-0.5">"Nexus Cleaner v4.2.1" was published to Windows → Utilities.</p>
                <p class="text-[11px] font-mono text-faint mt-1">2 hours ago</p>
              </div>

              <div class="timeline-item">
                <span class="timeline-dot bg-win-light text-win">
                  <svg width="12" height="12" viewBox="0 0 24 24" fill="none"><path d="M4 12C4 7.6 7.6 4 12 4C15.3 4 18.1 6 19.3 8.9" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><path d="M20 12C20 16.4 16.4 20 12 20C8.7 20 5.9 18 4.7 15.1" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><path d="M19 5V9H15" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M5 19V15H9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </span>
                <p class="text-[13px] font-semibold text-ink">Software Updated</p>
                <p class="text-[12px] text-sub mt-0.5">"CodeForge IDE" changelog updated to version 2.4.0.</p>
                <p class="text-[11px] font-mono text-faint mt-1">5 hours ago</p>
              </div>

              <div class="timeline-item">
                <span class="timeline-dot bg-emerald-50 text-emerald-600">
                  <svg width="12" height="12" viewBox="0 0 24 24" fill="none"><path d="M16 20V18C16 15.8 14.2 14 12 14H6C3.8 14 2 15.8 2 18V20" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><circle cx="9" cy="7" r="3.5" stroke="currentColor" stroke-width="2"/><path d="M19 8V13M16.5 10.5H21.5" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                </span>
                <p class="text-[13px] font-semibold text-ink">New Newsletter Subscriber</p>
                <p class="text-[12px] text-sub mt-0.5">m.hassan@gmail.com joined the weekly digest list.</p>
                <p class="text-[11px] font-mono text-faint mt-1">Yesterday</p>
              </div>

              <div class="timeline-item">
                <span class="timeline-dot bg-brand-light text-brand">
                  <svg width="12" height="12" viewBox="0 0 24 24" fill="none"><path d="M12 5V19M5 12H19" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"/></svg>
                </span>
                <p class="text-[13px] font-semibold text-ink">Software Added</p>
                <p class="text-[12px] text-sub mt-0.5">"Vault Archiver v6.0.2" was published to Windows → Compression.</p>
                <p class="text-[11px] font-mono text-faint mt-1">2 days ago</p>
              </div>

            </div>
          </div>

        </div>
      </div>
    </main>
  </div>
</div>

<script>
  // Mobile sidebar toggle
  (function () {
    var sidebar = document.getElementById('sidebar');
    var overlay = document.getElementById('sidebarOverlay');
    var toggle = document.getElementById('menuToggle');

    function openSidebar() {
      sidebar.classList.add('open');
      overlay.classList.remove('hidden');
    }
    function closeSidebar() {
      sidebar.classList.remove('open');
      overlay.classList.add('hidden');
    }
    toggle.addEventListener('click', openSidebar);
    overlay.addEventListener('click', closeSidebar);
  })();

  // Generic dropdown toggler (profile + notifications), closes on outside click
  (function () {
    var dropdowns = [
      { btn: document.getElementById('profileBtn'), menu: document.getElementById('profileMenu') },
      { btn: document.getElementById('notifBtn'), menu: document.getElementById('notifMenu') },
    ];

    function closeAll(except) {
      dropdowns.forEach(function (d) {
        if (d.menu !== except) d.menu.classList.remove('open');
      });
    }

    dropdowns.forEach(function (d) {
      d.btn.addEventListener('click', function (e) {
        e.stopPropagation();
        var isOpen = d.menu.classList.contains('open');
        closeAll(null);
        d.menu.classList.toggle('open', !isOpen);
      });
    });

    document.addEventListener('click', function () { closeAll(null); });
  })();
</script>
</body>
</html>
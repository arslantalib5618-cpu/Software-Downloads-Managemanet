<x-layout.admin_layout>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Filedesk · Newsletter Management</title>

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
            amber: { DEFAULT: '#B45309', light: '#FEF3E2' },
            rose: { DEFAULT: '#E11D48', light: '#FEF1F4' },
            dbg: '#0A0B0F',
            dcard: '#15171E',
            dline: 'rgba(255,255,255,0.09)',
            dtext: '#E7E9EE',
            dsub: '#9BA3B4',
          },
          boxShadow: {
            card: '0 1px 2px rgba(15,17,23,0.04), 0 1px 1px rgba(15,17,23,0.03)',
            cardHover: '0 20px 40px -16px rgba(15,17,23,0.16), 0 4px 12px -4px rgba(15,17,23,0.08)',
            banner: '0 28px 56px -18px rgba(79,70,229,0.4)',
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
    body {
      font-family: 'Inter', sans-serif; color: #0B0D12;
      background: #F9F9FB;
      transition: background-color .35s ease, color .35s ease;
    }
    html.dark body { color: #E7E9EE; background: #0A0B0F; }
    .font-mono { font-family: 'JetBrains Mono', monospace; }

    ::selection { background: #4F46E5; color: #fff; }
    ::-webkit-scrollbar { height: 8px; width: 8px; }
    ::-webkit-scrollbar-thumb { background: #D9DCE3; border-radius: 8px; }
    ::-webkit-scrollbar-track { background: transparent; }

    /* ---- ambient background ---- */
    .ambient-bg { position: fixed; inset: 0; z-index: -1; overflow: hidden; pointer-events: none; }
    .ambient-bg span { position: absolute; border-radius: 50%; filter: blur(90px); opacity: .35; }
    .ambient-bg .b1 { width: 460px; height: 460px; top: -180px; right: -120px; background: #6C63F1; }
    .ambient-bg .b2 { width: 380px; height: 380px; bottom: -160px; left: -140px; background: #2FB170; opacity: .12; }
    html.dark .ambient-bg span { opacity: .16; }

    /* ---- Hero banner ---- */
    .hero-banner {
      position: relative; overflow: hidden;
      background: radial-gradient(120% 160% at 0% 0%, #6C63F1 0%, #4F46E5 45%, #362DB8 100%);
    }
    .hero-banner::before {
      content: ''; position: absolute; inset: 0;
      background-image:
        radial-gradient(circle at 85% 15%, rgba(255,255,255,0.16) 0%, transparent 40%),
        radial-gradient(circle at 100% 100%, rgba(255,255,255,0.10) 0%, transparent 45%);
      pointer-events: none;
    }
    .hero-banner .grid-overlay {
      position: absolute; inset: 0;
      background-image: linear-gradient(rgba(255,255,255,0.06) 1px, transparent 1px),
                         linear-gradient(90deg, rgba(255,255,255,0.06) 1px, transparent 1px);
      background-size: 34px 34px;
      -webkit-mask-image: linear-gradient(to bottom, black, transparent 85%);
      mask-image: linear-gradient(to bottom, black, transparent 85%);
      pointer-events: none;
    }
    .hero-icon-float { animation: floaty 5s ease-in-out infinite; }
    @keyframes floaty {
      0%, 100% { transform: translateY(0) rotate(0deg); }
      50% { transform: translateY(-8px) rotate(3deg); }
    }

    .step-pill {
      display: inline-flex; align-items: center; gap: 6px;
      font-size: 11px; font-weight: 600; color: rgba(255,255,255,0.85);
      background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.15);
      padding: 5px 12px 5px 8px; border-radius: 100px;
    }
    .step-pill .dot { width: 6px; height: 6px; border-radius: 50%; background: #fff; }

    /* ---- Section cards ---- */
    .section-card {
      background: #FFFFFF; border: 1px solid #ECEDF1; border-radius: 22px;
      box-shadow: 0 1px 2px rgba(15,17,23,0.03), 0 1px 1px rgba(15,17,23,0.02);
      position: relative; overflow: hidden;
      transition: box-shadow .35s cubic-bezier(.16,1,.3,1), border-color .25s ease, transform .35s cubic-bezier(.16,1,.3,1);
    }
    .section-card:hover {
      box-shadow: 0 24px 48px -20px rgba(15,17,23,0.14), 0 6px 16px -6px rgba(15,17,23,0.06);
      border-color: #E0E2E9;
    }
    html.dark .section-card { background: #131519; border-color: rgba(255,255,255,0.08); }
    html.dark .section-card:hover { border-color: rgba(255,255,255,0.14); }

    .section-card::before {
      content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px;
      background: linear-gradient(90deg, #4F46E5, #6C63F1);
    }
    .section-card.accent-android::before { background: linear-gradient(90deg, #2FB170, #6EE7A8); }

    .section-head { display: flex; align-items: flex-start; gap: 16px; }
    .section-num {
      font-family: 'JetBrains Mono', monospace; font-size: 11px; font-weight: 600;
      color: #C3C8D2; letter-spacing: 0.04em; margin-bottom: 3px; display: block;
    }
    html.dark .section-num { color: #454B58; }
    .section-icon {
      flex-shrink: 0; width: 42px; height: 42px; border-radius: 13px;
      display: flex; align-items: center; justify-content: center;
      box-shadow: 0 8px 16px -6px rgba(15,17,23,0.22);
    }
    .section-title { font-size: 15px; font-weight: 700; color: #0B0D12; letter-spacing: -0.015em; }
    html.dark .section-title { color: #fff; }
    .section-sub { font-size: 12.5px; color: #8A93A3; margin-top: 3px; line-height: 1.55; }

    /* ---- Fields ---- */
    .field-input {
      width: 100%; padding: 12px 15px; border-radius: 13px;
      border: 1.5px solid #E7E9ED; background: #FBFBFD; font-size: 14px; color: #0B0D12;
      transition: border-color .2s ease, box-shadow .2s ease, background-color .2s ease;
    }
    .field-input:hover { border-color: #C9CDD6; }
    .field-input:focus {
      outline: none; border-color: #4F46E5; box-shadow: 0 0 0 4px rgba(79,70,229,0.10); background: #fff;
    }
    html.dark .field-input { background: #0E1015; border-color: rgba(255,255,255,0.1); color: #E7E9EE; }
    html.dark .field-input:hover { border-color: rgba(255,255,255,0.2); }
    html.dark .field-input:focus { border-color: #4F46E5; box-shadow: 0 0 0 4px rgba(79,70,229,0.18); background: #121520; }
    .field-input::placeholder { color: #A6AEBB; }

    .input-with-icon { position: relative; }
    .input-with-icon .field-input { padding-left: 42px; }
    .input-with-icon .input-icon {
      position: absolute; left: 14px; top: 50%; transform: translateY(-50%);
      color: #A6AEBB; pointer-events: none;
    }

    /* ---- Buttons ---- */
    .btn-primary {
      position: relative; overflow: hidden;
      display: inline-flex; align-items: center; gap: 8px;
      padding: 11px 22px; border-radius: 13px;
      background: linear-gradient(135deg, #4F46E5, #4338CA);
      color: #fff; font-size: 13.5px; font-weight: 600;
      box-shadow: 0 12px 28px -10px rgba(79,70,229,0.5);
      transition: transform .18s ease, box-shadow .18s ease, filter .18s ease;
      cursor: pointer;
    }
    .btn-primary::after {
      content: ''; position: absolute; inset: 0;
      background: linear-gradient(120deg, transparent 30%, rgba(255,255,255,0.25) 50%, transparent 70%);
      transform: translateX(-100%); transition: transform .6s ease;
    }
    .btn-primary:hover::after { transform: translateX(100%); }
    .btn-primary:hover { transform: translateY(-1px); filter: brightness(1.05); box-shadow: 0 16px 32px -10px rgba(79,70,229,0.6); }
    .btn-primary:active { transform: translateY(0); }

    .btn-secondary {
      display: inline-flex; align-items: center; gap: 8px;
      padding: 11px 20px; border-radius: 13px; cursor: pointer;
      background: #fff; border: 1.5px solid #E7E9ED; color: #3D4452; font-size: 13.5px; font-weight: 600;
      transition: border-color .18s ease, background-color .18s ease, transform .18s ease;
    }
    .btn-secondary:hover { border-color: #C9CDD6; background: #FBFBFD; transform: translateY(-1px); }
    html.dark .btn-secondary { background: #0E1015; border-color: rgba(255,255,255,0.12); color: #C4CADA; }
    html.dark .btn-secondary:hover { border-color: rgba(255,255,255,0.22); background: #14161C; }

    .btn-danger {
      display: inline-flex; align-items: center; gap: 7px; cursor: pointer;
      padding: 11px 20px; border-radius: 13px;
      background: #FEF1F4; color: #E11D48; font-size: 13.5px; font-weight: 700;
      border: 1.5px solid rgba(225,29,72,0.15);
      transition: background-color .18s ease, transform .18s ease;
    }
    .btn-danger:hover { background: #FCE1E7; transform: translateY(-1px); }
    .btn-danger:disabled { opacity: .45; pointer-events: none; }
    html.dark .btn-danger { background: rgba(225,29,72,0.12); border-color: rgba(225,29,72,0.25); }

    /* ---- Badges ---- */
    .badge {
      display: inline-flex; align-items: center; gap: 5px;
      font-size: 11px; font-weight: 700; padding: 4px 11px; border-radius: 100px;
      font-family: 'JetBrains Mono', monospace;
    }
    .badge .dot { width: 6px; height: 6px; border-radius: 50%; }
    .badge-active { background: #E9FBF1; color: #1F8F58; }
    .badge-active .dot { background: #2FB170; }
    html.dark .badge-active { background: rgba(47,177,112,0.18); color: #6EE7A8; }
    .badge-inactive { background: #F1F2F5; color: #5B6472; }
    .badge-inactive .dot { background: #8A93A3; }
    html.dark .badge-inactive { background: rgba(255,255,255,0.06); color: #9BA3B4; }
    .badge-count { background: #EEF0FF; color: #4338CA; }
    html.dark .badge-count { background: rgba(79,70,229,0.18); color: #A5B4FC; }

    /* ---- Table ---- */
    .table-wrap { border: 1px solid #ECEDF1; border-radius: 18px; overflow: hidden; }
    html.dark .table-wrap { border-color: rgba(255,255,255,0.08); }
    table.data-table { width: 100%; border-collapse: collapse; font-size: 13.5px; }
    table.data-table thead th {
      text-align: left; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .04em;
      color: #8A93A3; background: #FBFBFD; padding: 13px 16px; border-bottom: 1px solid #ECEDF1;
    }
    html.dark table.data-table thead th { background: #0E1015; border-color: rgba(255,255,255,0.08); color: #6F7789; }
    table.data-table tbody td { padding: 14px 16px; border-bottom: 1px solid #F1F2F5; color: #1B1E27; vertical-align: middle; }
    html.dark table.data-table tbody td { border-color: rgba(255,255,255,0.06); color: #E7E9EE; }
    table.data-table tbody tr { transition: background-color .15s ease; }
    table.data-table tbody tr:hover { background: #FBFBFD; }
    html.dark table.data-table tbody tr:hover { background: rgba(255,255,255,0.02); }
    table.data-table tbody tr:last-child td { border-bottom: none; }

    .row-check, .header-check {
      width: 16px; height: 16px; border-radius: 5px; border: 1.5px solid #D3D7E0;
      accent-color: #4F46E5; cursor: pointer;
    }
    html.dark .row-check, html.dark .header-check { border-color: rgba(255,255,255,0.2); }

    .icon-btn {
      width: 30px; height: 30px; border-radius: 9px; display: inline-flex; align-items: center; justify-content: center;
      color: #8A93A3; transition: background-color .15s ease, color .15s ease; cursor: pointer;
    }
    .icon-btn.danger:hover { background: #FEF1F4; color: #E11D48; }
    html.dark .icon-btn.danger:hover { background: rgba(225,29,72,0.12); color: #FB7185; }

    .icon-btn.refresh { color: #5B6472; }
    .icon-btn.refresh:hover { background: #F1F2F5; color: #3D4452; }
    html.dark .icon-btn.refresh:hover { background: rgba(255,255,255,0.06); color: #E7E9EE; }
    .icon-btn.refresh.spinning svg { animation: spin .7s linear; }
    @keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }

    /* ---- Pagination ---- */
    .page-btn {
      min-width: 34px; height: 34px; padding: 0 10px; border-radius: 10px; cursor: pointer;
      display: inline-flex; align-items: center; justify-content: center;
      font-size: 12.5px; font-weight: 600; color: #5B6472; border: 1.5px solid #E7E9ED; background: transparent;
      transition: all .18s ease;
    }
    .page-btn:hover { border-color: #C9CDD6; background: #FBFBFD; }
    .page-btn.active { background: #4F46E5; border-color: #4F46E5; color: #fff; }
    .page-btn.disabled { opacity: .4; pointer-events: none; }
    html.dark .page-btn { border-color: rgba(255,255,255,0.1); color: #9BA3B4; }
    html.dark .page-btn:hover { border-color: rgba(255,255,255,0.2); background: rgba(255,255,255,0.04); }

    /* ---- Empty state ---- */
    .empty-illustration {
      width: 96px; height: 96px; border-radius: 26px;
      background: linear-gradient(135deg, #EEF0FF, #FBFBFD);
      display: flex; align-items: center; justify-content: center;
      box-shadow: 0 16px 32px -14px rgba(79,70,229,0.28);
    }
    html.dark .empty-illustration { background: linear-gradient(135deg, rgba(79,70,229,0.16), rgba(79,70,229,0.04)); }

    /* ---- Bulk bar ---- */
    .bulk-bar { transition: max-height .25s ease, opacity .2s ease; overflow: hidden; }

    /* ---- Skeleton row (refresh loading state) ---- */
    .skel { position: relative; overflow: hidden; background: #F1F2F5; border-radius: 6px; }
    html.dark .skel { background: rgba(255,255,255,0.06); }
    .skel::after {
      content: ''; position: absolute; inset: 0; transform: translateX(-100%);
      background: linear-gradient(90deg, transparent, rgba(255,255,255,0.55), transparent);
      animation: shimmer 1.3s infinite;
    }
    html.dark .skel::after { background: linear-gradient(90deg, transparent, rgba(255,255,255,0.08), transparent); }
    @keyframes shimmer { 100% { transform: translateX(100%); } }
  </style>
</head>
<body class="antialiased bg-surface dark:bg-dbg text-ink dark:text-dtext">

  <div class="ambient-bg"><span class="b1"></span><span class="b2"></span></div>

  <main class="flex-1 flex flex-col overflow-y-auto">

    <!-- top bar -->
    <header class="sticky top-0 z-20 bg-white/70 dark:bg-dbg/70 backdrop-blur-md border-b border-line dark:border-dline px-5 sm:px-8 py-3 flex items-center justify-between">
      <div class="flex items-center gap-4">
        <a href="#" class="p-1.5 -ml-1.5 rounded-lg hover:bg-surface dark:hover:bg-white/5 transition-colors" aria-label="Go back">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 19L5 12L12 5" stroke="currentColor"/></svg>
        </a>
        <div>
          <h1 class="text-lg font-bold tracking-tight text-ink dark:text-white leading-tight">Newsletter Management</h1>
          <p class="text-[11px] text-sub dark:text-dsub font-mono">Marketing / Subscribers</p>
        </div>
      </div>
      <div class="flex items-center gap-3">
        <button id="darkToggle" class="p-2 rounded-lg hover:bg-surface dark:hover:bg-white/5 transition-colors" aria-label="Toggle dark mode">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="4"/><path d="M12 2V4M12 20V22M4 12H2M22 12H20M19.07 4.93L17.66 6.34M6.34 17.66L4.93 19.07M19.07 19.07L17.66 17.66M6.34 6.34L4.93 4.93"/></svg>
        </button>
        <div class="w-8 h-8 rounded-full bg-brand text-white flex items-center justify-center font-semibold text-sm">JD</div>
      </div>
    </header>

    <!-- ====== PAGE CONTENT ====== -->
    <div class="flex-1 px-5 sm:px-8 py-6 space-y-6 max-w-6xl w-full mx-auto">

      <!-- ===== HERO / PAGE BANNER ===== -->
      <section class="hero-banner rounded-2xl shadow-banner px-6 sm:px-10 py-9 sm:py-11">
        <div class="grid-overlay"></div>
        <div class="relative flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
          <div class="max-w-xl">
            <span class="inline-flex items-center gap-1.5 text-[11px] font-semibold uppercase tracking-wider text-white/70 bg-white/10 px-3 py-1 rounded-full">
              Email marketing
            </span>
            <h2 class="mt-4 text-3xl sm:text-4xl font-extrabold text-white tracking-tight">Newsletter Management</h2>
            <p class="mt-2.5 text-sm sm:text-[15px] text-white/75 leading-relaxed">
              Manage everyone who has subscribed from your website. Whenever you publish a new post, they'll automatically receive an update by email.
            </p>
            <div class="flex flex-wrap items-center gap-2 mt-5">
              <span class="step-pill"><span class="dot"></span>Subscribers</span>
              <span class="step-pill"><span class="dot"></span>Status</span>
              <span class="step-pill"><span class="dot"></span>Future campaigns</span>
            </div>
          </div>
          <span class="hero-icon-float hidden sm:flex w-16 h-16 rounded-2xl bg-white/10 border border-white/15 items-center justify-center">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="1.8"><rect x="3" y="5" width="18" height="14" rx="2.5"/><path d="M3 7L12 13L21 7"/></svg>
          </span>
        </div>
      </section>

      <!-- ===== SUBSCRIBERS TABLE ===== -->
      <div class="section-card accent-android p-5 sm:p-7">

        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
          <div class="section-head">
            <div class="section-icon bg-android-light dark:bg-android/20 text-android">
              <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M17 21V19C17 16.8 15.2 15 13 15H5C2.8 15 1 16.8 1 19V21"/><circle cx="9" cy="7" r="4"/><path d="M23 21V19C23 17.1 21.8 15.5 20 15.1"/><path d="M16 3.1C17.8 3.6 19 5.2 19 7C19 8.8 17.8 10.4 16 10.9"/></svg>
            </div>
            <div>
              <span class="section-num">Subscribers</span>
              <h3 class="section-title">All subscribers</h3>
              <p class="section-sub">Collected automatically from your website's newsletter sign-up form.</p>
            </div>
          </div>

          
        </div>

        <!-- Bulk actions bar -->


        <!-- Table -->
        <div id="tableWrap" class="table-wrap mt-6">
          <div class="overflow-x-auto">
            <table class="data-table">
              <thead>
                <tr>
                  <th class="w-10"><input type="checkbox" id="selectAll" class="header-check"></th>
                  <th>Email address</th>
                  <th class="text-right">Actions</th>
                </tr>
              </thead>
              <tbody id="subscribersBody">
                @foreach ($newsletters as $newsletter)
                <tr data-email="amelia.chen@gmail.com" data-status="active">
                  <td><input type="checkbox" class="row-check subscriber-check"></td>
                  <td class="font-medium">{{ $newsletter->email }}</td>
                  <td>
                    <div class="flex items-center justify-end">
                      <form action="{{ route('newsletter.destroy', $newsletter->id) }}"
      method="POST"
      onsubmit="return confirm('Are you sure you want to delete this subscriber?')"
      class="inline-block">

    @csrf
    @method('DELETE')

    <button type="submit"
            class="icon-btn danger delete-row-btn"
            aria-label="Delete subscriber"
            title="Delete Subscriber">

        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
            <path d="M3 6H21M8 6V4C8 3.4 8.4 3 9 3H15C15.6 3 16 3.4 16 4V6M19 6L18.3 19C18.2 20.1 17.3 21 16.2 21H7.8C6.7 21 5.8 20.1 5.7 19L5 6"/>
        </svg>

    </button>

</form>
                    </div>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>

        <!-- Pagination -->
        <div id="paginationWrap" class="flex flex-col sm:flex-row items-center justify-between gap-4 mt-6">
          <p class="text-[12.5px] text-sub dark:text-dsub">
            Showing <span class="font-semibold text-ink dark:text-dtext">1–6</span> of <span class="font-semibold text-ink dark:text-dtext">2,481</span>
          </p>
          <div class="flex items-center gap-1.5">
            <button type="button" class="page-btn disabled" aria-label="Previous page">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M15 18L9 12L15 6"/></svg>
            </button>
            <button type="button" class="page-btn active">1</button>
            <button type="button" class="page-btn">2</button>
            <button type="button" class="page-btn">3</button>
            <button type="button" class="page-btn">4</button>
            <button type="button" class="page-btn" aria-label="Next page">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M9 6L15 12L9 18"/></svg>
            </button>
          </div>
        </div>

        <!-- Empty state (hidden unless search yields nothing / all rows removed) -->
        <div id="emptyState" class="hidden flex-col items-center justify-center text-center py-16 px-6">
          <div class="empty-illustration">
            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#4F46E5" stroke-width="1.6"><path d="M17 21V19C17 16.8 15.2 15 13 15H5C2.8 15 1 16.8 1 19V21"/><circle cx="9" cy="7" r="4"/><path d="M19 8L21 10L23 8"/><path d="M21 4V10"/></svg>
          </div>
          <h4 class="mt-6 text-[15px] font-bold text-ink dark:text-white">No subscribers found</h4>
          <p class="mt-2 text-[13px] text-sub dark:text-dsub max-w-sm leading-relaxed">
            Try a different search term, or check back once more visitors subscribe from your website.
          </p>
        </div>
      </div>

    </div>
  </main>

  <script>
    // Bulk select / bulk bar toggle
    (function () {
      var selectAll = document.getElementById('selectAll');
      var bulkBar = document.getElementById('bulkBar');
      var selectedCount = document.getElementById('selectedCount');
      var deleteSelectedBtn = document.getElementById('deleteSelectedBtn');

      function visibleChecks() {
        return Array.from(document.querySelectorAll('#subscribersBody tr:not(.hidden) .subscriber-check'));
      }

      function refreshBulkBar() {
        var checked = Array.from(document.querySelectorAll('.subscriber-check')).filter(function (c) { return c.checked; });
        selectedCount.textContent = checked.length;
        if (checked.length > 0) {
          bulkBar.style.maxHeight = '80px';
          bulkBar.style.opacity = '1';
        } else {
          bulkBar.style.maxHeight = '0px';
          bulkBar.style.opacity = '0';
        }
      }

      selectAll.addEventListener('change', function () {
        visibleChecks().forEach(function (c) { c.checked = selectAll.checked; });
        refreshBulkBar();
      });

      document.addEventListener('change', function (e) {
        if (e.target.classList && e.target.classList.contains('subscriber-check')) refreshBulkBar();
      });

      deleteSelectedBtn.addEventListener('click', function () {
        var checked = Array.from(document.querySelectorAll('.subscriber-check')).filter(function (c) { return c.checked; });
        if (checked.length === 0) return;
        if (!confirm('Delete ' + checked.length + ' selected subscriber(s)? This is a UI preview only.')) return;
        checked.forEach(function (c) { c.closest('tr').remove(); });
        selectAll.checked = false;
        refreshBulkBar();
        updateCountAndEmptyState();
      });

      window.__refreshBulkBar = refreshBulkBar;
    })();

    // Single row delete (UI preview only — no backend)
    document.addEventListener('click', function (e) {
      var btn = e.target.closest('.delete-row-btn');
      if (!btn) return;
      var row = btn.closest('tr');
      var email = row.getAttribute('data-email');
      if (!confirm('Remove ' + email + ' from subscribers? This is a UI preview only.')) return;
      row.remove();
      window.__refreshBulkBar && window.__refreshBulkBar();
      updateCountAndEmptyState();
    });

    // Search (client-side demo)
    var searchInput = document.getElementById('searchInput');

    function applyFilters() {
      var term = searchInput.value.trim().toLowerCase();
      var rows = Array.from(document.querySelectorAll('#subscribersBody tr'));

      rows.forEach(function (row) {
        var matchesTerm = row.getAttribute('data-email').toLowerCase().indexOf(term) !== -1;
        row.classList.toggle('hidden', !matchesTerm);
      });

      updateCountAndEmptyState();
    }

    function updateCountAndEmptyState() {
      var visibleRows = Array.from(document.querySelectorAll('#subscribersBody tr:not(.hidden)'));
      var totalRows = document.querySelectorAll('#subscribersBody tr').length;
      var badge = document.getElementById('subscriberCountBadge');
      var tableWrap = document.getElementById('tableWrap');
      var paginationWrap = document.getElementById('paginationWrap');
      var emptyState = document.getElementById('emptyState');

      badge.textContent = visibleRows.length + ' subscriber' + (visibleRows.length === 1 ? '' : 's');

      if (totalRows === 0 || visibleRows.length === 0) {
        tableWrap.classList.add('hidden');
        paginationWrap.classList.add('hidden');
        emptyState.classList.remove('hidden');
        emptyState.classList.add('flex');
      } else {
        tableWrap.classList.remove('hidden');
        paginationWrap.classList.remove('hidden');
        emptyState.classList.add('hidden');
        emptyState.classList.remove('flex');
      }
    }

    searchInput.addEventListener('input', applyFilters);

    // Refresh button (UI only — spins briefly, no real data fetch)
    document.getElementById('refreshBtn').addEventListener('click', function () {
      var btn = this;
      if (btn.classList.contains('spinning')) return;
      btn.classList.add('spinning');
      setTimeout(function () { btn.classList.remove('spinning'); }, 700);
    });

    // Pagination (visual demo only — no real data paging)
    document.querySelectorAll('#paginationWrap .page-btn').forEach(function (btn) {
      btn.addEventListener('click', function () {
        if (btn.classList.contains('disabled') || isNaN(parseInt(btn.textContent))) return;
        document.querySelectorAll('#paginationWrap .page-btn').forEach(function (b) { b.classList.remove('active'); });
        btn.classList.add('active');
      });
    });

    // Dark mode toggle
    (function () {
      var toggle = document.getElementById('darkToggle');
      var isDark = localStorage.getItem('theme') === 'dark';
      document.documentElement.classList.toggle('dark', isDark);

      toggle.addEventListener('click', function () {
        var nowDark = !document.documentElement.classList.contains('dark');
        document.documentElement.classList.toggle('dark', nowDark);
        localStorage.setItem('theme', nowDark ? 'dark' : 'light');
      });
    })();
  </script>
</body>
</html>
</x-layout.admin_layout>

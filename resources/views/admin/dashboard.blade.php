<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Filedesk · Admin Dashboard</title>

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

    .stat-card {
      transition: transform .25s cubic-bezier(.16,1,.3,1), box-shadow .35s ease, border-color .2s ease;
    }
    .stat-card:hover { transform: translateY(-3px); box-shadow: 0 16px 32px -12px rgba(15,17,23,0.12), 0 4px 12px -4px rgba(15,17,23,0.06); }

    .glass-panel {
      background: rgba(255,255,255,0.6);
      backdrop-filter: blur(8px);
      -webkit-backdrop-filter: blur(8px);
      border: 1px solid rgba(255,255,255,0.5);
    }
    html.dark .glass-panel {
      background: rgba(17,19,24,0.7);
      border-color: rgba(255,255,255,0.06);
    }

    .table-row {
      transition: background-color .2s ease;
    }
    .table-row:hover { background-color: rgba(79,70,229,0.03); }
    html.dark .table-row:hover { background-color: rgba(255,255,255,0.02); }

    .sidebar-link {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 10px 16px;
      border-radius: 12px;
      font-weight: 500;
      color: #5B6472;
      transition: all .2s ease;
    }
    .sidebar-link:hover { background: rgba(79,70,229,0.06); color: #0B0D12; }
    .sidebar-link.active { background: #4F46E5; color: white; box-shadow: 0 8px 18px -6px rgba(79,70,229,0.4); }
    .sidebar-link.active:hover { background: #4338CA; }
    html.dark .sidebar-link { color: #9BA3B4; }
    html.dark .sidebar-link:hover { background: rgba(255,255,255,0.04); color: #E7E9EE; }
    html.dark .sidebar-link.active { background: #4F46E5; color: white; }

    .badge-platform {
      font-size: 10px;
      font-weight: 600;
      padding: 2px 10px;
      border-radius: 100px;
      text-transform: uppercase;
      letter-spacing: 0.02em;
    }

    .dot-pulse {
      animation: pulse-dot 1.6s ease-in-out infinite;
    }
    @keyframes pulse-dot {
      0% { opacity: 0.3; transform: scale(0.95); }
      50% { opacity: 1; transform: scale(1.1); }
      100% { opacity: 0.3; transform: scale(0.95); }
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
  </style>
</head>
<body class="antialiased bg-surface dark:bg-dbg text-ink dark:text-dtext">

  <div class="flex h-screen overflow-hidden">
    <!-- ======= SIDEBAR ======= -->
  <x-basic.sidebar />

    <!-- ======= MAIN ======= -->
    <main class="flex-1 flex flex-col overflow-y-auto">

      <!-- top bar (mobile: sidebar toggle & dark mode) -->
      <header class="sticky top-0 z-10 bg-white/70 dark:bg-dbg/70 backdrop-blur-md border-b border-line dark:border-dline px-5 sm:px-8 py-3 flex items-center justify-between">
        <div class="flex items-center gap-4">
          <button id="mobileMenuBtn" class="lg:hidden p-1.5 -ml-1.5 rounded-lg hover:bg-surface dark:hover:bg-white/5 transition-colors">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6H21M3 12H21M3 18H21" stroke="currentColor"/></svg>
          </button>
          <h1 class="text-lg font-bold tracking-tight text-ink dark:text-white">Dashboard</h1>
          <span class="hidden sm:inline-flex text-xs font-mono bg-brand-light dark:bg-brand/20 text-brand dark:text-brand-light px-2.5 py-0.5 rounded-full">v2.0</span>
        </div>
        <div class="flex items-center gap-3">
          <button id="darkModeToggleTop" class="p-2 rounded-lg hover:bg-surface dark:hover:bg-white/5 transition-colors">
            <span id="darkModeIconTop" class="w-5 h-5 flex items-center justify-center">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M21 12.8A9 9 0 1 1 11.2 3 7 7 0 0 0 21 12.8Z" fill="currentColor"/></svg>
            </span>
          </button>
          <div class="w-8 h-8 rounded-full bg-brand text-white flex items-center justify-center font-semibold text-sm">JD</div>
        </div>
      </header>

      <!-- ====== DASHBOARD CONTENT ====== -->
      <div class="flex-1 px-5 sm:px-8 py-6 space-y-10">

        <!-- stats cards -->
        <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
          <div class="stat-card bg-white dark:bg-dcard border border-line dark:border-dline rounded-2xl p-5 shadow-card">
            <div class="flex items-center justify-between">
              <span class="text-sub dark:text-dsub text-sm font-medium">Total software</span>
              <span class="w-9 h-9 rounded-xl bg-brand-light dark:bg-brand/20 text-brand flex items-center justify-center">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="16" rx="2" stroke="currentColor"/><path d="M3 8H21" stroke="currentColor"/></svg>
              </span>
            </div>
            <p class="text-3xl font-bold mt-2 text-ink dark:text-white">247</p>
            <div class="flex items-center gap-1.5 mt-1 text-sm text-android dark:text-android/80">
              <span>↑ 12%</span>
              <span class="text-sub dark:text-dsub text-xs">vs last month</span>
            </div>
          </div>

          <div class="stat-card bg-white dark:bg-dcard border border-line dark:border-dline rounded-2xl p-5 shadow-card">
            <div class="flex items-center justify-between">
              <span class="text-sub dark:text-dsub text-sm font-medium">Downloads</span>
              <span class="w-9 h-9 rounded-xl bg-win-light dark:bg-win/20 text-win flex items-center justify-center">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 16L12 21L20 16" stroke="currentColor"/><path d="M4 12L12 17L20 12" stroke="currentColor"/><path d="M12 3V12" stroke="currentColor"/><path d="M9 9L12 12L15 9" stroke="currentColor"/></svg>
              </span>
            </div>
            <p class="text-3xl font-bold mt-2 text-ink dark:text-white">1.84M</p>
            <div class="flex items-center gap-1.5 mt-1 text-sm text-android dark:text-android/80">
              <span>↑ 8.3%</span>
              <span class="text-sub dark:text-dsub text-xs">vs last month</span>
            </div>
          </div>

          <div class="stat-card bg-white dark:bg-dcard border border-line dark:border-dline rounded-2xl p-5 shadow-card">
            <div class="flex items-center justify-between">
              <span class="text-sub dark:text-dsub text-sm font-medium">Newsletter subs</span>
              <span class="w-9 h-9 rounded-xl bg-android-light dark:bg-android/20 text-android flex items-center justify-center">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6L12 13L21 6" stroke="currentColor"/><rect x="3" y="4" width="18" height="16" rx="2.5" stroke="currentColor"/></svg>
              </span>
            </div>
            <p class="text-3xl font-bold mt-2 text-ink dark:text-white">68.4K</p>
            <div class="flex items-center gap-1.5 mt-1 text-sm text-android dark:text-android/80">
              <span>↑ 4.2%</span>
              <span class="text-sub dark:text-dsub text-xs">vs last week</span>
            </div>
          </div>

          <div class="stat-card bg-white dark:bg-dcard border border-line dark:border-dline rounded-2xl p-5 shadow-card">
            <div class="flex items-center justify-between">
              <span class="text-sub dark:text-dsub text-sm font-medium">Pending reviews</span>
              <span class="w-9 h-9 rounded-xl bg-amber-50 dark:bg-amber-400/10 text-amber-500 flex items-center justify-center">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10" stroke="currentColor"/><path d="M12 8V12L14 14" stroke="currentColor"/></svg>
              </span>
            </div>
            <p class="text-3xl font-bold mt-2 text-ink dark:text-white">14</p>
            <div class="flex items-center gap-1.5 mt-1 text-sm text-amber-500">
              <span>⚠️ 3 urgent</span>
              <span class="text-sub dark:text-dsub text-xs">needs attention</span>
            </div>
          </div>
        </section>

        <!-- Recent software table + right side (quick actions / newsletter) -->
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

          <!-- table -->
          <div class="xl:col-span-2 bg-white dark:bg-dcard border border-line dark:border-dline rounded-2xl shadow-card overflow-hidden">
            <div class="px-5 py-4 border-b border-line dark:border-dline flex items-center justify-between">
              <h2 class="font-bold text-sm text-ink dark:text-white">Recent software</h2>
              <a href="#" class="text-xs font-semibold text-brand hover:text-brand-dark transition-colors">View all →</a>
            </div>
            <div class="overflow-x-auto">
              <table class="w-full text-sm">
                <thead class="bg-surface dark:bg-dsurface text-sub dark:text-dsub text-[11px] font-semibold uppercase tracking-wider">
                  <tr>
                    <th class="text-left px-5 py-3">App</th>
                    <th class="text-left px-5 py-3">Platform</th>
                    <th class="text-left px-5 py-3">Category</th>
                    <th class="text-left px-5 py-3">Downloads</th>
                    <th class="text-left px-5 py-3">Rating</th>
                  </tr>
                </thead>
                <tbody class="divide-y divide-line dark:divide-dline">
                  <tr class="table-row">
                    <td class="px-5 py-3.5 flex items-center gap-3">
                      <span class="w-8 h-8 rounded-lg bg-win text-white flex items-center justify-center text-[12px] font-bold">Nx</span>
                      <span class="font-medium">Nexus Cleaner</span>
                    </td>
                    <td class="px-5 py-3.5"><span class="badge-platform bg-win-light text-win dark:bg-win/20 dark:text-win-light">Windows</span></td>
                    <td class="px-5 py-3.5 text-sub dark:text-dsub">System Utilities</td>
                    <td class="px-5 py-3.5 font-mono text-sub dark:text-dsub">842K</td>
                    <td class="px-5 py-3.5 flex items-center gap-1"><span class="star text-amber-500">★★★★★</span> <span class="text-sub dark:text-dsub text-xs ml-1">4.8</span></td>
                  </tr>
                  <tr class="table-row">
                    <td class="px-5 py-3.5 flex items-center gap-3">
                      <span class="w-8 h-8 rounded-lg bg-mac text-white flex items-center justify-center text-[12px] font-bold">Fl</span>
                      <span class="font-medium">Flowdesk</span>
                    </td>
                    <td class="px-5 py-3.5"><span class="badge-platform bg-mac-light text-mac dark:bg-mac/20 dark:text-mac-light">macOS</span></td>
                    <td class="px-5 py-3.5 text-sub dark:text-dsub">Productivity</td>
                    <td class="px-5 py-3.5 font-mono text-sub dark:text-dsub">298K</td>
                    <td class="px-5 py-3.5 flex items-center gap-1"><span class="star text-amber-500">★★★★★</span> <span class="text-sub dark:text-dsub text-xs ml-1">4.9</span></td>
                  </tr>
                  <tr class="table-row">
                    <td class="px-5 py-3.5 flex items-center gap-3">
                      <span class="w-8 h-8 rounded-lg bg-android text-white flex items-center justify-center text-[12px] font-bold">Rn</span>
                      <span class="font-medium">RunTrack</span>
                    </td>
                    <td class="px-5 py-3.5"><span class="badge-platform bg-android-light text-android dark:bg-android/20 dark:text-android-light">Android</span></td>
                    <td class="px-5 py-3.5 text-sub dark:text-dsub">Health &amp; Fitness</td>
                    <td class="px-5 py-3.5 font-mono text-sub dark:text-dsub">705K</td>
                    <td class="px-5 py-3.5 flex items-center gap-1"><span class="star text-amber-500">★★★★★</span> <span class="text-sub dark:text-dsub text-xs ml-1">4.7</span></td>
                  </tr>
                  <tr class="table-row">
                    <td class="px-5 py-3.5 flex items-center gap-3">
                      <span class="w-8 h-8 rounded-lg bg-rose-500 text-white flex items-center justify-center text-[12px] font-bold">Sn</span>
                      <span class="font-medium">SnapNote</span>
                    </td>
                    <td class="px-5 py-3.5"><span class="badge-platform bg-mac-light text-mac dark:bg-mac/20 dark:text-mac-light">macOS</span></td>
                    <td class="px-5 py-3.5 text-sub dark:text-dsub">Notes</td>
                    <td class="px-5 py-3.5 font-mono text-sub dark:text-dsub">124K</td>
                    <td class="px-5 py-3.5 flex items-center gap-1"><span class="star text-amber-500">★★★★☆</span> <span class="text-sub dark:text-dsub text-xs ml-1">4.3</span></td>
                  </tr>
                  <tr class="table-row">
                    <td class="px-5 py-3.5 flex items-center gap-3">
                      <span class="w-8 h-8 rounded-lg bg-indigo-500 text-white flex items-center justify-center text-[12px] font-bold">Pk</span>
                      <span class="font-medium">PacketPro</span>
                    </td>
                    <td class="px-5 py-3.5"><span class="badge-platform bg-win-light text-win dark:bg-win/20 dark:text-win-light">Windows</span></td>
                    <td class="px-5 py-3.5 text-sub dark:text-dsub">Network</td>
                    <td class="px-5 py-3.5 font-mono text-sub dark:text-dsub">96K</td>
                    <td class="px-5 py-3.5 flex items-center gap-1"><span class="star text-amber-500">★★★★☆</span> <span class="text-sub dark:text-dsub text-xs ml-1">4.1</span></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

          <!-- right sidebar: newsletter & quick actions -->
          <div class="space-y-5">
            <!-- newsletter card -->
            <div class="bg-white dark:bg-dcard border border-line dark:border-dline rounded-2xl p-5 shadow-card">
              <div class="flex items-center gap-3">
                <span class="w-10 h-10 rounded-xl bg-brand/10 text-brand flex items-center justify-center">
                  <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M3 6L12 13L21 6" stroke="currentColor"/><rect x="3" y="4" width="18" height="16" rx="2.5" stroke="currentColor"/></svg>
                </span>
                <div>
                  <p class="text-sm font-bold text-ink dark:text-white">Newsletter</p>
                  <p class="text-xs text-sub dark:text-dsub">68,400 subscribers</p>
                </div>
              </div>
              <div class="mt-4 space-y-2.5">
                <div class="flex items-center justify-between text-sm">
                  <span class="text-sub dark:text-dsub">Open rate</span>
                  <span class="font-semibold text-ink dark:text-white">46%</span>
                </div>
                <div class="flex items-center justify-between text-sm">
                  <span class="text-sub dark:text-dsub">Click rate</span>
                  <span class="font-semibold text-ink dark:text-white">12.3%</span>
                </div>
                <div class="flex items-center justify-between text-sm">
                  <span class="text-sub dark:text-dsub">Last sent</span>
                  <span class="font-mono text-xs text-sub dark:text-dsub">2 days ago</span>
                </div>
                <button class="w-full mt-2 py-2.5 rounded-xl bg-brand text-white text-sm font-semibold hover:bg-brand-dark transition-colors shadow-sm">Create new issue</button>
              </div>
            </div>

            <!-- quick actions -->
            <div class="bg-white dark:bg-dcard border border-line dark:border-dline rounded-2xl p-5 shadow-card">
              <h3 class="text-sm font-bold text-ink dark:text-white mb-3">Quick actions</h3>
              <div class="grid grid-cols-2 gap-2">
                <button class="flex flex-col items-center justify-center gap-1.5 p-3 rounded-xl bg-surface dark:bg-white/5 hover:bg-brand-light dark:hover:bg-white/10 transition-colors">
                  <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 5V19M5 12H19" stroke="currentColor"/></svg>
                  <span class="text-[11px] font-medium text-sub dark:text-dsub">Add app</span>
                </button>
                <button class="flex flex-col items-center justify-center gap-1.5 p-3 rounded-xl bg-surface dark:bg-white/5 hover:bg-brand-light dark:hover:bg-white/10 transition-colors">
                  <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 6H20M4 12H20M4 18H12" stroke="currentColor"/></svg>
                  <span class="text-[11px] font-medium text-sub dark:text-dsub">New category</span>
                </button>
                <button class="flex flex-col items-center justify-center gap-1.5 p-3 rounded-xl bg-surface dark:bg-white/5 hover:bg-brand-light dark:hover:bg-white/10 transition-colors">
                  <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M3 6L12 13L21 6" stroke="currentColor"/><rect x="3" y="4" width="18" height="16" rx="2.5" stroke="currentColor"/></svg>
                  <span class="text-[11px] font-medium text-sub dark:text-dsub">Draft email</span>
                </button>
                <button class="flex flex-col items-center justify-center gap-1.5 p-3 rounded-xl bg-surface dark:bg-white/5 hover:bg-brand-light dark:hover:bg-white/10 transition-colors">
                  <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M16 21V19C16 16.8 14.2 15 12 15H5C2.8 15 1 16.8 1 19V21" stroke="currentColor"/><circle cx="8.5" cy="7.5" r="4.5" stroke="currentColor"/></svg>
                  <span class="text-[11px] font-medium text-sub dark:text-dsub">Manage users</span>
                </button>
              </div>
            </div>
          </div>
        </div>

        <!-- footer (minimal) -->
        <footer class="border-t border-line dark:border-dline pt-6 mt-6 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-sub dark:text-dsub">
          <span>© 2026 Filedesk · Admin panel</span>
          <div class="flex items-center gap-5">
            <a href="#" class="footer-link">Privacy</a>
            <a href="#" class="footer-link">Terms</a>
            <a href="#" class="footer-link">Support</a>
          </div>
        </footer>

      </div>
    </main>
  </div>

  <script>
    (function() {
      // unified dark mode toggle (syncs all buttons)
      const toggleButtons = [
        document.getElementById('darkModeToggleSidebar'),
        document.getElementById('darkModeToggleTop')
      ];
      const iconElements = [
        document.getElementById('darkModeIconSidebar'),
        document.getElementById('darkModeIconTop')
      ];

      const sun = '<path d="M12 5V2.5M12 21.5V19M19 12H21.5M2.5 12H5M17.7 6.3L19.4 4.6M4.6 19.4L6.3 17.7M17.7 17.7L19.4 19.4M4.6 4.6L6.3 6.3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><circle cx="12" cy="12" r="4.5" fill="currentColor"/>';
      const moon = '<path d="M21 12.8A9 9 0 1 1 11.2 3 7 7 0 0 0 21 12.8Z" fill="currentColor"/>';

      let isDark = localStorage.getItem('theme') === 'dark';
      document.documentElement.classList.toggle('dark', isDark);
      iconElements.forEach(el => el.innerHTML = isDark ? sun : moon);

      function toggleTheme() {
        isDark = !isDark;
        document.documentElement.classList.toggle('dark', isDark);
        iconElements.forEach(el => el.innerHTML = isDark ? sun : moon);
        localStorage.setItem('theme', isDark ? 'dark' : 'light');
      }

      toggleButtons.forEach(btn => {
        if (btn) btn.addEventListener('click', toggleTheme);
      });

      // mobile sidebar toggle (simple)
      const mobileBtn = document.getElementById('mobileMenuBtn');
      const sidebar = document.querySelector('aside');
      if (mobileBtn && sidebar) {
        mobileBtn.addEventListener('click', function(e) {
          e.stopPropagation();
          sidebar.classList.toggle('hidden');
        });
        // click outside closes sidebar on mobile
        document.addEventListener('click', function(e) {
          if (window.innerWidth < 1024 && sidebar && !sidebar.contains(e.target) && e.target !== mobileBtn) {
            sidebar.classList.add('hidden');
          }
        });
      }
    })();
  </script>
</body>
</html>
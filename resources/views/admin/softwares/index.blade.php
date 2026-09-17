<x-layout.admin_layout>
    <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Filedesk · Software</title>

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
            banner: '0 24px 48px -16px rgba(79,70,229,0.35)',
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

    .stat-card, .app-card {
      transition: transform .25s cubic-bezier(.16,1,.3,1), box-shadow .35s ease, border-color .2s ease;
    }
    .app-card:hover { transform: translateY(-3px); box-shadow: 0 16px 32px -12px rgba(15,17,23,0.12), 0 4px 12px -4px rgba(15,17,23,0.06); }

    .sidebar-link {
      display: flex; align-items: center; gap: 12px; padding: 10px 16px;
      border-radius: 12px; font-weight: 500; color: #5B6472; transition: all .2s ease;
    }
    .sidebar-link:hover { background: rgba(79,70,229,0.06); color: #0B0D12; }
    .sidebar-link.active { background: #4F46E5; color: white; box-shadow: 0 8px 18px -6px rgba(79,70,229,0.4); }
    html.dark .sidebar-link { color: #9BA3B4; }
    html.dark .sidebar-link:hover { background: rgba(255,255,255,0.04); color: #E7E9EE; }
    html.dark .sidebar-link.active { background: #4F46E5; color: white; }

    .badge-platform {
      font-size: 10px; font-weight: 600; padding: 2px 10px; border-radius: 100px;
      text-transform: uppercase; letter-spacing: 0.02em;
    }

    /* ---- Hero banner ---- */
    .hero-banner {
      position: relative;
      overflow: hidden;
      background: radial-gradient(120% 160% at 0% 0%, #6C63F1 0%, #4F46E5 45%, #3B32C9 100%);
    }
    .hero-banner::before {
      content: '';
      position: absolute; inset: 0;
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
    .hero-icon-float {
      animation: floaty 5s ease-in-out infinite;
    }
    @keyframes floaty {
      0%, 100% { transform: translateY(0) rotate(0deg); }
      50% { transform: translateY(-8px) rotate(3deg); }
    }

    /* ---- Table header banner row ---- */
    .table-head-banner {
      background: linear-gradient(90deg, #4F46E5 0%, #6C63F1 55%, #4338CA 100%);
    }
    .table-head-banner th { color: rgba(255,255,255,0.92); }

    .table-row { transition: background-color .2s ease; }
    .table-row:hover { background-color: rgba(79,70,229,0.035); }
    html.dark .table-row:hover { background-color: rgba(255,255,255,0.02); }

    .thumb {
      box-shadow: 0 6px 14px -6px rgba(15,17,23,0.25);
    }

    .icon-btn {
      width: 34px; height: 34px; border-radius: 10px;
      display: inline-flex; align-items: center; justify-content: center;
      transition: all .18s ease;
    }
    .icon-btn.edit { background: rgba(79,70,229,0.08); color: #4F46E5; }
    .icon-btn.edit:hover { background: #4F46E5; color: #fff; transform: translateY(-1px); }
    .icon-btn.delete { background: rgba(225,29,72,0.08); color: #E11D48; }
    .icon-btn.delete:hover { background: #E11D48; color: #fff; transform: translateY(-1px); }
    html.dark .icon-btn.edit { background: rgba(79,70,229,0.16); }
    html.dark .icon-btn.delete { background: rgba(225,29,72,0.16); }

    .footer-link {
      position: relative; display: inline-block; padding-bottom: 1px;
      background-image: linear-gradient(currentColor, currentColor);
      background-repeat: no-repeat; background-position: 0 100%; background-size: 0% 1.5px;
      transition: background-size .25s cubic-bezier(.16,1,.3,1), color .2s ease;
    }
    .footer-link:hover { background-size: 100% 1.5px; }
  </style>
</head>
<body class="antialiased bg-surface dark:bg-dbg text-ink dark:text-dtext">

  
    <!-- ======= SIDEBAR (component — 260px, kept as-is) ======= -->
    

    <!-- ======= MAIN ======= -->
    <main class="flex-1 flex flex-col overflow-y-auto">

      <!-- top bar -->
      <header class="sticky top-0 z-10 bg-white/70 dark:bg-dbg/70 backdrop-blur-md border-b border-line dark:border-dline px-5 sm:px-8 py-3 flex items-center justify-between">
        <div class="flex items-center gap-4">
          <button id="mobileMenuBtn" class="lg:hidden p-1.5 -ml-1.5 rounded-lg hover:bg-surface dark:hover:bg-white/5 transition-colors">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6H21M3 12H21M3 18H21" stroke="currentColor"/></svg>
          </button>
          <h1 class="text-lg font-bold tracking-tight text-ink dark:text-white">Software</h1>
          <span class="hidden sm:inline-flex text-xs font-mono bg-brand-light dark:bg-brand/20 text-brand dark:text-brand-light px-2.5 py-0.5 rounded-full">247 total</span>
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

      <!-- ====== PAGE CONTENT ====== -->
      <div class="flex-1 px-5 sm:px-8 py-6 space-y-8">

        <!-- ===== HERO / PAGE BANNER ===== -->
        <section class="hero-banner rounded-2xl shadow-banner px-6 sm:px-10 py-9 sm:py-12">
          <div class="grid-overlay"></div>
          <div class="relative flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
            <div class="max-w-xl">
              <span class="inline-flex items-center gap-1.5 text-[11px] font-semibold uppercase tracking-wider text-white/70 bg-white/10 px-3 py-1 rounded-full">
                Library
              </span>
              <h2 class="mt-4 text-3xl sm:text-4xl font-extrabold text-white tracking-tight">All Software</h2>
              <p class="mt-2.5 text-sm sm:text-[15px] text-white/75 leading-relaxed">
                Every app you publish on Filedesk, in one place — manage titles, thumbnails, categories and listings without leaving this page.
              </p>
            </div>
            <div class="flex items-center gap-3 sm:gap-4 shrink-0">
              <div class="hidden sm:flex flex-col items-end pr-4 border-r border-white/15">
                <span class="text-2xl font-bold text-white font-mono">247</span>
                <span class="text-[11px] text-white/60">published apps</span>
              </div>
              <span class="hero-icon-float hidden sm:flex w-16 h-16 rounded-2xl bg-white/10 border border-white/15 items-center justify-center">
                <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="1.8"><rect x="3" y="4" width="18" height="16" rx="2.5" stroke="#fff"/><path d="M3 9H21" stroke="#fff"/><circle cx="6.5" cy="6.5" r=".6" fill="#fff"/><circle cx="9" cy="6.5" r=".6" fill="#fff"/></svg>
              </span>
            </div>
          </div>
        </section>

        <!-- ===== SOFTWARE TABLE (CRUD) ===== -->
        <div class="bg-white dark:bg-dcard border border-line dark:border-dline rounded-2xl shadow-card overflow-hidden">
          <div class="px-5 sm:px-6 py-4 border-b border-line dark:border-dline flex flex-wrap items-center justify-between gap-3">
            <div>
              <h2 class="font-bold text-sm text-ink dark:text-white">Manage software</h2>
              <p class="text-xs text-sub dark:text-dsub mt-0.5">Add, edit or remove listings</p>
            </div>
            <a href="{{ route('softwares.create')}}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-brand text-white text-sm font-semibold hover:bg-brand-dark transition-colors shadow-sm">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M12 5V19M5 12H19" stroke="currentColor"/></svg>
              Add software
</a>
          </div>

          <div class="overflow-x-auto">
            <table class="w-full text-sm">
              <thead class="table-head-banner text-[11px] font-semibold uppercase tracking-wider">
                <tr>
                  <th class="text-left px-5 sm:px-6 py-4">Thumbnail</th>
                  <th class="text-left px-5 sm:px-6 py-4">Software</th>
                  <th class="text-left px-5 sm:px-6 py-4">Category</th>
                  <th class="text-left px-5 sm:px-6 py-4">Subcategory</th>
                  <th class="text-right px-5 sm:px-6 py-4">Actions</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-line dark:divide-dline">

                <!-- card 1 -->
                 @foreach($softwares as $software)
                <tr class="table-row app-card">
                  <td class="px-5 sm:px-6 py-4">
    <img
        
    src="{{ asset('storage/' . $software->icon) }}"
    alt="{{ $software->title }}"
   class="w-16 h-16 rounded-xl object-cover border border-slate-200 shadow-sm"

    >
</td>
                  <td class="px-5 sm:px-6 py-4">
                    <p class="font-semibold text-ink dark:text-white">{{$software->title}}</p>
                    <p class="text-xs text-sub dark:text-dsub mt-0.5">{{ Str::limit($software->short_description, 15) }}</p>
                  </td>
                  <td class="px-5 sm:px-6 py-4">
                    <span class="badge-platform bg-win-light text-win dark:bg-win/20 dark:text-win-light">{{ $software->category?->name }}</span>
                  </td>
                  <td class="px-5 sm:px-6 py-4 text-sub dark:text-dsub">{{ $software->subcategory?->name }}</td>
                  <td class="px-5 sm:px-6 py-4">
                    <div class="flex items-center justify-end gap-2">
                      <a class="icon-btn edit" title="Edit" href="{{ route('softwares.edit', $software->slug) }}">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20H21" stroke="currentColor"/><path d="M16.5 3.5A2.1 2.1 0 0 1 19.5 6.5L7 19L3 20L4 16L16.5 3.5Z" stroke="currentColor"/></svg>
</a>
                      <form action="{{ route('softwares.destroy', $software->slug) }}"
      method="POST"
      style="display:inline-block;"
      onsubmit="return confirm('Are you sure you want to delete this software?')">

    @csrf
    @method('DELETE')

    <button type="submit" class="icon-btn delete" title="Delete">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M4 7H20"/>
            <path d="M9 7V4.5C9 4 9.4 3.5 10 3.5H14C14.6 3.5 15 4 15 4.5V7"/>
            <path d="M6 7L7 20.5C7 21 7.4 21.5 8 21.5H16C16.6 21 17 20.5L18 7"/>
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

          <div class="px-5 sm:px-6 py-3.5 border-t border-line dark:border-dline flex items-center justify-between text-xs text-sub dark:text-dsub">
            <span>Showing 2 of 247 software</span>
            <div class="flex items-center gap-1">
              <button class="px-3 py-1.5 rounded-lg hover:bg-surface dark:hover:bg-white/5 transition-colors">Prev</button>
              <button class="px-3 py-1.5 rounded-lg bg-brand-light dark:bg-brand/20 text-brand dark:text-brand-light font-semibold">1</button>
              <button class="px-3 py-1.5 rounded-lg hover:bg-surface dark:hover:bg-white/5 transition-colors">Next</button>
            </div>
          </div>
        </div>

        <!-- footer -->
        <footer class="border-t border-line dark:border-dline pt-6 mt-2 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-sub dark:text-dsub">
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
      const toggleButtons = [
        document.getElementById('darkModeToggleSidebar'),
        document.getElementById('darkModeToggleTop')
      ];
      const iconElements = [
        document.getElementById('darkModeIconSidebar'),
        document.getElementById('darkModeIconTop')
      ].filter(Boolean);

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

      toggleButtons.forEach(btn => { if (btn) btn.addEventListener('click', toggleTheme); });

      const mobileBtn = document.getElementById('mobileMenuBtn');
      const sidebar = document.querySelector('aside');
      if (mobileBtn && sidebar) {
        mobileBtn.addEventListener('click', function(e) {
          e.stopPropagation();
          sidebar.classList.toggle('hidden');
        });
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
</x-layout.admin_layout>
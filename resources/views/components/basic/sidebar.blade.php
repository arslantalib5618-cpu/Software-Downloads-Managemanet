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
    <aside class="w-[260px] shrink-0 hidden lg:flex flex-col bg-white dark:bg-dcard border-r border-line dark:border-dline h-full overflow-y-auto">
      <div class="px-6 pt-8 pb-4 border-b border-line dark:border-dline">
        <div class="flex items-center gap-3">
          <span class="w-8 h-8 rounded-xl bg-brand text-white flex items-center justify-center font-bold text-sm">F</span>
          <span class="text-xl font-bold tracking-tight text-ink dark:text-white">Filedesk</span>
          <span class="ml-auto text-[10px] font-mono uppercase bg-brand-light dark:bg-brand/20 text-brand dark:text-brand-light px-2 py-0.5 rounded-full">admin</span>
        </div>
      </div>

      <nav class="flex-1 px-4 py-6 space-y-1.5">
        <a href="{{ route('dashboard') }}" class="sidebar-link active">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 12L5 10M21 12L19 10M12 3V5M12 19V21M5 5L7 7M17 17L19 19M5 19L7 17M17 7L19 5" stroke="currentColor" stroke-linecap="round"/><circle cx="12" cy="12" r="3" stroke="currentColor"/></svg>
          Dashboard
        </a>
        <a href="{{ route('softwares.index') }}" class="sidebar-link">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="16" rx="2" stroke="currentColor"/><path d="M3 8H21" stroke="currentColor"/></svg>
          All Software
        </a>
        <a href="{{ route('newsletter.index') }}" class="sidebar-link">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 6H20M4 12H20M4 18H12" stroke="currentColor" stroke-linecap="round"/></svg>
          Newsletter
        </a>
        <a href="#" class="sidebar-link">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2L2 7L12 12L22 7L12 2Z" stroke="currentColor"/><path d="M2 17L12 22L22 17" stroke="currentColor"/><path d="M2 12L12 17L22 12" stroke="currentColor"/></svg>
          Categories
        </a>
        <a href="#" class="sidebar-link">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21V19C16 16.8 14.2 15 12 15H5C2.8 15 1 16.8 1 19V21" stroke="currentColor"/><circle cx="8.5" cy="7.5" r="4.5" stroke="currentColor"/></svg>
          Admins
        </a>
      </nav>

      <div class="px-4 pb-6">
        <button id="darkModeToggleSidebar" class="flex items-center gap-3 w-full px-4 py-2.5 rounded-xl bg-surface dark:bg-white/5 text-sub dark:text-dsub text-sm font-medium hover:bg-brand-light dark:hover:bg-white/10 transition-colors">
          <span id="darkModeIconSidebar" class="w-5 h-5 flex items-center justify-center">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M21 12.8A9 9 0 1 1 11.2 3 7 7 0 0 0 21 12.8Z" fill="currentColor"/></svg>
          </span>
          <span>Toggle theme</span>
        </button>
      </div>
    </aside>
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
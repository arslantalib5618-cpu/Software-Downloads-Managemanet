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

{{ $slot }}
</body>
</html>
<x-layout.admin_layout>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Filedesk · {{ isset($software) ? 'Edit Software' : 'Add Software' }}</title>

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

  <!-- CKEditor 5 (Classic build) -->
  <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>

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
    .ambient-bg {
      position: fixed; inset: 0; z-index: -1; overflow: hidden; pointer-events: none;
    }
    .ambient-bg span {
      position: absolute; border-radius: 50%; filter: blur(90px); opacity: .35;
    }
    .ambient-bg .b1 { width: 460px; height: 460px; top: -180px; right: -120px; background: #6C63F1; }
    .ambient-bg .b2 { width: 380px; height: 380px; bottom: -160px; left: -140px; background: #2FB170; opacity: .12; }
    html.dark .ambient-bg span { opacity: .16; }

    /* ---- Hero banner ---- */
    .hero-banner {
      position: relative;
      overflow: hidden;
      background: radial-gradient(120% 160% at 0% 0%, #6C63F1 0%, #4F46E5 45%, #362DB8 100%);
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
    .section-card.accent-win::before { background: linear-gradient(90deg, #0F7BE0, #4FB3FF); }
    .section-card.accent-android::before { background: linear-gradient(90deg, #2FB170, #6EE7A8); }
    .section-card.accent-amber::before { background: linear-gradient(90deg, #B45309, #F0A94E); }
    .section-card.accent-mac::before { background: linear-gradient(90deg, #171821, #4B4F5E); }

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
    .field-label { display: flex; align-items: center; gap: 5px; font-size: 12.5px; font-weight: 600; color: #3D4452; margin-bottom: 8px; }
    html.dark .field-label { color: #C4CADA; }
    .field-label .req { color: #E11D48; font-weight: 700; }

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

    /* ---- Error state ---- */
    .field-input.has-error { border-color: #E11D48; background: #FEF1F4; }
    .field-input.has-error:focus { border-color: #E11D48; box-shadow: 0 0 0 4px rgba(225,29,72,0.10); }
    html.dark .field-input.has-error { background: rgba(225,29,72,0.08); border-color: #E11D48; }
    .field-error {
      display: flex; align-items: center; gap: 5px;
      font-size: 11.5px; font-weight: 600; color: #E11D48; margin-top: 6px;
    }
    .upload-box.has-error { border-color: #E11D48; background: #FEF1F4; }
    html.dark .upload-box.has-error { background: rgba(225,29,72,0.08); }

    select.field-input {
      appearance: none; cursor: pointer;
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%235B6472' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
      background-repeat: no-repeat; background-position: right 14px center; padding-right: 40px;
    }

    .input-with-icon { position: relative; }
    .input-with-icon .field-input { padding-left: 42px; }
    .input-with-icon .input-icon {
      position: absolute; left: 14px; top: 60%; transform: translateY(-50%);
      color: #A6AEBB; pointer-events: none;
    }

    /* ---- Upload boxes ---- */
    .upload-box {
      border: 1.75px dashed #D3D7E0; border-radius: 16px;
      background: linear-gradient(180deg, #FBFBFD 0%, #F4F5F9 100%);
      display: flex; flex-direction: column; align-items: center; justify-content: center;
      padding: 16px 10px; text-align: center; cursor: pointer;
      transition: all .25s cubic-bezier(.16,1,.3,1);
      position: relative; overflow: hidden;
    }
    .upload-box:hover {
      border-color: #4F46E5; background: #EEF0FF;
      transform: translateY(-3px);
      box-shadow: 0 14px 28px -12px rgba(79,70,229,0.4);
    }
    .upload-box.has-image { border-style: solid; border-color: #E7E9ED; padding: 0; }
    html.dark .upload-box { border-color: rgba(255,255,255,0.14); background: linear-gradient(180deg, #14161C 0%, #0E1015 100%); }
    html.dark .upload-box:hover { border-color: #4F46E5; background: rgba(79,70,229,0.12); }
    html.dark .upload-box.has-image { border-color: rgba(255,255,255,0.12); }

    .upload-box img.preview { width: 100%; height: 100%; object-fit: cover; border-radius: 14px; position: absolute; inset: 0; }
    .upload-box .remove-badge {
      position: absolute; top: 6px; right: 6px; z-index: 2;
      width: 22px; height: 22px; border-radius: 8px; background: rgba(11,13,18,0.65);
      color: #fff; display: none; align-items: center; justify-content: center;
      transition: background-color .15s ease, transform .15s ease;
    }
    .upload-box .remove-badge:hover { background: rgba(225,29,72,0.85); transform: scale(1.08); }
    .upload-box.has-image .remove-badge { display: flex; }

    .upload-icon-circle {
      width: 34px; height: 34px; border-radius: 10px; background: #fff; border: 1px solid #E7E9ED;
      display: flex; align-items: center; justify-content: center; margin-bottom: 8px;
      box-shadow: 0 1px 2px rgba(15,17,23,0.05);
    }
    html.dark .upload-icon-circle { background: #1B1E27; border-color: rgba(255,255,255,0.1); }

    .screenshot-counter {
      font-size: 11px; font-weight: 700; padding: 4px 11px; border-radius: 100px;
      background: #F1F2F5; color: #5B6472; font-family: 'JetBrains Mono', monospace;
      transition: all .2s ease;
    }
    .screenshot-counter.complete { background: #E9FBF1; color: #1F8F58; }
    html.dark .screenshot-counter { background: rgba(255,255,255,0.06); color: #9BA3B4; }
    html.dark .screenshot-counter.complete { background: rgba(47,177,112,0.18); color: #6EE7A8; }

    /* ---- CKEditor theming to match card ---- */
    .editor-wrap .ck.ck-editor__top .ck-sticky-panel .ck-toolbar {
      border: 1.5px solid #E7E9ED; border-bottom: none;
      border-top-left-radius: 13px; border-top-right-radius: 13px;
      background: #FBFBFD; padding: 8px;
    }
    .editor-wrap .ck.ck-editor__main > .ck-editor__editable {
      border: 1.5px solid #E7E9ED; border-top: none;
      border-bottom-left-radius: 13px; border-bottom-right-radius: 13px;
      background: #FBFBFD; min-height: 220px; font-size: 14px; padding: 16px 18px;
    }
    .editor-wrap .ck.ck-editor__main > .ck-editor__editable:not(.ck-focused) { box-shadow: none; }
    .editor-wrap .ck.ck-editor__main > .ck-editor__editable.ck-focused {
      border-color: #4F46E5 !important; box-shadow: 0 0 0 4px rgba(79,70,229,0.10) !important; background: #fff;
    }
    .editor-wrap .ck.ck-toolbar { --ck-color-toolbar-border: #E7E9ED; }
    .editor-wrap.has-error .ck.ck-editor__main > .ck-editor__editable { border-color: #E11D48; }
    html.dark .editor-wrap .ck.ck-editor__top .ck-sticky-panel .ck-toolbar,
    html.dark .editor-wrap .ck.ck-editor__main > .ck-editor__editable {
      background: #0E1015; border-color: rgba(255,255,255,0.1); color: #E7E9EE;
    }
    html.dark .editor-wrap .ck.ck-editor__main > .ck-editor__editable.ck-focused {
      background: #121520; box-shadow: 0 0 0 4px rgba(79,70,229,0.18) !important;
    }
    html.dark .editor-wrap .ck.ck-toolbar { --ck-color-toolbar-background: #0E1015; --ck-color-button-default-hover-background: rgba(255,255,255,0.06); }
    html.dark .editor-wrap .ck-icon { color: #C4CADA; }

    /* ---- Sticky action bar ---- */
    .action-bar {
      position: sticky; bottom: 0; z-index: 10;
      background: rgba(249,249,251,0.85); backdrop-filter: blur(12px);
      border-top: 1px solid #ECEDF1;
    }
    html.dark .action-bar { background: rgba(10,11,15,0.85); border-color: rgba(255,255,255,0.09); }

    .btn-primary {
      position: relative; overflow: hidden;
      display: inline-flex; align-items: center; gap: 8px;
      padding: 12px 26px; border-radius: 13px;
      background: linear-gradient(135deg, #4F46E5, #4338CA);
      color: #fff; font-size: 14px; font-weight: 600;
      box-shadow: 0 12px 28px -10px rgba(79,70,229,0.5);
      transition: transform .18s ease, box-shadow .18s ease, filter .18s ease;
    }
    .btn-primary::after {
      content: ''; position: absolute; inset: 0;
      background: linear-gradient(120deg, transparent 30%, rgba(255,255,255,0.25) 50%, transparent 70%);
      transform: translateX(-100%);
      transition: transform .6s ease;
    }
    .btn-primary:hover::after { transform: translateX(100%); }
    .btn-primary:hover { transform: translateY(-1px); filter: brightness(1.05); box-shadow: 0 16px 32px -10px rgba(79,70,229,0.6); }
    .btn-primary:active { transform: translateY(0); }

    .btn-ghost {
      padding: 12px 22px; border-radius: 13px; font-size: 14px; font-weight: 600;
      color: #5B6472; transition: background-color .18s ease;
    }
    .btn-ghost:hover { background: #F1F2F5; }
    html.dark .btn-ghost { color: #9BA3B4; }
    html.dark .btn-ghost:hover { background: rgba(255,255,255,0.06); }
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
          <h1 class="text-lg font-bold tracking-tight text-ink dark:text-white leading-tight">{{ isset($software) ? 'Edit software' : 'Add software' }}</h1>
          <p class="text-[11px] text-sub dark:text-dsub font-mono">Software / {{ isset($software) ? 'Edit' : 'New' }}</p>
        </div>
      </div>
      <div class="w-8 h-8 rounded-full bg-brand text-white flex items-center justify-center font-semibold text-sm">JD</div>
    </header>

    <!-- ====== PAGE CONTENT ====== -->
    <div class="flex-1 px-5 sm:px-8 py-6 space-y-6 max-w-4xl w-full mx-auto">

      <!-- ===== HERO / PAGE BANNER ===== -->
      <section class="hero-banner rounded-2xl shadow-banner px-6 sm:px-10 py-9 sm:py-11">
        <div class="grid-overlay"></div>
        <div class="relative flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
          <div class="max-w-xl">
            <span class="inline-flex items-center gap-1.5 text-[11px] font-semibold uppercase tracking-wider text-white/70 bg-white/10 px-3 py-1 rounded-full">
              {{ isset($software) ? 'Edit listing' : 'New listing' }}
            </span>
            <h2 class="mt-4 text-3xl sm:text-4xl font-extrabold text-white tracking-tight">{{ isset($software) ? 'Edit software' : 'Add software' }}</h2>
            <p class="mt-2.5 text-sm sm:text-[15px] text-white/75 leading-relaxed">
              {{ isset($software) ? "Update the details below and save your changes." : "Fill in the details below to publish a new app on Filedesk." }}
            </p>
            <div class="flex flex-wrap items-center gap-2 mt-5">
              <span class="step-pill"><span class="dot"></span>Icon</span>
              <span class="step-pill"><span class="dot"></span>Details</span>
              <span class="step-pill"><span class="dot"></span>Links</span>
              <span class="step-pill"><span class="dot"></span>Screenshots</span>
              <span class="step-pill"><span class="dot"></span>Description</span>
            </div>
          </div>
          <span class="hero-icon-float hidden sm:flex w-16 h-16 rounded-2xl bg-white/10 border border-white/15 items-center justify-center">
            <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="1.8"><path d="M12 5V19M5 12H19" stroke="#fff"/></svg>
          </span>
        </div>
      </section>

      <!-- ===== FORM ===== -->
      <form action="{{ isset($software) ? route('softwares.update', $software->slug) : route('softwares.store') }}" method="POST" enctype="multipart/form-data" id="softwareForm" class="space-y-6 pb-4" novalidate>
        @csrf
        @if(isset($software))
          @method('PUT')
        @endif

        <!-- Icon -->
       <div class="section-card p-5 sm:p-7">
    <div class="section-head">
        <div class="section-icon bg-brand-light dark:bg-brand/20 text-brand">
            <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <rect x="3" y="4" width="18" height="16" rx="2.5"/>
                <circle cx="9" cy="10" r="1.5"/>
                <path d="M21 16L15.5 10.5C15.1 10.1 14.4 10.1 14 10.5L6 18.5"/>
            </svg>
        </div>

        <div>
            <span class="section-num">01</span>
            <h3 class="section-title">App Icon</h3>
            <p class="section-sub">
                Square image, shown across cards and listings.
            </p>
        </div>
    </div>

    <div class="mt-6 w-32">
        <label
            for="icon"
            class="upload-box h-32 @error('icon') has-error @enderror {{ !empty($software->icon) ? 'has-image' : '' }}"
        >

            <img
                id="iconPreview"
                src="{{ !empty($software->icon) ? asset('storage/'.$software->icon) : '' }}"
                alt="Software Icon"
                class="preview {{ !empty($software->icon) ? '' : 'hidden' }}"
            >

            <span
                id="iconRemove"
                class="remove-badge"
                role="button"
                tabindex="0"
                onclick="removeImage(event,'icon','iconPreview','iconPlaceholder','iconRemove')"
            >
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M6 6L18 18M18 6L6 18"/>
                </svg>
            </span>

            <span
                id="iconPlaceholder"
                class="flex flex-col items-center {{ !empty($software->icon) ? 'hidden' : '' }}"
            >
                <span class="upload-icon-circle">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#5B6472" stroke-width="1.8">
                        <path d="M12 16V4M12 4L7 9M12 4L17 9"/>
                        <path d="M4 16V18.5C4 19.6 4.9 20.5 6 20.5H18C19.1 20.5 20 19.6 20 18.5V16"/>
                    </svg>
                </span>

                <span class="text-[11.5px] font-semibold text-ink dark:text-dtext">
                    Upload icon
                </span>

                <span class="text-[10.5px] text-faint dark:text-dsub mt-0.5">
                    PNG, JPG
                </span>
            </span>

        </label>

        <input
            type="file"
            id="icon"
            name="icon"
            accept="image/*"
            class="hidden"
            onchange="previewImage(this,'iconPreview','iconPlaceholder')"
        >

        @error('icon')
            <p class="field-error">
                {{ $message }}
            </p>
        @enderror
    </div>
</div>

        <!-- Basic details -->
        <div class="section-card accent-win p-5 sm:p-7">
          <div class="section-head">
            <div class="section-icon bg-win-light dark:bg-win/20 text-win">
              <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/></svg>
            </div>
            <div>
              <span class="section-num">02</span>
              <h3 class="section-title">Basic details</h3>
              <p class="section-sub">Name, categorisation and short summary of the app.</p>
            </div>
          </div>

          <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div class="sm:col-span-2">
              <label for="title" class="field-label">Title <span class="req">*</span></label>
              <input type="text" id="title" name="title" class="field-input @error('title') has-error @enderror" placeholder="e.g. Nexus Cleaner" value="{{ old('title', $software->title ?? '') }}" aria-describedby="title_error" required>
              @error('title')
                <p id="title_error" class="field-error">{{ $message }}</p>
              @enderror
            </div>

         <div>
    <label for="category_id" class="field-label">
        Category <span class="req">*</span>
    </label>

    <select id="category_id"
            name="category_id"
            class="field-input @error('category_id') has-error @enderror"
            required>

        <option value="">Select Category</option>

        @foreach ($categories as $category)
            <option value="{{ $category->id }}"
                {{ old('category_id', $software->category_id ?? '') == $category->id ? 'selected' : '' }}>
                {{ $category->name }}
            </option>
        @endforeach

    </select>

    @error('category_id')
        <p class="field-error">{{ $message }}</p>
    @enderror
</div>

          <div>
    <label for="subcategory_id" class="field-label">
        Subcategory
    </label>

    <select id="subcategory_id"
            name="subcategory_id"
            class="field-input @error('subcategory_id') has-error @enderror">

        <option value="">Select Subcategory</option>

        @foreach ($subcategories as $subcategory)
            <option value="{{ $subcategory->id }}"
                    data-category="{{ $subcategory->category_id }}"
                    {{ old('subcategory_id', $software->subcategory_id ?? '') == $subcategory->id ? 'selected' : '' }}>
                {{ $subcategory->name }}
            </option>
        @endforeach

    </select>

    @error('subcategory_id')
        <p class="field-error">{{ $message }}</p>
    @enderror
</div>

            <div class="sm:col-span-2">
              <label for="short_description" class="field-label">Short description <span class="req">*</span></label>
              <textarea id="short_description" name="short_description" rows="2" class="field-input @error('short_description') has-error @enderror" placeholder="One or two lines shown in listing cards" aria-describedby="short_description_error" required>{{ old('short_description', $software->short_description ?? '') }}</textarea>
              @error('short_description')
                <p id="short_description_error" class="field-error">{{ $message }}</p>
              @enderror
            </div>
          </div>
        </div>

        <div>
    <label for="downloads_count" class="field-label">
        Download Count <span class="req">*</span>
    </label>

    <div class="input-with-icon">
        <span class="input-icon">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <path d="M12 3V15"></path>
                <path d="M7 10L12 15L17 10"></path>
                <path d="M4 19H20"></path>
            </svg>
        </span>

        <input
            type="number"
            id="downloads_count"
            name="downloads_count"
            class="field-input @error('downloads_count') has-error @enderror"
            placeholder="e.g. 25000"
            value="{{ old('downloads_count', $software->downloads_count) }}"
            min="0">
    </div>

    @error('downloads_count')
        <p class="field-error">{{ $message }}</p>
    @enderror
</div>

<div>
    <label for="rating" class="field-label">
        Rating <span class="req">*</span>
    </label>

    <div class="input-with-icon">
        <span class="input-icon">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 .587l3.668 7.431 8.2 1.193-5.934 5.785 1.401 8.17L12 19.771l-7.335 3.395 1.401-8.17L.132 9.211l8.2-1.193z"/>
            </svg>
        </span>

        <input
            type="number"
            step="0.1"
            min="0"
            max="5"
            id="rating"
            name="rating"
            class="field-input @error('rating') has-error @enderror"
            placeholder="e.g. 4.8"
            value="{{ old('rating', $software->rating) }}">
    </div>

    @error('rating')
        <p class="field-error">{{ $message }}</p>
    @enderror
</div>

        <!-- Download & official links -->
        <div class="section-card accent-android p-5 sm:p-7">
          <div class="section-head">
            <div class="section-icon bg-android-light dark:bg-android/20 text-android">
              <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 3V15M12 15L7 10M12 15L17 10"/><path d="M4 17V19C4 20.1 4.9 21 6 21H18C19.1 21 20 20.1 20 19V17"/></svg>
            </div>
            <div>
              <span class="section-num">03</span>
              <h3 class="section-title">Download &amp; links</h3>
              <p class="section-sub">Buttons and links shown on the app's detail page.</p>
            </div>
          </div>

          <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div>
              <label for="download_button_text" class="field-label">Download button text</label>
              <input type="text" id="download_button_text" name="download_button_text" class="field-input @error('download_button_text') has-error @enderror" value="{{ old('download_button_text', $software->download_button_text ?? 'Download Now') }}" aria-describedby="download_button_text_error" required>
              @error('download_button_text')
                <p id="download_button_text_error" class="field-error">{{ $message }}</p>
              @enderror
            </div>

            <div class="input-with-icon">
              <label for="download_url" class="field-label">Download URL <span class="req">*</span></label>
              <span class="input-icon">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M9 12H15M12 9L15 12L12 15"/><circle cx="12" cy="12" r="9"/></svg>
              </span>
              <input type="url" id="download_url" name="download_url" class="field-input @error('download_url') has-error @enderror" placeholder="https://..." value="{{ old('download_url', $software->download_url ?? '') }}" aria-describedby="download_url_error" required>
              @error('download_url')
                <p id="download_url_error" class="field-error">{{ $message }}</p>
              @enderror
            </div>

            <div>
              <label for="official_button_text" class="field-label">Official website button text</label>
              <input type="text" id="official_button_text" name="official_button_text" class="field-input @error('official_button_text') has-error @enderror" value="{{ old('official_button_text', $software->official_button_text ?? 'Official Website') }}" aria-describedby="official_button_text_error">
              @error('official_button_text')
                <p id="official_button_text_error" class="field-error">{{ $message }}</p>
              @enderror
            </div>

            <div class="input-with-icon">
              <label for="official_website" class="field-label">Official website URL</label>
              <span class="input-icon">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="9"/><path d="M3 12H21M12 3C14.5 5.7 15.8 8.8 15.8 12C15.8 15.2 14.5 18.3 12 21C9.5 18.3 8.2 15.2 8.2 12C8.2 8.8 9.5 5.7 12 3Z"/></svg>
              </span>
              <input type="url" id="official_website" name="official_website" class="field-input @error('official_website') has-error @enderror" placeholder="https://..." value="{{ old('official_website', $software->official_website ?? '') }}" aria-describedby="official_website_error">
              @error('official_website')
                <p id="official_website_error" class="field-error">{{ $message }}</p>
              @enderror
            </div>
          </div>
        </div>

        <!-- Screenshots -->
       <div class="section-card accent-amber p-5 sm:p-7">
    <div class="section-head justify-between w-full">
        <div class="flex items-start gap-4">
            <div class="section-icon bg-amber-light dark:bg-amber/20 text-amber">
                <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <rect x="3" y="5" width="18" height="14" rx="2.5"/>
                    <circle cx="8.5" cy="10" r="1.5"/>
                    <path d="M21 16L16 11L6 19"/>
                </svg>
            </div>

            <div>
                <span class="section-num">04</span>
                <h3 class="section-title">Screenshots</h3>
                <p class="section-sub">Upload exactly 4 screenshots of the app.</p>
            </div>
        </div>

        <span id="screenshotCounter" class="screenshot-counter shrink-0">
            {{ isset($software) && is_array($software->screenshots) ? count($software->screenshots) : 0 }} / 4
        </span>
    </div>

    <div class="mt-6 grid grid-cols-2 sm:grid-cols-4 gap-4">

        @for($i = 1; $i <= 4; $i++)

            @php
                $existingScreenshot = $software->screenshots[$i - 1] ?? null;
            @endphp

            <div>

                <label for="screenshot_{{ $i }}"
                    class="upload-box h-28 @error('screenshots.' . ($i - 1)) has-error @enderror {{ $existingScreenshot ? 'has-image' : '' }}">

                    <img
                        id="screenshotPreview{{ $i }}"
                        src="{{ $existingScreenshot ? asset('storage/' . $existingScreenshot) : '' }}"
                        alt=""
                        class="preview {{ $existingScreenshot ? '' : 'hidden' }}">

                    <span
                        id="screenshotRemove{{ $i }}"
                        class="remove-badge"
                        onclick="removeImage(event,'screenshot_{{ $i }}','screenshotPreview{{ $i }}','screenshotPlaceholder{{ $i }}','screenshotRemove{{ $i }}')">

                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <path d="M6 6L18 18M18 6L6 18"/>
                        </svg>
                    </span>

                    <span
                        id="screenshotPlaceholder{{ $i }}"
                        class="flex flex-col items-center {{ $existingScreenshot ? 'hidden' : '' }}">

                        <span class="upload-icon-circle w-8 h-8 mb-1.5">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#5B6472" stroke-width="1.8">
                                <rect x="3" y="4" width="18" height="16" rx="2.5"/>
                                <circle cx="9" cy="10" r="1.5"/>
                                <path d="M21 16L15.5 10.5C15.1 10.1 14.4 10.1 14 10.5L6 18.5"/>
                            </svg>
                        </span>

                        <span class="text-[10.5px] font-semibold text-sub dark:text-dsub">
                            Screenshot {{ $i }}
                        </span>

                    </span>

                </label>

                <input
                    type="file"
                    id="screenshot_{{ $i }}"
                    name="screenshots[]"
                    accept="image/*"
                    class="hidden screenshot-input"
                    onchange="previewImage(this,'screenshotPreview{{ $i }}','screenshotPlaceholder{{ $i }}','screenshotRemove{{ $i }}')">

                @error('screenshots.' . ($i - 1))
                    <p class="field-error">{{ $message }}</p>
                @enderror

            </div>

        @endfor

    </div>

    @error('screenshots')
        <p class="field-error mt-3">{{ $message }}</p>
    @enderror

</div>

        <!-- Description (CKEditor 5) -->
        <div class="section-card accent-mac p-5 sm:p-7">
          <div class="section-head">
            <div class="section-icon bg-mac-light dark:bg-white/10 text-mac dark:text-white">
              <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 6H20M4 12H20M4 18H14"/></svg>
            </div>
            <div>
              <span class="section-num">05</span>
              <h3 class="section-title">Description</h3>
              <p class="section-sub">Full details shown on the app's page.</p>
            </div>
          </div>

          <div class="mt-6 editor-wrap @error('description') has-error @enderror">
            <label for="description" class="field-label sr-only">Description</label>
            <textarea id="description" name="description" aria-describedby="description_error" required>{{ old('description', $software->description ?? '') }}</textarea>
          </div>
          @error('description')
            <p id="description_error" class="field-error mt-2">{{ $message }}</p>
          @enderror
        </div>

        <!-- Actions -->
        <div class="action-bar -mx-5 sm:-mx-8 px-5 sm:px-8 py-4 mt-2 flex items-center justify-end gap-3 rounded-b-2xl">
          <button type="button" class="btn-ghost" onclick="window.history.back()">Cancel</button>
          <button type="submit" class="btn-primary">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M12 5V19M5 12H19" stroke="currentColor"/></svg>
            {{ isset($software) ? 'Update Software' : 'Add Software' }}
          </button>
        </div>

      </form>

    </div>
  </main>

  <script>
    function previewImage(input, previewId, placeholderId, removeId) {
      var preview = document.getElementById(previewId);
      var placeholder = document.getElementById(placeholderId);
      var label = document.querySelector('label[for="' + input.id + '"]');

      if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
          preview.src = e.target.result;
          preview.classList.remove('hidden');
          placeholder.classList.add('hidden');
          if (label) label.classList.add('has-image');
        };
        reader.readAsDataURL(input.files[0]);
      }

      updateScreenshotCounter();
    }

    function removeImage(event, inputId, previewId, placeholderId, removeId) {
      event.preventDefault();
      event.stopPropagation();

      var input = document.getElementById(inputId);
      var preview = document.getElementById(previewId);
      var placeholder = document.getElementById(placeholderId);
      var label = document.querySelector('label[for="' + inputId + '"]');

      input.value = '';
      preview.src = '';
      preview.classList.add('hidden');
      placeholder.classList.remove('hidden');
      if (label) label.classList.remove('has-image');

      updateScreenshotCounter();
    }

    function updateScreenshotCounter() {
      var inputs = document.querySelectorAll('.screenshot-input');
      var filled = 0;
      inputs.forEach(function (inp) { if (inp.files && inp.files[0]) filled++; });

      var counter = document.getElementById('screenshotCounter');
      counter.textContent = filled + ' / 4';
      counter.classList.toggle('complete', filled === 4);
    }

    // Filter subcategories based on selected category.
    // Relies on each dynamically rendered <option> carrying a data-category attribute.
    (function () {
      const category = document.getElementById('category_id');
      const subcategory = document.getElementById('subcategory_id');
      const initialSubcategory = subcategory.value; // preserve old()/edit preselection

      function filterSubcategories(preserveSelection) {

          const categoryId = category.value;

          Array.from(subcategory.options).forEach(function(option){

              if(option.value === ""){
                  option.hidden = false;
                  return;
              }

              option.hidden = option.dataset.category != categoryId;
          });

          if (!preserveSelection) {
              subcategory.value = "";
          }
      }

      category.addEventListener("change", function () {
          filterSubcategories(false);
      });

      // On initial load, filter visible options but keep the preselected value.
      filterSubcategories(true);
      subcategory.value = initialSubcategory;
    })();

    // CKEditor 5 on the description field — keeps the textarea's
    // name="description" value in sync so the form still submits it normally.
    var descriptionEditor;
    ClassicEditor
      .create(document.querySelector('#description'), {
        toolbar: ['heading', '|', 'bold', 'italic', 'underline', 'link', '|', 'bulletedList', 'numberedList', '|', 'blockQuote', 'insertTable', '|', 'undo', 'redo']
      })
      .then(function (editor) {
        descriptionEditor = editor;
      })
      .catch(function (error) {
        console.error(error);
      });

    document.getElementById('softwareForm').addEventListener('submit', function () {
      if (descriptionEditor) {
        document.getElementById('description').value = descriptionEditor.getData();
      }
    });

    // Dark mode (kept in sync with rest of admin panel)
    (function () {
      var isDark = localStorage.getItem('theme') === 'dark';
      document.documentElement.classList.toggle('dark', isDark);
    })();
  </script>
</body>
</html>
</x-layout.admin_layout>
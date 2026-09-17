<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Nexus Cleaner — Filedesk</title>

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

  .dl-btn {
    transition: background-color .2s ease, color .2s ease, transform .15s ease, box-shadow .2s ease, border-color .2s ease;
    will-change: transform;
  }
  .dl-btn:hover { transform: translateY(-1px); }
  .dl-btn:active { transform: translateY(0) scale(.96); transition-duration: .08s; }
  .dl-win-solid { background:#0F7BE0; }
  .dl-win-solid:hover { background:#0B5FB3; box-shadow: 0 10px 22px -8px rgba(15,123,224,0.5); }
  .dl-win-solid:active { background:#094a89; }

  button { -webkit-tap-highlight-color: transparent; }

  .icon-tile { transition: transform .35s cubic-bezier(.16,1,.3,1), box-shadow .35s ease; }

  .related-card {
    transition: border-color .25s ease, box-shadow .3s cubic-bezier(.16,1,.3,1), transform .3s cubic-bezier(.16,1,.3,1);
  }
  .related-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 16px 32px -14px rgba(15,17,23,0.16), 0 4px 10px -4px rgba(15,17,23,0.07);
    border-color: #C9D3F5;
  }

  .star { color: #F5A623; letter-spacing: -1px; }

  .tag-chip { transition: background-color .2s ease, color .2s ease; }

  /* Gallery */
  .gallery-track {
    display: flex;
    transition: transform .45s cubic-bezier(.16,1,.3,1);
  }
  .gallery-slide { flex: 0 0 100%; }
  .gallery-nav-btn {
    transition: background-color .2s ease, transform .15s ease, box-shadow .2s ease;
  }
  .gallery-nav-btn:hover { transform: translateY(-50%) scale(1.06); }
  .gallery-nav-btn:active { transform: translateY(-50%) scale(.94); }
  .thumb-btn {
    transition: border-color .2s ease, opacity .2s ease, transform .2s ease;
    opacity: .55;
  }
  .thumb-btn:hover { opacity: .85; transform: translateY(-1px); }
  .thumb-btn.active { opacity: 1; border-color: #4F46E5; }

  /* Rich content typography */
  .prose-content h2 { font-size: 1.05rem; font-weight: 700; margin-top: 1.75rem; margin-bottom: .6rem; }
  .prose-content p { color: #5B6472; font-size: .925rem; line-height: 1.75; margin-bottom: .9rem; }
  html.dark .prose-content p { color: #9BA3B4; }
  .prose-content ul { margin-bottom: .9rem; }
  .prose-content li { color: #5B6472; font-size: .925rem; line-height: 1.7; margin-bottom: .4rem; }
  html.dark .prose-content li { color: #9BA3B4; }

  .dot-grid {
    background-image: radial-gradient(circle, rgba(255,255,255,0.14) 1px, transparent 1px);
    background-size: 20px 20px;
  }

  @keyframes fadeUp { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
  .fade-up { animation: fadeUp .6s cubic-bezier(.16,1,.3,1) both; }

  @media (prefers-reduced-motion: reduce) {
    .icon-tile, .dl-btn, .related-card, .gallery-track, .gallery-nav-btn, .thumb-btn { transition: none !important; }
    .fade-up { animation: none !important; }
  }
</style>
</head>

<body class="antialiased bg-white text-ink dark:bg-dbg dark:text-dtext">

<!-- ================= NAVBAR (unchanged — same as homepage) ================= -->
<x-basic.navbar/>

<!-- ================= BREADCRUMB ================= -->
<div class="max-w-7xl mx-auto px-5 sm:px-8 pt-5 pb-2">
    <nav class="flex items-center gap-1.5 text-[12.5px] text-faint dark:text-dsub font-medium">

        <a href="{{ route('home') }}" class="hover:text-brand transition-colors">
            Home
        </a>

        <span>/</span>

        <a href="{{ route('category', $software->category->slug) }}"
            class="hover:text-brand transition-colors">
            {{ $software->category->name }}
        </a>

        <span>/</span>

        <span class="hover:text-brand transition-colors">
            {{ $software->subcategory->name }}
        </span>

        <span>/</span>

        <span class="text-ink dark:text-white">
            {{ $software->title }}
        </span>

    </nav>
</div>

<!-- ================= DETAIL HEADER + MAIN GRID ================= -->
<!-- Sidebar sits in the same grid as the header, so "Related Software" starts level with the title, not lower down. -->
<section class="max-w-7xl mx-auto px-5 sm:px-8 pt-4 sm:pt-6 pb-16 sm:pb-20">

<div class="grid grid-cols-1 lg:grid-cols-[1fr_320px] gap-8 lg:gap-10 items-start">


<!-- ================= LEFT COLUMN ================= -->
<div class="min-w-0">


<div class="fade-up flex flex-col sm:flex-row sm:items-center gap-5 sm:gap-6">

<img
src="{{ asset('storage/' . $software->icon) }}"
alt="{{ $software->title }}"
class="icon-tile w-28 h-28 sm:w-36 sm:h-36 rounded-2xl object-cover shadow-cardHover shrink-0">


<div class="min-w-0 flex-1">

<span class="tag-chip inline-block text-[11px] font-bold uppercase tracking-wide px-2.5 py-1 rounded-full {{ $theme['badge'] }}">
{{ $software->subcategory->name }}
</span>


<h1 class="mt-2.5 text-[26px] sm:text-[32px] font-extrabold tracking-tight text-ink dark:text-white leading-tight">
{{ $software->title }}
</h1>


<p class="mt-2 text-[14.5px] text-sub dark:text-dsub leading-relaxed">
{{ $software->short_description }}
</p>


<div class="mt-3.5 flex items-center gap-2 text-[13px] font-semibold {{ $theme['category_text'] }}">

{{ $software->category->name }}

</div>


<div class="mt-5 flex flex-wrap gap-3">


<a href="{{ $software->download_url }}"
target="_blank"
class="dl-btn {{ $theme['button'] }} h-11 px-6 rounded-xl text-white text-[14px] font-semibold flex items-center gap-2 shadow-card">

Download

</a>


<a href="{{ $software->official_website }}"
target="_blank"
class="dl-btn h-11 px-6 rounded-xl border border-line dark:border-dline text-ink dark:text-white text-[14px] font-semibold">

Official Website

</a>


</div>


</div>
</div>



<!-- Gallery -->

<div class="relative mt-8 rounded-2xl overflow-hidden border border-line dark:border-dline">

<div id="galleryViewport" class="overflow-hidden">

<div id="galleryTrack" class="gallery-track">


@foreach($software->screenshots ?? [] as $index => $image)

<div class="gallery-slide">

<img src="{{ asset('storage/'.$image) }}"
class="aspect-[16/9] w-full object-cover">

</div>

@endforeach


</div>

</div>

</div>



<!-- Thumbnails -->

<div class="flex gap-2 mt-3 overflow-x-auto no-scrollbar">

@foreach($software->screenshots ?? [] as $index => $image)

<button class="thumb-btn w-24 h-14 rounded-lg overflow-hidden border">

<img src="{{ asset('storage/'.$image) }}"
class="w-full h-full object-cover">

</button>

@endforeach


</div>


</div>
<!-- ================= END LEFT COLUMN ================= -->





<!-- ================= RIGHT COLUMN ================= -->

<aside class="lg:sticky lg:top-6">

<h3 class="text-[15px] font-bold text-ink dark:text-white mb-3.5">
    Related Software
</h3>


<div class="flex flex-col gap-3">


@foreach($software->related ?? [] as $item)

<a href="{{ route('software.show', $item->slug) }}"
class="related-card flex items-center gap-3 bg-white dark:bg-dcard border border-line dark:border-dline rounded-xl p-3">


<img 
src="{{ asset('storage/'.$item->icon) }}"
class="w-11 h-11 rounded-lg object-cover shrink-0"
alt="{{ $item->title }}">


<div class="min-w-0">

<p class="font-semibold text-[13.5px] text-ink dark:text-white truncate">
{{ $item->title }}
</p>


<p class="text-[11.5px] text-faint dark:text-dsub truncate">
{{ $item->subcategory->name }}
</p>


</div>


</a>


@endforeach


</div>


</aside>

</div>





<!-- ================= SEO DESCRIPTION FULL WIDTH ================= -->


<div class="prose-content mt-10 pt-8 border-t border-line dark:border-dline">


@if($software->description)

{!! $software->description !!}

@else

<p class="text-sub dark:text-dsub">
No description available.
</p>

@endif


</div>



</section>



<!-- ================= FOOTER (unchanged — same as homepage) ================= -->
<x-basic.footer />

<script>
  (function () {
    var track = document.getElementById('galleryTrack');
    var counter = document.getElementById('galleryCounter');
    var thumbs = Array.prototype.slice.call(document.querySelectorAll('#galleryThumbs .thumb-btn'));
    var slides = track.children.length;
    var index = 0;

    function render() {
      track.style.transform = 'translateX(-' + (index * 100) + '%)';
      counter.textContent = (index + 1) + ' / ' + slides;
      thumbs.forEach(function (t, i) { t.classList.toggle('active', i === index); });
    }

    document.getElementById('galleryNext').addEventListener('click', function () {
      index = (index + 1) % slides;
      render();
    });
    document.getElementById('galleryPrev').addEventListener('click', function () {
      index = (index - 1 + slides) % slides;
      render();
    });
    thumbs.forEach(function (t, i) {
      t.addEventListener('click', function () { index = i; render(); });
    });

    render();
  })();

  (function () {
    var btn = document.getElementById('darkModeToggle');
    if (!btn) return;

    var icon = document.getElementById('darkModeIcon');

    var sun = '<path d="M12 5V2.5M12 21.5V19M19 12H21.5M2.5 12H5M17.7 6.3L19.4 4.6M4.6 19.4L6.3 17.7M17.7 17.7L19.4 19.4M4.6 4.6L6.3 6.3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><circle cx="12" cy="12" r="4.5" fill="currentColor"/>';

    var moon = '<path d="M21 12.8A9 9 0 1 1 11.2 3 7 7 0 0 0 21 12.8Z" fill="currentColor"/>';

    // Load saved theme
    var on = localStorage.getItem('theme') === 'dark';

    document.documentElement.classList.toggle('dark', on);
    icon.innerHTML = on ? sun : moon;

    btn.addEventListener('click', function () {
        on = !on;

        document.documentElement.classList.toggle('dark', on);
        icon.innerHTML = on ? sun : moon;

        // Save theme
        localStorage.setItem('theme', on ? 'dark' : 'light');
    });
})();
</script>
</body>
</html>
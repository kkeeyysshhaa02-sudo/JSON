<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>D' Cacious — Endlessly Delicious Recipes & Food Curation</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,500;0,700;0,900;1,400;1,700&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Canvas Confetti CDN -->
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        serif: ['"Playfair Display"', 'Georgia', 'serif'],
                        display: ['"Instrument Serif"', 'serif'],
                        mono: ['"Space Grotesk"', 'monospace'],
                    },
                    colors: {
                        'luscious-bg': '#FBF9F5',
                        'luscious-card': '#F4EFE6',
                        'luscious-dark': '#1C1917',
                        'brand-orange': '#E8590C',
                        'sweet-green': '#1E3932',
                        'sweet-green-light': '#2D5A4C',
                    }
                }
            }
        }
    </script>

    <style>
        body {
            background-color: #FBF9F5;
            color: #1C1917;
            overflow-x: hidden;
        }

        /* Marble texture backdrop */
        .marble-bg {
            background-color: #FBF9F5;
            background-image: radial-gradient(#e7e2d7 0.75px, transparent 0.75px);
            background-size: 16px 16px;
        }

        /* Plate Split & Hover Animation */
        .plate-container {
            perspective: 1000px;
            transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        .plate-container:hover {
            transform: translateY(-8px) scale(1.02);
        }

        /* 3D Food Plate Split Effect */
        .split-left {
            transition: transform 0.5s cubic-bezier(0.2, 0.8, 0.2, 1), clip-path 0.5s ease;
            clip-path: polygon(0 0, 52% 0, 48% 100%, 0 100%);
        }
        .split-right {
            transition: transform 0.5s cubic-bezier(0.2, 0.8, 0.2, 1), clip-path 0.5s ease;
            clip-path: polygon(52% 0, 100% 0, 100% 100%, 48% 100%);
        }
        .plate-container.is-split .split-left {
            transform: translateX(-35px) rotate(-6deg);
        }
        .plate-container.is-split .split-right {
            transform: translateX(35px) rotate(6deg);
        }

        /* Ingredient Card interactive checked state */
        .ingredient-card.is-checked {
            background-color: #E8F5E9;
            border-color: #4CAF50;
            opacity: 0.75;
            transform: scale(0.97);
        }
        .ingredient-card.is-checked .check-indicator {
            background-color: #2E7D32;
            color: #ffffff;
            border-color: #2E7D32;
        }

        /* Glassmorphism nav */
        .glass-header {
            background: rgba(251, 249, 245, 0.88);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(229, 222, 210, 0.7);
        }
    </style>
</head>
<body class="marble-bg min-h-screen antialiased flex flex-col justify-between selection:bg-brand-orange selection:text-white">

    <!-- =================================================================== -->
    <!-- HEADER BAR (Foto 1 D' Cacious Style)                                -->
    <!-- =================================================================== -->
    <header class="sticky top-0 z-40 glass-header px-4 sm:px-8 py-3.5 transition-all">
        <div class="max-w-7xl mx-auto flex items-center justify-between gap-4">
            
            <!-- Brand Logo (D' Cacious) -->
            <div class="flex items-center gap-6">
                <a href="/resep" class="flex items-center gap-2 group">
                    <span class="font-serif font-black text-2xl sm:text-3xl text-stone-900 tracking-tight">D' Cacious</span>
                    <span class="text-[10px] uppercase font-mono tracking-widest bg-orange-100 text-orange-800 px-2 py-0.5 rounded-full font-bold">Recipes</span>
                </a>
            </div>

            <!-- Navigation Links -->
            <nav class="hidden md:flex items-center gap-7 text-xs font-semibold text-stone-700">
                <a href="#hero" class="hover:text-brand-orange transition-colors">Dumplings</a>
                <a href="#plate-section" class="hover:text-brand-orange transition-colors">What's on our Plate</a>
                <a href="#catalog-section" class="hover:text-brand-orange transition-colors">Food Menu</a>
                <a href="#summer-section" class="hover:text-brand-orange transition-colors">Seasonal Bowls</a>
                <a href="/" class="text-stone-500 hover:text-stone-900 flex items-center gap-1 border-l border-stone-300 pl-4">
                    <i data-lucide="sparkles" class="w-3.5 h-3.5 text-amber-500"></i> CaQuotes App
                </a>
            </nav>

            <!-- Action Buttons & Search Trigger -->
            <div class="flex items-center gap-3">
                <div class="relative hidden sm:block w-44 lg:w-56">
                    <i data-lucide="search" class="w-3.5 h-3.5 absolute left-3 top-1/2 -translate-y-1/2 text-stone-400"></i>
                    <input 
                        type="text" 
                        id="nav-search" 
                        oninput="handleSearch(event)"
                        placeholder="Cari resep / bahan..." 
                        class="w-full pl-8 pr-3 py-1.5 rounded-full bg-stone-100/90 border border-stone-300/80 text-xs focus:outline-none focus:ring-2 focus:ring-brand-orange transition-all"
                    >
                </div>

                <button onclick="openApiKeyModal()" class="bg-stone-200/80 hover:bg-stone-300 text-stone-800 font-bold text-xs px-3 py-2 rounded-full transition-colors flex items-center gap-1.5" title="Pengaturan API Ninjas">
                    <i data-lucide="key" class="w-3.5 h-3.5 text-brand-orange"></i>
                    <span class="hidden sm:inline">API Ninjas</span>
                </button>

                <button onclick="scrollToCatalog()" class="bg-brand-orange hover:bg-orange-600 text-white font-bold text-xs px-4 py-2 rounded-full shadow-sm transition-all hover:scale-105 active:scale-95 flex items-center gap-1.5">
                    <i data-lucide="book-open" class="w-3.5 h-3.5"></i>
                    <span>Eksplorasi Resep</span>
                </button>
            </div>
        </div>
    </header>


    <!-- =================================================================== -->
    <!-- SECTION 1: HERO "LUSCIOUS" BANNER (Foto 1 Style)                    -->
    <!-- =================================================================== -->
    <section id="hero" class="relative max-w-7xl mx-auto px-4 sm:px-8 pt-8 pb-16 overflow-hidden">
        
        <!-- Background Garnishes & Spoons Illustration elements -->
        <div class="absolute -top-6 -left-6 w-36 h-36 opacity-30 pointer-events-none">
            <span class="text-6xl">🌿</span>
        </div>
        <div class="absolute top-12 right-6 w-24 h-24 opacity-40 pointer-events-none hidden lg:block">
            <span class="text-5xl">🍅</span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
            
            <!-- Left Hero Text -->
            <div class="lg:col-span-5 space-y-6 text-center lg:text-left z-10">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-orange-100 text-brand-orange text-xs font-mono font-bold tracking-wider uppercase">
                    <span>🥟 Handcrafted Authentic Culinary</span>
                </div>

                <h1 class="text-4xl sm:text-6xl font-serif text-stone-900 leading-[1.1] tracking-tight">
                    Take a taste.<br>
                    <span class="italic font-normal">Come join us.</span>
                </h1>

                <p class="text-lg sm:text-xl font-serif italic text-stone-800">
                    Life is so endlessly delicious.
                </p>

                <p class="text-xs sm:text-sm text-stone-600 max-w-md font-sans leading-relaxed mx-auto lg:mx-0">
                    Dumpling is a broad classification for a dish that consists of pieces of dough wrapped around a savoury filling of seasoned chicken, mushrooms, or fresh herbs. Temukan rahasia kelezatan tiap piringnya di sini.
                </p>

                <div class="flex flex-wrap items-center justify-center lg:justify-start gap-3 pt-2">
                    <button onclick="openRecipeDetail('1')" class="bg-brand-orange hover:bg-orange-600 text-white font-bold text-sm px-6 py-3 rounded-full shadow-lg transition-transform hover:scale-105 active:scale-95 flex items-center gap-2">
                        <span>Lihat Resep Dumplings</span>
                        <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </button>
                    <a href="#plate-section" class="px-5 py-3 rounded-full bg-stone-200/80 hover:bg-stone-300 text-stone-800 text-sm font-semibold transition-colors">
                        Pilihan Menu Lain
                    </a>
                </div>

                <div class="flex items-center justify-center lg:justify-start gap-6 pt-4 border-t border-stone-200/80 text-xs font-mono text-stone-600">
                    <div><strong class="text-stone-900 font-sans text-sm">25+</strong> Pilihan Resep</div>
                    <div><strong class="text-stone-900 font-sans text-sm">100%</strong> Bahan Segar</div>
                    <div><strong class="text-stone-900 font-sans text-sm">Interactive</strong> Checklist</div>
                </div>
            </div>

            <!-- Right Hero Dish Visual with Wooden Bowl & Chopsticks (Foto 1 inspired) -->
            <div class="lg:col-span-7 relative flex items-center justify-center">
                <div class="relative w-full max-w-lg aspect-square">
                    
                    <!-- Decorative Circular Background Glow -->
                    <div class="absolute inset-0 rounded-full bg-gradient-to-tr from-amber-200/50 via-orange-100/40 to-transparent blur-2xl transform scale-90"></div>
                    
                    <!-- Main Dumplings Hero Plate -->
                    <div class="relative z-10 w-full h-full rounded-full shadow-2xl p-4 sm:p-6 bg-gradient-to-br from-stone-100 to-[#EAE4D7] border-4 border-white flex items-center justify-center cursor-pointer group" onclick="openRecipeDetail('1')" title="Klik untuk membuka resep Steamed Dumplings">
                        <img 
                            src="https://images.unsplash.com/photo-1541696432-82c6da8ce7bf?auto=format&fit=crop&w=900&q=80" 
                            alt="Steamed Dumplings on Wooden Plate" 
                            class="w-full h-full object-cover rounded-full shadow-inner group-hover:scale-105 transition-transform duration-500"
                        >
                        
                        <!-- Floating Chili Dip Badge -->
                        <div class="absolute bottom-6 left-6 bg-white/95 backdrop-blur-md rounded-2xl p-3 shadow-xl border border-stone-200 flex items-center gap-3 animate-bounce duration-1000">
                            <span class="text-2xl">🌶️</span>
                            <div>
                                <h4 class="font-bold text-xs text-stone-900 leading-none">Chili Dipping Sauce</h4>
                                <span class="text-[10px] text-stone-500 font-mono">Resep saus rahasia</span>
                            </div>
                        </div>

                        <!-- Floating Cook Badge -->
                        <div class="absolute top-6 right-6 bg-stone-900/90 text-white backdrop-blur-md rounded-2xl px-3.5 py-2 shadow-xl flex items-center gap-2">
                            <i data-lucide="clock" class="w-3.5 h-3.5 text-amber-400"></i>
                            <span class="text-xs font-mono font-bold">15 Menit Masak</span>
                        </div>
                    </div>

                    <!-- Spices on Wooden Spoon Accent (Photo 1 reference) -->
                    <div class="absolute -bottom-4 -right-4 bg-white/90 rounded-2xl p-2.5 shadow-md border border-stone-200 flex items-center gap-2 text-xs font-sans text-stone-700">
                        <span class="text-xl">🥢</span>
                        <span>Klik piring untuk buka resep & bumbu!</span>
                    </div>
                </div>
            </div>

        </div>
    </section>


    <!-- =================================================================== -->
    <!-- SECTION 2: "WHAT'S ON OUR PLATE" INTERACTIVE SPLIT PLATES (Foto 2)  -->
    <!-- =================================================================== -->
    <section id="plate-section" class="max-w-7xl mx-auto px-4 sm:px-8 py-16 border-t border-stone-200/80">
        <div class="text-center max-w-2xl mx-auto mb-10">
            <span class="text-xs font-mono uppercase tracking-widest text-brand-orange font-bold">Koleksi Piring Sajian</span>
            <h2 class="text-3xl sm:text-5xl font-serif text-stone-900 tracking-tight mt-1">
                What’s on our Plate
            </h2>
            <p class="text-stone-600 text-sm italic font-serif mt-1">
                Please serve yourself without any hesitate.
            </p>
            <p class="text-xs text-stone-500 font-sans mt-2">
                💡 <strong>Klik piring mana saja</strong> untuk membuka belahan piring (*split-plate*) dan melihat tata cara memasak serta daftar bahan interaktif.
            </p>

            <!-- Category Filter Tabs (Appetizers, Main Dish, Dessert, Salads, Warm Bowls) -->
            <div class="flex flex-wrap items-center justify-center gap-2 mt-6">
                @foreach ($categories as $cat)
                <button 
                    onclick="filterCategory('{{ $cat }}')"
                    id="cat-btn-{{ Str::slug($cat) }}"
                    class="category-tab-btn px-4 py-1.5 rounded-full text-xs font-semibold transition-all {{ $cat === 'All' ? 'bg-stone-900 text-white shadow-sm' : 'bg-stone-200/80 text-stone-700 hover:bg-stone-300' }}"
                >
                    {{ $cat }}
                </button>
                @endforeach
            </div>
        </div>

        <!-- Interactive Split Plates Grid (Foto 2 Reference) -->
        <div id="plates-grid" class="grid grid-cols-1 md:grid-cols-3 gap-8 sm:gap-10 pt-4">
            @foreach ($recipes as $rIndex => $recipe)
            <div 
                class="plate-card-item flex flex-col items-center text-center group cursor-pointer"
                data-category="{{ $recipe['category'] }}"
                data-id="{{ $recipe['id'] }}"
                onclick="triggerSplitAndOpen('{{ $recipe['id'] }}', this)"
            >
                <!-- Plate Circle Visual with Split halves -->
                <div class="plate-container relative w-64 h-64 sm:w-72 sm:h-72 rounded-full p-3 shadow-xl bg-gradient-to-b from-stone-100 to-stone-200 border-4 border-white flex items-center justify-center mb-6">
                    
                    <!-- Left Half Image (for split effect) -->
                    <div class="split-left absolute inset-0 w-full h-full rounded-full overflow-hidden p-3 z-10 pointer-events-none">
                        <img 
                            src="{{ $recipe['plate_image'] ?? $recipe['image'] }}" 
                            alt="{{ $recipe['name'] }}" 
                            class="w-full h-full object-cover rounded-full shadow-md"
                        >
                    </div>

                    <!-- Right Half Image (for split effect) -->
                    <div class="split-right absolute inset-0 w-full h-full rounded-full overflow-hidden p-3 z-10 pointer-events-none">
                        <img 
                            src="{{ $recipe['plate_image'] ?? $recipe['image'] }}" 
                            alt="{{ $recipe['name'] }}" 
                            class="w-full h-full object-cover rounded-full shadow-md"
                        >
                    </div>

                    <!-- Inner Core Reveal Content (Visible when split opens) -->
                    <div class="absolute inset-0 rounded-full bg-sweet-green text-white p-6 flex flex-col items-center justify-center z-0">
                        <span class="text-2xl">✨</span>
                        <h5 class="text-xs font-bold font-sans uppercase tracking-wider text-amber-300 mt-1">Buka Resep</h5>
                        <p class="text-[11px] text-white/90 font-mono mt-1">{{ count($recipe['ingredients']) }} Bahan Masak</p>
                    </div>

                    <!-- Plate Tag Badge -->
                    <div class="absolute top-2 right-4 z-20 bg-brand-orange text-white text-[10px] font-mono font-bold px-2.5 py-0.5 rounded-full shadow">
                        {{ $recipe['tag'] }}
                    </div>
                </div>

                <!-- Plate Details (Title, Description, Cooking time) -->
                <h3 class="font-serif font-bold text-xl sm:text-2xl text-stone-900 group-hover:text-brand-orange transition-colors">
                    {{ $recipe['name'] }}
                </h3>
                <p class="text-xs text-stone-600 max-w-xs mt-2 line-clamp-2 leading-relaxed font-sans">
                    {{ $recipe['subtitle'] }}
                </p>

                <div class="flex items-center gap-4 mt-3 text-xs font-mono text-stone-500">
                    <span class="flex items-center gap-1"><i data-lucide="clock" class="w-3.5 h-3.5"></i> {{ $recipe['cook_time'] }}</span>
                    <span class="flex items-center gap-1"><i data-lucide="flame" class="w-3.5 h-3.5 text-orange-500"></i> {{ $recipe['calories'] }}</span>
                    <span class="font-bold text-brand-orange">{{ $recipe['difficulty'] }}</span>
                </div>

                <!-- Click Button helper -->
                <button class="mt-4 px-4 py-1.5 rounded-full bg-stone-900 text-white text-xs font-bold group-hover:bg-brand-orange transition-colors flex items-center gap-1.5">
                    <span>Buka Cara Membuat</span>
                    <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
                </button>
            </div>
            @endforeach
        </div>
    </section>


    <!-- =================================================================== -->
    <!-- SECTION 3: SEASONAL SWEETGREEN BANNER (Foto 4 Style)                -->
    <!-- =================================================================== -->
    <section id="summer-section" class="max-w-7xl mx-auto px-4 sm:px-8 py-10">
        <div class="relative rounded-3xl overflow-hidden shadow-2xl bg-gradient-to-r from-sweet-green via-[#1A4336] to-sweet-green text-white p-8 sm:p-14">
            
            <div class="relative z-10 max-w-xl space-y-4">
                <span class="text-xs font-mono uppercase tracking-widest text-amber-300 font-bold bg-white/10 px-3 py-1 rounded-full backdrop-blur">
                    INSIDE THE RECIPES • SWEETGREEN STYLE
                </span>
                <h2 class="text-3xl sm:text-5xl font-serif leading-tight">
                    Now serving fresh seasonal harvests.
                </h2>
                <p class="text-sm text-stone-200 font-sans leading-relaxed">
                    Setiap mangkuk dirancang dengan perpaduan nutrisi seimbang, sayuran segar organik, dan saus racikan buatan sendiri yang mudah dibuat di dapur rumah Anda.
                </p>
                <div class="pt-2">
                    <button onclick="filterCategory('Warm Bowls')" class="bg-amber-400 hover:bg-amber-300 text-stone-900 font-bold text-xs px-6 py-3 rounded-full shadow-lg transition-transform hover:scale-105 active:scale-95 flex items-center gap-2">
                        <span>Jelajahi Warm Bowls & Salads</span>
                        <i data-lucide="arrow-down" class="w-4 h-4"></i>
                    </button>
                </div>
            </div>

            <div class="absolute right-0 bottom-0 top-0 w-1/2 opacity-25 lg:opacity-40 pointer-events-none hidden md:block">
                <img src="https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&w=800&q=80" alt="Harvest Bowl" class="w-full h-full object-cover">
            </div>

        </div>
    </section>


    <!-- =================================================================== -->
    <!-- SECTION 4: RECIPES CATALOG & SEARCH (Foto 4 Style)                  -->
    <!-- =================================================================== -->
    <section id="catalog-section" class="max-w-7xl mx-auto px-4 sm:px-8 py-12">
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mb-8">
            <div>
                <h3 class="text-2xl sm:text-4xl font-serif text-stone-900">Katalog Lengkap Resep</h3>
                <p class="text-xs text-stone-500 font-sans mt-1">Pilih hidangan favorit dan ceklis bahan-bahannya saat mulai memasak.</p>
            </div>

            <!-- Search box -->
            <div class="relative w-full sm:w-80">
                <i data-lucide="search" class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-stone-400"></i>
                <input 
                    type="text" 
                    id="catalog-search" 
                    oninput="handleSearch(event)"
                    placeholder="Ketik nama makanan atau bahan..." 
                    class="w-full pl-9 pr-4 py-2.5 rounded-full bg-white border border-stone-300 text-xs focus:outline-none focus:ring-2 focus:ring-brand-orange shadow-sm"
                >
            </div>
        </div>

        <!-- Catalog Grid -->
        <div id="catalog-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($recipes as $rec)
            <div 
                class="catalog-item bg-white rounded-3xl p-5 border border-stone-200 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between group cursor-pointer"
                data-name="{{ strtolower($rec['name']) }}"
                data-category="{{ $rec['category'] }}"
                onclick="openRecipeDetail('{{ $rec['id'] }}')"
            >
                <div>
                    <!-- Card Top Image -->
                    <div class="relative w-full h-48 rounded-2xl overflow-hidden mb-4 bg-stone-100">
                        <img 
                            src="{{ $rec['image'] }}" 
                            alt="{{ $rec['name'] }}" 
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                        >
                        <span class="absolute top-3 left-3 bg-white/90 backdrop-blur text-stone-900 text-[10px] font-mono font-bold px-2.5 py-1 rounded-full shadow-sm">
                            {{ $rec['category'] }}
                        </span>
                        <span class="absolute top-3 right-3 bg-brand-orange text-white text-[10px] font-mono font-bold px-2.5 py-1 rounded-full shadow-sm">
                            {{ $rec['calories'] }}
                        </span>
                    </div>

                    <h4 class="font-serif font-bold text-lg text-stone-900 group-hover:text-brand-orange transition-colors">
                        {{ $rec['name'] }}
                    </h4>
                    <p class="text-xs text-stone-600 mt-1 line-clamp-2 leading-relaxed">
                        {{ $rec['subtitle'] }}
                    </p>
                </div>

                <div class="border-t border-stone-100 pt-4 mt-4 flex items-center justify-between text-xs">
                    <div class="flex items-center gap-1.5 font-mono text-stone-500">
                        <i data-lucide="check-square" class="w-3.5 h-3.5 text-emerald-600"></i>
                        <span>{{ count($rec['ingredients']) }} Bahan</span>
                    </div>
                    <button class="font-bold text-brand-orange group-hover:translate-x-1 transition-transform flex items-center gap-1">
                        <span>Lihat Resep</span>
                        <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                    </button>
                </div>
            </div>
            @endforeach
        </div>
    </section>


    <!-- =================================================================== -->
    <!-- MASTER MODAL: RECIPE DETAIL, CHECKLIST & STEPS (Foto 3 Style)        -->
    <!-- =================================================================== -->
    <div id="recipe-modal" class="fixed inset-0 z-50 bg-stone-900/75 backdrop-blur-md hidden items-center justify-center p-2 sm:p-4 overflow-y-auto">
        <div class="relative w-full max-w-4xl bg-[#FCFBF8] rounded-3xl shadow-2xl border border-stone-300 overflow-hidden my-auto max-h-[92vh] flex flex-col animate-in fade-in zoom-in-95 duration-200">
            
            <!-- Sticky Modal Header -->
            <div class="sticky top-0 z-20 bg-[#FCFBF8]/95 backdrop-blur-md px-6 py-4 border-b border-stone-200 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <button onclick="closeRecipeModal()" class="w-9 h-9 rounded-full bg-stone-100 hover:bg-stone-200 text-stone-800 flex items-center justify-center transition-transform hover:scale-105" title="Tutup">
                        <i data-lucide="arrow-left" class="w-4 h-4"></i>
                    </button>
                    <div>
                        <h3 id="modal-dish-title" class="font-serif font-bold text-xl sm:text-2xl text-stone-900 leading-tight">Chicken + Brussels</h3>
                        <div class="flex items-center gap-3 text-[11px] font-mono text-stone-500">
                            <span id="modal-dish-category" class="text-brand-orange font-bold uppercase">Warm Bowls</span>
                            <span>•</span>
                            <span id="modal-dish-calories">485 kkal</span>
                            <span>•</span>
                            <span id="modal-dish-time">15 Menit Masak</span>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <button onclick="celebrateCook()" class="p-2 rounded-full bg-orange-100 text-brand-orange hover:bg-orange-200 transition-colors" title="Simpan Resep">
                        <i data-lucide="heart" class="w-4 h-4"></i>
                    </button>
                    <button onclick="closeRecipeModal()" class="w-9 h-9 rounded-full bg-stone-100 hover:bg-stone-200 text-stone-800 flex items-center justify-center">
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </button>
                </div>
            </div>

            <!-- Modal Scrollable Body -->
            <div class="p-6 sm:p-8 overflow-y-auto space-y-8">
                
                <!-- Hero Recipe Visual & Stats -->
                <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-center bg-stone-100/70 p-6 rounded-3xl border border-stone-200">
                    <div class="md:col-span-5 aspect-video md:aspect-square rounded-2xl overflow-hidden shadow-md">
                        <img id="modal-dish-image" src="" alt="Recipe Dish" class="w-full h-full object-cover">
                    </div>
                    <div class="md:col-span-7 space-y-3">
                        <p id="modal-dish-desc" class="text-xs sm:text-sm text-stone-700 leading-relaxed font-sans">
                            Deskripsi resep...
                        </p>
                        
                        <div class="grid grid-cols-3 gap-2 pt-2 border-t border-stone-200 text-center">
                            <div class="bg-white p-2.5 rounded-xl border border-stone-200/80 shadow-sm">
                                <span class="text-[10px] font-mono text-stone-500 uppercase">Porsi</span>
                                <h6 id="modal-dish-servings" class="font-bold text-xs text-stone-900 mt-0.5">2 Porsi</h6>
                            </div>
                            <div class="bg-white p-2.5 rounded-xl border border-stone-200/80 shadow-sm">
                                <span class="text-[10px] font-mono text-stone-500 uppercase">Tingkat</span>
                                <h6 id="modal-dish-difficulty" class="font-bold text-xs text-brand-orange mt-0.5">Mudah</h6>
                            </div>
                            <div class="bg-white p-2.5 rounded-xl border border-stone-200/80 shadow-sm">
                                <span class="text-[10px] font-mono text-stone-500 uppercase">Rating</span>
                                <h6 id="modal-dish-rating" class="font-bold text-xs text-stone-900 mt-0.5">⭐ 4.9</h6>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- =================================================================== -->
                <!-- INTERACTIVE INGREDIENTS CHECKLIST (Foto 3 Style)                    -->
                <!-- =================================================================== -->
                <div>
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-4">
                        <div>
                            <h4 class="text-xl sm:text-2xl font-serif font-bold text-stone-900">Daftar Bahan Makanan</h4>
                            <p class="text-xs text-stone-500 font-sans">Ceklis satu per satu bahan yang telah Anda siapkan di dapur.</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <span id="checklist-counter" class="text-xs font-mono font-bold px-3 py-1 bg-sweet-green text-white rounded-full">
                                Siap: 0 / 0 Bahan
                            </span>
                            <button onclick="resetIngredientsChecklist()" class="text-xs font-mono text-stone-500 hover:text-stone-900 underline">
                                Reset
                            </button>
                        </div>
                    </div>

                    <!-- Ingredients Grid (Foto 3 Card Style) -->
                    <div id="ingredients-grid" class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3">
                        <!-- Populated by Javascript with interactive checkbox -->
                    </div>
                </div>


                <!-- =================================================================== -->
                <!-- STEP-BY-STEP COOKING INSTRUCTIONS (Foto 3 & 4 Style)                 -->
                <!-- =================================================================== -->
                <div class="border-t border-stone-200 pt-8">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h4 class="text-xl sm:text-2xl font-serif font-bold text-stone-900">Tata Cara & Langkah Memasak</h4>
                            <p class="text-xs text-stone-500 font-sans">Ikuti langkah-langkah di bawah ini untuk hasil masakan sempurna.</p>
                        </div>
                    </div>

                    <!-- Steps Timeline -->
                    <div id="instructions-timeline" class="space-y-4">
                        <!-- Populated by Javascript -->
                    </div>
                </div>

            </div>

            <!-- Sticky Modal Footer -->
            <div class="sticky bottom-0 z-20 bg-[#FCFBF8]/95 backdrop-blur-md px-6 py-4 border-t border-stone-200 flex items-center justify-between">
                <button onclick="closeRecipeModal()" class="px-5 py-2.5 rounded-full bg-stone-200 hover:bg-stone-300 text-stone-800 text-xs font-bold transition-colors">
                    Tutup Resep
                </button>
                <button onclick="finishCookingRecipe()" class="px-6 py-2.5 rounded-full bg-sweet-green hover:bg-sweet-green-light text-white text-xs font-bold shadow-lg flex items-center gap-2 transition-transform hover:scale-105 active:scale-95">
                    <i data-lucide="check-circle-2" class="w-4 h-4 text-emerald-400"></i>
                    <span>Selesai Memasak! 🎉</span>
                </button>
            </div>

        </div>
    </div>


    <!-- =================================================================== -->
    <!-- MODAL: API NINJAS CONFIGURATION                                     -->
    <!-- =================================================================== -->
    <div id="api-key-modal" class="fixed inset-0 z-50 bg-stone-900/60 backdrop-blur-sm hidden items-center justify-center p-4">
        <div class="bg-white rounded-3xl p-6 sm:p-8 max-w-md w-full shadow-2xl border border-stone-200 relative animate-in fade-in zoom-in-95 duration-150">
            <button onclick="closeApiKeyModal()" class="absolute top-4 right-4 w-8 h-8 rounded-full bg-stone-100 hover:bg-stone-200 text-stone-700 flex items-center justify-center">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
            <div class="flex items-center gap-2.5 mb-3">
                <div class="w-9 h-9 rounded-2xl bg-orange-100 flex items-center justify-center text-brand-orange font-bold">
                    <i data-lucide="key" class="w-5 h-5"></i>
                </div>
                <div>
                    <h4 class="font-serif font-bold text-lg text-stone-900 leading-none">API Ninjas Recipe Key</h4>
                    <span class="text-[10px] text-stone-500 font-mono">https://api.api-ninjas.com/v1/recipe</span>
                </div>
            </div>
            <p class="text-xs text-stone-600 font-sans leading-relaxed mb-4">
                Masukkan API Key dari <a href="https://api-ninjas.com/api/recipe" target="_blank" class="text-brand-orange underline font-semibold">API Ninjas</a> untuk mencari jutaan resep live langsung saat mengetik di search bar.
            </p>
            <form onsubmit="saveApiKey(event)" class="space-y-4">
                <div>
                    <label class="block text-xs font-bold font-mono uppercase text-stone-600 mb-1">X-Api-Key Anda</label>
                    <input type="text" id="input-api-key" placeholder="Contoh: aBcDeFgHiJkLmNoPqRsTuVwXyZ..." class="w-full p-2.5 rounded-xl border border-stone-300 text-xs font-mono focus:outline-none focus:ring-2 focus:ring-brand-orange">
                </div>
                <div class="flex items-center justify-between pt-1">
                    <button type="button" onclick="clearApiKey()" class="text-xs text-red-600 hover:underline">Hapus Key</button>
                    <div class="flex gap-2">
                        <button type="button" onclick="closeApiKeyModal()" class="px-4 py-2 rounded-full text-xs font-semibold text-stone-600 hover:bg-stone-100">Batal</button>
                        <button type="submit" class="px-5 py-2 rounded-full bg-stone-900 hover:bg-black text-white text-xs font-bold shadow-md">Simpan Key</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <!-- Toast Notification -->
    <div id="recipe-toast" class="fixed bottom-6 right-6 z-50 bg-stone-900 text-white text-xs font-sans px-4 py-3 rounded-2xl shadow-2xl border border-stone-700 flex items-center gap-2 transform translate-y-24 opacity-0 transition-all duration-300 pointer-events-none">
        <i data-lucide="check-circle" class="w-4 h-4 text-emerald-400"></i>
        <span id="recipe-toast-text">Notifikasi</span>
    </div>



    <!-- Footer -->
    <footer class="max-w-7xl mx-auto w-full px-4 sm:px-8 py-8 border-t border-stone-200/80 mt-12 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs font-mono text-stone-500">
        <div>
            <strong>D' Cacious</strong> — Resep & Inspirasi Kuliner Berkualitas Tinggi.
        </div>
        <div class="flex items-center gap-4">
            <a href="/" class="hover:text-stone-900 font-bold text-amber-600">← Kembali ke CaQuotes</a>
            <a href="#hero" class="hover:text-stone-900">Atas</a>
            <a href="#plate-section" class="hover:text-stone-900">What's on our Plate</a>
            <a href="#catalog-section" class="hover:text-stone-900">Katalog</a>
        </div>
    </footer>


    <!-- Client Data & Interactive Logic -->
    <script>
        const recipesData = @json($recipes);
        let currentRecipe = null;
        let checkedIngredients = new Set();
        let checkedSteps = new Set();

        document.addEventListener('DOMContentLoaded', () => {
            lucide.createIcons();

            @if(isset($autoOpenId))
                openRecipeDetail('{{ $autoOpenId }}');
            @endif
        });

        // ===================================================================
        // 1. SPLIT PLATE ANIMATION & OPEN MODAL (Foto 2)
        // ===================================================================
        function triggerSplitAndOpen(recipeId, plateElement) {
            const container = plateElement.querySelector('.plate-container');
            if (container) {
                container.classList.add('is-split');
                playSplitSound();
            }

            setTimeout(() => {
                openRecipeDetail(recipeId);
                if (container) container.classList.remove('is-split');
            }, 450);
        }

        // ===================================================================
        // 2. RECIPE DETAIL & CHECKLIST INITIALIZER (Foto 3)
        // ===================================================================
        function openRecipeDetail(recipeId) {
            const recipe = recipesData.find(r => r.id === String(recipeId)) || recipesData[0];
            currentRecipe = recipe;
            checkedIngredients.clear();
            checkedSteps.clear();

            // Populate Modal Text
            document.getElementById('modal-dish-title').innerText = recipe.name;
            document.getElementById('modal-dish-category').innerText = recipe.category;
            document.getElementById('modal-dish-calories').innerText = recipe.calories;
            document.getElementById('modal-dish-time').innerText = recipe.cook_time;
            document.getElementById('modal-dish-desc').innerText = recipe.description;
            document.getElementById('modal-dish-servings').innerText = recipe.servings;
            document.getElementById('modal-dish-difficulty').innerText = recipe.difficulty;
            document.getElementById('modal-dish-rating').innerText = `⭐ ${recipe.rating}`;
            document.getElementById('modal-dish-image').src = recipe.image;

            // Render Ingredients Checklist
            renderIngredients(recipe.ingredients);

            // Render Instructions Timeline
            renderInstructions(recipe.instructions);

            updateChecklistCounter();

            const modal = document.getElementById('recipe-modal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            lucide.createIcons();
        }

        function closeRecipeModal() {
            const modal = document.getElementById('recipe-modal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        // Render Ingredients with Interactive Clickable Checkbox Cards (Foto 3)
        function renderIngredients(ingredients) {
            const container = document.getElementById('ingredients-grid');
            container.innerHTML = '';

            ingredients.forEach((ing, index) => {
                const card = document.createElement('div');
                card.id = `ing-card-${index}`;
                card.className = 'ingredient-card p-3 rounded-2xl bg-white border border-stone-200/90 shadow-sm cursor-pointer select-none transition-all hover:shadow-md flex flex-col justify-between';
                card.onclick = () => toggleIngredient(index);

                card.innerHTML = `
                    <div class="flex items-start justify-between gap-2">
                        <div class="w-9 h-9 rounded-xl bg-stone-100 flex items-center justify-center text-xl shadow-inner">
                            ${ing.icon || '🥗'}
                        </div>
                        <div class="check-indicator w-5 h-5 rounded-full border border-stone-300 flex items-center justify-center text-[10px] transition-colors">
                            <i data-lucide="check" class="w-3 h-3"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <h6 class="font-bold text-xs text-stone-900 leading-tight font-sans">${ing.name}</h6>
                        <span class="text-[10px] font-mono text-stone-500 mt-0.5 block">${ing.amount}</span>
                    </div>
                `;
                container.appendChild(card);
            });
            lucide.createIcons();
        }

        function toggleIngredient(index) {
            const card = document.getElementById(`ing-card-${index}`);
            if (checkedIngredients.has(index)) {
                checkedIngredients.delete(index);
                card.classList.remove('is-checked');
            } else {
                checkedIngredients.add(index);
                card.classList.add('is-checked');
                playPop();
            }
            updateChecklistCounter();
        }

        function updateChecklistCounter() {
            if (!currentRecipe) return;
            const total = currentRecipe.ingredients.length;
            const count = checkedIngredients.size;
            document.getElementById('checklist-counter').innerText = `Siap: ${count} / ${total} Bahan`;
            if (count === total && total > 0) {
                showToast('Semua bahan telah siap! Waktunya memasak 🍳');
                celebrateSmall();
            }
        }

        function resetIngredientsChecklist() {
            checkedIngredients.clear();
            document.querySelectorAll('.ingredient-card').forEach(card => card.classList.remove('is-checked'));
            updateChecklistCounter();
            showToast('Daftar bahan direset.');
        }

        // Render Step-by-Step Cooking Guide with Checkbox & Step completion
        function renderInstructions(instructions) {
            const container = document.getElementById('instructions-timeline');
            container.innerHTML = '';

            instructions.forEach((st) => {
                const row = document.createElement('div');
                row.id = `step-row-${st.step}`;
                row.className = 'p-4 rounded-2xl bg-white border border-stone-200/90 shadow-sm flex items-start gap-4 transition-all hover:border-brand-orange';
                
                row.innerHTML = `
                    <button onclick="toggleStep(${st.step})" class="mt-0.5 w-6 h-6 rounded-full border-2 border-stone-300 hover:border-brand-orange flex items-center justify-center text-white transition-colors step-check-btn">
                        <i data-lucide="check" class="w-3.5 h-3.5 opacity-0"></i>
                    </button>
                    <div class="flex-1">
                        <div class="flex items-center gap-2">
                            <span class="font-mono font-bold text-xs text-brand-orange uppercase">Langkah ${st.step}</span>
                            <h5 class="font-bold text-sm text-stone-900">${st.title}</h5>
                        </div>
                        <p class="text-xs text-stone-600 font-sans mt-1 leading-relaxed">${st.desc}</p>
                    </div>
                `;
                container.appendChild(row);
            });
            lucide.createIcons();
        }

        function toggleStep(stepNum) {
            const row = document.getElementById(`step-row-${stepNum}`);
            const checkBtn = row.querySelector('.step-check-btn');
            const icon = checkBtn.querySelector('i');

            if (checkedSteps.has(stepNum)) {
                checkedSteps.delete(stepNum);
                row.classList.remove('bg-emerald-50/60', 'border-emerald-300');
                checkBtn.classList.remove('bg-emerald-600', 'border-emerald-600');
                icon.classList.add('opacity-0');
            } else {
                checkedSteps.add(stepNum);
                row.classList.add('bg-emerald-50/60', 'border-emerald-300');
                checkBtn.classList.add('bg-emerald-600', 'border-emerald-600');
                icon.classList.remove('opacity-0');
                playPop();
            }
        }

        function finishCookingRecipe() {
            celebrateCook();
            showToast('Selamat! Hidangan lezat Anda telah selesai dimasak! 🍽️');
            setTimeout(() => {
                closeRecipeModal();
            }, 1800);
        }

        // ===================================================================
        // 3. CATEGORY FILTER & LIVE SEARCH (Foto 4)
        // ===================================================================
        function filterCategory(category) {
            // Update Tab styles
            document.querySelectorAll('.category-tab-btn').forEach(btn => {
                btn.className = 'category-tab-btn px-4 py-1.5 rounded-full text-xs font-semibold transition-all bg-stone-200/80 text-stone-700 hover:bg-stone-300';
            });
            const activeBtn = document.getElementById('cat-btn-' + category.toLowerCase().replace(/\s+/g, '-'));
            if (activeBtn) {
                activeBtn.className = 'category-tab-btn px-4 py-1.5 rounded-full text-xs font-semibold transition-all bg-stone-900 text-white shadow-sm';
            }

            // Filter Plate Cards
            document.querySelectorAll('.plate-card-item').forEach(plate => {
                const cat = plate.getAttribute('data-category');
                if (category === 'All' || cat === category) {
                    plate.style.display = 'flex';
                } else {
                    plate.style.display = 'none';
                }
            });

            // Filter Catalog Cards
            document.querySelectorAll('.catalog-item').forEach(item => {
                const cat = item.getAttribute('data-category');
                if (category === 'All' || cat === category) {
                    item.style.display = 'flex';
                } else {
                    item.style.display = 'none';
                }
            });
        }

        let searchDebounceTimer = null;

        function handleSearch(e) {
            const query = e.target.value.toLowerCase().trim();
            
            // 1. Filter local DOM cards immediately
            let localMatchCount = 0;
            document.querySelectorAll('.catalog-item').forEach(item => {
                const name = item.getAttribute('data-name');
                if (!query || name.includes(query)) {
                    item.style.display = 'flex';
                    localMatchCount++;
                } else {
                    item.style.display = 'none';
                }
            });

            // 2. Query API Ninjas via backend /api/recipes/search if query has 3+ chars
            clearTimeout(searchDebounceTimer);
            if (query.length >= 3) {
                searchDebounceTimer = setTimeout(() => {
                    const savedKey = localStorage.getItem('api_ninjas_key') || '';
                    fetch(`/api/recipes/search?query=${encodeURIComponent(query)}&api_key=${encodeURIComponent(savedKey)}`)
                        .then(res => res.json())
                        .then(resData => {
                            if (resData.status === 'success' && resData.data && resData.data.length > 0) {
                                resData.data.forEach(item => {
                                    const exists = recipesData.some(r => r.id === item.id || r.name.toLowerCase() === item.name.toLowerCase());
                                    if (!exists) {
                                        recipesData.push(item);
                                        appendCatalogCard(item);
                                    }
                                });
                                if (resData.source && resData.source.includes('api_ninjas')) {
                                    showToast(`Ditemukan resep dari API Ninjas untuk "${query}"! 🔍`);
                                }
                            }
                        })
                        .catch(err => console.log('Search fallback:', err));
                }, 400);
            }
        }

        function appendCatalogCard(rec) {
            const grid = document.getElementById('catalog-grid');
            if (!grid) return;
            const card = document.createElement('div');
            card.className = 'catalog-item bg-white rounded-3xl p-5 border border-stone-200 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between group cursor-pointer animate-in fade-in zoom-in-95 duration-200';
            card.setAttribute('data-name', rec.name.toLowerCase());
            card.setAttribute('data-category', rec.category || 'All');
            card.onclick = () => openRecipeDetail(rec.id);

            card.innerHTML = `
                <div>
                    <div class="relative w-full h-48 rounded-2xl overflow-hidden mb-4 bg-stone-100">
                        <img src="${rec.image}" alt="${rec.name}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <span class="absolute top-3 left-3 bg-white/90 backdrop-blur text-stone-900 text-[10px] font-mono font-bold px-2.5 py-1 rounded-full shadow-sm">
                            ${rec.category || 'Resep'}
                        </span>
                        <span class="absolute top-3 right-3 bg-brand-orange text-white text-[10px] font-mono font-bold px-2.5 py-1 rounded-full shadow-sm">
                            ${rec.calories || '400 kkal'}
                        </span>
                    </div>
                    <h4 class="font-serif font-bold text-lg text-stone-900 group-hover:text-brand-orange transition-colors">
                        ${rec.name}
                    </h4>
                    <p class="text-xs text-stone-600 mt-1 line-clamp-2 leading-relaxed">
                        ${rec.subtitle || rec.description}
                    </p>
                </div>
                <div class="border-t border-stone-100 pt-4 mt-4 flex items-center justify-between text-xs">
                    <div class="flex items-center gap-1.5 font-mono text-stone-500">
                        <i data-lucide="check-square" class="w-3.5 h-3.5 text-emerald-600"></i>
                        <span>${rec.ingredients ? rec.ingredients.length : 'Lengkap'} Bahan</span>
                    </div>
                    <button class="font-bold text-brand-orange group-hover:translate-x-1 transition-transform flex items-center gap-1">
                        <span>Lihat Resep</span>
                        <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                    </button>
                </div>
            `;
            grid.prepend(card);
            lucide.createIcons();
        }

        // API Key Management Functions
        function openApiKeyModal() {
            const key = localStorage.getItem('api_ninjas_key') || '';
            document.getElementById('input-api-key').value = key;
            const modal = document.getElementById('api-key-modal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeApiKeyModal() {
            const modal = document.getElementById('api-key-modal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function saveApiKey(e) {
            e.preventDefault();
            const key = document.getElementById('input-api-key').value.trim();
            if (key) {
                localStorage.setItem('api_ninjas_key', key);
                showToast('API Ninjas Key berhasil disimpan! 🔑');
            } else {
                localStorage.removeItem('api_ninjas_key');
                showToast('API Ninjas Key dihapus.');
            }
            closeApiKeyModal();
        }

        function clearApiKey() {
            localStorage.removeItem('api_ninjas_key');
            document.getElementById('input-api-key').value = '';
            showToast('API Ninjas Key dihapus.');
            closeApiKeyModal();
        }

        function scrollToCatalog() {
            document.getElementById('catalog-section').scrollIntoView({ behavior: 'smooth' });
        }


        // ===================================================================
        // 4. SOUND & CELEBRATION UTILITIES
        // ===================================================================
        let audioCtx = null;
        function getAudio() {
            if (!audioCtx) audioCtx = new (window.AudioContext || window.webkitAudioContext)();
            if (audioCtx.state === 'suspended') audioCtx.resume();
            return audioCtx;
        }

        function playPop() {
            try {
                const ctx = getAudio();
                const osc = ctx.createOscillator();
                const gain = ctx.createGain();
                osc.type = 'sine';
                osc.frequency.setValueAtTime(600, ctx.currentTime);
                osc.frequency.exponentialRampToValueAtTime(300, ctx.currentTime + 0.06);
                gain.gain.setValueAtTime(0.15, ctx.currentTime);
                gain.gain.exponentialRampToValueAtTime(0.01, ctx.currentTime + 0.06);
                osc.connect(gain);
                gain.connect(ctx.destination);
                osc.start();
                osc.stop(ctx.currentTime + 0.06);
            } catch(e){}
        }

        function playSplitSound() {
            try {
                const ctx = getAudio();
                const osc = ctx.createOscillator();
                const gain = ctx.createGain();
                osc.type = 'triangle';
                osc.frequency.setValueAtTime(240, ctx.currentTime);
                osc.frequency.exponentialRampToValueAtTime(120, ctx.currentTime + 0.18);
                gain.gain.setValueAtTime(0.18, ctx.currentTime);
                gain.gain.exponentialRampToValueAtTime(0.01, ctx.currentTime + 0.18);
                osc.connect(gain);
                gain.connect(ctx.destination);
                osc.start();
                osc.stop(ctx.currentTime + 0.18);
            } catch(e){}
        }

        function showToast(text) {
            const toast = document.getElementById('recipe-toast');
            document.getElementById('recipe-toast-text').innerText = text;
            toast.classList.remove('translate-y-24', 'opacity-0');
            setTimeout(() => {
                toast.classList.add('translate-y-24', 'opacity-0');
            }, 2600);
        }

        function celebrateCook() {
            if (typeof confetti === 'function') {
                confetti({
                    particleCount: 50,
                    spread: 70,
                    origin: { y: 0.75 }
                });
            }
        }

        function celebrateSmall() {
            if (typeof confetti === 'function') {
                confetti({
                    particleCount: 25,
                    spread: 45,
                    origin: { y: 0.8 }
                });
            }
        }

        // Close modal on Escape
        window.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closeRecipeModal();
        });
    </script>
</body>
</html>

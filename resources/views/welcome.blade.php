<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>CaQuotes — Interactive Quotes & Authors Curation</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Space+Grotesk:wght@400;600;700&family=Playfair+Display:ital,wght@0,600;0,800;1,400&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Matter.js for 2D Physics Engine -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/matter-js/0.19.0/matter.min.js"></script>
    
    <!-- Canvas Confetti CDN -->
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        serif: ['"Instrument Serif"', 'Georgia', 'serif'],
                        display: ['"Playfair Display"', 'serif'],
                        mono: ['"Space Grotesk"', 'monospace'],
                    },
                    colors: {
                        cream: '#F7F4EE',
                        'cream-card': '#EDE8DE',
                        dark: '#121212',
                        'brand-orange': '#FF5E36',
                        'brand-yellow': '#FACC15',
                        'brand-blue': '#2563EB',
                    }
                }
            }
        }
    </script>

    <style>
        body {
            background-color: #F7F4EE;
            color: #1c1917;
            overflow-x: hidden;
            user-select: none;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #EDE8DE;
        }
        ::-webkit-scrollbar-thumb {
            background: #A8A29E;
            border-radius: 9999px;
        }

        /* 3D Perspective & Animations */
        .perspective-1000 {
            perspective: 1200px;
        }
        .transform-style-3d {
            transform-style: preserve-3d;
        }

        /* Book Spine Styles */
        .book-spine {
            transition: transform 0.35s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.3s ease;
            box-shadow: -4px 0 10px rgba(0,0,0,0.15), inset -2px 0 5px rgba(0,0,0,0.25), inset 2px 0 5px rgba(255,255,255,0.3);
            writing-mode: vertical-rl;
            text-orientation: mixed;
            transform-origin: bottom center;
        }
        .book-spine:hover {
            transform: translateY(-24px) scale(1.03) rotateZ(-1.5deg);
            box-shadow: -8px 12px 24px rgba(0,0,0,0.25), inset -2px 0 6px rgba(0,0,0,0.3);
            z-index: 30;
        }

        /* Open Book 3D Container */
        .opened-book-page {
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.35);
        }

        /* Folder Swipe Card Stack */
        .folder-card {
            transition: transform 0.45s cubic-bezier(0.2, 0.8, 0.2, 1), opacity 0.4s ease, filter 0.3s ease;
            transform-origin: center bottom;
            touch-action: none;
        }

        /* Floating Pill Glow */
        .pill-badge {
            cursor: grab;
            transition: box-shadow 0.2s ease, transform 0.1s ease;
        }
        .pill-badge:active {
            cursor: grabbing;
        }

        /* Glassmorphism */
        .glass-nav {
            background: rgba(247, 244, 238, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(214, 211, 209, 0.6);
        }

        /* Paper Texture subtle effect */
        .paper-grain {
            background-image: radial-gradient(#d6d3d1 0.75px, transparent 0.75px);
            background-size: 14px 14px;
        }
    </style>
</head>
<body class="min-h-screen paper-grain antialiased flex flex-col justify-between selection:bg-stone-900 selection:text-white">

    <!-- Top Sticky Header Bar (Xhulia & BrandAppart Style) -->
    <header class="sticky top-4 z-50 px-4 max-w-6xl mx-auto w-full">
        <div class="glass-nav rounded-full px-4 py-2.5 shadow-sm flex items-center justify-between gap-2 border border-stone-300/80">
            <!-- Brand Logo -->
            <div class="flex items-center gap-3">
                <a href="#" class="flex items-center gap-2 group">
                    <div class="w-9 h-9 rounded-full bg-stone-900 text-amber-100 flex items-center justify-center font-serif text-xl font-bold group-hover:scale-105 transition-transform shadow-sm">
                        Ca
                    </div>
                    <div class="flex flex-col">
                        <span class="font-bold text-base tracking-tight font-mono text-stone-900 leading-none">CaQuotes</span>
                        <span class="text-[10px] text-stone-500 font-sans uppercase tracking-widest mt-0.5">Curation of Minds</span>
                    </div>
                </a>
            </div>

            <!-- Central Nav Pills -->
            <nav class="hidden md:flex items-center gap-1.5 bg-stone-200/70 p-1 rounded-full text-xs font-semibold text-stone-700">
                <button onclick="switchMode('folder')" id="nav-folder" class="px-4 py-1.5 rounded-full transition-all duration-200 bg-white text-stone-900 shadow-sm flex items-center gap-1.5">
                    <i data-lucide="layers" class="w-3.5 h-3.5"></i>
                    <span>Folder Swipe</span>
                </button>
                <button onclick="switchMode('bookshelf')" id="nav-bookshelf" class="px-4 py-1.5 rounded-full transition-all duration-200 hover:text-stone-900 hover:bg-white/60 flex items-center gap-1.5">
                    <i data-lucide="book-open" class="w-3.5 h-3.5"></i>
                    <span>Rak Buku 3D</span>
                </button>
                <button onclick="switchMode('physics')" id="nav-physics" class="px-4 py-1.5 rounded-full transition-all duration-200 hover:text-stone-900 hover:bg-white/60 flex items-center gap-1.5">
                    <i data-lucide="sparkles" class="w-3.5 h-3.5"></i>
                    <span>Physics Gyro</span>
                </button>
                <button onclick="switchMode('explorer')" id="nav-explorer" class="px-4 py-1.5 rounded-full transition-all duration-200 hover:text-stone-900 hover:bg-white/60 flex items-center gap-1.5">
                    <i data-lucide="compass" class="w-3.5 h-3.5"></i>
                    <span>Semua Penulis</span>
                </button>
                <a href="/resep" class="px-3.5 py-1.5 rounded-full bg-orange-100 hover:bg-orange-200 text-orange-900 font-bold transition-all flex items-center gap-1 shadow-sm">
                    <i data-lucide="utensils" class="w-3.5 h-3.5 text-brand-orange"></i>
                    <span>D' Cacious 🍳</span>
                </a>
            </nav>

            <!-- Action Controls -->
            <div class="flex items-center gap-2">
                <!-- Sound Toggle Button -->
                <button onclick="toggleAudioSFX()" id="sound-btn" title="Efek Suara Interaktif" class="w-9 h-9 rounded-full bg-stone-200/80 hover:bg-stone-300 text-stone-700 flex items-center justify-center transition-colors">
                    <i data-lucide="volume-2" id="sound-icon" class="w-4 h-4"></i>
                </button>
                
                <!-- Add Quote Modal Button -->
                <button onclick="openAddQuoteModal()" class="w-9 h-9 rounded-full bg-stone-900 hover:bg-black text-white flex items-center justify-center transition-transform hover:scale-105 shadow-sm" title="Tambah Quote Baru">
                    <i data-lucide="plus" class="w-4 h-4"></i>
                </button>

                <!-- Randomizer Button -->
                <button onclick="triggerRandomInspire()" class="bg-amber-400 hover:bg-amber-300 text-stone-900 text-xs font-bold px-3.5 py-2 rounded-full flex items-center gap-1.5 transition-all shadow-sm active:scale-95">
                    <i data-lucide="shuffle" class="w-3.5 h-3.5"></i>
                    <span class="hidden sm:inline">Acak Kutipan</span>
                </button>
            </div>
        </div>

        <!-- Mobile Navigation bar -->
        <div class="flex md:hidden justify-center gap-1 mt-2 bg-stone-200/80 p-1 rounded-full text-xs font-semibold text-stone-700 shadow-sm">
            <button onclick="switchMode('folder')" id="mob-folder" class="flex-1 py-1 rounded-full bg-white text-stone-900 text-center">Folder</button>
            <button onclick="switchMode('bookshelf')" id="mob-bookshelf" class="flex-1 py-1 rounded-full text-center">Rak Buku</button>
            <button onclick="switchMode('physics')" id="mob-physics" class="flex-1 py-1 rounded-full text-center">Physics</button>
            <button onclick="switchMode('explorer')" id="mob-explorer" class="flex-1 py-1 rounded-full text-center">Penulis</button>
        </div>
    </header>

    <!-- Main Container -->
    <main class="flex-1 max-w-6xl w-full mx-auto px-4 py-6 flex flex-col justify-center">

        <!-- =================================================================== -->
        <!-- SECTION 1: FOLDER SWIPE UP DECK (BrandAppart / Photo 1 & 2 Style)   -->
        <!-- =================================================================== -->
        <section id="section-folder" class="mode-section block">
            <div class="text-center mb-6">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-100 border border-amber-300/60 text-amber-900 text-xs font-mono font-semibold uppercase tracking-wider mb-2">
                    <i data-lucide="hand" class="w-3.5 h-3.5 animate-bounce"></i> Swipe / Drag ke Atas untuk Ganti Kutipan
                </span>
                <h1 class="text-3xl sm:text-5xl font-serif text-stone-900 tracking-tight">
                    Koleksi Pemikiran Para Tokoh
                </h1>
                <p class="text-stone-600 text-sm max-w-md mx-auto mt-1 font-sans">
                    Geser folder kartu ke atas atau klik tombol kontrol untuk melihat kutipan berikutnya.
                </p>
            </div>

            <!-- Folder Deck Container with Left Side Dock (BrandAppart Reference) -->
            <div class="relative max-w-4xl mx-auto min-h-[460px] sm:min-h-[520px] flex items-center justify-center">
                
                <!-- Left Side Vertical Floating Dock (Photo 1 reference) -->
                <div class="hidden sm:flex absolute left-0 top-1/2 -translate-y-1/2 flex-col gap-2 p-2 bg-stone-200/90 rounded-2xl shadow-sm border border-stone-300 z-30">
                    <button onclick="showFolderToast('Halaman Beranda Folder')" class="w-9 h-9 rounded-xl bg-white shadow-sm flex items-center justify-center text-stone-800 hover:scale-105 transition-transform" title="Home">
                        <i data-lucide="home" class="w-4 h-4"></i>
                    </button>
                    <button onclick="prevFolderCard()" class="w-9 h-9 rounded-xl hover:bg-white/70 flex items-center justify-center text-stone-700 transition-colors" title="Folder Sebelumnya">
                        <i data-lucide="chevron-up" class="w-4 h-4"></i>
                    </button>
                    <button onclick="nextFolderCard()" class="w-9 h-9 rounded-xl hover:bg-white/70 flex items-center justify-center text-stone-700 transition-colors" title="Folder Berikutnya (Swipe Up)">
                        <i data-lucide="chevron-down" class="w-4 h-4"></i>
                    </button>
                    <button onclick="copyCurrentFolderQuote()" class="w-9 h-9 rounded-xl hover:bg-white/70 flex items-center justify-center text-stone-700 transition-colors" title="Salin Quote">
                        <i data-lucide="copy" class="w-4 h-4"></i>
                    </button>
                    <button onclick="speakCurrentFolderQuote()" class="w-9 h-9 rounded-xl hover:bg-white/70 flex items-center justify-center text-stone-700 transition-colors" title="Dengarkan Suara (Audio)">
                        <i data-lucide="volume-2" class="w-4 h-4"></i>
                    </button>
                </div>

                <!-- Swipe Deck Stack -->
                <div id="folder-deck" class="relative w-full max-w-2xl h-[420px] sm:h-[460px] mx-auto perspective-1000 flex items-center justify-center">
                    @foreach ($folderQuotes as $index => $folder)
                    <div 
                        id="card-{{ $index }}" 
                        data-index="{{ $index }}"
                        data-quote="{{ $folder['quote'] }}"
                        data-author="{{ $folder['author'] }}"
                        data-title="{{ $folder['title'] }}"
                        class="folder-card absolute w-full rounded-3xl p-6 sm:p-9 shadow-2xl border border-white/20 select-none cursor-grab active:cursor-grabbing flex flex-col justify-between"
                        style="background-color: {{ $folder['color'] }}; color: #ffffff; z-index: {{ 20 - $index }};"
                    >
                        <!-- Card Header (Tab Number & Category) -->
                        <div class="flex items-start justify-between border-b border-white/15 pb-4">
                            <div>
                                <span class="px-3 py-1 rounded-full bg-white/20 backdrop-blur text-xs font-mono font-bold tracking-wider uppercase">
                                    {{ $folder['tag'] }}
                                </span>
                                <h3 class="text-xl sm:text-2xl font-bold font-sans mt-3 leading-snug tracking-tight text-white max-w-md">
                                    {{ $folder['title'] }}
                                </h3>
                            </div>
                            <span class="text-2xl sm:text-3xl font-mono font-bold opacity-75">({{ $folder['index'] }})</span>
                        </div>

                        <!-- Card Body (Quote Text in Serif) -->
                        <div class="my-4 py-2">
                            <p class="font-serif italic text-lg sm:text-2xl text-white/95 leading-relaxed">
                                “{{ $folder['quote'] }}”
                            </p>
                        </div>

                        <!-- Card Footer (Author info, Mockup badge, Action button) -->
                        <div class="flex flex-wrap items-center justify-between gap-4 pt-4 border-t border-white/15">
                            <div class="flex items-center gap-3">
                                <div class="w-11 h-11 rounded-full bg-white/20 backdrop-blur-md flex items-center justify-center font-serif text-xl font-bold text-white border border-white/30 shadow-inner">
                                    {{ substr($folder['author'], 0, 1) }}
                                </div>
                                <div>
                                    <h4 class="font-bold text-sm sm:text-base text-white font-sans leading-none">{{ $folder['author'] }}</h4>
                                    <p class="text-xs text-white/70 mt-1 font-sans">{{ $folder['role'] }}</p>
                                </div>
                            </div>

                            <!-- Interactive Pill Action -->
                            <div class="flex items-center gap-2">
                                <button onclick="openFolderDetail({{ $index }})" class="bg-white text-stone-900 hover:bg-stone-100 font-bold text-xs sm:text-sm px-4 py-2.5 rounded-full shadow-lg flex items-center gap-2 transition-transform hover:scale-105 active:scale-95">
                                    <span>Eksplorasi Karya</span>
                                    <i data-lucide="arrow-up-right" class="w-4 h-4"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Mini Swipe Up Indicator at the bottom edge -->
                        <div class="absolute -bottom-3 left-1/2 -translate-x-1/2 bg-white/90 text-stone-800 text-[10px] font-mono px-3 py-0.5 rounded-full shadow-md flex items-center gap-1">
                            <i data-lucide="chevrons-up" class="w-3 h-3 animate-pulse"></i> Geser ke atas
                        </div>
                    </div>
                    @endforeach
                </div>

            </div>

            <!-- Bottom Controller Navigation for Folders -->
            <div class="flex items-center justify-center gap-3 mt-6">
                <button onclick="prevFolderCard()" class="p-3 rounded-full bg-stone-200 hover:bg-stone-300 text-stone-800 transition-transform active:scale-95" title="Sebelumnya">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i>
                </button>
                <div id="folder-indicator" class="font-mono text-xs font-bold text-stone-600 px-3 py-1 bg-stone-200/80 rounded-full">
                    1 / {{ count($folderQuotes) }}
                </div>
                <button onclick="nextFolderCard()" class="p-3 rounded-full bg-stone-900 hover:bg-black text-white transition-transform active:scale-95" title="Berikutnya (Swipe Up)">
                    <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </button>
            </div>
        </section>


        <!-- =================================================================== -->
        <!-- SECTION 2: 3D INTERACTIVE BOOKSHELF (JZA Studio / Photo 3 & 4 Style)-->
        <!-- =================================================================== -->
        <section id="section-bookshelf" class="mode-section hidden">
            <div class="text-center mb-8">
                <span class="text-xs font-mono uppercase tracking-widest text-stone-500 font-bold">PART 1 • THE PERSONAL CURATION</span>
                <h2 class="text-3xl sm:text-5xl font-serif text-stone-900 tracking-tight mt-1">
                    Rak Buku & Cita Rasa Pikiran
                </h2>
                <p class="text-stone-600 text-sm max-w-md mx-auto mt-2 font-sans">
                    Klik punggung buku di rak untuk membuka halaman 3D dan membaca kutipan mendalam beserta biografi penulis.
                </p>
            </div>

            <!-- Bookshelf Stage -->
            <div class="relative max-w-5xl mx-auto py-10 px-2 sm:px-6">
                
                <!-- Books Array Row -->
                <div id="bookshelf-row" class="relative flex items-end justify-center gap-2 sm:gap-3.5 overflow-x-auto pb-4 pt-10 px-4 min-h-[420px] select-none">
                    @foreach ($books as $bIndex => $book)
                    <div 
                        onclick="open3DBook({{ $bIndex }})"
                        data-book-id="{{ $book['id'] }}"
                        class="book-spine relative cursor-pointer rounded-t-sm flex items-center justify-between py-5 px-1.5 shadow-md flex-shrink-0"
                        style="background-color: {{ $book['spine_color'] }}; height: {{ $book['height'] }}; width: {{ $book['width'] }}; color: {{ $book['text_color'] }};"
                        title="Klik untuk membuka {{ $book['title'] }} oleh {{ $book['author'] }}"
                    >
                        <!-- Top Spine Accent / Ribbon bookmark indicator -->
                        <div class="w-2.5 h-2 rounded-full bg-red-500/80 mb-2 self-center"></div>

                        <!-- Vertical Spine Title -->
                        <span class="{{ $book['font'] }} text-xs sm:text-sm tracking-wider uppercase truncate leading-tight select-none">
                            {{ $book['spine_title'] }}
                        </span>

                        <!-- Bottom Author & Symbol -->
                        <div class="flex flex-col items-center gap-1 mt-auto select-none">
                            <span class="text-[10px] font-mono opacity-80 uppercase">{{ substr($book['author'], 0, 10) }}</span>
                            <div class="w-3 h-0.5 bg-current opacity-40"></div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Realistic Wooden Shelf Base Line -->
                <div class="relative w-full h-5 bg-gradient-to-r from-stone-400 via-stone-300 to-stone-400 rounded-sm shadow-xl border-t border-stone-200 flex items-center justify-between px-6">
                    <div class="text-[9px] font-mono text-stone-600 uppercase tracking-widest font-bold">CaQuotes Curation Shelf</div>
                    <div class="text-[9px] font-mono text-stone-600">8 Curated Volumes</div>
                </div>
                <div class="w-[98%] mx-auto h-3 bg-stone-300/60 rounded-b-md shadow-inner"></div>

            </div>

            <!-- Hint helper -->
            <div class="flex justify-center items-center gap-2 mt-4 text-xs text-stone-500 font-mono">
                <i data-lucide="info" class="w-3.5 h-3.5"></i>
                <span>Pilih salah satu buku di rak untuk membuka tampilan 3D book cover & quote</span>
            </div>
        </section>


        <!-- =================================================================== -->
        <!-- SECTION 3: PHYSICS & GYRO QUOTE PILLS (Xhulia / Photo 5 Style)      -->
        <!-- =================================================================== -->
        <section id="section-physics" class="mode-section hidden">
            <!-- Hero Statement Text (Photo 5 reference) -->
            <div class="text-center max-w-3xl mx-auto mb-4 px-4">
                <div class="inline-flex items-center gap-2 px-3 py-1 bg-stone-200/80 rounded-full text-stone-700 text-xs font-semibold mb-3">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></span>
                    <span>Interactive Gravity & Gyro Engine</span>
                </div>
                <h2 class="text-3xl sm:text-5xl font-serif text-stone-900 leading-tight">
                    Kutipan singkat yang <span class="italic font-normal">bergerak bebas</span> mengikuti gerakan laptop & kursor Anda.
                </h2>
                <p class="text-stone-600 text-sm max-w-md mx-auto mt-2 font-sans">
                    Miringkan laptop / HP Anda (Gyroscope) atau lempar dan seret pil kutipan dengan mouse!
                </p>
            </div>

            <!-- Physics Interactive Controls Toolbar -->
            <div class="flex flex-wrap items-center justify-center gap-2 mb-3">
                <button onclick="shakePhysicsWorld()" class="px-3.5 py-1.5 rounded-full bg-stone-900 text-white text-xs font-bold flex items-center gap-1.5 shadow-sm hover:scale-105 active:scale-95 transition-transform">
                    <i data-lucide="zap" class="w-3.5 h-3.5 text-amber-300"></i> Kocok Gravitasi (Shake)
                </button>
                <button onclick="toggleInvertGravity()" id="btn-grav" class="px-3.5 py-1.5 rounded-full bg-stone-200 hover:bg-stone-300 text-stone-800 text-xs font-semibold flex items-center gap-1.5 transition-colors">
                    <i data-lucide="arrow-up-down" class="w-3.5 h-3.5"></i> Balik Gravitasi
                </button>
                <button onclick="spawnRandomPill()" class="px-3.5 py-1.5 rounded-full bg-amber-200 hover:bg-amber-300 text-amber-900 text-xs font-bold flex items-center gap-1.5 transition-colors">
                    <i data-lucide="plus-circle" class="w-3.5 h-3.5"></i> Tambah Pil
                </button>
                <button onclick="requestGyroPermission()" id="gyro-btn" class="px-3.5 py-1.5 rounded-full bg-blue-100 hover:bg-blue-200 text-blue-900 text-xs font-semibold flex items-center gap-1.5 transition-colors">
                    <i data-lucide="smartphone" class="w-3.5 h-3.5"></i> Kalibrasi Gyro Sensor
                </button>
            </div>

            <!-- Physics Canvas Sandbox (Matter.js container) -->
            <div class="relative w-full max-w-4xl mx-auto h-[380px] sm:h-[440px] bg-stone-200/50 rounded-3xl border-2 border-dashed border-stone-300 overflow-hidden shadow-inner flex flex-col justify-end">
                <div id="physics-canvas-container" class="absolute inset-0 w-full h-full"></div>
                
                <!-- Live Sensor Info Overlay -->
                <div class="absolute top-3 left-3 z-10 bg-white/80 backdrop-blur px-3 py-1 rounded-full text-[10px] font-mono text-stone-600 border border-stone-300/80 flex items-center gap-2">
                    <span id="gyro-status-dot" class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                    <span id="gyro-status-text">Sensor: Mouse & Laptop Tilt Aktif</span>
                </div>

                <div class="absolute bottom-3 right-3 z-10 pointer-events-none bg-stone-900/80 text-white text-[10px] font-mono px-3 py-1 rounded-full backdrop-blur">
                    💡 Klik pada sembarang pil untuk membaca kutipan lengkap!
                </div>
            </div>
        </section>


        <!-- =================================================================== -->
        <!-- SECTION 4: ALL AUTHORS & QUOTES EXPLORER (Search & Filter Mode)     -->
        <!-- =================================================================== -->
        <section id="section-explorer" class="mode-section hidden">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mb-6">
                <div>
                    <h2 class="text-3xl font-serif text-stone-900">Katalog Penulis & Kutipan</h2>
                    <p class="text-stone-600 text-xs font-sans mt-0.5">Temukan inspirasi berdasarkan nama tokoh favorit Anda.</p>
                </div>
                <!-- Search Input -->
                <div class="relative w-full sm:w-72">
                    <i data-lucide="search" class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-stone-400"></i>
                    <input 
                        type="text" 
                        id="search-input" 
                        oninput="filterQuotesList()" 
                        placeholder="Cari penulis, kata kunci, topik..." 
                        class="w-full pl-9 pr-4 py-2 rounded-full bg-white border border-stone-300 text-xs focus:outline-none focus:ring-2 focus:ring-stone-900 shadow-sm"
                    >
                </div>
            </div>

            <!-- Quotes Grid List -->
            <div id="quotes-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <!-- Javascript will populate / Blade cards -->
                @foreach (array_merge($folderQuotes, $books) as $item)
                <div class="quote-card-item bg-white p-5 rounded-2xl border border-stone-200 shadow-sm hover:shadow-md transition-all flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between gap-2 mb-2">
                            <span class="text-[10px] font-mono font-bold uppercase px-2 py-0.5 rounded-md bg-stone-100 text-stone-700">
                                {{ $item['genre'] ?? $item['tag'] ?? 'Inspirasi' }}
                            </span>
                            <span class="text-[11px] font-mono text-stone-400">{{ $item['year'] ?? 'Klasik' }}</span>
                        </div>
                        <p class="font-serif italic text-base text-stone-800 line-clamp-3 mb-3">
                            “{{ $item['quote'] }}”
                        </p>
                    </div>
                    <div class="flex items-center justify-between border-t border-stone-100 pt-3 mt-2">
                        <div>
                            <h5 class="font-bold text-xs text-stone-900 font-sans">{{ $item['author'] }}</h5>
                            <p class="text-[10px] text-stone-500">{{ $item['title'] ?? ($item['role'] ?? '') }}</p>
                        </div>
                        <button onclick="copyText('{{ addslashes($item['quote']) }} — {{ addslashes($item['author']) }}')" class="p-1.5 rounded-lg hover:bg-stone-100 text-stone-600 transition-colors" title="Salin">
                            <i data-lucide="copy" class="w-3.5 h-3.5"></i>
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
        </section>

    </main>

    <!-- Footer Bar -->
    <footer class="max-w-6xl mx-auto w-full px-4 py-4 text-center border-t border-stone-300/60 mt-8 flex flex-col sm:flex-row items-center justify-between gap-2 text-xs font-mono text-stone-500">
        <div>
            <strong>CaQuotes</strong> — Dibuat dengan cinta untuk para penikmat literatur & estetika visual.
        </div>
        <div class="flex items-center gap-4">
            <a href="#" onclick="switchMode('folder'); return false;" class="hover:text-stone-900">Folder Deck</a>
            <a href="#" onclick="switchMode('bookshelf'); return false;" class="hover:text-stone-900">3D Bookshelf</a>
            <a href="#" onclick="switchMode('physics'); return false;" class="hover:text-stone-900">Physics Gyro</a>
        </div>
    </footer>


    <!-- =================================================================== -->
    <!-- MODAL 1: 3D OPENED BOOK OVERLAY (Photo 3 & 4 Curation Click State)   -->
    <!-- =================================================================== -->
    <div id="book-modal" class="fixed inset-0 z-50 bg-stone-900/70 backdrop-blur-md hidden items-center justify-center p-4 transition-all duration-300">
        <div class="relative w-full max-w-3xl bg-[#FFFDF9] rounded-2xl shadow-2xl border border-stone-300 overflow-hidden flex flex-col md:flex-row min-h-[460px] animate-in fade-in zoom-in-95 duration-200">
            
            <!-- Close Button -->
            <button onclick="close3DBook()" class="absolute top-4 right-4 z-20 w-8 h-8 rounded-full bg-stone-200/80 hover:bg-stone-300 text-stone-800 flex items-center justify-center transition-transform hover:scale-105" title="Tutup Buku">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>

            <!-- Left Page: Book Cover / Author Info -->
            <div id="modal-book-left" class="w-full md:w-5/12 p-6 sm:p-8 bg-stone-100 border-b md:border-b-0 md:border-r border-stone-200 flex flex-col justify-between relative">
                <!-- Ribbon Bookmark graphic -->
                <div class="absolute top-0 right-6 w-5 h-12 bg-red-600 rounded-b shadow-md"></div>
                
                <div>
                    <span id="modal-book-genre" class="text-[10px] font-mono font-bold uppercase tracking-widest text-stone-500 bg-white px-2.5 py-1 rounded-full border border-stone-200">
                        GENRE
                    </span>
                    <h3 id="modal-book-title" class="text-2xl font-bold font-sans text-stone-900 mt-3 leading-tight">
                        Judul Buku
                    </h3>
                    <p id="modal-book-subtitle" class="text-xs text-stone-600 mt-1 font-sans">
                        Subjudul buku
                    </p>
                </div>

                <div class="my-4 pt-4 border-t border-stone-200">
                    <div class="flex items-center gap-3">
                        <div id="modal-author-avatar" class="w-12 h-12 rounded-full bg-stone-900 text-amber-100 flex items-center justify-center font-serif text-xl font-bold">
                            A
                        </div>
                        <div>
                            <h4 id="modal-book-author" class="font-bold text-sm text-stone-900 font-sans">Nama Penulis</h4>
                            <span id="modal-book-meta" class="text-[11px] text-stone-500 font-mono">Tahun • 320 Halaman</span>
                        </div>
                    </div>
                    <p id="modal-author-bio" class="text-xs text-stone-600 mt-3 leading-relaxed font-sans">
                        Biografi ringkas penulis...
                    </p>
                </div>

                <div class="text-[10px] font-mono text-stone-400">
                    Koleksi CaQuotes Library • Part 1
                </div>
            </div>

            <!-- Right Page: The Big Quote & Share actions -->
            <div class="w-full md:w-7/12 p-6 sm:p-10 flex flex-col justify-between bg-[#FFFDF9] relative">
                <div>
                    <div class="text-amber-500 text-4xl font-serif leading-none">“</div>
                    <p id="modal-book-quote" class="text-xl sm:text-2xl font-serif text-stone-900 leading-relaxed italic mt-1">
                        Kutipan kata mutiara di dalam buku ini...
                    </p>
                    <div class="text-right text-amber-500 text-4xl font-serif leading-none mt-2">”</div>
                </div>

                <div class="flex flex-wrap items-center justify-between gap-3 pt-6 border-t border-stone-200 mt-6">
                    <div class="flex items-center gap-2">
                        <button onclick="copyModalQuote()" class="px-3.5 py-2 rounded-full bg-stone-900 hover:bg-black text-white text-xs font-bold flex items-center gap-1.5 shadow-sm active:scale-95 transition-transform">
                            <i data-lucide="copy" class="w-3.5 h-3.5"></i>
                            <span>Salin Quote</span>
                        </button>
                        <button onclick="speakModalQuote()" class="p-2 rounded-full bg-stone-100 hover:bg-stone-200 text-stone-800 transition-colors" title="Dengarkan Audio">
                            <i data-lucide="volume-2" class="w-4 h-4"></i>
                        </button>
                        <button onclick="celebrateQuote()" class="p-2 rounded-full bg-amber-100 hover:bg-amber-200 text-amber-800 transition-colors" title="Suka Kutipan">
                            <i data-lucide="heart" class="w-4 h-4"></i>
                        </button>
                    </div>

                    <button onclick="close3DBook()" class="text-xs font-mono text-stone-500 hover:text-stone-900 flex items-center gap-1">
                        <span>Kembali ke Rak</span>
                        <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                    </button>
                </div>

            </div>

        </div>
    </div>


    <!-- =================================================================== -->
    <!-- MODAL 2: PILL QUOTE DETAIL POPUP (Physics Pill Click Modal)         -->
    <!-- =================================================================== -->
    <div id="pill-modal" class="fixed inset-0 z-50 bg-stone-900/60 backdrop-blur-sm hidden items-center justify-center p-4">
        <div class="bg-white rounded-3xl p-6 sm:p-8 max-w-md w-full shadow-2xl border border-stone-200 relative animate-in fade-in zoom-in-95 duration-150">
            <button onclick="closePillModal()" class="absolute top-4 right-4 w-8 h-8 rounded-full bg-stone-100 hover:bg-stone-200 text-stone-700 flex items-center justify-center">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
            <div id="pill-modal-tag" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-mono font-bold mb-3">
                <span id="pill-modal-icon">💡</span>
                <span id="pill-modal-short">Short Quote</span>
            </div>
            <p id="pill-modal-full" class="font-serif italic text-xl sm:text-2xl text-stone-900 leading-snug my-2">
                "Kutipan lengkap..."
            </p>
            <div class="flex items-center justify-between border-t border-stone-100 pt-4 mt-4">
                <div>
                    <h5 id="pill-modal-author" class="font-bold text-sm text-stone-900 font-sans">Author</h5>
                    <span class="text-[10px] text-stone-500 font-mono">CaQuotes Physics Element</span>
                </div>
                <button onclick="copyPillModalQuote()" class="bg-stone-900 hover:bg-black text-white text-xs font-bold px-3.5 py-1.5 rounded-full flex items-center gap-1">
                    <i data-lucide="copy" class="w-3 h-3"></i> Salin
                </button>
            </div>
        </div>
    </div>


    <!-- =================================================================== -->
    <!-- MODAL 3: ADD NEW QUOTE (Reactive Addition to All 3 Views)           -->
    <!-- =================================================================== -->
    <div id="add-modal" class="fixed inset-0 z-50 bg-stone-900/60 backdrop-blur-sm hidden items-center justify-center p-4">
        <div class="bg-white rounded-3xl p-6 sm:p-8 max-w-lg w-full shadow-2xl border border-stone-200 relative">
            <button onclick="closeAddQuoteModal()" class="absolute top-4 right-4 w-8 h-8 rounded-full bg-stone-100 hover:bg-stone-200 text-stone-700 flex items-center justify-center">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
            <div class="flex items-center gap-2 mb-4">
                <div class="w-8 h-8 rounded-full bg-amber-400 flex items-center justify-center text-stone-900 font-bold">
                    +
                </div>
                <h3 class="text-xl font-bold text-stone-900 font-sans">Tambah Kutipan Baru</h3>
            </div>
            
            <form onsubmit="handleAddNewQuote(event)" class="space-y-4">
                <div>
                    <label class="block text-xs font-bold font-mono uppercase text-stone-600 mb-1">Isi Kutipan / Quotes</label>
                    <textarea id="input-quote" required rows="3" placeholder="Tuliskan kata mutiara atau kutipan inspiratif..." class="w-full p-3 rounded-xl border border-stone-300 text-sm focus:outline-none focus:ring-2 focus:ring-stone-900"></textarea>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold font-mono uppercase text-stone-600 mb-1">Nama Penulis / Tokoh</label>
                        <input type="text" id="input-author" required placeholder="Contoh: B.J. Habibie" class="w-full p-2.5 rounded-xl border border-stone-300 text-sm focus:outline-none focus:ring-2 focus:ring-stone-900">
                    </div>
                    <div>
                        <label class="block text-xs font-bold font-mono uppercase text-stone-600 mb-1">Kategori / Topik</label>
                        <input type="text" id="input-tag" required placeholder="Contoh: Cinta & Cita-cita" class="w-full p-2.5 rounded-xl border border-stone-300 text-sm focus:outline-none focus:ring-2 focus:ring-stone-900">
                    </div>
                </div>
                <div class="flex justify-end gap-2 pt-2">
                    <button type="button" onclick="closeAddQuoteModal()" class="px-4 py-2 rounded-full text-xs font-semibold text-stone-600 hover:bg-stone-100">Batal</button>
                    <button type="submit" class="px-5 py-2 rounded-full bg-stone-900 hover:bg-black text-white text-xs font-bold shadow-md">Simpan & Terbitkan</button>
                </div>
            </form>
        </div>
    </div>


    <!-- Toast Notification -->
    <div id="toast" class="fixed bottom-6 right-6 z-50 bg-stone-900 text-white text-xs font-sans px-4 py-3 rounded-2xl shadow-xl border border-stone-700 flex items-center gap-2 transform translate-y-24 opacity-0 transition-all duration-300 pointer-events-none">
        <i data-lucide="check-circle" class="w-4 h-4 text-emerald-400"></i>
        <span id="toast-text">Berhasil disalin!</span>
    </div>


    <!-- Data Store injected from Laravel -->
    <script>
        const initialFolderQuotes = @json($folderQuotes);
        const initialBooks = @json($books);
        const initialPhysicsQuotes = @json($physicsQuotes);

        let folderQuotes = [...initialFolderQuotes];
        let books = [...initialBooks];
        let physicsQuotes = [...initialPhysicsQuotes];

        let currentFolderIndex = 0;
        let isAudioEnabled = true;
        let audioCtx = null;

        // Initialize Lucide Icons
        document.addEventListener('DOMContentLoaded', () => {
            lucide.createIcons();
            initFolderDeckPositions();
            initPhysicsEngine();
            setupDeviceOrientation();
        });

        // ===================================================================
        // 1. SOUND EFFECTS (Web Audio API Synthesizer - 100% Offline Reliable)
        // ===================================================================
        function getAudioContext() {
            if (!audioCtx) {
                audioCtx = new (window.AudioContext || window.webkitAudioContext)();
            }
            if (audioCtx.state === 'suspended') {
                audioCtx.resume();
            }
            return audioCtx;
        }

        function playPaperSound() {
            if (!isAudioEnabled) return;
            try {
                const ctx = getAudioContext();
                const osc = ctx.createOscillator();
                const gain = ctx.createGain();
                osc.type = 'triangle';
                osc.frequency.setValueAtTime(180, ctx.currentTime);
                osc.frequency.exponentialRampToValueAtTime(80, ctx.currentTime + 0.15);
                gain.gain.setValueAtTime(0.12, ctx.currentTime);
                gain.gain.exponentialRampToValueAtTime(0.01, ctx.currentTime + 0.15);
                osc.connect(gain);
                gain.connect(ctx.destination);
                osc.start();
                osc.stop(ctx.currentTime + 0.15);
            } catch(e){}
        }

        function playSwooshSound() {
            if (!isAudioEnabled) return;
            try {
                const ctx = getAudioContext();
                const osc = ctx.createOscillator();
                const gain = ctx.createGain();
                osc.type = 'sine';
                osc.frequency.setValueAtTime(320, ctx.currentTime);
                osc.frequency.exponentialRampToValueAtTime(140, ctx.currentTime + 0.2);
                gain.gain.setValueAtTime(0.15, ctx.currentTime);
                gain.gain.exponentialRampToValueAtTime(0.01, ctx.currentTime + 0.2);
                osc.connect(gain);
                gain.connect(ctx.destination);
                osc.start();
                osc.stop(ctx.currentTime + 0.2);
            } catch(e){}
        }

        function playPopSound() {
            if (!isAudioEnabled) return;
            try {
                const ctx = getAudioContext();
                const osc = ctx.createOscillator();
                const gain = ctx.createGain();
                osc.type = 'sine';
                osc.frequency.setValueAtTime(520, ctx.currentTime);
                osc.frequency.exponentialRampToValueAtTime(260, ctx.currentTime + 0.08);
                gain.gain.setValueAtTime(0.18, ctx.currentTime);
                gain.gain.exponentialRampToValueAtTime(0.01, ctx.currentTime + 0.08);
                osc.connect(gain);
                gain.connect(ctx.destination);
                osc.start();
                osc.stop(ctx.currentTime + 0.08);
            } catch(e){}
        }

        function toggleAudioSFX() {
            isAudioEnabled = !isAudioEnabled;
            const icon = document.getElementById('sound-icon');
            if (isAudioEnabled) {
                icon.setAttribute('data-lucide', 'volume-2');
                showToast('Efek suara aktif 🔊');
                playPopSound();
            } else {
                icon.setAttribute('data-lucide', 'volume-x');
                showToast('Efek suara dibisukan 🔇');
            }
            lucide.createIcons();
        }


        // ===================================================================
        // 2. NAVIGATION & TAB SWITCHER
        // ===================================================================
        function switchMode(mode) {
            playPaperSound();
            // Hide all sections
            document.querySelectorAll('.mode-section').forEach(sec => sec.classList.add('hidden'));
            
            // Show chosen section
            const target = document.getElementById('section-' + mode);
            if (target) {
                target.classList.remove('hidden');
            }

            // Update Desktop Nav styles
            const navIds = ['folder', 'bookshelf', 'physics', 'explorer'];
            navIds.forEach(id => {
                const btn = document.getElementById('nav-' + id);
                const mobBtn = document.getElementById('mob-' + id);
                if (id === mode) {
                    if (btn) {
                        btn.className = "px-4 py-1.5 rounded-full transition-all duration-200 bg-white text-stone-900 shadow-sm flex items-center gap-1.5 font-bold";
                    }
                    if (mobBtn) {
                        mobBtn.className = "flex-1 py-1 rounded-full bg-white text-stone-900 text-center font-bold";
                    }
                } else {
                    if (btn) {
                        btn.className = "px-4 py-1.5 rounded-full transition-all duration-200 hover:text-stone-900 hover:bg-white/60 flex items-center gap-1.5 text-stone-700";
                    }
                    if (mobBtn) {
                        mobBtn.className = "flex-1 py-1 rounded-full text-center text-stone-600";
                    }
                }
            });

            if (mode === 'physics') {
                setTimeout(() => {
                    if (typeof resizePhysicsCanvas === 'function') resizePhysicsCanvas();
                }, 100);
            }
        }


        // ===================================================================
        // 3. FOLDER SWIPE UP ENGINE (BrandAppart / Photo 1 & 2)
        // ===================================================================
        function initFolderDeckPositions() {
            const cards = document.querySelectorAll('.folder-card');
            cards.forEach((card, index) => {
                const diff = (index - currentFolderIndex + cards.length) % cards.length;
                if (diff === 0) {
                    // Front Card
                    card.style.transform = `translateY(0px) scale(1) rotate(0deg)`;
                    card.style.opacity = '1';
                    card.style.zIndex = '20';
                    card.style.filter = 'blur(0px)';
                    card.style.pointerEvents = 'auto';
                } else if (diff === 1) {
                    // Second card tucked behind
                    card.style.transform = `translateY(24px) scale(0.95) rotate(-1deg)`;
                    card.style.opacity = '0.92';
                    card.style.zIndex = '15';
                    card.style.filter = 'blur(0.4px)';
                    card.style.pointerEvents = 'none';
                } else if (diff === 2) {
                    // Third card
                    card.style.transform = `translateY(44px) scale(0.90) rotate(1.5deg)`;
                    card.style.opacity = '0.80';
                    card.style.zIndex = '10';
                    card.style.filter = 'blur(1px)';
                    card.style.pointerEvents = 'none';
                } else {
                    // Hidden back cards
                    card.style.transform = `translateY(60px) scale(0.85) rotate(0deg)`;
                    card.style.opacity = '0';
                    card.style.zIndex = '5';
                    card.style.pointerEvents = 'none';
                }
            });

            // Update Indicator
            const ind = document.getElementById('folder-indicator');
            if (ind) {
                ind.innerText = `${currentFolderIndex + 1} / ${cards.length}`;
            }

            attachDragToFrontCard();
        }

        function nextFolderCard() {
            playSwooshSound();
            const cards = document.querySelectorAll('.folder-card');
            if (!cards.length) return;

            const currentCard = document.getElementById(`card-${currentFolderIndex}`);
            if (currentCard) {
                // Animate swipe up
                currentCard.style.transform = 'translateY(-130%) rotate(-6deg) scale(0.9)';
                currentCard.style.opacity = '0';
            }

            setTimeout(() => {
                currentFolderIndex = (currentFolderIndex + 1) % cards.length;
                initFolderDeckPositions();
            }, 250);
        }

        function prevFolderCard() {
            playSwooshSound();
            const cards = document.querySelectorAll('.folder-card');
            if (!cards.length) return;

            currentFolderIndex = (currentFolderIndex - 1 + cards.length) % cards.length;
            const newFront = document.getElementById(`card-${currentFolderIndex}`);
            if (newFront) {
                newFront.style.transform = 'translateY(-120%) scale(0.95)';
                newFront.style.opacity = '0';
            }

            setTimeout(() => {
                initFolderDeckPositions();
            }, 50);
        }

        // Drag / Swipe Gesture for Front Folder Card
        function attachDragToFrontCard() {
            const frontCard = document.getElementById(`card-${currentFolderIndex}`);
            if (!frontCard) return;

            let startY = 0;
            let currentY = 0;
            let isDragging = false;

            const onStart = (e) => {
                isDragging = true;
                startY = e.type.includes('touch') ? e.touches[0].clientY : e.clientY;
                frontCard.style.transition = 'none';
            };

            const onMove = (e) => {
                if (!isDragging) return;
                currentY = e.type.includes('touch') ? e.touches[0].clientY : e.clientY;
                const deltaY = currentY - startY;

                if (deltaY < 0) { // dragging upwards
                    const rotate = deltaY * 0.05;
                    frontCard.style.transform = `translateY(${deltaY}px) rotate(${rotate}deg)`;
                }
            };

            const onEnd = (e) => {
                if (!isDragging) return;
                isDragging = false;
                frontCard.style.transition = 'transform 0.45s cubic-bezier(0.2, 0.8, 0.2, 1), opacity 0.4s ease';
                const deltaY = currentY - startY;

                if (deltaY < -90) {
                    // Swiped up successfully!
                    nextFolderCard();
                } else {
                    // Snap back
                    initFolderDeckPositions();
                }
            };

            frontCard.onmousedown = onStart;
            window.onmousemove = onMove;
            window.onmouseup = onEnd;

            frontCard.ontouchstart = onStart;
            window.ontouchmove = onMove;
            window.ontouchend = onEnd;
        }

        function copyCurrentFolderQuote() {
            const current = folderQuotes[currentFolderIndex];
            if (current) {
                copyText(`"${current.quote}" — ${current.author}`);
                celebrateQuote();
            }
        }

        function speakCurrentFolderQuote() {
            const current = folderQuotes[currentFolderIndex];
            if (current) {
                speakQuote(current.quote, current.author);
            }
        }

        function openFolderDetail(idx) {
            const folder = folderQuotes[idx];
            if (!folder) return;
            // Pop open detail in book modal style
            document.getElementById('modal-book-title').innerText = folder.title;
            document.getElementById('modal-book-subtitle').innerText = folder.case_study || 'Koleksi Pemikiran Esensial';
            document.getElementById('modal-book-genre').innerText = folder.category || folder.tag;
            document.getElementById('modal-book-author').innerText = folder.author;
            document.getElementById('modal-book-meta').innerText = `${folder.year} • ${folder.role}`;
            document.getElementById('modal-author-avatar').innerText = folder.author.charAt(0);
            document.getElementById('modal-author-bio').innerText = `${folder.author} adalah ${folder.role}. Dikenal lewat pemikiran yang mendobrak kebiasaan dan membuka wawasan baru.`;
            document.getElementById('modal-book-quote').innerText = folder.quote;

            const modal = document.getElementById('book-modal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            playPopSound();
        }

        function showFolderToast(msg) {
            showToast(msg);
        }


        // ===================================================================
        // 4. 3D INTERACTIVE BOOKSHELF ENGINE (JZA Studio / Photo 3 & 4)
        // ===================================================================
        let activeBookIndex = null;

        function open3DBook(index) {
            playPaperSound();
            activeBookIndex = index;
            const book = books[index];
            if (!book) return;

            document.getElementById('modal-book-title').innerText = book.title;
            document.getElementById('modal-book-subtitle').innerText = book.subtitle;
            document.getElementById('modal-book-genre').innerText = book.genre;
            document.getElementById('modal-book-author').innerText = book.author;
            document.getElementById('modal-book-meta').innerText = `${book.year} • ${book.pages}`;
            document.getElementById('modal-author-avatar').innerText = book.author.charAt(0);
            document.getElementById('modal-author-bio').innerText = book.author_bio;
            document.getElementById('modal-book-quote').innerText = book.quote;

            const modal = document.getElementById('book-modal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            celebrateSmall();
        }

        function close3DBook() {
            playPaperSound();
            const modal = document.getElementById('book-modal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function copyModalQuote() {
            const text = document.getElementById('modal-book-quote').innerText;
            const author = document.getElementById('modal-book-author').innerText;
            copyText(`"${text}" — ${author}`);
            celebrateQuote();
        }

        function speakModalQuote() {
            const text = document.getElementById('modal-book-quote').innerText;
            const author = document.getElementById('modal-book-author').innerText;
            speakQuote(text, author);
        }


        // ===================================================================
        // 5. PHYSICS & GYROSCOPE ENGINE (Xhulia / Photo 5 Style Matter.js)
        // ===================================================================
        let engine, world, render, runner;
        let pillBodies = [];
        let mouseConstraint;
        let gravityInverted = false;

        function initPhysicsEngine() {
            const container = document.getElementById('physics-canvas-container');
            if (!container) return;

            const width = container.clientWidth || 800;
            const height = container.clientHeight || 400;

            const { Engine, Render, Runner, Bodies, Composite, Mouse, MouseConstraint, Events } = Matter;

            engine = Engine.create();
            world = engine.world;
            world.gravity.y = 0.8;
            world.gravity.x = 0;

            render = Render.create({
                element: container,
                engine: engine,
                options: {
                    width: width,
                    height: height,
                    wireframes: false,
                    background: 'transparent',
                    pixelRatio: window.devicePixelRatio || 1
                }
            });

            Render.run(render);
            runner = Runner.create();
            Runner.run(runner, engine);

            // Boundaries (Floor, Walls, Ceiling)
            createPhysicsBoundaries(width, height);

            // Spawn Initial Pills
            physicsQuotes.forEach((q, idx) => {
                const x = 80 + (idx % 6) * 110 + Math.random() * 20;
                const y = 50 + Math.floor(idx / 6) * 60 + Math.random() * 20;
                createPillBody(x, y, q);
            });

            // Mouse Interaction (Drag & Fling)
            const mouse = Mouse.create(render.canvas);
            mouseConstraint = MouseConstraint.create(engine, {
                mouse: mouse,
                constraint: {
                    stiffness: 0.2,
                    render: { visible: false }
                }
            });
            Composite.add(world, mouseConstraint);
            render.mouse = mouse;

            // Click Pill Handler
            Events.on(mouseConstraint, 'startdrag', (evt) => {
                playPopSound();
            });

            Events.on(mouseConstraint, 'mousedown', (evt) => {
                const mousePosition = evt.mouse.position;
                const clicked = Matter.Query.point(pillBodies.map(p => p.body), mousePosition);
                if (clicked.length > 0) {
                    const pillData = clicked[0].quoteData;
                    if (pillData) {
                        openPillModal(pillData);
                    }
                }
            });

            // Custom Renderer for Beautiful Pill Badges (Rounded rectangles with text)
            Events.on(render, 'afterRender', () => {
                const ctx = render.context;
                pillBodies.forEach(p => {
                    const { x, y } = p.body.position;
                    const angle = p.body.angle;
                    const data = p.quoteData;

                    ctx.save();
                    ctx.translate(x, y);
                    ctx.rotate(angle);

                    // Pill Shape
                    const pw = p.width;
                    const ph = p.height;
                    const radius = ph / 2;

                    ctx.beginPath();
                    ctx.roundRect(-pw/2, -ph/2, pw, ph, radius);
                    ctx.fillStyle = data.bg || '#FACC15';
                    ctx.shadowColor = 'rgba(0, 0, 0, 0.15)';
                    ctx.shadowBlur = 6;
                    ctx.shadowOffsetY = 3;
                    ctx.fill();

                    // Pill Border
                    ctx.lineWidth = 1.5;
                    ctx.strokeStyle = 'rgba(0,0,0,0.1)';
                    ctx.stroke();

                    // Text inside Pill
                    ctx.shadowColor = 'transparent';
                    ctx.fillStyle = data.color || '#000000';
                    ctx.font = 'bold 12px "Plus Jakarta Sans", sans-serif';
                    ctx.textAlign = 'center';
                    ctx.textBaseline = 'middle';
                    ctx.fillText(data.text, 0, 1);

                    ctx.restore();
                });
            });

            window.addEventListener('resize', resizePhysicsCanvas);
        }

        function createPhysicsBoundaries(width, height) {
            const { Bodies, Composite } = Matter;
            const wallThickness = 60;
            const walls = [
                Bodies.rectangle(width / 2, height + wallThickness/2 - 2, width * 2, wallThickness, { isStatic: true, render: { visible: false } }), // floor
                Bodies.rectangle(-wallThickness/2, height / 2, wallThickness, height * 2, { isStatic: true, render: { visible: false } }), // left
                Bodies.rectangle(width + wallThickness/2, height / 2, wallThickness, height * 2, { isStatic: true, render: { visible: false } }), // right
                Bodies.rectangle(width / 2, -wallThickness/2, width * 2, wallThickness, { isStatic: true, render: { visible: false } }) // top
            ];
            Composite.add(world, walls);
        }

        function createPillBody(x, y, quoteData) {
            const { Bodies, Composite } = Matter;
            // Calculate width based on text length
            const textLen = quoteData.text.length;
            const width = Math.max(110, textLen * 8.5 + 24);
            const height = 36;

            const body = Bodies.rectangle(x, y, width, height, {
                chamfer: { radius: height / 2 },
                restitution: 0.75, // bounciness
                friction: 0.1,
                frictionAir: 0.015,
                angle: (Math.random() - 0.5) * 0.4,
                render: { visible: false }
            });

            body.quoteData = quoteData;
            pillBodies.push({ body, width, height, quoteData });
            Composite.add(world, body);
            return body;
        }

        function resizePhysicsCanvas() {
            if (!render || !render.canvas) return;
            const container = document.getElementById('physics-canvas-container');
            if (!container) return;
            const w = container.clientWidth;
            const h = container.clientHeight;
            render.canvas.width = w;
            render.canvas.height = h;
            render.options.width = w;
            render.options.height = h;
        }

        // Gyroscope & Laptop/Device Motion Integration
        function setupDeviceOrientation() {
            // Standard Gyroscope / Accelerometer
            window.addEventListener('deviceorientation', (event) => {
                if (!world) return;
                const gamma = event.gamma; // tilt left/right [-90, 90]
                const beta = event.beta;   // tilt front/back [-180, 180]

                if (gamma !== null && beta !== null) {
                    const gx = Math.min(Math.max(gamma / 45, -1.2), 1.2);
                    const gy = Math.min(Math.max(beta / 45, -1.2), 1.2);
                    world.gravity.x = gx;
                    world.gravity.y = gy;

                    document.getElementById('gyro-status-text').innerText = `Gyro Aktif: Tilt X(${gx.toFixed(1)}) Y(${gy.toFixed(1)})`;
                }
            });

            // Desktop Mouse Motion Tilt Fallback
            window.addEventListener('mousemove', (e) => {
                if (!world) return;
                // Gentle tilt response when moving mouse on desktop
                const cx = window.innerWidth / 2;
                const tiltX = (e.clientX - cx) / cx * 0.3;
                if (!gravityInverted) {
                    world.gravity.x = tiltX;
                }
            });
        }

        function requestGyroPermission() {
            if (typeof DeviceOrientationEvent !== 'undefined' && typeof DeviceOrientationEvent.requestPermission === 'function') {
                DeviceOrientationEvent.requestPermission()
                    .then(permissionState => {
                        if (permissionState === 'granted') {
                            showToast('Sensor Gyroscope diizinkan! Miringkan perangkat Anda.');
                        } else {
                            showToast('Izin sensor ditolak.');
                        }
                    })
                    .catch(console.error);
            } else {
                showToast('Sensor Gyro & Gerakan Mouse aktif otomatis!');
            }
        }

        function shakePhysicsWorld() {
            playPopSound();
            celebrateSmall();
            pillBodies.forEach(p => {
                const fx = (Math.random() - 0.5) * 0.08;
                const fy = -0.05 - Math.random() * 0.08;
                Matter.Body.applyForce(p.body, p.body.position, { x: fx, y: fy });
            });
            showToast('Gravitasi dikocok! ⚡');
        }

        function toggleInvertGravity() {
            playPopSound();
            if (!world) return;
            gravityInverted = !gravityInverted;
            world.gravity.y = gravityInverted ? -0.8 : 0.8;
            document.getElementById('btn-grav').innerText = gravityInverted ? 'Gravitasi Normal' : 'Balik Gravitasi';
            showToast(gravityInverted ? 'Gravitasi terbalik! Pil melayang ke atas 🎈' : 'Gravitasi normal ⬇️');
        }

        function spawnRandomPill() {
            playPopSound();
            const samples = [
                { text: 'Stay Curious 🔍', author: 'Albert Einstein', bg: '#FFD43B', color: '#4A3B00', full: 'Jangan pernah kehilangan rasa ingin tahu yang suci.' },
                { text: 'Be Brave 🦁', author: 'Brené Brown', bg: '#FFA8A8', color: '#5C0909', full: 'Keberanian dimulai dengan menunjukkan diri dan membiarkan diri kita terlihat.' },
                { text: 'Ship It! 🚢', author: 'Seth Godin', bg: '#74C0FC', color: '#0A2D4D', full: 'Selesaikan karyamu dan luncurkan ke dunia sekarang juga.' },
                { text: 'Keep Going 🏃', author: 'Winston Churchill', bg: '#63E6BE', color: '#083B2B', full: 'Jika Anda sedang melewati neraka, teruslah berjalan.' },
            ];
            const pick = samples[Math.floor(Math.random() * samples.length)];
            createPillBody(200 + Math.random() * 200, 40, pick);
            showToast(`Pil baru "${pick.text}" ditambahkan!`);
        }

        let activePillData = null;
        function openPillModal(data) {
            activePillData = data;
            document.getElementById('pill-modal-short').innerText = data.text;
            document.getElementById('pill-modal-icon').innerText = data.icon || '✨';
            document.getElementById('pill-modal-full').innerText = `"${data.full || data.text}"`;
            document.getElementById('pill-modal-author').innerText = data.author || 'Anonim';
            
            const tag = document.getElementById('pill-modal-tag');
            tag.style.backgroundColor = data.bg || '#FACC15';
            tag.style.color = data.color || '#000000';

            const modal = document.getElementById('pill-modal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            playPopSound();
        }

        function closePillModal() {
            const modal = document.getElementById('pill-modal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function copyPillModalQuote() {
            if (activePillData) {
                copyText(`"${activePillData.full || activePillData.text}" — ${activePillData.author}`);
                celebrateQuote();
            }
        }


        // ===================================================================
        // 6. EXPLORER / SEARCH FILTER
        // ===================================================================
        function filterQuotesList() {
            const query = document.getElementById('search-input').value.toLowerCase();
            const items = document.querySelectorAll('.quote-card-item');
            items.forEach(item => {
                const text = item.innerText.toLowerCase();
                if (text.includes(query)) {
                    item.style.display = 'flex';
                } else {
                    item.style.display = 'none';
                }
            });
        }


        // ===================================================================
        // 7. ADD NEW QUOTE REACTIVELY
        // ===================================================================
        function openAddQuoteModal() {
            const m = document.getElementById('add-modal');
            m.classList.remove('hidden');
            m.classList.add('flex');
        }

        function closeAddQuoteModal() {
            const m = document.getElementById('add-modal');
            m.classList.add('hidden');
            m.classList.remove('flex');
        }

        function handleAddNewQuote(e) {
            e.preventDefault();
            const quote = document.getElementById('input-quote').value.trim();
            const author = document.getElementById('input-author').value.trim();
            const tag = document.getElementById('input-tag').value.trim();

            if (!quote || !author) return;

            // 1. Add to Folder Quotes
            const newFolder = {
                id: 'folder-' + (folderQuotes.length + 1),
                index: '0' + (folderQuotes.length + 1),
                category: tag,
                title: quote.substring(0, 45) + '...',
                quote: quote,
                author: author,
                role: 'Penulis Kontributor',
                color: '#1E293B',
                tag: tag,
                year: '2026',
                case_study: 'Koleksi Komunitas'
            };
            folderQuotes.unshift(newFolder);

            // 2. Add to Physics Pills
            const newPill = {
                text: `${author.split(' ')[0]}: ${tag} ✨`,
                author: author,
                bg: '#A7F3D0',
                color: '#064E3B',
                icon: '💡',
                full: quote
            };
            if (world) {
                createPillBody(300, 30, newPill);
            }

            // Close & celebrate
            closeAddQuoteModal();
            celebrateQuote();
            showToast('Kutipan berhasil ditambahkan ke CaQuotes! 🎉');
            e.target.reset();
            
            // Re-render deck
            setTimeout(() => {
                location.reload();
            }, 1200);
        }

        function triggerRandomInspire() {
            playPopSound();
            celebrateQuote();
            const all = [...folderQuotes, ...books];
            const pick = all[Math.floor(Math.random() * all.length)];
            openFolderDetail(folderQuotes.indexOf(pick) >= 0 ? folderQuotes.indexOf(pick) : 0);
            showToast(`Kutipan Acak: ${pick.author} ✨`);
        }


        // ===================================================================
        // 8. UTILITIES (Copy, Toast, Confetti, Text-to-Speech)
        // ===================================================================
        function copyText(text) {
            navigator.clipboard.writeText(text).then(() => {
                showToast('Kutipan berhasil disalin ke clipboard! 📋');
                playPopSound();
            }).catch(() => {
                showToast('Kutipan disalin!');
            });
        }

        function showToast(msg) {
            const toast = document.getElementById('toast');
            document.getElementById('toast-text').innerText = msg;
            toast.classList.remove('translate-y-24', 'opacity-0');
            setTimeout(() => {
                toast.classList.add('translate-y-24', 'opacity-0');
            }, 3000);
        }

        function celebrateQuote() {
            if (typeof confetti === 'function') {
                confetti({
                    particleCount: 45,
                    spread: 60,
                    origin: { y: 0.8 }
                });
            }
        }

        function celebrateSmall() {
            if (typeof confetti === 'function') {
                confetti({
                    particleCount: 20,
                    spread: 40,
                    origin: { y: 0.7 }
                });
            }
        }

        function speakQuote(text, author) {
            if ('speechSynthesis' in window) {
                window.speechSynthesis.cancel();
                const utterance = new SpeechSynthesisUtterance(`${text}. Oleh ${author}`);
                utterance.lang = 'id-ID';
                utterance.rate = 0.95;
                window.speechSynthesis.speak(utterance);
                showToast('Memutar suara kutipan 🎙️');
            } else {
                showToast('Browser tidak mendukung audio speech');
            }
        }

        // Keyboard Shortcuts (ArrowUp / ArrowDown for Folders, Esc for Modals)
        window.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowDown' || e.key === 'ArrowRight') {
                nextFolderCard();
            } else if (e.key === 'ArrowUp' || e.key === 'ArrowLeft') {
                prevFolderCard();
            } else if (e.key === 'Escape') {
                close3DBook();
                closePillModal();
                closeAddQuoteModal();
            }
        });
    </script>
</body>
</html>
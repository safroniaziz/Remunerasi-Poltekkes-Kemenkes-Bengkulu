
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Remunerasi Poltekkes Kemenkes Bengkulu</title>
    <link rel="shortcut icon" href="{{ asset('assets/img/logo.svg') }}">
    <!-- stylesheets tailwind -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('assets/frontend/style.css') }}">

    <style>
        [x-cloak] { display: none !important; }
        
        .nav-scroll,
        .list-menu-scroll {
            background-color: rgba(255, 255, 255, 0.95) !important;
            border-bottom: 1px solid rgba(226, 232, 240, 0.8) !important;
        }
        
        @media (min-width: 1024px) {
            .list-menu-scroll {
                background-color: transparent !important;
            }
        }
    </style>

    @stack('styleshome')
</head>

<body class="antialiased leading-normal tracking-wide 2xl:text-xl font-sans bg-slate-50 text-slate-800"
    x-data="{ switcher: translationSwitcher() }">
    <div id="top"></div>

    <!-- Preloader Start -->
    <div x-data="{ loading: true }"
         x-init="window.addEventListener('load', () => setTimeout(() => loading = false, 350))"
         x-show="loading"
         x-transition:leave="transition ease-in duration-500"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0 pointer-events-none"
         class="fixed inset-0 z-[9999] flex flex-col items-center justify-center bg-white select-none">
        <div class="relative flex items-center justify-center">
            <!-- Outer Glowing Spin Ring -->
            <div class="h-24 w-24 rounded-full border-4 border-navy/10 border-t-gold animate-spin"></div>
            <!-- Inner Pulsing Logo -->
            <img src="{{ asset('assets/img/logo.svg') }}" alt="Logo" class="absolute h-12 w-12 animate-pulse">
        </div>
    </div>
    <!-- Preloader End -->


    <!-- navbar  -->
    <nav x-data="{isOpen: false }" class="fixed top-0 z-50 w-full">
        <div id="navbar" class="px-4 sm:px-6 lg:px-10 py-3 mx-auto duration-300 bg-white/80 backdrop-blur-md border-b border-slate-100 shadow-sm">
            <div class="max-w-7xl mx-auto lg:flex lg:items-center lg:justify-between">
                <div class="flex items-center justify-between">
                    <!-- logo -->
                    <a href="/" class="flex items-center">
                        <img src="{{ asset('assets/img/logo.svg') }}" alt="Logo Poltekkes" class="h-12 w-auto">
                        <div class="ml-3 leading-tight">
                            <strong class="text-navy tracking-wide block text-base font-heading">SISTEM REMUNERASI</strong>
                            <span class="text-[10px] text-gold-dark font-bold tracking-wide font-sans block">POLTEKKES KEMENKES BENGKULU</span>
                        </div>
                    </a>
                    <!-- Mobile menu button -->
                    <div class="flex lg:hidden">
                        <button x-cloak @click="isOpen = !isOpen" type="button"
                            class="text-slate-600 hover:text-navy focus:outline-none"
                            aria-label="toggle menu">
                            <svg x-show="!isOpen" xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 8h16M4 16h16" />
                            </svg>
                            <svg x-show="isOpen" xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
                <!-- Mobile Menu open: "block", Menu closed: "hidden" -->
                <div x-cloak :class="[isOpen ? 'translate-x-0 opacity-100 ' : 'opacity-0 -translate-x-full']" class="absolute inset-x-0 z-20 w-full px-6 py-4 transition-all duration-300 ease-in-out bg-white border-b border-slate-100 lg:border-none md:bg-none menu-navbar lg:mt-0 lg:p-0 lg:top-0 lg:relative lg:bg-transparent lg:w-auto lg:opacity-100 lg:translate-x-0 lg:flex lg:items-center" id="list-menu">
                    <div class="flex flex-col -mx-6 lg:flex-row lg:items-center lg:mx-0 lg:gap-2">
                        <a href="#home" class="px-4 py-2 mx-2 mt-2 text-slate-600 hover:text-navy transition-colors active-menu duration-300 rounded-lg lg:mt-0 font-medium">Beranda</a>
                        <a href="#fitur" class="px-4 py-2 mx-2 mt-2 text-slate-600 hover:text-navy transition-colors duration-300 rounded-lg lg:mt-0 font-medium">Tentang</a>
                        <a href="#simulator" class="px-4 py-2 mx-2 mt-2 text-slate-600 hover:text-navy transition-colors duration-300 rounded-lg lg:mt-0 font-medium">Simulasi</a>
                        <a href="#pengumuman" class="px-4 py-2 mx-2 mt-2 text-slate-600 hover:text-navy transition-colors duration-300 rounded-lg lg:mt-0 font-medium font-medium">Pengumuman</a>
                        <a href="#faq" class="px-4 py-2 mx-2 mt-2 text-slate-600 hover:text-navy transition-colors duration-300 rounded-lg lg:mt-0 font-medium">FAQ</a>
                        <a href="{{ route('login') }}" class="inline-flex items-center justify-center gap-2 px-6 py-2 mx-2 mt-2 lg:mt-0 lg:ml-2 text-white font-bold transition-all duration-300 rounded-xl bg-navy hover:bg-navy-light shadow-sm text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14M3 12a9 9 0 1118 0 9 9 0 01-18 0z"/></svg>
                            Login
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <!-- end navbar -->

    <!-- hero -->
    <section id="home" class="relative overflow-hidden bg-gradient-to-b from-slate-50 via-white to-slate-50 font-sans pt-36 pb-20 border-b border-slate-100">
        <!-- subtle dotted grid background pattern -->
        <div class="pointer-events-none absolute inset-0 opacity-[0.05]" style="background-image: radial-gradient(#152042 1px, transparent 1px); background-size: 20px 20px;"></div>
        <!-- elegant ambient glows -->
        <div class="pointer-events-none absolute top-1/4 -right-48 h-[450px] w-[450px] rounded-full bg-gold/10 blur-3xl"></div>
        <div class="pointer-events-none absolute -left-48 bottom-10 h-[450px] w-[450px] rounded-full bg-navy/5 blur-3xl"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid items-center gap-10 lg:grid-cols-2 pb-16">
                <div class="text-center lg:text-left" data-aos="fade-right">
                    <span class="inline-flex items-center gap-2 px-3 py-1.5 mb-6 text-xs font-bold tracking-wider uppercase rounded-full bg-gold/10 text-gold-dark border border-gold/20">
                        <span class="h-2 w-2 rounded-full bg-gold animate-pulse"></span>
                        Sistem Informasi Remunerasi
                    </span>
                    <h1 class="text-navy text-4xl md:text-5xl lg:text-6xl font-extrabold mb-6 leading-[1.15] font-heading tracking-tight">
                        Kelola Remunerasi Kampus Lebih <span class="text-transparent bg-clip-text bg-gradient-to-r from-navy to-navy-light">Transparan &amp; Akurat</span>
                    </h1>
                    <p class="text-slate-600 text-base md:text-lg leading-relaxed max-w-xl mb-8 font-sans mx-auto lg:mx-0">
                        Platform resmi pengelolaan remunerasi tenaga pendidik dan kependidikan <span class="text-navy font-semibold font-heading">Poltekkes Kemenkes Bengkulu</span>. Perhitungan otomatis berbasis rubrik kinerja, akurat, aman, dan dapat diakses kapan saja.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                        @if(auth()->check())
                            <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-navy hover:bg-navy-light text-white font-bold text-sm transition-all duration-300 rounded-2xl shadow-lg shadow-navy/20 hover:scale-[1.02] active:scale-[0.98] focus:ring-4 focus:ring-navy/15 focus:outline-none">
                                Ke Dashboard Saya
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-navy hover:bg-navy-light text-white font-bold text-sm transition-all duration-300 rounded-2xl shadow-lg shadow-navy/20 hover:scale-[1.02] active:scale-[0.98] focus:ring-4 focus:ring-navy/15 focus:outline-none">
                                Masuk ke Sistem
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                            </a>
                        @endif
                        <a href="#pengumuman" class="inline-flex items-center justify-center gap-2 px-8 py-4 border border-slate-200 bg-white text-slate-700 hover:bg-slate-50 font-bold text-sm transition-all duration-300 rounded-2xl hover:scale-[1.02] active:scale-[0.98] shadow-sm">
                            Lihat Pengumuman
                        </a>
                    </div>
                </div>
                
                <div class="flex items-center justify-center" data-aos="fade-left">
                    @if(auth()->check())
                        <!-- Authenticated Dashboard Preview Container -->
                        <div class="relative w-full max-w-lg p-6 bg-white border border-slate-100 rounded-3xl shadow-2xl shadow-navy/10 transform lg:rotate-1 hover:rotate-0 transition-transform duration-500 font-sans select-none">
                            
                            <!-- Header Mock Card -->
                            <div class="flex items-center justify-between pb-4 mb-4 border-b border-slate-100">
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 rounded-full bg-navy/10 flex items-center justify-center text-navy font-extrabold uppercase">{{ substr(auth()->user()->nama_user ?? 'US', 0, 2) }}</div>
                                    <div>
                                        <h4 class="text-sm font-bold text-navy font-heading">{{ auth()->user()->nama_user }}</h4>
                                        <span class="text-xs text-slate-400">NIP. {{ auth()->user()->pegawai_nip ?? '-' }}</span>
                                    </div>
                                </div>
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-semibold text-emerald-700 bg-emerald-50 rounded-full">
                                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                    Terhubung
                                </span>
                            </div>

                            <!-- Statistics Grid Mock -->
                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div class="bg-slate-50/60 p-4 rounded-2xl border border-slate-100">
                                    <span class="text-xs text-slate-400 block mb-1">Total Kinerja (SKS)</span>
                                    <span class="text-lg font-bold text-navy font-heading">16.5 / 12 SKS</span>
                                    <div class="w-full bg-slate-200 h-1.5 rounded-full mt-2 overflow-hidden">
                                        <div class="bg-gold h-full rounded-full" style="width: 100%"></div>
                                    </div>
                                </div>
                                <div class="bg-slate-50/60 p-4 rounded-2xl border border-slate-100">
                                    <span class="text-xs text-slate-400 block mb-1">Status Verifikasi</span>
                                    <span class="text-lg font-bold text-emerald-600 font-heading">Lolos Rubrik</span>
                                    <div class="w-full bg-slate-200 h-1.5 rounded-full mt-2 overflow-hidden">
                                        <div class="bg-emerald-500 h-full rounded-full" style="width: 100%"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Estimated Remuneration Mock Card -->
                            <div class="bg-navy rounded-2xl p-5 text-white mb-4 relative overflow-hidden">
                                <div class="pointer-events-none absolute -right-10 -bottom-10 h-32 w-32 rounded-full bg-gold/10 blur-xl"></div>
                                <span class="text-xs text-slate-300 block mb-1">Estimasi Remunerasi Terhitung</span>
                                <div class="flex items-baseline gap-2">
                                    <span class="text-2xl font-extrabold font-heading text-gold">Rp 14.850.000</span>
                                    <span class="text-[10px] text-slate-300 uppercase tracking-wider">Bulan Ini</span>
                                </div>
                            </div>

                            <!-- Mini Remuneration Chart Index Mock -->
                            <div>
                                <span class="text-xs font-bold text-navy uppercase tracking-wider block mb-1 font-heading">Statistik Kinerja Mingguan</span>
                                <div class="relative pt-6">
                                    <!-- Grid Lines -->
                                    <div class="absolute inset-x-0 top-6 bottom-6 flex flex-col justify-between pointer-events-none">
                                        <span class="w-full border-t border-dashed border-slate-100"></span>
                                        <span class="w-full border-t border-dashed border-slate-100"></span>
                                        <span class="w-full border-t border-dashed border-slate-100"></span>
                                    </div>
                                    <!-- Columns -->
                                    <div class="relative flex justify-between items-end h-28 gap-3 pt-2 z-10">
                                        <div class="flex-1 flex flex-col items-center gap-1.5 group relative">
                                            <div class="absolute -top-7 left-1/2 -translate-x-1/2 scale-0 group-hover:scale-100 transition-all duration-200 bg-navy text-white text-[9px] font-bold py-1 px-2 rounded-md shadow-lg pointer-events-none whitespace-nowrap z-20">
                                                10 SKS
                                            </div>
                                            <div class="w-full bg-gradient-to-t from-slate-200 to-slate-300 rounded-t-xl h-14 hover:from-gold hover:to-yellow-500 hover:shadow-lg hover:shadow-gold/20 transition-all duration-300 cursor-pointer"></div>
                                            <span class="text-[9px] font-bold text-slate-400">M1</span>
                                        </div>
                                        <div class="flex-1 flex flex-col items-center gap-1.5 group relative">
                                            <div class="absolute -top-7 left-1/2 -translate-x-1/2 scale-0 group-hover:scale-100 transition-all duration-200 bg-navy text-white text-[9px] font-bold py-1 px-2 rounded-md shadow-lg pointer-events-none whitespace-nowrap z-20">
                                                16 SKS (Optimal)
                                            </div>
                                            <div class="w-full bg-gradient-to-t from-navy to-navy-light rounded-t-xl h-24 hover:from-gold hover:to-yellow-500 hover:shadow-lg hover:shadow-gold/20 transition-all duration-300 cursor-pointer shadow-md shadow-navy/10"></div>
                                            <span class="text-[9px] font-bold text-navy">M2</span>
                                        </div>
                                        <div class="flex-1 flex flex-col items-center gap-1.5 group relative">
                                            <div class="absolute -top-7 left-1/2 -translate-x-1/2 scale-0 group-hover:scale-100 transition-all duration-200 bg-navy text-white text-[9px] font-bold py-1 px-2 rounded-md shadow-lg pointer-events-none whitespace-nowrap z-20">
                                                12 SKS
                                            </div>
                                            <div class="w-full bg-gradient-to-t from-slate-200 to-slate-300 rounded-t-xl h-16 hover:from-gold hover:to-yellow-500 hover:shadow-lg hover:shadow-gold/20 transition-all duration-300 cursor-pointer"></div>
                                            <span class="text-[9px] font-bold text-slate-400">M3</span>
                                        </div>
                                        <div class="flex-1 flex flex-col items-center gap-1.5 group relative">
                                            <div class="absolute -top-7 left-1/2 -translate-x-1/2 scale-0 group-hover:scale-100 transition-all duration-200 bg-navy text-white text-[9px] font-bold py-1 px-2 rounded-md shadow-lg pointer-events-none whitespace-nowrap z-20">
                                                14 SKS
                                            </div>
                                            <div class="w-full bg-gradient-to-t from-gold to-yellow-500 rounded-t-xl h-20 hover:from-navy hover:to-navy-light hover:shadow-lg hover:shadow-navy/20 transition-all duration-300 cursor-pointer shadow-md shadow-gold/20"></div>
                                            <span class="text-[9px] font-bold text-slate-400">M4</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- Guest System Workflow Showcase Container -->
                        <div class="relative w-full max-w-lg p-7 bg-white border border-slate-100 rounded-3xl shadow-2xl shadow-navy/10 transform lg:rotate-1 hover:rotate-0 transition-all duration-500 font-sans select-none">
                            <h3 class="text-base font-bold text-navy mb-6 font-heading flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gold" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                                Alur Kerja Sistem Remunerasi
                            </h3>

                            <div class="relative space-y-6">
                                <!-- Vertical Timeline Line -->
                                <div class="absolute left-6 top-2 bottom-2 w-0.5 border-l-2 border-dashed border-slate-200"></div>

                                <!-- Step 1 -->
                                <div class="relative flex gap-4 items-start group">
                                    <div class="h-12 w-12 rounded-xl bg-gold/10 text-gold-dark border border-gold/20 flex items-center justify-center shrink-0 shadow-sm group-hover:bg-gold group-hover:text-navy transition-all duration-300 z-10 font-bold">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-bold text-navy font-heading">1. Input &amp; Sinkronisasi Kinerja</h4>
                                        <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                                            Dosen menginput laporan kegiatan Tridharma secara mandiri serta melakukan sinkronisasi otomatis jadwal mengajar dari SIAKAD.
                                        </p>
                                    </div>
                                </div>

                                <!-- Step 2 -->
                                <div class="relative flex gap-4 items-start group">
                                    <div class="h-12 w-12 rounded-xl bg-gold/10 text-gold-dark border border-gold/20 flex items-center justify-center shrink-0 shadow-sm group-hover:bg-gold group-hover:text-navy transition-all duration-300 z-10 font-bold">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 7h-3a2 2 0 00-2 2v9a2 2 0 002 2h9a2 2 0 002-2v-3m-7.793-6.971a3.42 3.42 0 000 4.828M12 2a3 3 0 00-3 3v2a3 3 0 006 0V5a3 3 0 00-3-3z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-bold text-navy font-heading">2. Perhitungan Otomatis Rubrik</h4>
                                        <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                                            Kinerja dosen dihitung secara presisi berdasarkan parameter rubrik remunerasi resmi yang berlaku di Poltekkes Bengkulu.
                                        </p>
                                    </div>
                                </div>

                                <!-- Step 3 -->
                                <div class="relative flex gap-4 items-start group">
                                    <div class="h-12 w-12 rounded-xl bg-gold/10 text-gold-dark border border-gold/20 flex items-center justify-center shrink-0 shadow-sm group-hover:bg-gold group-hover:text-navy transition-all duration-300 z-10 font-bold">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-bold text-navy font-heading">3. Verifikasi &amp; Laporan Final</h4>
                                        <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                                            Hasil perhitungan ditinjau oleh tim verifikator program studi untuk melahirkan lembar laporan remunerasi bulanan yang akuntabel.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Bottom Mini Badge Info -->
                            <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between text-xs text-slate-400 font-sans">
                                <span>Status Sistem: <strong class="text-emerald-600 font-bold">Online</strong></span>
                                <span class="flex items-center gap-1">
                                    <span class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                    Terintegrasi SIAKAD
                                </span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- stats bar overlapping -->
        <div class="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 -mb-12 translate-y-12 z-10">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Stat Card 1 -->
                <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-xl shadow-navy/5 hover:-translate-y-1.5 hover:shadow-2xl hover:shadow-navy/10 transition-all duration-300 flex items-center gap-5 group">
                    <div class="flex items-center justify-center h-14 w-14 rounded-xl bg-gold/10 text-gold-dark group-hover:bg-gold group-hover:text-navy transition-colors duration-300 shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                    </div>
                    <div>
                        <div class="text-3xl font-extrabold text-navy font-heading">{{ $pengumumans->total() }}</div>
                        <div class="mt-1 text-sm font-semibold text-gray-500">Pengumuman Terbit</div>
                    </div>
                </div>

                <!-- Stat Card 2 -->
                <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-xl shadow-navy/5 hover:-translate-y-1.5 hover:shadow-2xl hover:shadow-navy/10 transition-all duration-300 flex items-center gap-5 group">
                    <div class="flex items-center justify-center h-14 w-14 rounded-xl bg-gold/10 text-gold-dark group-hover:bg-gold group-hover:text-navy transition-colors duration-300 shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                        </svg>
                    </div>
                    <div>
                        <div class="text-3xl font-extrabold text-navy font-heading">4</div>
                        <div class="mt-1 text-sm font-semibold text-gray-500">Jurusan Terlayani</div>
                    </div>
                </div>

                <!-- Stat Card 3 -->
                <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-xl shadow-navy/5 hover:-translate-y-1.5 hover:shadow-2xl hover:shadow-navy/10 transition-all duration-300 flex items-center gap-5 group">
                    <div class="flex items-center justify-center h-14 w-14 rounded-xl bg-gold/10 text-gold-dark group-hover:bg-gold group-hover:text-navy transition-colors duration-300 shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <div class="text-3xl font-extrabold text-navy font-heading">24/7</div>
                        <div class="mt-1 text-sm font-semibold text-gray-500">Akses Online</div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end hero -->

    <!-- fitur -->
    <section id="fitur" class="bg-slate-50 pt-32 pb-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-2xl mx-auto text-center mb-14" data-aos="fade-up">
                <span class="text-sm font-bold uppercase tracking-widest text-gold-dark">Kenapa Sistem Ini</span>
                <h2 class="mt-2 text-3xl md:text-4xl font-extrabold text-navy font-heading">Dirancang untuk Keandalan</h2>
                <p class="mt-4 text-gray-500">Tiga prinsip utama yang menjadi fondasi sistem remunerasi kami.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="group bg-white rounded-2xl p-8 border border-slate-100 shadow-md hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300" data-aos="fade-up">
                    <div class="flex items-center justify-center h-14 w-14 rounded-xl bg-gold/15 text-gold-dark group-hover:bg-gold group-hover:text-navy transition-colors duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <h3 class="mt-6 text-xl font-bold text-navy font-heading">Transparan</h3>
                    <p class="mt-2 text-gray-500 leading-relaxed text-sm">Setiap komponen remunerasi tercatat jelas dan dapat ditelusuri kapan pun dibutuhkan.</p>
                </div>
                <div class="group bg-white rounded-2xl p-8 border border-slate-100 shadow-md hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300" data-aos="fade-up" data-aos-delay="100">
                    <div class="flex items-center justify-center h-14 w-14 rounded-xl bg-gold/15 text-gold-dark group-hover:bg-gold group-hover:text-navy transition-colors duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </div>
                    <h3 class="mt-6 text-xl font-bold text-navy font-heading">Akurat &amp; Real-time</h3>
                    <p class="mt-2 text-gray-500 leading-relaxed text-sm">Perhitungan otomatis berbasis rubrik kinerja, meminimalkan kesalahan dan selalu terkini.</p>
                </div>
                <div class="group bg-white rounded-2xl p-8 border border-slate-100 shadow-md hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300" data-aos="fade-up" data-aos-delay="200">
                    <div class="flex items-center justify-center h-14 w-14 rounded-xl bg-gold/15 text-gold-dark group-hover:bg-gold group-hover:text-navy transition-colors duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </div>
                    <h3 class="mt-6 text-xl font-bold text-navy font-heading">Aman &amp; Terpercaya</h3>
                    <p class="mt-2 text-gray-500 leading-relaxed text-sm">Akses berbasis akun resmi dan integrasi SIAKAD menjaga keamanan data Anda.</p>
                </div>
            </div>
        </div>
    </section>
    <!-- end fitur -->

    <!-- Interactive Rubric & Document Guide Section -->
    <section id="simulator" class="bg-white py-24 border-t border-b border-slate-100" x-data="{ activeTab: 'pendidikan' }">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 font-sans">
            <div class="text-center mb-14" data-aos="fade-up">
                <span class="text-sm font-bold uppercase tracking-widest text-gold-dark font-sans">Panduan Kinerja</span>
                <h2 class="mt-2 text-3xl md:text-4xl font-extrabold text-navy font-heading">Panduan Rubrik &amp; Dokumen Bukti</h2>
                <p class="mt-4 text-slate-500 max-w-xl mx-auto text-sm leading-relaxed">
                    Pelajari ketentuan besaran poin kinerja untuk setiap kategori Tridharma Perguruan Tinggi beserta kelengkapan dokumen pendukung yang wajib diunggah ke sistem.
                </p>
            </div>
            
            <div class="bg-slate-50/50 border border-slate-150 rounded-3xl p-6 sm:p-8 shadow-xl shadow-navy/5 max-w-4xl mx-auto" data-aos="zoom-in">
                <!-- Navigation Tabs -->
                <div class="flex flex-wrap gap-2 justify-center mb-8 border-b border-slate-200 pb-6">
                    <button @click="activeTab = 'pendidikan'" :class="activeTab === 'pendidikan' ? 'bg-navy text-white shadow-md' : 'bg-white text-slate-600 hover:bg-slate-100'" class="px-5 py-2.5 rounded-xl font-bold text-sm transition-all duration-300">
                        A. Pendidikan &amp; Pengajaran
                    </button>
                    <button @click="activeTab = 'penelitian'" :class="activeTab === 'penelitian' ? 'bg-navy text-white shadow-md' : 'bg-white text-slate-600 hover:bg-slate-100'" class="px-5 py-2.5 rounded-xl font-bold text-sm transition-all duration-300">
                        B. Penelitian &amp; Publikasi
                    </button>
                    <button @click="activeTab = 'pengabdian'" :class="activeTab === 'pengabdian' ? 'bg-navy text-white shadow-md' : 'bg-white text-slate-600 hover:bg-slate-100'" class="px-5 py-2.5 rounded-xl font-bold text-sm transition-all duration-300">
                        C. Pengabdian Masyarakat
                    </button>
                    <button @click="activeTab = 'penunjang'" :class="activeTab === 'penunjang' ? 'bg-navy text-white shadow-md' : 'bg-white text-slate-600 hover:bg-slate-100'" class="px-5 py-2.5 rounded-xl font-bold text-sm transition-all duration-300">
                        D. Penunjang Akademik
                    </button>
                </div>

                <!-- Tab Contents -->
                <div class="space-y-4">
                    <!-- Tab: Pendidikan -->
                    <div x-show="activeTab === 'pendidikan'" x-transition class="space-y-4">
                        <div class="bg-white border border-slate-100 rounded-2xl p-5 shadow-sm hover:shadow-md transition duration-300 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <div>
                                <h4 class="font-bold text-navy text-base">Perkuliahan Teori (D3/D4/S1)</h4>
                                <p class="text-xs text-slate-500 mt-1">Mengajar mata kuliah teori di kelas reguler sesuai SK Direktur.</p>
                            </div>
                            <div class="flex flex-col sm:items-end gap-2 shrink-0">
                                <span class="px-3 py-1 bg-gold/10 text-gold-dark font-bold text-xs rounded-full w-fit">1 SKS = 1 Poin</span>
                                <span class="text-[10px] text-slate-400">Bukti: SK Mengajar, Presensi, &amp; Nilai Akhir</span>
                            </div>
                        </div>

                        <div class="bg-white border border-slate-100 rounded-2xl p-5 shadow-sm hover:shadow-md transition duration-300 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <div>
                                <h4 class="font-bold text-navy text-base">Bimbingan Tugas Akhir / Skripsi</h4>
                                <p class="text-xs text-slate-500 mt-1">Membimbing mahasiswa tingkat akhir menyelesaikan karya tulis/skripsi.</p>
                            </div>
                            <div class="flex flex-col sm:items-end gap-2 shrink-0">
                                <span class="px-3 py-1 bg-gold/10 text-gold-dark font-bold text-xs rounded-full w-fit">1 Mahasiswa = 1 Poin</span>
                                <span class="text-[10px] text-slate-400">Bukti: SK Direktur/Ketua Jurusan Pembimbing Skripsi</span>
                            </div>
                        </div>

                        <div class="bg-white border border-slate-100 rounded-2xl p-5 shadow-sm hover:shadow-md transition duration-300 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <div>
                                <h4 class="font-bold text-navy text-base">Menguji Sidang Akhir / Skripsi</h4>
                                <p class="text-xs text-slate-500 mt-1">Menjadi dewan penguji pada sidang tugas akhir/skripsi mahasiswa.</p>
                            </div>
                            <div class="flex flex-col sm:items-end gap-2 shrink-0">
                                <span class="px-3 py-1 bg-gold/10 text-gold-dark font-bold text-xs rounded-full w-fit">1 Mahasiswa = 0.5 Poin</span>
                                <span class="text-[10px] text-slate-400">Bukti: Undangan Penguji &amp; Berita Acara Sidang</span>
                            </div>
                        </div>
                    </div>

                    <!-- Tab: Penelitian -->
                    <div x-show="activeTab === 'penelitian'" x-transition class="space-y-4" x-cloak>
                        <div class="bg-white border border-slate-100 rounded-2xl p-5 shadow-sm hover:shadow-md transition duration-300 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <div>
                                <h4 class="font-bold text-navy text-base">Jurnal Internasional Bereputasi (Scopus/SJR)</h4>
                                <p class="text-xs text-slate-500 mt-1">Publikasi karya ilmiah pada jurnal terindeks Scopus atau setara.</p>
                            </div>
                            <div class="flex flex-col sm:items-end gap-2 shrink-0">
                                <span class="px-3 py-1 bg-gold/10 text-gold-dark font-bold text-xs rounded-full w-fit">S.d 40 Poin / Artikel</span>
                                <span class="text-[10px] text-slate-400">Bukti: Link Jurnal Resmi &amp; PDF Artikel Utuh</span>
                            </div>
                        </div>

                        <div class="bg-white border border-slate-100 rounded-2xl p-5 shadow-sm hover:shadow-md transition duration-300 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <div>
                                <h4 class="font-bold text-navy text-base">Jurnal Nasional Terakreditasi (Sinta 1-6)</h4>
                                <p class="text-xs text-slate-500 mt-1">Publikasi karya ilmiah pada jurnal nasional terakreditasi Kemenristek/Sinta.</p>
                            </div>
                            <div class="flex flex-col sm:items-end gap-2 shrink-0">
                                <span class="px-3 py-1 bg-gold/10 text-gold-dark font-bold text-xs rounded-full w-fit">15 - 25 Poin / Artikel</span>
                                <span class="text-[10px] text-slate-400">Bukti: Tangkapan Layar Indeks Sinta &amp; PDF Artikel</span>
                            </div>
                        </div>

                        <div class="bg-white border border-slate-100 rounded-2xl p-5 shadow-sm hover:shadow-md transition duration-300 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <div>
                                <h4 class="font-bold text-navy text-base">Buku Ajar / Monograf (Ber-ISBN)</h4>
                                <p class="text-xs text-slate-500 mt-1">Menulis dan menerbitkan buku ajar ber-ISBN yang digunakan mahasiswa.</p>
                            </div>
                            <div class="flex flex-col sm:items-end gap-2 shrink-0">
                                <span class="px-3 py-1 bg-gold/10 text-gold-dark font-bold text-xs rounded-full w-fit">20 Poin / Buku</span>
                                <span class="text-[10px] text-slate-400">Bukti: Halaman Cover, ISBN, &amp; Lembar Penerbit</span>
                            </div>
                        </div>
                    </div>

                    <!-- Tab: Pengabdian -->
                    <div x-show="activeTab === 'pengabdian'" x-transition class="space-y-4" x-cloak>
                        <div class="bg-white border border-slate-100 rounded-2xl p-5 shadow-sm hover:shadow-md transition duration-300 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <div>
                                <h4 class="font-bold text-navy text-base">Penyuluhan / Pelatihan Masyarakat</h4>
                                <p class="text-xs text-slate-500 mt-1">Mengadaan pelatihan, penyuluhan, atau edukasi kesehatan pada masyarakat umum.</p>
                            </div>
                            <div class="flex flex-col sm:items-end gap-2 shrink-0">
                                <span class="px-3 py-1 bg-gold/10 text-gold-dark font-bold text-xs rounded-full w-fit">5 - 10 Poin / Kegiatan</span>
                                <span class="text-[10px] text-slate-400">Bukti: Surat Tugas, Laporan Kegiatan, &amp; Absensi</span>
                            </div>
                        </div>

                        <div class="bg-white border border-slate-100 rounded-2xl p-5 shadow-sm hover:shadow-md transition duration-300 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <div>
                                <h4 class="font-bold text-navy text-base">Pelayanan Sosial / Layanan Kesehatan Terpadu</h4>
                                <p class="text-xs text-slate-500 mt-1">Terlibat langsung sebagai tim medis dalam aksi sosial kemanusiaan atau pelayanan posyandu.</p>
                            </div>
                            <div class="flex flex-col sm:items-end gap-2 shrink-0">
                                <span class="px-3 py-1 bg-gold/10 text-gold-dark font-bold text-xs rounded-full w-fit">5 Poin / Aksi</span>
                                <span class="text-[10px] text-slate-400">Bukti: SK Kegiatan, Laporan Hasil, &amp; Foto Dokumentasi</span>
                            </div>
                        </div>
                    </div>

                    <!-- Tab: Penunjang -->
                    <div x-show="activeTab === 'penunjang'" x-transition class="space-y-4" x-cloak>
                        <div class="bg-white border border-slate-100 rounded-2xl p-5 shadow-sm hover:shadow-md transition duration-300 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <div>
                                <h4 class="font-bold text-navy text-base">Menjadi Anggota Senat Akademik</h4>
                                <p class="text-xs text-slate-500 mt-1">Terpilih dan bertugas sebagai perwakilan Senat Akademik Poltekkes Bengkulu.</p>
                            </div>
                            <div class="flex flex-col sm:items-end gap-2 shrink-0">
                                <span class="px-3 py-1 bg-gold/10 text-gold-dark font-bold text-xs rounded-full w-fit">5 Poin / Semester</span>
                                <span class="text-[10px] text-slate-400">Bukti: SK Direktur/Ketua Senat Akademik</span>
                            </div>
                        </div>

                        <div class="bg-white border border-slate-100 rounded-2xl p-5 shadow-sm hover:shadow-md transition duration-300 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <div>
                                <h4 class="font-bold text-navy text-base">Panitia Kegiatan Institusi (Ketua / Anggota)</h4>
                                <p class="text-xs text-slate-500 mt-1">Bertugas dalam kepanitiaan acara/program kerja di tingkat kampus.</p>
                            </div>
                            <div class="flex flex-col sm:items-end gap-2 shrink-0">
                                <span class="px-3 py-1 bg-gold/10 text-gold-dark font-bold text-xs rounded-full w-fit">1 - 3 Poin / SK</span>
                                <span class="text-[10px] text-slate-400">Bukti: SK Kepanitiaan Resmi dari Direktur</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section id="faq" class="bg-slate-50 py-24">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 font-sans">
            <div class="text-center mb-14" data-aos="fade-up">
                <span class="text-sm font-bold uppercase tracking-widest text-gold-dark font-sans">Tanya Jawab</span>
                <h2 class="mt-2 text-3xl md:text-4xl font-extrabold text-navy font-heading">Pertanyaan Umum (FAQ)</h2>
            </div>
            
            <div class="space-y-4" x-data="{ activeFaq: null }">
                <!-- FAQ Item 1 -->
                <div class="border border-slate-150 rounded-2xl overflow-hidden bg-white shadow-sm transition-all duration-300">
                    <button @click="activeFaq = (activeFaq === 1) ? null : 1" class="w-full flex justify-between items-center p-5 text-left font-bold text-navy hover:bg-slate-50/50 transition">
                        <span>Bagaimana perhitungan remunerasi dilakukan?</span>
                        <svg :class="activeFaq === 1 ? 'rotate-180' : ''" class="w-5 h-5 transition-transform text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="activeFaq === 1" x-cloak x-transition class="p-5 border-t border-slate-100 text-slate-500 text-sm leading-relaxed bg-slate-50/30">
                        Perhitungan remunerasi dihitung secara otomatis berbasis rubrik kinerja dosen, mencakup perkuliahan teori, praktikum, pembimbingan, penelitian, pengabdian masyarakat, dan penunjang akademik lainnya yang terverifikasi.
                    </div>
                </div>

                <!-- FAQ Item 2 -->
                <div class="border border-slate-150 rounded-2xl overflow-hidden bg-white shadow-sm transition-all duration-300">
                    <button @click="activeFaq = (activeFaq === 2) ? null : 2" class="w-full flex justify-between items-center p-5 text-left font-bold text-navy hover:bg-slate-50/50 transition">
                        <span>Bagaimana cara data terintegrasi dengan SIAKAD?</span>
                        <svg :class="activeFaq === 2 ? 'rotate-180' : ''" class="w-5 h-5 transition-transform text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="activeFaq === 2" x-cloak x-transition class="p-5 border-t border-slate-100 text-slate-500 text-sm leading-relaxed bg-slate-50/30">
                        Sistem melakukan integrasi satu pintu via OAuth2 SIAKAD. Akun dosen yang terdaftar di SIAKAD dapat langsung digunakan untuk sinkronisasi nilai EWMP dan jadwal pengajaran tanpa perlu registrasi ulang.
                    </div>
                </div>

                <!-- FAQ Item 3 -->
                <div class="border border-slate-150 rounded-2xl overflow-hidden bg-white shadow-sm transition-all duration-300">
                    <button @click="activeFaq = (activeFaq === 3) ? null : 3" class="w-full flex justify-between items-center p-5 text-left font-bold text-navy hover:bg-slate-50/50 transition">
                        <span>Apakah riwayat perhitungan remunerasi saya aman?</span>
                        <svg :class="activeFaq === 3 ? 'rotate-180' : ''" class="w-5 h-5 transition-transform text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="activeFaq === 3" x-cloak x-transition class="p-5 border-t border-slate-100 text-slate-500 text-sm leading-relaxed bg-slate-50/30">
                        Ya. Seluruh data transaksi, nominal remunerasi, dan riwayat rubrik yang disimpan dienkripsi secara aman dan hanya dapat diakses oleh dosen yang bersangkutan serta verifikator berwenang.
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- content pengumuman -->
    <section class="bg-white py-24" id="pengumuman">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6 mb-12" data-aos="fade-up">
                <div>
                    <span class="text-sm font-bold uppercase tracking-widest text-gold-dark font-sans">Informasi Terbaru</span>
                    <h2 class="mt-2 font-heading text-3xl md:text-4xl font-extrabold text-navy">Pengumuman</h2>
                    <div class="mt-3 h-1 w-20 rounded-full bg-gold"></div>
                </div>
                <form method="GET" id="pencarianPengumuman" class="w-full lg:w-auto">
                    <div class="relative font-sans">
                        <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </span>
                        <input type="text" name="judulPencarian" value="{{$judulPencarian}}" class="w-full lg:w-96 py-3 pl-11 pr-28 text-gray-700 bg-slate-50 border border-gray-200 rounded-xl focus:bg-white focus:border-gold focus:outline-none focus:ring-4 focus:ring-gold/10 focus:border-gold text-sm transition" placeholder="Cari judul pengumuman...">
                        <button type="submit" class="absolute inset-y-0 right-0 my-1.5 mr-1.5 px-5 text-navy font-bold text-sm bg-gold hover:bg-gold-dark rounded-lg transition-colors duration-300">Cari</button>
                    </div>
                </form>
            </div>

            @if(count($pengumumans) > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach ($pengumumans as $pengumuman)
                        <article class="group flex flex-col bg-white rounded-2xl border border-slate-100 shadow-md hover:shadow-xl hover:border-gold/30 hover:-translate-y-1 transition-all duration-300 overflow-hidden" data-aos="fade-up">
                            <div class="h-1.5 w-full bg-gradient-to-r from-gold to-yellow-500"></div>
                            <div class="p-7 flex flex-col flex-1">
                                <p class="inline-flex items-center text-xs font-semibold text-gold-dark uppercase tracking-wide mb-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z" />
                                    </svg>{{ $pengumuman->tanggal_pengumuman->isoFormat('dddd, DD MMMM YYYY') }}
                                </p>
                                <a href="{{ route('home.detail',[$pengumuman->id]) }}" class="block text-lg text-navy font-bold leading-snug hover:text-gold-dark duration-300 line-clamp-2 font-heading">{{ $pengumuman->judul_pengumuman }}</a>
                                <div class="mt-2 font-normal text-sm text-gray-500 leading-relaxed line-clamp-3 flex-1 font-sans">
                                    {!! $pengumuman->short_isi_pengumuman !!}
                                </div>
                                <div class="mt-5 pt-4 border-t border-gray-100 flex items-center justify-between gap-3">
                                    <a href="{{ route('home.detail',[$pengumuman->id]) }}" class="inline-flex items-center gap-1 text-sm font-semibold text-navy hover:text-gold-dark transition-colors font-sans">
                                        Baca Selengkapnya
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                                    </a>
                                    @if ($pengumuman->file_pengumuman != null || $pengumuman->file_pengumuman != "")
                                        <a href="{{ route('home.download_pengumuman',[$pengumuman->id]) }}" title="Unduh dokumen" class="inline-flex items-center gap-1.5 text-xs font-semibold text-gold-dark bg-gold/10 hover:bg-gold/20 px-3 py-1.5 rounded-lg transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                            PDF
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                <div class="mt-10">
                    {{ $pengumumans->withQueryString()->links() }}
                </div>
            @else
                <div class="text-center py-20 bg-slate-50 rounded-2xl border border-dashed border-gray-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-14 h-14 mx-auto text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <p class="mt-4 text-gray-500 font-medium">Belum ada pengumuman yang cocok dengan pencarian Anda.</p>
                </div>
            @endif
        </div>
    </section>
    <!-- end pengumuman-->

    <!-- CTA -->
    <section class="relative overflow-hidden bg-navy py-16">
        <div class="pointer-events-none absolute -bottom-20 -right-10 h-72 w-72 rounded-full bg-gold/15 blur-3xl"></div>
        <div class="relative max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center font-sans" data-aos="zoom-in">
            <h2 class="text-2xl md:text-3xl font-extrabold text-white font-heading">Siap mengakses remunerasi Anda?</h2>
            <p class="mt-3 text-gray-300 max-w-2xl mx-auto">Masuk menggunakan akun resmi atau SIAKAD untuk melihat rincian dan riwayat remunerasi Anda.</p>
            <a href="{{ route('login') }}" class="inline-flex items-center justify-center gap-2 mt-8 px-8 py-3.5 bg-gold hover:bg-gold-dark text-navy font-bold text-sm transition-all duration-300 rounded-xl shadow-lg shadow-gold/20 hover:scale-[1.02] active:scale-[0.98]">
                Login Sekarang
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
            </a>
        </div>
    </section>
    <!-- end CTA -->

    <!-- Footer  -->
    <footer class="bg-navy-dark text-gray-300 font-sans">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">
                <div class="lg:col-span-2">
                    <div class="flex items-center">
                        <img src="{{ asset('assets/img/logo.svg') }}" alt="Logo Poltekkes" class="h-12 w-auto">
                        <div class="ml-3 leading-tight">
                            <strong class="text-white tracking-wide block font-heading">SISTEM REMUNERASI</strong>
                            <span class="text-xs text-gold/90 font-semibold">POLTEKKES KEMENKES BENGKULU</span>
                        </div>
                    </div>
                    <p class="mt-5 text-sm leading-relaxed max-w-md text-gray-400">
                        Jl. Indragiri Padang Harapan No.3, Padang Harapan, Kecamatan Gading Cempaka, Kota Bengkulu, Bengkulu 38225.
                    </p>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4 font-heading">Navigasi</h4>
                    <ul class="space-y-2.5 text-sm">
                        <li><a href="#home" class="hover:text-gold transition-colors">Beranda</a></li>
                        <li><a href="#fitur" class="hover:text-gold transition-colors">Tentang</a></li>
                        <li><a href="#pengumuman" class="hover:text-gold transition-colors">Pengumuman</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-gold transition-colors">Login</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4 font-heading">Ikuti Kami</h4>
                    <div class="flex gap-3">
                        <a target="_blank" href="https://www.facebook.com/people/Poltekkes-Kemenkes-Bengkulu/100067328544143/" aria-label="Facebook" class="flex items-center justify-center h-10 w-10 rounded-lg bg-white/5 hover:bg-gold hover:text-navy transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987H7.898v-2.89h2.54V9.797c0-2.507 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/></svg>
                        </a>
                        <a target="_blank" href="https://www.instagram.com/polkeslu_official/" aria-label="Instagram" class="flex items-center justify-center h-10 w-10 rounded-lg bg-white/5 hover:bg-gold hover:text-navy transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.332.014 7.052.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                        </a>
                        <a target="_blank" href="https://www.youtube.com/channel/UCLC0PeLAIweVCFGQtGydTFA" aria-label="Youtube" class="flex items-center justify-center h-10 w-10 rounded-lg bg-white/5 hover:bg-gold hover:text-navy transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                        </a>
                    </div>
                    <a target="_blank" href="https://poltekkesbengkulu.ac.id/" class="inline-block mt-5 text-sm text-gold hover:underline font-semibold font-heading">poltekkesbengkulu.ac.id</a>
                </div>
            </div>
        </div>
        <div class="border-t border-white/10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-5 text-center text-sm text-gray-400">
                Copyright &copy; {{ date('Y') }} Sistem Remunerasi
                <a target="_blank" href="https://poltekkesbengkulu.ac.id/" class="text-gold font-semibold hover:underline">Poltekkes Kemenkes Bengkulu</a>. All rights reserved.
            </div>
        </div>
    </footer>
    <!-- end Footer -->
    <!-- back to top  -->
    <div class="" x-data="{scrollBackTop: false}" x-cloak>
        <svg x-show="scrollBackTop" @click="window.scrollTo({top: 0, behavior: 'smooth'})"
            x-on:scroll.window="scrollBackTop = (window.pageYOffset > window.outerHeight * 0.5) ? true : false"
            aria-label="Back to top" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
            class="bi bi-arrow-up-circle-fill fixed bottom-0 right-0 mx-3 my-10 h-9 w-9 fill-navy shadow-lg cursor-pointer hover:fill-gold-dark bg-white rounded-full transition-colors duration-300"
            viewBox="0 0 16 16">
            <path
                d="M16 8A8 8 0 1 0 0 8a8 8 0 0 0 16 0zm-7.5 3.5a.5.5 0 0 1-1 0V5.707L5.354 7.854a.5.5 0 1 1-.708-.708l3-3a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 5.707V11.5z" />
        </svg>
    </div>

</body>
@if(session('pesan'))
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            alert({!! json_encode('Berhasil! ' . session('pesan')) !!});
        });
    </script>
@endif
@if(session('error'))
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            alert({!! json_encode('Gagal! ' . session('error')) !!});
        });
    </script>
@endif
<!-- script -->
<script src="{{ asset('assets/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('assets/frontend/scripts.js') }}"></script>
<script src="{{ asset('assets/ckeditor/build/ckeditor.js') }}"></script>
</html>

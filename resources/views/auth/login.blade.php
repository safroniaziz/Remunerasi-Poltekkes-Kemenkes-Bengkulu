<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sistem Remunerasi | Login</title>
    <link rel="shortcut icon" href="{{ asset('assets/img/logo.svg') }}">

    <!-- stylesheets tailwind -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        navy: { DEFAULT: '#152042', dark: '#0d1530', light: '#1e2d5a' },
                        gold: { DEFAULT: '#fbbf24', dark: '#f59e0b', light: '#fef3c7' },
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        heading: ['Plus Jakarta Sans', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="{{ asset('assets/login/output.css') }}">
    <!-- alpine js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.12.0/dist/cdn.min.js"></script>
    <!-- tailwindcss flag-icon  -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.4.6/css/flag-icon.min.css" rel="stylesheet">

    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
    <link rel="stylesheet" href="{{ asset('assets/login/style.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.6/flowbite.min.css" rel="stylesheet" />
    <style>[x-cloak]{display:none!important}</style>
</head>

<body class="m-0 font-sans antialiased font-normal bg-slate-100 text-start text-base text-slate-600">
    <main class="min-h-screen lg:grid lg:grid-cols-2">

        <!-- SIAKAD modal -->
        <div id="authentication-modal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full bg-navy/40 backdrop-blur-md">
            <div class="relative w-full max-w-md max-h-full mx-auto mt-24">
                <div class="relative bg-white rounded-2xl shadow-2xl">
                    <button type="button" class="absolute top-3 right-3 text-gray-400 bg-transparent hover:bg-gray-100 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-hide="authentication-modal">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                    <div class="px-6 py-6 lg:px-8">
                        <h3 class="mb-4 text-xl font-bold text-navy font-heading">Login Akun SIAKAD (Dosen)</h3>
                        <iframe src="{{ asset('Helpers/api/oAuth2Client/index.blade.php') }}" width="100%" height="190" class="rounded-lg border border-gray-200"></iframe>
                    </div>
                </div>
            </div>
        </div>

        <!-- Brand panel (kiri) -->
        <aside class="relative hidden lg:flex flex-col justify-between overflow-hidden bg-navy p-12 text-white font-sans">
            <div class="pointer-events-none absolute -top-24 -right-20 h-96 w-96 rounded-full bg-gold/20 blur-3xl"></div>
            <div class="pointer-events-none absolute -bottom-24 -left-20 h-96 w-96 rounded-full bg-gold/10 blur-3xl"></div>
            <div class="pointer-events-none absolute inset-0 opacity-[0.05]" style="background-image:radial-gradient(#fff 1px,transparent 1px);background-size:22px 22px;"></div>

            <a href="/" class="relative flex items-center gap-3">
                <img src="{{ asset('assets/img/logo.svg') }}" class="h-12 w-auto" alt="Logo Poltekkes">
                <div class="leading-tight">
                    <strong class="block tracking-wide font-heading">SISTEM REMUNERASI</strong>
                    <span class="text-xs text-gold/90 font-semibold">POLTEKKES KEMENKES BENGKULU</span>
                </div>
            </a>

            <div class="relative">
                <lottie-player src="{{ asset('assets/img/finance.json') }}" background="transparent" speed="1" class="w-full max-w-md mx-auto h-auto" loop autoplay></lottie-player>
                <h2 class="mt-6 text-3xl font-extrabold leading-tight font-heading">Selamat Datang Kembali</h2>
                <p class="mt-3 text-gray-300 max-w-md leading-relaxed">Masuk untuk mengelola dan memantau remunerasi Anda secara transparan, akurat, dan aman.</p>
                
                <div class="mt-6 bg-white/5 backdrop-blur-md border border-white/10 rounded-2xl p-6 max-w-md">
                    <ul class="space-y-3.5 text-sm text-gray-200">
                        <li class="flex items-center gap-3"><span class="flex h-6 w-6 items-center justify-center rounded-full bg-gold/20 text-gold"><svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg></span> Data remunerasi real-time</li>
                        <li class="flex items-center gap-3"><span class="flex h-6 w-6 items-center justify-center rounded-full bg-gold/20 text-gold"><svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg></span> Integrasi dengan SIAKAD</li>
                        <li class="flex items-center gap-3"><span class="flex h-6 w-6 items-center justify-center rounded-full bg-gold/20 text-gold"><svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg></span> Akses aman 24/7</li>
                    </ul>
                </div>
            </div>

            <p class="relative text-xs text-gray-400">&copy; {{ date('Y') }} Poltekkes Kemenkes Bengkulu. All rights reserved.</p>
        </aside>

        <!-- Form panel (kanan) -->
        <section class="flex items-center justify-center px-6 py-12 sm:px-12 font-sans">
            <div class="w-full max-w-md" x-data="{ showPassword: false }">
                <!-- brand mobile -->
                <div class="lg:hidden text-center mb-8">
                    <img src="{{ asset('assets/img/logo.svg') }}" class="h-20 w-auto mx-auto mb-3" alt="logo">
                    <h1 class="text-lg font-extrabold text-navy leading-tight font-heading">SISTEM REMUNERASI<br><span class="text-gold-dark font-sans text-sm font-bold block mt-1">POLTEKKES KEMENKES BENGKULU</span></h1>
                </div>

                <div class="mb-8">
                    <h2 class="text-2xl font-extrabold text-navy font-heading">Masuk ke Akun</h2>
                    <p class="mt-1.5 text-sm text-gray-500">Gunakan NIP/Email dan password Anda untuk melanjutkan.</p>
                </div>

                @if (session('status'))
                <div class="flex items-center gap-2 bg-gold/15 border border-gold/40 text-navy text-sm font-semibold px-4 py-3 rounded-xl mb-5" role="alert">
                    <svg class="fill-current w-4 h-4 text-gold-dark shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M12.432 0c1.34 0 2.01.912 2.01 1.957 0 1.305-1.164 2.512-2.679 2.512-1.269 0-2.009-.75-1.974-1.99C9.789 1.436 10.67 0 12.432 0zM8.309 20c-1.058 0-1.833-.652-1.093-3.524l1.214-5.092c.211-.814.246-1.141 0-1.141-.317 0-1.689.562-2.502 1.117l-.528-.88c2.572-2.186 5.531-3.467 6.801-3.467 1.057 0 1.233 1.273.705 3.23l-1.391 5.352c-.246.945-.141 1.271.106 1.271.317 0 1.357-.392 2.379-1.207l.6.814C12.098 19.02 9.365 20 8.309 20z"/></svg>
                    <span>{{ session('status') }}</span>
                </div>
                @endif

                <form action="{{ route('login') }}" method="POST" class="space-y-5">
                    {{ csrf_field() }} {{ method_field('POST') }}

                    <div>
                        <label class="block mb-2 font-semibold text-sm text-slate-700">NIP / Email</label>
                        <div class="relative">
                            <input type="text" name="id_user" id="id_user" value="{{ old('id_user') }}"
                                class="peer block w-full rounded-2xl border border-gray-300 bg-white pl-11 pr-3 py-3 text-sm text-gray-700 transition-all focus:border-gold focus:outline-none focus:ring-4 focus:ring-gold/10"
                                placeholder="Masukkan NIP atau email" aria-label="id_user"
                                required autofocus autocomplete="username"/>
                            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400 peer-focus:text-gold transition-colors duration-300">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206"/></svg>
                            </span>
                        </div>
                        <x-input-error :messages="$errors->get('id_user')" class="mt-2" />
                    </div>

                    <div>
                        <label class="block mb-2 font-semibold text-sm text-slate-700">Password</label>
                        <div class="relative">
                            <input :type="showPassword ? 'text' : 'password'" name="password" id="password"
                                class="peer block w-full rounded-2xl border border-gray-300 bg-white pl-11 pr-11 py-3 text-sm text-gray-700 transition-all focus:border-gold focus:outline-none focus:ring-4 focus:ring-gold/10"
                                placeholder="Masukkan password" aria-label="Password" required />
                            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400 peer-focus:text-gold transition-colors duration-300">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            </span>
                            <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400 hover:text-navy transition-colors" aria-label="Tampilkan password">
                                <svg x-show="!showPassword" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                <svg x-show="showPassword" x-cloak class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <button type="submit" class="w-full inline-flex items-center justify-center gap-2 text-navy bg-gold hover:bg-gold-dark focus:ring-4 focus:outline-none focus:ring-gold/20 font-bold rounded-2xl text-sm px-5 py-3.5 transition-all duration-300 shadow-lg shadow-gold/20 hover:scale-[1.01] active:scale-[0.99]">
                        Login
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                    </button>
                </form>

                <div class="flex items-center gap-4 my-6">
                    <span class="h-px flex-1 bg-gray-200"></span>
                    <span class="text-xs font-medium text-gray-400 uppercase tracking-wide">atau</span>
                    <span class="h-px flex-1 bg-gray-200"></span>
                </div>

                <button data-modal-target="authentication-modal" data-modal-toggle="authentication-modal" type="button" class="w-full inline-flex items-center justify-center gap-2 text-navy border border-navy/15 bg-white hover:bg-navy hover:text-white hover:border-transparent focus:ring-4 focus:outline-none focus:ring-navy/10 font-semibold rounded-2xl text-sm px-5 py-3.5 transition-all duration-300 hover:scale-[1.01] active:scale-[0.99] shadow-sm hover:shadow-md">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>
                    Login dengan SIAKAD
                </button>

                <p class="mt-8 text-center text-xs text-gray-400">
                    <a href="/" class="hover:text-navy font-medium transition-colors">&larr; Kembali ke beranda</a>
                </p>
            </div>
        </section>
    </main>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.6/flowbite.min.js"></script>
</body>
</html>
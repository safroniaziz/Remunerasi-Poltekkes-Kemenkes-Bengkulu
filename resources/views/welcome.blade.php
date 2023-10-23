
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Remunerasi Poltekkes Kemenkes Bengkulu</title>
    <link rel="shortcut icon" href="{{ asset('assets/img/logo.svg') }}">
    <!-- stylesheets tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('assets/frontend/output.css') }}">
    <!-- alpine js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.12.0/dist/cdn.min.js"></script>
    <!-- tailwindcss flag-icon  -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.4.6/css/flag-icon.min.css" rel="stylesheet">

    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.7.0/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/frontend/style.css') }}">

    <style>
        .glow {
            border: 3px solid white;
        }

        .card-container {
            display: flex;
            justify-content: center;
        }

        .max-w-sm {
            width: 100%; /* Atur lebar sesuai kebutuhan */
            max-width: 400px; /* Atur lebar maksimum sesuai kebutuhan */
        }

        .card-content {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .card-img {
            width: 100%;
            max-width: 100%;
            height: auto;
        }

        #loader-wrapper {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1000;
            background-color: #fff;
        }

        #loader-logo {
            background: url('assets/img/logo.svg') no-repeat;
            background-size: 70px;

            width: 80px;
            text-align: center;
            margin: auto;
            bottom: 0px;
            height: 80px;
            top: 0;
            left: 0px;
            right: 0px;
            position: absolute;
        }

        #loader {
            display: block;
            position: relative;
            left: 50%;
            top: 50%;
            width: 120px;
            height: 120px;
            margin: -62px 0 0 -65px;
            border: 5px solid #152042;
            z-index: 1500;
        }

        #loader {
            border: 5px solid #152042;
            border-top-color: #eeeeee;
            border-radius: 50%;
            -webkit-animation: spin 1s linear infinite;
            animation: spin 1s linear infinite;
        }

        @-webkit-keyframes spin {
            0% {
                -webkit-transform: rotate(0deg);
                /* Chrome, Opera 15+, Safari 3.1+ */
                -ms-transform: rotate(0deg);
                /* IE 9 */
                transform: rotate(0deg);
                /* Firefox 16+, IE 10+, Opera */
            }

            100% {
                -webkit-transform: rotate(360deg);
                /* Chrome, Opera 15+, Safari 3.1+ */
                -ms-transform: rotate(360deg);
                /* IE 9 */
                transform: rotate(360deg);
                /* Firefox 16+, IE 10+, Opera */
            }
        }

        @keyframes spin {
            0% {
                -webkit-transform: rotate(0deg);
                /* Chrome, Opera 15+, Safari 3.1+ */
                -ms-transform: rotate(0deg);
                /* IE 9 */
                transform: rotate(0deg);
                /* Firefox 16+, IE 10+, Opera */
            }

            100% {
                -webkit-transform: rotate(360deg);
                /* Chrome, Opera 15+, Safari 3.1+ */
                -ms-transform: rotate(360deg);
                /* IE 9 */
                transform: rotate(360deg);
                /* Firefox 16+, IE 10+, Opera */
            }
        }

        @keyframes zoom-in {
            from { transform: scale(0); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }

        .animated-image {
            animation: zoom-in 1s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }

        .modal-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }

        .modal-content {
            background-color: #fff;
            border-radius: 0.5rem;
            max-height: 80vh;
            overflow-y: auto;
            padding: 2rem;
            width: 90%;
            max-width: 640px;
        }
    </style>

    @stack('styleshome')
</head>

<body class="  antialiased leading-normal tracking-wide 2xl:text-xl font-nunito  bg-red   text-slate-900"
    x-data="{ switcher: translationSwitcher() }">
    <div id="home"></div>

    <!-- Preloader Start -->
    <div x-data="{ show: false }" x-transition:enter="transition duration-700" style="z-index: 99;"
        x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
        class="bg-white rounded p-4" x-show="show">
        <!-- Preloader Start -->
        <div id="loader-wrapper">
            <div id="loader-logo">
                <div id="loader"></div>
            </div>
        </div>
        <!-- Preloader Start -->
    </div>

    <!-- Preloader Start -->


    <!-- navbar  -->
    <nav x-data="{isOpen: false }" class="fixed top-0 z-50 w-full     ">
        <!-- Top Bar -->
        
        <div id="navbar" class="px-6 py-4 mx-auto duration-300 bg-[#152042]   ">
            <div class="lg:flex lg:items-center lg:justify-between  ">
                <div class="flex items-center justify-between">
                    <!-- logo -->
                    <a href="/view/home.html" class="flex items-center text-black   mx-4 md:ml-6">
                        <img src="{{ asset('assets/img/logo.svg') }}" style="height: 50px">

                        <div class="ml-3 text-white">
                            <strong>SISTEM REMUNERASI</strong> <br>
                            <span>POLTEKKES KEMENKES BENGKULU</span>
                        </div>
                    </a>
                    <!-- Mobile menu button -->
                    <div class="flex lg:hidden">
                        <button x-cloak @click="isOpen = !isOpen" type="button"
                            class="text-gray-200 hover:text-gray-400 focus:outline-none focus:text-gray-100 "
                            aria-label="toggle menu">
                            <svg x-show="!isOpen" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 8h16M4 16h16" />
                            </svg>
                            <svg x-show="isOpen" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
                <!-- Mobile Menu open: "block", Menu closed: "hidden" -->
                <div x-cloak :class="[isOpen ? 'translate-x-0 opacity-100 ' : 'opacity-0 -translate-x-full']" class="absolute inset-x-0 z-20 w-full px-6 py-4 transition-all duration-300 ease-in-out bg-[#152042]   md:bg-none menu-navbar text-white lg:mt-0 lg:p-0 lg:top-0 lg:relative lg:bg-transparent lg:w-auto
                    lg:opacity-100 lg:translate-x-0 lg:flex lg:items-center " id="list-menu">
                    <div class="flex flex-col -mx-6 lg:flex-row lg:items-center lg:mx-8 ">
                        <a href="#home" class="px-3 py-2 mx-2 mt-2 text-gray-100 transition-colors active-menu duration-300 transform rounded-md
                            lg:mt-0 hover:text-[#fbbf24] font-medium">Home</a>
                        <a href="#pengumuman"
                            class="px-3 py-2 mx-2 mt-2 text-gray-100 transition-colors duration-300 transform rounded-md lg:mt-0 hover:text-[#fbbf24]       font-medium">Pengumuman</a>
                        <a href="{{ route('login') }}"
                            class="px-3 py-2 mx-2 mt-2 text-gray-100 transition-colors duration-300 transform rounded-md lg:mt-0 hover:text-[#fbbf24]       font-medium">Login</a>
                    </div>

                </div>
            </div>
        </div>

    </nav>
    <!-- end navbar -->

    <!-- slider -->
    <section id="home" class="bg-[#152042]  sliderAx font-sans p-12 mt-22 pattren">
        <div class="container px-6 p-8 mx-auto">
            <div class="items-center lg:flex">
                <div class="w-full lg:w-6/6">
                    <div class=" ">
                        <h1 class="text-gray-200 lg:text-6xl md:text-4xl text-4xl font-bold mb-4"
                            style="text-shadow:5px 5px 5px #000;">SELAMAT<span class="text-yellow-600 ">&nbsp; DATANG</span>
                        </h1>

                        <h2 class="text-gray-200 lg:text-2xl md:text-2xl text-xl font-bold mb-4 "
                            style="text-shadow:5px 5px 5px #000;">SISTEM INFORMASI REMUNERASI POLTEKKES KEMENKES BENGKULU
                        </h2>

                        <p class="my-8 text-gray-300 text-xs md:text-sm text-justify">
                            Jl. Indragiri Padang Harapan No.3, Padang Harapan, Kecamatan Gading Cempaka, Kota Bengkulu, Bengkulu 38225
                        </p>
                        
                    <a href="{{ route('login') }}" class="inline-flex items-center justify-center w-auto my-5 px-8 py-3 bg-yellow-600
                    hover:shadow-none
                    text-white font-bold hover:scale-[99%] focus:bg-yellow-700 overflow-hidden
                    text-sm transition-colors duration-300 rounded-lg shadow
                     hover:bg-yellow-500 focus:ring
                    focus:ring-gray-300 focus:ring-opacity-80">Login</a>
                        {{--  <div class="user_box_login user_box_link text-xs pr-6"><a href="{{ route('login') }}">Login</a></div>  --}}
                        {{--  <div class="user_box_register user_box_link text-xs"><a href="{{ route('register') }}">Register</a></div>  --}}
                    </div>
                </div>
                <div class="flex items-center justify-center w-full mt-6 lg:mt-0 lg:w-6/6">
                     <lottie-player src="{{ asset('assets/img/hello.json') }} " background="transparent" speed="1"
                            class="w-10/12 h-10/12 " loop autoplay></lottie-player> 
                            {{-- <img src="{{ asset('assets/frontend/hero.json') }}" alt="Hero Image" class="w-12/12 h-12/12 animated-image"> --}}
                        </div>
            </div>
        </div>
    </section>
    <!-- end slider -->

    <!-- content pengumuman -->
    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-28" id="pengumuman">
        <h2 data-aos="fade-up" class="mb-16 text-center font-sans text-4xl lg:text-5xl font-bold text-[#0b3960]   "
                style="text-shadow:5px 5px 5px #38383863;">
                PENGUMUMAN</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="col-span-1 ">
                <div class=" px-6 mb-6 py-6 bg-white rounded-lg shadow-md">
                    <h3 class="text-lg font-bold text-center mb-5 ">PENCARIAN PENGUMUMAN</h3>

                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="w-5 h-5 text-gray-400" viewBox="0 0 24 24" fill="none">
                                <path d="M21 21L15 15M17 10C17 13.866 13.866 17 10 17C6.13401 17 3 13.866 3 10C3 6.13401 6.13401 3 10 3C13.866 3 17 6.13401 17 10Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </span>

                        <input type="text" class="w-full py-3 pl-10 pr-4 mb-4 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-900 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 dark:focus:border-blue-300 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-40 text-[14px]" placeholder="Cari Judul Pengumuman">
                    </div>
                        <button href="login.html"
                            class="  py-2   my-3 w-full text-white text-[14px] transition-colors duration-300 transform   lg:mt-0     bg-gradient-to-r  from-[#0d276e] to-[#18a6ede3] border border-white rounded-lg  hover:from-[#09072ce3] hover:to-[#18a6ede7]  px-5  ">Cari</button>
                </div>
            </div>
            <div class="col-span-1 lg:col-span-2">
                <!-- component -->
                @foreach ($pengumumans as $pengumuman)
                    <div class=" px-10 mb-6 py-6 bg-white rounded-lg shadow-md">
                        <div class="flex justify-between items-center">
                            <p class=" flex text-[14px]"><svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2"
                                    fill="currentColor" class="bi bi-calendar" viewBox="0 0 16 16">
                                    <path
                                        d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z" />
                                </svg>{{ $pengumuman->tanggal_pengumuman->isoFormat('dddd, DD MMMM YYYY') }}</p>
                        </div>
                        <div class="mt-2">
                            <a class="text-[16px] text-gray-700 font-bold hover:text-blue-500 duration-300 transform line-clamp-2"
                                href="{{ route('home.detail',[$pengumuman->id]) }}">{{ $pengumuman->judul_pengumuman }}</a>
                            <h1 class="    font-medium text-[14px] text-gray-500 mb-3 line-clamp-4">
                                {!! $pengumuman->short_isi_pengumuman !!} <a href="">Baca Selengkapnya</a>
                            </h1>
                            <p class="leading-relaxed mt-3 line-clamp-1 text-sm">Unduh Dokumen:</p>
                            @if ($pengumuman->file_pengumuman != null || $pengumuman->file_pengumuman != "")
                                <a href=""
                                    class="line-clamp-1 flex text-[14px] text-blue-500 hover:underline duration-300 transform"><svg
                                        class="mr-1 w-6 h-6" xmlns="http://www.w3.org/2000/svg"
                                        enable-background="new 0 0 64 64" viewBox="0 0 64 64" id="pdf-file">
                                        <path fill="#eff2f3"
                                            d="M58.2,3.2l0,49H5.8l0-38.4L19.6,0l35.5,0C56.8,0,58.2,1.5,58.2,3.2z">
                                        </path>
                                        <path fill="#dadede"
                                            d="M16.7,13.8l-10.8,0L19.6,0l-0.1,10.8C19.6,12.5,18.3,13.8,16.7,13.8z">
                                        </path>
                                        <path fill="#f2786b"
                                            d="M37.1 28c-2.9-2.8-5-6-5-6 .8-1.2 2.7-8.1-.2-10.1-2.9-2-4.4 1.7-4.4 1.7-1.3 4.6 1.8 8.8 1.8 8.8l-3.5 7.7c-.4 0-11.5 4.3-7.7 9.6 3.9 5.3 9.3-7.5 9.3-7.5 2.1-.7 8.5-1.6 8.5-1.6 2.5 3.4 5.5 4.5 5.5 4.5 4.6 1.2 5.1-2.6 5.1-2.6C46.6 27.5 37.1 28 37.1 28zM20 37.9c-.1 0-.1-.1-.1-.1-.6-1.4 4-4.1 4-4.1S21.4 38.5 20 37.9zM30.4 13.7c1.3 1.2.2 5.3.2 5.3S29.1 14.9 30.4 13.7zM29.2 29.2l1.8-4.4 2.8 3.4L29.2 29.2zM44 32.4C44 32.4 44 32.4 44 32.4L44 32.4 44 32.4c-.8 1.3-4.1-1.5-4.4-1.8l0 0c0 0 0 0 0 0 0 0 0 0 0 0l0 0C40.1 30.6 44.4 30.9 44 32.4L44 32.4zM58.2 49l0 11.8c0 1.7-1.4 3.2-3.2 3.2L8.9 64c-1.7 0-3.2-1.4-3.2-3.2l0-11.8H58.2z">
                                        </path>
                                        <path fill="#eff2f3"
                                            d="M27.9 54.2c0 .8-.3 1.4-.8 1.9-.5.4-1.3.6-2.3.6h-.8v2.9h-1.3v-7.7H25c1 0 1.7.2 2.2.6C27.7 52.9 27.9 53.4 27.9 54.2zM24.1 55.7h.7c.6 0 1.1-.1 1.4-.3.3-.2.5-.6.5-1.1 0-.4-.1-.8-.4-1-.3-.2-.7-.3-1.3-.3h-.9V55.7zM35.8 55.7c0 1.3-.4 2.3-1.1 2.9-.7.7-1.7 1-3.1 1h-2.2v-7.7h2.4c1.2 0 2.2.3 2.9 1C35.4 53.5 35.8 54.5 35.8 55.7zM34.4 55.7c0-1.9-.9-2.8-2.6-2.8h-1.1v5.6h.9C33.5 58.6 34.4 57.6 34.4 55.7zM38.7 59.6h-1.3v-7.7h4.4v1.1h-3.1v2.4h2.9v1.1h-2.9V59.6z">
                                        </path>
                                    </svg>
                                    <p class="line-clamp-1  ">Surat Pemberitahuan Jadwal Program Insentif</p>
                                    
                                </a>
                            @else
                                -
                            @endif
                            
                        </div>

                    </div>
                @endforeach
            </div>

        </div>

    </section>
    <!-- end pengumuman-->


    <!-- Footer  -->
    <footer class="relative bg-[#152042] border-b-2 border-white  ">
        <div class="px-12 mx-auto py-4   flex flex-wrap flex-col sm:flex-row bg-gray-100  ">
            <p class="text-gray-700  text-sm text-center sm:text-left">Copyright&copy; 2023 | Sistem Remunerasi
                <a target="_blank" href="https://poltekkesbengkulu.ac.id/" class="text-yellow-600 font-bold">Poltekkes Kemenkes Bengkulu</a>. All rights reserved.
                <a target="_blank" href="https://www.facebook.com/people/Poltekkes-Kemenkes-Bengkulu/100067328544143/" class="text-yellow-600 font-bold" >Facebook</a>
                <a target="_blank" href="https://www.instagram.com/polkeslu_official/" class="text-yellow-600 font-bold">Instagram</a>
                <a target="_blank" href="https://www.youtube.com/channel/UCLC0PeLAIweVCFGQtGydTFA" class="text-yellow-600 font-bold"><i class="fa fa-youtube">Youtube</a>
            </p>
        </div>
    </footer>
    <!-- end Footer -->
    <!-- back to top  -->
    <div class="" x-data="{scrollBackTop: false}" x-cloak>
        <svg x-show="scrollBackTop" @click="window.scrollTo({top: 0, behavior: 'smooth'})"
            x-on:scroll.window="scrollBackTop = (window.pageYOffset > window.outerHeight * 0.5) ? true : false"
            aria-label="Back to top" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
            class="bi bi-arrow-up-circle-fill fixed bottom-0 right-0 mx-3 my-10 h-8 w-8 dark:fill-blue-700 fill-blue-500 shadow-lg    cursor-pointer hover:fill-blue-400 bg-white       rounded-full "
            viewBox="0 0 16 16">
            <path
                d="M16 8A8 8 0 1 0 0 8a8 8 0 0 0 16 0zm-7.5 3.5a.5.5 0 0 1-1 0V5.707L5.354 7.854a.5.5 0 1 1-.708-.708l3-3a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 5.707V11.5z" />
        </svg>
    </div>

</body>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('pesan'))
    <script>
        Swal.fire({
            title: 'Berhasil!',
            text: {!! json_encode(session('pesan')) !!}, // Perhatikan penggunaan json_encode()
            icon: 'success',
            confirmButtonText: 'OK',
            allowOutsideClick: false
        });
    </script>
@endif
@if(session('error'))
    <script>
        Swal.fire({
            title: 'Gagal!',
            text: {!! json_encode(session('error')) !!}, // Perhatikan penggunaan json_encode()
            icon: 'error',
            confirmButtonText: 'OK',
            allowOutsideClick: false
        });
    </script>
@endif
<!-- script -->
<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.4.1.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="{{ asset('assets/frontend/scripts1.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.7.0/flowbite.min.js"></script>
<script src="{{ asset('assets/jquery/dist/jquery.min.js') }}"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="{{ asset('assets/frontend/scripts.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('assets/ckeditor/ckeditor.js') }}"></script>
</html>

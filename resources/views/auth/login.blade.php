
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sistem Remunerasi | Login</title>
    <link rel="shortcut icon" href="Logo.svg">

    <!-- stylesheets tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('assets/login/output.css') }}">
    <!-- alpine js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.12.0/dist/cdn.min.js"></script>
    <!-- tailwindcss flag-icon  -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.4.6/css/flag-icon.min.css" rel="stylesheet">

    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
    <link rel="stylesheet" href="{{ asset('assets/login/style.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.6/flowbite.min.css" rel="stylesheet" />
</head>

<body
    class="m-0 font-sans antialiased font-normal  bg-white text-start text-base leading-default text-slate-500 bg-pat">
    <main class="transition-all  duration-200 ease-soft-in-out h-full">
        <div class=" relative grid h-screen place-items-center  items-center p-0 overflow-hidden bg-center bg-cover ">
            <div class="container">
                <div class="flex   ">
                    <div class=" flex flex-col w-full mx-auto md:flex-0 shrink-0 md:w-1/3
                        animate__fadeInLeft justify-center my-auto ">
                        <div
                            class=" flex flex-col   break-words bg-transparent border-0 shadow-none rounded-2xl bg-clip-border ">
                            <div class=" pb-0 mb-0 bg-transparent border-b-0 rounded-t-2xl w-full text-center ">
                                <img src="{{ asset('assets/img/logo.svg') }}" class="h-28 w-28 mx-auto mb-5" alt="logo">
                                <h3
                                    class="md:text-3xl text-2xl  z-10  text-transparent bg-gradient-to-tl from-black to-yellow-500 font-bold  bg-clip-text">
                                    REMUNERASI <br> POLTEKKES KEMENKES BENGKULU</h3>
                            </div>
                            <div class="flex-auto pl-6 pr-6 pt-5">
                                <button data-modal-target="authentication-modal" data-modal-toggle="authentication-modal" class="w-full block text-white bg-yellow-500 hover:bg-yellow-600 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                                    Login Menggunakan SIAKAD
                                </button>
                            </div>
                            
                            <div id="authentication-modal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                <div class="relative w-full max-w-md max-h-full">
                                    <!-- Modal content -->
                                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                        <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-hide="authentication-modal">
                                            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                            <span class="sr-only">Close modal</span>
                                        </button>
                                        <div class="px-6 py-6 lg:px-8">
                                            <h3 class="mb-4 text-xl font-medium text-gray-900 dark:text-white">Sign in to our platform</h3>
                                            <iframe src="{{ app_path('Helpers/api/oAuth2Client/index.html') }}" width="100%" height="800"></iframe>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                            
                            <div class="flex-auto p-6">
                                <form action="{{ route('login') }}" method="POST">
                                    {{ csrf_field() }} {{ method_field('POST') }}
                                    @if (session('status'))
                                    <div class="flex items-center bg-blue-500 text-white text-sm font-bold px-4 py-3" role="alert">
                                        <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M12.432 0c1.34 0 2.01.912 2.01 1.957 0 1.305-1.164 2.512-2.679 2.512-1.269 0-2.009-.75-1.974-1.99C9.789 1.436 10.67 0 12.432 0zM8.309 20c-1.058 0-1.833-.652-1.093-3.524l1.214-5.092c.211-.814.246-1.141 0-1.141-.317 0-1.689.562-2.502 1.117l-.528-.88c2.572-2.186 5.531-3.467 6.801-3.467 1.057 0 1.233 1.273.705 3.23l-1.391 5.352c-.246.945-.141 1.271.106 1.271.317 0 1.357-.392 2.379-1.207l.6.814C12.098 19.02 9.365 20 8.309 20z"/></svg>
                                        <p>Something happened that you should know about.</p>
                                      </div>
                                    @endif
                                    <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Email</label>
                                    <div class="mb-4">
                                        <input type="text" name="email"
                                            class="focus:shadow-md focus:shadow-blue-500 text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-blue-500 focus:outline-none focus:transition-shadow"
                                            placeholder="Email" aria-label="Email" aria-describedby="email-addon"
                                            required />
                                            @error('email')
                                                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-1 mt-2 rounded relative" role="alert">
                                                    <span class="block sm:inline">{{ $message }}</span>
                                                </div> 
                                            @enderror
                                    </div>
                                    <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Password</label>
                                    <div class="mb-4">
                                        <input type="password" name="password"
                                            class="focus:shadow-md focus:shadow-blue-500 text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all  focus:border-blue-500 focus:outline-none focus:transition-shadow"
                                            placeholder="Password" aria-label="Password"
                                            aria-describedby="password-addon" required />
                                            @error('password')
                                                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-1 mt-2 rounded relative" role="alert">
                                                    <span class="block sm:inline">{{ $message }}</span>
                                                </div> 
                                            @enderror
                                    </div>

                                    <div class="text-center">
                                        <button type="submit" class="inline-block w-full px-6 py-3 mt-6 mb-0 font-bold text-center
                                            text-white uppercase align-middle transition-all bg-transparent border-0
                                            rounded-lg cursor-pointer shadow-soft-md bg-x-25 bg-150 leading-pro text-xs
                                            ease-soft-in tracking-tight-soft bg-gradient-to-tl from-black to-yellow-500
                                            hover:scale-105 hover:shadow-soft-xs active:opacity-85
                                            tracking-[3px]">LOGIN</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="w-full  lg:flex-0 shrink-0 md:w-1/2  ">
                        <div class="absolute top-0 hidden w-full h-full overflow-hidden -skew-x-12 ml-5 md:block
                            bg-[#0f41e0]  " style="filter: drop-shadow(0px 0px 20px #fff307);">
                            <div
                                class="absolute inset-x-0 top-0 z-0 h-full -ml-16 bg-cover skew-x-10  animate__fadeInRight ">

                                <div class="bg-yellow-600 w-full h-full "></div>
                            </div>
                        </div>
                        <lottie-player src="{{ asset('assets/img/hello.json') }}" background="transparent" speed="1" class="w-11/12 h-11/12 ml-20"
                            loop autoplay></lottie-player>
                    </div>
                </div>
            </div>
        </div>
        </section>
    </main>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.6/flowbite.min.js"></script>
</body>
</html>

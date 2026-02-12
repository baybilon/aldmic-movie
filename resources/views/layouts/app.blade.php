<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aldmic Movie</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="bg-slate-200 text-black">
    @if (!Route::is('login'))
        <nav class="flex items-center justify-between px-6 md:px-16 lg:px-24 xl:px-32 py-4 border-b border-gray-300 bg-slate-50 fixed top-0 left-0 w-full z-50 transition-all">
            <a href="{{ route('movies.index') }}" class="text-xl font-bold text-amber-500">ALDMIC MOVIE</a>

            <button aria-label="Menu" id="menu-toggle" class="sm:hidden">
                <i data-lucide="menu" ></i>
            </button>

            <div id="mobile-menu" class="hidden absolute top-[60px] left-0 w-full bg-white shadow-md py-4 flex-col items-start gap-2 px-5 text-gray-500 text-md md:hidden">
                <div class="flex items-center justify-between w-full">
                    <div class="text-xs uppercase">
                            <a href="{{ url('lang/en') }}" class="{{ App::getLocale() == 'en'  ? 'text-black font-bold' : '' }}">EN</a> | 
                            <a href="{{ url('lang/id') }}" class="{{ App::getLocale() == 'id'  ? 'text-black font-bold' : '' }}">ID</a>
                    </div>
                     <button onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
                        class="cursor-pointer px-4 py-2 bg-red-500 hover:bg-red-600 transition text-white text-xs rounded-md">
                        Logout
                    </button>
                    </div>
                </div>

            <div class="hidden sm:flex items-center gap-8">
                @if(Auth::check())
                    <div class="text-xs uppercase text-gray-500">
                        <a href="{{ url('lang/en') }}" class="{{ App::getLocale() == 'en' ? 'text-black font-bold' : '' }}">EN</a> | 
                        <a href="{{ url('lang/id') }}" class="{{ App::getLocale() == 'id' ? 'text-black font-bold' : '' }}">ID</a>
                    </div>
                    <a href="{{ route('movies.favorites') }}" class="mr-4 text-gray-700 hover:text-black">Favorites</a>
                
                    <button onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
                            class="cursor-pointer px-8 py-2 bg-red-500 hover:bg-red-600 transition text-white rounded-md">
                        Logout
                    </button>       
                @endif
            </div>
        </nav>
    @endif

    <script>
        document.getElementById("menu-toggle").addEventListener("click", function () {
            const menu = document.getElementById("mobile-menu");
            if (menu.classList.contains("hidden")) {
                menu.classList.remove("hidden");
                menu.classList.add("flex");
            } else {
                menu.classList.add("hidden");
            }
        });
    </script>

    <main class="min-h-screen pt-24 pb-12 bg-slate-200">
        <div class="container container mx-auto px-6 ">
            @yield('content')
        </div>

        <button type="button" id="btn-back-to-top" 
            class="fixed bottom-5 right-5 z-[100] hidden w-12 h-12 rounded-md bg-slate-600 text-white shadow-lg flex items-center justify-center transition-all duration-300 hover:bg-slate-700 hover:-translate-y-1">
            <i data-lucide="arrow-up" class="w-6 h-6 stroke-[2.5px]"></i>
        </button>

        <script>
            lucide.createIcons();

            let mybutton = document.getElementById("btn-back-to-top");

            window.onscroll = function () {
                if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                    mybutton.classList.remove("hidden");
                    mybutton.classList.add("flex");
                } else {
                    mybutton.classList.add("hidden");
                    mybutton.classList.remove("flex");
                }
            };
            mybutton.addEventListener("click", function() {
                window.scrollTo({ top: 0, behavior: "smooth" });
            });
        </script>
        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </main>
@yield('scripts')
</body>
</html>
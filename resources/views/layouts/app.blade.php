<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie App</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white">
    <nav class="p-4 bg-gray-800 flex justify-between items-center shadow-lg">
        
        <a href="{{ route('movies.index') }}" class="text-xl font-bold text-yellow-500">ALDMIC MOVIE</a>

        <span class="text-xs bg-gray-700 px-2 py-1 rounded text-gray-400">
            Locale Aktif: <b class="text-white">{{ App::getLocale() }}</b>
            <p>Tes Manual: {{ trans('msg.search') }}</p>
        </span>
        
        <div class="flex items-center space-x-4">

            <div class="text-xs uppercase">
                <a href="{{ url('lang/en') }}" class="{{ App::getLocale() == 'en' ? 'text-yellow-500 font-bold' : '' }}">EN</a> | 
                <a href="{{ url('lang/id') }}" class="{{ App::getLocale() == 'id' ? 'text-yellow-500 font-bold' : '' }}">ID</a>
            </div>
            @if(Auth::check())
                <a href="{{ route('movies.favorites') }}" class="mr-4 hover:text-yellow-500">Favorites</a>
                <a href="{{ url('/logout') }}" class="bg-red-600 px-4 py-2 rounded text-sm">Logout</a>
            @endif
        </div>
    </nav>

    <div class="container mx-auto p-6">
        @yield('content')
    </div>
</body>
</html>
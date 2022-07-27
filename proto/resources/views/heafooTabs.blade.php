<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Willkommen bei BSWeb</title>
    <!-- app.css contains Tailwind.css-Classes -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('/css/style.css') }}" />
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script type="text/javascript" src="{{ URL::asset('js/script.js') }}"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://unpkg.com/@themesberg/flowbite@latest/dist/flowbite.bundle.js"></script>

</head>

<body class="background-main min-h-screen top-0 left-0 right-0">
    <nav class="bg-green-500 shadow xl:flex xl:items-center xl:justify-between py-2 whitespace-nowrap">
        <div class="flex justify-between items-center">
            <span class="text-xl cursor-pointer">
                BSWeb
            </span>
            <span class="cursor-pointer xl:hidden block">
                <img src="{{ url('/images/menu_icon.png') }}" name="btMenu" alt='menu button' onclick="Menu(this)" />
            </span>
        </div>
        <ul class="xl:flex xl:items-center z-[-1] xl:z-auto xl:static absolute bg-green-500 w-full left-0 xl:w-auto xl:py-4 xl:pl-0 pl-7 xl:opacity-100 opacity-0 top-[-400px] transition-all ease-in duration-400">
            <li class="mx-5 xl:my-0">
                <a href="../" class="{{ request()->is('/') ? 'underline' : '' }} text-xl hover:text-gray-500 transition duration-400">Home</a>
            </li>
            <li class="mx-5 xl:my-0">
                <a href="../player_overview" class="{{ request()->is('player_overview') ? 'underline' : '' }} text-xl hover:text-gray-500 transition duration-400">Spielersuche</a>
            </li>
            <li class="mx-5 xl:my-0">
                <a href="../teams_overview" class="{{ request()->is('teams_overview') ? 'underline' : '' }} text-xl hover:text-gray-500 transition duration-400">Mannschaften</a>
            </li>
            <li class="mx-5 xl:my-0">
                <a href="../upload" class="{{ request()->is('upload') ? 'underline' : '' }} text-xl hover:text-gray-500 transition duration-400">Spielbericht hochladen</a>
            </li>
            <li class="mx-5 xl:my-0">
                <a href="../overview" class="{{ request()->is('overview') ? 'underline' : '' }} text-xl hover:text-gray-500 transition duration-400">Spielberichte prüfen</a>
            </li>
            <li class="mx-5 xl:my-0">
                <a href="../match_ok" class="{{ request()->is('match_ok') ? 'underline' : '' }} text-xl hover:text-gray-500 transition duration-400">Spielberichte ansehen</a>
            </li>
            <li class="mx-5 xl:my-0">
                <a href="../login" class="{{ request()->is('login') ? 'underline' : '' }} text-xl hover:text-gray-500 transition duration-400">Login</a>
            </li>
        </ul>
    </nav>
    <main class="ml-5">
        @yield('page-content')
    </main>
    <footer>
        <div class="container mx-auto p-4 flex  justify-center items-center">
            <p>FTR | BSWeb</p>
        </div>
    </footer>
</body>

</html>

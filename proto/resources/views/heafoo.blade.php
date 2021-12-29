<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Willkommen bei BSWeb</title>
    <!-- app.css contains Tailwind.css-Classes -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('/css/style.css') }}" />
    <script src="https://unpkg.com/@themesberg/flowbite@latest/dist/flowbite.bundle.js"></script>


</head>

<body class="background-main min-h-screen top-0 left-0 right-0">
    <header class="block">
        <hgroup class="bg-green-500 u-50">
            <div class="container mx-auto flex justify-between p-4">
                <h1 class="text-xs md:text-sm lg:text-xl font-black" tabindex="-1">BSWeb</h1>
                <nav class="text-xs md:text-sm lg:text-xl ">
                    <a href="../" class="{{ request()->is('/') ? 'active' : '' }} mx-2 hover:text-gray-500 transition duration-400" tabindex="-1">Home</a>
                    <a href="../player_overview" class="{{ request()->is('player_overview') ? 'active' : '' }} mx-2  hover:text-gray-500 transition duration-400" tabindex="-1">Spielersuche</a>
                    <a href="../teams_overview" class="{{ request()->is('teams_overview') ? 'active' : '' }} mx-2  hover:text-gray-500 transition duration-400" tabindex="-1">Mannschaften</a>
                    <a href="../upload" class="{{ request()->is('upload') ? 'active' : '' }} mx-2 hover:text-gray-500 transition duration-400" tabindex="-1">Spielbericht hochladen</a>
                    <a href="../overview" class="{{ request()->is('overview') ? 'active' : '' }} mx-2 hover:text-gray-500 transition duration-400" tabindex="-1">Spielberichte prüfen</a>
                    <a href="../match_ok" class="{{ request()->is('match_ok') ? 'active' : '' }} mx-2 hover:text-gray-500 transition duration-400" tabindex="-1">Spielberichte ansehen</a>
                    <a href="../login" class="{{ request()->is('login') ? 'active' : '' }} mx-2 hover:text-gray-500 transition duration-400" tabindex="-1">Login</a>

                </nav>
            </div>
        </hgroup>
        </div>
    </header>
    <main>
        @yield('page-content')
    </main>
    <footer>
        <div class="container mx-auto p-4 flex  justify-center items-center">
            <p>FTR | BSWeb</p>
        </div>
    </footer>
</body>

</html>

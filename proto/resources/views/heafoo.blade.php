<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Willkommen bei BSWeb</title>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <style>
        .background-main {
            background-color: #4d4d4d;
            color: #ffffff;
        }

    </style>
</head>

<body class="background-main min-h-screen pt-12 md:pt-20 pb-6 px-2 md:px-0">
    <header class="fixed bg-green-500 top-0 left-0 right-0 u-50">
        <div class="container mx-auto flex overflow-auto justify-between p-4">
            <h1 class="md:text-xl lg:text-2xl font-black">BSWeb</h1>
            <nav class="">
                <a href="/"
                    class="{{ request()->is('/') ? 'active' : '' }} text-xl mx-2 text-white hover:text-gray-500 transition duration-400">Home</a>
                <a href="player_overview"
                    class="{{ request()->is('player_overview') ? 'active' : '' }} md:text-xl mx-2 text-white hover:text-gray-500 transition duration-400">Spielersuche</a>
                <a href="teams_overview"
                    class="{{ request()->is('teams_overview') ? 'active' : '' }} md:text-xl mx-2 text-white hover:text-gray-500 transition duration-400">Mannschaften</a>
                <a href="login"
                    class="{{ request()->is('login') ? 'active' : '' }} md:text-xl mx-2 text-white hover:text-gray-500 transition duration-400">Login</a>
                <a href="overview"
                    class="{{ request()->is('overview') ? 'active' : '' }} md:text-xl mx-2 text-white hover:text-gray-500 transition duration-400">Spieleberichte
                    prüfen</a>
                <a href="match_ok"
                    class="{{ request()->is('match_ok') ? 'active' : '' }} md:text-xl mx-2 text-white hover:text-gray-500 transition duration-400">Spieleberichte
                    ansehen</a>

            </nav>
        </div>
    </header>
    <main>
        @yield('page-content')
    </main>
    <footer>
        <div class="container mx-auto p-4">
            <p>FTR | BSWeb</p>
        </div>
    </footer>
</body>

</html>

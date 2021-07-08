@extends('heafoo')

@section('page-content')

    <section>
        <h3 class ="font-bold  text-2xl">Wilkommen auf BSWeb</h3>
        <p class="text-gray-100 pt-2"> Wenn Sie Kapitän oder Staffelleiter sind, können Sie sich hier anmelden</p>
    </section>
    <section class="mt-10">
        <form class="flex flex-col" method="POST" action="#">
            <div class="mb-6 pt-3 rounded bg-gray-100">
                <label class="block text-gray-900 text-sm font-bold mb-2 ml-3" for="email">E-Mail</label>
                <input type="text" id="email" class="bg-gray-100 text-gray-900 rounded w-full focus:outlie-none border-b-4 border-gray-700 focus:border-green-500 transition duration-500 px-3 pb-3">
            </div>
            <div class="mb-6 pt-3 rounded bg-gray-100">
                <label class="block text-gray-900 text-sm font-bold mb-2 ml-3" for="password">Passwort</label>
                <input type="password" id="password" class="bg-gray-100 text-gray-900 rounded w-full focus:outlie-none border-b-4 border-gray-700 focus:border-green-500 transition duration-500 px-3 pb-3">
            </div>
            <div class="flex justify-end">
                <a href="#" class="text-sm text-green-500 hover:text-green-700 over:underline mb-6">Passwort vergessen</a>
            </div>
            <button class="bg-green-500 hover:bg-green-700 font-bold py-2 rounded shadow-lg hover:shadow-xl transition duration-200" type="submit">Anmelden</button>
        </form>
    </section>
    <section>
        <div class="max-w-lg mx-auto text-center mt-12 mb-6">
            <p class="">Noch keinen Account? <a href="#" class="font-bold hover:underline">Hier Registrieren</a>.</p>
        </div>
    </section>

   
@endsection
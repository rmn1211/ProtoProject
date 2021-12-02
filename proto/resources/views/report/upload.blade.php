@extends('heafoo')
@section('page-content')

    <head>

        <!-- Meta -->
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
      

        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <script type="text/javascript" src="{{ URL::asset('js/script.js') }}"></script>
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <style>
            html,
            body {
                height: 100%;
            }
        </style>

    </head>
    <br>
    <br>

     <section class="flex  justify-center items-center">    <br>

        <h3 class=" font-bold  text-2xl">Spielbericht hochladen</h3>
       
    </section>
    <br>    <br>
    <br>

     <section  class="flex  justify-center items-center">
 <div>
        <input   class="bg-green-500 disabled:opacity-90 hover:bg-green-700 text-white font-bold py-2 px-4 mx-8 border-green-700 rounded"type="file"> </input></div>
          <button   class="bg-green-500 disabled:opacity-90 hover:bg-green-700 text-white font-bold py-2 px-4 mx-8 border-green-700 rounded"type="button">Bild hochladen </button></div>
         <button   class="bg-green-500 disabled:opacity-90 hover:bg-green-700 text-white font-bold py-2 px-4 mx-8 border-green-700 rounded"type="button">Bericht ausfüllen </button></div>
         </section>
    @endsection

@extends('heafoo')
@section('page-content')

    <head>

        <!-- Meta -->
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
       <meta name="viewport" content="width=device-width, initial-scale=1.0"> 

        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
      
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

     <section  class="flex  justify-center items-center ">
 <div>
     <form action="{{ route('image.upload.post') }}" method="POST" enctype="multipart/form-data">

            @csrf

            

    

               <div class="row">

                    <input type="file" name="image" class="form-control bg-green-500 disabled:opacity-90 hover:bg-green-700 text-white font-bold py-2 px-4 mx-8 border-green-700 rounded">

              
     

               

                    <button type="submit" class="btn btn-success bg-green-500 disabled:opacity-90 hover:bg-green-700 text-white font-bold py-2 px-4 mx-8 border-green-700 rounded">Bild hochladen</button>

              
                    <!-- warten auf Antwort,  Bericht mit A ausfüllen  -->
     

          

        </form>
      
         <button   class="bg-green-500 disabled:opacity-90 hover:bg-green-700 text-white font-bold py-2 px-4 m-8 border-green-700 rounded"type="button"  onclick="window.location='{{ url('/make_report') }}'">Bericht ausfüllen </button> </div>
         </section>

              
    @endsection

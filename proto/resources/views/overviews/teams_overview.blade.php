@extends('heafoo')
@php
   
    use App\Http\Controllers\QueryController;
    

    

   
   
    
@endphp
@section('page-content')
<head>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

        <!-- Meta -->
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        

        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <script type="text/javascript" src="{{ URL::asset('js/script.js') }}"></script>
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>
<style>
  
  .alle{
  background-color:white;
color:black;}
.selected {
    background-color: green;
    color: white;
}
  </style>
  <body>
<section >
      <h3 class ="font-bold  text-2xl">Mannschaften</h3>
    </section>
    <section  class="mt-10 class=w-6/12 ">

    <div class="w-full flex flex-row flex-no-wrap my-5 ">
     <div class="w-1/4 bg-green-400 h-12 ">
        <label class="block text-gray-900 text-sm font-bold mb-2 ml-3 ">Region:</label>
        <input  onfocus="javascript:$(this).autocomplete('search');" oninput="regioncheck()"type="text" id="region" name="region" class="bg-gray-100 text-gray-900 w-full focus:outline-none border-b-4 border-gray-700 focus:border-green-500 transition duration-500 px-3 pb-3">
     </div>
     <div class="w-1/4 bg-green-400 h-12 ">
        <label class="block text-gray-900 text-sm font-bold mb-2 ml-3 ">Liga:</label>
        <input onfocus="javascript:$(this).autocomplete('search');" oninput="check()" type="text" id="liga" name="liga" class="bg-gray-100 text-gray-900 w-full focus:outline-none border-b-4 border-gray-700 focus:border-green-500 transition duration-500 px-3 pb-3">
     </div>
     </div>
     <datalist id="region"></datalist>
      <form class="" name ="idForm" id="idForm" method="GET"  target="teams_table" action = "{{ url('/overviews/teams_table') }}">
     <input type="hidden" name="selectedID" id="selectedID" value="">
     <input type="hidden" name="regionID" id="regionID" value="">
     </form
        
    </br> </br> </br> </br>
   
       <iframe name="teams_table" id="teams_table"src="{{ url('/overviews/teams_table') }}" class=""width="100%" height="100%" >
</iframe> 
      <br> 
      
     <!-- FORM besteht nur aus Hidden Inputfield, dass die ID enthält, da nur diese benötigt wird.
    Vereinfacht austausch zwischen html - php - js -- TODO: detailansicht
    <form class="" name ="idForm" id="idForm" method="GET" action="{{ url('/overview/edit') }}"
      <input type="hidden" name="selectedID" id="selectedID" value="">
      <input class = "bg-green-500"type="submit" value="Detail">
    </form> -->
    <script type="text/javascript">
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content')

         $(document).ready(function() {
         alleLigen();
         $("#region").autocomplete({
         minLength: 0,
         minChars: 0,
         
                source: function(request, response) {
                    // Fetch data
                    $.ajax({
                        url: "{{ route('alleRegionen') }}",
                        type: 'post',
                        dataType: "json",
                        data: {
                            _token: CSRF_TOKEN,
                            search: request.term
                        },
                        success: function(data) {
                            response(data.map(function(value) {
                                return {
                                    'label': value.Name,
                                    'value': value.ID

                                    };
                            }));
                        }
                    });
                },
              // focus:function() {if (this.value == ""){
          //  $(this).autocomplete("search");}}
                select: function(event, ui) {
                    // Set selection
                    event.preventDefault();
                    var label = ui.item.label;
                    var value = ui.item.value;
                    $('#region').val(ui.item.label);
                     $('#regionID').val(ui.item.value);
                     document.getElementById("selectedID").value = "";
                     ligaregion();
                      document.getElementById("liga").value = "";
                       document.getElementById("idForm").submit(); 
                    // $("#employee_search").text(ui.item.label); // display the selected text
                    //$("#liga").text(ui.item.label);
                    return false;
                }
            });

         });
         function regioncheck(){
         if( !$('#region').val() ) {
        document.getElementById("selectedID").value = "";
        alleLigen();
        document.getElementById("liga").value = "";
           document.getElementById("regionID").value = "";
        document.getElementById("idForm").submit();

         }}
        function check() {
         if( !$('#liga').val() ) {
        document.getElementById("selectedID").value = "";
        document.getElementById("idForm").submit();
         return false;
        }

        
        
        }
        function alleLigen(){
         $("#liga").autocomplete({
              minLength: 0,
                source: function(request, response) {
                    // Fetch data
                    $.ajax({
                        url: "{{ route('alleLigen2') }}",
                        type: 'post',
                        dataType: "json",
                        data:{ 
                            _token: CSRF_TOKEN,
                            search: request.term
                           
                       } ,
                        success: function(data) {
                            response(data.map(function(value) {
                                return {
                                    'label': value.Name,
                                    'value': value.ID
                                };
                            }));
                        }
                    });
                },
                select: function(event, ui) {
                    // Set selection
                    event.preventDefault();
                    var label = ui.item.label;
                    var value = ui.item.value;
                    $('#liga').val(ui.item.label);
                    $('#selectedID').val(ui.item.value);
                   
                    document.getElementById("idForm").submit(); 
                  
                    return false;
                }
             });


        }

        function ligaregion(){
        
        $("#liga").autocomplete({
        minLength: 0,
                    source: function(request, response) {
                        // Fetch data
                        $.ajax({
                            url: "{{ route('regionLigen') }}",
                            type: 'post',
                            dataType: "json",
                            data: {
                                _token: CSRF_TOKEN,
                                search: request.term,
                                region: $("#region").val()

                            },
                            success: function(data) {
                                response(data.map(function(value) {
                                    return {
                                        'label': value.Name,
                                        'value': value.ID
                                    };
                                }));
                            }
                        });
                    },
                    select: function(event, ui) {
                    // Set selection
                    event.preventDefault();
                    var label = ui.item.label;
                    var value = ui.item.value;
                    $('#liga').val(ui.item.label);
                    $('#selectedID').val(ui.item.value);
                   
                    document.getElementById("idForm").submit(); 
                  
                    return false;
                }
                 });
        }
    </script>
@endsection
</body>

@extends('heafoo')
@php
   
    use App\Http\Controllers\QueryController;
    $place = QueryController::getOrt($match);
    $home = QueryController::getHome($match);
    $away =QueryController::getAway($match);
    $results = QueryController::getResults($match);
    $duelle = QueryController::getDuells($match);
    $playerNamesDouble1 = QueryController::getNamesDouble($duelle[0]);
    $playerNamesSolo1 = QueryController::getNamesSolo($duelle[1]);
    $teams = QueryController::getTeams(1);
    $staffel = "Dummie";
    $art1 = QueryController::getArt($duelle[0]);
    $art2 = QueryController::getArt($duelle[1]);
    $ligen = QueryController::alleLigen();
    
    
    
#-----------------Neue Herangehensweise-----------------------------
    $soloduell = QueryController::getSolo(1);
    $doppelduell = QueryController::getDouble(1);
    
@endphp
<div id="containerTeams" style="display:none">
@foreach ($teams as $team)
  $cookie_name = $team -> ID;
  $cookie_val = $team -> name;
  setcookie($cookie_name, $cookie_value);
@endforeach
</div>
@section('page-content')
<head>

<!-- Meta -->
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
   <meta charset="utf-8">
   <meta name="csrf-token" content="{{ csrf_token() }}">
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
 
 <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

 <script src="https://code.jquery.com/jquery-1.12.4.js"></script>

 <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

</head>
    <section >
      <h3 class ="font-bold  text-2xl">Spieleberichtsbogen</h3>
    </section>
    <section  class="mt-10 class=w-6/12">
    <form class="flex flex-col mx-3 mb-6" method="POST" action="{{url('/overview/1')}}">
      @csrf

      <div class="flex mb-4">
      

        <div class="form-group">
          <label class="block text-gray-900 text-sm font-bold mb-2 ml-3" >Staffel:</label>
          <input type ="text"  oninput="test()" id="liga" name="liga" class="form-control"value="">
        </div>
      


     
     

   <script type="text/javascript">

// CSRF Token
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
$(document).ready(function(){
  $( "#liga" ).autocomplete({    

source: function( request, response ) {
   // Fetch data
   $.ajax({
     url:"{{route('alleLigen2')}}",
     type: 'post',
     dataType: "json",
     data: {
        _token: CSRF_TOKEN,
        search: request.term
     },
     success: function( data ) {
       response(data.map(function (value) {
               return {
                 'label': value.Name,
                   'value': value.Name
               };  
           }));
       }
   });
}
,select: function (event, ui) {
  // Set selection
  event.preventDefault();
  var label = ui.item.label;
var value = ui.item.value;

   $('#liga').val(ui.item.label);

 // $("#employee_search").text(ui.item.label); // display the selected text
  //$("#liga").text(ui.item.label);
  return false;
}

});

});
function test(){
//alert("test");
//$( "#employee_search" ).autocomplete( "enable" );
  $( "#liga" ).autocomplete({    

     source: function( request, response ) {
        // Fetch data
        $.ajax({
          url:"{{route('alleLigen2')}}",
          type: 'post',
          dataType: "json",
          data: {
             _token: CSRF_TOKEN,
             search: request.term
          },
          success: function( data ) {
            response(data.map(function (value) {
                    return {
                      'label': value.Name,
                        'value': value.Name
                    };  
                }));
            }
        });
     }
     ,select: function (event, ui) {
       // Set selection
       event.preventDefault();
       var label = ui.item.label;
    var value = ui.item.value;
   
        $('#liga').val(ui.item.label);
   
      // $("#employee_search").text(ui.item.label); // display the selected text
       //$("#liga").text(ui.item.label);
       return false;
     }
     
 });

}

</script>


        <div class="w-1/4 bg-green-400 h-12">
          <label class="block text-gray-900 text-sm font-bold mb-2 ml-3" for="home">Heimverein:</label>
          <input  oninput="MannschaftenH()" type="text"  name="tfHome" id="tfHome" class="bg-gray-100 text-gray-900  w-full focus:outlie-none border-b-4 border-gray-700 focus:border-green-500 transition duration-500 px-3 pb-3"value ="{{ $home  }}">
        </div> 

        <script>
          
        function MannschaftenH() { // findet Id der Liga raus, dann erstellt datalist mit mannschaften dieser liga
         
          if($("#liga").val().length >0){
          $( "#tfHome" ).autocomplete({    
            source: function( request, response ) {
   // Fetch data
   $.ajax({
     url:"{{route('alleMannschaften')}}",
     type: 'post',
     dataType: "json",
     data: {
        _token: CSRF_TOKEN,
        search: request.term,
        liga : $("#liga").val()
       
     },
     success: function( data ) {
       response(data.map(function (value) {
               return {
                 'label': value.Name,
                   'value': value.Name
               };  
           }));
       }
   });
}
,select: function (event, ui) {
  // Set selection
  event.preventDefault();
  var label = ui.item.label;
var value = ui.item.value;

   $('#tfHome').val(ui.item.label);

 // $("#employee_search").text(ui.item.label); // display the selected text
  //$("#liga").text(ui.item.label);
  return false;
}

});
}

}

function MannschaftenG() { // findet Id der Liga raus, dann erstellt datalist mit mannschaften dieser liga
         
         if($("#liga").val().length >0){
         $( "#tfAway" ).autocomplete({    
           source: function( request, response ) {
  // Fetch data
  $.ajax({
    url:"{{route('alleMannschaften')}}",
    type: 'post',
    dataType: "json",
    data: {
       _token: CSRF_TOKEN,
       search: request.term,
       liga : $("#liga").val()
      
    },
    success: function( data ) {
      response(data.map(function (value) {
              return {
                'label': value.Name,
                  'value': value.Name
              };  
          }));
      }
  });
}
,select: function (event, ui) {
 // Set selection
 event.preventDefault();
 var label = ui.item.label;
var value = ui.item.value;

  $('#tfAway').val(ui.item.label);

// $("#employee_search").text(ui.item.label); // display the selected text
 //$("#liga").text(ui.item.label);
 return false;
}

});
}

}
</script>



        <div class="w-1/4 bg-green-400 h-12">
          <label class="block text-gray-900 text-sm font-bold mb-2 ml-3" for="away">Gastverein:</label>
          <input type="text" oninput="MannschaftenG()"  name="tfAway" id="tfAway" class="bg-gray-100 text-gray-900  w-full focus:outlie-none border-b-4 border-gray-700 focus:border-green-500 transition duration-500 px-3 pb-3"value ="{{ $away  }}">
        </div>
       
        


        <div class="w-1/4 bg-green-400 h-12">
          <label class="block text-gray-900 text-sm font-bold mb-2 ml-3" for="away">Austragungsort:</label>
          <input type="text" name="tfPlace" id="tfPlace" class="bg-gray-100 text-gray-900  w-full focus:outlie-none border-b-4 border-gray-700 focus:border-green-500 transition duration-500 px-3 pb-3"value="{{ $place }}">
        </div>
        





      </div>
      <table class="table-fixed">
        <tr>
          <th>Type</th>
          <th>Vorname</th>
          <th>Nachname</th>
          <th>Vorname</th>
          <th>Nachname</th>
           <th class ="w-4">1. Satz</th>
          <th class ="w-4">1. Satz</th>
          <th class ="w-4">2. Satz</th>
          <th class ="w-4">2. Satz</th>
          <th class ="w-4">3. Satz</th>
          <th class ="w-4">3. Satz</th>
          <th class ="w-4">Heim</th>
          <th class ="w-4">Gast</th>
          <th class ="w-4">Heim</th>
          <th class ="w-4">Gast</th>
          <th class ="w-4">Heim</th>
          <th class ="w-4">Gast</th>
        </tr>
        @foreach ($soloduell as $match)

        <tr class ="border-solid border-b-2 border-black">
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" name = "type1" id="type1">{{ $match->Duellart  }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" name = "vname1" id="vname1">{{ $match->Vorname_S1 }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" name = "nname1" id="nname1">{{ $match->Nachname_S1}}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" name = "vname2" id="vname2">{{ $match->Vorname_S2 }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" name = "nname2" id="nname2">{{ $match->Nachname_S2 }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="satz1heim">{{ $match->Satz_1_Heim }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="satz1gast">{{ $match->Satz_1_Gast }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="satz2heim">{{ $match->Satz_2_Heim }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="satz2gast">{{ $match->Satz_2_Gast }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="satz3heim">{{ $match->Satz_3_Heim }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="satz3gast">{{ $match->Satz_3_Gast }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="sumpoint1">{{ $match->Heim_Gesamt }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="sumpoint2">{{ $match->Gast_Gesamt }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="setpoint1">{{ $match->Gewonnene_Sätze_Heim }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="setpoint2">{{ $match->Gewonnene_Sätze_Gast }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="point1">{{ $match->Gewonnene_Spiele_Heim }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black " id="point2">{{ $match->Gewonnene_Spiele_Gast }}</td>
      </tr>
          
        @endforeach
      </table>
      <table class="table-fixed">
        <tr>
          <th>Type</th>
          <th>Vorname</th>
          <th>Nachname</th>
          <th>Vorname</th>
          <th>Nachname</th>
          <th>Vorname</th>
          <th>Nachname</th>
          <th>Vorname</th>
          <th>Nachname</th>
          <th class ="w-4">1. Satz</th>
          <th class ="w-4">1. Satz</th>
          <th class ="w-4">2. Satz</th>
          <th class ="w-4">2. Satz</th>
          <th class ="w-4">3. Satz</th>
          <th class ="w-4">3. Satz</th>
          <th class ="w-4">Heim</th>
          <th class ="w-4">Gast</th>
          <th class ="w-4">Heim</th>
          <th class ="w-4">Gast</th>
          <th class ="w-4">Heim</th>
          <th class ="w-4">Gast</th>
        </tr>
        @foreach ($doppelduell as $match)
        <tr class ="border-solid border-b-2 border-black">
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="type1">{{ $match->Duellart  }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="vname11">{{ $match->Vorname_S1_H }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="nname11">{{ $match->Nachname_S1_H}}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="vname12">{{ $match->Vorname_S2_H }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="nname12">{{ $match->Nachname_S2_H }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="vname21">{{ $match->Vorname_S1_G }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="nname21">{{ $match->Nachname_S1_G}}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="vname22">{{ $match->Vorname_S2_G }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="nname22">{{ $match->Nachname_S2_G}}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="satz1heim">{{ $match->Satz_1_Heim }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="satz1gast">{{ $match->Satz_1_Gast }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="satz2heim">{{ $match->Satz_2_Heim }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="satz2gast">{{ $match->Satz_2_Gast }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="satz3heim">{{ $match->Satz_3_Heim }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="satz3gast">{{ $match->Satz_3_Gast }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="sumpoint1">{{ $match->Heim_Gesamt }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="sumpoint2">{{ $match->Gast_Gesamt }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="setpoint1">{{ $match->Gewonnene_Sätze_Heim }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="setpoint2">{{ $match->Gewonnene_Sätze_Gast }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="point1">{{ $match->Gewonnene_Spiele_Heim }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black " id="point2">{{ $match->Gewonnene_Spiele_Gast }}</td>
        </tr>
          
        @endforeach
      </table>
      <button type="submit" name="submit" value="Senden">Send</button>
     </form>
    </section>


    
    

   
@endsection
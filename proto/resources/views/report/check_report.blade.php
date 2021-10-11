@extends('heafoo')
@php
   
    use App\Http\Controllers\QueryController;
    $matchID = $_GET['selectedID'];
    $place = QueryController::getOrt($matchID);
    $homeTab = QueryController::getHome($matchID);
    $home = $homeTab->name;
    $homeID = $homeTab->ID;
    $awayTab =QueryController::getAway($matchID);
    $away = $awayTab->name;
    $awayID = $awayTab->ID;
    $results = QueryController::getResults($matchID);
    $teams = QueryController::getTeams($matchID);
    $staffel = "Dummie";
    $ligen = QueryController::alleLigen();
    $liga = QueryController::getLiga($matchID);
    
    
    
#-----------------Neue Herangehensweise-----------------------------
    $soloduell = QueryController::getSolo($matchID);
    $doppelduell = QueryController::getDouble($matchID);
    
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
      

        <div class="w-1/4 bg-green-400 h-12">
          <label class="block text-gray-900 text-sm font-bold mb-2 ml-3" >Staffel:</label>
          <input type ="text"  oninput="test()" id="liga" name="liga" class="form-control"value="{{ $liga  }}">
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
        @if (count($soloduell)>=1)
          
        <tr class ="border-solid border-b-2 border-black">
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" name = "soloType1" id="soloType1">{{ $soloduell[0]->Duellart  }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" name = "soloVnameHeim1" id="soloVnameHeim1">{{ $soloduell[0]->Vorname_S1 }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" name = "soloNnameHeim1" id="soloNnameHeim1">{{ $soloduell[0]->Nachname_S1}}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" name = "soloVnameGast1" id="soloVnameGast1">{{ $soloduell[0]->Vorname_S2 }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" name = "soloNnameGast1" id="soloNnameGast1">{{ $soloduell[0]->Nachname_S2 }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" name ="soloSatz1heim1" id="soloSatz1heim1">{{ $soloduell[0]->Satz_1_Heim }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" name ="soloSatz1gast1" id="soloSatz1gast1">{{ $soloduell[0]->Satz_1_Gast }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" name ="soloSatz2heim1" id="soloSatz2heim1">{{ $soloduell[0]->Satz_2_Heim }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" name ="soloSatz2gast1" id="soloSatz2gast1">{{ $soloduell[0]->Satz_2_Gast }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" name ="soloSatz3heim1" id="soloSatz3heim1">{{ $soloduell[0]->Satz_3_Heim }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" name ="soloSatz3gast1" id="soloSatz3gast1">{{ $soloduell[0]->Satz_3_Gast }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" name ="soloSumpointHeim1" id="soloSumpointGast1">{{ $soloduell[0]->Heim_Gesamt }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" name ="soloSumpointGast1" id="soloSumpointGast1">{{ $soloduell[0]->Gast_Gesamt }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" name ="soloSetpointHeim1" id="soloSetpoint1">{{ $soloduell[0]->Gewonnene_Sätze_Heim }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" name ="soloSetpointGast1" id="soloSetpointGast1">{{ $soloduell[0]->Gewonnene_Sätze_Gast }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" name ="soloPointHeim1" id="soploPointGast1">{{ $soloduell[0]->Gewonnene_Spiele_Heim }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black " name ="soloPointGast1" id="soloPointGast1">{{ $soloduell[0]->Gewonnene_Spiele_Gast }}</td>
        </tr>
        @if (count($soloduell)>=2)
        <tr class ="border-solid border-b-2 border-black">
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" name = "soloType2" id="soloType2">{{ $soloduell[1]->Duellart  }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" name = "soloVnameHeim2" id="soloVnameHeim2">{{ $soloduell[1]->Vorname_S1 }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" name = "soloNnameHeim2" id="soloNnameHeim2">{{ $soloduell[1]->Nachname_S1}}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" name = "soloVnameGast2" id="soloVnameGast2">{{ $soloduell[1]->Vorname_S2 }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" name = "soloNnameGast2" id="soloNnameGast2">{{ $soloduell[1]->Nachname_S2 }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" name ="soloSatz1heim2" id="soloSatz1heim2">{{ $soloduell[1]->Satz_1_Heim }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" name ="soloSatz1gast2" id="soloSatz1gast2">{{ $soloduell[1]->Satz_1_Gast }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" name ="soloSatz2heim2" id="soloSatz2heim2">{{ $soloduell[1]->Satz_2_Heim }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" name ="soloSatz2gast2" id="soloSatz2gast2">{{ $soloduell[1]->Satz_2_Gast }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" name ="soloSatz3heim2" id="soloSatz3heim2">{{ $soloduell[1]->Satz_3_Heim }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" name ="soloSatz3gast2" id="soloSatz3gast2">{{ $soloduell[1]->Satz_3_Gast }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" name ="soloSumpointHeim2" id="soloSumpointGast2">{{ $soloduell[1]->Heim_Gesamt }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" name ="soloSumpointGast2" id="soloSumpointGast2">{{ $soloduell[1]->Gast_Gesamt }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" name ="soloSetpointHeim2" id="soloSetpoint2">{{ $soloduell[1]->Gewonnene_Sätze_Heim }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" name ="soloSetpointGast2" id="soloSetpointGast2">{{ $soloduell[1]->Gewonnene_Sätze_Gast }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" name ="soloPointHeim2" id="soploPointGast2">{{ $soloduell[1]->Gewonnene_Spiele_Heim }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black " name ="soloPointGast1" id="soloPointGast1">{{ $soloduell[1]->Gewonnene_Spiele_Gast }}</td>
        </tr>
        @if (count($soloduell)>=3)
        <tr class ="border-solid border-b-2 border-black">
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" name = "soloType3" id="soloType3">{{ $soloduell[2]->Duellart  }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" name = "soloVnameHeim3" id="soloVnameHeim3">{{ $soloduell[2]->Vorname_S1 }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" name = "soloNnameHeim3" id="soloNnameHeim3">{{ $soloduell[2]->Nachname_S1}}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" name = "soloVnameGast3" id="soloVnameGast3">{{ $soloduell[2]->Vorname_S2 }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" name = "soloNnameGast3" id="soloNnameGast3">{{ $soloduell[2]->Nachname_S2 }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" name ="soloSatz1heim3" id="soloSatz1heim3">{{ $soloduell[2]->Satz_1_Heim }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" name ="soloSatz1gast3" id="soloSatz1gast3">{{ $soloduell[2]->Satz_1_Gast }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" name ="soloSatz2heim3" id="soloSatz2heim3">{{ $soloduell[2]->Satz_2_Heim }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" name ="soloSatz2gast3" id="soloSatz2gast3">{{ $soloduell[2]->Satz_2_Gast }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" name ="soloSatz3heim3" id="soloSatz3heim3">{{ $soloduell[2]->Satz_3_Heim }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" name ="soloSatz3gast3" id="soloSatz3gast3">{{ $soloduell[2]->Satz_3_Gast }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" name ="soloSumpointHeim3" id="soloSumpointGast3">{{ $soloduell[2]->Heim_Gesamt }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" name ="soloSumpointGast3" id="soloSumpointGast3">{{ $soloduell[2]->Gast_Gesamt }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" name ="soloSetpointHeim3" id="soloSetpoint3">{{ $soloduell[2]->Gewonnene_Sätze_Heim }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" name ="soloSetpointGast3" id="soloSetpointGast3">{{ $soloduell[2]->Gewonnene_Sätze_Gast }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" name ="soloPointHeim3" id="soploPointGast3">{{ $soloduell[2]->Gewonnene_Spiele_Heim }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black " name ="soloPointGast1" id="soloPointGast1">{{ $soloduell[2]->Gewonnene_Spiele_Gast }}</td>
        </tr>
        @if (count($soloduell)>=4)
        <tr class ="border-solid border-b-2 border-black">
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" name = "soloType2" id="soloType2">{{ $soloduell[3]->Duellart  }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" name = "soloVnameHeim2" id="soloVnameHeim2">{{ $soloduell[3]->Vorname_S1 }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" name = "soloNnameHeim2" id="soloNnameHeim2">{{ $soloduell[3]->Nachname_S1}}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" name = "soloVnameGast2" id="soloVnameGast2">{{ $soloduell[3]->Vorname_S2 }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" name = "soloNnameGast2" id="soloNnameGast2">{{ $soloduell[3]->Nachname_S2 }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" name ="soloSatz1heim2" id="soloSatz1heim2">{{ $soloduell[3]->Satz_1_Heim }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" name ="soloSatz1gast2" id="soloSatz1gast2">{{ $soloduell[3]->Satz_1_Gast }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" name ="soloSatz2heim2" id="soloSatz2heim2">{{ $soloduell[3]->Satz_2_Heim }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" name ="soloSatz2gast2" id="soloSatz2gast2">{{ $soloduell[3]->Satz_2_Gast }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" name ="soloSatz3heim2" id="soloSatz3heim2">{{ $soloduell[3]->Satz_3_Heim }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" name ="soloSatz3gast2" id="soloSatz3gast2">{{ $soloduell[3]->Satz_3_Gast }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" name ="soloSumpointHeim2" id="soloSumpointGast2">{{ $soloduell[3]->Heim_Gesamt }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" name ="soloSumpointGast2" id="soloSumpointGast2">{{ $soloduell[3]->Gast_Gesamt }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" name ="soloSetpointHeim2" id="soloSetpoint2">{{ $soloduell[3]->Gewonnene_Sätze_Heim }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" name ="soloSetpointGast2" id="soloSetpointGast2">{{ $soloduell[3]->Gewonnene_Sätze_Gast }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" name ="soloPointHeim2" id="soploPointGast2">{{ $soloduell[3]->Gewonnene_Spiele_Heim }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black " name ="soloPointGast1" id="soloPointGast1">{{ $soloduell[3]->Gewonnene_Spiele_Gast }}</td>
        </tr>
        @endif
        @endif
        @endif
        @endif
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
        @if (count($doppelduell)>=1)
        <tr class ="border-solid border-b-2 border-black">
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" name="dualType1" id="dualType1">{{ $doppelduell[0]->Duellart  }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" name="dualVnameHeim11" id="dualVnameHeim11">{{ $doppelduell[0]->Vorname_S1_H }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" name="dualNnameHeim11" id="dualNnameHeim11">{{ $doppelduell[0]->Nachname_S1_H}}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" name="dualVnameHeim21" id="dualVnameHeim21">{{ $doppelduell[0]->Vorname_S2_H }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" name="dualNname1Heim21" id="dualNname1Heim2">{{ $doppelduell[0]->Nachname_S2_H }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" name="dualVnameGast11" id="dualVnameGast11">{{ $doppelduell[0]->Vorname_S1_G }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" name="dualNnameGast11" id="dualNnameGast11">{{ $doppelduell[0]->Nachname_S1_G}}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" name="dualVnameGast21" id="dualVnameGast21">{{ $doppelduell[0]->Vorname_S2_G }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" name="dualVnameGast21" id="dualVnameGast21">{{ $doppelduell[0]->Nachname_S2_G}}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" name="dualSatz1heim1" id="dualSatz1heim1">{{ $doppelduell[0]->Satz_1_Heim }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" name="dualSatz1gast1" id="dualSatz1gast1">{{ $doppelduell[0]->Satz_1_Gast }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" name="dualSatz2heim1" id="dualSatz2heim1">{{ $doppelduell[0]->Satz_2_Heim }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" name="dualSatz2gast1" id="dualSatz2gast1">{{ $doppelduell[0]->Satz_2_Gast }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" name="dualSatz3heim1" id="dualSatz3heim1">{{ $doppelduell[0]->Satz_3_Heim }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" name="dualSatz3gast1" id="dualSatz3gast1">{{ $doppelduell[0]->Satz_3_Gast }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" name="dualSumpointHeim1" id="dualSumpointHeim1">{{ $doppelduell[0]->Heim_Gesamt }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" name="dualSumpointGast1" id="dualSumpointGast1">{{ $doppelduell[0]->Gast_Gesamt }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" name="dualSetpointHeim1" id="dualSetpointHeim1">{{ $doppelduell[0]->Gewonnene_Sätze_Heim }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" name="dualSetpointGast1" id="dualSetpointGast1">{{ $doppelduell[0]->Gewonnene_Sätze_Gast }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" name="dualPointHeim1" id="dualPointHeim1">{{ $doppelduell[0]->Gewonnene_Spiele_Heim }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black" name="dualPointGast1" id="dualPointGast1">{{ $doppelduell[0]->Gewonnene_Spiele_Gast }}</td>
        </tr>
        @if (count($doppelduell)>=2)
        <tr class ="border-solid border-b-2 border-black">
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" name="dualType2" id="dualType2">{{ $doppelduell[1]->Duellart  }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" name="dualVnameHeim12" id="dualVnameHeim12">{{ $doppelduell[1]->Vorname_S1_H }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" name="dualNnameHeim12" id="dualNnameHeim12">{{ $doppelduell[1]->Nachname_S1_H}}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" name="dualVnameHeim22" id="dualVnameHeim22">{{ $doppelduell[1]->Vorname_S2_H }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" name="dualNname1Heim22" id="dualNname1Heim22">{{ $doppelduell[1]->Nachname_S2_H }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" name="dualVnameGast12" id="dualVnameGast12">{{ $doppelduell[1]->Vorname_S1_G }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" name="dualNnameGast12" id="dualNnameGast12">{{ $doppelduell[1]->Nachname_S1_G}}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" name="dualVnameGast22" id="dualVnameGast22">{{ $doppelduell[1]->Vorname_S2_G }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" name="dualNnameGast22" id="dualNnameGast22">{{ $doppelduell[1]->Nachname_S2_G}}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" name="dualSatz1heim2" id="dualSatz1heim2">{{ $doppelduell[1]->Satz_1_Heim }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" name="dualSatz1gast2" id="dualSatz1gast2">{{ $doppelduell[1]->Satz_1_Gast }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" name="dualSatz2heim2" id="dualSatz2heim2">{{ $doppelduell[1]->Satz_2_Heim }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" name="dualSatz2gast2" id="dualSatz2gast2">{{ $doppelduell[1]->Satz_2_Gast }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" name="dualSatz3heim2" id="dualSatz3heim2">{{ $doppelduell[1]->Satz_3_Heim }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" name="dualSatz3gast2" id="dualSatz3gast2">{{ $doppelduell[1]->Satz_3_Gast }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" name="dualSumpointHeim2" id="dualSumpointHeim2">{{ $doppelduell[1]->Heim_Gesamt }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" name="dualSumpointGast2" id="dualSumpointGast2">{{ $doppelduell[1]->Gast_Gesamt }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" name="dualSetpointHeim2" id="dualSetpointHeim2">{{ $doppelduell[1]->Gewonnene_Sätze_Heim }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" name="dualSetpointGast2" id="dualSetpointGast2">{{ $doppelduell[1]->Gewonnene_Sätze_Gast }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" name="dualPointHeim2" id="dualPointHeim2">{{ $doppelduell[1]->Gewonnene_Spiele_Heim }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black" name="dualPointGast2" id="dualPointGast2">{{ $doppelduell[1]->Gewonnene_Spiele_Gast }}</td>
        </tr>
        @endif
        @endif
          
      </table>
      <button type="submit" name="submit" value="Senden">Send</button>
     </form>
    </section>


    
    

   
@endsection
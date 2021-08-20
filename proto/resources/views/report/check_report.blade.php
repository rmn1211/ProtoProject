@extends('heafoo')
@php
    use App\Http\Controllers\QueryController;
    $place = QueryController::getOrt($match);
    $home = QueryController::getHome($match);
    $guest =QueryController::getAway($match);
    $results = QueryController::getResults($match);
    $duelle = QueryController::getDuells($match);
    $playerNamesDouble1 = QueryController::getNamesDouble($duelle[0]);
    $playerNamesSolo1 = QueryController::getNamesSolo($duelle[1]);
    $teams = QueryController::getTeams(1);
    $staffel = "Dummie";
    $art1 = QueryController::getArt($duelle[0]);
    $art2 = QueryController::getArt($duelle[1]);
#-----------------Neue herangehensweise-----------------------------
    $soloduell = QueryController::getSolo(1);
    
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
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" />
</head>
    <section >
      <h3 class ="font-bold  text-2xl">Spieleberichtsbogen</h3>
    </section>
    <section  class="mt-10 class=w-6/12">
    <form class="flex flex-col mx-3 mb-6" method="POST" action="{{url('/overview/1')}}">
      @csrf

      <div class="flex mb-4">

      <div class="form-group">
          <label class="block text-gray-900 text-sm font-bold mb-2 ml-3" for="away">Staffel:</label>
          <input type="text" id="tfStaffel" name="tfStaffel" class="form-control"value={{ $staffel }}>
        </div>
        <div class="w-1/4 bg-green-400 h-12">
          <label class="block text-gray-900 text-sm font-bold mb-2 ml-3" for="home">Heimverein:</label>
          <input type="text" name="tfHome" id="tfHome" class="bg-gray-100 text-gray-900  w-full focus:outlie-none border-b-4 border-gray-700 focus:border-green-500 transition duration-500 px-3 pb-3" value={{ $home }}>
        </div>
        <div class="w-1/4 bg-green-400 h-12">
          <label class="block text-gray-900 text-sm font-bold mb-2 ml-3" for="away">Gastverein:</label>
          <input type="text" name="tfAway" id="tfAway" class="bg-gray-100 text-gray-900  w-full focus:outlie-none border-b-4 border-gray-700 focus:border-green-500 transition duration-500 px-3 pb-3"value={{ $guest }}>
        </div>
        <div class="w-1/4 bg-green-400 h-12">
          <label class="block text-gray-900 text-sm font-bold mb-2 ml-3" for="away">Austragungsort:</label>
          <input type="text" name="tfPlace" id="tfPlace" class="bg-gray-100 text-gray-900  w-full focus:outlie-none border-b-4 border-gray-700 focus:border-green-500 transition duration-500 px-3 pb-3"value={{ $place }}>
        </div>
        
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
    <script type="text/javascript">
        var route = "{{ url('autocomplete-search') }}";

        $('#tfStaffel').typeahead({
            source: function (query, process) {
                return $.get(route, {
                    query: query
                }, function (data) {
                    return process(data);
                });
            }
        });
    </script>






      </div>
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
        <tr class ="border-solid border-b-2 border-black">
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="type1">{{ $soloduell[0]->art  }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="vname11">{{ $soloduell[0]->heimVorname }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="nname11">{{ $soloduell[0]->heimNachname}}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="vname12"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-double border-r-2 border-black" id="nname12"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="vname13">{{ $soloduell[0]->gastVorname }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="nname13">{{ $soloduell[0]->gastNachname }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="vname14"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="nname14"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="satz1heim1">{{ $soloduell[0]->satz1Heim }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="satz1gast1">{{ $soloduell[0]->satz1Gast }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="satz2heim1">{{ $soloduell[0]->satz2Heim }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="satz2gast1">{{ $soloduell[0]->satz2Gast }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="satz3heim1">{{ $soloduell[0]->satz3Heim }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="satz3gast1">{{ $soloduell[0]->satz3Gast }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="sumpoint11">{{ $soloduell[0]->GewonneneSaetzeHeim }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="sumpoint12">{{ $soloduell[0]->GewonneneSaetzeGast }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="setpoint11">{{ $soloduell[0]->GewonneneSpieleHeim }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="setpoint12">{{ $soloduell[0]->GewonneneSpieleGast }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="point11"></td>
          <td contenteditable="true" class="bg-gray-100 text-black " id="point12"></td>
        </tr>
        <tr class ="border-solid border-b-2 border-black">
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="type2"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="vname21"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="nname21"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="vname22"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-double border-r-2 border-black" id="nname22"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="vname23"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="nname23"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="vname24"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="nname24"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="satz1heim2"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="satz1gast2"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="satz2heim2"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="satz2gast2"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="satz3heim2"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="satz3gast2"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="sumpoint21"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="sumpoint22"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="setpoint21"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="setpoint22"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="point21"></td>
          <td contenteditable="true" class="bg-gray-100 text-black " id="point22"></td>
        </tr>
        <tr class ="border-solid border-b-2 border-black">
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="type3"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="vname31"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="nname31"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="vname32"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-double border-r-2 border-black" id="nname32"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="vname33"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="nname33"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="vname34"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="nname34"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="satz1heim3"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="satz1gast3"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="satz2heim3"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="satz2gast3"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="satz3heim3"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="satz3gast3"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="sumpoint31"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="sumpoint32"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="setpoint31"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="setpoint32"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="point31"></td>
          <td contenteditable="true" class="bg-gray-100 text-black " id="point32"></td>
        </tr>
        <tr class ="border-solid border-b-2 border-black">
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="type4"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="vname41"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="nname41"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="vname42"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-double border-r-2 border-black" id="nname42"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="vname43"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="nname43"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="vname44"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="nname44"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="satz1heim4"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="satz1gast4"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="satz2heim4"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="satz2gast4"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="satz3heim4"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="satz3gast4"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="sumpoint41"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="sumpoint42"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="setpoint41"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="setpoint42"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="point41"></td>
          <td contenteditable="true" class="bg-gray-100 text-black " id="point42"></td>
        </tr>
        <tr class ="border-solid border-b-2 border-black">
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="type5"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="vname51"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="nname51"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="vname52"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-double border-r-2 border-black" id="nname52"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="vname53"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="nname53"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="vname54"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="nname54"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="satz1heim5"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="satz1gast5"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="satz2heim5"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="satz2gast5"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="satz3heim5"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="satz3gast5"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="sumpoint51"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="sumpoint52"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="setpoint51"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="setpoint52"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="point51"></td>
          <td contenteditable="true" class="bg-gray-100 text-black " id="point52"></td>
        </tr>
        <tr class ="border-solid border-b-2 border-black">
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="type6"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="vname61"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="nname61"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="vname62"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-double border-r-2 border-black" id="nname62"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="vname63"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="nname63"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="vname64"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="nname64"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="satz1heim6"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="satz1gast6"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="satz2heim6"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="satz2gast6"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="satz3heim6"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="satz3gast6"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="sumpoint61"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="sumpoint62"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="setpoint61"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="setpoint62"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="point61"></td>
          <td contenteditable="true" class="bg-gray-100 text-black " id="point62"></td>
        </tr>
        <tr class ="border-solid border-b-2 border-black">
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="type7"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="vname71"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="nname71"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="vname72"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-double border-r-2 border-black" id="nname72"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="vname73"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="nname73"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="vname74"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="nname74"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="satz1heim7"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="satz1gast7"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="satz2heim7"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="satz2gast7"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="satz3heim7"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="satz3gast7"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="sumpoint71"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="sumpoint72"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="setpoint71"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="setpoint72"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="point71"></td>
          <td contenteditable="true" class="bg-gray-100 text-black " id="point72"></td>
        </tr>
        <tr class ="border-solid border-b-2 border-black">
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="type8"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="vname81"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="nname81"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="vname82"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-double border-r-2 border-black" id="nname82"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="vname83"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="nname83"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="vname84"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="nname84"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="satz1heim8"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="satz1gast8"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="satz2heim8"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="satz2gast8"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="satz3heim8"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="satz3gast8"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="sumpoint81"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="sumpoint82"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="setpoint81"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="setpoint82"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="point81"></td>
          <td contenteditable="true" class="bg-gray-100 text-black " id="point82"></td>
        </tr>
      </table>
      <button type="submit" name="submit" value="Senden">Send</button>
     </form>
    </section>


    
    

   
@endsection
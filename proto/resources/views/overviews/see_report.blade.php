@extends('heafoo')
@php
   
   
use App\Http\Controllers\QueryController;
$matchID = $_GET['selectedID'];
$match = QueryController::getSingleMatch($matchID);
$homeID = $match->HeimID;
$awayID = $match->GastID;
$teams = QueryController::getTeams($matchID);
$ligen = QueryController::alleLigen();
$liga = QueryController::getLiga($matchID);
$region = QueryController::getRegion($liga->ID);

#-----------------Neue Herangehensweise-----------------------------
$soloduell = QueryController::getSolo($matchID);
$doppelduell = QueryController::getDouble($matchID);
$tag =  QueryController::getTag($matchID);
$runde =  QueryController::getRunde( $tag[0]->ID);
$saison =  QueryController::getSaison( $runde[0]->ID);
#-----------------Test fuer Vorschlaege------------------------------
$arten = QueryController::allTypes();
@endphp
<!-- HTML Listen fuellen -->
<datalist id="arten">
    @foreach ($arten as $art)
        <option value="{{ $art->Name }}">
    @endforeach
</datalist>
<!-- HTML Listen fuellen ENDE-->
<div id="containerTeams" style="display:none">
    @foreach ($teams as $team)
        $cookie_name = $team -> ID;
        $cookie_val = $team -> Name;
        setcookie($cookie_name, $cookie_value);
    @endforeach
</div>
@section('page-content')

    <head>

        <!-- Meta -->
         <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
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

            @media (min-width: 640px) {
                table {
                    display: inline-table !important;
                }

                thead tr:not(:first-child) {
                    display: none;
                }
            }

            td:not(:last-child) {
                border-bottom: 0;
            }

            th:not(:last-child) {
                border-bottom: 2px solid rgba(0, 0, 0, .1);
            }

        </style>

    </head>
    <section>
        <h3 class="font-bold  text-2xl">Spielberichtsbogen</h3>
    </section>
    <section class="mt-10 overflow-auto">
        <div class="w-full flex flex-row lg:justify-center">
            <form class="flex flex-col mx-3 mb-6" method="POST" onsubmit="return validateInputs();" action="{{ url('/overview') }}">
                @csrf
                <input readonly type="hidden" id="matchID" name="matchID" value="{{ $matchID }}">
                <input readonly type="hidden" id="soloCount" name="soloCount" value="{{ count($soloduell) }}">
                <input readonly type="hidden" id="doubleCount" name="doubleCount" value="{{ count($doppelduell) }}">
                <div class="flex mb-4">
                    <div class="w-1/full bg-green-400 h-12">
                        <label class="block text-gray-900 text-sm font-bold mb-2 ml-3">Region:</label>
                        <input readonly  type="text" id="region" name="region" onChange="markInput(this)" class="bg-gray-100 text-gray-900 w-full  border-gray-700 border-r-2 focus:outline-none border-b-full border-gray-700 focus:border-green-500 transition duration-500 px-3 pb-3" value="{{ $region->name }}">

                    </div>

                    <div class="w-1/full bg-green-400 h-12">


                        <label class="block text-gray-900 text-sm font-bold mb-2 ml-3">Staffel:</label>
                        <input readonly  type="text" id="liga" onChange="markInput(this)" name="liga" class="bg-gray-100 text-gray-900 w-full  border-gray-700 border-r-2 focus:outline-none border-b-full border-gray-700 focus:border-green-500 transition duration-500 px-3 pb-3" value="{{ $liga->Name }}">
                    </div>
                        <div class="w-1/full bg-green-400 h-12">
                        <label class="block text-gray-900 text-sm font-bold mb-2 ml-3" >Saison:</label>
                        <input readonly type="text"   name=" saison" id="saison" class="bg-gray-100 text-gray-900  border-gray-700 border-r-2  w-full focus:outline-none border-b-full  border-gray-700 focus:border-green-500 transition duration-500 px-3 pb-3" value="{{ $saison[0]->Name }}" >
                    </div>
                      <div class="w-1/full bg-green-400 h-12">
                        <label class="block text-gray-900 text-sm font-bold mb-2 ml-3" >Runde:</label>
                        <input readonly  type="text" name=" runde" id="runde" class="bg-gray-100 text-gray-900  w-full focus:outline-none border-b-full border-gray-700   border-r-2 focus:border-green-500 transition duration-500 px-3 pb-3" value="{{ $runde[0]->Bezeichnung }}"  >
                    </div>
                      <div class="w-1/full bg-green-400 h-12">
                        <label class="block text-gray-900 text-sm font-bold mb-2 ml-3" >Spieltag:</label>
                        <input readonly type="text"  name=" tag" id="tag" class="bg-gray-100 text-gray-900  w-full focus:outline-none border-b-full border-gray-700  border-r-2 focus:border-green-500 transition duration-500 px-3 pb-3"value="{{ $tag[0]->Tag }}" >
                    </div>


                    <div class="w-1/full bg-green-400 h-12">
                        <label class="block text-gray-900 text-sm font-bold mb-2 ml-3" for="home">Heimverein:</label>
                        <input readonly type="text" onChange="markInput(this)" name=" tfHome" id="tfHome" class="bg-gray-100 text-gray-900  border-gray-700 border-r-2  w-full focus:outline-none border-b-full border-gray-700 focus:border-green-500 transition duration-500 px-3 pb-3" value="{{ $match->Heim }}">
                    </div>
                    <div class="w-1/full bg-green-400 h-12">
                        <label class="block text-gray-900 text-sm font-bold mb-2 ml-3" for="away">Gastverein:</label>
                        <input readonly   type="text" onChange="markInput(this)" name="tfAway" id="tfAway" class="bg-gray-100 text-gray-900  border-gray-700 border-r-2 w-full focus:outlie-none border-b-full border-gray-700 focus:border-green-500 transition duration-500 px-3 pb-3" value="{{ $match->Gast }}">
                    </div>
                    <div class="w-1/full bg-green-400 h-12">
                        <label class="block text-gray-900 text-sm font-bold mb-2 ml-3" for="away">Schiedsrichter:</label>
                        <input readonly type="text" name="tfPlace" id="tfPlace" onChange="markInput(this)" class="bg-gray-100 text-gray-900  border-gray-700 border-r-2 w-full focus:outline-none border-b-full border-gray-700 focus:border-green-500 transition duration-500 px-3 pb-3" value="{{ $match->Schiedsrichter }}">
                    </div>
                    <div class="w-1/full bg-green-400 h-12">
                        <label class="block text-gray-900 text-sm font-bold mb-2 ml-3" for="away">Austragungsort:</label>
                        <input  readonly type="text" name="tfPlace" id="tfPlace" onChange="markInput(this)" class="bg-gray-100 text-gray-900  w-full focus:outline-none border-b-full border-gray-700 focus:border-green-500 transition duration-500 px-3 pb-3" value="{{ $match->Spielort }}">
                    </div>
                </div>

                  <h1>Doppel</h1>
                <table class="w-full flex flex-row flex-wrap rounded-lg my-5">
                    <thead>
                        <tr class="bg-green-400 flex flex-col sm:table-row rounded-l-lg sm:rounded-none mb-2 sm:mb-0">
                            <th class="w-28 h-8 sm:h-auto  sm:w-4 border-solid sm:border-r-2 align-middle text-center">Art</th>
                            <th class="w-28 h-16 sm:h-auto sm:w-4 border-solid sm:border-r-2 align-middle text-center" colspan="2">Spieler 1: Heim</th>
                            <th class="w-28 h-16 sm:h-auto sm:w-4 border-solid sm:border-r-2 align-middle text-center" rowspan="2" colspan="2">Spieler 2: Heim</th>
                            <th class="w-28 h-16 sm:h-auto sm:w-4 border-solid sm:border-r-2 align-middle text-center" colspan="2">Spieler 1: Gast</th>
                            <th class="w-28 h-16 sm:h-auto sm:w-4 border-solid sm:border-r-2 align-middle text-center" rowspan="2" colspan="2">Spieler 2: Gast</th>
                            <th class="w-28 h-48 sm:h-auto sm:w-4 border-solid sm:border-r-2 align-middle text-center" rowspan="6" colspan="6">Satzergebnisse</th>
                            <th class="w-28 h-16 sm:h-auto sm:w-4 border-solid sm:border-r-2 align-middle text-center" rowspan="2" colspan="2">Summe: Spielpunkte</th>
                            <th class="w-28 h-16 sm:h-auto sm:w-4 border-solid sm:border-r-2 align-middle text-center" rowspan="2" colspan="2">Summe: Sätze</th>
                            <th class="w-28 h-16 sm:h-auto sm:w-4 border-solid align-middle text-center" rowspan="2" colspan="2">Punkte</th>
                        </tr>
                        @if (count($doppelduell) >= 2)
                            <tr class="bg-green-400 flex flex-col sm:table-row rounded-l-lg sm:rounded-none mb-2 sm:mb-0">
                                <th class="w-28 h-8 sm:h-auto  sm:w-4 border-solid sm:border-r-2 sm:text-center">Art</th>
                                <th class="w-28 h-16 sm:h-auto sm:w-4 border-solid sm:border-r-2 align-middle text-center" colspan="2">Spieler 1: Heim</th>
                                <th class="w-28 h-16 sm:h-auto sm:w-4 border-solid sm:border-r-2 align-middle text-center" rowspan="2" colspan="2">Spieler 2: Heim</th>
                                <th class="w-28 h-16 sm:h-auto sm:w-4 border-solid sm:border-r-2 align-middle text-center" colspan="2">Spieler 1: Gast</th>
                                <th class="w-28 h-16 sm:h-auto sm:w-4 border-solid sm:border-r-2 align-middle text-center" rowspan="2" colspan="2">Spieler 2: Gast</th>
                                <th class="w-28 h-48 sm:h-auto sm:w-4 border-solid sm:border-r-2 sm:text-center" rowspan="6" colspan="6">Satzergebnisse</th>
                                <th class="w-28 h-16 sm:h-auto sm:w-4 border-solid sm:border-r-2 sm:text-center" rowspan="2" colspan="2">Summe: Spielpunkte</th>
                                <th class="w-28 h-16 sm:h-auto sm:w-4 border-solid sm:border-r-2 sm:text-center" rowspan="2" colspan="2">Summe: Sätze</th>
                                <th class="w-28 h-16 sm:h-auto sm:w-4 border-solid sm:text-center" rowspan="2" colspan="2">Punkte</th>

                            </tr>
                        @endif
                    </thead>
                    <thead>
                        <tr class="flex flex-col flex-no wrap sm:table-row rounded-l-lg sm:rounded-none mb-2 sm:mb-0">
                            <th class="border-solid h-8 sm:h-auto border-t-2 border-green-500 sm:border-white sm:border-r-2 text-center">Art</th>
                            <th class="text-center h-8 sm:h-auto">Vorname</th>
                            <th class="border-solid h-8 sm:h-auto sm:border-r-2 text-center">Nachname</th>
                            <th class="text-center h-8 sm:h-auto">Vorname</th>
                            <th class="border-solid h-8 sm:h-auto sm:border-r-2 text-center">Nachname</th>
                            <th class="text-center h-8 sm:h-auto">Vorname</th>
                            <th class="border-solid h-8 sm:h-auto sm:border-r-2 text-center">Nachname</th>
                            <th class="text-center h-8 sm:h-auto">Vorname</th>
                            <th class="border-solid h-8 sm:h-auto sm:border-r-2 text-center">Nachname</th>
                            <th class="w-full sm:w-4 h-16 sm:h-auto text-center" colspan="2">1. Satz</th>
                            <th class="w-full sm:w-4 h-16 sm:h-auto text-center" colspan="2">2. Satz</th>
                            <th class="w-full sm:w-4 h-16 sm:h-auto text-center border-solid sm:border-r-2" colspan="2">3. Satz</th>
                            <th class="w-full sm:w-4 h-8 sm:h-auto text-center">Heim</th>
                            <th class="w-full sm:w-4 h-8 sm:h-auto text-center border-solid sm:border-r-2">Gast</th>
                            <th class="w-full sm:w-4 h-8 sm:h-auto text-center">Heim</th>
                            <th class="w-full sm:w-4 h-8 sm:h-auto text-center border-solid sm:border-r-2">Gast</th>
                            <th class="w-full sm:w-4 h-8 sm:h-auto text-center">Heim</th>
                            <th class="w-full border-b-2 border-green-500 sm:w-4 h-8 sm:h-auto text-center">Gast</th>
                        </tr>
                        @if (count($doppelduell) >= 2)
                            <tr class="flex flex-col flex-no wrap sm:table-row rounded-l-lg sm:rounded-none mb-2 sm:mb-0">
                                <th class="border-solid h-8 sm:h-auto border-t-2 border-green-500 sm:border-white sm:border-r-2 text-center">Art</th>
                                <th class="text-center h-8 sm:h-auto">Vorname</th>
                                <th class="border-solid h-8 sm:h-auto sm:border-r-2 text-center">Nachname</th>
                                <th class="text-center h-8 sm:h-auto">Vorname</th>
                                <th class="border-solid h-8 sm:h-auto sm:border-r-2 text-center">Nachname</th>
                                <th class="text-center h-8 sm:h-auto">Vorname</th>
                                <th class="border-solid h-8 sm:h-auto sm:border-r-2 text-center">Nachname</th>
                                <th class="text-center h-8 sm:h-auto">Vorname</th>
                                <th class="border-solid h-8 sm:h-auto sm:border-r-2 text-center">Nachname</th>
                                <th class="w-full sm:w-4 h-16 sm:h-auto text-center" colspan="2">1. Satz</th>
                                <th class="w-full sm:w-4 h-16 sm:h-auto text-center" colspan="2">2. Satz</th>
                                <th class="w-full sm:w-4 h-16 sm:h-auto text-center border-solid sm:border-r-2" colspan="2">3. Satz</th>
                                <th class="w-full sm:w-4 h-8 sm:h-auto text-center">Heim</th>
                                <th class="w-full sm:w-4 h-8 sm:h-auto text-center border-solid sm:border-r-2">Gast</th>
                                <th class="w-full sm:w-4 h-8 sm:h-auto text-center">Heim</th>
                                <th class="w-full sm:w-4 h-8 sm:h-auto text-center border-solid sm:border-r-2">Gast</th>
                                <th class="w-full sm:w-4 h-8 sm:h-auto text-center">Heim</th>
                                <th class="w-full border-b-2 border-green-500 sm:w-4 h-8 sm:h-auto text-center">Gast</th>
                            </tr>
                        @endif
                    </thead>
                    <tbody class="flex-1 sm:flex-none">
                        @if (count($doppelduell) >= 1)
                            <tr class="border-solid border-b-2 border-black w-44 sm:w-auto flex flex-col flex-no wrap sm:table-row mb-2 sm:mb-0">
                                <input readonly type="hidden" id="doppelDuellID1" name="doppelDuellID1" value="{{ $doppelduell[0]->Duell_ID }}">
                                <td class="bg-gray-100 h-8 text-black border-solid border-b-2 sm:border-r-2 border-black">
                                    <input readonly type="text" list="arten" size="4" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300" name="dualType1" id="dualType1" value="{{ $doppelduell[0]->Duellart }}" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                    <input readonly type="text"  size="20" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 sm:p-1.5" name="dualVnameHeim11" id="dualVnameHeim11" value="{{ $doppelduell[0]->Vorname_S1_H }}" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                    <input readonly type="text"  size="20" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" name="dualNnameHeim11" id="dualNnameHeim11" value="{{ $doppelduell[0]->Nachname_S1_H }}" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                    <input readonly type="text" size="20" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5" name="dualVnameHeim21" id="dualVnameHeim21" value="{{ $doppelduell[0]->Vorname_S2_H }}" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                    <input readonly type="text"  size="20" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" name="dualNnameHeim21" id="dualNnameHeim21" value="{{ $doppelduell[0]->Nachname_S2_H }}" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                    <input readonly type="text" size="20" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 sm:p-1.5" name="dualVnameGast11" id="dualVnameGast11" value="{{ $doppelduell[0]->Vorname_S1_G }}" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                    <input readonly type="text" size="20" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" name="dualNnameGast11" id="dualNnameGast11" value="{{ $doppelduell[0]->Nachname_S1_G }}" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                    <input readonly type="text"  size="20" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5" name="dualVnameGast21" id="dualVnameGast21" value="{{ $doppelduell[0]->Vorname_S2_G }}" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                    <input readonly type="text"  size="20" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" name="dualNnameGast21" id="dualNnameGast21" value="{{ $doppelduell[0]->Nachname_S2_G }}" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                    <input readonly type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5" onchange="markInput(this); changeSetSumD(1)" name="dualSatz1heim1" id="dualSatz1heim1" value="{{ $doppelduell[0]->Satz_1_Heim }}" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                    <input readonly type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" onchange="markInput(this); changeSetSumD(1)" name="dualSatz1gast1" id="dualSatz1gast1" value="{{ $doppelduell[0]->Satz_1_Gast }}" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                    <input readonly type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5" onchange="markInput(this); changeSetSumD(1)" name="dualSatz2heim1" id="dualSatz2heim1" value="{{ $doppelduell[0]->Satz_2_Heim }}" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                    <input readonly type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" onchange="markInput(this); changeSetSumD(1)" name="dualSatz2gast1" id="dualSatz2gast1" value="{{ $doppelduell[0]->Satz_2_Gast }}" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                    <input readonly type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5" onchange="markInput(this); changeSetSumD(1)" name="dualSatz3heim1" id="dualSatz3heim1" value="{{ $doppelduell[0]->Satz_3_Heim }}" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                    <input readonly type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" onchange="markInput(this); changeSetSumD(1)" name="dualSatz3gast1" id="dualSatz3gast1" value="{{ $doppelduell[0]->Satz_3_Gast }}" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                    <input readonly type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5" readonly="readonly" tabindex="-1" name="dualSetpointHeim1" id="dualSetpointHeim1" value="{{ $doppelduell[0]->Gewonnene_Sätze_Heim }}" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                    <input readonly type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" readonly="readonly" tabindex="-1" name="dualSetpointGast1" id="dualSetpointGast1" value="{{ $doppelduell[0]->Gewonnene_Sätze_Gast }}" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                    <input readonly type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5" readonly="readonly" tabindex="-1" name="dualWonSetHeim1" id="dualWonSetHeim1" value="{{ $doppelduell[0]->Heim_Gesamt }}" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                    <input readonly type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" readonly="readonly" tabindex="-1" name="dualWonSetGast1" id="dualWonSetGast1" value="{{ $doppelduell[0]->Gast_Gesamt }}" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                    <input readonly type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:sm:text-right focus:bg-green-400 transition duration-300 p-1.5" readonly="readonly" tabindex="-1" name="dualWonMatchHeim1" id="dualWonMatchHeim1" value="{{ $doppelduell[0]->Gewonnene_Spiele_Heim }}" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black">
                                    <input readonly type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" readonly="readonly" tabindex="-1" name="dualWonMatchGast1" id="dualWonMatchGast1" value="{{ $doppelduell[0]->Gewonnene_Spiele_Gast }}" />
                                </td>
                            </tr>
                            @if (count($doppelduell) >= 2)
                                <tr class="border-solid border-b-2 border-black w-44 sm:w-auto flex flex-col flex-no wrap sm:table-row mb-2 sm:mb-0">
                                    <input readonly type="hidden" id="doppelDuellID2" name="doppelDuellID2" value="{{ $doppelduell[1]->Duell_ID }}">
                                    <td class="bg-gray-100 h-8 text-black border-solid border-b-2 sm:border-r-2 border-black">
                                        <input readonly type="text" list="arten" size="4" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300" name="dualType2" id="dualType2" value="{{ $doppelduell[1]->Duellart }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                        <input readonly type="text" size="20" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 sm:p-1.5" name="dualVnameHeim12" id="dualVnameHeim12" value="{{ $doppelduell[1]->Vorname_S1_H }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                        <input readonly type="text"   class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" name="dualNnameHeim12" id="dualNnameHeim12" value="{{ $doppelduell[1]->Nachname_S1_H }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                        <input readonly type="text"size="20" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5" name="dualVnameHeim22" id="dualVnameHeim22" value="{{ $doppelduell[1]->Vorname_S2_H }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                        <input readonly type="text"   size="20" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" name="dualNnameHeim22" id="dualNnameHeim22" value="{{ $doppelduell[1]->Nachname_S2_H }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                        <input readonly type="text" size="20" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 sm:p-1.5" name="dualVnameGast12" id="dualVnameGast12" value="{{ $doppelduell[1]->Vorname_S1_G }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                        <input readonly type="text"   class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" name="dualNnameGast12" id="dualNnameGast12" value="{{ $doppelduell[1]->Nachname_S1_G }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                        <input readonly type="text" size="20" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5" name="dualVnameGast22" id="dualVnameGast22" value="{{ $doppelduell[1]->Vorname_S2_G }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                        <input readonly type="text"  size="20" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" name="dualNnameGast22" id="dualNnameGast22" value="{{ $doppelduell[1]->Nachname_S2_G }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                        <input readonly type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5" onchange="markInput(this); changeSetSumD(2)" name="dualSatz1heim2" id="dualSatz1heim2" value="{{ $doppelduell[1]->Satz_1_Heim }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                        <input readonly type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" onchange="markInput(this); changeSetSumD(2)" name="dualSatz1gast2" id="dualSatz1gast2" value="{{ $doppelduell[1]->Satz_1_Gast }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                        <input readonly type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5" onchange="markInput(this); changeSetSumD(2)" name="dualSatz2heim2" id="dualSatz2heim2" value="{{ $doppelduell[1]->Satz_2_Heim }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                        <input readonly type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" onchange="markInput(this); changeSetSumD(2)" name="dualSatz2gast2" id="dualSatz2gast2" value="{{ $doppelduell[1]->Satz_2_Gast }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                        <input readonly type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5" onchange="markInput(this); changeSetSumD(2)" name="dualSatz3heim2" id="dualSatz3heim2" value="{{ $doppelduell[1]->Satz_3_Heim }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                        <input readonly type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" onchange="markInput(this); changeSetSumD(2)" name="dualSatz3gast2" id="dualSatz3gast2" value="{{ $doppelduell[1]->Satz_3_Gast }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                        <input readonly type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5" readonly="readonly" tabindex="-1" name="dualSetpointHeim2" id="dualSetpointHeim2" value="{{ $doppelduell[1]->Gewonnene_Sätze_Heim }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                        <input readonly type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" readonly="readonly" tabindex="-1" name="dualSetpointGast2" id="dualSetpointGast2" value="{{ $doppelduell[1]->Gewonnene_Sätze_Gast }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                        <input readonly type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5" readonly="readonly" tabindex="-1" name="dualWonSetHeim2" id="dualWonSetHeim2" value="{{ $doppelduell[1]->Heim_Gesamt }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                        <input readonly type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" readonly="readonly" tabindex="-1" name="dualWonSetGast2" id="dualWonSetGast2" value="{{ $doppelduell[1]->Gast_Gesamt }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                        <input readonly type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:sm:text-right focus:bg-green-400 transition duration-300 p-1.5" readonly="readonly" tabindex="-1" name="dualWonMatchHeim2" id="dualWonMatchHeim2" value="{{ $doppelduell[1]->Gewonnene_Spiele_Heim }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black">
                                        <input readonly type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" readonly="readonly" tabindex="-1" name="dualWonMatchGast2" id="dualWonMatchGast2" value="{{ $doppelduell[1]->Gewonnene_Spiele_Gast }}" />
                                    </td>
                                </tr>

                                  @if (count($doppelduell) >= 3)
                                    <tr class="border-solid border-b-2 border-black w-44 sm:w-auto flex flex-col flex-no wrap sm:table-row mb-2 sm:mb-0">
                                        <input type="hidden" id="doppelDuellID3" name="doppelDuellID3" value="{{ $doppelduell[2]->Duell_ID }}">
                                    <td class="bg-gray-100 h-8 text-black border-solid border-b-2 sm:border-r-2 border-black">
                                        <input type="text" list="arten" size="4" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300" name="dualType3" id="dualType3" value="{{ $doppelduell[2]->Duellart }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                        <input type="text" onload="VnameH(this.id)" oninput="VnameH(this.id)" onfocus="javascript:VnameH(this.id);$(this).autocomplete('search');" size="20" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 sm:p-1.5" name="dualVnameHeim13" id="dualVnameHeim13" value="{{ $doppelduell[2]->Vorname_S1_H }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                        <input type="text"  onload="NnameH(this.id)" oninput="NnameH(this.id)" onfocus="javascript:NnameH(this.id);$(this).autocomplete('search');"  class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" name="dualNnameHeim13" id="dualNnameHeim13" value="{{ $doppelduell[2]->Nachname_S1_H }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                        <input type="text" onload="VnameH(this.id)" oninput="VnameH(this.id)" onfocus="javascript:VnameH(this.id);$(this).autocomplete('search');" size="20" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5" name="dualVnameHeim23" id="dualVnameHeim23" value="{{ $doppelduell[2]->Vorname_S2_H }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                        <input type="text" onload="NnameH(this.id)" oninput="NnameH(this.id)" onfocus="javascript:NnameH(this.id);$(this).autocomplete('search');"  size="20" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" name="dualNnameHeim23" id="dualNnameHeim23" value="{{ $doppelduell[2]->Nachname_S2_H }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                        <input type="text" onload="VnameG(this.id)" oninput="VnameG(this.id)" onfocus="javascript:VnameG(this.id);$(this).autocomplete('search');" size="20" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 sm:p-1.5" name="dualVnameGast13" id="dualVnameGast13" value="{{ $doppelduell[2]->Vorname_S1_G }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                        <input type="text" onload="NnameG(this.id)" oninput="NnameG(this.id)" onfocus="javascript:NnameG(this.id);$(this).autocomplete('search');"  class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" name="dualNnameGast13" id="dualNnameGast13" value="{{ $doppelduell[2]->Nachname_S1_G }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                        <input type="text" onload="VnameG(this.id)" oninput="VnameG(this.id)" onfocus="javascript:VnameG(this.id);$(this).autocomplete('search');" size="20" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5" name="dualVnameGast23" id="dualVnameGast23" value="{{ $doppelduell[2]->Vorname_S2_G }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                        <input type="text" onload="NnameG(this.id)" oninput="NnameG(this.id)" onfocus="javascript:NnameG(this.id);$(this).autocomplete('search');"  size="20" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" name="dualNnameGast23" id="dualNnameGast23" value="{{ $doppelduell[2]->Nachname_S2_G }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5" onchange="markInput(this); changeSetSumD(3)" name="dualSatz1heim3" id="dualSatz1heim3" value="{{ $doppelduell[2]->Satz_1_Heim }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" onchange="markInput(this); changeSetSumD(3)" name="dualSatz1gast3" id="dualSatz1gast3" value="{{ $doppelduell[2]->Satz_1_Gast }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5" onchange="markInput(this); changeSetSumD(3)" name="dualSatz2heim3" id="dualSatz2heim3" value="{{ $doppelduell[2]->Satz_2_Heim }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" onchange="markInput(this); changeSetSumD(3)" name="dualSatz2gast3" id="dualSatz2gast3" value="{{ $doppelduell[2]->Satz_2_Gast }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5" onchange="markInput(this); changeSetSumD(3)" name="dualSatz3heim3" id="dualSatz3heim3" value="{{ $doppelduell[2]->Satz_3_Heim }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" onchange="markInput(this); changeSetSumD(3)" name="dualSatz3gast3" id="dualSatz3gast3" value="{{ $doppelduell[2]->Satz_3_Gast }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5" readonly="readonly" tabindex="-1" name="dualSetpointHeim3" id="dualSetpointHeim3" value="{{ $doppelduell[2]->Gewonnene_Sätze_Heim }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" readonly="readonly" tabindex="-1" name="dualSetpointGast3" id="dualSetpointGast3" value="{{ $doppelduell[2]->Gewonnene_Sätze_Gast }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5" readonly="readonly" tabindex="-1" name="dualWonSetHeim3" id="dualWonSetHeim3" value="{{ $doppelduell[2]->Heim_Gesamt }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" readonly="readonly" tabindex="-1" name="dualWonSetGast3" id="dualWonSetGast3" value="{{ $doppelduell[2]->Gast_Gesamt }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:sm:text-right focus:bg-green-400 transition duration-300 p-1.5" readonly="readonly" tabindex="-1" name="dualWonMatchHeim3" id="dualWonMatchHeim3" value="{{ $doppelduell[2]->Gewonnene_Spiele_Heim }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black">
                                        <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" readonly="readonly" tabindex="-1" name="dualWonMatchGast3" id="dualWonMatchGast3" value="{{ $doppelduell[2]->Gewonnene_Spiele_Gast }}" />
                                    </td>
                                </tr>
                                      @if (count($doppelduell) >= 4)
                                    <tr class="border-solid border-b-2 border-black w-44 sm:w-auto flex flex-col flex-no wrap sm:table-row mb-2 sm:mb-0">
                                        <input type="hidden" id="doppelDuellID4" name="doppelDuellID4" value="{{ $doppelduell[3]->Duell_ID }}">
                                    <td class="bg-gray-100 h-8 text-black border-solid border-b-2 sm:border-r-2 border-black">
                                        <input type="text" list="arten" size="4" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300" name="dualType4" id="dualType4" value="{{ $doppelduell[3]->Duellart }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                        <input type="text" onload="VnameH(this.id)" oninput="VnameH(this.id)" onfocus="javascript:VnameH(this.id);$(this).autocomplete('search');" size="20" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 sm:p-1.5" name="dualVnameHeim14" id="dualVnameHeim14" value="{{ $doppelduell[3]->Vorname_S1_H }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                        <input type="text"  onload="NnameH(this.id)" oninput="NnameH(this.id)" onfocus="javascript:NnameH(this.id);$(this).autocomplete('search');"  class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" name="dualNnameHeim14" id="dualNnameHeim14" value="{{ $doppelduell[3]->Nachname_S1_H }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                        <input type="text" onload="VnameH(this.id)" oninput="VnameH(this.id)" onfocus="javascript:VnameH(this.id);$(this).autocomplete('search');" size="20" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5" name="dualVnameHeim24" id="dualVnameHeim24" value="{{ $doppelduell[3]->Vorname_S2_H }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                        <input type="text" onload="NnameH(this.id)" oninput="NnameH(this.id)" onfocus="javascript:NnameH(this.id);$(this).autocomplete('search');"  size="20" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" name="dualNnameHeim24" id="dualNnameHeim24" value="{{ $doppelduell[3]->Nachname_S2_H }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                        <input type="text" onload="VnameG(this.id)" oninput="VnameG(this.id)" onfocus="javascript:VnameG(this.id);$(this).autocomplete('search');" size="20" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 sm:p-1.5" name="dualVnameGast14" id="dualVnameGast14" value="{{ $doppelduell[3]->Vorname_S1_G }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                        <input type="text" onload="NnameG(this.id)" oninput="NnameG(this.id)" onfocus="javascript:NnameG(this.id);$(this).autocomplete('search');"  class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" name="dualNnameGast14" id="dualNnameGast14" value="{{ $doppelduell[3]->Nachname_S1_G }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                        <input type="text" onload="VnameG(this.id)" oninput="VnameG(this.id)" onfocus="javascript:VnameG(this.id);$(this).autocomplete('search');" size="20" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5" name="dualVnameGast24" id="dualVnameGast24" value="{{ $doppelduell[3]->Vorname_S2_G }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                        <input type="text" onload="NnameG(this.id)" oninput="NnameG(this.id)" onfocus="javascript:NnameG(this.id);$(this).autocomplete('search');"  size="20" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" name="dualNnameGast24" id="dualNnameGast24" value="{{ $doppelduell[3]->Nachname_S2_G }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5" onchange="markInput(this); changeSetSumD(4)" name="dualSatz1heim4" id="dualSatz1heim4" value="{{ $doppelduell[3]->Satz_1_Heim }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" onchange="markInput(this); changeSetSumD(4)" name="dualSatz1gast4" id="dualSatz1gast4" value="{{ $doppelduell[3]->Satz_1_Gast }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5" onchange="markInput(this); changeSetSumD(4)" name="dualSatz2heim4" id="dualSatz2heim4" value="{{ $doppelduell[3]->Satz_2_Heim }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" onchange="markInput(this); changeSetSumD(4)" name="dualSatz2gast4" id="dualSatz2gast4" value="{{ $doppelduell[3]->Satz_2_Gast }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5" onchange="markInput(this); changeSetSumD(4)" name="dualSatz3heim4" id="dualSatz3heim4" value="{{ $doppelduell[3]->Satz_3_Heim }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" onchange="markInput(this); changeSetSumD(4)" name="dualSatz3gast4" id="dualSatz3gast4" value="{{ $doppelduell[3]->Satz_3_Gast }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5" readonly="readonly" tabindex="-1" name="dualSetpointHeim4" id="dualSetpointHeim4" value="{{ $doppelduell[3]->Gewonnene_Sätze_Heim }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" readonly="readonly" tabindex="-1" name="dualSetpointGast4" id="dualSetpointGast4" value="{{ $doppelduell[3]->Gewonnene_Sätze_Gast }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5" readonly="readonly" tabindex="-1" name="dualWonSetHeim4" id="dualWonSetHeim4" value="{{ $doppelduell[3]->Heim_Gesamt }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" readonly="readonly" tabindex="-1" name="dualWonSetGast4" id="dualWonSetGast4" value="{{ $doppelduell[3]->Gast_Gesamt }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:sm:text-right focus:bg-green-400 transition duration-300 p-1.5" readonly="readonly" tabindex="-1" name="dualWonMatchHeim4" id="dualWonMatchHeim4" value="{{ $doppelduell[3]->Gewonnene_Spiele_Heim }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black">
                                        <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" readonly="readonly" tabindex="-1" name="dualWonMatchGast4" id="dualWonMatchGast4" value="{{ $doppelduell[3]->Gewonnene_Spiele_Gast }}" />
                                    </td>
                                </tr>
                            @endif
                            @endif
                            @endif
                        @endif
                        <tr class="border-black wrap sm:table-row mb-2 sm:mb-0">
                            <td colspan="15" class="invisible">
                            </td>
                            <td class="bg-gray-100 h-8 text-black">
                                <input readonly type="text" size="4" class="bg-gray-100 text-black w-full border-black border-dashed border-r-2 focus:bg-green-400 transition duration-300" readonly="readonly" tabindex="-1" name="sumSetHomeDual" id="sumSetHomeDual" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black">
                                <input readonly type="text" size="4" class="bg-gray-100 text-black w-full border-solid border-r-2 border-black focus:bg-green-400 transition duration-300" readonly="readonly" tabindex="-1" name="sumSetGuestDual" id="sumSetGuestDual" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black">
                                <input readonly type="text" size="4" class="bg-gray-100 text-black w-full border-black border-dashed border-r-2 focus:bg-green-400 transition duration-300" readonly="readonly" tabindex="-1" name="sumWonSetHomeDual" id="sumWonSetHomeDual" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black">
                                <input readonly type="text" size="4" class="bg-gray-100 text-black w-full border-solid border-r-2 border-black focus:bg-green-400 transition duration-300" readonly="readonly" tabindex="-1" name="sumWonSetGuestDual" id="sumWonSetGuestDual" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black">
                                <input readonly type="text" size="4" class="bg-gray-100 text-black w-full border-black border-dashed border-r-2 focus:bg-green-400 transition duration-300" readonly="readonly" tabindex="-1" name="sumWonMatchHomeDual" id="sumWonMatchHomeDual" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black">
                                <input readonly type="text" size="4" class="bg-gray-100 text-black w-full focus:bg-green-400 transition duration-300" readonly="readonly" tabindex="-1" name="sumWonMatchGuestDual" id="sumWonMatchGuestDual" />
                            </td>
                        </tr>
                    </tbody>
                </table>


                <h1 class="pt-5">Einzel</h1>

                <input readonly type="hidden" name="regionID" id="regionID" value="{{ $region->ID }}">
                <input readonly type="hidden" name="HeimID" id="HeimID" value="{{ $homeID }}">
                <input readonly type="hidden" name="GastID" id="GastID" value="{{ $awayID }}">
                <table class="w-full flex flex-row flex-wrap rounded-lg my-5">
                    <thead>
                        <tr class="bg-green-400 flex flex-col sm:table-row rounded-l-lg sm:rounded-none mb-2 sm:mb-0">
                            <th class="w-28 h-8 sm:h-auto  sm:w-4 border-solid sm:border-r-2 align-middle text-center">Art</th>
                            <th class="w-28 h-16 sm:h-auto sm:w-4 border-solid sm:border-r-2 align-middle text-center" colspan="2">Spieler: Heim</th>
                            <th class="w-28 h-16 sm:h-auto sm:w-4 border-solid sm:border-r-2 align-middle text-center" rowspan="2" colspan="2">Spieler: Gast</th>
                            <th class="w-28 h-48 sm:h-auto sm:w-4 border-solid sm:border-r-2 align-middle text-center" rowspan="6" colspan="6">Satzergebnisse</th>
                            <th class="w-28 h-16 sm:h-auto sm:w-4 border-solid sm:border-r-2 align-middle text-center" rowspan="2" colspan="2">Summe: Spielpunkte</th>
                            <th class="w-28 h-16 sm:h-auto sm:w-4 border-solid sm:border-r-2 align-middle text-center" rowspan="2" colspan="2">Summe: Sätze</th>
                            <th class="w-28 h-16 sm:h-auto sm:w-4 border-solid align-middle text-center" rowspan="2" colspan="2">Punkte</th>
                        </tr>
                        @if (count($soloduell) >= 2)
                            <tr class="bg-green-400 flex flex-col sm:table-row rounded-l-lg sm:rounded-none mb-2 sm:mb-0">
                                <th class="w-28 h-8 sm:h-auto  sm:w-4 border-solid sm:border-r-2 sm:text-center">Art</th>
                                <th class="w-28 h-16 sm:h-auto sm:w-4 border-solid sm:border-r-2 sm:text-center" colspan="2">Spieler: Heim</th>
                                <th class="w-28 h-16 sm:h-auto sm:w-4 border-solid sm:border-r-2 sm:text-center" rowspan="2" colspan="2">Spieler: Gast</th>
                                <th class="w-28 h-48 sm:h-auto sm:w-4 border-solid sm:border-r-2 sm:text-center" rowspan="6" colspan="6">Satzergebnisse</th>
                                <th class="w-28 h-16 sm:h-auto sm:w-4 border-solid sm:border-r-2 sm:text-center" rowspan="2" colspan="2">Summe: Spielpunkte</th>
                                <th class="w-28 h-16 sm:h-auto sm:w-4 border-solid sm:border-r-2 sm:text-center" rowspan="2" colspan="2">Summe: Sätze</th>
                                <th class="w-28 h-16 sm:h-auto sm:w-4 border-solid sm:text-center" rowspan="2" colspan="2">Punkte</th>

                            </tr>
                           <!-- @if (count($soloduell) >= 3)
                                <tr class="bg-green-400 flex flex-col sm:table-row rounded-l-lg sm:rounded-none mb-2 sm:mb-0">
                                    <th class="w-28 h-8 sm:h-auto  sm:w-4 border-solid sm:border-r-2 sm:text-center">Art</th>
                                    <th class="w-28 h-16 sm:h-auto sm:w-4 border-solid sm:border-r-2 sm:text-center" colspan="2">Spieler: Heim</th>
                                    <th class="w-28 h-16 sm:h-auto sm:w-4 border-solid sm:border-r-2 sm:text-center" rowspan="2" colspan="2">Spieler: Gast</th>
                                    <th class="w-28 h-48 sm:h-auto sm:w-4 border-solid sm:border-r-2 sm:text-center" rowspan="6" colspan="6">Satzergebnisse</th>
                                    <th class="w-28 h-16 sm:h-auto sm:w-4 border-solid sm:border-r-2 sm:text-center" rowspan="2" colspan="2">Summe: Spielpunkte</th>
                                    <th class="w-28 h-16 sm:h-auto sm:w-4 border-solid sm:border-r-2 sm:text-center" rowspan="2" colspan="2">Summe: Sätze</th>
                                    <th class="w-28 h-16 sm:h-auto sm:w-4 border-solid sm:text-center" rowspan="2" colspan="2">Punkte</th>

                                </tr>
                                @if (count($soloduell) >= 4)
                                    <tr class="bg-green-400 flex flex-col sm:table-row rounded-l-lg sm:rounded-none mb-2 sm:mb-0">
                                        <th class="w-28 h-8 sm:h-auto  sm:w-4 border-solid sm:border-r-2 sm:text-center">Art</th>
                                        <th class="w-28 h-16 sm:h-auto sm:w-4 border-solid sm:border-r-2 sm:text-center" colspan="2">Spieler: Heim</th>
                                        <th class="w-28 h-16 sm:h-auto sm:w-4 border-solid sm:border-r-2 sm:text-center" rowspan="2" colspan="2">Spieler: Gast</th>
                                        <th class="w-28 h-48 sm:h-auto sm:w-4 border-solid sm:border-r-2 sm:text-center" rowspan="6" colspan="6">Satzergebnisse</th>
                                        <th class="w-28 h-16 sm:h-auto sm:w-4 border-solid sm:border-r-2 sm:text-center" rowspan="2" colspan="2">Summe: Spielpunkte</th>
                                        <th class="w-28 h-16 sm:h-auto sm:w-4 border-solid sm:border-r-2 sm:text-center" rowspan="2" colspan="2">Summe: Sätze</th>
                                        <th class="w-28 h-16 sm:h-auto sm:w-4 border-solid sm:text-center" rowspan="2" colspan="2">Punkte</th>

                                    </tr>
                                @endif
                            @endif -->
                        @endif
                    </thead>
                    <thead>
                        <tr class="flex flex-col flex-no wrap sm:table-row rounded-l-lg sm:rounded-none mb-2 sm:mb-0">
                            <th class="border-solid h-8 sm:h-auto border-t-2 border-green-500 sm:border-white sm:border-r-2 text-center">Art</th>
                            <th class="text-center h-8 sm:h-auto">Vorname</th>
                            <th class="border-solid h-8 sm:h-auto sm:border-r-2 text-center">Nachname</th>
                            <th class="text-center h-8 sm:h-auto">Vorname</th>
                            <th class="border-solid h-8 sm:h-auto sm:border-r-2 text-center">Nachname</th>
                            <th class="w-full sm:w-4 h-16 sm:h-auto text-center" colspan="2">1. Satz</th>
                            <th class="w-full sm:w-4 h-16 sm:h-auto text-center" colspan="2">2. Satz</th>
                            <th class="w-full sm:w-4 h-16 sm:h-auto text-center border-solid sm:border-r-2" colspan="2">3. Satz</th>
                            <th class="w-full sm:w-4 h-8 sm:h-auto text-center">Heim</th>
                            <th class="w-full sm:w-4 h-8 sm:h-auto text-center border-solid sm:border-r-2">Gast</th>
                            <th class="w-full sm:w-4 h-8 sm:h-auto text-center">Heim</th>
                            <th class="w-full sm:w-4 h-8 sm:h-auto text-center border-solid sm:border-r-2">Gast</th>
                            <th class="w-full sm:w-4 h-8 sm:h-auto text-center">Heim</th>
                            <th class="w-full border-b-2 border-green-500 sm:w-4 h-8 sm:h-auto text-center">Gast</th>
                        </tr>
                        @if (count($soloduell) >= 2)
                            <tr class="flex flex-col flex-no wrap sm:table-row rounded-l-lg sm:rounded-none mb-2 sm:mb-0">
                                <th class="border-solid h-8 sm:h-auto border-t-2 border-green-500 sm:border-white sm:border-r-2 text-center">Art</th>
                                <th class="text-center h-8 sm:h-auto">Vorname</th>
                                <th class="border-solid h-8 sm:h-auto sm:border-r-2 text-center">Nachname</th>
                                <th class="text-center h-8 sm:h-auto">Vorname</th>
                                <th class="border-solid h-8 sm:h-auto sm:border-r-2 text-center">Nachname</th>
                                <th class="w-full sm:w-4 h-16 sm:h-auto text-center" colspan="2">1. Satz</th>
                                <th class="w-full sm:w-4 h-16 sm:h-auto text-center" colspan="2">2. Satz</th>
                                <th class="w-full sm:w-4 h-16 sm:h-auto text-center border-solid sm:border-r-2" colspan="2">3. Satz</th>
                                <th class="w-full sm:w-4 h-8 sm:h-auto text-center">Heim</th>
                                <th class="w-full sm:w-4 h-8 sm:h-auto text-center border-solid sm:border-r-2">Gast</th>
                                <th class="w-full sm:w-4 h-8 sm:h-auto text-center">Heim</th>
                                <th class="w-full sm:w-4 h-8 sm:h-auto text-center border-solid sm:border-r-2">Gast</th>
                                <th class="w-full sm:w-4 h-8 sm:h-auto text-center">Heim</th>
                                <th class="w-full border-b-2 border-green-500 sm:w-4 h-8 sm:h-auto text-center">Gast</th>
                            </tr>
                         <!--   @if (count($soloduell) >= 3)
                                <tr class="flex flex-col flex-no wrap sm:table-row rounded-l-lg sm:rounded-none mb-2 sm:mb-0">
                                    <th class="border-solid h-8 sm:h-auto border-t-2 border-green-500 sm:border-white sm:border-r-2 text-center">Art</th>
                                    <th class="text-center h-8 sm:h-auto">Vorname</th>
                                    <th class="border-solid h-8 sm:h-auto sm:border-r-2 text-center">Nachname</th>
                                    <th class="text-center h-8 sm:h-auto">Vorname</th>
                                    <th class="border-solid h-8 sm:h-auto sm:border-r-2 text-center">Nachname</th>
                                    <th class="w-full sm:w-4 h-16 sm:h-auto text-center" colspan="2">1. Satz</th>
                                    <th class="w-full sm:w-4 h-16 sm:h-auto text-center" colspan="2">2. Satz</th>
                                    <th class="w-full sm:w-4 h-16 sm:h-auto text-center border-solid sm:border-r-2" colspan="2">3. Satz</th>
                                    <th class="w-full sm:w-4 h-8 sm:h-auto text-center">Heim</th>
                                    <th class="w-full sm:w-4 h-8 sm:h-auto text-center border-solid sm:border-r-2">Gast</th>
                                    <th class="w-full sm:w-4 h-8 sm:h-auto text-center">Heim</th>
                                    <th class="w-full sm:w-4 h-8 sm:h-auto text-center border-solid sm:border-r-2">Gast</th>
                                    <th class="w-full sm:w-4 h-8 sm:h-auto text-center">Heim</th>
                                    <th class="w-full border-b-2 border-green-500 sm:w-4 h-8 sm:h-auto text-center">Gast</th>
                                </tr>
                                @if (count($soloduell) >= 4)
                                    <tr class="flex flex-col flex-no wrap sm:table-row rounded-l-lg sm:rounded-none mb-2 sm:mb-0">
                                        <th class="border-solid h-8 sm:h-auto border-t-2 border-green-500 sm:border-white sm:border-r-2 text-center">Art</th>
                                        <th class="text-center h-8 sm:h-auto">Vorname</th>
                                        <th class="border-solid h-8 sm:h-auto sm:border-r-2 text-center">Nachname</th>
                                        <th class="text-center h-8 sm:h-auto">Vorname</th>
                                        <th class="border-solid h-8 sm:h-auto sm:border-r-2 text-center">Nachname</th>
                                        <th class="w-full sm:w-4 h-16 sm:h-auto text-center" colspan="2">1. Satz</th>
                                        <th class="w-full sm:w-4 h-16 sm:h-auto text-center" colspan="2">2. Satz</th>
                                        <th class="w-full sm:w-4 h-16 sm:h-auto text-center border-solid sm:border-r-2" colspan="2">3. Satz</th>
                                        <th class="w-full sm:w-4 h-8 sm:h-auto text-center">Heim</th>
                                        <th class="w-full sm:w-4 h-8 sm:h-auto text-center border-solid sm:border-r-2">Gast</th>
                                        <th class="w-full sm:w-4 h-8 sm:h-auto text-center">Heim</th>
                                        <th class="w-full sm:w-4 h-8 sm:h-auto text-center border-solid sm:border-r-2">Gast</th>
                                        <th class="w-full sm:w-4 h-8 sm:h-auto text-center">Heim</th>
                                        <th class="w-full border-b-2 border-green-500 sm:w-4 h-8 sm:h-auto text-center">Gast</th>
                                    </tr>
                                @endif
                            @endif -->
                        @endif
                    </thead>
                    <tbody class="flex-1 sm:flex-none">
                        @if (count($soloduell) >= 1)
                            <tr class="border-solid border-b-2 border-black w-44 sm:w-auto flex flex-col flex-no wrap sm:table-row mb-2 sm:mb-0">
                                <input readonly type="hidden" id="duellID1" name="duellID1" value="{{ $soloduell[0]->Duell_ID }}">
                                <td class="bg-gray-100 h-8 text-black border-solid border-b-2 sm:border-r-2 border-black">
                                    <input readonly type="text" list="arten" size="4" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300" name="soloType1" id="soloType1" value="{{ $soloduell[0]->Duellart }}" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                    <input readonly type="text" size="20" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 sm:p-1.5" name="soloVnameHeim1" id="soloVnameHeim1" value="{{ $soloduell[0]->Vorname_S1 }}" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                    <input readonly type="text" size="20" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" name="soloNnameHeim1" id="soloNnameHeim1" value="{{ $soloduell[0]->Nachname_S1 }}" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                    <input readonly type="text" size="20" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5" name="soloVnameGast1" id="soloVnameGast1" value="{{ $soloduell[0]->Vorname_S2 }}" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                    <input readonly type="text" size="20" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" name="soloNnameGast1" id="soloNnameGast1" value="{{ $soloduell[0]->Nachname_S2 }}" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                    <input readonly type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5" onchange="markInput(this); changeSetSumS(1)" name="soloSatz1heim1" id="soloSatz1heim1" value="{{ $soloduell[0]->Satz_1_Heim }}" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                    <input readonly type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" onchange="markInput(this); changeSetSumS(1)" name="soloSatz1gast1" id="soloSatz1gast1" value="{{ $soloduell[0]->Satz_1_Gast }}" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                    <input readonly type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5" onchange="markInput(this); changeSetSumS(1)" name="soloSatz2heim1" id="soloSatz2heim1" value="{{ $soloduell[0]->Satz_2_Heim }}" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                    <input readonly type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" onchange="markInput(this); changeSetSumS(1)" name="soloSatz2gast1" id="soloSatz2gast1" value="{{ $soloduell[0]->Satz_2_Gast }}" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                    <input readonly type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5" onchange="markInput(this); changeSetSumS(1)" name="soloSatz3heim1" id="soloSatz3heim1" value="{{ $soloduell[0]->Satz_3_Heim }}" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                    <input readonly type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" onchange="markInput(this); changeSetSumS(1)" name="soloSatz3gast1" id="soloSatz3gast1" value="{{ $soloduell[0]->Satz_3_Gast }}" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                    <input readonly type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5" readonly="readonly" tabindex="-1" name="soloSetpointHeim1" id="soloSetpointHeim1" value="{{ $soloduell[0]->Gewonnene_Sätze_Heim }}" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                    <input readonly type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" readonly="readonly" tabindex="-1" name="soloSetpointGast1" id="soloSetpointGast1" value="{{ $soloduell[0]->Gewonnene_Sätze_Gast }}" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                    <input readonly type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5" readonly="readonly" tabindex="-1" name="soloWonSetHeim1" id="soloWonSetHeim1" value="{{ $soloduell[0]->Heim_Gesamt }}" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                    <input readonly type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" readonly="readonly" tabindex="-1" name="soloWonSetGast1" id="soloWonSetGast1" value="{{ $soloduell[0]->Gast_Gesamt }}" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                    <input readonly type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:sm:text-right focus:bg-green-400 transition duration-300 p-1.5" readonly="readonly" tabindex="-1" name="soloWonMatchHeim1" id="soloWonMatchHeim1" value="{{ $soloduell[0]->Gewonnene_Spiele_Heim }}" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black">
                                    <input readonly type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" readonly="readonly" tabindex="-1" name="soloWonMatchGast1" id="soloWonMatchGast1" value="{{ $soloduell[0]->Gewonnene_Spiele_Gast }}" />
                                </td>
                            </tr>
                            @if (count($soloduell) >= 2)
                                <tr class="border-solid border-b-2 border-black w-44 sm:w-auto flex flex-col flex-no wrap sm:table-row mb-2 sm:mb-0">
                                    <input readonly type="hidden" id="duellID2" name="duellID2" value="{{ $soloduell[1]->Duell_ID }}">
                                    <td class="bg-gray-100 h-8 text-black border-solid border-b-2 sm:border-r-2 border-black">
                                        <input readonly type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300" onChange="markInput(this)" name="soloType2" id="soloType2" value="{{ $soloduell[1]->Duellart }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                        <input readonly type="text" size="20" size="20" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5" onChange="markInput(this)" name="soloVnameHeim2" id="soloVnameHeim2" value="{{ $soloduell[1]->Vorname_S1 }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                        <input readonly type="text"  size="20" class="bg-gray-100 p-1.5 text-black w-full focus:bg-green-400 transition duration-300" onChange="markInput(this)" name="soloNnameHeim2" id="soloNnameHeim2" value="{{ $soloduell[1]->Nachname_S1 }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                        <input readonly type="text" size="20" class="bg-gray-100 text-black w-full h-full sm:text-right  focus:bg-green-400 transition duration-300 p-1.5" onChange="markInput(this)" name="soloVnameGast2" id="soloVnameGast2" value="{{ $soloduell[1]->Vorname_S2 }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                        <input readonly type="text" size="20" class="bg-gray-100 p-1.5 text-black w-full focus:bg-green-400 transition duration-300" onChange="markInput(this)" name="soloNnameGast2" id="soloNnameGast2" value="{{ $soloduell[1]->Nachname_S2 }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                        <input readonly type="text" size="4" class="bg-gray-100 sm:text-right  text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" onchange="markInput(this); changeSetSumS(2)" name="soloSatz1heim2" id="soloSatz1heim2" value="{{ $soloduell[1]->Satz_1_Heim }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                        <input readonly type="text" size="4" class="bg-gray-100 p-1.5 text-black w-full focus:bg-green-400 transition duration-300" onchange="markInput(this); changeSetSumS(2)" name="soloSatz1gast2" id="soloSatz1gast2" value="{{ $soloduell[1]->Satz_1_Gast }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                        <input readonly type="text" size="4" class="bg-gray-100 sm:text-right text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" onchange="markInput(this); changeSetSumS(2)" name="soloSatz2heim2" id="soloSatz2heim2" value="{{ $soloduell[1]->Satz_2_Heim }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                        <input readonly type="text" size="4" class="bg-gray-100 p-1.5 text-black w-full focus:bg-green-400 transition duration-300" onchange="markInput(this); changeSetSumS(2)" name="soloSatz2gast2" id="soloSatz2gast2" value="{{ $soloduell[1]->Satz_2_Gast }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                        <input readonly type="text" size="4" class="bg-gray-100 sm:text-right  text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" onchange="markInput(this); changeSetSumS(2)" name="soloSatz3heim2" id="soloSatz3heim2" value="{{ $soloduell[1]->Satz_3_Heim }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                        <input readonly type="text" size="4" class="bg-gray-100 p-1.5 text-black w-full focus:bg-green-400 transition duration-300" onchange="markInput(this); changeSetSumS(2)" name="soloSatz3gast2" id="soloSatz3gast2" value="{{ $soloduell[1]->Satz_3_Gast }}" />
                                    </td>
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                        <input readonly type="text" size="4" class="bg-gray-100 sm:text-right  text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" readonly="readonly" tabindex="-1" name="soloSetpointHeim2" id="soloSetpointHeim2" value="{{ $soloduell[1]->Gewonnene_Sätze_Heim }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                        <input readonly type="text" size="4" class="bg-gray-100 p-1.5 text-black w-full focus:bg-green-400 transition duration-300" readonly="readonly" tabindex="-1" name="soloSetpointGast2" id="soloSetpointGast2" value="{{ $soloduell[1]->Gewonnene_Sätze_Gast }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                        <input readonly type="text" size="4" class="bg-gray-100 sm:text-right  text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" name="soloWonSetHeim2" readonly="readonly" tabindex="-1" id="soloWonSetHeim2" value="{{ $soloduell[1]->Heim_Gesamt }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                        <input readonly type="text" size="4" class="bg-gray-100 p-1.5 text-black w-full focus:bg-green-400 transition duration-300" readonly="readonly" tabindex="-1" name="soloWonSetGast2" id="soloWonSetGast2" value="{{ $soloduell[1]->Gast_Gesamt }}" />
                                    <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                        <input readonly type="text" size="4" class="bg-gray-100 sm:text-right  text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" name="soloWonMatchHeim2" readonly="readonly" tabindex="-1" id="soloWonMatchHeim2" value="{{ $soloduell[1]->Gewonnene_Spiele_Heim }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black">
                                        <input readonly type="text" size="4" class="bg-gray-100 p-1.5 text-black w-full focus:bg-green-400 transition duration-300" readonly="readonly" tabindex="-1" name="soloWonMatchGast2" id="soloWonMatchGast2" value="{{ $soloduell[1]->Gewonnene_Spiele_Gast }}" />
                                    </td>
                                </tr>
                               <!-- @if (count($soloduell) >= 3)
                                    <tr class="border-solid border-b-2 border-black flex flex-col flex-no wrap sm:table-row mb-2 sm:mb-0">
                                        <input readonly type="hidden" id="duellID3" name="duellID3" value="{{ $soloduell[2]->Duell_ID }}">
                                        <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                            <input readonly type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300" name="soloType3" id="soloType3" value="{{ $soloduell[2]->Duellart }}" />
                                        </td>
                                        <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                            <input readonly type="text" size="20" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5" name="soloVnameHeim3" id="soloVnameHeim3" onChange="markInput(this)" value="{{ $soloduell[2]->Vorname_S1 }}" />
                                        </td>
                                        <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                            <input readonly type="text"  size="20" class="bg-gray-100 text-black w-full h-full  focus:bg-green-400 transition duration-300 p-1.5" name="soloNnameHeim3" id="soloNnameHeim3" onChange="markInput(this)" value="{{ $soloduell[2]->Nachname_S1 }}" />
                                        </td>
                                        <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                            <input readonly type="text" size="20" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5" name="soloVnameGast3" id="soloVnameGast3" onChange="markInput(this)" value="{{ $soloduell[2]->Vorname_S2 }}" />
                                        </td>
                                        <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                            <input readonly type="text" size="20" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" name="soloNnameGast3" id="soloNnameGast3" onChange="markInput(this)" value="{{ $soloduell[2]->Nachname_S2 }}" />
                                        </td>
                                        <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                            <input readonly type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5" name="soloSatz1heim3" id="soloSatz1heim3" onchange="markInput(this); changeSetSumS(3)" value="{{ $soloduell[2]->Satz_1_Heim }}" />
                                        </td>
                                        <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                            <input readonly type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" name="soloSatz1gast3" id="soloSatz1gast3" onchange="markInput(this); changeSetSumS(3)" value="{{ $soloduell[2]->Satz_1_Gast }}" />
                                        </td>
                                        <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                            <input readonly type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5" name="soloSatz2heim3" id="soloSatz2heim3" onchange="markInput(this); changeSetSumS(3)" value="{{ $soloduell[2]->Satz_2_Heim }}" />
                                        </td>
                                        <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                            <input readonly type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" name="soloSatz2gast3" id="soloSatz2gast3" onchange="markInput(this); changeSetSumS(3)" value="{{ $soloduell[2]->Satz_2_Gast }}" />
                                        </td>
                                        <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                            <input readonly type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5" name="soloSatz3heim3" id="soloSatz3heim3" onchange="markInput(this); changeSetSumS(3)" value="{{ $soloduell[2]->Satz_3_Heim }}" />
                                        </td>
                                        <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                            <input readonly type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" name="soloSatz3gast3" id="soloSatz3gast3" onchange="markInput(this); changeSetSumS(3)" value="{{ $soloduell[2]->Satz_3_Gast }}" />
                                        </td>
                                        <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                            <input readonly type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5" readonly="readonly" tabindex="-1" name="soloSetpointHeim3" id="soloSetpointHeim3" onChange="markInput(this)" value="{{ $soloduell[2]->Gewonnene_Sätze_Heim }}" />
                                        </td>
                                        <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                            <input readonly type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" readonly="readonly" tabindex="-1" name="soloSetpointGast3" id="soloSetpointGast3" onChange="markInput(this)" value="{{ $soloduell[2]->Gewonnene_Sätze_Gast }}" />
                                        </td>
                                        <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                            <input readonly type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5" readonly="readonly" tabindex="-1" name="soloWonSetHeim3" id="soloWonSetHeim3" onChange="markInput(this)" value="{{ $soloduell[2]->Heim_Gesamt }}" />
                                        </td>
                                        <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                            <input readonly type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" readonly="readonly" tabindex="-1" name="soloWonSetGast3" id="soloWonSetGast3" onChange="markInput(this)" value="{{ $soloduell[2]->Gast_Gesamt }}" />
                                        </td>
                                        <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                            <input readonly type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5" readonly="readonly" tabindex="-1" name="soloWonMatchHeim3" id="soloWonMatchHeim3" onChange="markInput(this)" value="{{ $soloduell[2]->Gewonnene_Spiele_Heim }}" />
                                        </td>
                                        <td class="bg-gray-100 h-8 text-black">
                                            <input readonly type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" readonly="readonly" tabindex="-1" name="soloWonMatchGast3" id="soloWonMatchGast3" onChange="markInput(this)" value="{{ $soloduell[2]->Gewonnene_Spiele_Gast }}" />
                                        </td>
                                    </tr>
                                    @if (count($soloduell) >= 4)
                                        <tr class="border-solid border-b-2 border-black flex flex-col flex-no wrap sm:table-row mb-2 sm:mb-0">
                                            <input readonly type="hidden" id="duellID4" name="duellID4" value="{{ $soloduell[3]->Duell_ID }}">
                                            <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                                <input readonly type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300" name="soloType4" id="soloType4" value="{{ $soloduell[3]->Duellart }}" />
                                            </td>
                                            <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                                <input readonly type="text"  size="20" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5" name="soloVnameHeim4" id="soloVnameHeim4" onChange="markInput(this)" value="{{ $soloduell[3]->Vorname_S1 }}" />
                                            </td>
                                            <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                                <input readonly type="text"  size="20" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" name="soloNnameHeim4" id="soloNnameHeim4" onChange="markInput(this)" value="{{ $soloduell[3]->Nachname_S1 }}" />
                                            </td>
                                            <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                                <input readonly type="text"  size="20" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5" name="soloVnameGast4" id="soloVnameGast4" onChange="markInput(this)" value="{{ $soloduell[3]->Vorname_S2 }}" />
                                            </td>
                                            <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                                <input readonly type="text"  size="20" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" name="soloNnameGast4" id="soloNnameGast4" onChange="markInput(this)" value="{{ $soloduell[3]->Nachname_S2 }}" />
                                            </td>
                                            <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                                <input readonly type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5" name="soloSatz1heim4" id="soloSatz1heim4" onchange="markInput(this); changeSetSumS(4)" value="{{ $soloduell[3]->Satz_1_Heim }}" />
                                            </td>
                                            <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                                <input readonly type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" name="soloSatz1gast4" id="soloSatz1gast4" onchange="markInput(this); changeSetSumS(4)" value="{{ $soloduell[3]->Satz_1_Gast }}" />
                                            </td>
                                            <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                                <input readonly type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5" name="soloSatz2heim4" id="soloSatz2heim4" onchange="markInput(this); changeSetSumS(4)" value="{{ $soloduell[3]->Satz_2_Heim }}" />
                                            </td>
                                            <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                                <input readonly type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" name="soloSatz2gast4" id="soloSatz2gast4" onchange="markInput(this); changeSetSumS(4)" value="{{ $soloduell[3]->Satz_2_Gast }}" />
                                            </td>
                                            <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                                <input readonly type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5" name="soloSatz3heim4" id="soloSatz3heim4" onchange="markInput(this); changeSetSumS(4)" value="{{ $soloduell[3]->Satz_3_Heim }}" />
                                            </td>
                                            <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                                <input readonly type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" name="soloSatz3gast4" id="soloSatz3gast4" onchange="markInput(this); changeSetSumS(4)" value="{{ $soloduell[3]->Satz_3_Gast }}" />
                                            </td>
                                            <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                                <input readonly type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5" readonly="readonly" tabindex="-1" name="soloSetpointHeim4" id="soloSetpointHeim4" value="{{ $soloduell[3]->Gewonnene_Sätze_Heim }}" />
                                            </td>
                                            <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                                <input readonly type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" readonly="readonly" tabindex="-1" name="soloSetpointGast4" id="soloSetpointGast4" value="{{ $soloduell[3]->Gewonnene_Sätze_Gast }}" />
                                            </td>
                                            <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                                <input readonly type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5" readonly="readonly" tabindex="-1" name="soloWonSetHeim4" id="soloWonSetHeim4" value="{{ $soloduell[3]->Heim_Gesamt }}" />
                                            </td>
                                            <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                                <input readonly type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" readonly="readonly" tabindex="-1" name="soloWonSetGast4" id="soloWonSetGast4" value="{{ $soloduell[3]->Gast_Gesamt }}" />
                                            </td>
                                            <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                                <input readonly type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5" readonly="readonly" tabindex="-1" name="soloWonMatchHeim4" id="soloWonMatchHeim4" value="{{ $soloduell[3]->Gewonnene_Spiele_Heim }}" />
                                            </td>
                                            <td class="bg-gray-100 h-8 text-black">
                                                <input readonly type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" readonly="readonly" tabindex="-1" name="soloWonMatchGast4" id="soloWonMatchGast4" value="{{ $soloduell[3]->Gewonnene_Spiele_Gast }}" />
                                            </td>
                                        </tr>
                                    @endif
                                @endif -->
                            @endif
                        @endif
                        <tr class="border-black wrap sm:table-row mb-2 sm:mb-0">
                            <td colspan="11" class="invisible">
                            </td>
                            <td class="bg-gray-100 h-8 text-black">
                                <input readonly type="text" size="4" class="bg-gray-100 text-black w-full border-black border-dashed border-r-2 focus:bg-green-400 transition duration-300" readonly="readonly" tabindex="-1" name="sumSetHomeSolo" id="sumSetHomeSolo" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black">
                                <input readonly type="text" size="4" class="bg-gray-100 text-black w-full border-solid border-r-2 border-black focus:bg-green-400 transition duration-300" readonly="readonly" tabindex="-1" name="sumSetGuestSolo" id="sumSetGuestSolo" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black">
                                <input readonly type="text" size="4" class="bg-gray-100 text-black w-full border-black border-dashed border-r-2 focus:bg-green-400 transition duration-300" readonly="readonly" tabindex="-1" name="sumWonSetHomeSolo" id="sumWonSetHomeSolo" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black">
                                <input readonly type="text" size="4" class="bg-gray-100 text-black w-full border-solid border-r-2 border-black focus:bg-green-400 transition duration-300" readonly="readonly" tabindex="-1" name="sumWonSetGuestSolo" id="sumWonSetGuestSolo" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black">
                                <input readonly type="text" size="4" class="bg-gray-100 text-black w-full border-black border-dashed border-r-2 focus:bg-green-400 transition duration-300" readonly="readonly" tabindex="-1" name="sumWonMatchHomeSolo" id="sumWonMatchHomeSolo" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black">
                                <input readonly type="text" size="4" class="bg-gray-100 text-black w-full focus:bg-green-400 transition duration-300" readonly="readonly" tabindex="-1" name="sumWonMatchGuestSolo" id="sumWonMatchGuestSolo" />
                            </td>
                        </tr>
                    </tbody>
                </table>
              
              
            </form>
           
   @endsection


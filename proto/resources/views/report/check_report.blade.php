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

#-----------------Neue Herangehensweise-----------------------------
$soloduell = QueryController::getSolo($matchID);
$doppelduell = QueryController::getDouble($matchID);
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
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <script type="text/javascript" src="{{ URL::asset('js/script.js') }}"></script>
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    </head>
    <section>
        <h3 class="font-bold  text-2xl">Spieleberichtsbogen</h3>
    </section>
    <section class="mt-10  overflow-x-auto">
        <div class="w-full flex flex-row flex-no-wrap my-5 justify-center">
            <form class="flex flex-col mx-3 mb-6" method="POST" onsubmit="return validateInputs();" action="{{ url('/overview') }}">
                @csrf
                <input type="hidden" id="matchID" name="matchID" value="{{ $matchID }}">
                <input type="hidden" id="soloCount" name="soloCount" value="{{ count($soloduell) }}">
                <input type="hidden" id="doubleCount" name="doubleCount" value="{{ count($doppelduell) }}">
                <div class="flex mb-4">


                    <div class="w-1/4 bg-green-400 h-12">
                        <label class="block text-gray-900 text-sm font-bold mb-2 ml-3">Staffel:</label>
                        <input type="text" oninput="hello()" id="liga" name="liga" class="bg-gray-100 text-gray-900 w-full focus:outline-none border-b-4 border-gray-700 focus:border-green-500 transition duration-500 px-3 pb-3" value="{{ $liga->Name }}">
                    </div>

                    <div class="w-1/4 bg-green-400 h-12">
                        <label class="block text-gray-900 text-sm font-bold mb-2 ml-3" for="home">Heimverein:</label>
                        <input oninput="MannschaftenH()" type="text" name="tfHome" id="tfHome" class="bg-gray-100 text-gray-900  w-full focus:outline-none border-b-4 border-gray-700 focus:border-green-500 transition duration-500 px-3 pb-3" value="{{ $match->Heim }}">
                    </div>
                    <div class="w-1/4 bg-green-400 h-12">
                        <label class="block text-gray-900 text-sm font-bold mb-2 ml-3" for="away">Gastverein:</label>
                        <input type="text" oninput="MannschaftenG()" name="tfAway" id="tfAway" class="bg-gray-100 text-gray-900  w-full focus:outlie-none border-b-4 border-gray-700 focus:border-green-500 transition duration-500 px-3 pb-3" value="{{ $match->Gast }}">
                    </div>
                    <div class="w-1/4 bg-green-400 h-12">
                        <label class="block text-gray-900 text-sm font-bold mb-2 ml-3" for="away">Schiedsrichter:</label>
                        <input type="text" name="tfPlace" id="tfPlace" class="bg-gray-100 text-gray-900  w-full focus:outline-none border-b-4 border-gray-700 focus:border-green-500 transition duration-500 px-3 pb-3" value="{{ $match->Schiedsrichter }}">
                    </div>
                    <div class="w-1/4 bg-green-400 h-12">
                        <label class="block text-gray-900 text-sm font-bold mb-2 ml-3" for="away">Austragungsort:</label>
                        <input type="text" name="tfPlace" id="tfPlace" class="bg-gray-100 text-gray-900  w-full focus:outline-none border-b-4 border-gray-700 focus:border-green-500 transition duration-500 px-3 pb-3" value="{{ $match->Spielort }}">
                    </div>
                </div>
                <table class="border-collapse w-full">
                    <tr class="bg-green-400 rounded-lg">
                        <th class="w-4 border-solid border-r-2 text-center">Art</th>
                        <th class="w-4 border-solid border-r-2 text-center" colspan="2">Spieler: Heim</th>
                        <th class="w-4 border-solid border-r-2 text-center" colspan="2">Spieler: Gast</th>
                        <th class="w-4 border-solid border-r-2 text-center" class="w-4" colspan="6">Satzergebnisse</th>
                        <th class="w-4 border-solid border-r-2 text-center" class="w-4" colspan="2">Summe: Spielpunkte</th>
                        <th class="w-4 border-solid border-r-2 text-center" class="w-4" colspan="2">Summe: Sätze</th>
                        <th class="w-4 border-solid text-center" class="w-4" colspan="2">Punkte</th>

                    </tr>
                    <tr class="">
                        <th class="border-solid border-r-2 text-center"></th>
                        <th class="text-center">Vorname</th>
                        <th class="border-solid border-r-2 text-center">Nachname</th>
                        <th class="text-center">Vorname</th>
                        <th class="border-solid border-r-2 text-center">Nachname</th>
                        <th class="w-4 text-center" colspan="2">1. Satz</th>
                        <th class="w-4 text-center" colspan="2">2. Satz</th>
                        <th class="w-4 text-center border-solid border-r-2" colspan="2">3. Satz</th>
                        <th class="w-4 text-center">Heim</th>
                        <th class="w-4 text-center border-solid border-r-2">Gast</th>
                        <th class="w-4 text-center">Heim</th>
                        <th class="w-4 text-center border-solid border-r-2">Gast</th>
                        <th class="w-4 text-center">Heim</th>
                        <th class="w-4 text-center">Gast</th>
                    </tr>
                    @if (count($soloduell) >= 1)
                        <tr class="border-solid border-b-2 border-black">
                            <input type="hidden" id="duellID1" name="duellID1" value="{{ $soloduell[0]->Duell_ID }}">
                            <td class="bg-gray-100 text-black border-solid border-r-2 border-black">
                                <input type="text" list="arten" size="4" class="bg-gray-100 text-black w-full focus:bg-green-400 transition duration-300" name="soloType1" id="soloType1" value="{{ $soloduell[0]->Duellart }}" />
                            </td>
                            <td class="bg-gray-100 text-black border-dashed border-r-2 border-black">
                                <input type="text" size="20" class="bg-gray-100 text-black w-full text-right focus:bg-green-400 transition duration-300 p-1.5" name="soloVnameHeim1" id="soloVnameHeim1" value="{{ $soloduell[0]->Vorname_S1 }}" />
                            </td>
                            <td class="bg-gray-100 text-black border-solid border-r-2 border-black">
                                <input type="text" size="20" class="bg-gray-100 text-black w-full focus:bg-green-400 transition duration-300 p-1.5" name="soloNnameHeim1" id="soloNnameHeim1" value="{{ $soloduell[0]->Nachname_S1 }}" />
                            </td>
                            <td class="bg-gray-100 text-black border-dashed border-r-2 border-black">
                                <input type="text" size="20" class="bg-gray-100 text-black w-full text-right focus:bg-green-400 transition duration-300 p-1.5" name="soloVnameGast1" id="soloVnameGast1" value="{{ $soloduell[0]->Vorname_S2 }}" />
                            </td>
                            <td class="bg-gray-100 text-black border-solid border-r-2 border-black">
                                <input type="text" size="20" class="bg-gray-100 text-black w-full focus:bg-green-400 transition duration-300 p-1.5" name="soloNnameGast1" id="soloNnameGast1" value="{{ $soloduell[0]->Nachname_S2 }}" />
                            </td>
                            <td class="bg-gray-100 text-black border-dashed border-r-2 border-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full text-right focus:bg-green-400 transition duration-300 p-1.5" onchange="changeSetSumS(1)" name="soloSatz1heim1" id="soloSatz1heim1" value="{{ $soloduell[0]->Satz_1_Heim }}" />
                            </td>
                            <td class="bg-gray-100 text-black border-solid border-r-2 border-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full focus:bg-green-400 transition duration-300 p-1.5" onchange="changeSetSumS(1)" name="soloSatz1gast1" id="soloSatz1gast1" value="{{ $soloduell[0]->Satz_1_Gast }}" />
                            </td>
                            <td class="bg-gray-100 text-black border-dashed border-r-2 border-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full text-right focus:bg-green-400 transition duration-300 p-1.5" onchange="changeSetSumS(1)" name="soloSatz2heim1" id="soloSatz2heim1" value="{{ $soloduell[0]->Satz_2_Heim }}" />
                            </td>
                            <td class="bg-gray-100 text-black border-solid border-r-2 border-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full focus:bg-green-400 transition duration-300 p-1.5" onchange="changeSetSumS(1)" name="soloSatz2gast1" id="soloSatz2gast1" value="{{ $soloduell[0]->Satz_2_Gast }}" />
                            </td>
                            <td class="bg-gray-100 text-black border-dashed border-r-2 border-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full text-right focus:bg-green-400 transition duration-300 p-1.5" onchange="changeSetSumS(1)" name="soloSatz3heim1" id="soloSatz3heim1" value="{{ $soloduell[0]->Satz_3_Heim }}" />
                            </td>
                            <td class="bg-gray-100 text-black border-solid border-r-2 border-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full focus:bg-green-400 transition duration-300 p-1.5" onchange="changeSetSumS(1)" name="soloSatz3gast1" id="soloSatz3gast1" value="{{ $soloduell[0]->Satz_3_Gast }}" />
                            </td>
                            <td class="bg-gray-100 text-black border-dashed border-r-2 border-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full text-right focus:bg-green-400 transition duration-300 p-1.5" readonly="readonly" name="soloSetpointHeim1" id="soloSetpointHeim1" value="{{ $soloduell[0]->Gewonnene_Sätze_Heim }}" />
                            </td>
                            <td class="bg-gray-100 text-black border-solid border-r-2 border-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full focus:bg-green-400 transition duration-300 p-1.5" readonly="readonly" name="soloSetpointGast1" id="soloSetpointGast1" value="{{ $soloduell[0]->Gewonnene_Sätze_Gast }}" />
                            </td>
                            <td class="bg-gray-100 text-black border-dashed border-r-2 border-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full text-right focus:bg-green-400 transition duration-300 p-1.5" readonly="readonly" name="soloSumpointHeim1" id="soloSumpointHeim1" value="{{ $soloduell[0]->Heim_Gesamt }}" />
                            </td>
                            <td class="bg-gray-100 text-black border-solid border-r-2 border-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full focus:bg-green-400 transition duration-300 p-1.5" readonly="readonly" name="soloSumpointGast1" id="soloSumpointGast1" value="{{ $soloduell[0]->Gast_Gesamt }}" />
                            </td>
                            <td class="bg-gray-100 text-black border-dashed border-r-2 border-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full text-right focus:bg-green-400 transition duration-300 p-1.5" readonly="readonly" name="soloPointHeim1" id="soloPointHeim1" value="{{ $soloduell[0]->Gewonnene_Spiele_Heim }}" />
                            </td>
                            <td class="bg-gray-100 text-black ">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full focus:bg-green-400 transition duration-300 p-1.5" readonly="readonly" name="soloPointGast1" id="soloPointGast1" value="{{ $soloduell[0]->Gewonnene_Spiele_Gast }}" />
                            </td>
                        </tr>
                        @if (count($soloduell) >= 2)
                            <tr class="border-solid border-b-2 border-black">
                                <input type="hidden" id="duellID2" name="duellID2" value="{{ $soloduell[1]->Duell_ID }}">
                                <td class="bg-gray-100 text-black border-solid border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full focus:bg-green-400 transition duration-300" name="soloType2" id="soloType2" value="{{ $soloduell[1]->Duellart }}" />
                                </td>
                                <td class="bg-gray-100 text-black border-dashed border-r-2 border-black">
                                    <input type="text" size="20" class="bg-gray-100 text-black w-full focus:bg-green-400 transition duration-300" name="soloVnameHeim2" id="soloVnameHeim2" value="{{ $soloduell[1]->Vorname_S1 }}" />
                                </td>
                                <td class="bg-gray-100 text-black border-solid border-r-2 border-black">
                                    <input type="text" size="20" class="bg-gray-100 text-right p-1.5 text-black w-full focus:bg-green-400 transition duration-300" name="soloNnameHeim2" id="soloNnameHeim2" value="{{ $soloduell[1]->Nachname_S1 }}" />
                                </td>
                                <td class="bg-gray-100 text-black border-dashed border-r-2 border-black">
                                    <input type="text" size="20" class="bg-gray-100 text-black w-full focus:bg-green-400 transition duration-300" name="soloVnameGast2" id="soloVnameGast2" value="{{ $soloduell[1]->Vorname_S2 }}" />
                                </td>
                                <td class="bg-gray-100 text-black border-solid border-r-2 border-black">
                                    <input type="text" size="20" class="bg-gray-100 text-right p-1.5 text-black w-full focus:bg-green-400 transition duration-300" name="soloNnameGast2" id="soloNnameGast2" value="{{ $soloduell[1]->Nachname_S2 }}" />
                                </td>
                                <td class="bg-gray-100 text-black border-dashed border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full focus:bg-green-400 transition duration-300" name="soloSatz1heim2" id="soloSatz1heim2" value="{{ $soloduell[1]->Satz_1_Heim }}" />
                                </td>
                                <td class="bg-gray-100 text-black border-solid border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-right p-1.5 text-black w-full focus:bg-green-400 transition duration-300" name="soloSatz1gast2" id="soloSatz1gast2" value="{{ $soloduell[1]->Satz_1_Gast }}" />
                                </td>
                                <td class="bg-gray-100 text-black border-dashed border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full focus:bg-green-400 transition duration-300" name="soloSatz2heim2" id="soloSatz2heim2" value="{{ $soloduell[1]->Satz_2_Heim }}" />
                                </td>
                                <td class="bg-gray-100 text-black border-solid border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-right p-1.5 text-black w-full focus:bg-green-400 transition duration-300" name="soloSatz2gast2" id="soloSatz2gast2" value="{{ $soloduell[1]->Satz_2_Gast }}" />
                                </td>
                                <td class="bg-gray-100 text-black border-dashed border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full focus:bg-green-400 transition duration-300" name="soloSatz3heim2" id="soloSatz3heim2" value="{{ $soloduell[1]->Satz_3_Heim }}" />
                                </td>
                                <td class="bg-gray-100 text-black border-solid border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-right p-1.5 text-black w-full focus:bg-green-400 transition duration-300" name="soloSatz3gast2" id="soloSatz3gast2" value="{{ $soloduell[1]->Satz_3_Gast }}" />
                                </td>
                                </td>
                                <td class="bg-gray-100 text-black border-dashed border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full focus:bg-green-400 transition duration-300" name="soloSetpointHeim2" id="soloSetpointHeim2" value="{{ $soloduell[1]->Gewonnene_Sätze_Heim }}" />
                                </td>
                                <td class="bg-gray-100 text-black border-solid border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-right p-1.5 text-black w-full focus:bg-green-400 transition duration-300" name="soloSetpointGast2" id="soloSetpointGast2" value="{{ $soloduell[1]->Gewonnene_Sätze_Gast }}" />
                                </td>
                                <td class="bg-gray-100 text-black border-dashed border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full focus:bg-green-400 transition duration-300" name="soloSumpointHeim2" id="soloSumpointHeim2" value="{{ $soloduell[1]->Heim_Gesamt }}" />
                                </td>
                                <td class="bg-gray-100 text-black border-solid border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-right p-1.5 text-black w-full focus:bg-green-400 transition duration-300" name="soloSumpointGast2" id="soloSumpointGast2" value="{{ $soloduell[1]->Gast_Gesamt }}" />
                                <td class="bg-gray-100 text-black border-dashed border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full focus:bg-green-400 transition duration-300" name="soloPointHeim2" id="soloPointHeim2" value="{{ $soloduell[1]->Gewonnene_Spiele_Heim }}" />
                                </td>
                                <td class="bg-gray-100 text-black ">
                                    <input type="text" size="4" class="bg-gray-100 text-right p-1.5 text-black w-full focus:bg-green-400 transition duration-300" name="soloPointGast2" id="soloPointGast2" value="{{ $soloduell[1]->Gewonnene_Spiele_Gast }}" />
                                </td>
                            </tr>
                            @if (count($soloduell) >= 3)
                                <tr class="border-solid border-b-2 border-black">
                                    <input type="hidden" id="duellID3" name="duellID3" value="{{ $soloduell[2]->Duell_ID }}">
                                    <td class="bg-gray-100 text-black border-solid border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 text-black w-full" name="soloType3" id="soloType3" value="{{ $soloduell[2]->Duellart }}" />
                                    </td>
                                    <td class="bg-gray-100 text-black border-dashed border-r-2 border-black">
                                        <input type="text" size="20" class="bg-gray-100 text-black w-full focus:bg-green-400 transition duration-300" name="soloVnameHeim3" id="soloVnameHeim3" value="{{ $soloduell[2]->Vorname_S1 }}" />
                                    </td>
                                    <td class="bg-gray-100 text-black border-solid border-r-2 border-black">
                                        <input type="text" size="20" class="bg-gray-100 text-black w-full focus:bg-green-400 transition duration-300" name="soloNnameHeim3" id="soloNnameHeim3" value="{{ $soloduell[2]->Nachname_S1 }}" />
                                    </td>
                                    <td class="bg-gray-100 text-black border-dashed border-r-2 border-black">
                                        <input type="text" size="20" class="bg-gray-100 text-black w-full focus:bg-green-400 transition duration-300" name="soloVnameGast3" id="soloVnameGast3" value="{{ $soloduell[2]->Vorname_S2 }}" />
                                    </td>
                                    <td class="bg-gray-100 text-black border-solid border-r-2 border-black">
                                        <input type="text" size="20" class="bg-gray-100 text-black w-full focus:bg-green-400 transition duration-300" name="soloNnameGast3" id="soloNnameGast3" value="{{ $soloduell[2]->Nachname_S2 }}" />
                                    </td>
                                    <td class="bg-gray-100 text-black border-dashed border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 text-black w-full focus:bg-green-400 transition duration-300" name="soloSatz1heim3" id="soloSatz1heim3" value="{{ $soloduell[2]->Satz_1_Heim }}" />
                                    </td>
                                    <td class="bg-gray-100 text-black border-solid border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 text-black w-full focus:bg-green-400 transition duration-300" name="soloSatz1gast3" id="soloSatz1gast3" value="{{ $soloduell[2]->Satz_1_Gast }}" />
                                    </td>
                                    <td class="bg-gray-100 text-black border-dashed border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 text-black w-full focus:bg-green-400 transition duration-300" name="soloSatz2heim3" id="soloSatz2heim3" value="{{ $soloduell[2]->Satz_2_Heim }}" />
                                    </td>
                                    <td class="bg-gray-100 text-black border-solid border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 text-black w-full focus:bg-green-400 transition duration-300" name="soloSatz2gast3" id="soloSatz2gast3" value="{{ $soloduell[2]->Satz_2_Gast }}" />
                                    </td>
                                    <td class="bg-gray-100 text-black border-dashed border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 text-black w-full focus:bg-green-400 transition duration-300" name="soloSatz3heim3" id="soloSatz3heim3" value="{{ $soloduell[2]->Satz_3_Heim }}" />
                                    </td>
                                    <td class="bg-gray-100 text-black border-solid border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 text-black w-full focus:bg-green-400 transition duration-300" name="soloSatz3gast3" id="soloSatz3gast3" value="{{ $soloduell[2]->Satz_3_Gast }}" />
                                    </td>
                                    <td class="bg-gray-100 text-black border-dashed border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 text-black w-full focus:bg-green-400 transition duration-300" name="soloSetpointHeim3" id="soloSetpointHeim3" value="{{ $soloduell[2]->Gewonnene_Sätze_Heim }}" />
                                    </td>
                                    <td class="bg-gray-100 text-black border-solid border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 text-black w-full focus:bg-green-400 transition duration-300" name="soloSetpointGast3" id="soloSetpointGast3" value="{{ $soloduell[2]->Gewonnene_Sätze_Gast }}" />
                                    </td>
                                    <td class="bg-gray-100 text-black border-dashed border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 text-black w-full focus:bg-green-400 transition duration-300" name="soloSumpointHeim3" id="soloSumpointHeim3" value="{{ $soloduell[2]->Heim_Gesamt }}" />
                                    </td>
                                    <td class="bg-gray-100 text-black border-solid border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 text-black w-full focus:bg-green-400 transition duration-300" name="soloSumpointGast3" id="soloSumpointGast3" value="{{ $soloduell[2]->Gast_Gesamt }}" />
                                    </td>
                                    <td class="bg-gray-100 text-black border-dashed border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 text-black w-full focus:bg-green-400 transition duration-300" name="soloPointHeim3" id="soloPointHeim3" value="{{ $soloduell[2]->Gewonnene_Spiele_Heim }}" />
                                    </td>
                                    <td class="bg-gray-100 text-black ">
                                        <input type="text" size="4" class="bg-gray-100 text-black w-full focus:bg-green-400 transition duration-300" name="soloPointGast3" id="soloPointGast3" value="{{ $soloduell[2]->Gewonnene_Spiele_Gast }}" />
                                    </td>
                                </tr>
                                @if (count($soloduell) >= 4)
                                    <tr class="border-solid border-b-2 border-black">
                                        <input type="hidden" id="duellID4" name="duellID4" value="{{ $soloduell[3]->Duell_ID }}">
                                        <td class="bg-gray-100 text-black border-solid border-r-2 border-black">
                                            <input type="text" size="4" class="bg-gray-100 text-black w-full focus:bg-green-400 transition duration-300" name="soloType4" id="soloType4" value="{{ $soloduell[3]->Duellart }}" />
                                        </td>
                                        <td class="bg-gray-100 text-black border-dashed border-r-2 border-black">
                                            <input type="text" size="20" class="bg-gray-100 text-black w-full focus:bg-green-400 transition duration-300" name="soloVnameHeim4" id="soloVnameHeim4" value="{{ $soloduell[3]->Vorname_S1 }}" />
                                        </td>
                                        <td class="bg-gray-100 text-black border-solid border-r-2 border-black">
                                            <input type="text" size="20" class="bg-gray-100 text-black w-full focus:bg-green-400 transition duration-300" name="soloNnameHeim4" id="soloNnameHeim4" value="{{ $soloduell[3]->Nachname_S1 }}" />
                                        </td>
                                        <td class="bg-gray-100 text-black border-dashed border-r-2 border-black">
                                            <input type="text" size="20" class="bg-gray-100 text-black w-full focus:bg-green-400 transition duration-300" name="soloVnameGast4" id="soloVnameGast4" value="{{ $soloduell[3]->Vorname_S2 }}" />
                                        </td>
                                        <td class="bg-gray-100 text-black border-solid border-r-2 border-black">
                                            <input type="text" size="20" class="bg-gray-100 text-black w-full focus:bg-green-400 transition duration-300" name="soloNnameGast4" id="soloNnameGast4" value="{{ $soloduell[3]->Nachname_S2 }}" />
                                        </td>
                                        <td class="bg-gray-100 text-black border-dashed border-r-2 border-black">
                                            <input type="text" size="4" class="bg-gray-100 text-black w-full focus:bg-green-400 transition duration-300" name="soloSatz1heim4" id="soloSatz1heim4" value="{{ $soloduell[3]->Satz_1_Heim }}" />
                                        </td>
                                        <td class="bg-gray-100 text-black border-solid border-r-2 border-black">
                                            <input type="text" size="4" class="bg-gray-100 text-black w-full focus:bg-green-400 transition duration-300" name="soloSatz1gast4" id="soloSatz1gast4" value="{{ $soloduell[3]->Satz_1_Gast }}" />
                                        </td>
                                        <td class="bg-gray-100 text-black border-dashed border-r-2 border-black">
                                            <input type="text" size="4" class="bg-gray-100 text-black w-full focus:bg-green-400 transition duration-300" name="soloSatz2heim4" id="soloSatz2heim4" value="{{ $soloduell[3]->Satz_2_Heim }}" />
                                        </td>
                                        <td class="bg-gray-100 text-black border-solid border-r-2 border-black">
                                            <input type="text" size="4" class="bg-gray-100 text-black w-full focus:bg-green-400 transition duration-300" name="soloSatz2gast4" id="soloSatz2gast4" value="{{ $soloduell[3]->Satz_2_Gast }}" />
                                        </td>
                                        <td class="bg-gray-100 text-black border-dashed border-r-2 border-black">
                                            <input type="text" size="4" class="bg-gray-100 text-black w-full focus:bg-green-400 transition duration-300" name="soloSatz3heim4" id="soloSatz3heim4" value="{{ $soloduell[3]->Satz_3_Heim }}" />
                                        </td>
                                        <td class="bg-gray-100 text-black border-solid border-r-2 border-black">
                                            <input type="text" size="4" class="bg-gray-100 text-black w-full focus:bg-green-400 transition duration-300" name="soloSatz3gast4" id="soloSatz3gast4" value="{{ $soloduell[3]->Satz_3_Gast }}" />
                                        </td>
                                        <td class="bg-gray-100 text-black border-dashed border-r-2 border-black">
                                            <input type="text" size="4" class="bg-gray-100 text-black w-full focus:bg-green-400 transition duration-300" name="soloSetpointHeim4" id="soloSetpointHeim4" value="{{ $soloduell[3]->Gewonnene_Sätze_Heim }}" />
                                        </td>
                                        <td class="bg-gray-100 text-black border-solid border-r-2 border-black">
                                            <input type="text" size="4" class="bg-gray-100 text-black w-full focus:bg-green-400 transition duration-300" name="soloSetpointGast4" id="soloSetpointGast4" value="{{ $soloduell[3]->Gewonnene_Sätze_Gast }}" />
                                        </td>
                                        <td class="bg-gray-100 text-black border-dashed border-r-2 border-black">
                                            <input type="text" size="4" class="bg-gray-100 text-black w-full focus:bg-green-400 transition duration-300" name="soloSumpointHeim4" id="soloSumpointHeim4" value="{{ $soloduell[3]->Heim_Gesamt }}" />
                                        </td>
                                        <td class="bg-gray-100 text-black border-solid border-r-2 border-black">
                                            <input type="text" size="4" class="bg-gray-100 text-black w-full focus:bg-green-400 transition duration-300" name="soloSumpointGast4" id="soloSumpointGast4" value="{{ $soloduell[3]->Gast_Gesamt }}" />
                                        </td>
                                        <td class="bg-gray-100 text-black border-dashed border-r-2 border-black">
                                            <input type="text" size="4" class="bg-gray-100 text-black w-full focus:bg-green-400 transition duration-300" name="soloPointHeim4" id="soloPointHeim4" value="{{ $soloduell[3]->Gewonnene_Spiele_Heim }}" />
                                        </td>
                                        <td class="bg-gray-100 text-black ">
                                            <input type="text" size="4" class="bg-gray-100 text-black w-full focus:bg-green-400 transition duration-300" name="soloPointGast4" id="soloPointGast4" value="{{ $soloduell[3]->Gewonnene_Spiele_Gast }}" />
                                        </td>
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
                        <th class="w-4">1. Satz</th>
                        <th class="w-4">1. Satz</th>
                        <th class="w-4">2. Satz</th>
                        <th class="w-4">2. Satz</th>
                        <th class="w-4">3. Satz</th>
                        <th class="w-4">3. Satz</th>
                        <th class="w-4">Heim</th>
                        <th class="w-4">Gast</th>
                        <th class="w-4">Heim</th>
                        <th class="w-4">Gast</th>
                        <th class="w-4">Heim</th>
                        <th class="w-4">Gast</th>
                    </tr>
                    @if (count($doppelduell) >= 1)
                        <tr class="border-solid border-b-2 border-black">
                            <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" name="dualType1" id="dualType1">{{ $doppelduell[0]->Duellart }}</td>
                            <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" name="dualVnameHeim11" id="dualVnameHeim11">{{ $doppelduell[0]->Vorname_S1_H }}</td>
                            <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" name="dualNnameHeim11" id="dualNnameHeim11">{{ $doppelduell[0]->Nachname_S1_H }}</td>
                            <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" name="dualVnameHeim21" id="dualVnameHeim21">{{ $doppelduell[0]->Vorname_S2_H }}</td>
                            <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" name="dualNname1Heim21" id="dualNname1Heim2">{{ $doppelduell[0]->Nachname_S2_H }}</td>
                            <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" name="dualVnameGast11" id="dualVnameGast11">{{ $doppelduell[0]->Vorname_S1_G }}</td>
                            <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" name="dualNnameGast11" id="dualNnameGast11">{{ $doppelduell[0]->Nachname_S1_G }}</td>
                            <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" name="dualVnameGast21" id="dualVnameGast21">{{ $doppelduell[0]->Vorname_S2_G }}</td>
                            <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" name="dualVnameGast21" id="dualVnameGast21">{{ $doppelduell[0]->Nachname_S2_G }}</td>
                            <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" name="dualSatz1heim1" id="dualSatz1heim1">{{ $doppelduell[0]->Satz_1_Heim }}</td>
                            <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" name="dualSatz1gast1" id="dualSatz1gast1">{{ $doppelduell[0]->Satz_1_Gast }}</td>
                            <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" name="dualSatz2heim1" id="dualSatz2heim1">{{ $doppelduell[0]->Satz_2_Heim }}</td>
                            <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" name="dualSatz2gast1" id="dualSatz2gast1">{{ $doppelduell[0]->Satz_2_Gast }}</td>
                            <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" name="dualSatz3heim1" id="dualSatz3heim1">{{ $doppelduell[0]->Satz_3_Heim }}</td>
                            <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" name="dualSatz3gast1" id="dualSatz3gast1">{{ $doppelduell[0]->Satz_3_Gast }}</td>
                            <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" name="dualSumpointHeim1" id="dualSumpointHeim1">{{ $doppelduell[0]->Heim_Gesamt }}</td>
                            <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" name="dualSumpointGast1" id="dualSumpointGast1">{{ $doppelduell[0]->Gast_Gesamt }}</td>
                            <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" name="dualSetpointHeim1" id="dualSetpointHeim1">
                                {{ $doppelduell[0]->Gewonnene_Sätze_Heim }}</td>
                            <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" name="dualSetpointGast1" id="dualSetpointGast1">
                                {{ $doppelduell[0]->Gewonnene_Sätze_Gast }}</td>
                            <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" name="dualPointHeim1" id="dualPointHeim1">{{ $doppelduell[0]->Gewonnene_Spiele_Heim }}
                            </td>
                            <td contenteditable="true" class="bg-gray-100 text-black" name="dualPointGast1" id="dualPointGast1">{{ $doppelduell[0]->Gewonnene_Spiele_Gast }}</td>
                        </tr>
                        @if (count($doppelduell) >= 2)
                            <tr class="border-solid border-b-2 border-black">
                                <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" name="dualType2" id="dualType2">{{ $doppelduell[1]->Duellart }}</td>
                                <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" name="dualVnameHeim12" id="dualVnameHeim12">{{ $doppelduell[1]->Vorname_S1_H }}</td>
                                <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" name="dualNnameHeim12" id="dualNnameHeim12">{{ $doppelduell[1]->Nachname_S1_H }}
                                </td>
                                <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" name="dualVnameHeim22" id="dualVnameHeim22">{{ $doppelduell[1]->Vorname_S2_H }}</td>
                                <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" name="dualNname1Heim22" id="dualNname1Heim22">{{ $doppelduell[1]->Nachname_S2_H }}
                                </td>
                                <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" name="dualVnameGast12" id="dualVnameGast12">{{ $doppelduell[1]->Vorname_S1_G }}</td>
                                <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" name="dualNnameGast12" id="dualNnameGast12">{{ $doppelduell[1]->Nachname_S1_G }}
                                </td>
                                <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" name="dualVnameGast22" id="dualVnameGast22">{{ $doppelduell[1]->Vorname_S2_G }}</td>
                                <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" name="dualNnameGast22" id="dualNnameGast22">{{ $doppelduell[1]->Nachname_S2_G }}
                                </td>
                                <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" name="dualSatz1heim2" id="dualSatz1heim2">{{ $doppelduell[1]->Satz_1_Heim }}</td>
                                <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" name="dualSatz1gast2" id="dualSatz1gast2">{{ $doppelduell[1]->Satz_1_Gast }}</td>
                                <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" name="dualSatz2heim2" id="dualSatz2heim2">{{ $doppelduell[1]->Satz_2_Heim }}</td>
                                <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" name="dualSatz2gast2" id="dualSatz2gast2">{{ $doppelduell[1]->Satz_2_Gast }}</td>
                                <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" name="dualSatz3heim2" id="dualSatz3heim2">{{ $doppelduell[1]->Satz_3_Heim }}</td>
                                <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" name="dualSatz3gast2" id="dualSatz3gast2">{{ $doppelduell[1]->Satz_3_Gast }}</td>
                                <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" name="dualSumpointHeim2" id="dualSumpointHeim2">{{ $doppelduell[1]->Heim_Gesamt }}
                                </td>
                                <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" name="dualSumpointGast2" id="dualSumpointGast2">{{ $doppelduell[1]->Gast_Gesamt }}
                                </td>
                                <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" name="dualSetpointHeim2" id="dualSetpointHeim2">
                                    {{ $doppelduell[1]->Gewonnene_Sätze_Heim }}</td>
                                <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" name="dualSetpointGast2" id="dualSetpointGast2">
                                    {{ $doppelduell[1]->Gewonnene_Sätze_Gast }}</td>
                                <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" name="dualPointHeim2" id="dualPointHeim2">
                                    {{ $doppelduell[1]->Gewonnene_Spiele_Heim }}</td>
                                <td contenteditable="true" class="bg-gray-100 text-black" name="dualPointGast2" id="dualPointGast2">{{ $doppelduell[1]->Gewonnene_Spiele_Gast }}</td>
                            </tr>
                        @endif
                    @endif

                </table>
                <div class="mt-3 flex place-content-end">
                    <div>
                        <fieldset>
                            <input type="radio" id="rbAccept" name="rbState" onclick="activateSubmit()" value="true">
                            <label for="rbAccept">Bericht akzeptieren</label>
                            <br>
                            <input type="radio" id="rbDecline" name="rbState" onclick="activateSubmit()" value="false">
                            <label for="rbDecline">Bericht ablehnen</label>
                        </fieldset>
                    </div>
                    <br>
                    <div>
                        <button class="test" type="submit" id="submitBTN" name="submit" disabled>Absenden</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
    <script type="text/javascript">
        // CSRF Token
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $(document).ready(function() {
            $("#liga").autocomplete({
                source: function(request, response) {
                    // Fetch data
                    $.ajax({
                        url: "{{ route('alleLigen2') }}",
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
                                    'value': value.Name
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
                    // $("#employee_search").text(ui.item.label); // display the selected text
                    //$("#liga").text(ui.item.label);
                    return false;
                }
            });
        });

        function test() {
            //alert("test");
            //$( "#employee_search" ).autocomplete( "enable" );
            $("#liga").autocomplete({
                source: function(request, response) {
                    // Fetch data
                    $.ajax({
                        url: "{{ route('alleLigen2') }}",
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
                                    'value': value.Name
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

                    // $("#employee_search").text(ui.item.label); // display the selected text
                    //$("#liga").text(ui.item.label);
                    return false;
                }

            });
        }

        function MannschaftenH() { // findet Id der Liga raus, dann erstellt datalist mit mannschaften dieser liga
            if ($("#liga").val().length > 0) {
                $("#tfHome").autocomplete({
                    source: function(request, response) {
                        // Fetch data
                        $.ajax({
                            url: "{{ route('alleMannschaften') }}",
                            type: 'post',
                            dataType: "json",
                            data: {
                                _token: CSRF_TOKEN,
                                search: request.term,
                                liga: $("#liga").val()

                            },
                            success: function(data) {
                                response(data.map(function(value) {
                                    return {
                                        'label': value.Name,
                                        'value': value.Name
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
                        $('#tfHome').val(ui.item.label);
                        // $("#employee_search").text(ui.item.label); // display the selected text
                        //$("#liga").text(ui.item.label);
                        return false;
                    }
                });
            }
        }

        function MannschaftenG() { // findet Id der Liga raus, dann erstellt datalist mit mannschaften dieser liga

            if ($("#liga").val().length > 0) {
                $("#tfAway").autocomplete({
                    source: function(request, response) {
                        // Fetch data
                        $.ajax({
                            url: "{{ route('alleMannschaften') }}",
                            type: 'post',
                            dataType: "json",
                            data: {
                                _token: CSRF_TOKEN,
                                search: request.term,
                                liga: $("#liga").val()

                            },
                            success: function(data) {
                                response(data.map(function(value) {
                                    return {
                                        'label': value.Name,
                                        'value': value.Name
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
                        $('#tfAway').val(ui.item.label);
                        // $("#employee_search").text(ui.item.label); // display the selected text
                        //$("#liga").text(ui.item.label);
                        return false;
                    }
                });
            }
        }
    </script>
@endsection

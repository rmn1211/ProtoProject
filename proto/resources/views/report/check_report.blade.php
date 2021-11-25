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
        <h3 class="font-bold  text-2xl">Spieleberichtsbogen</h3>
    </section>
    <section class="mt-10 overflow-auto">
        <div class="w-full flex flex-row lg:justify-center">
            <form class="flex flex-col mx-3 mb-6" method="POST" onsubmit="return validateInputs();" action="{{ url('/overview') }}">
                @csrf
                <input type="hidden" id="matchID" name="matchID" value="{{ $matchID }}">
                <input type="hidden" id="soloCount" name="soloCount" value="{{ count($soloduell) }}">
                <input type="hidden" id="doubleCount" name="doubleCount" value="{{ count($doppelduell) }}">
                <div class="flex mb-4">
                    <div class="w-1/full bg-green-400 h-12">
                        <label class="block text-gray-900 text-sm font-bold mb-2 ml-3">Staffel:</label>
                        <input type="text" oninput="hello()"onfocus="javascript:$(this).autocomplete('search');" id="liga" onChange="markInput(this)" name="liga" class="bg-gray-100 text-gray-900 w-full focus:outline-none border-b-full border-gray-700 focus:border-green-500 transition duration-500 px-3 pb-3" value="{{ $liga->Name }}">
                    </div>

                    <div class="w-1/full bg-green-400 h-12">
                        <label class="block text-gray-900 text-sm font-bold mb-2 ml-3" for="home">Heimverein:</label>
                        <input onfocus="javascript:$(this).autocomplete('search');" oninput="MannschaftenH()" type="text" onChange="markInput(this)" name=" tfHome" id="tfHome" class="bg-gray-100 text-gray-900  w-full focus:outline-none border-b-full border-gray-700 focus:border-green-500 transition duration-500 px-3 pb-3" value="{{ $match->Heim }}">
                    </div>
                    <div class="w-1/full bg-green-400 h-12">
                        <label class="block text-gray-900 text-sm font-bold mb-2 ml-3" for="away">Gastverein:</label>
                        <input onfocus="javascript:$(this).autocomplete('search');" type="text" oninput="MannschaftenG()" onChange="markInput(this)" name="tfAway" id="tfAway" class="bg-gray-100 text-gray-900  w-full focus:outlie-none border-b-full border-gray-700 focus:border-green-500 transition duration-500 px-3 pb-3" value="{{ $match->Gast }}">
                    </div>
                    <div class="w-1/full bg-green-400 h-12">
                        <label class="block text-gray-900 text-sm font-bold mb-2 ml-3" for="away">Schiedsrichter:</label>
                        <input type="text" name="tfPlace" id="tfPlace" onChange="markInput(this)" class="bg-gray-100 text-gray-900  w-full focus:outline-none border-b-full border-gray-700 focus:border-green-500 transition duration-500 px-3 pb-3" value="{{ $match->Schiedsrichter }}">
                    </div>
                    <div class="w-1/full bg-green-400 h-12">
                        <label class="block text-gray-900 text-sm font-bold mb-2 ml-3" for="away">Austragungsort:</label>
                        <input type="text" name="tfPlace" id="tfPlace" onChange="markInput(this)" class="bg-gray-100 text-gray-900  w-full focus:outline-none border-b-full border-gray-700 focus:border-green-500 transition duration-500 px-3 pb-3" value="{{ $match->Spielort }}">
                    </div>
                </div>
                 <input type="hidden" name="HeimID" id="HeimID" value="{{$homeID}}">
                  <input type="hidden" name="GastID" id="GastID" value="{{$awayID}}">
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
                            @if (count($soloduell) >= 3)
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
                            @endif
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
                            @if (count($soloduell) >= 3)
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
                            @endif
                        @endif
                    </thead>
                    <tbody class="flex-1 sm:flex-none">
                        @if (count($soloduell) >= 1)
                            <tr class="border-solid border-b-2 border-black w-44 sm:w-auto flex flex-col flex-no wrap sm:table-row mb-2 sm:mb-0">
                                <input type="hidden" id="duellID1" name="duellID1" value="{{ $soloduell[0]->Duell_ID }}">
                                <td class="bg-gray-100 h-8 text-black border-solid border-b-2 sm:border-r-2 border-black">
                                    <input type="text" list="arten" size="4" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300" name="soloType1" id="soloType1" value="{{ $soloduell[0]->Duellart }}" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                    <input type="text"   onload = "VnameH(this.id)"oninput="VnameH(this.id)" onfocus="VnameH(this.id);javascript:$(this).autocomplete('search');" size="20" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 sm:p-1.5" name="soloVnameHeim1" id="soloVnameHeim1" value="{{ $soloduell[0]->Vorname_S1 }}" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                    <input type="text" onload="NnameH(this.id)" oninput="NnameH(this.id)"  onfocus="NnameH(this.id);javascript:$(this).autocomplete('search');" size="20" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" name="soloNnameHeim1" id="soloNnameHeim1" value="{{ $soloduell[0]->Nachname_S1 }}" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                    <input type="text" onload="VnameG(this.id)"onfocus="javascript:VnameG(this.id);$(this).autocomplete('search');" oninput="VnameG(this.id)" size="20" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5" name="soloVnameGast1" id="soloVnameGast1" value="{{ $soloduell[0]->Vorname_S2 }}" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                    <input type="text" onload="NnameG(this.id)"  onfocus="javascript:NnameG(this.id);$(this).autocomplete('search');" oninput="NnameG(this.id)"size="20" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" name="soloNnameGast1" id="soloNnameGast1" value="{{ $soloduell[0]->Nachname_S2 }}" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5" onchange="markInput(this); changeSetSumS(1)" name="soloSatz1heim1" id="soloSatz1heim1" value="{{ $soloduell[0]->Satz_1_Heim }}" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" onchange="markInput(this); changeSetSumS(1)" name="soloSatz1gast1" id="soloSatz1gast1" value="{{ $soloduell[0]->Satz_1_Gast }}" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5" onchange="markInput(this); changeSetSumS(1)" name="soloSatz2heim1" id="soloSatz2heim1" value="{{ $soloduell[0]->Satz_2_Heim }}" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" onchange="markInput(this); changeSetSumS(1)" name="soloSatz2gast1" id="soloSatz2gast1" value="{{ $soloduell[0]->Satz_2_Gast }}" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5" onchange="markInput(this); changeSetSumS(1)" name="soloSatz3heim1" id="soloSatz3heim1" value="{{ $soloduell[0]->Satz_3_Heim }}" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" onchange="markInput(this); changeSetSumS(1)" name="soloSatz3gast1" id="soloSatz3gast1" value="{{ $soloduell[0]->Satz_3_Gast }}" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5" readonly="readonly" tabindex="-1" name="soloSetpointHeim1" id="soloSetpointHeim1" value="{{ $soloduell[0]->Gewonnene_Sätze_Heim }}" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" readonly="readonly" tabindex="-1" name="soloSetpointGast1" id="soloSetpointGast1" value="{{ $soloduell[0]->Gewonnene_Sätze_Gast }}" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5" readonly="readonly" tabindex="-1" name="soloWonSetHeim1" id="soloWonSetHeim1" value="{{ $soloduell[0]->Heim_Gesamt }}" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" readonly="readonly" tabindex="-1" name="soloWonSetGast1" id="soloWonSetGast1" value="{{ $soloduell[0]->Gast_Gesamt }}" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:sm:text-right focus:bg-green-400 transition duration-300 p-1.5" readonly="readonly" tabindex="-1" name="soloWonMatchHeim1" id="soloWonMatchHeim1" value="{{ $soloduell[0]->Gewonnene_Spiele_Heim }}" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" readonly="readonly" tabindex="-1" name="soloWonMatchGast1" id="soloWonMatchGast1" value="{{ $soloduell[0]->Gewonnene_Spiele_Gast }}" />
                                </td>
                            </tr>
                            @if (count($soloduell) >= 2)
                                <tr class="border-solid border-b-2 border-black w-44 sm:w-auto flex flex-col flex-no wrap sm:table-row mb-2 sm:mb-0">
                                    <input type="hidden" id="duellID2" name="duellID2" value="{{ $soloduell[1]->Duell_ID }}">
                                    <td class="bg-gray-100 text-black border-solid border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 text-black w-full focus:bg-green-400 transition duration-300" onChange="markInput(this)" name="soloType2" id="soloType2" value="{{ $soloduell[1]->Duellart }}" />
                                    </td>
                                    <td class="bg-gray-100 text-black border-dashed border-r-2 border-black">
                                        <input type="text"   onload = "VnameH(this.id)" onfocus="javascript:VnameH(this.id);$(this).autocomplete('search');" oninput="VnameH(this.id)" size="20" class="bg-gray-100 text-black w-full focus:bg-green-400 transition duration-300" onChange="markInput(this)" name="soloVnameHeim2" id="soloVnameHeim2" value="{{ $soloduell[1]->Vorname_S1 }}" />
                                    </td>
                                    <td class="bg-gray-100 text-black border-solid border-r-2 border-black">
                                        <input type="text"   onload = "NnameH(this.id)" onfocus="javascript:NnameH(this.id);$(this).autocomplete('search');" oninput="NnameH(this.id)" size="20" class="bg-gray-100 sm:text-right p-1.5 text-black w-full focus:bg-green-400 transition duration-300" onChange="markInput(this)" name="soloNnameHeim2" id="soloNnameHeim2" value="{{ $soloduell[1]->Nachname_S1 }}" />
                                    </td>
                                    <td class="bg-gray-100 text-black border-dashed border-r-2 border-black">
                                        <input type="text"  onload = "VnameG(this.id)" onfocus="javascript:VnameG(this.id);$(this).autocomplete('search');" oninput="VnameG(this.id)" size="20" class="bg-gray-100 text-black w-full focus:bg-green-400 transition duration-300" onChange="markInput(this)" name="soloVnameGast2" id="soloVnameGast2" value="{{ $soloduell[1]->Vorname_S2 }}" />
                                    </td>
                                    <td class="bg-gray-100 text-black border-solid border-r-2 border-black">
                                        <input type="text"   onload = "NnameG(this.id)" onfocus="javascript:NnameG(this.id);$(this).autocomplete('search');" oninput="NnameG(this.id)"size="20" class="bg-gray-100 sm:text-right p-1.5 text-black w-full focus:bg-green-400 transition duration-300" onChange="markInput(this)" name="soloNnameGast2" id="soloNnameGast2" value="{{ $soloduell[1]->Nachname_S2 }}" />
                                    </td>
                                    <td class="bg-gray-100 text-black border-dashed border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 text-black w-full focus:bg-green-400 transition duration-300" onchange="markInput(this); changeSetSumS(2)" name="soloSatz1heim2" id="soloSatz1heim2" value="{{ $soloduell[1]->Satz_1_Heim }}" />
                                    </td>
                                    <td class="bg-gray-100 text-black border-solid border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 sm:text-right p-1.5 text-black w-full focus:bg-green-400 transition duration-300" onchange="markInput(this); changeSetSumS(2)" name="soloSatz1gast2" id="soloSatz1gast2" value="{{ $soloduell[1]->Satz_1_Gast }}" />
                                    </td>
                                    <td class="bg-gray-100 text-black border-dashed border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 text-black w-full focus:bg-green-400 transition duration-300" onchange="markInput(this); changeSetSumS(2)" name="soloSatz2heim2" id="soloSatz2heim2" value="{{ $soloduell[1]->Satz_2_Heim }}" />
                                    </td>
                                    <td class="bg-gray-100 text-black border-solid border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 sm:text-right p-1.5 text-black w-full focus:bg-green-400 transition duration-300" onchange="markInput(this); changeSetSumS(2)" name="soloSatz2gast2" id="soloSatz2gast2" value="{{ $soloduell[1]->Satz_2_Gast }}" />
                                    </td>
                                    <td class="bg-gray-100 text-black border-dashed border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 text-black w-full focus:bg-green-400 transition duration-300" onchange="markInput(this); changeSetSumS(2)" name="soloSatz3heim2" id="soloSatz3heim2" value="{{ $soloduell[1]->Satz_3_Heim }}" />
                                    </td>
                                    <td class="bg-gray-100 text-black border-solid border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 sm:text-right p-1.5 text-black w-full focus:bg-green-400 transition duration-300" onchange="markInput(this); changeSetSumS(2)" name="soloSatz3gast2" id="soloSatz3gast2" value="{{ $soloduell[1]->Satz_3_Gast }}" />
                                    </td>
                                    </td>
                                    <td class="bg-gray-100 text-black border-dashed border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 text-black w-full focus:bg-green-400 transition duration-300" readonly="readonly" tabindex="-1" name="soloSetpointHeim2" id="soloSetpointHeim2" value="{{ $soloduell[1]->Gewonnene_Sätze_Heim }}" />
                                    </td>
                                    <td class="bg-gray-100 text-black border-solid border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 sm:text-right p-1.5 text-black w-full focus:bg-green-400 transition duration-300" readonly="readonly" tabindex="-1" name="soloSetpointGast2" id="soloSetpointGast2" value="{{ $soloduell[1]->Gewonnene_Sätze_Gast }}" />
                                    </td>
                                    <td class="bg-gray-100 text-black border-dashed border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 text-black w-full focus:bg-green-400 transition duration-300" name="soloWonSetHeim2" readonly="readonly" tabindex="-1" id="soloWonSetHeim2" value="{{ $soloduell[1]->Heim_Gesamt }}" />
                                    </td>
                                    <td class="bg-gray-100 text-black border-solid border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 sm:text-right p-1.5 text-black w-full focus:bg-green-400 transition duration-300" readonly="readonly" tabindex="-1" name="soloWonSetGast2" id="soloWonSetGast2" value="{{ $soloduell[1]->Gast_Gesamt }}" />
                                    <td class="bg-gray-100 text-black border-dashed border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 text-black w-full focus:bg-green-400 transition duration-300" name="soloWonMatchHeim2" readonly="readonly" tabindex="-1" id="soloWonMatchHeim2" value="{{ $soloduell[1]->Gewonnene_Spiele_Heim }}" />
                                    </td>
                                    <td class="bg-gray-100 text-black ">
                                        <input type="text" size="4" class="bg-gray-100 sm:text-right p-1.5 text-black w-full focus:bg-green-400 transition duration-300" readonly="readonly" tabindex="-1" name="soloWonMatchGast2" id="soloWonMatchGast2" value="{{ $soloduell[1]->Gewonnene_Spiele_Gast }}" />
                                    </td>
                                </tr>
                                @if (count($soloduell) >= 3)
                                    <tr class="border-solid border-b-2 border-black flex flex-col flex-no wrap sm:table-row mb-2 sm:mb-0">
                                        <input type="hidden" id="duellID3" name="duellID3" value="{{ $soloduell[2]->Duell_ID }}">
                                        <td class="bg-gray-100 text-black border-solid border-r-2 border-black">
                                            <input type="text" size="4" class="bg-gray-100 text-black w-full" name="soloType3" id="soloType3" value="{{ $soloduell[2]->Duellart }}" />
                                        </td>
                                        <td class="bg-gray-100 text-black border-dashed border-r-2 border-black">
                                            <input type="text"   onload = "VnameH(this.id)" onfocus="javascript:VnameH(this.id);$(this).autocomplete('search');" oninput="VnameH(this.id)" size="20" class="bg-gray-100 text-black w-full focus:bg-green-400 transition duration-300" name="soloVnameHeim3" id="soloVnameHeim3" onChange="markInput(this)" value="{{ $soloduell[2]->Vorname_S1 }}" />
                                        </td>
                                        <td class="bg-gray-100 text-black border-solid border-r-2 border-black">
                                            <input type="text"  onload = "NnameH(this.id)" onfocus="javascript:NnameH(this.id);$(this).autocomplete('search');" oninput="NnameH(this.id)" size="20" class="bg-gray-100 text-black w-full focus:bg-green-400 transition duration-300" name="soloNnameHeim3" id="soloNnameHeim3" onChange="markInput(this)" value="{{ $soloduell[2]->Nachname_S1 }}" />
                                        </td>
                                        <td class="bg-gray-100 text-black border-dashed border-r-2 border-black">
                                            <input type="text"  onload = "VnameG(this.id)" onfocus="javascript:VnameG(this.id);$(this).autocomplete('search');" oninput="VnameG(this.id)"size="20" class="bg-gray-100 text-black w-full focus:bg-green-400 transition duration-300" name="soloVnameGast3" id="soloVnameGast3" onChange="markInput(this)" value="{{ $soloduell[2]->Vorname_S2 }}" />
                                        </td>
                                        <td class="bg-gray-100 text-black border-solid border-r-2 border-black">
                                            <input type="text"  onload = "NnameG(this.id)" onfocus="javascript:NnameG(this.id);$(this).autocomplete('search');" oninput="NnameG(this.id)"size="20" class="bg-gray-100 text-black w-full focus:bg-green-400 transition duration-300" name="soloNnameGast3" id="soloNnameGast3" onChange="markInput(this)" value="{{ $soloduell[2]->Nachname_S2 }}" />
                                        </td>
                                        <td class="bg-gray-100 text-black border-dashed border-r-2 border-black">
                                            <input type="text" size="4" class="bg-gray-100 text-black w-full focus:bg-green-400 transition duration-300" name="soloSatz1heim3" id="soloSatz1heim3" onchange="markInput(this); changeSetSumS(3)" value="{{ $soloduell[2]->Satz_1_Heim }}" />
                                        </td>
                                        <td class="bg-gray-100 text-black border-solid border-r-2 border-black">
                                            <input type="text" size="4" class="bg-gray-100 text-black w-full focus:bg-green-400 transition duration-300" name="soloSatz1gast3" id="soloSatz1gast3" onchange="markInput(this); changeSetSumS(3)" value="{{ $soloduell[2]->Satz_1_Gast }}" />
                                        </td>
                                        <td class="bg-gray-100 text-black border-dashed border-r-2 border-black">
                                            <input type="text" size="4" class="bg-gray-100 text-black w-full focus:bg-green-400 transition duration-300" name="soloSatz2heim3" id="soloSatz2heim3" onchange="markInput(this); changeSetSumS(3)" value="{{ $soloduell[2]->Satz_2_Heim }}" />
                                        </td>
                                        <td class="bg-gray-100 text-black border-solid border-r-2 border-black">
                                            <input type="text" size="4" class="bg-gray-100 text-black w-full focus:bg-green-400 transition duration-300" name="soloSatz2gast3" id="soloSatz2gast3" onchange="markInput(this); changeSetSumS(3)" value="{{ $soloduell[2]->Satz_2_Gast }}" />
                                        </td>
                                        <td class="bg-gray-100 text-black border-dashed border-r-2 border-black">
                                            <input type="text" size="4" class="bg-gray-100 text-black w-full focus:bg-green-400 transition duration-300" name="soloSatz3heim3" id="soloSatz3heim3" onchange="markInput(this); changeSetSumS(3)" value="{{ $soloduell[2]->Satz_3_Heim }}" />
                                        </td>
                                        <td class="bg-gray-100 text-black border-solid border-r-2 border-black">
                                            <input type="text" size="4" class="bg-gray-100 text-black w-full focus:bg-green-400 transition duration-300" name="soloSatz3gast3" id="soloSatz3gast3" onchange="markInput(this); changeSetSumS(3)" value="{{ $soloduell[2]->Satz_3_Gast }}" />
                                        </td>
                                        <td class="bg-gray-100 text-black border-dashed border-r-2 border-black">
                                            <input type="text" size="4" class="bg-gray-100 text-black w-full focus:bg-green-400 transition duration-300" readonly="readonly" tabindex="-1" name="soloSetpointHeim3" id="soloSetpointHeim3" onChange="markInput(this)" value="{{ $soloduell[2]->Gewonnene_Sätze_Heim }}" />
                                        </td>
                                        <td class="bg-gray-100 text-black border-solid border-r-2 border-black">
                                            <input type="text" size="4" class="bg-gray-100 text-black w-full focus:bg-green-400 transition duration-300" readonly="readonly" tabindex="-1" name="soloSetpointGast3" id="soloSetpointGast3" onChange="markInput(this)" value="{{ $soloduell[2]->Gewonnene_Sätze_Gast }}" />
                                        </td>
                                        <td class="bg-gray-100 text-black border-dashed border-r-2 border-black">
                                            <input type="text" size="4" class="bg-gray-100 text-black w-full focus:bg-green-400 transition duration-300" readonly="readonly" tabindex="-1" name="soloWonSetHeim3" id="soloWonSetHeim3" onChange="markInput(this)" value="{{ $soloduell[2]->Heim_Gesamt }}" />
                                        </td>
                                        <td class="bg-gray-100 text-black border-solid border-r-2 border-black">
                                            <input type="text" size="4" class="bg-gray-100 text-black w-full focus:bg-green-400 transition duration-300" readonly="readonly" tabindex="-1" name="soloWonSetGast3" id="soloWonSetGast3" onChange="markInput(this)" value="{{ $soloduell[2]->Gast_Gesamt }}" />
                                        </td>
                                        <td class="bg-gray-100 text-black border-dashed border-r-2 border-black">
                                            <input type="text" size="4" class="bg-gray-100 text-black w-full focus:bg-green-400 transition duration-300" readonly="readonly" tabindex="-1" name="soloWonMatchHeim3" id="soloWonMatchHeim3" onChange="markInput(this)" value="{{ $soloduell[2]->Gewonnene_Spiele_Heim }}" />
                                        </td>
                                        <td class="bg-gray-100 text-black ">
                                            <input type="text" size="4" class="bg-gray-100 text-black w-full focus:bg-green-400 transition duration-300" readonly="readonly" tabindex="-1" name="soloWonMatchGast3" id="soloWonMatchGast3" onChange="markInput(this)" value="{{ $soloduell[2]->Gewonnene_Spiele_Gast }}" />
                                        </td>
                                    </tr>
                                    @if (count($soloduell) >= 4)
                                        <tr class="border-solid border-b-2 border-black flex flex-col flex-no wrap sm:table-row mb-2 sm:mb-0">
                                            <input type="hidden" id="duellID4" name="duellID4" value="{{ $soloduell[3]->Duell_ID }}">
                                            <td class="bg-gray-100 text-black border-solid border-r-2 border-black">
                                                <input type="text" size="4" class="bg-gray-100 text-black w-full focus:bg-green-400 transition duration-300" name="soloType4" id="soloType4" value="{{ $soloduell[3]->Duellart }}" />
                                            </td>
                                            <td class="bg-gray-100 text-black border-dashed border-r-2 border-black">
                                                <input type="text" onload = "VnameH(this.id)" onfocus="javascript:VnameH(this.id);$(this).autocomplete('search');" oninput="VnameH(this.id)" size="20" class="bg-gray-100 text-black w-full focus:bg-green-400 transition duration-300" name="soloVnameHeim4" id="soloVnameHeim4" onChange="markInput(this)" value="{{ $soloduell[3]->Vorname_S1 }}" />
                                            </td>
                                            <td class="bg-gray-100 text-black border-solid border-r-2 border-black">
                                                <input type="text" onload = "NnameH(this.id)" onfocus="javascript:NnameH(this.id);$(this).autocomplete('search');" oninput="NnameH(this.id)" size="20" class="bg-gray-100 text-black w-full focus:bg-green-400 transition duration-300" name="soloNnameHeim4" id="soloNnameHeim4" onChange="markInput(this)" value="{{ $soloduell[3]->Nachname_S1 }}" />
                                            </td>
                                            <td class="bg-gray-100 text-black border-dashed border-r-2 border-black">
                                                <input type="text" onload = "VnameG(this.id)" onfocus="javascript:VnameG(this.id);$(this).autocomplete('search');" oninput="VnameG(this.id)" size="20" class="bg-gray-100 text-black w-full focus:bg-green-400 transition duration-300" name="soloVnameGast4" id="soloVnameGast4" onChange="markInput(this)" value="{{ $soloduell[3]->Vorname_S2 }}" />
                                            </td>
                                            <td class="bg-gray-100 text-black border-solid border-r-2 border-black">
                                                <input type="text" onload = "NnameG(this.id)" onfocus="javascript:NnameG(this.id);$(this).autocomplete('search');" oninput="NnameG(this.id)" size="20" class="bg-gray-100 text-black w-full focus:bg-green-400 transition duration-300" name="soloNnameGast4" id="soloNnameGast4" onChange="markInput(this)" value="{{ $soloduell[3]->Nachname_S2 }}" />
                                            </td>
                                            <td class="bg-gray-100 text-black border-dashed border-r-2 border-black">
                                                <input type="text" size="4" class="bg-gray-100 text-black w-full focus:bg-green-400 transition duration-300" name="soloSatz1heim4" id="soloSatz1heim4" onchange="markInput(this); changeSetSumS(4)" value="{{ $soloduell[3]->Satz_1_Heim }}" />
                                            </td>
                                            <td class="bg-gray-100 text-black border-solid border-r-2 border-black">
                                                <input type="text" size="4" class="bg-gray-100 text-black w-full focus:bg-green-400 transition duration-300" name="soloSatz1gast4" id="soloSatz1gast4" onchange="markInput(this); changeSetSumS(4)" value="{{ $soloduell[3]->Satz_1_Gast }}" />
                                            </td>
                                            <td class="bg-gray-100 text-black border-dashed border-r-2 border-black">
                                                <input type="text" size="4" class="bg-gray-100 text-black w-full focus:bg-green-400 transition duration-300" name="soloSatz2heim4" id="soloSatz2heim4" onchange="markInput(this); changeSetSumS(4)" value="{{ $soloduell[3]->Satz_2_Heim }}" />
                                            </td>
                                            <td class="bg-gray-100 text-black border-solid border-r-2 border-black">
                                                <input type="text" size="4" class="bg-gray-100 text-black w-full focus:bg-green-400 transition duration-300" name="soloSatz2gast4" id="soloSatz2gast4" onchange="markInput(this); changeSetSumS(4)" value="{{ $soloduell[3]->Satz_2_Gast }}" />
                                            </td>
                                            <td class="bg-gray-100 text-black border-dashed border-r-2 border-black">
                                                <input type="text" size="4" class="bg-gray-100 text-black w-full focus:bg-green-400 transition duration-300" name="soloSatz3heim4" id="soloSatz3heim4" onchange="markInput(this); changeSetSumS(4)" value="{{ $soloduell[3]->Satz_3_Heim }}" />
                                            </td>
                                            <td class="bg-gray-100 text-black border-solid border-r-2 border-black">
                                                <input type="text" size="4" class="bg-gray-100 text-black w-full focus:bg-green-400 transition duration-300" name="soloSatz3gast4" id="soloSatz3gast4" onchange="markInput(this); changeSetSumS(4)" value="{{ $soloduell[3]->Satz_3_Gast }}" />
                                            </td>
                                            <td class="bg-gray-100 text-black border-dashed border-r-2 border-black">
                                                <input type="text" size="4" class="bg-gray-100 text-black w-full focus:bg-green-400 transition duration-300" readonly="readonly" tabindex="-1" name="soloSetpointHeim4" id="soloSetpointHeim4" value="{{ $soloduell[3]->Gewonnene_Sätze_Heim }}" />
                                            </td>
                                            <td class="bg-gray-100 text-black border-solid border-r-2 border-black">
                                                <input type="text" size="4" class="bg-gray-100 text-black w-full focus:bg-green-400 transition duration-300" readonly="readonly" tabindex="-1" name="soloSetpointGast4" id="soloSetpointGast4" value="{{ $soloduell[3]->Gewonnene_Sätze_Gast }}" />
                                            </td>
                                            <td class="bg-gray-100 text-black border-dashed border-r-2 border-black">
                                                <input type="text" size="4" class="bg-gray-100 text-black w-full focus:bg-green-400 transition duration-300" readonly="readonly" tabindex="-1" name="soloWonSetHeim4" id="soloWonSetHeim4" value="{{ $soloduell[3]->Heim_Gesamt }}" />
                                            </td>
                                            <td class="bg-gray-100 text-black border-solid border-r-2 border-black">
                                                <input type="text" size="4" class="bg-gray-100 text-black w-full focus:bg-green-400 transition duration-300" readonly="readonly" tabindex="-1" name="soloWonSetGast4" id="soloWonSetGast4" value="{{ $soloduell[3]->Gast_Gesamt }}" />
                                            </td>
                                            <td class="bg-gray-100 text-black border-dashed border-r-2 border-black">
                                                <input type="text" size="4" class="bg-gray-100 text-black w-full focus:bg-green-400 transition duration-300" readonly="readonly" tabindex="-1" name="soloWonMatchHeim4" id="soloWonMatchHeim4" value="{{ $soloduell[3]->Gewonnene_Spiele_Heim }}" />
                                            </td>
                                            <td class="bg-gray-100 text-black ">
                                                <input type="text" size="4" class="bg-gray-100 text-black w-full focus:bg-green-400 transition duration-300" readonly="readonly" tabindex="-1" name="soloWonMatchGast4" id="soloWonMatchGast4" value="{{ $soloduell[3]->Gewonnene_Spiele_Gast }}" />
                                            </td>
                                        </tr>
                                    @endif
                                @endif
                            @endif
                        @endif
                        <tr>
                            <td colspan="11" class="invisible">
                            </td>
                            <td class="bg-gray-100 text-black ">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full focus:bg-green-400 transition duration-300" readonly="readonly" tabindex="-1" name="sumSetHomeSolo" id="sumSetHomeSolo" />
                            </td>
                            <td class="bg-gray-100 text-black ">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full focus:bg-green-400 transition duration-300" readonly="readonly" tabindex="-1" name="sumSetGuestSolo" id="sumSetGuestSolo" />
                            </td>
                            <td class="bg-gray-100 text-black ">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full focus:bg-green-400 transition duration-300" readonly="readonly" tabindex="-1" name="sumWonSetHomeSolo" id="sumWonSetHomeSolo" />
                            </td>
                            <td class="bg-gray-100 text-black ">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full focus:bg-green-400 transition duration-300" readonly="readonly" tabindex="-1" name="sumWonSetGuestSolo" id="sumWonSetGuestSolo" />
                            </td>
                            <td class="bg-gray-100 text-black ">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full focus:bg-green-400 transition duration-300" readonly="readonly" tabindex="-1" name="sumWonMatchHomeSolo" id="sumWonMatchHomeSolo" />
                            </td>
                            <td class="bg-gray-100 text-black ">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full focus:bg-green-400 transition duration-300" readonly="readonly" tabindex="-1" name="sumWonMatchGuestSolo" id="sumWonMatchGuestSolo" />
                            </td>
                        </tr>
                    </tbody>
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
                            <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" name="dualWonSetHeim1" id="dualWonSetHeim1">{{ $doppelduell[0]->Heim_Gesamt }}</td>
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
                                <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" name="dualWonSetHeim2" id="dualWonSetHeim2">{{ $doppelduell[1]->Heim_Gesamt }}
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
            <button class='fixed bottom-0 right-2 my-2 float-right px-3 py-3 rounded bg-green-500 active:bg-green-700 text-white text-sm opacity-70 hover:opacity-100 font-bold lg:hidden'>TAB</button>
        </div>
    </section>
    <script type="text/javascript">
        // CSRF Token
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
      
        
        $(document).ready(function() {
            $("#liga").autocomplete({
            minLength: 0,
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

        

        function MannschaftenH() { // findet Id der Liga raus, dann erstellt datalist mit mannschaften dieser liga
            if ($("#liga").val().length > 0) {
                $("#tfHome").autocomplete({
                 minLength: 0,
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
                        $('#tfHome').val(ui.item.label);
                         $('#HeimID').val(ui.item.value);
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
                 minLength: 0,
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
                        $('#tfAway').val(ui.item.label);
                         $('#GastID').val(ui.item.value);
                        // $("#employee_search").text(ui.item.label); // display the selected text
                        //$("#liga").text(ui.item.label);
                        return false;
                    }
                });
            }
        }
          function NnameH(elem) { 
          var id = document.getElementById(elem);
            
               $(id).autocomplete({
                 minLength: 0,
                    source: function(request, response) {
                        // Fetch data
                        $.ajax({
                            url: "{{ route('getSpielerNname') }}",
                            type: 'post',
                            dataType: "json",
                            data: {
                                _token: CSRF_TOKEN,
                                search: request.term,
                                team: $("#HeimID").val()

                            },
                            success: function(data) {
                                response(data.map(function(value) {
                                    return {
                                        'label': value.Nname,
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
                       $(id).val(ui.item.label);
                        
                        // $("#employee_search").text(ui.item.label); // display the selected text
                        //$("#liga").text(ui.item.label);
                        return false;
                    }
                });
               
        }
         function VnameH(elem) { // findet Id der Liga raus, dann erstellt datalist mit mannschaften dieser liga
          var id = document.getElementById(elem);
          
               $(id).autocomplete({
                 minLength: 0,
                    source: function(request, response) {
                        // Fetch data
                        $.ajax({
                            url: "{{ route('getSpielerVname') }}",
                            type: 'post',
                            dataType: "json",
                            data: {
                                _token: CSRF_TOKEN,
                                search: request.term,
                                team: $("#HeimID").val()

                            },
                            success: function(data) {
                                response(data.map(function(value) {
                                    return {
                                        'label': value.Vname,
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
                       $(id).val(ui.item.label);
                        
                        // $("#employee_search").text(ui.item.label); // display the selected text
                        //$("#liga").text(ui.item.label);
                        return false;
                    }
                });
           
        }

        function NnameG(elem) { 
          var id = document.getElementById(elem);
            
               $(id).autocomplete({
                 minLength: 0,
                    source: function(request, response) {
                        // Fetch data
                        $.ajax({
                            url: "{{ route('getSpielerNname') }}",
                            type: 'post',
                            dataType: "json",
                            data: {
                                _token: CSRF_TOKEN,
                                search: request.term,
                                team: $("#GastID").val()

                            },
                            success: function(data) {
                                response(data.map(function(value) {
                                    return {
                                        'label': value.Nname,
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
                       $(id).val(ui.item.label);
                        
                        // $("#employee_search").text(ui.item.label); // display the selected text
                        //$("#liga").text(ui.item.label);
                        return false;
                    }
                });
              
        }
         function VnameG(elem) { 
          var id = document.getElementById(elem);
               $(id).autocomplete({
                 minLength: 0,
                    source: function(request, response) {
                        // Fetch data
                        $.ajax({
                            url: "{{ route('getSpielerVname') }}",
                            type: 'post',
                            dataType: "json",
                            data: {
                                _token: CSRF_TOKEN,
                                search: request.term,
                                team: $("#GastID").val()

                            },
                            success: function(data) {
                                response(data.map(function(value) {
                                    return {
                                        'label': value.Vname,
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
                       $(id).val(ui.item.label);
                        
                        // $("#employee_search").text(ui.item.label); // display the selected text
                        //$("#liga").text(ui.item.label);
                        return false;
                    }
                });
           
        }

        function NH1() { // findet Id der Liga raus, dann erstellt datalist mit mannschaften dieser liga

            
                $("#soloNnameHeim1").autocomplete({
                 minLength: 0,
                    source: function(request, response) {
                        // Fetch data
                        $.ajax({
                            url: "{{ route('getSpielerNname') }}",
                            type: 'post',
                            dataType: "json",
                            data: {
                                _token: CSRF_TOKEN,
                                search: request.term,
                                team: $("#HeimID").val()

                            },
                            success: function(data) {
                                response(data.map(function(value) {
                                    return {
                                        'label': value.Nname,
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
                        $('#soloNnameHeim1').val(ui.item.label);
                        
                        // $("#employee_search").text(ui.item.label); // display the selected text
                        //$("#liga").text(ui.item.label);
                        return false;
                    }
                });
                
        }

         function NH2() { // findet Id der Liga raus, dann erstellt datalist mit mannschaften dieser liga

            
                $("#soloNnameHeim2").autocomplete({
                 minLength: 0,
                    source: function(request, response) {
                        // Fetch data
                        $.ajax({
                            url: "{{ route('getSpielerNname') }}",
                            type: 'post',
                            dataType: "json",
                            data: {
                                _token: CSRF_TOKEN,
                                search: request.term,
                                team: $("#HeimID").val()

                            },
                            success: function(data) {
                                response(data.map(function(value) {
                                    return {
                                        'label': value.Nname,
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
                        $('#soloNnameHeim2').val(ui.item.label);
                        
                        // $("#employee_search").text(ui.item.label); // display the selected text
                        //$("#liga").text(ui.item.label);
                        return false;
                    }
                });
                
        }
        function VH1() { // findet Id der Liga raus, dann erstellt datalist mit mannschaften dieser liga

            
                $("#soloVnameHeim1").autocomplete({
                 minLength: 0,
                    source: function(request, response) {
                        // Fetch data
                        $.ajax({
                            url: "{{ route('getSpielerVname') }}",
                            type: 'post',
                            dataType: "json",
                            data: {
                                _token: CSRF_TOKEN,
                                search: request.term,
                                team: $("#HeimID").val()

                            },
                            success: function(data) {
                                response(data.map(function(value) {
                                    return {
                                        'label': value.Vname,
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
                        $('#soloVnameHeim1').val(ui.item.label);
                        
                        // $("#employee_search").text(ui.item.label); // display the selected text
                        //$("#liga").text(ui.item.label);
                        return false;
                    }
                });
            
        }
        function NG1() { // findet Id der Liga raus, dann erstellt datalist mit mannschaften dieser liga

            
                $("#soloNnameGast1").autocomplete({
                 minLength: 0,
                    source: function(request, response) {
                        // Fetch data
                        $.ajax({
                            url: "{{ route('getSpielerNname') }}",
                            type: 'post',
                            dataType: "json",
                            data: {
                                _token: CSRF_TOKEN,
                                search: request.term,
                                team: $("#GastID").val()

                            },
                            success: function(data) {
                                response(data.map(function(value) {
                                    return {
                                        'label': value.Nname,
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
                        $('#soloNnameGast1').val(ui.item.label);
                        
                        // $("#employee_search").text(ui.item.label); // display the selected text
                        //$("#liga").text(ui.item.label);
                        return false;
                    }
                });
                
        }
        function VG1() { // findet Id der Liga raus, dann erstellt datalist mit mannschaften dieser liga

            
                $("#soloVnameGast1").autocomplete({
                 minLength: 0,
                    source: function(request, response) {
                        // Fetch data
                        $.ajax({
                            url: "{{ route('getSpielerVname') }}",
                            type: 'post',
                            dataType: "json",
                            data: {
                                _token: CSRF_TOKEN,
                                search: request.term,
                                team: $("#GastID").val()

                            },
                            success: function(data) {
                                response(data.map(function(value) {
                                    return {
                                        'label': value.Vname,
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
                        $('#soloVnameGast1').val(ui.item.label);
                        
                        // $("#employee_search").text(ui.item.label); // display the selected text
                        //$("#liga").text(ui.item.label);
                        return false;
                    }
                });
            
        }


        

        function alleNamen(){
        VH1();
        NH1();
        VG1();
        NG1();

        NH2();
        }
    </script>
@endsection

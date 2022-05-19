@extends('heafoo')
@php

use App\Http\Controllers\QueryController;
$matchID = $_GET['selectedID'];
$match = QueryController::getSingleMatch($matchID);
$homeID = $match->HeimID;
$awayID = $match->GastID;
$ligen = QueryController::alleLigen();
$liga = QueryController::getLiga($matchID);
$region = QueryController::getRegion($liga->ID);

#-----------------Neue Herangehensweise-----------------------------
$soloduell = QueryController::getSolo($matchID);
$doppelduell = QueryController::getDouble($matchID);
$tag = QueryController::getTag($matchID);
$runde = QueryController::getRunde($tag[0]->ID);
$saison = QueryController::getSaison($runde[0]->ID);
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
@section('page-content')

    <head>

        <!-- Meta -->
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                <input type="hidden" id="matchID" name="matchID" value="{{ $matchID }}">
                <input type="hidden" id="soloCount" name="soloCount" value="{{ count($soloduell) }}">
                <input type="hidden" id="doubleCount" name="doubleCount" value="{{ count($doppelduell) }}">
                <div class="flex mb-4" id="matchRow">
                    <div class="w-1/full bg-green-400 h-12">
                        <label class="block text-gray-900 text-sm font-bold mb-2 ml-3">Region:</label>
                        <input onfocus="javascript:$(this).autocomplete('search');" oninput="regioncheck()" type="text" id="region" name="region" onChange="markInput(this)" class="bg-gray-100 text-gray-900 w-full  border-gray-700 border-r-2 focus:outline-none border-b-full border-gray-700 focus:border-green-500 transition duration-500 px-3 pb-3" value="{{ $region->name }}"  >

                    </div>

                    <div class="w-1/full bg-green-400 h-12">


                        <label class="block text-gray-900 text-sm font-bold mb-2 ml-3">Staffel:</label>
                        <input type="text" onfocus="javascript:$(this).autocomplete('search');" oninput="check()" id="liga" onChange="markInput(this)" name="liga" class="bg-gray-100 text-gray-900 w-full  border-gray-700 border-r-2 focus:outline-none border-b-full border-gray-700 focus:border-green-500 transition duration-500 px-3 pb-3" value="{{ $liga->Name }}">
                    </div>

                    <div class="w-1/full bg-green-400 h-12">
                        <label class="block text-gray-900 text-sm font-bold mb-2 ml-3">Saison:</label>
                        <input type="text" oninput="saisoncheck()" onfocus="javascript:$(this).autocomplete('search');" name=" saison" id="saison" class="bg-gray-100 text-gray-900  border-gray-700 border-r-2  w-full focus:outline-none border-b-full border-gray-700 focus:border-green-500 transition duration-500 px-3 pb-3" value="{{ $saison[0]->Name }}">
                    </div>
                    <div class="w-1/full bg-green-400 h-12">
                        <label class="block text-gray-900 text-sm font-bold mb-2 ml-3">Runde:</label>
                        <input type="text" oninput="rundecheck()" onfocus="javascript:$(this).autocomplete('search');" name=" runde" id="runde" class="bg-gray-100 text-gray-900  border-gray-700 border-r-2  w-full focus:outline-none border-b-full border-gray-700 focus:border-green-500 transition duration-500 px-3 pb-3" value="{{ $runde[0]->Bezeichnung }}">
                    </div>
                    <div class="w-1/full bg-green-400 h-12">
                        <label class="block text-gray-900 text-sm font-bold mb-2 ml-3">Spieltag:</label>
                        <input type="text" oninput="tagcheck()" onfocus="javascript:$(this).autocomplete('search');" name=" tag" id="tag" class="bg-gray-100 text-gray-900  border-gray-700 border-r-2  w-full focus:outline-none border-b-full border-gray-700 focus:border-green-500 transition duration-500 px-3 pb-3" value="{{ $tag[0]->Tag }}">
                    </div>

                    <div class="w-1/full bg-green-400 h-12">
                        <label class="block text-gray-900 text-sm font-bold mb-2 ml-3" for="home">Heimverein:</label>
                        <input onload="MannschaftenH();" onfocus="javascript:MannschaftenH();$(this).autocomplete('search');" oninput="MannschaftenH()" type="text" onChange="markInput(this)" name=" tfHome" id="tfHome" class="bg-gray-100 text-gray-900  border-gray-700 border-r-2  w-full focus:outline-none border-b-full border-gray-700 focus:border-green-500 transition duration-500 px-3 pb-3" value="{{ $match->Heim }}">
                    </div>
                    <div class="w-1/full bg-green-400 h-12">
                        <label class="block text-gray-900 text-sm font-bold mb-2 ml-3" for="away">Gastverein:</label>
                        <input onload="MannschaftenG();" onfocus="javascript:MannschaftenG();$(this).autocomplete('search');" type="text" oninput="MannschaftenG()" onChange="markInput(this)" name="tfAway" id="tfAway" class="bg-gray-100 text-gray-900   border-gray-700 border-r-2 w-full focus:outlie-none border-b-full border-gray-700 focus:border-green-500 transition duration-500 px-3 pb-3" value="{{ $match->Gast }}">
                    </div>
                    <div class="w-1/full bg-green-400 h-12">
                        <label class="block text-gray-900 text-sm font-bold mb-2 ml-3" for="away">Schiedsrichter:</label>
                        <input type="text" name="schiri" id="schiri" onChange="markInput(this)" class="bg-gray-100 text-gray-900  border-gray-700 border-r-2 w-full focus:outline-none border-b-full border-gray-700 focus:border-green-500 transition duration-500 px-3 pb-3" value="{{ $match->Schiedsrichter }}">
                    </div>
                    <div class="w-1/full bg-green-400 h-12">
                        <label class="block text-gray-900 text-sm font-bold mb-2 ml-3" for="away">Austragungsort:</label>
                        <input type="text" name="tfPlace" id="tfPlace" onChange="markInput(this)" class="bg-gray-100 text-gray-900  w-full focus:outline-none border-b-full border-gray-700 focus:border-green-500 transition duration-500 px-3 pb-3" value="{{ $match->Spielort }}">
                    </div>
                </div>

                <h1>Doppel</h1>
                <table class="w-full flex flex-row flex-wrap rounded-lg my-5" id="tabDouble">
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
                            @if (count($doppelduell) >= 3)
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
                                @if (count($doppelduell) >= 4)
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
                            <th class="w-full sm:w-4 h-8 sm:h-auto text-center">Gast</th>
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
                                <th class="w-full sm:w-4 h-8 sm:h-auto text-center">Gast</th>
                            </tr>

                            @if (count($doppelduell) >= 3)
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
                                    <th class="w-full sm:w-4 h-8 sm:h-auto text-center">Gast</th>
                                </tr>
                                @if (count($doppelduell) >= 4)
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
                                        <th class="w-full sm:w-4 h-8 sm:h-auto text-center">Gast</th>
                                    </tr>
                                @endif
                            @endif
                        @endif
                    </thead>
                    <tbody class="flex-1 sm:flex-none" id="tabDoubleBody">
                        @if (count($doppelduell) >= 1)
                            <tr class="border-solid border-b-2 border-black w-44 sm:w-auto flex flex-col flex-no wrap sm:table-row mb-2 sm:mb-0" id="doppel1">
                                <input type="hidden" id="doppelDuellID1" name="doppelDuellID1" value="{{ $doppelduell[0]->Duell_ID }}">
                                <td class="bg-gray-100 h-8 text-black border-solid border-b-2 sm:border-r-2 border-black">
                                    <input type="text" list="arten" size="4" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300" name="dualType1" id="dualType1" value="{{ $doppelduell[0]->Duellart }}" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                    <input type="text" onload="VnameH(this.id)"  onfocus="javascript:VnameH(this.id);$(this).autocomplete('search');" size="20" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 sm:p-1.5" name="dualVnameHeim11" id="dualVnameHeim11" value="{{ $doppelduell[0]->Vorname_S1_H }}" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                    <input type="text" onload="NnameH(this.id)" onfocus="javascript:NnameH(this.id);$(this).autocomplete('search');" size="20" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" name="dualNnameHeim11" id="dualNnameHeim11" value="{{ $doppelduell[0]->Nachname_S1_H }}" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                    <input type="text" onload="VnameH(this.id)"  onfocus="javascript:VnameH(this.id);$(this).autocomplete('search');" size="20" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5" name="dualVnameHeim21" id="dualVnameHeim21" value="{{ $doppelduell[0]->Vorname_S2_H }}" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                    <input type="text" onload="NnameH(this.id)"  onfocus="javascript:NnameH(this.id);$(this).autocomplete('search');" size="20" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" name="dualNnameHeim21" id="dualNnameHeim21" value="{{ $doppelduell[0]->Nachname_S2_H }}" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                    <input type="text" onload="VnameG(this.id)"  onfocus="javascript:VnameG(this.id);$(this).autocomplete('search');" size="20" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 sm:p-1.5" name="dualVnameGast11" id="dualVnameGast11" value="{{ $doppelduell[0]->Vorname_S1_G }}" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                    <input type="text" onload="NnameG(this.id)" onfocus="javascript:NnameG(this.id);$(this).autocomplete('search');" size="20" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" name="dualNnameGast11" id="dualNnameGast11" value="{{ $doppelduell[0]->Nachname_S1_G }}" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                    <input type="text" onload="VnameG(this.id)" onfocus="javascript:VnameG(this.id);$(this).autocomplete('search');" size="20" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5" name="dualVnameGast21" id="dualVnameGast21" value="{{ $doppelduell[0]->Vorname_S2_G }}" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                    <input type="text" onload="NnameG(this.id)" onfocus="javascript:NnameG(this.id);$(this).autocomplete('search');" size="20" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" name="dualNnameGast21" id="dualNnameGast21" value="{{ $doppelduell[0]->Nachname_S2_G }}" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5" onchange="markInput(this); changeSetSumD(1)" name="dualSatz1heim1" id="dualSatz1heim1" value="{{ $doppelduell[0]->Satz_1_Heim }}" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" onchange="markInput(this); changeSetSumD(1)" name="dualSatz1gast1" id="dualSatz1gast1" value="{{ $doppelduell[0]->Satz_1_Gast }}" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5" onchange="markInput(this); changeSetSumD(1)" name="dualSatz2heim1" id="dualSatz2heim1" value="{{ $doppelduell[0]->Satz_2_Heim }}" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" onchange="markInput(this); changeSetSumD(1)" name="dualSatz2gast1" id="dualSatz2gast1" value="{{ $doppelduell[0]->Satz_2_Gast }}" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5" onchange="markInput(this); changeSetSumD(1)" name="dualSatz3heim1" id="dualSatz3heim1" value="{{ $doppelduell[0]->Satz_3_Heim }}" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" onchange="markInput(this); changeSetSumD(1)" name="dualSatz3gast1" id="dualSatz3gast1" value="{{ $doppelduell[0]->Satz_3_Gast }}" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right cursor-default p-1.5" readonly="readonly" tabindex="-1" name="dualSetpointHeim1" id="dualSetpointHeim1" value="" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full cursor-default p-1.5" readonly="readonly" tabindex="-1" name="dualSetpointGast1" id="dualSetpointGast1" value="" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right cursor-default p-1.5" readonly="readonly" tabindex="-1" name="dualWonSetHeim1" id="dualWonSetHeim1" value="" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full cursor-default p-1.5" readonly="readonly" tabindex="-1" name="dualWonSetGast1" id="dualWonSetGast1" value="" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right cursor-default p-1.5" readonly="readonly" tabindex="-1" name="dualWonMatchHeim1" id="dualWonMatchHeim1" value="" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full cursor-default p-1.5" readonly="readonly" tabindex="-1" name="dualWonMatchGast1" id="dualWonMatchGast1" value="" />
                                </td>
                            </tr>
                            @if (count($doppelduell) >= 2)
                                <tr class="border-solid border-b-2 border-black w-44 sm:w-auto flex flex-col flex-no wrap sm:table-row mb-2 sm:mb-0" id="doppel2">
                                    <input type="hidden" id="doppelDuellID2" name="doppelDuellID2" value="{{ $doppelduell[1]->Duell_ID }}"> <!-- ??$doppelduell[0] -->
                                    <td class="bg-gray-100 h-8 text-black border-solid border-b-2 sm:border-r-2 border-black">
                                        <input type="text" list="arten" size="4" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300" name="dualType2" id="dualType2" value="{{ $doppelduell[1]->Duellart }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                        <input type="text" onload="VnameH(this.id)" onfocus="javascript:VnameH(this.id);$(this).autocomplete('search');" size="20" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 sm:p-1.5" name="dualVnameHeim12" id="dualVnameHeim12" value="{{ $doppelduell[1]->Vorname_S1_H }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                        <input type="text" onload="NnameH(this.id)" onfocus="javascript:NnameH(this.id);$(this).autocomplete('search');" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" name="dualNnameHeim12" id="dualNnameHeim12" value="{{ $doppelduell[1]->Nachname_S1_H }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                        <input type="text" onload="VnameH(this.id)"  onfocus="javascript:VnameH(this.id);$(this).autocomplete('search');" size="20" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5" name="dualVnameHeim22" id="dualVnameHeim22" value="{{ $doppelduell[1]->Vorname_S2_H }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                        <input type="text" onload="NnameH(this.id)" onfocus="javascript:NnameH(this.id);$(this).autocomplete('search');" size="20" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" name="dualNnameHeim22" id="dualNnameHeim22" value="{{ $doppelduell[1]->Nachname_S2_H }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                        <input type="text" onload="VnameG(this.id)" onfocus="javascript:VnameG(this.id);$(this).autocomplete('search');" size="20" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 sm:p-1.5" name="dualVnameGast12" id="dualVnameGast12" value="{{ $doppelduell[1]->Vorname_S1_G }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                        <input type="text" onload="NnameG(this.id)" onfocus="javascript:NnameG(this.id);$(this).autocomplete('search');" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" name="dualNnameGast12" id="dualNnameGast12" value="{{ $doppelduell[1]->Nachname_S1_G }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                        <input type="text" onload="VnameG(this.id)"  onfocus="javascript:VnameG(this.id);$(this).autocomplete('search');" size="20" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5" name="dualVnameGast22" id="dualVnameGast22" value="{{ $doppelduell[1]->Vorname_S2_G }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                        <input type="text" onload="NnameG(this.id)"  onfocus="javascript:NnameG(this.id);$(this).autocomplete('search');" size="20" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" name="dualNnameGast22" id="dualNnameGast22" value="{{ $doppelduell[1]->Nachname_S2_G }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5" onchange="markInput(this); changeSetSumD(2)" name="dualSatz1heim2" id="dualSatz1heim2" value="{{ $doppelduell[1]->Satz_1_Heim }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" onchange="markInput(this); changeSetSumD(2)" name="dualSatz1gast2" id="dualSatz1gast2" value="{{ $doppelduell[1]->Satz_1_Gast }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5" onchange="markInput(this); changeSetSumD(2)" name="dualSatz2heim2" id="dualSatz2heim2" value="{{ $doppelduell[1]->Satz_2_Heim }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" onchange="markInput(this); changeSetSumD(2)" name="dualSatz2gast2" id="dualSatz2gast2" value="{{ $doppelduell[1]->Satz_2_Gast }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5" onchange="markInput(this); changeSetSumD(2)" name="dualSatz3heim2" id="dualSatz3heim2" value="{{ $doppelduell[1]->Satz_3_Heim }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" onchange="markInput(this); changeSetSumD(2)" name="dualSatz3gast2" id="dualSatz3gast2" value="{{ $doppelduell[1]->Satz_3_Gast }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right cursor-default p-1.5" readonly="readonly" tabindex="-1" name="dualSetpointHeim2" id="dualSetpointHeim2" value="" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 text-black w-full h-full cursor-default p-1.5" readonly="readonly" tabindex="-1" name="dualSetpointGast2" id="dualSetpointGast2" value="" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right cursor-default p-1.5" readonly="readonly" tabindex="-1" name="dualWonSetHeim2" id="dualWonSetHeim2" value="" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 text-black w-full h-full cursor-default p-1.5" readonly="readonly" tabindex="-1" name="dualWonSetGast2" id="dualWonSetGast2" value="" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right cursor-default p-1.5" readonly="readonly" tabindex="-1" name="dualWonMatchHeim2" id="dualWonMatchHeim2" value="" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black">
                                        <input type="text" size="4" class="bg-gray-100 text-black w-full h-full cursor-default p-1.5" readonly="readonly" tabindex="-1" name="dualWonMatchGast2" id="dualWonMatchGast2" value="" />
                                    </td>
                                </tr>
                                @if (count($doppelduell) >= 3)
                                    <tr class="border-solid border-b-2 border-black w-44 sm:w-auto flex flex-col flex-no wrap sm:table-row mb-2 sm:mb-0" id="doppel3">
                                        <input type="hidden" id="doppelDuellID3" name="doppelDuellID3" value="{{ $doppelduell[2]->Duell_ID }}">
                                        <td class="bg-gray-100 h-8 text-black border-solid border-b-2 sm:border-r-2 border-black">
                                            <input type="text" list="arten" size="4" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300" name="dualType3" id="dualType3" value="{{ $doppelduell[2]->Duellart }}" />
                                        </td>
                                        <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                            <input type="text" onload="VnameH(this.id)"  onfocus="javascript:VnameH(this.id);$(this).autocomplete('search');" size="20" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 sm:p-1.5" name="dualVnameHeim13" id="dualVnameHeim13" value="{{ $doppelduell[2]->Vorname_S1_H }}" />
                                        </td>
                                        <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                            <input type="text" onload="NnameH(this.id)" onfocus="javascript:NnameH(this.id);$(this).autocomplete('search');" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" name="dualNnameHeim13" id="dualNnameHeim13" value="{{ $doppelduell[2]->Nachname_S1_H }}" />
                                        </td>
                                        <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                            <input type="text" onload="VnameH(this.id)"  onfocus="javascript:VnameH(this.id);$(this).autocomplete('search');" size="20" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5" name="dualVnameHeim23" id="dualVnameHeim23" value="{{ $doppelduell[2]->Vorname_S2_H }}" />
                                        </td>
                                        <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                            <input type="text" onload="NnameH(this.id)" onfocus="javascript:NnameH(this.id);$(this).autocomplete('search');" size="20" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" name="dualNnameHeim23" id="dualNnameHeim23" value="{{ $doppelduell[2]->Nachname_S2_H }}" />
                                        </td>
                                        <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                            <input type="text" onload="VnameG(this.id)" onfocus="javascript:VnameG(this.id);$(this).autocomplete('search');" size="20" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 sm:p-1.5" name="dualVnameGast13" id="dualVnameGast13" value="{{ $doppelduell[2]->Vorname_S1_G }}" />
                                        </td>
                                        <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                            <input type="text" onload="NnameG(this.id)"  onfocus="javascript:NnameG(this.id);$(this).autocomplete('search');" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" name="dualNnameGast13" id="dualNnameGast13" value="{{ $doppelduell[2]->Nachname_S1_G }}" />
                                        </td>
                                        <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                            <input type="text" onload="VnameG(this.id)"  onfocus="javascript:VnameG(this.id);$(this).autocomplete('search');" size="20" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5" name="dualVnameGast23" id="dualVnameGast23" value="{{ $doppelduell[2]->Vorname_S2_G }}" />
                                        </td>
                                        <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                            <input type="text" onload="NnameG(this.id)"  onfocus="javascript:NnameG(this.id);$(this).autocomplete('search');" size="20" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" name="dualNnameGast23" id="dualNnameGast23" value="{{ $doppelduell[2]->Nachname_S2_G }}" />
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
                                            <input type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5" readonly="readonly" tabindex="-1" name="dualSetpointHeim3" id="dualSetpointHeim3" value="" />
                                        </td>
                                        <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                            <input type="text" size="4" class="bg-gray-100 text-black w-full h-full cursor-default p-1.5" readonly="readonly" tabindex="-1" name="dualSetpointGast3" id="dualSetpointGast3" value="" />
                                        </td>
                                        <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                            <input type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right cursor-default p-1.5" readonly="readonly" tabindex="-1" name="dualWonSetHeim3" id="dualWonSetHeim3" value="" />
                                        </td>
                                        <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                            <input type="text" size="4" class="bg-gray-100 text-black w-full h-full cursor-default p-1.5" readonly="readonly" tabindex="-1" name="dualWonSetGast3" id="dualWonSetGast3" value="" />
                                        </td>
                                        <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                            <input type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right cursor-default p-1.5" readonly="readonly" tabindex="-1" name="dualWonMatchHeim3" id="dualWonMatchHeim3" value="" />
                                        </td>
                                        <td class="bg-gray-100 h-8 text-black">
                                            <input type="text" size="4" class="bg-gray-100 text-black w-full h-full cursor-default p-1.5" readonly="readonly" tabindex="-1" name="dualWonMatchGast3" id="dualWonMatchGast3" value="" />
                                        </td>
                                    </tr>
                                    @if (count($doppelduell) >= 4)
                                        <tr class="border-solid border-b-2 border-black w-44 sm:w-auto flex flex-col flex-no wrap sm:table-row mb-2 sm:mb-0" id="doppel4">
                                            <input type="hidden" id="doppelDuellID4" name="doppelDuellID4" value="{{ $doppelduell[3]->Duell_ID }}">
                                            <td class="bg-gray-100 h-8 text-black border-solid border-b-2 sm:border-r-2 border-black">
                                                <input type="text" list="arten" size="4" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300" name="dualType4" id="dualType4" value="{{ $doppelduell[3]->Duellart }}" />
                                            </td>
                                            <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                                <input type="text" onload="VnameH(this.id)"  onfocus="javascript:VnameH(this.id);$(this).autocomplete('search');" size="20" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 sm:p-1.5" name="dualVnameHeim14" id="dualVnameHeim14" value="{{ $doppelduell[3]->Vorname_S1_H }}" />
                                            </td>
                                            <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                                <input type="text" onload="NnameH(this.id)" onfocus="javascript:NnameH(this.id);$(this).autocomplete('search');" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" name="dualNnameHeim14" id="dualNnameHeim14" value="{{ $doppelduell[3]->Nachname_S1_H }}" />
                                            </td>
                                            <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                                <input type="text" onload="VnameH(this.id)"  onfocus="javascript:VnameH(this.id);$(this).autocomplete('search');" size="20" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5" name="dualVnameHeim24" id="dualVnameHeim24" value="{{ $doppelduell[3]->Vorname_S2_H }}" />
                                            </td>
                                            <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                                <input type="text" onload="NnameH(this.id)" onfocus="javascript:NnameH(this.id);$(this).autocomplete('search');" size="20" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" name="dualNnameHeim24" id="dualNnameHeim24" value="{{ $doppelduell[3]->Nachname_S2_H }}" />
                                            </td>
                                            <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                                <input type="text" onload="VnameG(this.id)" onfocus="javascript:VnameG(this.id);$(this).autocomplete('search');" size="20" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 sm:p-1.5" name="dualVnameGast14" id="dualVnameGast14" value="{{ $doppelduell[3]->Vorname_S1_G }}" />
                                            </td>
                                            <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                                <input type="text" onload="NnameG(this.id)"  onfocus="javascript:NnameG(this.id);$(this).autocomplete('search');" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" name="dualNnameGast14" id="dualNnameGast14" value="{{ $doppelduell[3]->Nachname_S1_G }}" />
                                            </td>
                                            <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                                <input type="text" onload="VnameG(this.id)" onfocus="javascript:VnameG(this.id);$(this).autocomplete('search');" size="20" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5" name="dualVnameGast24" id="dualVnameGast24" value="{{ $doppelduell[3]->Vorname_S2_G }}" />
                                            </td>
                                            <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                                <input type="text" onload="NnameG(this.id)"  onfocus="javascript:NnameG(this.id);$(this).autocomplete('search');" size="20" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" name="dualNnameGast24" id="dualNnameGast24" value="{{ $doppelduell[3]->Nachname_S2_G }}" />
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
                                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right cursor-default p-1.5" readonly="readonly" tabindex="-1" name="dualSetpointHeim4" id="dualSetpointHeim4" value="" />
                                            </td>
                                            <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full cursor-default p-1.5" readonly="readonly" tabindex="-1" name="dualSetpointGast4" id="dualSetpointGast4" value="" />
                                            </td>
                                            <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right cursor-default p-1.5" readonly="readonly" tabindex="-1" name="dualWonSetHeim4" id="dualWonSetHeim4" value="" />
                                            </td>
                                            <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full cursor-default p-1.5" readonly="readonly" tabindex="-1" name="dualWonSetGast4" id="dualWonSetGast4" value="" />
                                            </td>
                                            <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right cursor-default p-1.5" readonly="readonly" tabindex="-1" name="dualWonMatchHeim4" id="dualWonMatchHeim4" value="" />
                                            </td>
                                            <td class="bg-gray-100 h-8 text-black">
                                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full cursor-default p-1.5" readonly="readonly" tabindex="-1" name="dualWonMatchGast4" id="dualWonMatchGast4" value="" />
                                            </td>
                                        </tr>
                                    @endif
                                @endif
                            @endif
                        @endif
                        <tr class="border-solid border-black w-44 sm:w-auto flex flex-col flex-no wrap sm:table-row mb-2 sm:mb-0">
                            <td colspan="15" class="invisible border-solid sm:border-r-2 border-black">
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right cursor-default p-1.5" readonly="readonly" tabindex="-1" name="sumSetHomeDual" id="sumSetHomeDual" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full cursor-default p-1.5" readonly="readonly" tabindex="-1" name="sumSetGuestDual" id="sumSetGuestDual" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right cursor-default p-1.5" readonly="readonly" tabindex="-1" name="sumWonSetHomeDual" id="sumWonSetHomeDual" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full cursor-default p-1.5" readonly="readonly p-1.5" tabindex="-1" name="sumWonSetGuestDual" id="sumWonSetGuestDual" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right cursor-default p-1.5" readonly="readonly" tabindex="-1" name="sumWonMatchHomeDual" id="sumWonMatchHomeDual" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full cursor-default p-1.5" readonly="readonly" tabindex="-1" name="sumWonMatchGuestDual" id="sumWonMatchGuestDual" />
                            </td>
                        </tr>
                    </tbody>
                </table>

                <h1 class="pt-5">Einzel</h1>

                <input type="hidden" name="regionID" id="regionID" value="{{ $region->ID }}">
                <input type="hidden" name="ligaID" id="ligaID" value="{{ $liga->ID }}">
                <input type="hidden" name="HeimID" id="HeimID" value="{{ $homeID }}">
                <input type="hidden" name="GastID" id="GastID" value="{{ $awayID }}">
                <input type="hidden" name="saisonID" id="saisonID" value="{{ $saison[0]->ID }}">
                <input type="hidden" name="rundeID" id="rundeID" value="{{ $runde[0]->ID }}">
                <input type="hidden" name="tagID" id="tagID" value="{{ $tag[0]->ID }}">
                <table class="w-full flex flex-row flex-wrap rounded-lg my-5" id="tabSolo">
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
                            <th class="w-full0 sm:w-4 h-8 sm:h-auto text-center">Gast</th>
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
                                <th class="w-full sm:w-4 h-8 sm:h-auto text-center">Gast</th>
                            </tr>
                        @endif
                    </thead>
                    <tbody class="flex-1 sm:flex-none" id="tabSoloBody">
                        @if (count($soloduell) >= 1)
                            <tr class="border-solid border-b-2 border-black w-44 sm:w-auto flex flex-col flex-no wrap sm:table-row mb-2 sm:mb-0" id="solo1">
                                <input type="hidden" id="duellID1" name="duellID1" value="{{ $soloduell[0]->Duell_ID }}">
                                <td class="bg-gray-100 h-8 text-black border-solid border-b-2 sm:border-r-2 border-black">
                                    <input type="text" list="arten" size="4" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300" name="soloType1" id="soloType1" value="{{ $soloduell[0]->Duellart }}" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                    <input type="text" onload="VnameH(this.id)"onfocus="VnameH(this.id);javascript:$(this).autocomplete('search');" size="20" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 sm:p-1.5" name="soloVnameHeim1" id="soloVnameHeim1" value="{{ $soloduell[0]->Vorname_S1 }}" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                    <input type="text" onload="NnameH(this.id)" onfocus="NnameH(this.id);javascript:$(this).autocomplete('search');" size="20" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" name="soloNnameHeim1" id="soloNnameHeim1" value="{{ $soloduell[0]->Nachname_S1 }}" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                    <input type="text" onload="VnameG(this.id)" onfocus="javascript:VnameG(this.id);$(this).autocomplete('search');"  size="20" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5" name="soloVnameGast1" id="soloVnameGast1" value="{{ $soloduell[0]->Vorname_S2 }}" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                    <input type="text" onload="NnameG(this.id)" onfocus="javascript:NnameG(this.id);$(this).autocomplete('search');"  size="20" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" name="soloNnameGast1" id="soloNnameGast1" value="{{ $soloduell[0]->Nachname_S2 }}" />
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
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right cursor-default p-1.5" readonly="readonly" tabindex="-1" name="soloSetpointHeim1" id="soloSetpointHeim1" value="" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full cursor-default p-1.5" readonly="readonly" tabindex="-1" name="soloSetpointGast1" id="soloSetpointGast1" value="" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right cursor-default p-1.5" readonly="readonly" tabindex="-1" name="soloWonSetHeim1" id="soloWonSetHeim1" value="" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full cursor-default p-1.5" readonly="readonly" tabindex="-1" name="soloWonSetGast1" id="soloWonSetGast1" value="" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:sm:text-right cursor-default p-1.5" readonly="readonly" tabindex="-1" name="soloWonMatchHeim1" id="soloWonMatchHeim1" value="" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full cursor-default p-1.5" readonly="readonly" tabindex="-1" name="soloWonMatchGast1" id="soloWonMatchGast1" value="" />
                                </td>
                            </tr>
                            @if (count($soloduell) >= 2)
                                <tr class="border-solid border-b-2 border-black w-44 sm:w-auto flex flex-col flex-no wrap sm:table-row mb-2 sm:mb-0" id="solo2">
                                    <input type="hidden" id="duellID2" name="duellID2" value="{{ $soloduell[1]->Duell_ID }}">
                                    <td class="bg-gray-100 h-8 text-black border-solid border-b-2 sm:border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300" onChange="markInput(this)" name="soloType2" id="soloType2" value="{{ $soloduell[1]->Duellart }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                        <input type="text" onload="VnameH(this.id)" onfocus="javascript:VnameH(this.id);$(this).autocomplete('search');"  size="20" size="20" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5" onChange="markInput(this)" name="soloVnameHeim2" id="soloVnameHeim2" value="{{ $soloduell[1]->Vorname_S1 }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                        <input type="text" onload="NnameH(this.id)" onfocus="javascript:NnameH(this.id);$(this).autocomplete('search');" size="20" class="bg-gray-100 p-1.5 text-black w-full focus:bg-green-400 transition duration-300" onChange="markInput(this)" name="soloNnameHeim2" id="soloNnameHeim2" value="{{ $soloduell[1]->Nachname_S1 }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                        <input type="text" onload="VnameG(this.id)" onfocus="javascript:VnameG(this.id);$(this).autocomplete('search');"  size="20" class="bg-gray-100 text-black w-full h-full sm:text-right  focus:bg-green-400 transition duration-300 p-1.5" onChange="markInput(this)" name="soloVnameGast2" id="soloVnameGast2" value="{{ $soloduell[1]->Vorname_S2 }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                        <input type="text" onload="NnameG(this.id)" onfocus="javascript:NnameG(this.id);$(this).autocomplete('search');" size="20" class="bg-gray-100 p-1.5 text-black w-full focus:bg-green-400 transition duration-300" onChange="markInput(this)" name="soloNnameGast2" id="soloNnameGast2" value="{{ $soloduell[1]->Nachname_S2 }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 sm:text-right  text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" onchange="markInput(this); changeSetSumS(2)" name="soloSatz1heim2" id="soloSatz1heim2" value="{{ $soloduell[1]->Satz_1_Heim }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 p-1.5 text-black w-full focus:bg-green-400 transition duration-300" onchange="markInput(this); changeSetSumS(2)" name="soloSatz1gast2" id="soloSatz1gast2" value="{{ $soloduell[1]->Satz_1_Gast }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 sm:text-right text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" onchange="markInput(this); changeSetSumS(2)" name="soloSatz2heim2" id="soloSatz2heim2" value="{{ $soloduell[1]->Satz_2_Heim }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 p-1.5 text-black w-full focus:bg-green-400 transition duration-300" onchange="markInput(this); changeSetSumS(2)" name="soloSatz2gast2" id="soloSatz2gast2" value="{{ $soloduell[1]->Satz_2_Gast }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 sm:text-right  text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" onchange="markInput(this); changeSetSumS(2)" name="soloSatz3heim2" id="soloSatz3heim2" value="{{ $soloduell[1]->Satz_3_Heim }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 p-1.5 text-black w-full focus:bg-green-400 transition duration-300" onchange="markInput(this); changeSetSumS(2)" name="soloSatz3gast2" id="soloSatz3gast2" value="{{ $soloduell[1]->Satz_3_Gast }}" />
                                    </td>
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 sm:text-right  text-black w-full h-full cursor-default p-1.5" readonly="readonly" tabindex="-1" name="soloSetpointHeim2" id="soloSetpointHeim2" value="" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 p-1.5 text-black w-full cursor-default" readonly="readonly" tabindex="-1" name="soloSetpointGast2" id="soloSetpointGast2" value="" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 sm:text-right  text-black w-full h-full cursor-default p-1.5" name="soloWonSetHeim2" readonly="readonly" tabindex="-1" id="soloWonSetHeim2" value="" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 p-1.5 text-black w-full cursor-default" readonly="readonly" tabindex="-1" name="soloWonSetGast2" id="soloWonSetGast2" value="" />
                                    <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 sm:text-right  text-black w-full h-full cursor-default p-1.5" name="soloWonMatchHeim2" readonly="readonly" tabindex="-1" id="soloWonMatchHeim2" value="" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black">
                                        <input type="text" size="4" class="bg-gray-100 p-1.5 text-black w-full cursor-default" readonly="readonly" tabindex="-1" name="soloWonMatchGast2" id="soloWonMatchGast2" value="" />
                                    </td>
                                </tr>
                            @endif
                        @endif
                        <tr class="border-solid border-black w-44 sm:w-auto flex flex-col flex-no wrap sm:table-row mb-2 sm:mb-0">
                            <td colspan="11" class="invisible border-solid sm:border-r-2 border-black">
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right cursor-default p-1.5" readonly="readonly" tabindex="-1" name="sumSetHomeDual" id="sumSetHomeSolo" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full cursor-default p-1.5" readonly="readonly" tabindex="-1" name="sumSetGuestDual" id="sumSetGuestSolo" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right cursor-default p-1.5" readonly="readonly" tabindex="-1" name="sumWonSetHomeDual" id="sumWonSetHomeSolo" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full cursor-default p-1.5" readonly="readonly p-1.5" tabindex="-1" name="sumWonSetGuestDual" id="sumWonSetGuestSolo" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right cursor-default p-1.5" readonly="readonly" tabindex="-1" name="sumWonMatchHomeDual" id="sumWonMatchHomeSolo" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full cursor-default p-1.5" readonly="readonly" tabindex="-1" name="sumWonMatchGuestDual" id="sumWonMatchGuestSolo" />
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table>
                    <thead>
                        <tr class="bg-green-400 flex flex-col sm:table-row rounded-l-lg sm:rounded-none mb-2 sm:mb-0">
                            <th class="w-28 h-16 sm:h-auto sm:w-4 border-solid sm:border-r-2 align-middle text-center">Spielpunkte Gesamt: Heim</th>
                            <th class="w-28 h-16 sm:h-auto sm:w-4 border-solid sm:border-r-2 align-middle text-center">Spielpunkte Gesamt: Gast</th>
                            <th class="w-28 h-16 sm:h-auto sm:w-4 border-solid sm:border-r-2 align-middle text-center">Sätze Gesamt: Heim</th>
                            <th class="w-28 h-16 sm:h-auto sm:w-4 border-solid sm:border-r-2 align-middle text-center">Sätze Gesamt: Gast</th>
                            <th class="w-28 h-16 sm:h-auto sm:w-4 border-solid sm:border-r-2 align-middle text-center">Punkte Gesamt: Heim</th>
                            <th class="w-28 h-16 sm:h-auto sm:w-4 border-solid sm:border-r-2 align-middle text-center">Punkte Gesamt: Gast</th>
                        </tr>
                    </thead>
                    <tbody class="flex-1 sm:flex-none" id="tabTotal">
                        <tr class="border-solid border-black w-44 sm:w-auto flex flex-col flex-no wrap sm:table-row mb-2 sm:mb-0">
                            <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right cursor-default p-1.5" readonly="readonly" tabindex="-1" name="sumSetHomeTotal" id="sumSetHomeTotal" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full cursor-default p-1.5" readonly="readonly" tabindex="-1" name="sumSetGuestTotal" id="sumSetGuestTotal" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right cursor-default p-1.5" readonly="readonly" tabindex="-1" name="sumWonSetHomeTotal" id="sumWonSetHomeTotal" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full cursor-default p-1.5" readonly="readonly p-1.5" tabindex="-1" name="sumWonSetGuestTotal" id="sumWonSetGuestTotal" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right cursor-default p-1.5" readonly="readonly" tabindex="-1" name="sumWonMatchHomeTotal" id="sumWonMatchHomeTotal" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full cursor-default p-1.5" readonly="readonly" tabindex="-1" name="sumWonMatchGuestTotal" id="sumWonMatchGuestTotal" />
                            </td>
                        </tr>
                    </tbody>
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
                        <button class="my-2 float-right px-3 py-3 rounded bg-green-500 active:bg-green-700 text-white text-sm opacity-70  font-bold" type="submit" id="submitBTN" name="submit" disabled>Absenden</button>
                    </div>
                </div>
            </form>
            <!--    <button class='fixed bottom-0 right-2 my-2 float-right px-3 py-3 rounded bg-green-500 active:bg-green-700 text-white text-sm opacity-70 hover:opacity-100 font-bold lg:hidden'>TAB</button>-->
        </div>
    </section>
    <script type="text/javascript">
        // CSRF Token
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $(document).ready(function() {
       if ($('#region').val()) {
               ligaregion();}
            saison();
            runde();
            tag();
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
                    document.getElementById("saison").disabled = true;
                    document.getElementById("tag").disabled = true;
                    document.getElementById("runde").disabled = true;
                    ligaregion();
                    document.getElementById("liga").disabled = false;
                    document.getElementById("liga").value = "";
                    document.getElementById("ligaID").value = "";
                    document.getElementById("saison").value = "";
                    document.getElementById("saisonID").value = "";
                    document.getElementById("runde").value = "";
                    document.getElementById("rundeID").value = "";
                    document.getElementById("tag").value = "";
                    document.getElementById("tagID").value = "";
                    document.getElementById("tfHome").value = "";
                    document.getElementById("HeimID").value = "";
                    document.getElementById("tfAway").value = "";
                    document.getElementById("GastID").value = "";
                    // $("#employee_search").text(ui.item.label); // display the selected text
                    //$("#liga").text(ui.item.label);
                    return false;
                }
            });
        });

        function regioncheck() {
            if (!$('#region').val()) {
                document.getElementById("liga").disabled = true;
                document.getElementById("saison").disabled = true;
                document.getElementById("tag").disabled = true;
                document.getElementById("runde").disabled = true;
                document.getElementById("liga").value = "";
                document.getElementById("ligaID").value = "";
                document.getElementById("regionID").value = "";
                document.getElementById("saison").value = "";
                document.getElementById("saisonID").value = "";
                document.getElementById("runde").value = "";
                document.getElementById("rundeID").value = "";
                document.getElementById("tag").value = "";
                document.getElementById("tagID").value = "";
                document.getElementById("tfHome").value = "";
                document.getElementById("HeimID").value = "";
                document.getElementById("tfAway").value = "";
                document.getElementById("GastID").value = "";
            }
        }

        function check() {
            if (!$('#liga').val()) {
                document.getElementById("ligaID").value = "";
                document.getElementById("saison").value = "";
                document.getElementById("saisonID").value = "";
                document.getElementById("runde").value = "";
                document.getElementById("rundeID").value = "";
                document.getElementById("tag").value = "";
                document.getElementById("tagID").value = "";
                document.getElementById("tfHome").value = "";
                document.getElementById("HeimID").value = "";
                document.getElementById("tfAway").value = "";
                document.getElementById("GastID").value = "";
                document.getElementById("saison").disabled = true;
                document.getElementById("tag").disabled = true;
                document.getElementById("runde").disabled = true;
            }
        }

     

        function ligaregion() {
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
                    $('#ligaID').val(ui.item.value);
                    document.getElementById("saison").disabled = false;
                    return false;
                }
            });
        }

        function saisoncheck() {
            if (!$('#saison').val()) {
                document.getElementById("runde").value = "";
                document.getElementById("saisonID").value = "";
                document.getElementById("rundeID").value = "";
                document.getElementById("tag").value = "";
                document.getElementById("tagID").value = "";
                document.getElementById("runde").disabled = true;
                document.getElementById("tag").disabled = true;
            }
        }

        function saison() {
            $("#saison").autocomplete({
                minLength: 0,
                source: function(request, response) {
                    // Fetch data
                    $.ajax({
                        url: "{{ route('saison') }}",
                        type: 'post',
                        dataType: "json",
                        data: {
                            _token: CSRF_TOKEN,
                            search: request.term,
                            ligaID: $("#ligaID").val()

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
                    $('#saison').val(ui.item.label);
                    $('#saisonID').val(ui.item.value);
                    document.getElementById("runde").disabled = false;
                    return false;
                }
            });

        }

        function rundecheck() {
            if (!$('#runde').val()) {

                document.getElementById("rundeID").value = "";
                document.getElementById("tag").value = "";
                document.getElementById("tagID").value = "";

                document.getElementById("tag").disabled = true;

            }
        }

        function runde() {


            $("#runde").autocomplete({
                minLength: 0,
                source: function(request, response) {
                    // Fetch data
                    $.ajax({
                        url: "{{ route('runde') }}",
                        type: 'post',
                        dataType: "json",
                        data: {
                            _token: CSRF_TOKEN,
                            search: request.term,
                            saisonID: $("#saisonID").val()

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
                    $('#runde').val(ui.item.label);
                    $('#rundeID').val(ui.item.value);
                    document.getElementById("tag").disabled = false;
                    return false;
                }
            });

        }

        function tagcheck() {
            if (!$('#tag').val()) {
                document.getElementById("tagID").value = "";
            }
        }

        function tag() {


            $("#tag").autocomplete({
                minLength: 0,
                source: function(request, response) {
                    // Fetch data
                    $.ajax({
                        url: "{{ route('tag') }}",
                        type: 'post',
                        dataType: "json",
                        data: {
                            _token: CSRF_TOKEN,
                            search: request.term,
                            rundeID: $("#rundeID").val()

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
                    $('#tag').val(ui.item.label);
                    $('#tagID').val(ui.item.value);;
                    return false;
                }
            });

        }


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
            } else if ($("#region").val().length > 0) {
                $("#tfHome").autocomplete({
                    minLength: 0,
                    source: function(request, response) {
                        // Fetch data
                        $.ajax({
                            url: "{{ route('regionMannschaften') }}",
                            type: 'post',
                            dataType: "json",
                            data: {
                                _token: CSRF_TOKEN,
                                search: request.term,
                                region: $("#regionID").val()

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

                        return false;
                    }
                });
            } else {
                $("#tfHome").autocomplete({
                    minLength: 0,
                    source: function(request, response) {
                        // Fetch data
                        $.ajax({
                            url: "{{ route('mannschaften') }}",
                            type: 'post',
                            dataType: "json",
                            data: {
                                _token: CSRF_TOKEN,
                                search: request.term,


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
            } else if ($("#region").val().length > 0) {
                $("#tfAway").autocomplete({
                    minLength: 0,
                    source: function(request, response) {
                        // Fetch data
                        $.ajax({
                            url: "{{ route('regionMannschaften') }}",
                            type: 'post',
                            dataType: "json",
                            data: {
                                _token: CSRF_TOKEN,
                                search: request.term,
                                region: $("#regionID").val()

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

                        return false;
                    }
                });
            } else {
                $("#tfAway").autocomplete({
                    minLength: 0,
                    source: function(request, response) {
                        // Fetch data
                        $.ajax({
                            url: "{{ route('mannschaften') }}",
                            type: 'post',
                            dataType: "json",
                            data: {
                                _token: CSRF_TOKEN,
                                search: request.term,


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

                        return false;
                    }
                });


            }
        }

        function NnameH(elem) {
            var id = document.getElementById(elem);
            var fNameID = elem.replace("Nname", "Vname");
            var fName = document.getElementById(fNameID);
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
                                    'label': value.Vname + ' ' + value.Nname,
                                    'labelV': value.Vname,
                                    'labelN': value.Nname,
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
                    $(id).val(ui.item.labelN);
                    $(fName).val(ui.item.labelV);

                    // $("#employee_search").text(ui.item.label); // display the selected text
                    //$("#liga").text(ui.item.label);
                    return false;
                }
            });

        }

        function VnameH(elem) { //  erstellt liste mit passenden vornamen der heimmannschaft
            var id = document.getElementById(elem);
            var nNameID = elem.replace("Vname", "Nname");
            console.log(nNameID);
            var nName = document.getElementById(nNameID);
            $(id).autocomplete({
                minLength: 0,
                source: function(request, response) {
                    // Fetch    
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
                                    'label': value.Vname + ' ' + value.Nname,
                                    'labelV': value.Vname,
                                    'labelN': value.Nname,
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
                    $(id).val(ui.item.labelV);
                    $(nName).val(ui.item.labelN);

                  
                    return false;
                }
            });

        }

        function NnameG(elem) {
            var id = document.getElementById(elem);
            var fNameID = elem.replace("Nname", "Vname");
            var fName = document.getElementById(fNameID);
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
                                    'label': value.Vname + ' ' + value.Nname,
                                    'labelV': value.Vname,
                                    'labelN': value.Nname,
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
                    $(id).val(ui.item.labelN);
                    $(fName).val(ui.item.labelV);

                    // $("#employee_search").text(ui.item.label); // display the selected text
                    //$("#liga").text(ui.item.label);
                    return false;
                }
            });

        }

        function VnameG(elem) {
            var id = document.getElementById(elem);
            var nNameID = elem.replace("Vname", "Nname");
            var nName = document.getElementById(nNameID);
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
                                    'label': value.Vname + ' ' + value.Nname,
                                    'labelV': value.Vname,
                                    'labelN': value.Nname,
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
                    $(id).val(ui.item.labelV);
                    $(nName).val(ui.item.labelN);

                    // $("#employee_search").text(ui.item.label); // display the selected text
                    //$("#liga").text(ui.item.label);
                    return false;
                }
            });

        }
    </script>
@endsection

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
    <section>
        <h3 class="font-bold text-2xl">Spielberichtsbogen</h3>
    </section>
    <section class="mt-10 overflow-x:auto">
        <div class="">
            <form class="mx-3 mb-6" method="POST" onsubmit="return validateInputs();" action="{{ url('/overview') }}">
                @csrf
                <input type="hidden" id="matchID" name="matchID" value="{{ $matchID }}">
                <input type="hidden" id="soloCount" name="soloCount" value="{{ count($soloduell) }}">
                <input type="hidden" id="doubleCount" name="doubleCount" value="{{ count($doppelduell) }}">
                <div class="flex mb-4" style="overflow-x:auto;" id="matchRow">
                    <div class="w-1/full bg-green-400 h-16 min-w-fit">
                        <label class="block text-gray-900 text-sm font-bold pb-2 border-gray-700 border-r-2 pl-1">Region:</label>
                        <input onfocus="javascript:$(this).autocomplete('search');" oninput="regioncheck()" type="text" id="region" name="region" onChange="markInput(this)" class="bg-gray-100 text-gray-900 h-9 w-full border-gray-700 border-r-2 border-t-2 focus:outline-none border-b-full border-gray-700 focus:bg-green-400 transition duration-500 pl-1" value="{{ $region->name }}">

                    </div>
                    <div class="w-1/full bg-green-400 h-16 min-w-fit">
                        <label class="block text-gray-900 text-sm font-bold pb-2 border-gray-700 border-r-2 pl-1">Staffel:</label>
                        <input type="text" onfocus="javascript:$(this).autocomplete('search');" oninput="check()" id="liga" onChange="markInput(this)" name="liga" class="bg-gray-100 text-gray-900 h-9 w-full border-gray-700 border-r-2 border-t-2 focus:outline-none border-b-full border-gray-700 focus:bg-green-400 transition duration-500 pl-1" value="{{ $liga->Name }}">
                    </div>

                    <div class="w-1/full bg-green-400 h-16 min-w-fit">
                        <label class="block text-gray-900 text-sm font-bold pb-2 border-gray-700 border-r-2 pl-1">Saison:</label>
                        <input type="text" oninput="saisoncheck()" onfocus="javascript:$(this).autocomplete('search');" name="saison" id="saison" class="bg-gray-100 text-gray-900 border-gray-700 border-r-2 border-t-2 h-9 w-full focus:outline-none border-b-full border-gray-700 focus:bg-green-400 transition duration-500 pl-1" value="{{ $saison[0]->Name }}">
                    </div>
                    <div class="w-1/full bg-green-400 h-16 min-w-fit">
                        <label class="block text-gray-900 text-sm font-bold pb-2 border-gray-700 border-r-2 pl-1">Runde:</label>
                        <input type="text" oninput="rundecheck()" onfocus="javascript:$(this).autocomplete('search');" name="runde" id="runde" class="bg-gray-100 text-gray-900 border-gray-700 border-r-2 border-t-2 h-9 w-full focus:outline-none border-b-full border-gray-700 focus:bg-green-400 transition duration-500 pl-1" value="{{ $runde[0]->Bezeichnung }}">
                    </div>
                    <div class="w-1/full bg-green-400 h-16 min-w-fit">
                        <label class="block text-gray-900 text-sm font-bold pb-2 border-gray-700 border-r-2 pl-1">Spieltag:</label>
                        <input type="text" oninput="tagcheck()" onfocus="javascript:$(this).autocomplete('search');" name="tag" id="tag" class="bg-gray-100 text-gray-900 border-gray-700 border-r-2 border-t-2 h-9 w-full focus:outline-none border-b-full focus:bg-green-400 transition duration-500 pl-1" value="{{ $tag[0]->Tag }}">
                    </div>

                    <div class="w-1/full bg-green-400 h-16 min-w-fit">
                        <label class="block text-gray-900 text-sm font-bold pb-2 border-gray-700 border-r-2 pl-1" for="home">Heimverein:</label>
                        <input onload="MannschaftenH();" onfocus="javascript:MannschaftenH();$(this).autocomplete('search');" oninput="MannschaftenH()" type="text" onChange="markInput(this)" name=" tfHome" id="tfHome" class="bg-gray-100 text-gray-900 border-gray-700 border-r-2 border-t-2 h-9 w-full focus:outline-none border-b-full border-gray-700 focus:bg-green-400 transition duration-500 pl-1" value="{{ $match->Heim }}">
                    </div>
                    <div class="w-1/full bg-green-400 h-16 min-w-fit">
                        <label class="block text-gray-900 text-sm font-bold pb-2 border-gray-700 border-r-2 pl-1" for="away">Gastverein:</label>
                        <input onload="MannschaftenG();" onfocus="javascript:MannschaftenG();$(this).autocomplete('search');" type="text" oninput="MannschaftenG()" onChange="markInput(this)" name="tfAway" id="tfAway" class="bg-gray-100 text-gray-900 border-gray-700 border-r-2 border-t-2 h-9 w-full focus:outlie-none border-b-full border-gray-700 focus:bg-green-400 transition duration-500 pl-1" value="{{ $match->Gast }}">
                    </div>
                    <div class="w-1/full bg-green-400 h-16 min-w-fit">
                        <label class="block text-gray-900 text-sm font-bold pb-2 border-gray-700 border-r-2 pl-1" for="away">Schiedsrichter:</label>
                        <input type="text" name="schiri" id="schiri" onChange="markInput(this)" class="bg-gray-100 text-gray-900 border-gray-700 border-r-2 border-t-2 h-9 w-full focus:outline-none border-b-full border-gray-700 focus:bg-green-400 transition duration-500 pl-1" value="{{ $match->Schiedsrichter }}">
                    </div>
                    <div class="w-1/full bg-green-400 h-16 min-w-fit">
                        <label class="block text-gray-900 text-sm font-bold pb-2 pl-1" for="away">Austragungsort:</label>
                        <input type="text" name="tfPlace" id="tfPlace" onChange="markInput(this)" class="bg-gray-100 text-gray-900 h-9 w-full focus:outline-none border-b-full border-gray-700 focus:bg-green-400 transition border-t-2 duration-500 pl-1" value="{{ $match->Spielort }}">
                    </div>
                </div>

                <h1>Doppel</h1>
                <div style="overflow-x:auto;">
                    <table class="table-auto w-full rounded-lg my-5" id="tabDouble">
                        <thead>
                            <tr class="bg-green-400 table-row rounded-none mb-0">
                                <th class="border-solid border-r-2 align-middle text-center">Art</th>
                                <th class="border-solid border-r-2 align-middle text-center" colspan="2">Spieler 1: Heim</th>
                                <th class="border-solid border-r-2 align-middle text-center" rowspan="2" colspan="2">Spieler 2: Heim</th>
                                <th class="border-solid border-r-2 align-middle text-center" colspan="2">Spieler 1: Gast</th>
                                <th class="border-solid border-r-2 align-middle text-center" rowspan="2" colspan="2">Spieler 2: Gast</th>
                                <th class="border-solid border-r-2 align-middle text-center" rowspan="6" colspan="6">Satzergebnisse</th>
                                <th class="border-solid border-r-2 align-middle text-center" rowspan="2" colspan="2">Summe: Spielpunkte</th>
                                <th class="border-solid border-r-2 align-middle text-center" rowspan="2" colspan="2">Summe: Sätze</th>
                                <th class="border-solid align-middle text-center" rowspan="2" colspan="2">Punkte</th>
                            </tr>
                        </thead>
                        <thead>
                            <tr class="table-row rounded-none mb-0 whitespace-nowrap">
                                <th class="border-solid h-auto border-t-2 border-white border-r-2 text-center">Art</th>
                                <th class="text-center h-auto">Vorname</th>
                                <th class="border-solid h-auto border-r-2 text-center">Nachname</th>
                                <th class="text-center h-auto">Vorname</th>
                                <th class="border-solid h-auto border-r-2 text-center">Nachname</th>
                                <th class="text-center h-auto">Vorname</th>
                                <th class="border-solid h-auto border-r-2 text-center">Nachname</th>
                                <th class="text-center h-auto">Vorname</th>
                                <th class="border-solid h-auto border-r-2 text-center">Nachname</th>
                                <th class="w-4 h-auto text-center" colspan="2">1. Satz</th>
                                <th class="w-4 h-auto text-center" colspan="2">2. Satz</th>
                                <th class="w-4 h-auto text-center border-solid border-r-2" colspan="2">3. Satz</th>
                                <th class="w-4 h-auto text-center">Heim</th>
                                <th class="w-4 h-auto text-center border-solid border-r-2">Gast</th>
                                <th class="w-4 h-auto text-center">Heim</th>
                                <th class="w-4 h-auto text-center border-solid border-r-2">Gast</th>
                                <th class="w-4 h-auto text-center">Heim</th>
                                <th class="w-4 h-auto text-center">Gast</th>
                            </tr>
                        </thead>
                        <tbody class="" id="tabDoubleBody">
                            @if (count($doppelduell) >= 1)
                                <tr class="border-solid border-b-2 border-black w-44 w-auto flex flex-col flex-no wrap table-row mb-0" id="doppel1">
                                    <input type="hidden" id="doppelDuellID1" name="doppelDuellID1" value="{{ $doppelduell[0]->Duell_ID }}">
                                    <td class="bg-gray-100 h-8 text-black border-solid border-b-2 border-r-2 border-black">
                                        <input type="text" list="arten" size="4" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300" name="dualType1" id="dualType1" value="{{ $doppelduell[0]->Duellart }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                        <input type="text" onload="VnameH(this.id)" onfocus="javascript:VnameH(this.id);$(this).autocomplete('search');" size="20" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full text-right focus:bg-green-400 transition duration-300 pr-1" name="dualVnameHeim11" id="dualVnameHeim11" value="{{ $doppelduell[0]->Vorname_S1_H }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                        <input type="text" onload="NnameH(this.id)" onfocus="javascript:NnameH(this.id);$(this).autocomplete('search');" size="20" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 pl-1" name="dualNnameHeim11" id="dualNnameHeim11" value="{{ $doppelduell[0]->Nachname_S1_H }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                        <input type="text" onload="VnameH(this.id)" onfocus="javascript:VnameH(this.id);$(this).autocomplete('search');" size="20" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full text-right focus:bg-green-400 transition duration-300 pr-1" name="dualVnameHeim21" id="dualVnameHeim21" value="{{ $doppelduell[0]->Vorname_S2_H }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                        <input type="text" onload="NnameH(this.id)" onfocus="javascript:NnameH(this.id);$(this).autocomplete('search');" size="20" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 pl-1" name="dualNnameHeim21" id="dualNnameHeim21" value="{{ $doppelduell[0]->Nachname_S2_H }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                        <input type="text" onload="VnameG(this.id)" onfocus="javascript:VnameG(this.id);$(this).autocomplete('search');" size="20" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full text-right focus:bg-green-400 transition duration-300 pr-1" name="dualVnameGast11" id="dualVnameGast11" value="{{ $doppelduell[0]->Vorname_S1_G }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                        <input type="text" onload="NnameG(this.id)" onfocus="javascript:NnameG(this.id);$(this).autocomplete('search');" size="20" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 pl-1" name="dualNnameGast11" id="dualNnameGast11" value="{{ $doppelduell[0]->Nachname_S1_G }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                        <input type="text" onload="VnameG(this.id)" onfocus="javascript:VnameG(this.id);$(this).autocomplete('search');" size="20" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full text-right focus:bg-green-400 transition duration-300 pr-1" name="dualVnameGast21" id="dualVnameGast21" value="{{ $doppelduell[0]->Vorname_S2_G }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                        <input type="text" onload="NnameG(this.id)" onfocus="javascript:NnameG(this.id);$(this).autocomplete('search');" size="20" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 pl-1" name="dualNnameGast21" id="dualNnameGast21" value="{{ $doppelduell[0]->Nachname_S2_G }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 min-w-600 text-black w-full h-full text-right focus:bg-green-400 transition duration-300 pr-1" onchange="markInput(this); changeSetSumD(1)" name="dualSatz1heim1" id="dualSatz1heim1" value="{{ $doppelduell[0]->Satz_1_Heim }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 pl-1" onchange="markInput(this); changeSetSumD(1)" name="dualSatz1gast1" id="dualSatz1gast1" value="{{ $doppelduell[0]->Satz_1_Gast }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 text-black w-full h-full text-right focus:bg-green-400 transition duration-300 pr-1" onchange="markInput(this); changeSetSumD(1)" name="dualSatz2heim1" id="dualSatz2heim1" value="{{ $doppelduell[0]->Satz_2_Heim }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 pl-1" onchange="markInput(this); changeSetSumD(1)" name="dualSatz2gast1" id="dualSatz2gast1" value="{{ $doppelduell[0]->Satz_2_Gast }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 text-black w-full h-full text-right focus:bg-green-400 transition duration-300 pr-1" onchange="markInput(this); changeSetSumD(1)" name="dualSatz3heim1" id="dualSatz3heim1" value="{{ $doppelduell[0]->Satz_3_Heim }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 pl-1" onchange="markInput(this); changeSetSumD(1)" name="dualSatz3gast1" id="dualSatz3gast1" value="{{ $doppelduell[0]->Satz_3_Gast }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 text-black w-full h-full text-right cursor-default pr-1" readonly="readonly" tabindex="-1" name="dualSetpointHeim1" id="dualSetpointHeim1" value="" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 text-black w-full h-full cursor-default pl-1" readonly="readonly" tabindex="-1" name="dualSetpointGast1" id="dualSetpointGast1" value="" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 text-black w-full h-full text-right cursor-default pr-1" readonly="readonly" tabindex="-1" name="dualWonSetHeim1" id="dualWonSetHeim1" value="" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 text-black w-full h-full cursor-default pl-1" readonly="readonly" tabindex="-1" name="dualWonSetGast1" id="dualWonSetGast1" value="" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 text-black w-full h-full text-right cursor-default pr-1" readonly="readonly" tabindex="-1" name="dualWonMatchHeim1" id="dualWonMatchHeim1" value="" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black">
                                        <input type="text" size="4" class="bg-gray-100 text-black w-full h-full cursor-default pl-1" readonly="readonly" tabindex="-1" name="dualWonMatchGast1" id="dualWonMatchGast1" value="" />
                                    </td>
                                </tr>
                                @if (count($doppelduell) >= 2)
                                    <tr class="border-solid border-b-2 border-black w-44 w-auto table-row mb-0" id="doppel2">
                                        <input type="hidden" id="doppelDuellID2" name="doppelDuellID2" value="{{ $doppelduell[1]->Duell_ID }}"> <!-- ??$doppelduell[0] -->
                                        <td class="bg-gray-100 h-8 text-black border-solid border-b-2 border-r-2 border-black">
                                            <input type="text" list="arten" size="4" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300" name="dualType2" id="dualType2" value="{{ $doppelduell[1]->Duellart }}" />
                                        </td>
                                        <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                            <input type="text" onload="VnameH(this.id)" onfocus="javascript:VnameH(this.id);$(this).autocomplete('search');" size="20" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full text-right focus:bg-green-400 transition duration-300 pr-1" name="dualVnameHeim12" id="dualVnameHeim12" value="{{ $doppelduell[1]->Vorname_S1_H }}" />
                                        </td>
                                        <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                            <input type="text" onload="NnameH(this.id)" onfocus="javascript:NnameH(this.id);$(this).autocomplete('search');" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 pl-1" name="dualNnameHeim12" id="dualNnameHeim12" value="{{ $doppelduell[1]->Nachname_S1_H }}" />
                                        </td>
                                        <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                            <input type="text" onload="VnameH(this.id)" onfocus="javascript:VnameH(this.id);$(this).autocomplete('search');" size="20" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full text-right focus:bg-green-400 transition duration-300 pr-1" name="dualVnameHeim22" id="dualVnameHeim22" value="{{ $doppelduell[1]->Vorname_S2_H }}" />
                                        </td>
                                        <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                            <input type="text" onload="NnameH(this.id)" onfocus="javascript:NnameH(this.id);$(this).autocomplete('search');" size="20" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 pl-1" name="dualNnameHeim22" id="dualNnameHeim22" value="{{ $doppelduell[1]->Nachname_S2_H }}" />
                                        </td>
                                        <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                            <input type="text" onload="VnameG(this.id)" onfocus="javascript:VnameG(this.id);$(this).autocomplete('search');" size="20" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full text-right focus:bg-green-400 transition duration-300 pr-1" name="dualVnameGast12" id="dualVnameGast12" value="{{ $doppelduell[1]->Vorname_S1_G }}" />
                                        </td>
                                        <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                            <input type="text" onload="NnameG(this.id)" onfocus="javascript:NnameG(this.id);$(this).autocomplete('search');" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 pl-1" name="dualNnameGast12" id="dualNnameGast12" value="{{ $doppelduell[1]->Nachname_S1_G }}" />
                                        </td>
                                        <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                            <input type="text" onload="VnameG(this.id)" onfocus="javascript:VnameG(this.id);$(this).autocomplete('search');" size="20" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full text-right focus:bg-green-400 transition duration-300 pr-1" name="dualVnameGast22" id="dualVnameGast22" value="{{ $doppelduell[1]->Vorname_S2_G }}" />
                                        </td>
                                        <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                            <input type="text" onload="NnameG(this.id)" onfocus="javascript:NnameG(this.id);$(this).autocomplete('search');" size="20" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 pl-1" name="dualNnameGast22" id="dualNnameGast22" value="{{ $doppelduell[1]->Nachname_S2_G }}" />
                                        </td>
                                        <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                            <input type="text" size="4" class="bg-gray-100 text-black w-full h-full text-right focus:bg-green-400 transition duration-300 pr-1" onchange="markInput(this); changeSetSumD(2)" name="dualSatz1heim2" id="dualSatz1heim2" value="{{ $doppelduell[1]->Satz_1_Heim }}" />
                                        </td>
                                        <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                            <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 pl-1" onchange="markInput(this); changeSetSumD(2)" name="dualSatz1gast2" id="dualSatz1gast2" value="{{ $doppelduell[1]->Satz_1_Gast }}" />
                                        </td>
                                        <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                            <input type="text" size="4" class="bg-gray-100 text-black w-full h-full text-right focus:bg-green-400 transition duration-300 pr-1" onchange="markInput(this); changeSetSumD(2)" name="dualSatz2heim2" id="dualSatz2heim2" value="{{ $doppelduell[1]->Satz_2_Heim }}" />
                                        </td>
                                        <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                            <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 pl-1" onchange="markInput(this); changeSetSumD(2)" name="dualSatz2gast2" id="dualSatz2gast2" value="{{ $doppelduell[1]->Satz_2_Gast }}" />
                                        </td>
                                        <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                            <input type="text" size="4" class="bg-gray-100 text-black w-full h-full text-right focus:bg-green-400 transition duration-300 pr-1" onchange="markInput(this); changeSetSumD(2)" name="dualSatz3heim2" id="dualSatz3heim2" value="{{ $doppelduell[1]->Satz_3_Heim }}" />
                                        </td>
                                        <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                            <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 pl-1" onchange="markInput(this); changeSetSumD(2)" name="dualSatz3gast2" id="dualSatz3gast2" value="{{ $doppelduell[1]->Satz_3_Gast }}" />
                                        </td>
                                        <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                            <input type="text" size="4" class="bg-gray-100 text-black w-full h-full text-right cursor-default pr-1" readonly="readonly" tabindex="-1" name="dualSetpointHeim2" id="dualSetpointHeim2" value="" />
                                        </td>
                                        <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                            <input type="text" size="4" class="bg-gray-100 text-black w-full h-full cursor-default pl-1" readonly="readonly" tabindex="-1" name="dualSetpointGast2" id="dualSetpointGast2" value="" />
                                        </td>
                                        <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                            <input type="text" size="4" class="bg-gray-100 text-black w-full h-full text-right cursor-default pr-1" readonly="readonly" tabindex="-1" name="dualWonSetHeim2" id="dualWonSetHeim2" value="" />
                                        </td>
                                        <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                            <input type="text" size="4" class="bg-gray-100 text-black w-full h-full cursor-default pl-1" readonly="readonly" tabindex="-1" name="dualWonSetGast2" id="dualWonSetGast2" value="" />
                                        </td>
                                        <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                            <input type="text" size="4" class="bg-gray-100 text-black w-full h-full text-right cursor-default pr-1" readonly="readonly" tabindex="-1" name="dualWonMatchHeim2" id="dualWonMatchHeim2" value="" />
                                        </td>
                                        <td class="bg-gray-100 h-8 text-black">
                                            <input type="text" size="4" class="bg-gray-100 text-black w-full h-full cursor-default pl-1" readonly="readonly" tabindex="-1" name="dualWonMatchGast2" id="dualWonMatchGast2" value="" />
                                        </td>
                                    </tr>
                                    @if (count($doppelduell) >= 3)
                                        <tr class="border-solid border-b-2 border-black w-44 w-auto table-row mb-0" id="doppel3">
                                            <input type="hidden" id="doppelDuellID3" name="doppelDuellID3" value="{{ $doppelduell[2]->Duell_ID }}">
                                            <td class="bg-gray-100 h-8 text-black border-solid border-b-2 border-r-2 border-black">
                                                <input type="text" list="arten" size="4" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300" name="dualType3" id="dualType3" value="{{ $doppelduell[2]->Duellart }}" />
                                            </td>
                                            <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                                <input type="text" onload="VnameH(this.id)" onfocus="javascript:VnameH(this.id);$(this).autocomplete('search');" size="20" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full text-right focus:bg-green-400 transition duration-300 pr-1" name="dualVnameHeim13" id="dualVnameHeim13" value="{{ $doppelduell[2]->Vorname_S1_H }}" />
                                            </td>
                                            <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                                <input type="text" onload="NnameH(this.id)" onfocus="javascript:NnameH(this.id);$(this).autocomplete('search');" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 pl-1" name="dualNnameHeim13" id="dualNnameHeim13" value="{{ $doppelduell[2]->Nachname_S1_H }}" />
                                            </td>
                                            <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                                <input type="text" onload="VnameH(this.id)" onfocus="javascript:VnameH(this.id);$(this).autocomplete('search');" size="20" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full text-right focus:bg-green-400 transition duration-300 pr-1" name="dualVnameHeim23" id="dualVnameHeim23" value="{{ $doppelduell[2]->Vorname_S2_H }}" />
                                            </td>
                                            <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                                <input type="text" onload="NnameH(this.id)" onfocus="javascript:NnameH(this.id);$(this).autocomplete('search');" size="20" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 pl-1" name="dualNnameHeim23" id="dualNnameHeim23" value="{{ $doppelduell[2]->Nachname_S2_H }}" />
                                            </td>
                                            <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                                <input type="text" onload="VnameG(this.id)" onfocus="javascript:VnameG(this.id);$(this).autocomplete('search');" size="20" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full text-right focus:bg-green-400 transition duration-300 pr-1" name="dualVnameGast13" id="dualVnameGast13" value="{{ $doppelduell[2]->Vorname_S1_G }}" />
                                            </td>
                                            <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                                <input type="text" onload="NnameG(this.id)" onfocus="javascript:NnameG(this.id);$(this).autocomplete('search');" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 pl-1" name="dualNnameGast13" id="dualNnameGast13" value="{{ $doppelduell[2]->Nachname_S1_G }}" />
                                            </td>
                                            <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                                <input type="text" onload="VnameG(this.id)" onfocus="javascript:VnameG(this.id);$(this).autocomplete('search');" size="20" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full text-right focus:bg-green-400 transition duration-300 pr-1" name="dualVnameGast23" id="dualVnameGast23" value="{{ $doppelduell[2]->Vorname_S2_G }}" />
                                            </td>
                                            <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                                <input type="text" onload="NnameG(this.id)" onfocus="javascript:NnameG(this.id);$(this).autocomplete('search');" size="20" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 pl-1" name="dualNnameGast23" id="dualNnameGast23" value="{{ $doppelduell[2]->Nachname_S2_G }}" />
                                            </td>
                                            <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full text-right focus:bg-green-400 transition duration-300 pr-1" onchange="markInput(this); changeSetSumD(3)" name="dualSatz1heim3" id="dualSatz1heim3" value="{{ $doppelduell[2]->Satz_1_Heim }}" />
                                            </td>
                                            <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 pl-1" onchange="markInput(this); changeSetSumD(3)" name="dualSatz1gast3" id="dualSatz1gast3" value="{{ $doppelduell[2]->Satz_1_Gast }}" />
                                            </td>
                                            <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full text-right focus:bg-green-400 transition duration-300 pr-1" onchange="markInput(this); changeSetSumD(3)" name="dualSatz2heim3" id="dualSatz2heim3" value="{{ $doppelduell[2]->Satz_2_Heim }}" />
                                            </td>
                                            <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 pl-1" onchange="markInput(this); changeSetSumD(3)" name="dualSatz2gast3" id="dualSatz2gast3" value="{{ $doppelduell[2]->Satz_2_Gast }}" />
                                            </td>
                                            <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full text-right focus:bg-green-400 transition duration-300 pr-1" onchange="markInput(this); changeSetSumD(3)" name="dualSatz3heim3" id="dualSatz3heim3" value="{{ $doppelduell[2]->Satz_3_Heim }}" />
                                            </td>
                                            <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 pl-1" onchange="markInput(this); changeSetSumD(3)" name="dualSatz3gast3" id="dualSatz3gast3" value="{{ $doppelduell[2]->Satz_3_Gast }}" />
                                            </td>
                                            <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full text-right focus:bg-green-400 transition duration-300 pr-1" readonly="readonly" tabindex="-1" name="dualSetpointHeim3" id="dualSetpointHeim3" value="" />
                                            </td>
                                            <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full cursor-default pl-1" readonly="readonly" tabindex="-1" name="dualSetpointGast3" id="dualSetpointGast3" value="" />
                                            </td>
                                            <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full text-right cursor-default pr-1" readonly="readonly" tabindex="-1" name="dualWonSetHeim3" id="dualWonSetHeim3" value="" />
                                            </td>
                                            <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full cursor-default pl-1" readonly="readonly" tabindex="-1" name="dualWonSetGast3" id="dualWonSetGast3" value="" />
                                            </td>
                                            <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full text-right cursor-default pr-1" readonly="readonly" tabindex="-1" name="dualWonMatchHeim3" id="dualWonMatchHeim3" value="" />
                                            </td>
                                            <td class="bg-gray-100 h-8 text-black">
                                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full cursor-default pl-1" readonly="readonly" tabindex="-1" name="dualWonMatchGast3" id="dualWonMatchGast3" value="" />
                                            </td>
                                        </tr>
                                        @if (count($doppelduell) >= 4)
                                            <tr class="border-solid border-b-2 border-black w-44 w-auto table-row mb-0" id="doppel4">
                                                <input type="hidden" id="doppelDuellID4" name="doppelDuellID4" value="{{ $doppelduell[3]->Duell_ID }}">
                                                <td class="bg-gray-100 h-8 text-black border-solid border-b-2 border-r-2 border-black">
                                                    <input type="text" list="arten" size="4" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300" name="dualType4" id="dualType4" value="{{ $doppelduell[3]->Duellart }}" />
                                                </td>
                                                <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                                    <input type="text" onload="VnameH(this.id)" onfocus="javascript:VnameH(this.id);$(this).autocomplete('search');" size="20" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full text-right focus:bg-green-400 transition duration-300 pr-1" name="dualVnameHeim14" id="dualVnameHeim14" value="{{ $doppelduell[3]->Vorname_S1_H }}" />
                                                </td>
                                                <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                                    <input type="text" onload="NnameH(this.id)" onfocus="javascript:NnameH(this.id);$(this).autocomplete('search');" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 pl-1" name="dualNnameHeim14" id="dualNnameHeim14" value="{{ $doppelduell[3]->Nachname_S1_H }}" />
                                                </td>
                                                <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                                    <input type="text" onload="VnameH(this.id)" onfocus="javascript:VnameH(this.id);$(this).autocomplete('search');" size="20" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full text-right focus:bg-green-400 transition duration-300 pr-1" name="dualVnameHeim24" id="dualVnameHeim24" value="{{ $doppelduell[3]->Vorname_S2_H }}" />
                                                </td>
                                                <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                                    <input type="text" onload="NnameH(this.id)" onfocus="javascript:NnameH(this.id);$(this).autocomplete('search');" size="20" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 pl-1" name="dualNnameHeim24" id="dualNnameHeim24" value="{{ $doppelduell[3]->Nachname_S2_H }}" />
                                                </td>
                                                <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                                    <input type="text" onload="VnameG(this.id)" onfocus="javascript:VnameG(this.id);$(this).autocomplete('search');" size="20" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full text-right focus:bg-green-400 transition duration-300 pr-1" name="dualVnameGast14" id="dualVnameGast14" value="{{ $doppelduell[3]->Vorname_S1_G }}" />
                                                </td>
                                                <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                                    <input type="text" onload="NnameG(this.id)" onfocus="javascript:NnameG(this.id);$(this).autocomplete('search');" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 pl-1" name="dualNnameGast14" id="dualNnameGast14" value="{{ $doppelduell[3]->Nachname_S1_G }}" />
                                                </td>
                                                <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                                    <input type="text" onload="VnameG(this.id)" onfocus="javascript:VnameG(this.id);$(this).autocomplete('search');" size="20" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full text-right focus:bg-green-400 transition duration-300 pr-1" name="dualVnameGast24" id="dualVnameGast24" value="{{ $doppelduell[3]->Vorname_S2_G }}" />
                                                </td>
                                                <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                                    <input type="text" onload="NnameG(this.id)" onfocus="javascript:NnameG(this.id);$(this).autocomplete('search');" size="20" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 pl-1" name="dualNnameGast24" id="dualNnameGast24" value="{{ $doppelduell[3]->Nachname_S2_G }}" />
                                                </td>
                                                <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full text-right focus:bg-green-400 transition duration-300 pr-1" onchange="markInput(this); changeSetSumD(4)" name="dualSatz1heim4" id="dualSatz1heim4" value="{{ $doppelduell[3]->Satz_1_Heim }}" />
                                                </td>
                                                <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 pl-1" onchange="markInput(this); changeSetSumD(4)" name="dualSatz1gast4" id="dualSatz1gast4" value="{{ $doppelduell[3]->Satz_1_Gast }}" />
                                                </td>
                                                <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full text-right focus:bg-green-400 transition duration-300 pr-1" onchange="markInput(this); changeSetSumD(4)" name="dualSatz2heim4" id="dualSatz2heim4" value="{{ $doppelduell[3]->Satz_2_Heim }}" />
                                                </td>
                                                <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 pl-1" onchange="markInput(this); changeSetSumD(4)" name="dualSatz2gast4" id="dualSatz2gast4" value="{{ $doppelduell[3]->Satz_2_Gast }}" />
                                                </td>
                                                <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full text-right focus:bg-green-400 transition duration-300 pr-1" onchange="markInput(this); changeSetSumD(4)" name="dualSatz3heim4" id="dualSatz3heim4" value="{{ $doppelduell[3]->Satz_3_Heim }}" />
                                                </td>
                                                <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 pl-1" onchange="markInput(this); changeSetSumD(4)" name="dualSatz3gast4" id="dualSatz3gast4" value="{{ $doppelduell[3]->Satz_3_Gast }}" />
                                                </td>
                                                <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full text-right cursor-default pr-1" readonly="readonly" tabindex="-1" name="dualSetpointHeim4" id="dualSetpointHeim4" value="" />
                                                </td>
                                                <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full cursor-default pl-1" readonly="readonly" tabindex="-1" name="dualSetpointGast4" id="dualSetpointGast4" value="" />
                                                </td>
                                                <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full text-right cursor-default pr-1" readonly="readonly" tabindex="-1" name="dualWonSetHeim4" id="dualWonSetHeim4" value="" />
                                                </td>
                                                <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full cursor-default pl-1" readonly="readonly" tabindex="-1" name="dualWonSetGast4" id="dualWonSetGast4" value="" />
                                                </td>
                                                <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full text-right cursor-default pr-1" readonly="readonly" tabindex="-1" name="dualWonMatchHeim4" id="dualWonMatchHeim4" value="" />
                                                </td>
                                                <td class="bg-gray-100 h-8 text-black">
                                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full cursor-default pl-1" readonly="readonly" tabindex="-1" name="dualWonMatchGast4" id="dualWonMatchGast4" value="" />
                                                </td>
                                            </tr>
                                        @endif
                                    @endif
                                @endif
                            @endif
                            <tr class="border-solid border-black w-44 w-auto table-row mb-0">
                                <td colspan="15" class="invisible border-solid border-r-2 border-black">
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full text-right cursor-default pr-1" readonly="readonly" tabindex="-1" name="sumSetHomeDual" id="sumSetHomeDual" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full cursor-default pl-1" readonly="readonly" tabindex="-1" name="sumSetGuestDual" id="sumSetGuestDual" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full text-right cursor-default pr-1" readonly="readonly" tabindex="-1" name="sumWonSetHomeDual" id="sumWonSetHomeDual" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full cursor-default pl-1" readonly="readonly" tabindex="-1" name="sumWonSetGuestDual" id="sumWonSetGuestDual" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full text-right cursor-default pr-1" readonly="readonly" tabindex="-1" name="sumWonMatchHomeDual" id="sumWonMatchHomeDual" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full cursor-default pl-1" readonly="readonly" tabindex="-1" name="sumWonMatchGuestDual" id="sumWonMatchGuestDual" />
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
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
                        <tr class="bg-green-400 flex flex-col table-row rounded-none mb-0">
                            <th class="h-auto  w-4 border-solid border-r-2 align-middle text-center">Art</th>
                            <th class="border-solid border-r-2 align-middle text-center" colspan="2">Spieler: Heim</th>
                            <th class="border-solid border-r-2 align-middle text-center" rowspan="2" colspan="2">Spieler: Gast</th>
                            <th class="border-solid border-r-2 align-middle text-center" rowspan="6" colspan="6">Satzergebnisse</th>
                            <th class="border-solid border-r-2 align-middle text-center" rowspan="2" colspan="2">Summe: Spielpunkte</th>
                            <th class="border-solid border-r-2 align-middle text-center" rowspan="2" colspan="2">Summe: Sätze</th>
                            <th class="border-solid align-middle text-center" rowspan="2" colspan="2">Punkte</th>
                        </tr>
                    </thead>
                    <thead>
                        <tr class="flex flex-col flex-no wrap table-row rounded-none mb-0">
                            <th class="border-solid h-8 h-auto border-t-2 border-white border-r-2 text-center">Art</th>
                            <th class="text-center h-8 h-auto">Vorname</th>
                            <th class="border-solid h-8 h-auto border-r-2 text-center">Nachname</th>
                            <th class="text-center h-8 h-auto">Vorname</th>
                            <th class="border-solid h-8 h-auto border-r-2 text-center">Nachname</th>
                            <th class="w-4 h-auto text-center" colspan="2">1. Satz</th>
                            <th class="w-4 h-auto text-center" colspan="2">2. Satz</th>
                            <th class="w-4 h-auto text-center border-solid border-r-2" colspan="2">3. Satz</th>
                            <th class="w-4 h-auto text-center">Heim</th>
                            <th class="w-4 h-auto text-center border-solid border-r-2">Gast</th>
                            <th class="w-4 h-auto text-center">Heim</th>
                            <th class="w-4 h-auto text-center border-solid border-r-2">Gast</th>
                            <th class="w-4 h-auto text-center">Heim</th>
                            <th class="w-4 h-auto text-center">Gast</th>
                        </tr>
                    </thead>
                    <tbody class="flex-1 flex-none" id="tabSoloBody">
                        @if (count($soloduell) >= 1)
                            <tr class="border-solid border-b-2 border-black w-44 w-auto flex flex-col flex-no wrap table-row mb-0" id="solo1">
                                <input type="hidden" id="duellID1" name="duellID1" value="{{ $soloduell[0]->Duell_ID }}">
                                <td class="bg-gray-100 h-8 text-black border-solid border-b-2 border-r-2 border-black">
                                    <input type="text" list="arten" size="4" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300" name="soloType1" id="soloType1" value="{{ $soloduell[0]->Duellart }}" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                    <input type="text" onload="VnameH(this.id)" onfocus="VnameH(this.id);javascript:$(this).autocomplete('search');" size="20" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full text-right focus:bg-green-400 transition duration-300 pr-1" name="soloVnameHeim1" id="soloVnameHeim1" value="{{ $soloduell[0]->Vorname_S1 }}" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                    <input type="text" onload="NnameH(this.id)" onfocus="NnameH(this.id);javascript:$(this).autocomplete('search');" size="20" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 pl-1" name="soloNnameHeim1" id="soloNnameHeim1" value="{{ $soloduell[0]->Nachname_S1 }}" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                    <input type="text" onload="VnameG(this.id)" onfocus="javascript:VnameG(this.id);$(this).autocomplete('search');" size="20" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full text-right focus:bg-green-400 transition duration-300 pr-1" name="soloVnameGast1" id="soloVnameGast1" value="{{ $soloduell[0]->Vorname_S2 }}" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                    <input type="text" onload="NnameG(this.id)" onfocus="javascript:NnameG(this.id);$(this).autocomplete('search');" size="20" onChange="markInput(this)" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 pl-1" name="soloNnameGast1" id="soloNnameGast1" value="{{ $soloduell[0]->Nachname_S2 }}" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full text-right focus:bg-green-400 transition duration-300 pr-1" onchange="markInput(this); changeSetSumS(1)" name="soloSatz1heim1" id="soloSatz1heim1" value="{{ $soloduell[0]->Satz_1_Heim }}" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 pl-1" onchange="markInput(this); changeSetSumS(1)" name="soloSatz1gast1" id="soloSatz1gast1" value="{{ $soloduell[0]->Satz_1_Gast }}" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full text-right focus:bg-green-400 transition duration-300 pr-1" onchange="markInput(this); changeSetSumS(1)" name="soloSatz2heim1" id="soloSatz2heim1" value="{{ $soloduell[0]->Satz_2_Heim }}" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 pl-1" onchange="markInput(this); changeSetSumS(1)" name="soloSatz2gast1" id="soloSatz2gast1" value="{{ $soloduell[0]->Satz_2_Gast }}" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full text-right focus:bg-green-400 transition duration-300 pr-1" onchange="markInput(this); changeSetSumS(1)" name="soloSatz3heim1" id="soloSatz3heim1" value="{{ $soloduell[0]->Satz_3_Heim }}" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 pl-1" onchange="markInput(this); changeSetSumS(1)" name="soloSatz3gast1" id="soloSatz3gast1" value="{{ $soloduell[0]->Satz_3_Gast }}" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full text-right cursor-default pr-1" readonly="readonly" tabindex="-1" name="soloSetpointHeim1" id="soloSetpointHeim1" value="" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full cursor-default pl-1" readonly="readonly" tabindex="-1" name="soloSetpointGast1" id="soloSetpointGast1" value="" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full text-right cursor-default pr-1" readonly="readonly" tabindex="-1" name="soloWonSetHeim1" id="soloWonSetHeim1" value="" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full cursor-default pl-1" readonly="readonly" tabindex="-1" name="soloWonSetGast1" id="soloWonSetGast1" value="" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full text-right cursor-default pr-1" readonly="readonly" tabindex="-1" name="soloWonMatchHeim1" id="soloWonMatchHeim1" value="" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full cursor-default pl-1" readonly="readonly" tabindex="-1" name="soloWonMatchGast1" id="soloWonMatchGast1" value="" />
                                </td>
                            </tr>
                            @if (count($soloduell) >= 2)
                                <tr class="border-solid border-b-2 border-black w-44 w-auto flex flex-col flex-no wrap table-row mb-0" id="solo2">
                                    <input type="hidden" id="duellID2" name="duellID2" value="{{ $soloduell[1]->Duell_ID }}">
                                    <td class="bg-gray-100 h-8 text-black border-solid border-b-2 border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300" onChange="markInput(this)" name="soloType2" id="soloType2" value="{{ $soloduell[1]->Duellart }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                        <input type="text" onload="VnameH(this.id)" onfocus="javascript:VnameH(this.id);$(this).autocomplete('search');" size="20" size="20" class="bg-gray-100 text-black w-full h-full text-right focus:bg-green-400 transition duration-300 pr-1" onChange="markInput(this)" name="soloVnameHeim2" id="soloVnameHeim2" value="{{ $soloduell[1]->Vorname_S1 }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                        <input type="text" onload="NnameH(this.id)" onfocus="javascript:NnameH(this.id);$(this).autocomplete('search');" size="20" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 pl-1" onChange="markInput(this)" name="soloNnameHeim2" id="soloNnameHeim2" value="{{ $soloduell[1]->Nachname_S1 }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                        <input type="text" onload="VnameG(this.id)" onfocus="javascript:VnameG(this.id);$(this).autocomplete('search');" size="20" class="bg-gray-100 text-black w-full h-full text-right  focus:bg-green-400 transition duration-300 pr-1" onChange="markInput(this)" name="soloVnameGast2" id="soloVnameGast2" value="{{ $soloduell[1]->Vorname_S2 }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                        <input type="text" onload="NnameG(this.id)" onfocus="javascript:NnameG(this.id);$(this).autocomplete('search');" size="20" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 pl-1" onChange="markInput(this)" name="soloNnameGast2" id="soloNnameGast2" value="{{ $soloduell[1]->Nachname_S2 }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 text-right  text-black w-full h-full focus:bg-green-400 transition duration-300 pr-1" onchange="markInput(this); changeSetSumS(2)" name="soloSatz1heim2" id="soloSatz1heim2" value="{{ $soloduell[1]->Satz_1_Heim }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 pl-1" onchange="markInput(this); changeSetSumS(2)" name="soloSatz1gast2" id="soloSatz1gast2" value="{{ $soloduell[1]->Satz_1_Gast }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 text-right text-black w-full h-full focus:bg-green-400 transition duration-300 pr-1" onchange="markInput(this); changeSetSumS(2)" name="soloSatz2heim2" id="soloSatz2heim2" value="{{ $soloduell[1]->Satz_2_Heim }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 pl-1" onchange="markInput(this); changeSetSumS(2)" name="soloSatz2gast2" id="soloSatz2gast2" value="{{ $soloduell[1]->Satz_2_Gast }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 text-right text-black w-full h-full focus:bg-green-400 transition duration-300 pr-1" onchange="markInput(this); changeSetSumS(2)" name="soloSatz3heim2" id="soloSatz3heim2" value="{{ $soloduell[1]->Satz_3_Heim }}" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 pl-1" onchange="markInput(this); changeSetSumS(2)" name="soloSatz3gast2" id="soloSatz3gast2" value="{{ $soloduell[1]->Satz_3_Gast }}" />
                                    </td>
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 text-right text-black w-full h-full cursor-default pr-1" readonly="readonly" tabindex="-1" name="soloSetpointHeim2" id="soloSetpointHeim2" value="" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 text-black w-full h-full cursor-default pl-1" readonly="readonly" tabindex="-1" name="soloSetpointGast2" id="soloSetpointGast2" value="" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 text-right text-black w-full h-full cursor-default pr-1" name="soloWonSetHeim2" readonly="readonly" tabindex="-1" id="soloWonSetHeim2" value="" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 text-black w-full h-full cursor-default pl-1" readonly="readonly" tabindex="-1" name="soloWonSetGast2" id="soloWonSetGast2" value="" />
                                    <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 text-right text-black w-full h-full cursor-default pr-1" name="soloWonMatchHeim2" readonly="readonly" tabindex="-1" id="soloWonMatchHeim2" value="" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black">
                                        <input type="text" size="4" class="bg-gray-100 text-black w-full h-full cursor-default pl-1" readonly="readonly" tabindex="-1" name="soloWonMatchGast2" id="soloWonMatchGast2" value="" />
                                    </td>
                                </tr>
                            @endif
                        @endif
                        <tr class="border-solid border-black w-44 w-auto flex flex-col flex-no wrap table-row mb-0">
                            <td colspan="11" class="invisible border-solid border-r-2 border-black">
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full text-right cursor-default pr-1" readonly="readonly" tabindex="-1" name="sumSetHomeDual" id="sumSetHomeSolo" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full cursor-default pl-1" readonly="readonly" tabindex="-1" name="sumSetGuestDual" id="sumSetGuestSolo" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full text-right cursor-default pr-1" readonly="readonly" tabindex="-1" name="sumWonSetHomeDual" id="sumWonSetHomeSolo" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full cursor-default pl-1" readonly="readonly" tabindex="-1" name="sumWonSetGuestDual" id="sumWonSetGuestSolo" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full text-right cursor-default pr-1" readonly="readonly" tabindex="-1" name="sumWonMatchHomeDual" id="sumWonMatchHomeSolo" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full cursor-default pl-1" readonly="readonly" tabindex="-1" name="sumWonMatchGuestDual" id="sumWonMatchGuestSolo" />
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="mt-3 flex place-content-end">
                    <table>
                        <thead>
                            <tr class="bg-green-400 flex flex-col table-row rounded-none mb-0">
                                <th class="border-solid border-r-2 align-middle text-center p-2" rowspan="2" colspan="2">Spielpunkte Gesamt</th>
                                <th class="border-solid border-r-2 align-middle text-center" rowspan="2" colspan="2">Sätze Gesamt</th>
                                <th class="border-solid align-middle text-center" rowspan="2" colspan="2">Punkte Gesamt</th>
                            </tr>
                        </thead>
                        <thead>
                            <tr class="flex flex-col table-row rounded-none mb-0">
                                <th class="border-solid border-r-2 align-middle text-center">Heim</th>
                                <th class="border-solid border-r-2 align-middle text-center">Gast</th>
                                <th class="border-solid border-r-2 align-middle text-center">Heim</th>
                                <th class="border-solid border-r-2 align-middle text-center">Gast</th>
                                <th class="border-solid border-r-2 align-middle text-center">Heim</th>
                                <th class="border-solid align-middle text-center">Gast</th>
                            </tr>
                        </thead>
                        <tbody class="flex-1 flex-none" id="tabTotal">
                            <tr class="border-solid border-black w-44 w-auto flex flex-col flex-no wrap table-row mb-0">
                                <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full text-right cursor-default pr-1" readonly="readonly" tabindex="-1" name="sumSetHomeTotal" id="sumSetHomeTotal" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full cursor-default pl-1" readonly="readonly" tabindex="-1" name="sumSetGuestTotal" id="sumSetGuestTotal" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full text-right cursor-default pr-1" readonly="readonly" tabindex="-1" name="sumWonSetHomeTotal" id="sumWonSetHomeTotal" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full cursor-default pl-1" readonly="readonly" tabindex="-1" name="sumWonSetGuestTotal" id="sumWonSetGuestTotal" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full text-right cursor-default pr-1" readonly="readonly" tabindex="-1" name="sumWonMatchHomeTotal" id="sumWonMatchHomeTotal" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full cursor-default pl-1" readonly="readonly" tabindex="-1" name="sumWonMatchGuestTotal" id="sumWonMatchGuestTotal" />
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
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
                        <button class="ml-2 my-2 float-right px-3 py-3 rounded bg-green-500 active:bg-green-700 text-white text-sm opacity-70  font-bold" type="submit" id="submitBTN" name="submit" disabled>Absenden</button>
                    </div>
                </div>
            </form>
            <!--    <button class='fixed bottom-0 right-2 my-2 float-right px-3 py-3 rounded bg-green-500 active:bg-green-700 text-white text-sm opacity-70 hover:opacity-100 font-bold lg:hidden'>TAB</button>-->
        </div>
    </section>
@endsection

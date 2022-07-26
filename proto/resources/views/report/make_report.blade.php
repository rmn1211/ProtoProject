@extends('heafoo')
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
            <form class="mx-3 mb-6" method="POST" onsubmit="return validateInputs();" action="{{ url('/upload') }}">
                @csrf
                <input type="hidden" id="matchID" name="matchID">
                <input type="hidden" id="soloCount" name="soloCount">
                <input type="hidden" id="doubleCount" name="doubleCount">
                <div class="flex mb-4" style="overflow-x:auto;" id="matchRow">
                    <div class="w-1/full bg-green-400 h-16 min-w-fit">
                        <label class="block text-gray-900 text-sm font-bold pb-2 border-gray-700 border-r-2 pl-1">Region:</label>
                        <input onfocus="javascript:$(this).autocomplete('search');" oninput="regioncheck()" type="text" id="region" name="region" class="bg-gray-100 text-gray-900 h-9 w-full border-gray-700 border-r-2 border-t-2 focus:outline-none border-b-full border-gray-700 focus:bg-green-400 transition duration-500 pl-1">

                    </div>
                    <div class="w-1/full bg-green-400 h-16 min-w-fit">
                        <label class="block text-gray-900 text-sm font-bold pb-2 border-gray-700 border-r-2 pl-1">Staffel:</label>
                        <input type="text" onfocus="javascript:$(this).autocomplete('search');" oninput="check()" id="liga" name="liga" class="bg-gray-100 text-gray-900 h-9 w-full border-gray-700 border-r-2 border-t-2 focus:outline-none border-b-full border-gray-700 focus:bg-green-400 transition duration-500 pl-1">
                    </div>

                    <div class="w-1/full bg-green-400 h-16 min-w-fit">
                        <label class="block text-gray-900 text-sm font-bold pb-2 border-gray-700 border-r-2 pl-1">Saison:</label>
                        <input type="text" oninput="saisoncheck()" onfocus="javascript:$(this).autocomplete('search');" name="saison" id="saison" class="bg-gray-100 text-gray-900 border-gray-700 border-r-2 border-t-2 h-9 w-full focus:outline-none border-b-full border-gray-700 focus:bg-green-400 transition duration-500 pl-1">
                    </div>
                    <div class="w-1/full bg-green-400 h-16 min-w-fit">
                        <label class="block text-gray-900 text-sm font-bold pb-2 border-gray-700 border-r-2 pl-1">Runde:</label>
                        <input type="text" oninput="rundecheck()" onfocus="javascript:$(this).autocomplete('search');" name="runde" id="runde" class="bg-gray-100 text-gray-900 border-gray-700 border-r-2 border-t-2 h-9 w-full focus:outline-none border-b-full border-gray-700 focus:bg-green-400 transition duration-500 pl-1">
                    </div>
                    <div class="w-1/full bg-green-400 h-16 min-w-fit">
                        <label class="block text-gray-900 text-sm font-bold pb-2 border-gray-700 border-r-2 pl-1">Spieltag:</label>
                        <input type="text" oninput="tagcheck()" onfocus="javascript:$(this).autocomplete('search');" name="tag" id="tag" class="bg-gray-100 text-gray-900 border-gray-700 border-r-2 border-t-2 h-9 w-full focus:outline-none border-b-full focus:bg-green-400 transition duration-500 pl-1">
                    </div>

                    <div class="w-1/full bg-green-400 h-16 min-w-fit">
                        <label class="block text-gray-900 text-sm font-bold pb-2 border-gray-700 border-r-2 pl-1" for="home">Heimverein:</label>
                        <input onload="MannschaftenH();" onfocus="javascript:MannschaftenH();$(this).autocomplete('search');" oninput="MannschaftenH()" type="text" name=" tfHome" id="tfHome" class="bg-gray-100 text-gray-900 border-gray-700 border-r-2 border-t-2 h-9 w-full focus:outline-none border-b-full border-gray-700 focus:bg-green-400 transition duration-500 pl-1">
                    </div>
                    <div class="w-1/full bg-green-400 h-16 min-w-fit">
                        <label class="block text-gray-900 text-sm font-bold pb-2 border-gray-700 border-r-2 pl-1" for="away">Gastverein:</label>
                        <input onload="MannschaftenG();" onfocus="javascript:MannschaftenG();$(this).autocomplete('search');" type="text" oninput="MannschaftenG()" name="tfAway" id="tfAway" class="bg-gray-100 text-gray-900 border-gray-700 border-r-2 border-t-2 h-9 w-full focus:outlie-none border-b-full border-gray-700 focus:bg-green-400 transition duration-500 pl-1">
                    </div>
                    <div class="w-1/full bg-green-400 h-16 min-w-fit">
                        <label class="block text-gray-900 text-sm font-bold pb-2 border-gray-700 border-r-2 pl-1" for="away">Schiedsrichter:</label>
                        <input type="text" name="schiri" id="schiri" class="bg-gray-100 text-gray-900 border-gray-700 border-r-2 border-t-2 h-9 w-full focus:outline-none border-b-full border-gray-700 focus:bg-green-400 transition duration-500 pl-1">
                    </div>
                    <div class="w-1/full bg-green-400 h-16 min-w-fit">
                        <label class="block text-gray-900 text-sm font-bold pb-2 pl-1" for="away">Austragungsort:</label>
                        <input type="text" name="tfPlace" id="tfPlace" class="bg-gray-100 text-gray-900 h-9 w-full focus:outline-none border-b-full border-gray-700 focus:bg-green-400 transition border-t-2 duration-500 pl-1">
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
                            <tr class="border-solid border-b-2 border-black w-44 w-auto flex flex-col flex-no wrap table-row mb-0" id="doppel1">
                                <input type="hidden" id="doppelDuellID1" name="doppelDuellID1">
                                <td class="bg-gray-100 h-8 text-black border-solid border-b-2 border-r-2 border-black">
                                    <input type="text" list="arten" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300" name="dualType1" id="dualType1" value="GD" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                    <input type="text" onload="VnameH(this.id)" onfocus="javascript:VnameH(this.id);$(this).autocomplete('search');" size="20" class="bg-gray-100 text-black w-full h-full text-right focus:bg-green-400 transition duration-300 pr-1" name="dualVnameHeim11" id="dualVnameHeim11" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                    <input type="text" onload="NnameH(this.id)" onfocus="javascript:NnameH(this.id);$(this).autocomplete('search');" size="20" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 pl-1" name="dualNnameHeim11" id="dualNnameHeim11" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                    <input type="text" onload="VnameH(this.id)" onfocus="javascript:VnameH(this.id);$(this).autocomplete('search');" size="20" class="bg-gray-100 text-black w-full h-full text-right focus:bg-green-400 transition duration-300 pr-1" name="dualVnameHeim21" id="dualVnameHeim21" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                    <input type="text" onload="NnameH(this.id)" onfocus="javascript:NnameH(this.id);$(this).autocomplete('search');" size="20" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 pl-1" name="dualNnameHeim21" id="dualNnameHeim21" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                    <input type="text" onload="VnameG(this.id)" onfocus="javascript:VnameG(this.id);$(this).autocomplete('search');" size="20" class="bg-gray-100 text-black w-full h-full text-right focus:bg-green-400 transition duration-300 pr-1" name="dualVnameGast11" id="dualVnameGast11" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                    <input type="text" onload="NnameG(this.id)" onfocus="javascript:NnameG(this.id);$(this).autocomplete('search');" size="20" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 pl-1" name="dualNnameGast11" id="dualNnameGast11" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                    <input type="text" onload="VnameG(this.id)" onfocus="javascript:VnameG(this.id);$(this).autocomplete('search');" size="20" class="bg-gray-100 text-black w-full h-full text-right focus:bg-green-400 transition duration-300 pr-1" name="dualVnameGast21" id="dualVnameGast21" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                    <input type="text" onload="NnameG(this.id)" onfocus="javascript:NnameG(this.id);$(this).autocomplete('search');" size="20" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 pl-1" name="dualNnameGast21" id="dualNnameGast21" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 min-w-600 text-black w-full h-full text-right focus:bg-green-400 transition duration-300 pr-1" onchange="changeSetSumD(1)" name="dualSatz1heim1" id="dualSatz1heim1" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 pl-1" onchange="changeSetSumD(1)" name="dualSatz1gast1" id="dualSatz1gast1" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full text-right focus:bg-green-400 transition duration-300 pr-1" onchange="changeSetSumD(1)" name="dualSatz2heim1" id="dualSatz2heim1" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 pl-1" onchange="changeSetSumD(1)" name="dualSatz2gast1" id="dualSatz2gast1" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full text-right focus:bg-green-400 transition duration-300 pr-1" onchange="changeSetSumD(1)" name="dualSatz3heim1" id="dualSatz3heim1" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 pl-1" onchange="changeSetSumD(1)" name="dualSatz3gast1" id="dualSatz3gast1" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full text-right cursor-default pr-1" readonly="readonly" tabindex="-1" name="dualSetpointHeim1" id="dualSetpointHeim1" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full cursor-default pl-1" readonly="readonly" tabindex="-1" name="dualSetpointGast1" id="dualSetpointGast1" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full text-right cursor-default pr-1" readonly="readonly" tabindex="-1" name="dualWonSetHeim1" id="dualWonSetHeim1" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full cursor-default pl-1" readonly="readonly" tabindex="-1" name="dualWonSetGast1" id="dualWonSetGast1" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full text-right cursor-default pr-1" readonly="readonly" tabindex="-1" name="dualWonMatchHeim1" id="dualWonMatchHeim1" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full cursor-default pl-1" readonly="readonly" tabindex="-1" name="dualWonMatchGast1" id="dualWonMatchGast1" />
                                </td>
                            </tr>
                            <tr class="border-solid border-b-2 border-black w-44 w-auto table-row mb-0" id="doppel2">
                                <input type="hidden" id="doppelDuellID2" name="doppelDuellID2"> <!-- ??$doppelduell[0] -->
                                <td class="bg-gray-100 h-8 text-black border-solid border-b-2 border-r-2 border-black">
                                    <input type="text" list="arten" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300" name="dualType2" id="dualType2" value="GD" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                    <input type="text" onload="VnameH(this.id)" onfocus="javascript:VnameH(this.id);$(this).autocomplete('search');" size="20" class="bg-gray-100 text-black w-full h-full text-right focus:bg-green-400 transition duration-300 pr-1" name="dualVnameHeim12" id="dualVnameHeim12" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                    <input type="text" onload="NnameH(this.id)" onfocus="javascript:NnameH(this.id);$(this).autocomplete('search');" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 pl-1" name="dualNnameHeim12" id="dualNnameHeim12" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                    <input type="text" onload="VnameH(this.id)" onfocus="javascript:VnameH(this.id);$(this).autocomplete('search');" size="20" class="bg-gray-100 text-black w-full h-full text-right focus:bg-green-400 transition duration-300 pr-1" name="dualVnameHeim22" id="dualVnameHeim22" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                    <input type="text" onload="NnameH(this.id)" onfocus="javascript:NnameH(this.id);$(this).autocomplete('search');" size="20" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 pl-1" name="dualNnameHeim22" id="dualNnameHeim22" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                    <input type="text" onload="VnameG(this.id)" onfocus="javascript:VnameG(this.id);$(this).autocomplete('search');" size="20" class="bg-gray-100 text-black w-full h-full text-right focus:bg-green-400 transition duration-300 pr-1" name="dualVnameGast12" id="dualVnameGast12" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                    <input type="text" onload="NnameG(this.id)" onfocus="javascript:NnameG(this.id);$(this).autocomplete('search');" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 pl-1" name="dualNnameGast12" id="dualNnameGast12" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                    <input type="text" onload="VnameG(this.id)" onfocus="javascript:VnameG(this.id);$(this).autocomplete('search');" size="20" class="bg-gray-100 text-black w-full h-full text-right focus:bg-green-400 transition duration-300 pr-1" name="dualVnameGast22" id="dualVnameGast22" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                    <input type="text" onload="NnameG(this.id)" onfocus="javascript:NnameG(this.id);$(this).autocomplete('search');" size="20" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 pl-1" name="dualNnameGast22" id="dualNnameGast22" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full text-right focus:bg-green-400 transition duration-300 pr-1" onchange="changeSetSumD(2)" name="dualSatz1heim2" id="dualSatz1heim2" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 pl-1" onchange="changeSetSumD(2)" name="dualSatz1gast2" id="dualSatz1gast2" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full text-right focus:bg-green-400 transition duration-300 pr-1" onchange="changeSetSumD(2)" name="dualSatz2heim2" id="dualSatz2heim2" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 pl-1" onchange="changeSetSumD(2)" name="dualSatz2gast2" id="dualSatz2gast2" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full text-right focus:bg-green-400 transition duration-300 pr-1" onchange="changeSetSumD(2)" name="dualSatz3heim2" id="dualSatz3heim2" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 pl-1" onchange="changeSetSumD(2)" name="dualSatz3gast2" id="dualSatz3gast2" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full text-right cursor-default pr-1" readonly="readonly" tabindex="-1" name="dualSetpointHeim2" id="dualSetpointHeim2" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full cursor-default pl-1" readonly="readonly" tabindex="-1" name="dualSetpointGast2" id="dualSetpointGast2" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full text-right cursor-default pr-1" readonly="readonly" tabindex="-1" name="dualWonSetHeim2" id="dualWonSetHeim2" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full cursor-default pl-1" readonly="readonly" tabindex="-1" name="dualWonSetGast2" id="dualWonSetGast2" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full text-right cursor-default pr-1" readonly="readonly" tabindex="-1" name="dualWonMatchHeim2" id="dualWonMatchHeim2" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full cursor-default pl-1" readonly="readonly" tabindex="-1" name="dualWonMatchGast2" id="dualWonMatchGast2" />
                                </td>
                            </tr>
                            <tr class="border-solid border-b-2 border-black w-44 w-auto table-row mb-0" id="doppel3">
                                <input type="hidden" id="doppelDuellID3" name="doppelDuellID3">
                                <td class="bg-gray-100 h-8 text-black border-solid border-b-2 border-r-2 border-black">
                                    <input type="text" list="arten" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300" name="dualType3" id="dualType3" value="DD" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                    <input type="text" onload="VnameH(this.id)" onfocus="javascript:VnameH(this.id);$(this).autocomplete('search');" size="20" class="bg-gray-100 text-black w-full h-full text-right focus:bg-green-400 transition duration-300 pr-1" name="dualVnameHeim13" id="dualVnameHeim13" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                    <input type="text" onload="NnameH(this.id)" onfocus="javascript:NnameH(this.id);$(this).autocomplete('search');" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 pl-1" name="dualNnameHeim13" id="dualNnameHeim13" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                    <input type="text" onload="VnameH(this.id)" onfocus="javascript:VnameH(this.id);$(this).autocomplete('search');" size="20" class="bg-gray-100 text-black w-full h-full text-right focus:bg-green-400 transition duration-300 pr-1" name="dualVnameHeim23" id="dualVnameHeim23" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                    <input type="text" onload="NnameH(this.id)" onfocus="javascript:NnameH(this.id);$(this).autocomplete('search');" size="20" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 pl-1" name="dualNnameHeim23" id="dualNnameHeim23" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                    <input type="text" onload="VnameG(this.id)" onfocus="javascript:VnameG(this.id);$(this).autocomplete('search');" size="20" class="bg-gray-100 text-black w-full h-full text-right focus:bg-green-400 transition duration-300 pr-1" name="dualVnameGast13" id="dualVnameGast13" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                    <input type="text" onload="NnameG(this.id)" onfocus="javascript:NnameG(this.id);$(this).autocomplete('search');" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 pl-1" name="dualNnameGast13" id="dualNnameGast13" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                    <input type="text" onload="VnameG(this.id)" onfocus="javascript:VnameG(this.id);$(this).autocomplete('search');" size="20" class="bg-gray-100 text-black w-full h-full text-right focus:bg-green-400 transition duration-300 pr-1" name="dualVnameGast23" id="dualVnameGast23" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                    <input type="text" onload="NnameG(this.id)" onfocus="javascript:NnameG(this.id);$(this).autocomplete('search');" size="20" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 pl-1" name="dualNnameGast23" id="dualNnameGast23" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full text-right focus:bg-green-400 transition duration-300 pr-1" onchange="changeSetSumD(3)" name="dualSatz1heim3" id="dualSatz1heim3" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 pl-1" onchange="changeSetSumD(3)" name="dualSatz1gast3" id="dualSatz1gast3" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full text-right focus:bg-green-400 transition duration-300 pr-1" onchange="changeSetSumD(3)" name="dualSatz2heim3" id="dualSatz2heim3" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 pl-1" onchange="changeSetSumD(3)" name="dualSatz2gast3" id="dualSatz2gast3" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full text-right focus:bg-green-400 transition duration-300 pr-1" onchange="changeSetSumD(3)" name="dualSatz3heim3" id="dualSatz3heim3" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 pl-1" onchange="changeSetSumD(3)" name="dualSatz3gast3" id="dualSatz3gast3" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full text-right focus:bg-green-400 transition duration-300 pr-1" readonly="readonly" tabindex="-1" name="dualSetpointHeim3" id="dualSetpointHeim3" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full cursor-default pl-1" readonly="readonly" tabindex="-1" name="dualSetpointGast3" id="dualSetpointGast3" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full text-right cursor-default pr-1" readonly="readonly" tabindex="-1" name="dualWonSetHeim3" id="dualWonSetHeim3" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full cursor-default pl-1" readonly="readonly" tabindex="-1" name="dualWonSetGast3" id="dualWonSetGast3" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full text-right cursor-default pr-1" readonly="readonly" tabindex="-1" name="dualWonMatchHeim3" id="dualWonMatchHeim3" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full cursor-default pl-1" readonly="readonly" tabindex="-1" name="dualWonMatchGast3" id="dualWonMatchGast3" />
                                </td>
                            </tr>
                            <tr class="border-solid border-b-2 border-black w-44 w-auto table-row mb-0" id="doppel4">
                                <input type="hidden" id="doppelDuellID4" name="doppelDuellID4">
                                <td class="bg-gray-100 h-8 text-black border-solid border-b-2 border-r-2 border-black">
                                    <input type="text" list="arten" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300" name="dualType4" id="dualType4" value="HD" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                    <input type="text" onload="VnameH(this.id)" onfocus="javascript:VnameH(this.id);$(this).autocomplete('search');" size="20" class="bg-gray-100 text-black w-full h-full text-right focus:bg-green-400 transition duration-300 pr-1" name="dualVnameHeim14" id="dualVnameHeim14" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                    <input type="text" onload="NnameH(this.id)" onfocus="javascript:NnameH(this.id);$(this).autocomplete('search');" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 pl-1" name="dualNnameHeim14" id="dualNnameHeim14" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                    <input type="text" onload="VnameH(this.id)" onfocus="javascript:VnameH(this.id);$(this).autocomplete('search');" size="20" class="bg-gray-100 text-black w-full h-full text-right focus:bg-green-400 transition duration-300 pr-1" name="dualVnameHeim24" id="dualVnameHeim24" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                    <input type="text" onload="NnameH(this.id)" onfocus="javascript:NnameH(this.id);$(this).autocomplete('search');" size="20" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 pl-1" name="dualNnameHeim24" id="dualNnameHeim24" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                    <input type="text" onload="VnameG(this.id)" onfocus="javascript:VnameG(this.id);$(this).autocomplete('search');" size="20" class="bg-gray-100 text-black w-full h-full text-right focus:bg-green-400 transition duration-300 pr-1" name="dualVnameGast14" id="dualVnameGast14" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                    <input type="text" onload="NnameG(this.id)" onfocus="javascript:NnameG(this.id);$(this).autocomplete('search');" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 pl-1" name="dualNnameGast14" id="dualNnameGast14" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                    <input type="text" onload="VnameG(this.id)" onfocus="javascript:VnameG(this.id);$(this).autocomplete('search');" size="20" class="bg-gray-100 text-black w-full h-full text-right focus:bg-green-400 transition duration-300 pr-1" name="dualVnameGast24" id="dualVnameGast24" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                    <input type="text" onload="NnameG(this.id)" onfocus="javascript:NnameG(this.id);$(this).autocomplete('search');" size="20" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 pl-1" name="dualNnameGast24" id="dualNnameGast24" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full text-right focus:bg-green-400 transition duration-300 pr-1" onchange="changeSetSumD(4)" name="dualSatz1heim4" id="dualSatz1heim4" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 pl-1" onchange="changeSetSumD(4)" name="dualSatz1gast4" id="dualSatz1gast4" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full text-right focus:bg-green-400 transition duration-300 pr-1" onchange="changeSetSumD(4)" name="dualSatz2heim4" id="dualSatz2heim4" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 pl-1" onchange="changeSetSumD(4)" name="dualSatz2gast4" id="dualSatz2gast4" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full text-right focus:bg-green-400 transition duration-300 pr-1" onchange="changeSetSumD(4)" name="dualSatz3heim4" id="dualSatz3heim4" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 pl-1" onchange="changeSetSumD(4)" name="dualSatz3gast4" id="dualSatz3gast4" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full text-right cursor-default pr-1" readonly="readonly" tabindex="-1" name="dualSetpointHeim4" id="dualSetpointHeim4" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full cursor-default pl-1" readonly="readonly" tabindex="-1" name="dualSetpointGast4" id="dualSetpointGast4" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full text-right cursor-default pr-1" readonly="readonly" tabindex="-1" name="dualWonSetHeim4" id="dualWonSetHeim4" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full cursor-default pl-1" readonly="readonly" tabindex="-1" name="dualWonSetGast4" id="dualWonSetGast4" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full text-right cursor-default pr-1" readonly="readonly" tabindex="-1" name="dualWonMatchHeim4" id="dualWonMatchHeim4" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full cursor-default pl-1" readonly="readonly" tabindex="-1" name="dualWonMatchGast4" id="dualWonMatchGast4" />
                                </td>
                            </tr>
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

                <input type="hidden" name="regionID" id="regionID">
                <input type="hidden" name="ligaID" id="ligaID">
                <input type="hidden" name="HeimID" id="HeimID">
                <input type="hidden" name="GastID" id="GastID">
                <input type="hidden" name="saisonID" id="saisonID">
                <input type="hidden" name="rundeID" id="rundeID">
                <input type="hidden" name="tagID" id="tagID">
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
                        <tr class="border-solid border-b-2 border-black w-44 w-auto flex flex-col flex-no wrap table-row mb-0" id="solo1">
                            <input type="hidden" id="duellID1" name="duellID1">
                            <td class="bg-gray-100 h-8 text-black border-solid border-b-2 border-r-2 border-black">
                                <input type="text" list="arten" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300" name="soloType1" id="soloType1" value="HE" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                <input type="text" onload="VnameH(this.id)" onfocus="VnameH(this.id);javascript:$(this).autocomplete('search');" size="20" class="bg-gray-100 text-black w-full h-full text-right focus:bg-green-400 transition duration-300 pr-1" name="soloVnameHeim1" id="soloVnameHeim1" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                <input type="text" onload="NnameH(this.id)" onfocus="NnameH(this.id);javascript:$(this).autocomplete('search');" size="20" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 pl-1" name="soloNnameHeim1" id="soloNnameHeim1" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                <input type="text" onload="VnameG(this.id)" onfocus="javascript:VnameG(this.id);$(this).autocomplete('search');" size="20" class="bg-gray-100 text-black w-full h-full text-right focus:bg-green-400 transition duration-300 pr-1" name="soloVnameGast1" id="soloVnameGast1" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                <input type="text" onload="NnameG(this.id)" onfocus="javascript:NnameG(this.id);$(this).autocomplete('search');" size="20" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 pl-1" name="soloNnameGast1" id="soloNnameGast1" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full text-right focus:bg-green-400 transition duration-300 pr-1" onchange="changeSetSumS(1)" name="soloSatz1heim1" id="soloSatz1heim1" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 pl-1" onchange="changeSetSumS(1)" name="soloSatz1gast1" id="soloSatz1gast1" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full text-right focus:bg-green-400 transition duration-300 pr-1" onchange="changeSetSumS(1)" name="soloSatz2heim1" id="soloSatz2heim1" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 pl-1" onchange="changeSetSumS(1)" name="soloSatz2gast1" id="soloSatz2gast1" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full text-right focus:bg-green-400 transition duration-300 pr-1" onchange="changeSetSumS(1)" name="soloSatz3heim1" id="soloSatz3heim1" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 pl-1" onchange="changeSetSumS(1)" name="soloSatz3gast1" id="soloSatz3gast1" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full text-right cursor-default pr-1" readonly="readonly" tabindex="-1" name="soloSetpointHeim1" id="soloSetpointHeim1" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full cursor-default pl-1" readonly="readonly" tabindex="-1" name="soloSetpointGast1" id="soloSetpointGast1" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full text-right cursor-default pr-1" readonly="readonly" tabindex="-1" name="soloWonSetHeim1" id="soloWonSetHeim1" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full cursor-default pl-1" readonly="readonly" tabindex="-1" name="soloWonSetGast1" id="soloWonSetGast1" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full text-right cursor-default pr-1" readonly="readonly" tabindex="-1" name="soloWonMatchHeim1" id="soloWonMatchHeim1" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full cursor-default pl-1" readonly="readonly" tabindex="-1" name="soloWonMatchGast1" id="soloWonMatchGast1" />
                            </td>
                        </tr>
                        <tr class="border-solid border-b-2 border-black w-44 w-auto flex flex-col flex-no wrap table-row mb-0" id="solo2">
                            <input type="hidden" id="duellID2" name="duellID2">
                            <td class="bg-gray-100 h-8 text-black border-solid border-b-2 border-r-2 border-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300" name="soloType2" id="soloType2" value="HE" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                <input type="text" onload="VnameH(this.id)" onfocus="javascript:VnameH(this.id);$(this).autocomplete('search');" size="20" size="20" class="bg-gray-100 text-black w-full h-full text-right focus:bg-green-400 transition duration-300 pr-1" name="soloVnameHeim2" id="soloVnameHeim2" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                <input type="text" onload="NnameH(this.id)" onfocus="javascript:NnameH(this.id);$(this).autocomplete('search');" size="20" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 pl-1" name="soloNnameHeim2" id="soloNnameHeim2" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                <input type="text" onload="VnameG(this.id)" onfocus="javascript:VnameG(this.id);$(this).autocomplete('search');" size="20" class="bg-gray-100 text-black w-full h-full text-right  focus:bg-green-400 transition duration-300 pr-1" name="soloVnameGast2" id="soloVnameGast2" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                <input type="text" onload="NnameG(this.id)" onfocus="javascript:NnameG(this.id);$(this).autocomplete('search');" size="20" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 pl-1" name="soloNnameGast2" id="soloNnameGast2" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                <input type="text" size="4" class="bg-gray-100 text-right  text-black w-full h-full focus:bg-green-400 transition duration-300 pr-1" onchange="changeSetSumS(2)" name="soloSatz1heim2" id="soloSatz1heim2" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 pl-1" onchange="changeSetSumS(2)" name="soloSatz1gast2" id="soloSatz1gast2" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                <input type="text" size="4" class="bg-gray-100 text-right text-black w-full h-full focus:bg-green-400 transition duration-300 pr-1" onchange="changeSetSumS(2)" name="soloSatz2heim2" id="soloSatz2heim2" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 pl-1" onchange="changeSetSumS(2)" name="soloSatz2gast2" id="soloSatz2gast2" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                <input type="text" size="4" class="bg-gray-100 text-right text-black w-full h-full focus:bg-green-400 transition duration-300 pr-1" onchange="changeSetSumS(2)" name="soloSatz3heim2" id="soloSatz3heim2" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 pl-1" onchange="changeSetSumS(2)" name="soloSatz3gast2" id="soloSatz3gast2" />
                            </td>
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                <input type="text" size="4" class="bg-gray-100 text-right text-black w-full h-full cursor-default pr-1" readonly="readonly" tabindex="-1" name="soloSetpointHeim2" id="soloSetpointHeim2" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full cursor-default pl-1" readonly="readonly" tabindex="-1" name="soloSetpointGast2" id="soloSetpointGast2" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                <input type="text" size="4" class="bg-gray-100 text-right text-black w-full h-full cursor-default pr-1" name="soloWonSetHeim2" readonly="readonly" tabindex="-1" id="soloWonSetHeim2" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-solid border-r-2 border-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full cursor-default pl-1" readonly="readonly" tabindex="-1" name="soloWonSetGast2" id="soloWonSetGast2" />
                            <td class="bg-gray-100 h-8 text-black border-dashed border-r-2 border-black">
                                <input type="text" size="4" class="bg-gray-100 text-right text-black w-full h-full cursor-default pr-1" name="soloWonMatchHeim2" readonly="readonly" tabindex="-1" id="soloWonMatchHeim2" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full cursor-default pl-1" readonly="readonly" tabindex="-1" name="soloWonMatchGast2" id="soloWonMatchGast2" />
                            </td>
                        </tr>
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
                        <button class="my-2 float-right px-3 py-3 rounded bg-green-500 active:bg-green-700 text-white text-sm font-bold" type="submit" id="submitBTN" name="submit">Absenden</button>
                    </div>
                </div>
            </form>

        </div>
    </section>
@endsection

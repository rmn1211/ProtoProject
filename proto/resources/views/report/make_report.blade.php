@extends('heafoo')
@section('page-content')

    <head>

        <!-- Meta -->
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
         <meta name="viewport" content="width=device-width, initial-scale=1.0"> 

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
            <form class="flex flex-col mx-3 mb-6" method="POST" onsubmit="return validateInputsUpload();" action="{{ url('/upload') }}">
                @csrf
                <input type="hidden" id="matchID" name="matchID" >
                <input type="hidden" id="soloCount" name="soloCount" >
                <input type="hidden" id="doubleCount" name="doubleCount" >
                <div class="flex mb-4">
                    <div class="w-1/full bg-green-400 h-12">
                        <label class="block text-gray-900 text-sm font-bold mb-2 ml-3">Region:</label>
                        <input onfocus="javascript:$(this).autocomplete('search');" oninput="regioncheck()" type="text" id="region" name="region"  class="bg-gray-100 text-gray-900  border-gray-700 border-r-2 w-full focus:outline-none border-b-full border-gray-700 focus:border-green-500 transition duration-500 px-3 pb-3" >

                    </div>

                    <div class="w-1/full bg-green-400 h-12">


                        <label class="block text-gray-900 text-sm font-bold mb-2 ml-3">Staffel:</label>
                        <input type="text" onfocus="javascript:$(this).autocomplete('search');"oninput="check()" id="liga"  name="liga" class="bg-gray-100   border-gray-700 border-r-2 text-gray-900 w-full focus:outline-none border-b-full border-gray-700 focus:border-green-500 transition duration-500 px-3 pb-3">
                    </div>

                     <div class="w-1/full bg-green-400 h-12">
                        <label class="block text-gray-900 text-sm font-bold mb-2 ml-3" >Saison:</label>
                        <input  type="text"  oninput="saisoncheck()"onfocus="javascript:$(this).autocomplete('search');" name=" saison" id="saison" class="bg-gray-100 text-gray-900  border-gray-700 border-r-2  w-full focus:outline-none border-b-full border-gray-700 focus:border-green-500 transition duration-500 px-3 pb-3" >
                    </div>
                      <div class="w-1/full bg-green-400 h-12">
                        <label class="block text-gray-900 text-sm font-bold mb-2 ml-3" >Runde:</label>
                        <input  type="text" oninput="rundecheck()" onfocus="javascript:$(this).autocomplete('search');" name=" runde" id="runde" class="bg-gray-100 text-gray-900  border-gray-700 border-r-2  w-full focus:outline-none border-b-full border-gray-700 focus:border-green-500 transition duration-500 px-3 pb-3" >
                    </div>
                      <div class="w-1/full bg-green-400 h-12">
                        <label class="block text-gray-900 text-sm font-bold mb-2 ml-3" >Spieltag:</label>
                        <input  type="text" oninput="tagcheck()" onfocus="javascript:$(this).autocomplete('search');" name=" tag" id="tag" class="bg-gray-100 text-gray-900    w-full focus:outline-none border-b-full border-gray-700 border-r-2 focus:border-green-500 transition duration-500 px-3 pb-3" >
                    </div>

                    <div class="w-1/full bg-green-400 h-12">
                        <label class="block text-gray-900 text-sm font-bold mb-2 ml-3" for="home">Heimverein:</label>
                        <input onload="MannschaftenH();" onfocus="javascript:MannschaftenH();$(this).autocomplete('search');" oninput="MannschaftenH()" type="text"  name=" tfHome" id="tfHome" class="bg-gray-100 text-gray-900  w-full focus:outline-none border-b-full border-gray-700 border-r-2  focus:border-green-500 transition duration-500 px-3 pb-3" >
                    </div>
                    <div class="w-1/full bg-green-400 h-12">
                        <label class="block text-gray-900 text-sm font-bold mb-2 ml-3" for="away">Gastverein:</label>
                        <input onload="MannschaftenG();" onfocus="javascript:MannschaftenG();$(this).autocomplete('search');" type="text" oninput="MannschaftenG()"  name="tfAway" id="tfAway" class="bg-gray-100 text-gray-900  w-full focus:outlie-none border-b-full border-gray-700  border-r-2 focus:border-green-500 transition duration-500 px-3 pb-3" >
                    </div>
                    <div class="w-1/full bg-green-400 h-12">
                        <label class="block text-gray-900 text-sm font-bold mb-2 ml-3" for="away">Schiedsrichter:</label>
                        <input type="text" name="schiri" id="schiri" class="bg-gray-100 text-gray-900  w-full  border-gray-700 border-r-2 focus:outline-none border-b-full border-gray-700 focus:border-green-500 transition duration-500 px-3 pb-3" >
                    </div>
                    <div class="w-1/full bg-green-400 h-12">
                        <label class="block text-gray-900 text-sm font-bold mb-2 ml-3" for="away">Austragungsort:</label>
                        <input type="text" name="tfPlace" id="tfPlace"  class="bg-gray-100 text-gray-900  w-full focus:outline-none border-b-full border-gray-700 focus:border-green-500 transition duration-500 px-3 pb-3" >
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
                       
                    </thead>
                    <tbody class="flex-1 sm:flex-none">
                      
                            <tr class="border-solid border-b-2 border-black w-44 sm:w-auto flex flex-col flex-no wrap sm:table-row mb-2 sm:mb-0">
                                <input type="hidden" id="doppelDuellID1" name="doppelDuellID1" >
                                <td class="bg-gray-100 h-8 text-black border-solid border-b-2 sm:border-r-2 border-black">
                                    <input type="text" list="arten" size="4"  class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300" name="dualType1" id="dualType1"  />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                    <input type="text" onload="VnameH(this.id)" oninput="VnameH(this.id)" onfocus="javascript:VnameH(this.id);$(this).autocomplete('search');" size="20" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 sm:p-1.5" name="dualVnameHeim11" id="dualVnameHeim11"  />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                    <input type="text" onload="NnameH(this.id)" oninput="NnameH(this.id)" onfocus="javascript:NnameH(this.id);$(this).autocomplete('search');" size="20"  class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" name="dualNnameHeim11" id="dualNnameHeim11"  />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                    <input type="text"onload="VnameH(this.id)" oninput="VnameH(this.id)" onfocus="javascript:VnameH(this.id);$(this).autocomplete('search');" size="20"  class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5" name="dualVnameHeim21" id="dualVnameHeim21"  />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                    <input type="text" onload="NnameH(this.id)" oninput="NnameH(this.id)" onfocus="javascript:NnameH(this.id);$(this).autocomplete('search');" size="20" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" name="dualNnameHeim21" id="dualNnameHeim21"  />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                    <input type="text" onload="VnameG(this.id)" oninput="VnameG(this.id)" onfocus="javascript:VnameG(this.id);$(this).autocomplete('search');" size="20" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 sm:p-1.5" name="dualVnameGast11" id="dualVnameGast11"  />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                    <input type="text"onload="NnameG(this.id)" oninput="NnameG(this.id)" onfocus="javascript:NnameG(this.id);$(this).autocomplete('search');" size="20" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" name="dualNnameGast11" id="dualNnameGast11"  />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                    <input type="text" onload="VnameG(this.id)" oninput="VnameG(this.id)" onfocus="javascript:VnameG(this.id);$(this).autocomplete('search');" size="20" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5" name="dualVnameGast21" id="dualVnameGast21" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                    <input type="text" onload="NnameG(this.id)" oninput="NnameG(this.id)" onfocus="javascript:NnameG(this.id);$(this).autocomplete('search');" size="20"  class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" name="dualNnameGast21" id="dualNnameGast21"  />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5" onchange=" changeSetSumD(1)" name="dualSatz1heim1" id="dualSatz1heim1" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" onchange=" changeSetSumD(1)" name="dualSatz1gast1" id="dualSatz1gast1" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5" onchange="changeSetSumD(1)" name="dualSatz2heim1" id="dualSatz2heim1" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" onchange=" changeSetSumD(1)" name="dualSatz2gast1" id="dualSatz2gast1"  />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5" onchange=" changeSetSumD(1)" name="dualSatz3heim1" id="dualSatz3heim1"  />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" onchange=" changeSetSumD(1)" name="dualSatz3gast1" id="dualSatz3gast1"  />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5" readonly="readonly" tabindex="-1" name="dualSetpointHeim1" id="dualSetpointHeim1"  />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" readonly="readonly" tabindex="-1" name="dualSetpointGast1" id="dualSetpointGast1" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5" readonly="readonly" tabindex="-1" name="dualWonSetHeim1" id="dualWonSetHeim1" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" readonly="readonly" tabindex="-1" name="dualWonSetGast1" id="dualWonSetGast1"  />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:sm:text-right focus:bg-green-400 transition duration-300 p-1.5" readonly="readonly" tabindex="-1" name="dualWonMatchHeim1" id="dualWonMatchHeim1" />
                                </td>
                                <td class="bg-gray-100 h-8 text-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" readonly="readonly" tabindex="-1" name="dualWonMatchGast1" id="dualWonMatchGast1"  />
                                </td>
                            </tr>
                          
                                <tr class="border-solid border-b-2 border-black w-44 sm:w-auto flex flex-col flex-no wrap sm:table-row mb-2 sm:mb-0">
                                    <input type="hidden" id="doppelDuellID2" name="doppelDuellID2" >
                                    <td class="bg-gray-100 h-8 text-black border-solid border-b-2 sm:border-r-2 border-black">
                                        <input type="text" list="arten" size="4"  class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300" name="dualType2" id="dualType2" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                        <input type="text" onload="VnameH(this.id)" oninput="VnameH(this.id)" onfocus="javascript:VnameH(this.id);$(this).autocomplete('search');" size="20" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 sm:p-1.5" name="dualVnameHeim12" id="dualVnameHeim12" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                        <input type="text"  onload="NnameH(this.id)" oninput="NnameH(this.id)" onfocus="javascript:NnameH(this.id);$(this).autocomplete('search');"  class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" name="dualNnameHeim12" id="dualNnameHeim12"  />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                        <input type="text" onload="VnameH(this.id)" oninput="VnameH(this.id)" onfocus="javascript:VnameH(this.id);$(this).autocomplete('search');" size="20" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5" name="dualVnameHeim22" id="dualVnameHeim22"  />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                        <input type="text" onload="NnameH(this.id)" oninput="NnameH(this.id)" onfocus="javascript:NnameH(this.id);$(this).autocomplete('search');"  size="20"  class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" name="dualNnameHeim22" id="dualNnameHeim22" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                        <input type="text" onload="VnameG(this.id)" oninput="VnameG(this.id)" onfocus="javascript:VnameG(this.id);$(this).autocomplete('search');" size="20"  class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 sm:p-1.5" name="dualVnameGast12" id="dualVnameGast12"  />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                        <input type="text" onload="NnameG(this.id)" oninput="NnameG(this.id)" onfocus="javascript:NnameG(this.id);$(this).autocomplete('search');"  class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" name="dualNnameGast12" id="dualNnameGast12" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                        <input type="text" onload="VnameG(this.id)" oninput="VnameG(this.id)" onfocus="javascript:VnameG(this.id);$(this).autocomplete('search');" size="20"  class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5" name="dualVnameGast22" id="dualVnameGast22"  />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                        <input type="text" onload="NnameG(this.id)" oninput="NnameG(this.id)" onfocus="javascript:NnameG(this.id);$(this).autocomplete('search');"  size="20"  class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" name="dualNnameGast22" id="dualNnameGast22" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5" onchange="changeSetSumD(2)" name="dualSatz1heim2" id="dualSatz1heim2" />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" onchange=" changeSetSumD(2)" name="dualSatz1gast2" id="dualSatz1gast2"  />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5" onchange=" changeSetSumD(2)" name="dualSatz2heim2" id="dualSatz2heim2"  />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" onchange=" changeSetSumD(2)" name="dualSatz2gast2" id="dualSatz2gast2"  />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5" onchange="changeSetSumD(2)" name="dualSatz3heim2" id="dualSatz3heim2"  />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" onchange=" changeSetSumD(2)" name="dualSatz3gast2" id="dualSatz3gast2"  />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5" readonly="readonly" tabindex="-1" name="dualSetpointHeim2" id="dualSetpointHeim2"  />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" readonly="readonly" tabindex="-1" name="dualSetpointGast2" id="dualSetpointGast2"  />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5" readonly="readonly" tabindex="-1" name="dualWonSetHeim2" id="dualWonSetHeim2"  />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" readonly="readonly" tabindex="-1" name="dualWonSetGast2" id="dualWonSetGast2"  />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:sm:text-right focus:bg-green-400 transition duration-300 p-1.5" readonly="readonly" tabindex="-1" name="dualWonMatchHeim2" id="dualWonMatchHeim2"  />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black">
                                        <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" readonly="readonly" tabindex="-1" name="dualWonMatchGast2" id="dualWonMatchGast2"  />
                                    </td>
                                </tr>
                           
                  
                        <tr class="border-black wrap sm:table-row mb-2 sm:mb-0">
                            <td colspan="15" class="invisible">
                            </td>
                            <td class="bg-gray-100 h-8 text-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full border-black border-dashed border-r-2 focus:bg-green-400 transition duration-300" readonly="readonly" tabindex="-1" name="sumSetHomeDual" id="sumSetHomeDual" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full border-solid border-r-2 border-black focus:bg-green-400 transition duration-300" readonly="readonly" tabindex="-1" name="sumSetGuestDual" id="sumSetGuestDual" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full border-black border-dashed border-r-2 focus:bg-green-400 transition duration-300" readonly="readonly" tabindex="-1" name="sumWonSetHomeDual" id="sumWonSetHomeDual" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full border-solid border-r-2 border-black focus:bg-green-400 transition duration-300" readonly="readonly" tabindex="-1" name="sumWonSetGuestDual" id="sumWonSetGuestDual" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full border-black border-dashed border-r-2 focus:bg-green-400 transition duration-300" readonly="readonly" tabindex="-1" name="sumWonMatchHomeDual" id="sumWonMatchHomeDual" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full focus:bg-green-400 transition duration-300" readonly="readonly" tabindex="-1" name="sumWonMatchGuestDual" id="sumWonMatchGuestDual" />
                            </td>
                        </tr>
                    </tbody>
                </table>


                <h1 class="pt-5">Einzel</h1>

                <input type="hidden" name="regionID" id="regionID" >
                <input type="hidden" name="ligaID" id="ligaID" >
                <input type="hidden" name="HeimID" id="HeimID" value=" ">
                <input type="hidden" name="GastID" id="GastID" >
                <input type="hidden" name="saisonID" id="saisonID" >
                <input type="hidden" name="rundeID" id="rundeID" >
                <input type="hidden" name="tagID" id="tagID" >
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
                       
                            <tr class="bg-green-400 flex flex-col sm:table-row rounded-l-lg sm:rounded-none mb-2 sm:mb-0">
                                <th class="w-28 h-8 sm:h-auto  sm:w-4 border-solid sm:border-r-2 sm:text-center">Art</th>
                                <th class="w-28 h-16 sm:h-auto sm:w-4 border-solid sm:border-r-2 sm:text-center" colspan="2">Spieler: Heim</th>
                                <th class="w-28 h-16 sm:h-auto sm:w-4 border-solid sm:border-r-2 sm:text-center" rowspan="2" colspan="2">Spieler: Gast</th>
                                <th class="w-28 h-48 sm:h-auto sm:w-4 border-solid sm:border-r-2 sm:text-center" rowspan="6" colspan="6">Satzergebnisse</th>
                                <th class="w-28 h-16 sm:h-auto sm:w-4 border-solid sm:border-r-2 sm:text-center" rowspan="2" colspan="2">Summe: Spielpunkte</th>
                                <th class="w-28 h-16 sm:h-auto sm:w-4 border-solid sm:border-r-2 sm:text-center" rowspan="2" colspan="2">Summe: Sätze</th>
                                <th class="w-28 h-16 sm:h-auto sm:w-4 border-solid sm:text-center" rowspan="2" colspan="2">Punkte</th>

                            </tr>
                            
                                <tr class="bg-green-400 flex flex-col sm:table-row rounded-l-lg sm:rounded-none mb-2 sm:mb-0">
                                    <th class="w-28 h-8 sm:h-auto  sm:w-4 border-solid sm:border-r-2 sm:text-center">Art</th>
                                    <th class="w-28 h-16 sm:h-auto sm:w-4 border-solid sm:border-r-2 sm:text-center" colspan="2">Spieler: Heim</th>
                                    <th class="w-28 h-16 sm:h-auto sm:w-4 border-solid sm:border-r-2 sm:text-center" rowspan="2" colspan="2">Spieler: Gast</th>
                                    <th class="w-28 h-48 sm:h-auto sm:w-4 border-solid sm:border-r-2 sm:text-center" rowspan="6" colspan="6">Satzergebnisse</th>
                                    <th class="w-28 h-16 sm:h-auto sm:w-4 border-solid sm:border-r-2 sm:text-center" rowspan="2" colspan="2">Summe: Spielpunkte</th>
                                    <th class="w-28 h-16 sm:h-auto sm:w-4 border-solid sm:border-r-2 sm:text-center" rowspan="2" colspan="2">Summe: Sätze</th>
                                    <th class="w-28 h-16 sm:h-auto sm:w-4 border-solid sm:text-center" rowspan="2" colspan="2">Punkte</th>

                                </tr>
                            
                                    <tr class="bg-green-400 flex flex-col sm:table-row rounded-l-lg sm:rounded-none mb-2 sm:mb-0">
                                        <th class="w-28 h-8 sm:h-auto  sm:w-4 border-solid sm:border-r-2 sm:text-center">Art</th>
                                        <th class="w-28 h-16 sm:h-auto sm:w-4 border-solid sm:border-r-2 sm:text-center" colspan="2">Spieler: Heim</th>
                                        <th class="w-28 h-16 sm:h-auto sm:w-4 border-solid sm:border-r-2 sm:text-center" rowspan="2" colspan="2">Spieler: Gast</th>
                                        <th class="w-28 h-48 sm:h-auto sm:w-4 border-solid sm:border-r-2 sm:text-center" rowspan="6" colspan="6">Satzergebnisse</th>
                                        <th class="w-28 h-16 sm:h-auto sm:w-4 border-solid sm:border-r-2 sm:text-center" rowspan="2" colspan="2">Summe: Spielpunkte</th>
                                        <th class="w-28 h-16 sm:h-auto sm:w-4 border-solid sm:border-r-2 sm:text-center" rowspan="2" colspan="2">Summe: Sätze</th>
                                        <th class="w-28 h-16 sm:h-auto sm:w-4 border-solid sm:text-center" rowspan="2" colspan="2">Punkte</th>

                                    </tr>
                               
                          
                      
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
                           
                    </thead>
                    <tbody class="flex-1 sm:flex-none">
                       
                            <tr class="border-solid border-b-2 border-black w-44 sm:w-auto flex flex-col flex-no wrap sm:table-row mb-2 sm:mb-0">
                                <input type="hidden" id="duellID1" name="duellID1" >
                                <td class="bg-gray-100 h-8 text-black border-solid border-b-2 sm:border-r-2 border-black">
                                    <input type="text" list="arten" size="4"  class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300" name="soloType1" id="soloType1"  />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                    <input type="text" onload="VnameH(this.id)" oninput="VnameH(this.id)" onfocus="VnameH(this.id);javascript:$(this).autocomplete('search');" size="20"  class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 sm:p-1.5" name="soloVnameHeim1" id="soloVnameHeim1"  />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                    <input type="text" onload="NnameH(this.id)" oninput="NnameH(this.id)" onfocus="NnameH(this.id);javascript:$(this).autocomplete('search');" size="20" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" name="soloNnameHeim1" id="soloNnameHeim1"  />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                    <input type="text" onload="VnameG(this.id)" onfocus="javascript:VnameG(this.id);$(this).autocomplete('search');" oninput="VnameG(this.id)" size="20" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5" name="soloVnameGast1" id="soloVnameGast1"  />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                    <input type="text" onload="NnameG(this.id)" onfocus="javascript:NnameG(this.id);$(this).autocomplete('search');" oninput="NnameG(this.id)" size="20" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" name="soloNnameGast1" id="soloNnameGast1"  />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5" onchange=" changeSetSumS(1)" name="soloSatz1heim1" id="soloSatz1heim1"  />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" onchange=" changeSetSumS(1)" name="soloSatz1gast1" id="soloSatz1gast1"  />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5" onchange=" changeSetSumS(1)" name="soloSatz2heim1" id="soloSatz2heim1"  />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" onchange=" changeSetSumS(1)" name="soloSatz2gast1" id="soloSatz2gast1"  />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5" onchange=" changeSetSumS(1)" name="soloSatz3heim1" id="soloSatz3heim1"  />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" onchange=" changeSetSumS(1)" name="soloSatz3gast1" id="soloSatz3gast1"  />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5" readonly="readonly" tabindex="-1" name="soloSetpointHeim1" id="soloSetpointHeim1"  />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" readonly="readonly" tabindex="-1" name="soloSetpointGast1" id="soloSetpointGast1"  />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5" readonly="readonly" tabindex="-1" name="soloWonSetHeim1" id="soloWonSetHeim1"  />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" readonly="readonly" tabindex="-1" name="soloWonSetGast1" id="soloWonSetGast1"  />
                                </td>
                                <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:sm:text-right focus:bg-green-400 transition duration-300 p-1.5" readonly="readonly" tabindex="-1" name="soloWonMatchHeim1" id="soloWonMatchHeim1"  />
                                </td>
                                <td class="bg-gray-100 h-8 text-black">
                                    <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" readonly="readonly" tabindex="-1" name="soloWonMatchGast1" id="soloWonMatchGast1"  />
                                </td>
                            </tr>
                          
                                <tr class="border-solid border-b-2 border-black w-44 sm:w-auto flex flex-col flex-no wrap sm:table-row mb-2 sm:mb-0">
                                    <input type="hidden" id="duellID2" name="duellID2" >
                                    <td class="bg-gray-100 h-8 text-black border-solid border-b-2 sm:border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300"  name="soloType2" id="soloType2"  />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                        <input type="text" onload="VnameH(this.id)" onfocus="javascript:VnameH(this.id);$(this).autocomplete('search');" oninput="VnameH(this.id)" size="20" size="20" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5" name="soloVnameHeim2" id="soloVnameHeim2"  />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                        <input type="text" onload="NnameH(this.id)" onfocus="javascript:NnameH(this.id);$(this).autocomplete('search');" oninput="NnameH(this.id)" size="20" class="bg-gray-100 p-1.5 text-black w-full focus:bg-green-400 transition duration-300" name="soloNnameHeim2" id="soloNnameHeim2"  />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                        <input type="text" onload="VnameG(this.id)" onfocus="javascript:VnameG(this.id);$(this).autocomplete('search');" oninput="VnameG(this.id)" size="20" class="bg-gray-100 text-black w-full h-full sm:text-right  focus:bg-green-400 transition duration-300 p-1.5" name="soloVnameGast2" id="soloVnameGast2"  />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                        <input type="text" onload="NnameG(this.id)" onfocus="javascript:NnameG(this.id);$(this).autocomplete('search');" oninput="NnameG(this.id)" size="20" class="bg-gray-100 p-1.5 text-black w-full focus:bg-green-400 transition duration-300" name="soloNnameGast2" id="soloNnameGast2"  />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 sm:text-right  text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" onchange=" changeSetSumS(2)" name="soloSatz1heim2" id="soloSatz1heim2"  />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 p-1.5 text-black w-full focus:bg-green-400 transition duration-300" onchange=" changeSetSumS(2)" name="soloSatz1gast2" id="soloSatz1gast2"  />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 sm:text-right text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" onchange=" changeSetSumS(2)" name="soloSatz2heim2" id="soloSatz2heim2"  />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 p-1.5 text-black w-full focus:bg-green-400 transition duration-300" onchange=" changeSetSumS(2)" name="soloSatz2gast2" id="soloSatz2gast2"  />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 sm:text-right  text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" onchange=" changeSetSumS(2)" name="soloSatz3heim2" id="soloSatz3heim2"  />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 p-1.5 text-black w-full focus:bg-green-400 transition duration-300" onchange=" changeSetSumS(2)" name="soloSatz3gast2" id="soloSatz3gast2"  />
                                    </td>
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 sm:text-right  text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" readonly="readonly" tabindex="-1" name="soloSetpointHeim2" id="soloSetpointHeim2"  />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 p-1.5 text-black w-full focus:bg-green-400 transition duration-300" readonly="readonly" tabindex="-1" name="soloSetpointGast2" id="soloSetpointGast2"  />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 sm:text-right  text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" name="soloWonSetHeim2" readonly="readonly" tabindex="-1" id="soloWonSetHeim2"  />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 p-1.5 text-black w-full focus:bg-green-400 transition duration-300" readonly="readonly" tabindex="-1" name="soloWonSetGast2" id="soloWonSetGast2"  />
                                    <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                        <input type="text" size="4" class="bg-gray-100 sm:text-right  text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" name="soloWonMatchHeim2" readonly="readonly" tabindex="-1" id="soloWonMatchHeim2"  />
                                    </td>
                                    <td class="bg-gray-100 h-8 text-black">
                                        <input type="text" size="4" class="bg-gray-100 p-1.5 text-black w-full focus:bg-green-400 transition duration-300" readonly="readonly" tabindex="-1" name="soloWonMatchGast2" id="soloWonMatchGast2"  />
                                    </td>
                                </tr>
                              
                                    <tr class="border-solid border-b-2 border-black flex flex-col flex-no wrap sm:table-row mb-2 sm:mb-0">
                                        <input type="hidden" id="duellID3" name="duellID3" >
                                        <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                            <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300" name="soloType3" id="soloType3"  />
                                        </td>
                                        <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                            <input type="text" onload="VnameH(this.id)" onfocus="javascript:VnameH(this.id);$(this).autocomplete('search');" oninput="VnameH(this.id)" size="20" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5" name="soloVnameHeim3" id="soloVnameHeim3"  />
                                        </td>
                                        <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                            <input type="text" onload="NnameH(this.id)" onfocus="javascript:NnameH(this.id);$(this).autocomplete('search');" oninput="NnameH(this.id)" size="20" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" name="soloNnameHeim3" id="soloNnameHeim3"  />
                                        </td>
                                        <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                            <input type="text" onload="VnameG(this.id)" onfocus="javascript:VnameG(this.id);$(this).autocomplete('search');" oninput="VnameG(this.id)" size="20" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5" name="soloVnameGast3" id="soloVnameGast3"   />
                                        </td>
                                        <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                            <input type="text" onload="NnameG(this.id)" onfocus="javascript:NnameG(this.id);$(this).autocomplete('search');" oninput="NnameG(this.id)" size="20" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" name="soloNnameGast3" id="soloNnameGast3"   />
                                        </td>
                                        <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                            <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition sm:text-right duration-300 p-1.5" name="soloSatz1heim3" id="soloSatz1heim3" onchange=" changeSetSumS(3)"  />
                                        </td>
                                        <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                            <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" name="soloSatz1gast3" id="soloSatz1gast3" onchange=" changeSetSumS(3)"  />
                                        </td>
                                        <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                            <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition  sm:text-right duration-300 p-1.5" name="soloSatz2heim3" id="soloSatz2heim3" onchange="   changeSetSumS(3)"  />
                                        </td>
                                        <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                            <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" name="soloSatz2gast3" id="soloSatz2gast3" onchange="changeSetSumS(3)"  />
                                        </td>
                                        <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                            <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition sm:text-right duration-300 p-1.5" name="soloSatz3heim3" id="soloSatz3heim3" onchange=" changeSetSumS(3)"  />
                                        </td>
                                        <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                            <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" name="soloSatz3gast3" id="soloSatz3gast3" onchange=" changeSetSumS(3)"  />
                                        </td>
                                        <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                            <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition sm:text-right duration-300 p-1.5" readonly="readonly" tabindex="-1" name="soloSetpointHeim3" id="soloSetpointHeim3"  />
                                        </td>
                                        <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                            <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" readonly="readonly" tabindex="-1" name="soloSetpointGast3" id="soloSetpointGast3"   />
                                        </td>
                                        <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                            <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition sm:text-right duration-300 p-1.5" readonly="readonly" tabindex="-1" name="soloWonSetHeim3" id="soloWonSetHeim3"  />
                                        </td>
                                        <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                            <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" readonly="readonly" tabindex="-1" name="soloWonSetGast3" id="soloWonSetGast3"  />
                                        </td>
                                        <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                            <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition sm:text-right duration-300 p-1.5" readonly="readonly" tabindex="-1" name="soloWonMatchHeim3" id="soloWonMatchHeim3" />
                                        </td>
                                        <td class="bg-gray-100 h-8 text-black">
                                            <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" readonly="readonly" tabindex="-1" name="soloWonMatchGast3" id="soloWonMatchGast3"   />
                                        </td>
                                    </tr>
                                   
                                        <tr class="border-solid border-b-2 border-black flex flex-col flex-no wrap sm:table-row mb-2 sm:mb-0">
                                            <input type="hidden" id="duellID4" name="duellID4" >
                                            <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300" name="soloType4" id="soloType4"  />
                                            </td>
                                            <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                                <input type="text" onload="VnameH(this.id)" onfocus="javascript:VnameH(this.id);$(this).autocomplete('search');" oninput="VnameH(this.id)" size="20" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5" name="soloVnameHeim4" id="soloVnameHeim4"   />
                                            </td>
                                            <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                                <input type="text" onload="NnameH(this.id)" onfocus="javascript:NnameH(this.id);$(this).autocomplete('search');" oninput="NnameH(this.id)" size="20" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" name="soloNnameHeim4" id="soloNnameHeim4"  />
                                            </td>
                                            <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                                <input type="text" onload="VnameG(this.id)" onfocus="javascript:VnameG(this.id);$(this).autocomplete('search');" oninput="VnameG(this.id)" size="20" class="bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5" name="soloVnameGast4" id="soloVnameGast4"   />
                                            </td>
                                            <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                                <input type="text" onload="NnameG(this.id)" onfocus="javascript:NnameG(this.id);$(this).autocomplete('search');" oninput="NnameG(this.id)" size="20" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" name="soloNnameGast4" id="soloNnameGast4"   />
                                            </td>
                                            <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 sm:text-right transition duration-300 p-1.5" name="soloSatz1heim4" id="soloSatz1heim4" onchange=" changeSetSumS(4)"  />
                                            </td>
                                            <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" name="soloSatz1gast4" id="soloSatz1gast4" onchange=" changeSetSumS(4)"  />
                                            </td>
                                            <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 sm:text-right transition duration-300 p-1.5" name="soloSatz2heim4" id="soloSatz2heim4" onchange=" changeSetSumS(4)"  />
                                            </td>
                                            <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" name="soloSatz2gast4" id="soloSatz2gast4" onchange=" changeSetSumS(4)"  />
                                            </td>
                                            <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 sm:text-right transition duration-300 p-1.5" name="soloSatz3heim4" id="soloSatz3heim4" onchange=" changeSetSumS(4)"  />
                                            </td>
                                            <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" name="soloSatz3gast4" id="soloSatz3gast4" onchange=" changeSetSumS(4)"  />
                                            </td>
                                            <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 sm:text-right transition duration-300 p-1.5" readonly="readonly" tabindex="-1" name="soloSetpointHeim4" id="soloSetpointHeim4"  />
                                            </td>
                                            <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" readonly="readonly" tabindex="-1" name="soloSetpointGast4" id="soloSetpointGast4"  />
                                            </td>
                                            <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black"> 
                                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 sm:text-right transition duration-300 p-1.5" readonly="readonly" tabindex="-1" name="soloWonSetHeim4" id="soloWonSetHeim4"  />
                                            </td>
                                            <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" readonly="readonly" tabindex="-1" name="soloWonSetGast4" id="soloWonSetGast4"  />
                                            </td>
                                            <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 sm:text-right transition duration-300 p-1.5" readonly="readonly" tabindex="-1" name="soloWonMatchHeim4" id="soloWonMatchHeim4"  />
                                            </td>
                                            <td class="bg-gray-100 h-8 text-black">
                                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" readonly="readonly" tabindex="-1" name="soloWonMatchGast4" id="soloWonMatchGast4"  />
                                            </td>
                                        </tr>
                        
                        <tr class="border-black wrap sm:table-row mb-2 sm:mb-0">
                            <td colspan="11" class="invisible">
                            </td>
                            <td class="bg-gray-100 h-8 text-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full border-black border-dashed border-r-2 focus:bg-green-400 transition duration-300" readonly="readonly" tabindex="-1" name="sumSetHomeSolo" id="sumSetHomeSolo" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full border-solid border-r-2 border-black focus:bg-green-400 transition duration-300" readonly="readonly" tabindex="-1" name="sumSetGuestSolo" id="sumSetGuestSolo" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full border-black border-dashed border-r-2 focus:bg-green-400 transition duration-300" readonly="readonly" tabindex="-1" name="sumWonSetHomeSolo" id="sumWonSetHomeSolo" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full border-solid border-r-2 border-black focus:bg-green-400 transition duration-300" readonly="readonly" tabindex="-1" name="sumWonSetGuestSolo" id="sumWonSetGuestSolo" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full border-black border-dashed border-r-2 focus:bg-green-400 transition duration-300" readonly="readonly" tabindex="-1" name="sumWonMatchHomeSolo" id="sumWonMatchHomeSolo" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full focus:bg-green-400 transition duration-300" readonly="readonly" tabindex="-1" name="sumWonMatchGuestSolo" id="sumWonMatchGuestSolo" />
                            </td>
                        </tr>
                    </tbody>
                </table>
            
                <div class="mt-3 flex place-content-end">
                   
                    <div>
                        <button class="my-2 float-right px-3 py-3 rounded bg-green-500 active:bg-green-700 text-white text-sm   font-bold" type="submit" id="submitBTN" name="submit" >Absenden</button>
                    </div>
                </div>
            </form>
         
        </div>
    </section>
   <script type="text/javascript">
        // CSRF Token
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');


        $(document).ready(function() {
            document.getElementById("saison").disabled = true;
                document.getElementById("runde").disabled = true;
                    document.getElementById("tag").disabled = true;
            alleLigen();
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
                    document.getElementById("liga").value = "";
                     document.getElementById("ligaID").value = "";       document.getElementById("saison").value = "";
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

                alleLigen();
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

        function alleLigen() {
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
        function saisoncheck(){
         if (!$('#saison').val()) {
         document.getElementById("saisonID").value = "";
         document.getElementById("rundeID").value = "";
          document.getElementById("runde").value = "";
                  document.getElementById("tag").value = "";
                   document.getElementById("tagID").value = "";
                     document.getElementById("runde").disabled = true;
                    document.getElementById("tag").disabled = true;
         }
        }
        function saison(){
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

        function rundecheck(){
         if (!$('#runde').val()) {
            
                 document.getElementById("rundeID").value = "";
                  document.getElementById("tag").value = "";
                   document.getElementById("tagID").value = "";
                   
                    document.getElementById("tag").disabled = true;
                   
        }}
            function runde(){
           
             
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
            function tagcheck(){
             if (!$('#tag').val()) {
             document.getElementById("tagID").value = "";
            }}
            
            function tag(){
             
            
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
                      $('#tagID').val(ui.item.value);
                          ;
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

      
    </script>
@endsection

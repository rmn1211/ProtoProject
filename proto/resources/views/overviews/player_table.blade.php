
@php
   
    use App\Http\Controllers\QueryController;

    if(isset($_GET['selectedID'])) {
        if($_GET['selectedID']==""){
        if($_GET['ligaID']==""){
        if($_GET['regionID']==""){
            $spieler = QueryController::getAlleSpieler();
            }
            else{
                $regionID = $_GET['regionID'];
                $spieler = QueryController::getRegionSpieler($regionID);
            }
            }
            else{
                $ligaID = $_GET['ligaID'];
            $spieler = QueryController::getLigaSpieler($ligaID);
            }


            }
        else{
            $teamID = $_GET['selectedID'];
            $spieler = QueryController::getSpieler($teamID);
            }
    }
    else{  
    $spieler = QueryController::getAlleSpieler();
    }
    
    
   
    
@endphp

<head>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
 <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
</head>
<style>
  
  .alle{
  background-color:white;
color:black;}
.selected {
    background-color: green;
    color: white;
}
  </style>
<body>
   
<table class="table-fixed" id="table">
            <thead>
                <tr class ="border-solid border-b-2 border-black bg-green-500 ">
                    <th hidden>ID </th>
                    <th class="px-4 py-2 mx-1">Vorname</th>
                    <th class="px-4 py-2 mx-1">Nachname</th>
                    <th class="px-4 py-2 mx-1">Geschlecht</th>
                    <th class="px-4 py-2 mx-1">Mannschaften</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($spieler as $player)
                    <tr class="border-solid border-b-2 border-black alle">
                        <td hidden class="bg-gray-100 text-black border-solid border-r-2 border-black" name="id" id="id">
                            {{ $player->ID }}</td>
                        <td class="border-solid border-r-2 border-b-2 border-black  px-4 py-2 mx-1" name="vorname" id="vorname">
                            {{ $player->Vorname }}</td>
                        <td class="border-solid border-r-2 border-b-2 border-black  px-4 py-2 mx-1" id="nachname">
                            {{ $player->Nachname }}</td>
                        <td class="border-solid border-r-2 border-b-2 border-black  px-4 py-2 mx-1" id="geschlecht">
                            {{ $player->Geschlecht }}</td>
                        <td class="border-solid border-r-2 border-b-2 border-black  px-4 py-2 mx-1" name="liga" id="iga">
                            {{ $player->Mannschaften }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
      <br>
      <br> 
      </body>
     <!-- FORM besteht nur aus Hidden Inputfield, dass die ID enthält, da nur diese benötigt wird.
    Vereinfacht austausch zwischen html - php - js -- TODO: detailansicht
    <form class="" name ="idForm" id="idForm" method="GET" action="{{ url('/overview/edit') }}"
      <input type="hidden" name="selectedID" id="selectedID" value="">
      <input class = "bg-green-500"type="submit" value="Detail">
    </form> -->
    <script type="text/javascript">
        highlight_row();

        function highlight_row() {
            var table = document.getElementById('table');
            var cells = table.getElementsByTagName('td');

            for (var i = 0; i < cells.length; i++) {
                // Take each cell
                var cell = cells[i];
                // do something on onclick event for cell
                cell.onclick = function() {
                    // Get the row id where the cell exists
                    var rowId = this.parentNode.rowIndex;

                    var rowsNotSelected = table.getElementsByTagName('tr');
                    for (var row = 0; row < rowsNotSelected.length; row++) {

                        rowsNotSelected[row].classList.remove('selected');

                    }
                    var rowSelected = table.getElementsByTagName('tr')[rowId];
                    //rowSelected.style.backgroundColor = "green";
                    rowSelected.className += " selected";

                    //msg = 'The ID  is: ' + rowSelected.cells[0].innerHTML;
                    var spielid = rowSelected.cells[0].innerHTML; // kann außerhalb der funktion verwendet werden, zb für prüfen
                  //  document.idForm.selectedID.value = spielid;
                    
                    //alert(spielid);
                    //msg += '\nThe cell value is: ' + this.innerHTML;
                    // alert(msg);
                }
            }

        }

    </script>



@php
   
    use App\Http\Controllers\QueryController;
      if(isset($_GET['regionID'])) {
        if(isset($_GET['selectedID'])) {
         
            if($_GET['selectedID']==""){
                if($_GET['regionID']==""){

                    $mannschaften = QueryController::getAlleMannschaften();
                    }
                else{
                    $regionID = $_GET['regionID'];
                    $mannschaften = QueryController::getRegionMannschaften($regionID);
                }
            }
            else{
                $ligaID = $_GET['selectedID'];
                $mannschaften = QueryController::getMannschaften($ligaID);
            }
        }

        }
      
    else{
        $mannschaften = QueryController::getAlleMannschaften();
    }
    
    
   
    
@endphp

<head>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
 <link rel="stylesheet" href="{{ asset('css/app.css') }}">
       
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
   

      <table class="table-fixed"  id="table">
      <thead >
        <tr  class ="border-solid border-b-2 border-black bg-green-500 ">
        <th hidden>ID </th>
          <th >Name</th>
          <th>Kapitän</th>
          <th>Verein von</th>
          <th>Liga</th>
          
        </tr>
</thead><tbody >
        @foreach ($mannschaften as $mannschaft)
       
 
        <tr class ="border-solid border-b-2 border-black alle  ">
        <td hidden class="bg-gray-100 text-black border-solid border-r-2 border-black" name = "id" id="id">{{ $mannschaft->ID  }}</td>
        <td class="border-solid border-r-2 border-b-2 border-black px-4 py-2 mx-1"  name = "mannschaft" id="mannschaft">{{ $mannschaft->Mannschaft  }}</td>
          <td class="border-solid border-r-2 border-b-2 border-black  px-4 py-2 mx-1" name = "kapitän" id="kapitän">{{ $mannschaft->vorname  }}  {{ $mannschaft->nachname  }}</td>
          <td class="border-solid border-r-2 border-b-2 border-black  px-4 py-2 mx-1" name = "Verein" id="Verein">{{ $mannschaft->Verein  }} </td>
          <td  class="border-solid border-r-2  border-b-2 border-black  px-4 py-2 mx-1" name = "Liga" id="Liga">{{  $mannschaft->Liga  }}</td>
          
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


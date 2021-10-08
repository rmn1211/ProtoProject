@extends('heafoo')
@php
   
    use App\Http\Controllers\QueryController;
    
    
    

    $spiele = QueryController::getSpiele();
   
    
@endphp
@section('page-content')
<head>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

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
<section >
      <h3 class ="font-bold  text-2xl">Eingereichte Spielberichte</h3>
    </section>
    <section  class="mt-10 class=w-6/12">
    <form class="flex flex-col mx-3 mb-6" method="POST" action="">  

      <table class="table-fixed"  id="table">
      <thead>
        <tr>
        <th hidden>ID </th>
          <th>Spiel</th>
          <th>Termin</th>
          <th>Eingereicht von</th>
          <th>Status</th>
          
        </tr>
</thead><tbody >
        @foreach ($spiele as $match)
        @php $status = "";
if($match->status == 0)
   $status = "offen";

if($match->status == 1)
   $status = "bearbeitet";

if($match->status == 2)
   $status = "abgelehnt";

 @endphp
 
        <tr class ="border-solid border-b-2 border-black alle">
        <td hidden class="bg-gray-100 text-black border-solid border-r-2 border-black" name = "id" id="id">{{ $match->ID  }}</td>
          <td class="border-solid border-r-2 border-b-2 border-black" name = "spiel" id="spiel">{{ $match->Heim  }} vs {{ $match->Gast  }}</td>
          <td class="border-solid border-r-2 border-b-2 border-black"  name = "termin" id="termin">{{ $match->Termin  }}</td>
          <td class="border-solid border-r-2 border-b-2 border-black" name = "von" id="von">{{ $match->vorname  }} {{ $match->nachname  }}</td>
          <td  class="border-solid border-r-2  border-b-2 border-black" name = "status" id="status">{{  $status  }}</td>
          
      </tr>
      @endforeach
</tbody>
      </table>


      <br>
      <br>
      
      <button class = "bg-green-500"type="" name="" value="Prüfen">Prüfen</button>
     </form>

     
    </section>
   <script  >

highlight_row();
function highlight_row() {
    var table = document.getElementById('table');
    var cells = table.getElementsByTagName('td');

    for (var i = 0; i < cells.length; i++) {
        // Take each cell
        var cell = cells[i];
        // do something on onclick event for cell
        cell.onclick = function () {
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
            var spielid = rowSelected.cells[0].innerHTML;   // kann außerhalb der funktion verwendet werden, zb für prüfen
            alert(spielid);
            //msg += '\nThe cell value is: ' + this.innerHTML;
           // alert(msg);
        }
    }

}

     </script>
@endsection
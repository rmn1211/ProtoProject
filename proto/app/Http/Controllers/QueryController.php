<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Spielplan;
class QueryController extends Controller
{
    //SELECT QUERIES FROM DUELL
    public static function getResults($id)
    {
        //$change = DB::connection('mysqlrep')->update('update duell set Schiedsrichter = "Günther Jauch" where id = ?', [$id]);
       $results = Spielplan::select('select * from duell where spiel_ID = ?', [$id]);
       
        //$foo =DB::connection('mysqlrep')->insert('insert into region (Name, Sportart) Values ("Köln-Bonn", 1)');
       // $satz = DB::connection('mysqlrep')->select('select * from satz where duell_ID = ? and Satz_Nr = 3',[$id]);
        //$region = DB::connection('mysqlrep')->select('select * from region');
       return $results;
    }
    

    public static function getOrt($id)
    {
        //$ort = DB::select('select ort from spiel where ID = ?', [$id]);
        $place = Spielplan::table(Spielplan::raw('spiel'))
        ->where(Spielplan::raw('ID'), [$id])
        ->first();
        return $place->Ort;
    }

    public static function getHome($id)
    {
        //$home = DB::select('select m.name from spiel s,mannschaft m where s.Heim = m.Verein_ID and s.ID = ?', [$id]);
        $home = Spielplan::table(Spielplan::raw('spiel s, mannschaft m'))
        ->where(Spielplan::raw('s.Heim = m.Verein_ID and s.ID'), [$id])
        ->first();
        return $home->name;
    }
    public static function getAway($id)
    {
        $away = Spielplan::table(Spielplan::raw('spiel s, mannschaft m'))
        ->where(Spielplan::raw('s.Gast = m.Verein_ID and s.ID'), [$id])
        ->first();
        return $away->name;
    }

    public static function getTeams($liga)
    {
        $teams = Spielplan::table(Spielplan::raw('mannschaft'))
        ->where(Spielplan::raw('liga'), [$liga]);
        return $teams;
    }

    public static function getNamesE($duellID)
    {
        
    }
    public static function getNamesD($duellID)
    {
        //Names is an Arry full of Objects. To gather an Value, first get the index and than the Value
       /* $names = DB::table(DB::raw('duell du, doppel dp, spieler s'))
        ->where(DB::raw('dp.Spieler_Heim_1= s.ID and dp.Duell_ID =2'))
        ->pluck('Vorname');
        return $names;*/
        $name =Spielplan::select('SELECT s.Vorname, s.Nachname FROM doppel d LEFT JOIN spieler s ON d.spieler_Heim_1 = s.ID');
        return $name;
    }
    public static function getDuells($spielID)
    {
        $duelle = Spielplan::table('duell')
        ->where('Spiel_ID', $spielID)
        ->pluck('ID');

        return $duelle;

    }
   
    public function updateMatch($id,Request $request)
    {
        $place = $request->tfPlace;
        $home = $request->tfHome;
        $homeID = $this->getTeamID($home);
        $guest = $request-> tfAway;
        $guestID = $this->getTeamID($guest);
        #$id = $request -> match;
        $set = Spielplan::table(('spiel'))
        ->where(Spielplan::raw('ID'), [$id])
        ->update([  'Ort'=>$place,
                    'Heim'=>$homeID,
                    'Gast'=>$guestID]);
    }

    public function getTeamID($name)
    {
        $team = Spielplan::table('mannschaft')
        ->where('name',$name)
        ->first();
        return $team->ID;
    }

    
}

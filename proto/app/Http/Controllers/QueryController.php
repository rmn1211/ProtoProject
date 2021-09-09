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
       $results = DB::select('select * from duell where spiel_ID = ?', [$id]);
       
        //$foo =DB::connection('mysqlrep')->insert('insert into region (Name, Sportart) Values ("Köln-Bonn", 1)');
       // $satz = DB::connection('mysqlrep')->select('select * from satz where duell_ID = ? and Satz_Nr = 3',[$id]);
        //$region = DB::connection('mysqlrep')->select('select * from region');
       return $results;
    }
    

    public static function getOrt($id)
    {
        //$ort = DB::select('select ort from spiel where ID = ?', [$id]);
        $place = DB::table(DB::raw('spiel'))
        ->where(DB::raw('ID'), [$id])
        ->first();
        return $place->Ort;
    }

    public static function getHome($id)
    {
        //$home = DB::select('select m.name from spiel s,mannschaft m where s.Heim = m.Verein_ID and s.ID = ?', [$id]);
        $home = DB::table(DB::raw('spiel s, mannschaft m'))
        ->where(DB::raw('s.Heim = m.Verein_ID and s.ID'), [$id])
        ->first();
        return $home->name;
    }
    public static function getAway($id)
    {
        $away = DB::table(DB::raw('spiel s, mannschaft m'))
        ->where(DB::raw('s.Gast = m.Verein_ID and s.ID'), [$id])
        ->first();
        return $away->name;
    }

    public static function getTeams($liga)
    {
        $teams = DB::select("SELECT * from mannschaft Where liga = '{$liga}' ");
        
        return $teams;
    }

    public static function getArt($duellID)
    {
        $art = DB::table(DB::raw('art a, duell d'))
        ->where(DB::raw('d.art = a.id and d.ID'), [$duellID])
        ->first();
        return $art->Name;
    }

    public static function getNamesSolo($duellID)
    {
        $name =DB::select('SELECT s.Vorname, s.Nachname FROM einzel e LEFT JOIN spieler s ON e.spieler_Heim = s.ID or e.spieler_Gast = s.ID');
        return $name;
    }
    public static function getNamesDouble($duellID)
    {
        //Names is an Arry full of Objects. To gather an Value, first get the index and than the Value
       /* $names = DB::table(DB::raw('duell du, doppel dp, spieler s'))
        ->where(DB::raw('dp.Spieler_Heim_1= s.ID and dp.Duell_ID =2'))
        ->pluck('Vorname');
        return $names;*/
        $name =DB::select('SELECT s.Vorname, s.Nachname FROM doppel d LEFT JOIN spieler s ON d.spieler_Heim_1 = s.ID  or d.spieler_Heim_2 = s.ID or d.spieler_Gast_1 = s.ID  or d.spieler_Gast_2 = s.ID');
        return $name;
    }
    
    public static function getDuells($spielID)
    {
        $duelle = DB::table('duell')
        ->where('Spiel_ID', $spielID)
        ->pluck('ID');

        return $duelle;

    }

    public static function getSolo($id) #Gruesse an Jabba the Hutt
    {
        $duell = DB::select('SELECT 
        a.name AS art,																										#Art
        s1.Vorname AS heimVorname, s1.Nachname AS heimNachname,																					#Heimspieler
        s2.Vorname AS gastVorname, s2.Nachname AS gastNachname,																					#Gastspieler
        sa1.Punkte_Heim AS satz1Heim, sa1.Punkte_Gast AS satz1Gast, sa2.Punkte_Heim AS satz2Heim, sa2.Punkte_Gast AS satz2Gast, sa3.Punkte_Heim AS satz3Heim, sa3.Punkte_Gast AS satz3Gast,		#Satzergebnisse
        sa1.Punkte_Heim + sa2.Punkte_Heim + sa3.Punkte_Heim AS "Heim Gesamt",										#Summe der Satzergebnisse Heim
        sa1.Punkte_Gast + sa2.Punkte_Gast + sa3.Punkte_Gast AS "Gast Gesamt",										#Summe der Satzergebnisse Gast
        d.heim_saetze AS "GewonneneSaetzeHeim", d.gast_saetze AS "GewonneneSaetzeGast",							#Angabe der jeweils gewonnenen Sätze
        d.heim_spiele AS "GewonneneSpieleHeim", d.gast_spiele AS "GewonneneSpieleGast"						#Angabe der jeweils gewonnenen Spiele
    FROM 
        art a, spieler s1, spieler s2, duell d, einzel e, satz sa1, satz sa2, satz sa3 
    WHERE 
        d.id = 1 and a.id = d.art and e.spieler_heim = s1.id and e.spieler_gast = s2.id and sa1.Duell_ID = 1 and sa1.Satz_Nr=1 and sa2.Duell_ID = 1 and sa2.Satz_Nr=2 and sa3.Duell_ID = 1 and sa3.Satz_Nr=3;
    ');
return $duell;
    }

    public static function getDouble($id)
    {
    
    }

    public static function getType($spielID, $diellID)
    {

    }

    public function getTeamID($name)
    {
        $team = DB::table('mannschaft')
        ->where('name',$name)
        ->first();
        return $team->ID;
    }
 #-----------------------------------------------Update-functions--------------------------------  
    public function updateMatch($id,Request $request)
    {
        $place = $request->tfPlace;
        $home = $request->tfHome;
        $homeID = $this->getTeamID($home);
        $guest = $request-> tfAway;
        $guestID = $this->getTeamID($guest);
        #$id = $request -> match;
        $set = DB::table(('spiel'))
        ->where(DB::raw('ID'), [$id])
        ->update([  'Ort'=>$place,
                    'Heim'=>$homeID,
                    'Gast'=>$guestID]);
    }

#----------------------------------Suggestions-------------------------------------------------------------


    public function index()
    {
        return view('check_report');
    }
 
    public static function autocompleteSearch(Request $request)
    {
          $query = $request->get('query');
          $filterResult = DB::select('SELECT Name from liga where Name LIKE "$query"');
          
          
          return response()->json($filterResult);
    } 

    public static function alleLigen()
    {
        $ligen =DB::select('SELECT * from liga');
        return $ligen;
    }
    public static function LigaID($name) // first
    {
        //$liga =DB::selec*t("SELECT * from liga where name Like '%$teilname%' ");
        //return $liga;

        $liga = DB::table('liga')
        ->where('name',$name)
        ->first();
        return $liga;

    }
    

   
    public static function alleLigen2(Request $request){
        $search = $request->search;
            $ligen = DB::table('liga')->select('ID','Name')->where('name', 'like', '%' .$search . '%')  ->get();
            
        
              $response = array();
              foreach($ligen as $liga){
                 $response[] = array("ID"=>$liga->ID,"Name"=>$liga->Name);
              }
        
              return response()->json($response); 
           } 
        
        
           public static function alleMannschaften(Request $request){
            
           
           $search = $request->search;
           $liga = $request->liga;
           $rliga = DB::table('liga')->select('ID')->where('name', '=', $liga)  ->first();
           //DB::select("SELECT ID from liga where name = '$liga' ");
           $test = $rliga ->ID;
           $mannschaften = DB::table('mannschaft')->select('ID','Name')->where('liga', '=', $test  ) ->where('name', 'like', '%' .$search . '%')  ->get();
           //DB::select("SELECT * from Mannschaften where liga == '$rliga' ");   
           //
           
        
             $response = array();
             foreach($mannschaften as $mannschaft){
                $response[] = array("ID"=>$mannschaft->ID,"Name"=>$mannschaft->Name);
             }
        
             return response()->json($response); 
          } 
        
    }
    

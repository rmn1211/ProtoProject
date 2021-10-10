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
       $results = DB::connection('mysqlSP')->select('select * from duell where spiel_ID = ?', [$id]);
       
        //$foo =DB::connection('mysqlrep')->insert('insert into region (Name, Sportart) Values ("Köln-Bonn", 1)');
       // $satz = DB::connection('mysqlrep')->select('select * from satz where duell_ID = ? and Satz_Nr = 3',[$id]);
        //$region = DB::connection('mysqlrep')->select('select * from region');
       return $results;
    }
    

    public static function getOrt($id)
    {
        //$ort = DB::select('select ort from spiel where ID = ?', [$id]);
        $place = DB::connection('mysqlSP')->table(DB::raw('spiel'))
        ->where(DB::raw('ID'), [$id])
        ->first();
        return $place->Ort;
    }

    public static function getHome($id)
    {
        //$home = DB::select('select m.name from spiel s,mannschaft m where s.Heim = m.Verein_ID and s.ID = ?', [$id]);
        $home = DB::connection('mysqlSP')->table(DB::raw('spiel s, mannschaft m'))
        ->where(DB::connection('mysqlSP')->raw('s.Heim = m.Verein_ID and s.ID'), [$id])
        ->first();
        return $home->name;
    }
    public static function getAway($id)
    {
        $away = DB::connection('mysqlSP')->table(DB::raw('spiel s, mannschaft m'))
        ->where(DB::connection('mysqlSP')->raw('s.Gast = m.Verein_ID and s.ID'), [$id])
        ->first();
        return $away->name;
    }

    public static function getTeams($liga)
    {
        $teams = DB::connection('mysqlSP')->select("SELECT * from mannschaft Where liga = '{$liga}' ");
        
        return $teams;
    }

    public static function getArt($duellID)
    {
        $art = DB::connection('mysqlSP')->table(DB::raw('art a, duell d'))
        ->where(DB::connection('mysqlSP')->raw('d.art = a.id and d.ID'), [$duellID])
        ->first();
        return $art->Name;
    }

    public static function getNamesSolo($duellID)
    {
        $name =DB::connection('mysqlSP')->select('SELECT s.Vorname, s.Nachname FROM einzel e LEFT JOIN spieler s ON e.spieler_Heim = s.ID or e.spieler_Gast = s.ID');
        return $name;
    }
    public static function getNamesDouble($duellID)
    {
        //Names is an Arry full of Objects. To gather an Value, first get the index and than the Value
       /* $names = DB::table(DB::raw('duell du, doppel dp, spieler s'))
        ->where(DB::raw('dp.Spieler_Heim_1= s.ID and dp.Duell_ID =2'))
        ->pluck('Vorname');
        return $names;*/
        $name =DB::connection('mysqlSP')->select('SELECT s.Vorname, s.Nachname FROM doppel d LEFT JOIN spieler s ON d.spieler_Heim_1 = s.ID  or d.spieler_Heim_2 = s.ID or d.spieler_Gast_1 = s.ID  or d.spieler_Gast_2 = s.ID');
        return $name;
    }
    
    public static function getDuells($spielID)
    {
        $duelle = DB::connection('mysqlSP')->table('duell')
        ->where('Spiel_ID', $spielID)
        ->pluck('ID');

        return $duelle;

    }

    public static function getSolo($id) #Gruesse an Jabba the Hutt
    {
        $duell = DB::connection('mysqlSP')->select('SELECT 
        d.id AS "Duell_ID",																		#ID des eingetlichen Duells
    a.name AS "Duellart",																	#Duell Art: Doppel, Einzel, Herren,Damen, Gemischt
    s1.vorname AS "Vorname_S1", s1.nachname AS "Nachname_S1",								#Name Spieler 1
    s2.vorname AS "Vorname_S2", s2.nachname AS "Nachname_S2",								#Name Spieler 2
    sa1.Punkte_Heim AS "Satz_1_Heim", sa1.Punkte_Gast AS "Satz_1_Gast",					#Punkte im 1. Satz
    sa2.Punkte_Heim AS "Satz_2_Heim", sa2.Punkte_Gast AS "Satz_2_Gast",					#Punkte im 2. Satz
    sa3.Punkte_Heim AS "Satz_3_Heim", sa3.Punkte_Gast AS "Satz_3_Gast",					#Punkte im 3. Satz
    sa1.Punkte_Heim + sa2.Punkte_Heim + sa3.Punkte_Heim AS "Heim_Gesamt",					#Gesamtpunktzahl Heimmannschaft
    sa1.Punkte_Gast + sa2.Punkte_Gast + sa3.Punkte_Gast AS "Gast_Gesamt",					#Gesamtpunktzahl Gastmannschaft
    d.heim_saetze AS "Gewonnene_Sätze_Heim", d.gast_saetze AS "Gewonnene_Sätze_Gast",		#Gewonnene Sätze					
    d.heim_spiele AS "Gewonnene_Spiele_Heim", d.gast_spiele AS "Gewonnene_Spiele_Gast"	#Gewonnene Spiele
FROM duell d
	LEFT JOIN  art a ON a.id = d.art
	LEFT JOIN einzel e ON e.Duell_ID = d.ID
	LEFT JOIN spieler s1 ON e.Spieler_Heim = s1.ID
	LEFT JOIN spieler s2 ON e.Spieler_Gast = s2.id
    LEFT JOIN  satz sa1 ON sa1.Duell_ID = d.id
    LEFT JOIN  satz sa2 ON sa2.Duell_ID = d.id
    LEFT JOIN  satz sa3 ON sa3.Duell_ID = d.id
WHERE d.Spiel_ID =1 and d.id IN (e.duell_ID) and sa1.Satz_Nr =1 and sa2.Satz_Nr =2 and sa3.Satz_Nr =3;	#Spiel ID wird in Funktion als Parameter uebertragen, um Spiele zu unterscheiden Um Einzelspiele zu filtern wird nach IDs in Einzel gesucht
 
    ');
return $duell;
    }

    public static function getDouble($id)
    {
        $duell = DB::connection('mysqlSP')->select('SELECT 
        d.id AS "Duell-ID",																		#ID des eingetlichen Duells
    a.name AS "Duellart",																	#Duell Art: Doppel, Einzel, Herren,Damen, Gemischt
    s1h.vorname AS "Vorname_S1_H", s1h.nachname AS "Nachname_S1_H",								#Name Spieler 1 Heim
    s2h.vorname AS "Vorname_S2_H", s2h.nachname AS "Nachname_S2_H",								#Name Spieler 2 Heim
	s1g.vorname AS "Vorname_S1_G", s1g.nachname AS "Nachname_S1_G",								#Name Spieler 1 Gast
    s2g.vorname AS "Vorname_S2_G", s2g.nachname AS "Nachname_S2_G",								#Name Spieler 2 Gast
    sa1.Punkte_Heim AS "Satz_1_Heim", sa1.Punkte_Gast AS "Satz_1_Gast",					#Punkte im 1. Satz
    sa2.Punkte_Heim AS "Satz_2_Heim", sa2.Punkte_Gast AS "Satz_2_Gast",					#Punkte im 2. Satz
    sa3.Punkte_Heim AS "Satz_3_Heim", sa3.Punkte_Gast AS "Satz_3_Gast",					#Punkte im 3. Satz
    sa1.Punkte_Heim + sa2.Punkte_Heim + sa3.Punkte_Heim AS "Heim_Gesamt",					#Gesamtpunktzahl Heimmannschaft
    sa1.Punkte_Gast + sa2.Punkte_Gast + sa3.Punkte_Gast AS "Gast_Gesamt",					#Gesamtpunktzahl Gastmannschaft
    d.heim_saetze AS "Gewonnene_Sätze_Heim", d.gast_saetze AS "Gewonnene_Sätze_Gast",		#Gewonnene Sätze					
    d.heim_spiele AS "Gewonnene_Spiele_Heim", d.gast_spiele AS "Gewonnene_Spiele_Gast"	#Gewonnene Spiele
FROM duell d
	LEFT JOIN  art a ON a.id = d.art
	LEFT JOIN doppel dp ON dp.Duell_ID = d.ID
	LEFT JOIN spieler s1h ON dp.Spieler_Heim_1 = s1h.ID
	LEFT JOIN spieler s2h ON dp.Spieler_Heim_2 = s2h.id
    LEFT JOIN spieler s1g ON dp.Spieler_Gast_1 = s1g.ID
	LEFT JOIN spieler s2g ON dp.Spieler_Gast_2 = s2g.id
    LEFT JOIN  satz sa1 ON sa1.Duell_ID = d.id
    LEFT JOIN  satz sa2 ON sa2.Duell_ID = d.id
    LEFT JOIN  satz sa3 ON sa3.Duell_ID = d.id
WHERE d.id IN (dp.duell_ID) and sa1.Satz_Nr =1 and sa2.Satz_Nr =2 and sa3.Satz_Nr =3 and d.Spiel_ID =1;	#Spiel ID wird in Funktion als Parameter uebertragen, um Spiele zu unterscheiden Um Doppelspiele zu filtern wird nach IDs in Einzel gesucht

    ');
return $duell;
    }

    public static function getType($spielID, $diellID)
    {

    }
 #---------------------------------------------------Update-functions--------------------------------  
#Hilfsfunktionen zum anhand von Eingaben IDs herauszufinden
    private function getTeamID($name)
    {
        $team = DB::connection('mysqlSP')->table('mannschaft')
        ->where('name',$name)
        ->first();
        return $team->ID;
    }
    private function getPlayerID($firstname, $lastname)
    {
        $player = DB::connection('mysqlSP')->table('spieler')
        ->where('Vorname',"Willy")
        ->where('Nachname',"Brandt")
        ->first();
        return $player ->ID;
    }
    #Eigetnliche Updatefunktionen
    public function updateMatch($id,Request $request)
    {
        $place = $request->tfPlace;
        $home = $request->tfHome;
        $homeID = $this->getTeamID($home);
        $guest = $request-> tfAway;
        $guestID = $this->getTeamID($guest);
        #$id = $request -> match;
        $set = DB::connection('mysqlSP')->table(('spiel'))
        ->where(DB::connection('mysqlSP')->raw('ID'), [$id])
        ->update([  'Ort'=>$place,
                    'Heim'=>$homeID,
                    'Gast'=>$guestID]);
    }

    public function updateSoloDuel($id, Request $request)
    {
        //IDs der Spieler werden benoetigt
        $hPlayerFirst = $request->soloVnameHeim1;
        $hPlayerLast = $request ->soloNnameHeim1;
        $gPlayerFirst = $request ->soloVnameGast1;
        $gPlayerLast = $request ->soloVnameGastname2;
        $homeID = $this ->getPlayerID($hPlayerFirst, $hPlayerLast);
        $guestID = $this ->getPlayerID($gPlayerFirst, $gPlayerLast);
        //Update in EinzelTabelle
        $set = DB::connection('mysqlSP')->table(('einzel'))
        ->where(DB::connection('mysqlSP')->raw('Duell_ID'), [$id])
        ->update([
            'Spieler_Heim'=>$homeID,
            'Spieler_Gast'=>$guestID]);
    }

#----------------------------------Suggestions-------------------------------------------------------------


    public function index()
    {
        return view('check_report');
    }
 
    public static function autocompleteSearch(Request $request)
    {
          $query = $request->get('query');
          $filterResult = DB::connection('mysqlSP')->select('SELECT Name from liga where Name LIKE "$query"');
          
          
          return response()->json($filterResult);
    } 

    public static function alleLigen()
    {
        $ligen =DB::connection('mysqlSP')->select('SELECT * from liga');
        return $ligen;
    }
    public static function LigaID($name) // first
    {
        //$liga =DB::selec*t("SELECT * from liga where name Like '%$teilname%' ");
        //return $liga;

        $liga = DB::connection('mysqlSP')->table('liga')
        ->where('name',$name)
        ->first();
        return $liga;

    }
    

   
    public static function alleLigen2(Request $request){
        $search = $request->search;
            $ligen = DB::connection('mysqlSP')->table('liga')->select('ID','Name')->where('name', 'like', '%' .$search . '%')  ->get();
            
        
              $response = array();
              foreach($ligen as $liga){
                 $response[] = array("ID"=>$liga->ID,"Name"=>$liga->Name);
              }
        
              return response()->json($response); 
           } 
        
        
           public static function alleMannschaften(Request $request){
            
           
           $search = $request->search;
           $liga = $request->liga;
           $rliga = DB::connection('mysqlSP')->table('liga')->select('ID')->where('name', '=', $liga)  ->first();
           //DB::select("SELECT ID from liga where name = '$liga' ");
           $test = $rliga ->ID;
           $mannschaften = DB::connection('mysqlSP')->table('mannschaft')->select('ID','Name')->where('liga', '=', $test  ) ->where('name', 'like', '%' .$search . '%')  ->get();
           //DB::select("SELECT * from Mannschaften where liga == '$rliga' ");   
           //
           
        
             $response = array();
             foreach($mannschaften as $mannschaft){
                $response[] = array("ID"=>$mannschaft->ID,"Name"=>$mannschaft->Name);
             }
        
             return response()->json($response); 
          } 
        
    }
    

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QueryController extends Controller
{
    //QUERIES TO SELECT MATCH
    public static function getSpiele()
    {
        $spiele = DB::connection('mysqlSP')->select('SELECT
            s.ID,
            s.termin as "Termin",
            m.name as "Heim",
            m2.name as "Gast",
            sp.id,
            sp.vorname,
            sp.nachname,
            s.status
        FROM
            spieler sp2,spiel s
            LEFT JOIN mannschaft m2 on m2.id = s.gast
            LEFT JOIN mannschaft m on m.id = s.heim
            LEFT JOIN spieler sp on sp.id = m.Kapitaen_ID
        WHERE
            sp2.id = sp.id and s.status !=1;');

        return $spiele;
    }

    public static function getSpieleOk() // nur spiele mit status =1

    {
        $spiele = DB::connection('mysqlSP')->select('SELECT
            s.ID,
            s.termin as "Termin"
            ,m.name as "Heim",
            m2.name as "Gast",
            sp.id,
            sp.vorname,
            sp.nachname,
            s.status
         FROM
            spieler sp2,spiel s
            LEFT JOIN mannschaft m2 on m2.id = s.gast
            LEFT JOIN mannschaft m on m.id = s.heim
            LEFT JOIN spieler sp on sp.id = m.Kapitaen_ID
         WHERE
            sp2.id = sp.id and s.status =1;');

        return $spiele;
    }
    public static function getAlleMannschaften() // nur spiele mit status =1

    {
        $mannschaften = DB::connection('mysqlSP')->select('SELECT
            m.id as "ID",
            m.name as "Mannschaft",
            sp.vorname,
            sp.nachname,
            v.Name as "Verein",
            l.name as "Liga"
        FROM
            mannschaft m,spieler sp, verein v, liga l
        WHERE
            m.Kapitaen_ID = sp.ID and m.Verein_ID = v.ID and m.liga = l.ID;');

        return $mannschaften;
    }
    public static function getAlleSpieler()
    {
        $spieler = DB::connection('mysqlSP')->select('SELECT
            s.id as "ID",
            s.Vorname as "Vorname",
            s.Nachname as "Nachname",
            s.Geschlecht as "Geschlecht",
            group_concat(m.name) as "Mannschaften"
        FROM
            spieler_mannschaft sm
        LEFT JOIN spieler s ON s.ID = sm.Spieler_ID
        LEFT JOIN mannschaft m on m.id = sm.Mannschaft_ID
        GROUP BY s.id');

        return $spieler;
    }
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
    public static function getLiga($id)
    {
        $liga = DB::connection('mysqlSP')->table(DB::raw('spiel s, liga l'))
            ->where(DB::connection('mysqlSP')->raw('s.liga = l.id and s.ID'), [$id])
            ->first();
        return $liga;
    }
    public static function getHome($id)
    {
        //$home = DB::select('select m.name from spiel s,mannschaft m where s.Heim = m.Verein_ID and s.ID = ?', [$id]);
        $home = DB::connection('mysqlSP')->table(DB::raw('spiel s, mannschaft m'))
            ->where(DB::connection('mysqlSP')->raw('s.Heim = m.Verein_ID and s.ID'), [$id])
            ->first();
        return $home;
    }
    public static function getAway($id)
    {
        $away = DB::connection('mysqlSP')->table(DB::raw('spiel s, mannschaft m'))
            ->where(DB::connection('mysqlSP')->raw('s.Gast = m.Verein_ID and s.ID'), [$id])
            ->first();
        return $away;
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
        $name = DB::connection('mysqlSP')->select('SELECT s.Vorname, s.Nachname FROM einzel e LEFT JOIN spieler s ON e.spieler_Heim = s.ID or e.spieler_Gast = s.ID');
        return $name;
    }
    public static function getNamesDouble($duellID)
    {
        //Names is an Arry full of Objects. To gather an Value, first get the index and than the Value
        /* $names = DB::table(DB::raw('duell du, doppel dp, spieler s'))
        ->where(DB::raw('dp.Spieler_Heim_1= s.ID and dp.Duell_ID =2'))
        ->pluck('Vorname');
        return $names;*/
        $name = DB::connection('mysqlSP')->select('SELECT s.Vorname, s.Nachname FROM doppel d LEFT JOIN spieler s ON d.spieler_Heim_1 = s.ID  or d.spieler_Heim_2 = s.ID or d.spieler_Gast_1 = s.ID  or d.spieler_Gast_2 = s.ID');
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
            s1.ID AS "ID_S1", s1.vorname AS "Vorname_S1", s1.nachname AS "Nachname_S1",								#Name Spieler 1
            s2.ID AS "ID_S2", s2.vorname AS "Vorname_S2", s2.nachname AS "Nachname_S2",								#Name Spieler 2
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
        WHERE d.id IN (e.duell_ID) and sa1.Satz_Nr =1 and sa2.Satz_Nr =2 and sa3.Satz_Nr =3  and d.Spiel_ID = ?', [$id]); #Spiel ID wird in Funktion als Parameter uebertragen, um Spiele zu unterscheiden Um Einzelspiele zu filtern wird nach IDs in Einzel gesucht
        return $duell;
    }

    public static function getDouble($id)
    {
        $duell = DB::connection('mysqlSP')->select('SELECT
            d.id AS "Duell-ID",																		#ID des eingetlichen Duells
            a.name AS "Duellart",																	#Duell Art: Doppel, Einzel, Herren,Damen, Gemischt
            s1h.ID as "ID_S1_H", s1h.vorname AS "Vorname_S1_H", s1h.nachname AS "Nachname_S1_H",								#Name Spieler 1 Heim
            s2h.ID as "ID_S2_H", s2h.vorname AS "Vorname_S2_H", s2h.nachname AS "Nachname_S2_H",								#Name Spieler 2 Heim
            s1g.ID as "ID_S1_G", s1g.vorname AS "Vorname_S1_G", s1g.nachname AS "Nachname_S1_G",								#Name Spieler 1 Gast
            s2g.ID as "ID_S2_G", s2g.vorname AS "Vorname_S2_G", s2g.nachname AS "Nachname_S2_G",								#Name Spieler 2 Gast
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
        WHERE d.id IN (dp.duell_ID) and sa1.Satz_Nr =1 and sa2.Satz_Nr =2 and sa3.Satz_Nr =3 and d.Spiel_ID = ?', [$id]); #Spiel ID wird in Funktion als Parameter uebertragen, um Spiele zu unterscheiden Um Doppelspiele zu filtern wird nach IDs in Einzel gesucht

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
            ->where('name', $name)
            ->first();
        return $team->ID;
    }
    private function getPlayerID($firstname, $lastname)
    {
        $player = DB::connection('mysqlSP')->table('spieler')
            ->where([['Vorname', '=', $firstname], ['Nachname', '=', $lastname]])
            ->first();
        return $player->ID;
    }
    #Eigetnliche Updatefunktionen
    public function updateMatch(Request $request)
    {
        $id = $request->matchID;
        $state = $request->rbState;
        if ($state == "true") {
            $place = $request->tfPlace;
            $home = $request->tfHome;
            $homeID = $this->getTeamID($home);
            $guest = $request->tfAway;
            $guestID = $this->getTeamID($guest);
            #$id = $request -> match;
            $set = DB::connection('mysqlSP')->table(('spiel'))
                ->where(DB::connection('mysqlSP')->raw('ID'), [$id])
                ->update(['Ort' => $place,
                    'Heim' => $homeID,
                    'Gast' => $guestID]);
            $this->updateSoloDuel($id, $request);
            $this->setAccepted($id);
        } else {
            $this->setDeclined($id);
        }
    }

    private function setDeclined($id)
    {
        $state = DB::connection('mysqlSP')->table(('spiel'))
            ->where(DB::connection('mysqlSP')->raw('ID'), [$id])
            ->update(['Status' => 2]);
    }
    private function setAccepted($id)
    {
        $state = DB::connection('mysqlSP')->table(('spiel'))
            ->where(DB::connection('mysqlSP')->raw('ID'), [$id])
            ->update(['Status' => 1]);
    }

    public function updateSoloDuel($id, Request $request)
    {
        //Um keine null-werte einzutragen, wird erst die Anzahl der Reihen benoetigt
        $soloCount = $request->soloCount;
        //IDs der Spieler werden benoetigt
        if ($soloCount >= 1) {
            $duellID1 = $request->duellID1;
            $homeFName1 = $request->soloVnameHeim1;
            $homeLName1 = $request->soloNnameHeim1;
            $guestFName1 = $request->soloVnameGast1;
            $guestLName1 = $request->soloNnameGast1;
            $homePID1 = $this->getPlayerID($homeFName1, $homeLName1);
            $guestPID1 = $this->getPlayerID($guestFName1, $guestLName1);
            $satz1H1 = $request->soloSatz1heim1;
            $satz1G1 = $request->soloSatz1gast1;
            $satz2H1 = $request->soloSatz2heim1;
            $satz2G1 = $request->soloSatz2gast1;
            $satz3H1 = $request->soloSatz3heim1;
            $satz3G1 = $request->soloSatz3gast1;

            DB::connection('mysqlSP')->table('einzel')
                ->where('Duell_ID', $duellID1)
                ->update(['Spieler_Heim' => $homePID1,
                    'Spieler_Gast' => $guestPID1],
                    '');
            DB::connection('mysqlSP')->table('satz')
                ->where([['Duell_ID', '=', $duellID1], ['Satz_Nr', '=', 1]])
                ->update(['Punkte_Heim' => $satz1H1,
                    'Punkte_Gast' => $satz1G1]);
            DB::connection('mysqlSP')->table('satz')
                ->where([['Duell_ID', '=', $duellID1], ['Satz_Nr', '=', 2]])
                ->update(['Punkte_Heim' => $satz2H1,
                    'Punkte_Gast' => $satz2G1]);
            DB::connection('mysqlSP')->table('satz')
                ->where([['Duell_ID', '=', $duellID1], ['Satz_Nr', '=', 3]])
                ->update(['Punkte_Heim' => $satz3H1,
                    'Punkte_Gast' => $satz3G1]);
        }
        if ($soloCount >= 2) {
            $duellID2 = $request->duellID2;
            $homeFName2 = $request->soloVnameHeim2;
            $homeLName2 = $request->soloNnameHeim2;
            $guestFName2 = $request->soloVnameGast2;
            $guestLName2 = $request->soloNnameGast2;
            $homePID2 = $this->getPlayerID($homeFName2, $homeLName2);
            $guestPID2 = $this->getPlayerID($guestFName2, $guestLName2);
            $satz1H2 = $request->soloSatz1heim2;
            $satz1G2 = $request->soloSatz1gast2;
            $satz2H2 = $request->soloSatz2heim2;
            $satz2G2 = $request->soloSatz2gast2;
            $satz3H2 = $request->soloSatz3heim2;
            $satz3G2 = $request->soloSatz3gast2;

            DB::connection('mysqlSP')->table('einzel')
                ->where('Duell_ID', $duellID2)
                ->update(['Spieler_Heim' => $homePID2,
                    'Spieler_Gast' => $guestPID2],
                    '');
            DB::connection('mysqlSP')->table('satz')
                ->where([['Duell_ID', '=', $duellID2], ['Satz_Nr', '=', 1]])
                ->update(['Punkte_Heim' => $satz1H2,
                    'Punkte_Gast' => $satz1G2]);
            DB::connection('mysqlSP')->table('satz')
                ->where([['Duell_ID', '=', $duellID2], ['Satz_Nr', '=', 2]])
                ->update(['Punkte_Heim' => $satz2H2,
                    'Punkte_Gast' => $satz2G2]);
            DB::connection('mysqlSP')->table('satz')
                ->where([['Duell_ID', '=', $duellID2], ['Satz_Nr', '=', 3]])
                ->update(['Punkte_Heim' => $satz3H2,
                    'Punkte_Gast' => $satz3G2]);
        }
        if ($soloCount >= 3) {
            $duellID3 = $request->duellID3;
            $homeFName3 = $request->soloVnameHeim3;
            $homeLName3 = $request->soloNnameHeim3;
            $guestFName3 = $request->soloVnameGast3;
            $guestLName3 = $request->soloNnameGast3;
            $homePID3 = $this->getPlayerID($homeFName3, $homeLName3);
            $guestPID3 = $this->getPlayerID($guestFName3, $guestLName3);
            $satz1H3 = $request->soloSatz1heim3;
            $satz1G3 = $request->soloSatz1gast3;
            $satz2H3 = $request->soloSatz2heim3;
            $satz2G3 = $request->soloSatz2gast3;
            $satz3H3 = $request->soloSatz3heim3;
            $satz3G3 = $request->soloSatz3gast3;

            DB::connection('mysqlSP')->table('einzel')
                ->where('Duell_ID', $duellID3)
                ->update(['Spieler_Heim' => $homePID3,
                    'Spieler_Gast' => $guestPID3],
                    '');
            DB::connection('mysqlSP')->table('satz')
                ->where([['Duell_ID', '=', $duellID3], ['Satz_Nr', '=', 1]])
                ->update(['Punkte_Heim' => $satz1H3,
                    'Punkte_Gast' => $satz1G3]);
            DB::connection('mysqlSP')->table('satz')
                ->where([['Duell_ID', '=', $duellID3], ['Satz_Nr', '=', 2]])
                ->update(['Punkte_Heim' => $satz2H3,
                    'Punkte_Gast' => $satz2G3]);
            DB::connection('mysqlSP')->table('satz')
                ->where([['Duell_ID', '=', $duellID3], ['Satz_Nr', '=', 3]])
                ->update(['Punkte_Heim' => $satz3H3,
                    'Punkte_Gast' => $satz3G3]);
        }
        if ($soloCount >= 4) {
            $duellID4 = $request->duellID4;
            $homeFName4 = $request->soloVnameHeim4;
            $homeLName4 = $request->soloNnameHeim4;
            $guestFName4 = $request->soloVnameGast4;
            $guestLName4 = $request->soloNnameGast4;
            $homePID4 = $this->getPlayerID($homeFName4, $homeLName4);
            $guestPID4 = $this->getPlayerID($guestFName4, $guestLName4);
            $satz1H4 = $request->soloSatz1heim4;
            $satz1G4 = $request->soloSatz1gast4;
            $satz2H4 = $request->soloSatz2heim4;
            $satz2G4 = $request->soloSatz2gast4;
            $satz3H4 = $request->soloSatz3heim4;
            $satz3G4 = $request->soloSatz3gast4;

            DB::connection('mysqlSP')->table('einzel')
                ->where('Duell_ID', $duellID4)
                ->update(['Spieler_Heim' => $homePID4,
                    'Spieler_Gast' => $guestPID4],
                    '');
            DB::connection('mysqlSP')->table('satz')
                ->where([['Duell_ID', '=', $duellID4], ['Satz_Nr', '=', 1]])
                ->update(['Punkte_Heim' => $satz1H4,
                    'Punkte_Gast' => $satz1G4]);
            DB::connection('mysqlSP')->table('satz')
                ->where([['Duell_ID', '=', $duellID4], ['Satz_Nr', '=', 2]])
                ->update(['Punkte_Heim' => $satz2H4,
                    'Punkte_Gast' => $satz2G4]);
            DB::connection('mysqlSP')->table('satz')
                ->where([['Duell_ID', '=', $duellID4], ['Satz_Nr', '=', 3]])
                ->update(['Punkte_Heim' => $satz3H4,
                    'Punkte_Gast' => $satz3G4]);
        }

        //Update in EinzelTabelle

    }

#----------------------------------Suggestions-------------------------------------------------------------

#Roman
    #Rueckgabe aller Ligen einer Region die im Parameter bestimmt wird
    public static function allLeagues($region)
    {
        $result = DB::connection('mysqlSP')->select('SELECT * from liga WHERE Region = ?', [$region]);
        return $result;
    }
    #Rueckgabe aller Spieltypen fuer Vorschlagsliste
    public static function allTypes()
    {
        $result = DB::connection('mysqlSP')->select('SELECT * from art');
        return $result;
    }
#Roman-Ende
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
        $ligen = DB::connection('mysqlSP')->select('SELECT * from liga');
        return $ligen;
    }
    public static function LigaID($name) // first

    {
        //$liga =DB::selec*t("SELECT * from liga where name Like '%$teilname%' ");
        //return $liga;

        $liga = DB::connection('mysqlSP')->table('liga')
            ->where('name', $name)
            ->first();
        return $liga;

    }

    public static function alleLigen2(Request $request)
    {
        $search = $request->search;
        $ligen = DB::connection('mysqlSP')->table('liga')->select('ID', 'Name')->where('name', 'like', '%' . $search . '%')->get();

        $response = array();
        foreach ($ligen as $liga) {
            $response[] = array("ID" => $liga->ID, "Name" => $liga->Name);
        }

        return response()->json($response);
    }

    public static function alleMannschaften(Request $request)
    {

        $search = $request->search;
        $liga = $request->liga;
        $rliga = DB::connection('mysqlSP')->table('liga')->select('ID')->where('name', '=', $liga)->first();
        //DB::select("SELECT ID from liga where name = '$liga' ");
        $test = $rliga->ID;
        $mannschaften = DB::connection('mysqlSP')->table('mannschaft')->select('ID', 'Name')->where('liga', '=', $test)->where('name', 'like', '%' . $search . '%')->get();
        //DB::select("SELECT * from Mannschaften where liga == '$rliga' ");
        //

        $response = array();
        foreach ($mannschaften as $mannschaft) {
            $response[] = array("ID" => $mannschaft->ID, "Name" => $mannschaft->Name);
        }

        return response()->json($response);
    }

}

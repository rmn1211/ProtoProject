<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QueryController extends Controller
{
    //_____________________________________________Mannschaften____________________________________________

    //overview: Alle eingerichten, nicht ueberprueften Spieleberichte
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
            sp2.id = sp.id and s.status != :mStatus', ['mStatus' => 1]);

        return $spiele;
    }

    //match_ok: Alle ueberprueften Spieleberichte
    public static function getSpieleOk()
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
            sp2.id = sp.id and s.status = :mStatus', ['mStatus' => 1]);

        return $spiele;
    }

    //teams_table: Auflistung aller Mannschaften in DB
    public static function getAlleMannschaften()
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
            m.Kapitaen_ID = sp.ID and m.Verein_ID = v.ID and m.liga = l.ID Order by l.name ASC;');

        return $mannschaften;
    }

    //teams_table: Auflistung aller Mannschaften die in der selben Region sind
    public static function getRegionMannschaften($region)
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
            m.Kapitaen_ID = sp.ID and m.Verein_ID = v.ID and m.liga = l.ID and  l.region = :region', ['region' => $region]);

        return $mannschaften;
    }

    //teams_table: Auflistung aller Mannschaften die in selber Liga spielen
    public static function getMannschaften($liga)
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
            m.Kapitaen_ID = sp.ID and m.Verein_ID = v.ID and m.liga = l.ID and l.ID = :liga', ['liga' => $liga]);

        return $mannschaften;
    }
    //_____________________________________________Spieler____________________________________________

    //player_table: Auflistung aller Spieler in der DB
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

    //player_table: Auflistung aller Spieler in selber Region
    public static function getRegionSpieler($region)
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
        Left join liga l on l.id = m.liga
        WHERE
            l.region = :region
        GROUP BY s.id', ['region' => $region]);

        return $spieler;
    }

    //player_table: Auflistung aller Spieler in selber Liga
    public static function getLigaSpieler($liga)
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
        WHERE
            m.liga = :liga
        GROUP BY s.id', ['liga' => $liga]);

        return $spieler;
    }

    //player_table: Auflistung aller Spieler eines Teams
    public static function getSpieler($team)
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
        LEFT JOIN mannschaft m ON m.id = sm.Mannschaft_ID
        WHERE
            m.id = :team
        GROUP BY s.id', ['team' => $team]);

        return $spieler;
    }

    //_____________________________________________Berichte____________________________________________

    //see_report, check_report: Liga in der das anzuzeigende Spiel stattfindet
    public static function getLiga($match)
    {
        $liga = DB::connection('mysqlSP')->select('SELECT
            *
        FROM
            spiel s, liga l
        WHERE
            s.liga = l.id AND s.id = :match', ['match' => $match]);

        return $liga[0];
    }

    //see_report, check_report: Region in der Sich die Liga des befindet
    public static function getRegion($liga)
    {
        $region = DB::connection('mysqlSP')->select('SELECT
            r.name, r.ID
        FROM
            region r, liga l
        WHERE
            l.region = r.id AND l.ID = :id', ['id' => $liga]);

        return $region[0];
    }

    //see_report, check_report: Informationen des Spiels, die nicht im Duell gespeichert werden
    public static function getSingleMatch($match)
    {
        $match = DB::connection('mysqlSP')->select('SELECT
            mH.ID as HeimID,
            mH.Name as Heim,
            mG.ID as GastID,
            mG.Name as Gast,
            s.Schiedsrichter as Schiedsrichter,
            s.Ort as Spielort
        FROM
            spiel s
        LEFT JOIN mannschaft mH ON s.Heim = mH.ID
        LEFT JOIN mannschaft mG ON s.Gast = mG.ID
        WHERE
            s.ID = :id', ['id' => $match]);

        return $match[0];
    }

    //see_report, check_report: Informationen aller Einzelspiele
    public static function getSolo($match)
    {
        $duell = DB::connection('mysqlSP')->select('SELECT
            d.id AS "Duell_ID",																	#ID des eingetlichen Duells
            a.name AS "Duellart",																#Duell Art: Doppel, Einzel, Herren,Damen, Gemischt
            s1.ID AS "ID_S1", s1.vorname AS "Vorname_S1", s1.nachname AS "Nachname_S1",			#Name Spieler 1
            s2.ID AS "ID_S2", s2.vorname AS "Vorname_S2", s2.nachname AS "Nachname_S2",			#Name Spieler 2
            sa1.Punkte_Heim AS "Satz_1_Heim", sa1.Punkte_Gast AS "Satz_1_Gast",					#Punkte im 1. Satz
            sa2.Punkte_Heim AS "Satz_2_Heim", sa2.Punkte_Gast AS "Satz_2_Gast",					#Punkte im 2. Satz
            sa3.Punkte_Heim AS "Satz_3_Heim", sa3.Punkte_Gast AS "Satz_3_Gast",					#Punkte im 3. Satz
            sa1.Punkte_Heim + sa2.Punkte_Heim + sa3.Punkte_Heim AS "Heim_Gesamt",				#Gesamtpunktzahl Heimmannschaft
            sa1.Punkte_Gast + sa2.Punkte_Gast + sa3.Punkte_Gast AS "Gast_Gesamt",				#Gesamtpunktzahl Gastmannschaft
            d.heim_saetze AS "Gewonnene_Sätze_Heim", d.gast_saetze AS "Gewonnene_Sätze_Gast",	#Gewonnene Sätze
            d.heim_spiele AS "Gewonnene_Spiele_Heim", d.gast_spiele AS "Gewonnene_Spiele_Gast"	#Gewonnene Spiele
        FROM
            duell d
	    LEFT JOIN  art a ON a.id = d.art
	    LEFT JOIN einzel e ON e.Duell_ID = d.ID
	    LEFT JOIN spieler s1 ON e.Spieler_Heim = s1.ID
	    LEFT JOIN spieler s2 ON e.Spieler_Gast = s2.id
        LEFT JOIN  satz sa1 ON sa1.Duell_ID = d.id
        LEFT JOIN  satz sa2 ON sa2.Duell_ID = d.id
        LEFT JOIN  satz sa3 ON sa3.Duell_ID = d.id
        WHERE
            d.id IN (e.duell_ID) AND sa1.Satz_Nr = 1 AND sa2.Satz_Nr = 2 AND sa3.Satz_Nr = 3  AND d.Spiel_ID = :id', ['id' => $match]); #Spiel ID wird in Funktion als Parameter uebertragen, um Spiele zu unterscheiden Um Einzelspiele zu filtern wird nach IDs in Einzel gesucht

        return $duell;
    }

    //see_report, check_report: Informationen aller Doppelspiele
    public static function getDouble($match)
    {
        $duell = DB::connection('mysqlSP')->select('SELECT
            d.id AS "Duell_ID",																		#ID des eingetlichen Duells
            a.name AS "Duellart",																	#Duell Art: Doppel, Einzel, Herren,Damen, Gemischt
            s1h.ID as "ID_S1_H", s1h.vorname AS "Vorname_S1_H", s1h.nachname AS "Nachname_S1_H",	#Name Spieler 1 Heim
            s2h.ID as "ID_S2_H", s2h.vorname AS "Vorname_S2_H", s2h.nachname AS "Nachname_S2_H",	#Name Spieler 2 Heim
            s1g.ID as "ID_S1_G", s1g.vorname AS "Vorname_S1_G", s1g.nachname AS "Nachname_S1_G",    #Name Spieler 1 Gast
            s2g.ID as "ID_S2_G", s2g.vorname AS "Vorname_S2_G", s2g.nachname AS "Nachname_S2_G",	#Name Spieler 2 Gast
            sa1.Punkte_Heim AS "Satz_1_Heim", sa1.Punkte_Gast AS "Satz_1_Gast",					    #Punkte im 1. Satz
            sa2.Punkte_Heim AS "Satz_2_Heim", sa2.Punkte_Gast AS "Satz_2_Gast",					    #Punkte im 2. Satz
            sa3.Punkte_Heim AS "Satz_3_Heim", sa3.Punkte_Gast AS "Satz_3_Gast",					    #Punkte im 3. Satz
            sa1.Punkte_Heim + sa2.Punkte_Heim + sa3.Punkte_Heim AS "Heim_Gesamt",					#Gesamtpunktzahl Heimmannschaft
            sa1.Punkte_Gast + sa2.Punkte_Gast + sa3.Punkte_Gast AS "Gast_Gesamt",					#Gesamtpunktzahl Gastmannschaft
            d.heim_saetze AS "Gewonnene_Sätze_Heim", d.gast_saetze AS "Gewonnene_Sätze_Gast",		#Gewonnene Sätze
            d.heim_spiele AS "Gewonnene_Spiele_Heim", d.gast_spiele AS "Gewonnene_Spiele_Gast"	    #Gewonnene Spiele
        FROM
            duell d
	    LEFT JOIN  art a ON a.id = d.art
	    LEFT JOIN doppel dp ON dp.Duell_ID = d.ID
	    LEFT JOIN spieler s1h ON dp.Spieler_Heim_1 = s1h.ID
	    LEFT JOIN spieler s2h ON dp.Spieler_Heim_2 = s2h.id
        LEFT JOIN spieler s1g ON dp.Spieler_Gast_1 = s1g.ID
	    LEFT JOIN spieler s2g ON dp.Spieler_Gast_2 = s2g.id
        LEFT JOIN  satz sa1 ON sa1.Duell_ID = d.id
        LEFT JOIN  satz sa2 ON sa2.Duell_ID = d.id
        LEFT JOIN  satz sa3 ON sa3.Duell_ID = d.id
        WHERE
            d.id IN (dp.duell_ID) AND sa1.Satz_Nr = 1 AND sa2.Satz_Nr = 2 AND sa3.Satz_Nr = 3 AND d.Spiel_ID = :id', ['id' => $match]); #Spiel ID wird in Funktion als Parameter uebertragen, um Spiele zu unterscheiden Um Doppelspiele zu filtern wird nach IDs in Einzel gesucht

        return $duell;
    }

    //see_report, check_report: Spieltag einer Runde
    public static function getTag($match)
    {
        $tag = DB::connection('mysqlSP')->select('SELECT
            t.ID, t.Tag AS "Tag"
        FROM
            spiel s, spieltag t
        WHERE
            s.spieltag=t.id AND s.ID = :id', ['id' => $match]);

        return $tag;
    }

    //see_report, check_report: Runde eines Spieltages
    public static function getRunde($tag)
    {
        $runde = DB::connection('mysqlSP')->select('SELECT
            r.ID, r.Bezeichnung
        FROM
            runde r, spieltag t
        WHERE
            t.ID =1 AND t.Tag=r.ID = :id', ['id' => $tag]);

        return $runde;
    }

    //see_report, check_report: Saison einer Runde
    public static function getSaison($runde)
    {
        $saison = DB::connection('mysqlSP')->select('SELECT
            s.ID, s.Name
         FROM
            runde r, saison s
         WHERE
            r.ID =1 AND r.Saison=s.ID = :id', ['id' => $runde]);

        return $saison;
    }

    //_____________________________________________Texterkennung Korrektur____________________________________________

    //control_handwriting: Bezeichnung einer Mannschaft anhand der ID
    public static function getMannschaftName($id)
    {
        $team = DB::connection('mysqlSP')->select('SELECT
            m.Name
        FROM
            mannschaft m
        WHERE
            m.ID = :id', ['id' => $id]);

        return $team;
    }

    //control_handwriting: Spielername anhand der ID
    public static function getSpielerName($id)
    {
        $player = DB::connection('mysqlSP')->select('SELECT
            s.Vorname, s.Nachname
        FROM
            spieler s
        WHERE
            s.ID = :id', ['id' => $id]);

        return $player;
    }

    //   ----------------------------Insert----------------------------
    public function insertMatch(Request $request)
    {

        $place = $request->tfPlace;
        $home = $request->tfHome;
        $homeID = $this->getTeamID($home);
        $guest = $request->tfAway;
        $guestID = $this->getTeamID($guest);
        $day = $request->tagID;
        $date = date('Y-m-d');
        $ligaID = $request->ligaID;
        $schiri = $request->schiri;
        $status = 0;

        #$id = $request -> match;
        DB::connection('mysqlSP')->table(('spiel'))
            ->insert([
                'Termin' => $date,
                'Spieltag' => $day,
                'Ort' => $place,

                'Heim' => $homeID,
                'Gast' => $guestID,
                'Status' => $status,
                'Liga' => $ligaID,
                'Schiedsrichter' => $schiri,

            ]);
        $id = DB::connection('mysqlSP')->table(('spiel'))->select('ID')->where('Termin', $date)->where('Liga', $ligaID)->where('Heim', $homeID)->where('Gast', $guestID)->latest('ID')->first();
        $this->insertSoloDuelTest($id, $request);
        $this->insertSoloDuel($id, $request);
        $this->insertDoubleDuel($id, $request);
        //    $this->setAccepted($id);
        return redirect('/upload');

    }
    public function insertSoloDuelTest($id, Request $request)
    {
        $soloCount = $request->soloCount;
        for ($i = 1; $i <= $soloCount; $i++) {
            $homeFName1 = $request->soloVnameHeim1 . $i;
            error_log($homeFName1);
        }
    }
    public function insertSoloDuel($id, Request $request)
    {
        //Um keine null-werte einzutragen, wird erst die Anzahl der Reihen benoetigt
        $soloCount = $request->soloCount;

        //IDs der Spieler werden benoetigt
        if ($soloCount >= 1) {
            $soloType1 = $request->soloType1;
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
            $soloSetpointHeim1 = $request->soloSetpointHeim1;
            $soloSetpointGast1 = $request->soloSetpointGast1;
            $soloWonSetHeim1 = $request->soloWonSetHeim1;
            $soloWonSetGast1 = $request->soloWonSetGast1;
            $soloWonMatchHeim1 = $request->soloWonMatchHeim1;
            $soloWonMatchGast1 = $request->soloWonMatchGast1;
            $art = DB::connection('mysqlSP')->table('art')
                ->select('ID')->where('Name', $soloType1)->value('ID');

            DB::connection('mysqlSP')->table('duell')
                ->insert([
                    'Spiel_ID' => $id->ID,
                    'Art' => $art,
                    'Heim_Spiele' => $soloSetpointHeim1,
                    'Gast_Spiele' => $soloSetpointGast1,
                    'Heim_Saetze' => $soloWonSetHeim1,
                    'Gast_Saetze' => $soloWonSetGast1,
                    'Heim_Punkte' => $soloWonMatchHeim1,
                    'Gast_Punkte' => $soloWonMatchGast1,
                ]);

            $singleID = DB::connection('mysqlSP')->table('duell')->select('ID')
                ->where('Spiel_ID', $id->ID)
                ->where('Art', $art)
                ->latest('ID')->first();

            DB::connection('mysqlSP')->table('einzel')
                ->insert(['Duell_ID' => $singleID->ID, 'Spieler_Heim' => $homePID1,
                    'Spieler_Gast' => $guestPID1],
                );

            DB::connection('mysqlSP')->table('satz')
            //  ->where([['Duell_ID', '=', $duellID1], ['Satz_Nr', '=', 1]])
                ->insert(['Punkte_Heim' => $satz1H1,
                    'Satz_Nr' => 1,
                    'Duell_ID' => $singleID->ID,
                    'Punkte_Gast' => $satz1G1]);

            DB::connection('mysqlSP')->table('satz')
                ->insert(['Duell_ID' => $singleID->ID,
                    'Satz_Nr' => 2,
                    'Punkte_Heim' => $satz2H1,
                    'Punkte_Gast' => $satz2G1]);
            DB::connection('mysqlSP')->table('satz')
                ->insert(['Duell_ID' => $singleID->ID,
                    'Satz_Nr' => 3,
                    'Punkte_Heim' => $satz3H1,
                    'Punkte_Gast' => $satz3G1]);
        }
        if ($soloCount >= 2) {

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
            $soloType2 = $request->soloType2;
            $soloSetpointHeim2 = $request->soloSetpointHeim2;
            $soloSetpointGast2 = $request->soloSetpointGast2;
            $soloWonSetHeim2 = $request->soloWonSetHeim2;
            $soloWonSetGast2 = $request->soloWonSetGast2;
            $soloWonMatchHeim2 = $request->soloWonMatchHeim2;
            $soloWonMatchGast2 = $request->soloWonMatchGast2;
            $art = DB::connection('mysqlSP')->table('art')
                ->select('ID')->where('Name', $soloType2)->value('ID');

            DB::connection('mysqlSP')->table('duell')
                ->insert([
                    'Spiel_ID' => $id->ID,
                    'Art' => $art,
                    'Heim_Spiele' => $soloSetpointHeim2,
                    'Gast_Spiele' => $soloSetpointGast2,
                    'Heim_Saetze' => $soloWonSetHeim2,
                    'Gast_Saetze' => $soloWonSetGast2,
                    'Heim_Punkte' => $soloWonMatchHeim2,
                    'Gast_Punkte' => $soloWonMatchGast2,
                ]);
            $singleID = DB::connection('mysqlSP')->table('duell')->select('ID')
                ->where('Spiel_ID', $id->ID)
                ->where('Art', $art)
                ->latest('ID')->first();

            DB::connection('mysqlSP')->table('einzel')
                ->insert(['Duell_ID' => $singleID->ID, 'Spieler_Heim' => $homePID2,
                    'Spieler_Gast' => $guestPID2],
                );

            DB::connection('mysqlSP')->table('satz')
            //  ->where([['Duell_ID', '=', $duellID1], ['Satz_Nr', '=', 1]])
                ->insert(['Duell_ID' => $singleID->ID, 'Satz_Nr' => 1,
                    'Punkte_Heim' => $satz1H2,
                    'Punkte_Gast' => $satz1G2]);

            DB::connection('mysqlSP')->table('satz')
                ->insert(['Duell_ID' => $singleID->ID,
                    'Satz_Nr' => 2,
                    'Punkte_Heim' => $satz2H2,
                    'Punkte_Gast' => $satz2G2]);
            DB::connection('mysqlSP')->table('satz')
                ->insert(['Duell_ID' => $singleID->ID,
                    'Satz_Nr' => 3,
                    'Punkte_Heim' => $satz3H2,
                    'Punkte_Gast' => $satz3G2]);

        }
        if ($soloCount >= 3) {

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
            $soloType3 = $request->soloType3;
            $soloSetpointHeim3 = $request->soloSetpointHeim3;
            $soloSetpointGast3 = $request->soloSetpointGast3;
            $soloWonSetHeim3 = $request->soloWonSetHeim3;
            $soloWonSetGast3 = $request->soloWonSetGast3;
            $soloWonMatchHeim3 = $request->soloWonMatchHeim3;
            $soloWonMatchGast3 = $request->soloWonMatchGast3;
            $art = DB::connection('mysqlSP')->table('art')
                ->select('ID')->where('Name', $soloType3)->value('ID');

            DB::connection('mysqlSP')->table('duell')
                ->insert([
                    'Spiel_ID' => $id->ID,
                    'Art' => $art,
                    'Heim_Spiele' => $soloSetpointHeim3,
                    'Gast_Spiele' => $soloSetpointGast3,
                    'Heim_Saetze' => $soloWonSetHeim3,
                    'Gast_Saetze' => $soloWonSetGast3,
                    'Heim_Punkte' => $soloWonMatchHeim3,
                    'Gast_Punkte' => $soloWonMatchGast3,
                ]);

            $singleID = DB::connection('mysqlSP')->table('duell')->select('ID')
                ->where('Spiel_ID', $id->ID)
                ->where('Art', $art)
                ->latest('ID')->first();

            DB::connection('mysqlSP')->table('einzel')
                ->insert(['Duell_ID' => $singleID->ID, 'Spieler_Heim' => $homePID3,
                    'Spieler_Gast' => $guestPID3],
                );

            DB::connection('mysqlSP')->table('satz')
            //  ->where([['Duell_ID', '=', $duellID1], ['Satz_Nr', '=', 1]])
                ->insert(['Duell_ID' => $singleID->ID, 'Satz_Nr' => 1,
                    'Punkte_Heim' => $satz1H3,
                    'Punkte_Gast' => $satz1G3]);

            DB::connection('mysqlSP')->table('satz')
                ->insert(['Duell_ID' => $singleID->ID,
                    'Satz_Nr' => 2,
                    'Punkte_Heim' => $satz2H3,
                    'Punkte_Gast' => $satz2G3]);
            DB::connection('mysqlSP')->table('satz')
                ->insert(['Duell_ID' => $singleID->ID,
                    'Satz_Nr' => 3,
                    'Punkte_Heim' => $satz3H3,
                    'Punkte_Gast' => $satz3G3]);
        }
        if ($soloCount >= 4) {

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
            $soloType4 = $request->soloType4;
            $soloSetpointHeim4 = $request->soloSetpointHeim4;
            $soloSetpointGast4 = $request->soloSetpointGast4;
            $soloWonSetHeim4 = $request->soloWonSetHeim4;
            $soloWonSetGast4 = $request->soloWonSetGast4;
            $soloWonMatchHeim4 = $request->soloWonMatchHeim4;
            $soloWonMatchGast4 = $request->soloWonMatchGast4;
            $art = DB::connection('mysqlSP')->table('art')
                ->select('ID')->where('Name', $soloType4)->value('ID');

            DB::connection('mysqlSP')->table('duell')
                ->insert([
                    'Spiel_ID' => $id->ID,
                    'Art' => $art,
                    'Heim_Spiele' => $soloSetpointHeim4,
                    'Gast_Spiele' => $soloSetpointGast4,
                    'Heim_Saetze' => $soloWonSetHeim4,
                    'Gast_Saetze' => $soloWonSetGast4,
                    'Heim_Punkte' => $soloWonMatchHeim4,
                    'Gast_Punkte' => $soloWonMatchGast4,
                ]);

            $singleID = DB::connection('mysqlSP')->table('duell')->select('ID')
                ->where('Spiel_ID', $id->ID)
                ->where('Art', $art)
                ->latest('ID')->first();

            DB::connection('mysqlSP')->table('einzel')
                ->insert(['Duell_ID' => $singleID->ID, 'Spieler_Heim' => $homePID4,
                    'Spieler_Gast' => $guestPID4],
                );

            DB::connection('mysqlSP')->table('satz')
            //  ->where([['Duell_ID', '=', $duellID1], ['Satz_Nr', '=', 1]])
                ->insert(['Duell_ID' => $singleID->ID, 'Satz_Nr' => 1,
                    'Punkte_Heim' => $satz1H4,
                    'Punkte_Gast' => $satz1G4]);

            DB::connection('mysqlSP')->table('satz')
                ->insert(['Duell_ID' => $singleID->ID,
                    'Satz_Nr' => 2,
                    'Punkte_Heim' => $satz2H4,
                    'Punkte_Gast' => $satz2G4]);
            DB::connection('mysqlSP')->table('satz')
                ->insert(['Duell_ID' => $singleID->ID,
                    'Satz_Nr' => 3,
                    'Punkte_Heim' => $satz3H4,
                    'Punkte_Gast' => $satz3G4]);
        }
    }
    public function insertDoubleDuel($id, Request $request)
    {
        //Um keine null-werte einzutragen, wird erst die Anzahl der Reihen benoetigt
        $doubleCount = $request->doubleCount;
        //IDs der Spieler werden benoetigt
        if ($doubleCount >= 1) {

            $homeFName11 = $request->dualVnameHeim11;
            $homeLName11 = $request->dualNnameHeim11;
            $homeFName21 = $request->dualVnameHeim21;
            $homeLName21 = $request->dualNnameHeim21;
            $guestFName11 = $request->dualVnameGast11;
            $guestLName11 = $request->dualNnameGast11;
            $guestFName21 = $request->dualVnameGast21;
            $guestLName21 = $request->dualNnameGast21;
            $homePID11 = $this->getPlayerID($homeFName11, $homeLName11);
            $homePID21 = $this->getPlayerID($homeFName21, $homeLName21);
            $guestPID11 = $this->getPlayerID($guestFName11, $guestLName11);
            $guestPID21 = $this->getPlayerID($guestFName21, $guestLName21);
            $satz1H1 = $request->dualSatz1heim1;
            $satz1G1 = $request->dualSatz1gast1;
            $satz2H1 = $request->dualSatz2heim1;
            $satz2G1 = $request->dualSatz2gast1;
            $satz3H1 = $request->dualSatz3heim1;
            $satz3G1 = $request->dualSatz3gast1;
            $dualType1 = $request->dualType1;

            $dualSetpointHeim1 = $request->dualSetpointHeim1;
            $dualSetpointGast1 = $request->dualSetpointGast1;
            $dualWonSetHeim1 = $request->dualWonSetHeim1;
            $dualWonSetGast1 = $request->dualWonSetGast1;
            $dualWonMatchHeim1 = $request->dualWonMatchHeim1;
            $dualWonMatchGast1 = $request->dualWonMatchGast1;
            $art = DB::connection('mysqlSP')->table('art')
                ->select('ID')->where('Name', $dualType1)->value('ID');

            DB::connection('mysqlSP')->table('duell')
                ->insert([
                    'Spiel_ID' => $id->ID,
                    'Art' => $art,
                    'Heim_Spiele' => $dualSetpointHeim1,
                    'Gast_Spiele' => $dualSetpointGast1,
                    'Heim_Saetze' => $dualWonSetHeim1,
                    'Gast_Saetze' => $dualWonSetGast1,
                    'Heim_Punkte' => $dualWonMatchHeim1,
                    'Gast_Punkte' => $dualWonMatchGast1,
                ]);

            $doubleID = DB::connection('mysqlSP')->table('duell')->select('ID')
                ->where('Spiel_ID', $id->ID)
                ->where('Art', $art)
                ->latest('ID')->first();

            DB::connection('mysqlSP')->table('doppel')

                ->insert(['Duell_ID' => $doubleID->ID, 'Spieler_Heim_1' => $homePID11,
                    'Spieler_Heim_2' => $homePID21,
                    'Spieler_Gast_1' => $guestPID11,
                    'Spieler_Gast_2' => $guestPID21]
                );
            DB::connection('mysqlSP')->table('satz')

                ->insert(['Duell_ID' => $doubleID->ID, 'Satz_Nr' => 1,
                    'Punkte_Heim' => $satz1H1,
                    'Punkte_Gast' => $satz1G1]);
            DB::connection('mysqlSP')->table('satz')
                ->insert(['Duell_ID' => $doubleID->ID, 'Satz_Nr' => 2,
                    'Punkte_Heim' => $satz2H1,
                    'Punkte_Gast' => $satz2G1]);
            DB::connection('mysqlSP')->table('satz')
                ->insert(['Duell_ID' => $doubleID->ID, 'Satz_Nr' => 3,
                    'Punkte_Heim' => $satz3H1,
                    'Punkte_Gast' => $satz3G1]);
        }
        if ($doubleCount >= 2) {

            $homeFName12 = $request->dualVnameHeim12;
            $homeLName12 = $request->dualNnameHeim12;
            $homeFName22 = $request->dualVnameHeim22;
            $homeLName22 = $request->dualNnameHeim22;
            $guestFName12 = $request->dualVnameGast12;
            $guestLName12 = $request->dualNnameGast12;
            $guestFName22 = $request->dualVnameGast22;
            $guestLName22 = $request->dualNnameGast22;
            $homePID12 = $this->getPlayerID($homeFName12, $homeLName12);
            $homePID22 = $this->getPlayerID($homeFName22, $homeLName22);
            $guestPID12 = $this->getPlayerID($guestFName12, $guestLName12);
            $guestPID22 = $this->getPlayerID($guestFName22, $guestLName22);
            $satz1H2 = $request->dualSatz1heim2;
            $satz1G2 = $request->dualSatz1gast2;
            $satz2H2 = $request->dualSatz2heim2;
            $satz2G2 = $request->dualSatz2gast2;
            $satz3H2 = $request->dualSatz3heim2;
            $satz3G2 = $request->dualSatz3gast2;
            $dualType2 = $request->dualType2;

            $dualSetpointHeim2 = $request->dualSetpointHeim2;
            $dualSetpointGast2 = $request->dualSetpointGast2;
            $dualWonSetHeim2 = $request->dualWonSetHeim2;
            $dualWonSetGast2 = $request->dualWonSetGast2;
            $dualWonMatchHeim2 = $request->dualWonMatchHeim2;
            $dualWonMatchGast2 = $request->dualWonMatchGast2;
            $art = DB::connection('mysqlSP')->table('art')
                ->select('ID')->where('Name', $dualType2)->value('ID');

            DB::connection('mysqlSP')->table('duell')
                ->insert([
                    'Spiel_ID' => $id->ID,
                    'Art' => $art,
                    'Heim_Spiele' => $dualSetpointHeim2,
                    'Gast_Spiele' => $dualSetpointGast2,
                    'Heim_Saetze' => $dualWonSetHeim2,
                    'Gast_Saetze' => $dualWonSetGast2,
                    'Heim_Punkte' => $dualWonMatchHeim2,
                    'Gast_Punkte' => $dualWonMatchGast2,
                ]);

            $doubleID = DB::connection('mysqlSP')->table('duell')->select('ID')
                ->where('Spiel_ID', $id->ID)
                ->where('Art', $art)
                ->latest('ID')->first();

            DB::connection('mysqlSP')->table('doppel')

                ->insert(['Duell_ID' => $doubleID->ID, 'Spieler_Heim_1' => $homePID12,
                    'Spieler_Heim_2' => $homePID22,
                    'Spieler_Gast_1' => $guestPID12,
                    'Spieler_Gast_2' => $guestPID22]
                );
            DB::connection('mysqlSP')->table('satz')

                ->insert(['Duell_ID' => $doubleID->ID, 'Satz_Nr' => 1,
                    'Punkte_Heim' => $satz1H2,
                    'Punkte_Gast' => $satz1G2]);
            DB::connection('mysqlSP')->table('satz')
                ->insert(['Duell_ID' => $doubleID->ID, 'Satz_Nr' => 2,
                    'Punkte_Heim' => $satz2H2,
                    'Punkte_Gast' => $satz2G2]);
            DB::connection('mysqlSP')->table('satz')
                ->insert(['Duell_ID' => $doubleID->ID, 'Satz_Nr' => 3,
                    'Punkte_Heim' => $satz3H2,
                    'Punkte_Gast' => $satz3G2]);
        }
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
    #Eigentliche Updatefunktionen
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
            $day = $request->tag;
            $schiri = $request->schiri;
            #$id = $request -> match;
            $set = DB::connection('mysqlSP')->table(('spiel'))
                ->where(DB::connection('mysqlSP')->raw('ID'), [$id])
                ->update(['Ort' => $place,
                    'Heim' => $homeID,
                    'Spieltag' => $day,
                    'Schiedsrichter' => $schiri,
                    'Gast' => $guestID]);
            $this->updateSoloDuel($id, $request);
            $this->updateDoubleDuel($id, $request);
            $this->setAccepted($id);
        } else {
            $this->setDeclined($id);
        }
        return redirect('/overview');
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

            $soloType1 = $request->soloType1;
            $soloSetpointHeim1 = $request->soloSetpointHeim1;
            $soloSetpointGast1 = $request->soloSetpointGast1;
            $soloWonSetHeim1 = $request->soloWonSetHeim1;
            $soloWonSetGast1 = $request->soloWonSetGast1;
            $soloWonMatchHeim1 = $request->soloWonMatchHeim1;
            $soloWonMatchGast1 = $request->soloWonMatchGast1;

            $art = DB::connection('mysqlSP')->table('art')
                ->select('ID')->where('Name', $soloType1)->value('ID');
            DB::connection('mysqlSP')->table('duell')
                ->where('ID', $duellID1)
                ->update([

                    'Art' => $art,
                    'Heim_Spiele' => $soloSetpointHeim1,
                    'Gast_Spiele' => $soloSetpointGast1,
                    'Heim_Saetze' => $soloWonSetHeim1,
                    'Gast_Saetze' => $soloWonSetGast1,
                    'Heim_Punkte' => $soloWonMatchHeim1,
                    'Gast_Punkte' => $soloWonMatchGast1,
                ]);

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

            $soloType2 = $request->soloType2;
            $soloSetpointHeim2 = $request->soloSetpointHeim2;
            $soloSetpointGast2 = $request->soloSetpointGast2;
            $soloWonSetHeim2 = $request->soloWonSetHeim2;
            $soloWonSetGast2 = $request->soloWonSetGast2;
            $soloWonMatchHeim2 = $request->soloWonMatchHeim2;
            $soloWonMatchGast2 = $request->soloWonMatchGast2;

            $art = DB::connection('mysqlSP')->table('art')
                ->select('ID')->where('Name', $soloType1)->value('ID');
            DB::connection('mysqlSP')->table('duell')
                ->where('ID', $duellID2)
                ->update([

                    'Art' => $art,
                    'Heim_Spiele' => $soloSetpointHeim2,
                    'Gast_Spiele' => $soloSetpointGast2,
                    'Heim_Saetze' => $soloWonSetHeim2,
                    'Gast_Saetze' => $soloWonSetGast2,
                    'Heim_Punkte' => $soloWonMatchHeim2,
                    'Gast_Punkte' => $soloWonMatchGast2,
                ]);

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

            $soloType3 = $request->soloType3;
            $soloSetpointHeim3 = $request->soloSetpointHeim3;
            $soloSetpointGast3 = $request->soloSetpointGast3;
            $soloWonSetHeim3 = $request->soloWonSetHeim3;
            $soloWonSetGast3 = $request->soloWonSetGast3;
            $soloWonMatchHeim3 = $request->soloWonMatchHeim3;
            $soloWonMatchGast3 = $request->soloWonMatchGast3;

            $art = DB::connection('mysqlSP')->table('art')
                ->select('ID')->where('Name', $soloType3)->value('ID');
            DB::connection('mysqlSP')->table('duell')
                ->where('ID', $duellID3)
                ->update([

                    'Art' => $art,
                    'Heim_Spiele' => $soloSetpointHeim3,
                    'Gast_Spiele' => $soloSetpointGast3,
                    'Heim_Saetze' => $soloWonSetHeim3,
                    'Gast_Saetze' => $soloWonSetGast3,
                    'Heim_Punkte' => $soloWonMatchHeim3,
                    'Gast_Punkte' => $soloWonMatchGast3,
                ]);

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

            $soloType4 = $request->soloType4;
            $soloSetpointHeim4 = $request->soloSetpointHeim4;
            $soloSetpointGast4 = $request->soloSetpointGast4;
            $soloWonSetHeim4 = $request->soloWonSetHeim4;
            $soloWonSetGast4 = $request->soloWonSetGast4;
            $soloWonMatchHeim4 = $request->soloWonMatchHeim4;
            $soloWonMatchGast4 = $request->soloWonMatchGast4;

            $art = DB::connection('mysqlSP')->table('art')
                ->select('ID')->where('Name', $soloType1)->value('ID');
            DB::connection('mysqlSP')->table('duell')
                ->where('ID', $duellID4)
                ->update([

                    'Art' => $art,
                    'Heim_Spiele' => $soloSetpointHeim4,
                    'Gast_Spiele' => $soloSetpointGast4,
                    'Heim_Saetze' => $soloWonSetHeim4,
                    'Gast_Saetze' => $soloWonSetGast4,
                    'Heim_Punkte' => $soloWonMatchHeim4,
                    'Gast_Punkte' => $soloWonMatchGast4,
                ]);

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

    public function updateDoubleDuel($id, Request $request)
    {
        //Um keine null-werte einzutragen, wird erst die Anzahl der Reihen benoetigt
        $doubleCount = $request->doubleCount;
        //IDs der Spieler werden benoetigt
        if ($doubleCount >= 1) {
            $duellID1 = $request->doppelDuellID1;
            $homeFName11 = $request->dualVnameHeim11;
            $homeLName11 = $request->dualNnameHeim11;
            $homeFName21 = $request->dualVnameHeim21;
            $homeLName21 = $request->dualNnameHeim21;
            $guestFName11 = $request->dualVnameGast11;
            $guestLName11 = $request->dualNnameGast11;
            $guestFName21 = $request->dualVnameGast21;
            $guestLName21 = $request->dualNnameGast21;
            $homePID11 = $this->getPlayerID($homeFName11, $homeLName11);
            $homePID21 = $this->getPlayerID($homeFName21, $homeLName21);
            $guestPID11 = $this->getPlayerID($guestFName11, $guestLName11);
            $guestPID21 = $this->getPlayerID($guestFName21, $guestLName21);
            $satz1H1 = $request->dualSatz1heim1;
            $satz1G1 = $request->dualSatz1gast1;
            $satz2H1 = $request->dualSatz2heim1;
            $satz2G1 = $request->dualSatz2gast1;
            $satz3H1 = $request->dualSatz3heim1;
            $satz3G1 = $request->dualSatz3gast1;
            $dualType1 = $request->dualType1;

            $dualSetpointHeim1 = $request->dualSetpointHeim1;
            $dualSetpointGast1 = $request->dualSetpointGast1;
            $dualWonSetHeim1 = $request->dualWonSetHeim1;
            $dualWonSetGast1 = $request->dualWonSetGast1;
            $dualWonMatchHeim1 = $request->dualWonMatchHeim1;
            $dualWonMatchGast1 = $request->dualWonMatchGast1;
            $art = DB::connection('mysqlSP')->table('art')
                ->select('ID')->where('Name', $dualType1)->value('ID');

            DB::connection('mysqlSP')->table('duell')
                ->where('ID', $duellID1)
                ->update([

                    'Art' => $art,
                    'Heim_Spiele' => $dualSetpointHeim1,
                    'Gast_Spiele' => $dualSetpointGast1,
                    'Heim_Saetze' => $dualWonSetHeim1,
                    'Gast_Saetze' => $dualWonSetGast1,
                    'Heim_Punkte' => $dualWonMatchHeim1,
                    'Gast_Punkte' => $dualWonMatchGast1,
                ]);

            DB::connection('mysqlSP')->table('doppel')
                ->where('Duell_ID', $duellID1)
                ->update(['Spieler_Heim_1' => $homePID11,
                    'Spieler_Heim_2' => $homePID21,
                    'Spieler_Gast_1' => $guestPID11,
                    'Spieler_Gast_2' => $guestPID21]
                );
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
        if ($doubleCount >= 2) {
            $duellID2 = $request->doppelDuellID2;
            $homeFName12 = $request->dualVnameHeim12;
            $homeLName12 = $request->dualNnameHeim12;
            $homeFName22 = $request->dualVnameHeim22;
            $homeLName22 = $request->dualNnameHeim22;
            $guestFName12 = $request->dualVnameGast12;
            $guestLName12 = $request->dualNnameGast12;
            $guestFName22 = $request->dualVnameGast22;
            $guestLName22 = $request->dualNnameGast22;
            $homePID12 = $this->getPlayerID($homeFName12, $homeLName12);
            $homePID22 = $this->getPlayerID($homeFName22, $homeLName22);
            $guestPID12 = $this->getPlayerID($guestFName12, $guestLName12);
            $guestPID22 = $this->getPlayerID($guestFName22, $guestLName22);
            $satz1H2 = $request->dualSatz1heim2;
            $satz1G2 = $request->dualSatz1gast2;
            $satz2H2 = $request->dualSatz2heim2;
            $satz2G2 = $request->dualSatz2gast2;
            $satz3H2 = $request->dualSatz3heim2;
            $satz3G2 = $request->dualSatz3gast2;
            $dualType2 = $request->dualType2;
            $dualSetpointHeim2 = $request->dualSetpointHeim2;
            $dualSetpointGast2 = $request->dualSetpointGast2;
            $dualWonSetHeim2 = $request->dualWonSetHeim2;
            $dualWonSetGast2 = $request->dualWonSetGast2;
            $dualWonMatchHeim2 = $request->dualWonMatchHeim2;
            $dualWonMatchGast2 = $request->dualWonMatchGast2;
            $art = DB::connection('mysqlSP')->table('art')
                ->select('ID')->where('Name', $dualType2)->value('ID');

            DB::connection('mysqlSP')->table('duell')
                ->where('ID', $duellID2)
                ->update([

                    'Art' => $art,
                    'Heim_Spiele' => $dualSetpointHeim2,
                    'Gast_Spiele' => $dualSetpointGast2,
                    'Heim_Saetze' => $dualWonSetHeim2,
                    'Gast_Saetze' => $dualWonSetGast2,
                    'Heim_Punkte' => $dualWonMatchHeim2,
                    'Gast_Punkte' => $dualWonMatchGast2,
                ]);

            DB::connection('mysqlSP')->table('doppel')
                ->where('Duell_ID', $duellID2)
                ->update(['Spieler_Heim_1' => $homePID12,
                    'Spieler_Heim_2' => $homePID22,
                    'Spieler_Gast_1' => $guestPID12,
                    'Spieler_Gast_2' => $guestPID12]
                );
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
    }

#----------------------------------Suggestions-------------------------------------------------------------

#Roman
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

    // ------------------------------------------------Autocomplete------------------------------------------
    //unnötig?
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
    // first
    public static function LigaID($name)
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
    public static function mannschaften(Request $request)
    {

        $search = $request->search;

        $mannschaften = DB::connection('mysqlSP')->table('mannschaft')->select('ID', 'Name')->where('name', 'like', '%' . $search . '%')->get();

        $response = array();
        foreach ($mannschaften as $mannschaft) {
            $response[] = array("ID" => $mannschaft->ID, "Name" => $mannschaft->Name);
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

    public static function regionLigen(Request $request)
    {

        $search = $request->search;
        $region = $request->region;
        $rregion = DB::connection('mysqlSP')->table('region')->select('ID')->where('name', '=', $region)->first();
        //DB::select("SELECT ID from liga where name = '$liga' ");
        $test = $rregion->ID;
        $ligen = DB::connection('mysqlSP')->table('liga')->select('ID', 'Name')->where('region', '=', $test)->where('name', 'like', '%' . $search . '%')->get();
        //DB::select("SELECT * from Mannschaften where liga == '$rliga' ");
        //

        $response = array();
        foreach ($ligen as $liga) {
            $response[] = array("ID" => $liga->ID, "Name" => $liga->Name);
        }

        return response()->json($response);
    }
    public static function alleRegionen(Request $request)
    {
        $search = $request->search;
        $regionen = DB::connection('mysqlSP')->table('region')->select('ID', 'Name')->where('name', 'like', '%' . $search . '%')->get();

        $response = array();
        foreach ($regionen as $region) {
            $response[] = array("ID" => $region->ID, "Name" => $region->Name);
        }

        return response()->json($response);
    }

    public static function regionMannschaften(Request $request)
    {
        $region = $request->region;
        $search = $request->search;

        $allemannschaften = DB::connection('mysqlSP')->select('SELECT
            m.id as "ID",
            m.name as "Name",

            l.name as "Liga"
        FROM
            mannschaft m, verein v, liga l
        WHERE
             m.Verein_ID = v.ID and m.liga = l.ID and  l.region =? ', [$region]

        );

        $response = array();
        foreach ($allemannschaften as $mannschaft) {

            if (stristr($mannschaft->Name, $search) !== false) {
                $response[] = array("ID" => $mannschaft->ID, "Name" => $mannschaft->Name);}
        }

        return response()->json($response);
    }

    public static function getSpielerNname(Request $request)
    {$team = $request->team;

        $search = $request->search;

        $spieler = DB::connection('mysqlSP')->select('SELECT
            s.id as "ID",
            s.Vorname as "Vorname",
            s.Nachname as "Nachname",
            s.Geschlecht as "Geschlecht"
        FROM
            spieler_mannschaft sm
        LEFT JOIN spieler s ON s.ID = sm.Spieler_ID
        LEFT JOIN mannschaft m on m.id = sm.Mannschaft_ID
        Where m.id=?
        GROUP BY s.id', [$team]);

        $response = array();
        foreach ($spieler as $player) {

            if (stristr($player->Nachname, $search) !== false) {
                $response[] = array("ID" => $player->ID, "Nname" => $player->Nachname);}

        }
        return response()->json($response);
    }
    public static function getSpielerVname(Request $request)
    {$team = $request->team;

        $search = $request->search;

        $spieler = DB::connection('mysqlSP')->select('SELECT
            s.id as "ID",
            s.Vorname as "Vorname",
            s.Nachname as "Nachname",
            s.Geschlecht as "Geschlecht"
        FROM
            spieler_mannschaft sm
        LEFT JOIN spieler s ON s.ID = sm.Spieler_ID
        LEFT JOIN mannschaft m on m.id = sm.Mannschaft_ID
        Where m.id=?
        GROUP BY s.id', [$team]);

        $response = array();
        foreach ($spieler as $player) {

            if (stristr($player->Vorname, $search) !== false) {
                $response[] = array("ID" => $player->ID, "Vname" => $player->Vorname);}
        }

        return response()->json($response);
    }

    public static function saison(Request $request)
    {
        $ligaID = $request->ligaID;

        $saison =
        DB::connection('mysqlSP')->table('saison')
            ->where('Liga', $ligaID)

            ->latest('ID')->first();

        $response = array();

        if ($saison != null) {
            $response[] = array("ID" => $saison->ID, "Name" => $saison->Name);}

        return response()->json($response);
    }
    public static function runde(Request $request)
    {
        $saisonID = $request->saisonID;

        $saison =
        DB::connection('mysqlSP')->table('runde')
            ->where('Saison', $saisonID)

            ->latest('ID')->first();

        $response = array();

        $response[] = array("ID" => $saison->ID, "Name" => $saison->Bezeichnung);

        return response()->json($response);
    }

    public static function tag(Request $request)
    {
        $rundeID = $request->rundeID;

        $tag =
        DB::connection('mysqlSP')->table('spieltag')
            ->where('Runde', $rundeID)

            ->latest('ID')->first();

        $response = array();

        $response[] = array("ID" => $tag->ID, "Name" => $tag->Tag);

        return response()->json($response);
    }
}

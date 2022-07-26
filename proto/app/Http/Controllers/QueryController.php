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

    //see_report, check_report, control_handwriting: Region in der Sich die Liga des befindet
    public static function getRegion($liga)
    {
        $region = DB::connection('mysqlSP')->select('SELECT
            r.name, r.ID
        FROM
            region r, liga l
        WHERE
            l.region = r.id AND l.ID = :id', ['id' => $liga]);
        error_log($region[0]->name);
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
            sa3.Punkte_Heim AS "Satz_3_Heim", sa3.Punkte_Gast AS "Satz_3_Gast"					#Punkte im 3. Satz
        FROM
            duell d
	    LEFT JOIN  art a ON a.id = d.art
	    LEFT JOIN einzel e ON e.Duell_ID = d.ID
	    LEFT JOIN spieler s1 ON e.Spieler_Heim = s1.ID
	    LEFT JOIN spieler s2 ON e.Spieler_Gast = s2.ID
        LEFT JOIN  satz sa1 ON sa1.Duell_ID = d.ID
        LEFT JOIN  satz sa2 ON sa2.Duell_ID = d.ID
        LEFT JOIN  satz sa3 ON sa3.Duell_ID = d.ID
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
            sa3.Punkte_Heim AS "Satz_3_Heim", sa3.Punkte_Gast AS "Satz_3_Gast"					    #Punkte im 3. Satz
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

    //see_report, check_report: Alle Spieletypen
    public static function allTypes()
    {
        $result = DB::connection('mysqlSP')->select('SELECT
            *
        FROM
            art');
        return $result;
    }

    //_____________________________________________Texterkennung Korrektur____________________________________________

    //control_handwriting: Rueckgabe der Liga anhand der spielenden Mannschaften
    public static function getLigaByTeam($name)
    {
        $liga = DB::connection('mysqlSP')->select('SELECT
            *
        FROM
            mannschaft m, liga l
        WHERE
            m.liga = l.id AND m.id = :mName', ['mName' => $name]);

        return $liga[0];
    }
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

    //_____________________________________________Spiel hinzufuegen____________________________________________

    //web.php Route /upload: Neues Spiel wird der Datenbank hinzugefuegt
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
        $this->insertSoloDuel($id, $request);
        $this->insertDoubleDuel($id, $request);
        return redirect('/upload');

    }

    //QueryController insertMatch: Fuegt alle Einzelspiele eines Spiels der Datenbank hinzu
    public function insertSoloDuel($id, Request $request)
    {
        //Um keine null-werte einzutragen, wird erst die Anzahl der Reihen benoetigt
        $soloCount = $request->soloCount;
        if (empty($soloCount)) {
            $soloCount = 2;
        }
        error_log($soloCount);

        //IDs der Spieler werden benoetigt
        if ($soloCount >= 1) {

            $homeFName = $request->soloVnameHeim1;
            $homeLName = $request->soloNnameHeim1;
            $guestFName = $request->soloVnameGast1;
            $guestLName = $request->soloNnameGast1;
            $homePID = $this->getPlayerID($homeFName, $homeLName);
            $guestPID = $this->getPlayerID($guestFName, $guestLName);
            $satz1H = $request->soloSatz1heim1;
            $satz1G = $request->soloSatz1gast1;
            $satz2H = $request->soloSatz2heim1;
            $satz2G = $request->soloSatz2gast1;
            $satz3H = $request->soloSatz3heim1;
            $satz3G = $request->soloSatz3gast1;
            $soloType = $request->soloType1;
            $art = DB::connection('mysqlSP')->table('art')
                ->select('ID')->where('Name', $soloType)->value('ID');

            DB::connection('mysqlSP')->table('duell')
                ->insert([
                    'Spiel_ID' => $id->ID,
                    'Art' => $art,
                ]);

            $singleID = DB::connection('mysqlSP')->table('duell')->select('ID')
                ->where('Spiel_ID', $id->ID)
                ->where('Art', $art)
                ->latest('ID')->first();

            DB::connection('mysqlSP')->table('einzel')
                ->insert(['Duell_ID' => $singleID->ID, 'Spieler_Heim' => $homePID,
                    'Spieler_Gast' => $guestPID],
                );

            DB::connection('mysqlSP')->table('satz')
            //  ->where([['Duell_ID', '=', $duellID], ['Satz_Nr', '=', 1]])
                ->insert(['Punkte_Heim' => $satz1H,
                    'Satz_Nr' => 1,
                    'Duell_ID' => $singleID->ID,
                    'Punkte_Gast' => $satz1G]);

            DB::connection('mysqlSP')->table('satz')
                ->insert(['Duell_ID' => $singleID->ID,
                    'Satz_Nr' => 2,
                    'Punkte_Heim' => $satz2H,
                    'Punkte_Gast' => $satz2G]);
            DB::connection('mysqlSP')->table('satz')
                ->insert(['Duell_ID' => $singleID->ID,
                    'Satz_Nr' => 3,
                    'Punkte_Heim' => $satz3H,
                    'Punkte_Gast' => $satz3G]);
        }
        if ($soloCount >= 2) {

            $homeFName = $request->soloVnameHeim2;
            $homeLName = $request->soloNnameHeim2;
            $guestFName = $request->soloVnameGast2;
            $guestLName = $request->soloNnameGast2;
            $homePID = $this->getPlayerID($homeFName, $homeLName);
            $guestPID = $this->getPlayerID($guestFName, $guestLName);
            $satz1H = $request->soloSatz1heim2;
            $satz1G = $request->soloSatz1gast2;
            $satz2H = $request->soloSatz2heim2;
            $satz2G = $request->soloSatz2gast2;
            $satz3H = $request->soloSatz3heim2;
            $satz3G = $request->soloSatz3gast2;
            $soloType = $request->soloType2;
            $art = DB::connection('mysqlSP')->table('art')
                ->select('ID')->where('Name', $soloType)->value('ID');

            DB::connection('mysqlSP')->table('duell')
                ->insert([
                    'Spiel_ID' => $id->ID,
                    'Art' => $art,
                ]);
            $singleID = DB::connection('mysqlSP')->table('duell')->select('ID')
                ->where('Spiel_ID', $id->ID)
                ->where('Art', $art)
                ->latest('ID')->first();

            DB::connection('mysqlSP')->table('einzel')
                ->insert(['Duell_ID' => $singleID->ID,
                    'Spieler_Heim' => $homePID,
                    'Spieler_Gast' => $guestPID],
                );

            DB::connection('mysqlSP')->table('satz')
            //  ->where([['Duell_ID', '=', $duellID], ['Satz_Nr', '=', 1]])
                ->insert(['Duell_ID' => $singleID->ID,
                    'Satz_Nr' => 1,
                    'Punkte_Heim' => $satz1H,
                    'Punkte_Gast' => $satz1G]);

            DB::connection('mysqlSP')->table('satz')
                ->insert(['Duell_ID' => $singleID->ID,
                    'Satz_Nr' => 2,
                    'Punkte_Heim' => $satz2H,
                    'Punkte_Gast' => $satz2G]);
            DB::connection('mysqlSP')->table('satz')
                ->insert(['Duell_ID' => $singleID->ID,
                    'Satz_Nr' => 3,
                    'Punkte_Heim' => $satz3H,
                    'Punkte_Gast' => $satz3G]);

        }
        if ($soloCount >= 3) {

            $homeFName = $request->soloVnameHeim3;
            $homeLName = $request->soloNnameHeim3;
            $guestFName = $request->soloVnameGast3;
            $guestLName = $request->soloNnameGast3;
            $homePID = $this->getPlayerID($homeFName, $homeLName);
            $guestPID = $this->getPlayerID($guestFName, $guestLName);
            $satz1H = $request->soloSatz1heim3;
            $satz1G = $request->soloSatz1gast3;
            $satz2H = $request->soloSatz2heim3;
            $satz2G = $request->soloSatz2gast3;
            $satz3H = $request->soloSatz3heim3;
            $satz3G = $request->soloSatz3gast3;
            $soloType = $request->soloType3;
            $art = DB::connection('mysqlSP')->table('art')
                ->select('ID')->where('Name', $soloType)->value('ID');

            DB::connection('mysqlSP')->table('duell')
                ->insert([
                    'Spiel_ID' => $id->ID,
                    'Art' => $art,
                ]);

            $singleID = DB::connection('mysqlSP')->table('duell')->select('ID')
                ->where('Spiel_ID', $id->ID)
                ->where('Art', $art)
                ->latest('ID')->first();

            DB::connection('mysqlSP')->table('einzel')
                ->insert(['Duell_ID' => $singleID->ID,
                    'Spieler_Heim' => $homePID,
                    'Spieler_Gast' => $guestPID],
                );

            DB::connection('mysqlSP')->table('satz')
            //  ->where([['Duell_ID', '=', $duellID], ['Satz_Nr', '=', 1]])
                ->insert(['Duell_ID' => $singleID->ID,
                    'Satz_Nr' => 1,
                    'Punkte_Heim' => $satz1H,
                    'Punkte_Gast' => $satz1G]);

            DB::connection('mysqlSP')->table('satz')
                ->insert(['Duell_ID' => $singleID->ID,
                    'Satz_Nr' => 2,
                    'Punkte_Heim' => $satz2H,
                    'Punkte_Gast' => $satz2G]);
            DB::connection('mysqlSP')->table('satz')
                ->insert(['Duell_ID' => $singleID->ID,
                    'Satz_Nr' => 3,
                    'Punkte_Heim' => $satz3H,
                    'Punkte_Gast' => $satz3G]);
        }
        if ($soloCount >= 4) {

            $homeFName = $request->soloVnameHeim4;
            $homeLName = $request->soloNnameHeim4;
            $guestFName = $request->soloVnameGast4;
            $guestLName = $request->soloNnameGast4;
            $homePID = $this->getPlayerID($homeFName, $homeLName);
            $guestPID = $this->getPlayerID($guestFName, $guestLName);
            $satz1H = $request->soloSatz1heim4;
            $satz1G = $request->soloSatz1gast4;
            $satz2H = $request->soloSatz2heim4;
            $satz2G = $request->soloSatz2gast4;
            $satz3H = $request->soloSatz3heim4;
            $satz3G = $request->soloSatz3gast4;
            $soloType = $request->soloType4;
            $art = DB::connection('mysqlSP')->table('art')
                ->select('ID')->where('Name', $soloType)->value('ID');

            DB::connection('mysqlSP')->table('duell')
                ->insert([
                    'Spiel_ID' => $id->ID,
                    'Art' => $art,
                ]);

            $singleID = DB::connection('mysqlSP')->table('duell')->select('ID')
                ->where('Spiel_ID', $id->ID)
                ->where('Art', $art)
                ->latest('ID')->first();

            DB::connection('mysqlSP')->table('einzel')
                ->insert(['Duell_ID' => $singleID->ID,
                    'Spieler_Heim' => $homePID,
                    'Spieler_Gast' => $guestPID],
                );

            DB::connection('mysqlSP')->table('satz')
            //  ->where([['Duell_ID', '=', $duellID], ['Satz_Nr', '=', 1]])
                ->insert(['Duell_ID' => $singleID->ID, 'Satz_Nr' => 1,
                    'Punkte_Heim' => $satz1H,
                    'Punkte_Gast' => $satz1G]);

            DB::connection('mysqlSP')->table('satz')
                ->insert(['Duell_ID' => $singleID->ID,
                    'Satz_Nr' => 2,
                    'Punkte_Heim' => $satz2H,
                    'Punkte_Gast' => $satz2G]);
            DB::connection('mysqlSP')->table('satz')
                ->insert(['Duell_ID' => $singleID->ID,
                    'Satz_Nr' => 3,
                    'Punkte_Heim' => $satz3H,
                    'Punkte_Gast' => $satz3G]);
        }
    }

    //QueryController insertMatch: Fuegt alle Doppelspiele eines Spiels der Datenbank hinzu
    public function insertDoubleDuel($id, Request $request)
    {
        //Um keine null-werte einzutragen, wird erst die Anzahl der Reihen benoetigt
        $doubleCount = $request->doubleCount;
        if (empty($doubleCount)) {
            $doubleCount = 4;
        }
        //IDs der Spieler werden benoetigt
        if ($doubleCount >= 1) {
            $homeFName1 = $request->dualVnameHeim11;
            $homeLName1 = $request->dualNnameHeim11;
            $homeFName2 = $request->dualVnameHeim21;
            $homeLName2 = $request->dualNnameHeim21;
            $guestFName1 = $request->dualVnameGast11;
            $guestLName1 = $request->dualNnameGast11;
            $guestFName2 = $request->dualVnameGast21;
            $guestLName2 = $request->dualNnameGast21;
            $homePID1 = $this->getPlayerID($homeFName1, $homeLName1);
            $homePID2 = $this->getPlayerID($homeFName2, $homeLName2);
            $guestPID1 = $this->getPlayerID($guestFName1, $guestLName1);
            $guestPID2 = $this->getPlayerID($guestFName2, $guestLName2);
            $satz1H = $request->dualSatz1heim1;
            $satz1G = $request->dualSatz1gast1;
            $satz2H = $request->dualSatz2heim1;
            $satz2G = $request->dualSatz2gast1;
            $satz3H = $request->dualSatz3heim1;
            $satz3G = $request->dualSatz3gast1;
            $dualType = $request->dualType1;
            $art = DB::connection('mysqlSP')->table('art')
                ->select('ID')->where('Name', $dualType)->value('ID');

            DB::connection('mysqlSP')->table('duell')
                ->insert([
                    'Spiel_ID' => $id->ID,
                    'Art' => $art,
                ]);

            $doubleID = DB::connection('mysqlSP')->table('duell')->select('ID')
                ->where('Spiel_ID', $id->ID)
                ->where('Art', $art)
                ->latest('ID')->first();

            DB::connection('mysqlSP')->table('doppel')

                ->insert(['Duell_ID' => $doubleID->ID,
                    'Spieler_Heim_1' => $homePID1,
                    'Spieler_Heim_2' => $homePID2,
                    'Spieler_Gast_1' => $guestPID1,
                    'Spieler_Gast_2' => $guestPID2]
                );
            DB::connection('mysqlSP')->table('satz')

                ->insert(['Duell_ID' => $doubleID->ID,
                    'Satz_Nr' => 1,
                    'Punkte_Heim' => $satz1H,
                    'Punkte_Gast' => $satz1G]);
            DB::connection('mysqlSP')->table('satz')
                ->insert(['Duell_ID' => $doubleID->ID,
                    'Satz_Nr' => 2,
                    'Punkte_Heim' => $satz2H,
                    'Punkte_Gast' => $satz2G]);
            DB::connection('mysqlSP')->table('satz')
                ->insert(['Duell_ID' => $doubleID->ID,
                    'Satz_Nr' => 3,
                    'Punkte_Heim' => $satz3H,
                    'Punkte_Gast' => $satz3G]);
        }
        if ($doubleCount >= 2) {
            $homeFName1 = $request->dualVnameHeim12;
            $homeLName1 = $request->dualNnameHeim12;
            $homeFName2 = $request->dualVnameHeim22;
            $homeLName2 = $request->dualNnameHeim22;
            $guestFName1 = $request->dualVnameGast12;
            $guestLName1 = $request->dualNnameGast12;
            $guestFName2 = $request->dualVnameGast22;
            $guestLName2 = $request->dualNnameGast22;
            $homePID1 = $this->getPlayerID($homeFName1, $homeLName1);
            $homePID2 = $this->getPlayerID($homeFName2, $homeLName2);
            $guestPID1 = $this->getPlayerID($guestFName1, $guestLName1);
            $guestPID2 = $this->getPlayerID($guestFName2, $guestLName2);
            $satz1H = $request->dualSatz1heim2;
            $satz1G = $request->dualSatz1gast2;
            $satz2H = $request->dualSatz2heim2;
            $satz2G = $request->dualSatz2gast2;
            $satz3H = $request->dualSatz3heim2;
            $satz3G = $request->dualSatz3gast2;
            $dualType = $request->dualType2;
            $art = DB::connection('mysqlSP')->table('art')
                ->select('ID')->where('Name', $dualType)->value('ID');

            DB::connection('mysqlSP')->table('duell')
                ->insert([
                    'Spiel_ID' => $id->ID,
                    'Art' => $art,
                ]);

            $doubleID = DB::connection('mysqlSP')->table('duell')->select('ID')
                ->where('Spiel_ID', $id->ID)
                ->where('Art', $art)
                ->latest('ID')->first();

            DB::connection('mysqlSP')->table('doppel')

                ->insert(['Duell_ID' => $doubleID->ID,
                    'Spieler_Heim_1' => $homePID1,
                    'Spieler_Heim_2' => $homePID2,
                    'Spieler_Gast_1' => $guestPID1,
                    'Spieler_Gast_2' => $guestPID2]
                );
            DB::connection('mysqlSP')->table('satz')

                ->insert(['Duell_ID' => $doubleID->ID, 'Satz_Nr' => 1,
                    'Punkte_Heim' => $satz1H,
                    'Punkte_Gast' => $satz1G]);
            DB::connection('mysqlSP')->table('satz')
                ->insert(['Duell_ID' => $doubleID->ID, 'Satz_Nr' => 2,
                    'Punkte_Heim' => $satz2H,
                    'Punkte_Gast' => $satz2G]);
            DB::connection('mysqlSP')->table('satz')
                ->insert(['Duell_ID' => $doubleID->ID, 'Satz_Nr' => 3,
                    'Punkte_Heim' => $satz3H,
                    'Punkte_Gast' => $satz3G]);
        }
        if ($doubleCount >= 3) {
            $homeFName1 = $request->dualVnameHeim13;
            $homeLName1 = $request->dualNnameHeim13;
            $homeFName2 = $request->dualVnameHeim23;
            $homeLName2 = $request->dualNnameHeim23;
            $guestFName1 = $request->dualVnameGast13;
            $guestLName1 = $request->dualNnameGast13;
            $guestFName2 = $request->dualVnameGast23;
            $guestLName2 = $request->dualNnameGast23;
            $homePID1 = $this->getPlayerID($homeFName1, $homeLName1);
            $homePID2 = $this->getPlayerID($homeFName2, $homeLName2);
            $guestPID1 = $this->getPlayerID($guestFName1, $guestLName1);
            $guestPID2 = $this->getPlayerID($guestFName2, $guestLName2);
            $satz1H = $request->dualSatz1heim3;
            $satz1G = $request->dualSatz1gast3;
            $satz2H = $request->dualSatz2heim3;
            $satz2G = $request->dualSatz2gast3;
            $satz3H = $request->dualSatz3heim3;
            $satz3G = $request->dualSatz3gast3;
            $dualType = $request->dualType3;
            $art = DB::connection('mysqlSP')->table('art')
                ->select('ID')->where('Name', $dualType)->value('ID');

            DB::connection('mysqlSP')->table('duell')
                ->insert([
                    'Spiel_ID' => $id->ID,
                    'Art' => $art,
                ]);

            $doubleID = DB::connection('mysqlSP')->table('duell')->select('ID')
                ->where('Spiel_ID', $id->ID)
                ->where('Art', $art)
                ->latest('ID')->first();

            DB::connection('mysqlSP')->table('doppel')

                ->insert(['Duell_ID' => $doubleID->ID,
                    'Spieler_Heim_1' => $homePID1,
                    'Spieler_Heim_2' => $homePID2,
                    'Spieler_Gast_1' => $guestPID1,
                    'Spieler_Gast_2' => $guestPID2]
                );
            DB::connection('mysqlSP')->table('satz')

                ->insert(['Duell_ID' => $doubleID->ID, 'Satz_Nr' => 1,
                    'Punkte_Heim' => $satz1H,
                    'Punkte_Gast' => $satz1G]);
            DB::connection('mysqlSP')->table('satz')
                ->insert(['Duell_ID' => $doubleID->ID, 'Satz_Nr' => 2,
                    'Punkte_Heim' => $satz2H,
                    'Punkte_Gast' => $satz2G]);
            DB::connection('mysqlSP')->table('satz')
                ->insert(['Duell_ID' => $doubleID->ID, 'Satz_Nr' => 3,
                    'Punkte_Heim' => $satz3H,
                    'Punkte_Gast' => $satz3G]);
        }
        if ($doubleCount >= 4) {

            $homeFName1 = $request->dualVnameHeim14;
            $homeLName1 = $request->dualNnameHeim14;
            $homeFName2 = $request->dualVnameHeim24;
            $homeLName2 = $request->dualNnameHeim24;
            $guestFName1 = $request->dualVnameGast14;
            $guestLName1 = $request->dualNnameGast14;
            $guestFName2 = $request->dualVnameGast24;
            $guestLName2 = $request->dualNnameGast24;
            $homePID1 = $this->getPlayerID($homeFName1, $homeLName1);
            $homePID2 = $this->getPlayerID($homeFName2, $homeLName2);
            $guestPID1 = $this->getPlayerID($guestFName1, $guestLName1);
            $guestPID2 = $this->getPlayerID($guestFName2, $guestLName2);
            $satz1H = $request->dualSatz1heim4;
            $satz1G = $request->dualSatz1gast4;
            $satz2H = $request->dualSatz2heim4;
            $satz2G = $request->dualSatz2gast4;
            $satz3H = $request->dualSatz3heim4;
            $satz3G = $request->dualSatz3gast4;
            $dualType = $request->dualType4;
            $art = DB::connection('mysqlSP')->table('art')
                ->select('ID')->where('Name', $dualType)->value('ID');

            DB::connection('mysqlSP')->table('duell')
                ->insert([
                    'Spiel_ID' => $id->ID,
                    'Art' => $art,
                ]);

            $doubleID = DB::connection('mysqlSP')->table('duell')->select('ID')
                ->where('Spiel_ID', $id->ID)
                ->where('Art', $art)
                ->latest('ID')->first();

            DB::connection('mysqlSP')->table('doppel')

                ->insert(['Duell_ID' => $doubleID->ID,
                    'Spieler_Heim_1' => $homePID1,
                    'Spieler_Heim_2' => $homePID2,
                    'Spieler_Gast_1' => $guestPID1,
                    'Spieler_Gast_2' => $guestPID2]
                );
            DB::connection('mysqlSP')->table('satz')

                ->insert(['Duell_ID' => $doubleID->ID, 'Satz_Nr' => 1,
                    'Punkte_Heim' => $satz1H,
                    'Punkte_Gast' => $satz1G]);
            DB::connection('mysqlSP')->table('satz')
                ->insert(['Duell_ID' => $doubleID->ID, 'Satz_Nr' => 2,
                    'Punkte_Heim' => $satz2H,
                    'Punkte_Gast' => $satz2G]);
            DB::connection('mysqlSP')->table('satz')
                ->insert(['Duell_ID' => $doubleID->ID, 'Satz_Nr' => 3,
                    'Punkte_Heim' => $satz3H,
                    'Punkte_Gast' => $satz3G]);
        }
    }

    // QueryController updateMatch, insertMatch: Hilfsfunktionen zum Erhalten der ID anhand der Eingaben
    private function getTeamID($name)
    {
        $teamID = DB::connection('mysqlSP')->select('SELECT
            ID
        FROM
            mannschaft
        WHERE
            Name = :name', ['name' => $name]);
        return $teamID[0]->ID;
    }

    // QueryController updateMatch, insertMatch: Hilfsfunktionen zum Erhalten der ID anhand der Eingaben
    private function getPlayerID($firstname, $lastname)
    {
        error_log('Spieler: ' . $firstname . " " . $lastname);
        $playerID = DB::connection('mysqlSP')->select('SELECT
            ID
        FROM
            spieler
        WHERE
            Vorname = :vorname AND Nachname = :nachname', ['vorname' => $firstname, 'nachname' => $lastname]);
        return $playerID[0]->ID;
    }

    //web.php edit: AKtualisieren eines bereits vorhandenen Spiels
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
            error_log('TAG');
            error_log($day);
            $schiri = $request->schiri;
            error_log($request);
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

    //QueryController updateMatch: Setzt Status des Spiels
    private function setDeclined($id)
    {
        $state = DB::connection('mysqlSP')->table(('spiel'))
            ->where(DB::connection('mysqlSP')->raw('ID'), [$id])
            ->update(['Status' => 2]);
    }

    //QueryController updateMatch: Setzt Status des Spiels
    private function setAccepted($id)
    {
        $state = DB::connection('mysqlSP')->table(('spiel'))
            ->where(DB::connection('mysqlSP')->raw('ID'), [$id])
            ->update(['Status' => 1]);
    }

    //QueryController updateMatch: Aktualisiert alle Einzelspiele eines vorhandenen Spiels
    public function updateSoloDuel($id, Request $request)
    {
        //Um keine null-werte einzutragen, wird erst die Anzahl der Reihen benoetigt
        $soloCount = $request->soloCount;
        //IDs der Spieler werden benoetigt
        if ($soloCount >= 1) {
            $duellID = $request->duellID1;
            $homeFName = $request->soloVnameHeim1;
            $homeLName = $request->soloNnameHeim1;
            $guestFName = $request->soloVnameGast1;
            $guestLName = $request->soloNnameGast1;
            $homePID = $this->getPlayerID($homeFName, $homeLName);
            $guestPID = $this->getPlayerID($guestFName, $guestLName);
            $satz1H = $request->soloSatz1heim1;
            $satz1G = $request->soloSatz1gast1;
            $satz2H = $request->soloSatz2heim1;
            $satz2G = $request->soloSatz2gast1;
            $satz3H = $request->soloSatz3heim1;
            $satz3G = $request->soloSatz3gast1;
            $soloType = $request->soloType1;

            $art = DB::connection('mysqlSP')->table('art')
                ->select('ID')->where('Name', $soloType)->value('ID');
            DB::connection('mysqlSP')->table('duell')
                ->where('ID', $duellID)
                ->update([

                    'Art' => $art,
                ]);

            DB::connection('mysqlSP')->table('einzel')
                ->where('Duell_ID', $duellID)
                ->update(['Spieler_Heim' => $homePID,
                    'Spieler_Gast' => $guestPID],
                    '');

            DB::connection('mysqlSP')->table('satz')
                ->where([['Duell_ID', '=', $duellID], ['Satz_Nr', '=', 1]])
                ->update(['Punkte_Heim' => $satz1H,
                    'Punkte_Gast' => $satz1G]);
            DB::connection('mysqlSP')->table('satz')
                ->where([['Duell_ID', '=', $duellID], ['Satz_Nr', '=', 2]])
                ->update(['Punkte_Heim' => $satz2H,
                    'Punkte_Gast' => $satz2G]);
            DB::connection('mysqlSP')->table('satz')
                ->where([['Duell_ID', '=', $duellID], ['Satz_Nr', '=', 3]])
                ->update(['Punkte_Heim' => $satz3H,
                    'Punkte_Gast' => $satz3G]);
        }
        if ($soloCount >= 2) {
            $duellID = $request->duellID2;
            $homeFName = $request->soloVnameHeim2;
            $homeLName = $request->soloNnameHeim2;
            $guestFName = $request->soloVnameGast2;
            $guestLName = $request->soloNnameGast2;
            $homePID = $this->getPlayerID($homeFName, $homeLName);
            $guestPID = $this->getPlayerID($guestFName, $guestLName);
            $satz1H = $request->soloSatz1heim2;
            $satz1G = $request->soloSatz1gast2;
            $satz2H = $request->soloSatz2heim2;
            $satz2G = $request->soloSatz2gast2;
            $satz3H = $request->soloSatz3heim2;
            $satz3G = $request->soloSatz3gast2;
            $soloType = $request->soloType2;

            $art = DB::connection('mysqlSP')->table('art')
                ->select('ID')->where('Name', $soloType)->value('ID');
            DB::connection('mysqlSP')->table('duell')
                ->where('ID', $duellID)
                ->update([

                    'Art' => $art,
                ]);

            DB::connection('mysqlSP')->table('einzel')
                ->where('Duell_ID', $duellID)
                ->update(['Spieler_Heim' => $homePID,
                    'Spieler_Gast' => $guestPID],
                    '');
            DB::connection('mysqlSP')->table('satz')
                ->where([['Duell_ID', '=', $duellID], ['Satz_Nr', '=', 1]])
                ->update(['Punkte_Heim' => $satz1H,
                    'Punkte_Gast' => $satz1G]);
            DB::connection('mysqlSP')->table('satz')
                ->where([['Duell_ID', '=', $duellID], ['Satz_Nr', '=', 2]])
                ->update(['Punkte_Heim' => $satz2H,
                    'Punkte_Gast' => $satz2G]);
            DB::connection('mysqlSP')->table('satz')
                ->where([['Duell_ID', '=', $duellID], ['Satz_Nr', '=', 3]])
                ->update(['Punkte_Heim' => $satz3H,
                    'Punkte_Gast' => $satz3G]);
        }
        if ($soloCount >= 3) {
            $duellID = $request->duellID3;
            $homeFName = $request->soloVnameHeim3;
            $homeLName = $request->soloNnameHeim3;
            $guestFName = $request->soloVnameGast3;
            $guestLName = $request->soloNnameGast3;
            $homePID = $this->getPlayerID($homeFName, $homeLName);
            $guestPID = $this->getPlayerID($guestFName, $guestLName);
            $satz1H = $request->soloSatz1heim3;
            $satz1G = $request->soloSatz1gast3;
            $satz2H = $request->soloSatz2heim3;
            $satz2G = $request->soloSatz2gast3;
            $satz3H = $request->soloSatz3heim3;
            $satz3G = $request->soloSatz3gast3;
            $soloType = $request->soloType3;

            $art = DB::connection('mysqlSP')->table('art')
                ->select('ID')->where('Name', $soloType)->value('ID');
            DB::connection('mysqlSP')->table('duell')
                ->where('ID', $duellID)
                ->update([

                    'Art' => $art,
                ]);

            DB::connection('mysqlSP')->table('einzel')
                ->where('Duell_ID', $duellID)
                ->update(['Spieler_Heim' => $homePID,
                    'Spieler_Gast' => $guestPID],
                    '');
            DB::connection('mysqlSP')->table('satz')
                ->where([['Duell_ID', '=', $duellID], ['Satz_Nr', '=', 1]])
                ->update(['Punkte_Heim' => $satz1H,
                    'Punkte_Gast' => $satz1G]);
            DB::connection('mysqlSP')->table('satz')
                ->where([['Duell_ID', '=', $duellID], ['Satz_Nr', '=', 2]])
                ->update(['Punkte_Heim' => $satz2H,
                    'Punkte_Gast' => $satz2G]);
            DB::connection('mysqlSP')->table('satz')
                ->where([['Duell_ID', '=', $duellID], ['Satz_Nr', '=', 3]])
                ->update(['Punkte_Heim' => $satz3H,
                    'Punkte_Gast' => $satz3G]);
        }
        if ($soloCount >= 4) {
            $duellID = $request->duellID4;
            $homeFName = $request->soloVnameHeim4;
            $homeLName = $request->soloNnameHeim4;
            $guestFName = $request->soloVnameGast4;
            $guestLName = $request->soloNnameGast4;
            $homePID = $this->getPlayerID($homeFName, $homeLName);
            $guestPID = $this->getPlayerID($guestFName, $guestLName);
            $satz1H = $request->soloSatz1heim4;
            $satz1G = $request->soloSatz1gast4;
            $satz2H = $request->soloSatz2heim4;
            $satz2G = $request->soloSatz2gast4;
            $satz3H = $request->soloSatz3heim4;
            $satz3G = $request->soloSatz3gast4;
            $soloType = $request->soloType4;

            $art = DB::connection('mysqlSP')->table('art')
                ->select('ID')->where('Name', $soloType)->value('ID');
            DB::connection('mysqlSP')->table('duell')
                ->where('ID', $duellID)
                ->update([
                    'Art' => $art,
                ]);

            DB::connection('mysqlSP')->table('einzel')
                ->where('Duell_ID', $duellID)
                ->update(['Spieler_Heim' => $homePID,
                    'Spieler_Gast' => $guestPID],
                    '');
            DB::connection('mysqlSP')->table('satz')
                ->where([['Duell_ID', '=', $duellID], ['Satz_Nr', '=', 1]])
                ->update(['Punkte_Heim' => $satz1H,
                    'Punkte_Gast' => $satz1G]);
            DB::connection('mysqlSP')->table('satz')
                ->where([['Duell_ID', '=', $duellID], ['Satz_Nr', '=', 2]])
                ->update(['Punkte_Heim' => $satz2H,
                    'Punkte_Gast' => $satz2G]);
            DB::connection('mysqlSP')->table('satz')
                ->where([['Duell_ID', '=', $duellID], ['Satz_Nr', '=', 3]])
                ->update(['Punkte_Heim' => $satz3H,
                    'Punkte_Gast' => $satz3G]);
        }

        //Update in EinzelTabelle
    }

    //QueryController updateMatch: Aktualisiert alle Doppelspiele eines vorhandenen Spiels
    public function updateDoubleDuel($id, Request $request)
    {
        //Um keine null-werte einzutragen, wird erst die Anzahl der Reihen benoetigt
        $doubleCount = $request->doubleCount;
        error_log("COUNTER");
        error_log($doubleCount);
        //IDs der Spieler werden benoetigt
        if ($doubleCount >= 1) {
            error_log('dTest1 ');
            $duellID = $request->doppelDuellID1;
            $homeFName1 = $request->dualVnameHeim11;
            $homeLName1 = $request->dualNnameHeim11;
            $homeFName2 = $request->dualVnameHeim21;
            $homeLName2 = $request->dualNnameHeim21;
            $guestFName1 = $request->dualVnameGast11;
            $guestLName1 = $request->dualNnameGast11;
            $guestFName2 = $request->dualVnameGast21;
            $guestLName2 = $request->dualNnameGast21;
            $homePID1 = $this->getPlayerID($homeFName1, $homeLName1);
            $homePID2 = $this->getPlayerID($homeFName2, $homeLName2);
            $guestPID1 = $this->getPlayerID($guestFName1, $guestLName1);
            $guestPID2 = $this->getPlayerID($guestFName2, $guestLName2);
            $satz1H = $request->dualSatz1heim1;
            $satz1G = $request->dualSatz1gast1;
            $satz2H = $request->dualSatz2heim1;
            $satz2G = $request->dualSatz2gast1;
            $satz3H = $request->dualSatz3heim1;
            $satz3G = $request->dualSatz3gast1;
            $dualType = $request->dualType1;
            $art = DB::connection('mysqlSP')->table('art')
                ->select('ID')->where('Name', $dualType)->value('ID');

            DB::connection('mysqlSP')->table('duell')
                ->where('ID', $duellID)
                ->update([

                    'Art' => $art,
                ]);

            DB::connection('mysqlSP')->table('doppel')
                ->where('Duell_ID', $duellID)
                ->update(['Spieler_Heim_1' => $homePID1,
                    'Spieler_Heim_2' => $homePID2,
                    'Spieler_Gast_1' => $guestPID1,
                    'Spieler_Gast_2' => $guestPID2]
                );
            DB::connection('mysqlSP')->table('satz')
                ->where([['Duell_ID', '=', $duellID], ['Satz_Nr', '=', 1]])
                ->update(['Punkte_Heim' => $satz1H,
                    'Punkte_Gast' => $satz1G]);
            DB::connection('mysqlSP')->table('satz')
                ->where([['Duell_ID', '=', $duellID], ['Satz_Nr', '=', 2]])
                ->update(['Punkte_Heim' => $satz2H,
                    'Punkte_Gast' => $satz2G]);
            DB::connection('mysqlSP')->table('satz')
                ->where([['Duell_ID', '=', $duellID], ['Satz_Nr', '=', 3]])
                ->update(['Punkte_Heim' => $satz3H,
                    'Punkte_Gast' => $satz3G]);

        }
        if ($doubleCount >= 2) {
            error_log('dTest2 ');
            $duellID = $request->doppelDuellID2;
            $homeFName1 = $request->dualVnameHeim12;
            $homeLName1 = $request->dualNnameHeim12;
            $homeFName2 = $request->dualVnameHeim22;
            $homeLName2 = $request->dualNnameHeim22;
            $guestFName1 = $request->dualVnameGast12;
            $guestLName1 = $request->dualNnameGast12;
            $guestFName2 = $request->dualVnameGast22;
            $guestLName2 = $request->dualNnameGast22;
            $homePID1 = $this->getPlayerID($homeFName1, $homeLName1);
            $homePID2 = $this->getPlayerID($homeFName2, $homeLName2);
            $guestPID1 = $this->getPlayerID($guestFName1, $guestLName1);
            $guestPID2 = $this->getPlayerID($guestFName2, $guestLName2);
            $satz1H = $request->dualSatz1heim2;
            $satz1G = $request->dualSatz1gast2;
            $satz2H = $request->dualSatz2heim2;
            $satz2G = $request->dualSatz2gast2;
            $satz3H = $request->dualSatz3heim2;
            $satz3G = $request->dualSatz3gast2;
            $dualType = $request->dualType2;
            $art = DB::connection('mysqlSP')->table('art')
                ->select('ID')->where('Name', $dualType)->value('ID');

            DB::connection('mysqlSP')->table('duell')
                ->where('ID', $duellID)
                ->update([

                    'Art' => $art,
                ]);

            DB::connection('mysqlSP')->table('doppel')
                ->where('Duell_ID', $duellID)
                ->update(['Spieler_Heim_1' => $homePID1,
                    'Spieler_Heim_2' => $homePID2,
                    'Spieler_Gast_1' => $guestPID1,
                    'Spieler_Gast_2' => $guestPID2]
                );
            DB::connection('mysqlSP')->table('satz')
                ->where([['Duell_ID', '=', $duellID], ['Satz_Nr', '=', 1]])
                ->update(['Punkte_Heim' => $satz1H,
                    'Punkte_Gast' => $satz1G]);
            DB::connection('mysqlSP')->table('satz')
                ->where([['Duell_ID', '=', $duellID], ['Satz_Nr', '=', 2]])
                ->update(['Punkte_Heim' => $satz2H,
                    'Punkte_Gast' => $satz2G]);
            DB::connection('mysqlSP')->table('satz')
                ->where([['Duell_ID', '=', $duellID], ['Satz_Nr', '=', 3]])
                ->update(['Punkte_Heim' => $satz3H,
                    'Punkte_Gast' => $satz3G]);
        }

        if ($doubleCount >= 3) {
            error_log('dTest3');
            $duellID = $request->doppelDuellID3;
            $homeFName1 = $request->dualVnameHeim13;
            $homeLName1 = $request->dualNnameHeim13;
            $homeFName2 = $request->dualVnameHeim23;
            $homeLName2 = $request->dualNnameHeim23;
            $guestFName1 = $request->dualVnameGast13;
            $guestLName1 = $request->dualNnameGast13;
            $guestFName2 = $request->dualVnameGast23;
            $guestLName2 = $request->dualNnameGast23;
            $homePID1 = $this->getPlayerID($homeFName1, $homeLName1);
            $homePID2 = $this->getPlayerID($homeFName2, $homeLName2);
            $guestPID1 = $this->getPlayerID($guestFName1, $guestLName1);
            $guestPID2 = $this->getPlayerID($guestFName2, $guestLName2);
            $satz1H = $request->dualSatz1heim3;
            $satz1G = $request->dualSatz1gast3;
            $satz2H = $request->dualSatz2heim3;
            $satz2G = $request->dualSatz2gast3;
            $satz3H = $request->dualSatz3heim3;
            $satz3G = $request->dualSatz3gast3;
            $dualType = $request->dualType3;
            error_log($dualType);
            $art = DB::connection('mysqlSP')->table('art')
                ->select('ID')->where('Name', $dualType)->value('ID');
            error_log($art);
            DB::connection('mysqlSP')->table('duell')
                ->where('ID', $duellID)
                ->update([

                    'Art' => $art,
                ]);

            DB::connection('mysqlSP')->table('doppel')
                ->where('Duell_ID', $duellID)
                ->update(['Spieler_Heim_1' => $homePID1,
                    'Spieler_Heim_2' => $homePID2,
                    'Spieler_Gast_1' => $guestPID1,
                    'Spieler_Gast_2' => $guestPID2]
                );
            DB::connection('mysqlSP')->table('satz')
                ->where([['Duell_ID', '=', $duellID], ['Satz_Nr', '=', 1]])
                ->update(['Punkte_Heim' => $satz1H,
                    'Punkte_Gast' => $satz1G]);
            DB::connection('mysqlSP')->table('satz')
                ->where([['Duell_ID', '=', $duellID], ['Satz_Nr', '=', 2]])
                ->update(['Punkte_Heim' => $satz2H,
                    'Punkte_Gast' => $satz2G]);
            DB::connection('mysqlSP')->table('satz')
                ->where([['Duell_ID', '=', $duellID], ['Satz_Nr', '=', 3]])
                ->update(['Punkte_Heim' => $satz3H,
                    'Punkte_Gast' => $satz3G]);
        }

        if ($doubleCount >= 4) {
            error_log('dTest4');
            error_log($request->dualSatz1heim4);
            $duellID = $request->doppelDuellID4;
            $homeFName1 = $request->dualVnameHeim14;
            $homeLName1 = $request->dualNnameHeim14;
            $homeFName2 = $request->dualVnameHeim24;
            $homeLName2 = $request->dualNnameHeim24;
            $guestFName1 = $request->dualVnameGast14;
            $guestLName1 = $request->dualNnameGast14;
            $guestFName2 = $request->dualVnameGast24;
            $guestLName2 = $request->dualNnameGast24;
            $homePID1 = $this->getPlayerID($homeFName1, $homeLName1);
            $homePID2 = $this->getPlayerID($homeFName2, $homeLName2);
            $guestPID1 = $this->getPlayerID($guestFName1, $guestLName1);
            $guestPID2 = $this->getPlayerID($guestFName2, $guestLName2);
            $satz1H = $request->dualSatz1heim4;
            $satz1G = $request->dualSatz1gast4;
            $satz2H = $request->dualSatz2heim4;
            $satz2G = $request->dualSatz2gast4;
            $satz3H = $request->dualSatz3heim4;
            $satz3G = $request->dualSatz3gast4;
            $dualType = $request->dualType4;
            $art = DB::connection('mysqlSP')->table('art')
                ->select('ID')->where('Name', $dualType)->value('ID');

            DB::connection('mysqlSP')->table('duell')
                ->where('ID', $duellID)
                ->update([

                    'Art' => $art,
                ]);

            DB::connection('mysqlSP')->table('doppel')
                ->where('Duell_ID', $duellID)
                ->update(['Spieler_Heim_1' => $homePID1,
                    'Spieler_Heim_2' => $homePID2,
                    'Spieler_Gast_1' => $guestPID1,
                    'Spieler_Gast_2' => $guestPID2]
                );
            DB::connection('mysqlSP')->table('satz')
                ->where([['Duell_ID', '=', $duellID], ['Satz_Nr', '=', 1]])
                ->update(['Punkte_Heim' => $satz1H,
                    'Punkte_Gast' => $satz1G]);
            DB::connection('mysqlSP')->table('satz')
                ->where([['Duell_ID', '=', $duellID], ['Satz_Nr', '=', 2]])
                ->update(['Punkte_Heim' => $satz2H,
                    'Punkte_Gast' => $satz2G]);
            DB::connection('mysqlSP')->table('satz')
                ->where([['Duell_ID', '=', $duellID], ['Satz_Nr', '=', 3]])
                ->update(['Punkte_Heim' => $satz3H,
                    'Punkte_Gast' => $satz3G]);
        }

    }
    //_____________________________________________Texterkennung Korrektur____________________________________________

    //player_overview, teams_overview, check_report, control_handwriting, make_report Liste aller in DB gespeicherten Ligen
    public static function alleLigen()
    {
        $ligen = DB::connection('mysqlSP')->select('SELECT
            *
        FROM
            liga');

        return $ligen;
    }

    //web.php
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

    //web.php
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

    //web.php
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

    //web.php
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

    //web.php
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

    //web.php
    public static function getSpielerNname(Request $request)
    {
        $team = $request->team;
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
                $response[] = array("ID" => $player->ID, "Vname" => $player->Vorname, "Nname" => $player->Nachname);}

        }
        return response()->json($response);
    }

    //web.php
    public static function getSpielerVname(Request $request)
    {
        $team = $request->team;
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
                $response[] = array("ID" => $player->ID, "Vname" => $player->Vorname, "Nname" => $player->Nachname);}
        }

        return response()->json($response);
    }

    //web.php
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

    //web.php
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

    //web.php
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

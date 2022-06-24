@extends('heafoo')

@php

use App\Http\Controllers\QueryController;

#-----------------hier die json bearbeiten, die zurück kommt-----------------------------

$HeimID = '';
$Heim;
$Heimmannschaft_Prob = false;
$GastID = '';
$Gast;
$Gastmannschaft_Prob = false;
$dualHeim_name_11;
$dualHeim_name_11_Prob = false;
$dualHeim_name_21;
$dualHeim_name_21_Prob = false;
$dualGast_name_11;
$dualGast_name_11_Prob = false;
$dualGast_name_21;
$dualGast_name_21_Prob = false;
$dualSatz_1_heim1 = '';
$dualSatz_1_heim1_Prob = false;
$dualSatz_1_gast1 = '';
$dualSatz_1_gast1_Prob = false;
$dualSatz_2_heim1 = '';
$dualSatz_2_heim1_Prob = false;
$dualSatz_2_gast1 = '';
$dualSatz_2_gast1_Prob = false;
$dualSatz_3_heim1 = '';
$dualSatz_3_heim1_Prob = false;
$dualSatz_3_gast1 = '';
$dualSatz_3_gast1_Prob = false;

$dualHeim_name_12;
$dualHeim_name_12_Prob = false;
$dualHeim_name_22;
$dualHeim_name_22_Prob = false;
$dualGast_name_12;
$dualGast_name_12_Prob = false;
$dualGast_name_22;
$dualGast_name_22_Prob = false;
$dualSatz_1_heim2 = '';
$dualSatz_1_heim2_Prob = false;
$dualSatz_1_gast2 = '';
$dualSatz_1_gast2_Prob = false;
$dualSatz_2_heim2 = '';
$dualSatz_2_heim2_Prob = false;
$dualSatz_2_gast2 = '';
$dualSatz_2_gast2_Prob = false;
$dualSatz_3_heim2 = '';
$dualSatz_3_heim2_Prob = false;
$dualSatz_3_gast2 = '';
$dualSatz_3_gast2_Prob = false;

$dualHeim_name_13;
$dualHeim_name_13_Prob = false;
$dualHeim_name_23;
$dualHeim_name_23_Prob = false;
$dualGast_name_13;
$dualGast_name_13_Prob = false;
$dualGast_name_23;
$dualGast_name_23_Prob = false;
$dualSatz_1_heim3 = '';
$dualSatz_1_heim3_Prob = false;
$dualSatz_1_gast3 = '';
$dualSatz_1_gast3_Prob = false;
$dualSatz_2_heim3 = '';
$dualSatz_2_heim3_Prob = false;
$dualSatz_2_gast3 = '';
$dualSatz_2_gast3_Prob = false;
$dualSatz_3_heim3 = '';
$dualSatz_3_heim3_Prob = false;
$dualSatz_3_gast3 = '';
$dualSatz_3_gast3_Prob = false;

$dualHeim_name_14;
$dualHeim_name_14_Prob = false;
$dualHeim_name_24;
$dualHeim_name_24_Prob = false;
$dualGast_name_14;
$dualGast_name_14_Prob = false;
$dualGast_name_24;
$dualGast_name_24_Prob = false;
$dualSatz_1_heim4 = '';
$dualSatz_1_heim4_Prob = false;
$dualSatz_1_gast4 = '';
$dualSatz_1_gast4_Prob = false;
$dualSatz_2_heim4 = '';
$dualSatz_2_heim4_Prob = false;
$dualSatz_2_gast4 = '';
$dualSatz_2_gast4_Prob = false;
$dualSatz_3_heim4 = '';
$dualSatz_3_heim4_Prob = false;
$dualSatz_3_gast4 = '';
$dualSatz_3_gast4_Prob = false;

$soloHeim_name_1;
$soloHeim_name_1_Prob = false;
$soloGast_name_1;
$soloGast_name_1_Prob = false;
$soloSatz_1_heim1 = '';
$soloSatz_1_heim1_Prob = false;
$soloSatz_1_gast1 = '';
$soloSatz_1_gast1_Prob = false;
$soloSatz_2_gast1 = '';
$soloSatz_2_gast1_Prob = false;
$soloSatz_2_heim1 = '';
$soloSatz_2_heim1_Prob = false;
$soloSatz_3_heim1 = '';
$soloSatz_3_heim1_Prob = false;
$soloSatz_3_gast1 = '';
$soloSatz_3_gast1_Prob = false;

$soloHeim_name_2;
$soloHeim_name_2_Prob = false;
$soloGast_name_2;
$soloGast_name_2_Prob = false;
$soloSatz_1_heim2 = '';
$soloSatz_1_heim2_Prob = false;
$soloSatz_1_gast2 = '';
$soloSatz_1_gast2_Prob = false;
$soloSatz_2_gast2 = '';
$soloSatz_2_gast2_Prob = false;
$soloSatz_2_heim2 = '';
$soloSatz_2_heim2_Prob = false;
$soloSatz_3_heim2 = '';
$soloSatz_3_heim2_Prob = false;
$soloSatz_3_gast2 = '';
$soloSatz_3_gast2_Prob = false;

$soloHeim_name_3;
$soloGast_name_3;
$soloSatz_1_heim3 = '';
$soloSatz_1_gast3 = '';
$soloSatz_2_gast3 = '';
$soloSatz_2_heim3 = '';
$soloSatz_3_heim3 = '';
$soloSatz_3_gast3 = '';

$soloHeim_name_4;
$soloGast_name_4;
$soloSatz_1_heim4 = '';
$soloSatz_1_gast4 = '';
$soloSatz_2_gast4 = '';
$soloSatz_2_heim4 = '';
$soloSatz_3_heim4 = '';
$soloSatz_3_gast4 = '';

if (isset($response['Heimmannschaft'])) {
    $HeimID = $response['Heimmannschaft'];
    if (isset($response['Heimmannschaft_Prob'])) {
        $Heimmannschaft_Prob = $response['Heimmannschaft_Prob'];
    }
    $Heim = QueryController::getMannschaftName($HeimID);
}
if (isset($response['Gastmannschaft'])) {
    $GastID = $response['Gastmannschaft'];
    $Gastmannschaft_Prob = $response['Gastmannschaft_Prob'];
    $Gast = QueryController::getMannschaftName($GastID);
}
if (isset($response['Doppel_1'])) {
    if (isset($response['Doppel_1']['Heim_1'])) {
        $dualHeim_11 = $response['Doppel_1']['Heim_1'];
        $dualHeim_name_11_Prob = $response['Doppel_1']['Heim_1_Prob'];
        $dualHeim_name_11 = QueryController::getSpielerName($dualHeim_11);
    }
    if (isset($response['Doppel_1']['Heim_2'])) {
        $dualHeim_21 = $response['Doppel_1']['Heim_2'];
        $dualHeim_name_21_Prob = $response['Doppel_1']['Heim_2_Prob'];
        $dualHeim_name_21 = QueryController::getSpielerName($dualHeim_21);
    }
    if (isset($response['Doppel_1']['Gast_1'])) {
        $dualGast_11 = $response['Doppel_1']['Gast_1'];
        $dualGast_name_11_Prob = $response['Doppel_1']['Gast_1_Prob'];
        $dualGast_name_11 = QueryController::getSpielerName($dualGast_11);
    }
    if (isset($response['Doppel_1']['Gast_2'])) {
        $dualGast_21 = $response['Doppel_1']['Gast_2'];
        $dualGast_name_21_Prob = $response['Doppel_1']['Gast_2_Prob'];
        $dualGast_name_21 = QueryController::getSpielerName($dualGast_21);
    }
    if (isset($response['Doppel_1']['Satz_1'])) {
        if (isset($response['Doppel_1']['Satz_1']['Punkte_Heim'])) {
            $dualSatz_1_heim1_Prob = $response['Doppel_1']['Satz_1']['Punkte_Heim_Prob'];
            $dualSatz_1_heim1 = $response['Doppel_1']['Satz_1']['Punkte_Heim'];
        }
        if (isset($response['Doppel_1']['Satz_1']['Punkte_Gast'])) {
            $dualSatz_1_gast1 = $response['Doppel_1']['Satz_1']['Punkte_Gast'];
            $dualSatz_1_gast1_Prob = $response['Doppel_1']['Satz_1']['Punkte_Gast_Prob'];
        }
    }
    if (isset($response['Doppel_1']['Satz_2'])) {
        if (isset($response['Doppel_1']['Satz_2']['Punkte_Heim'])) {
            $dualSatz_2_heim1 = $response['Doppel_1']['Satz_2']['Punkte_Heim'];
            $dualSatz_2_heim1_Prob = $response['Doppel_1']['Satz_2']['Punkte_Heim_Prob'];
        }
        if (isset($response['Doppel_1']['Satz_2']['Punkte_Gast'])) {
            $dualSatz_2_gast1 = $response['Doppel_1']['Satz_2']['Punkte_Gast'];
            $dualSatz_2_gast1_Prob = $response['Doppel_1']['Satz_2']['Punkte_Gast_Prob'];
        }
    }
    if (isset($response['Doppel_1']['Satz_3'])) {
        if (isset($response['Doppel_1']['Satz_3']['Punkte_Heim'])) {
            $dualSatz_3_heim1 = $response['Doppel_1']['Satz_3']['Punkte_Heim'];
            $dualSatz_3_heim1_Prob = $response['Doppel_1']['Satz_3']['Punkte_Heim_Prob'];
        }
        if (isset($response['Doppel_1']['Satz_3']['Punkte_Gast'])) {
            $dualSatz_3_gast1 = $response['Doppel_1']['Satz_3']['Punkte_Gast'];
            $dualSatz_3_gast1_Prob = $response['Doppel_1']['Satz_3']['Punkte_Gast_Prob'];
        }
    }
}

if (isset($response['Doppel_2'])) {
    if (isset($response['Doppel_2']['Heim_1'])) {
        $dualHeim_12 = $response['Doppel_2']['Heim_1'];
        $dualHeim_name_12_Prob = $response['Doppel_2']['Heim_1_Prob'];
        $dualHeim_name_12 = QueryController::getSpielerName($dualHeim_12);
    }
    if (isset($response['Doppel_2']['Heim_2'])) {
        $dualHeim_22 = $response['Doppel_2']['Heim_2'];
        $dualHeim_name_22_Prob = $response['Doppel_2']['Heim_2_Prob'];
        $dualHeim_name_22 = QueryController::getSpielerName($dualHeim_22);
    }
    if (isset($response['Doppel_2']['Gast_1'])) {
        $dualGast_12 = $response['Doppel_2']['Gast_1'];
        $dualGast_name_12_Prob = $response['Doppel_2']['Gast_1_Prob'];
        $dualGast_name_12 = QueryController::getSpielerName($dualGast_12);
    }
    if (isset($response['Doppel_2']['Gast_2'])) {
        $dualGast_22 = $response['Doppel_2']['Gast_2'];
        $dualGast_name_22_Prob = $response['Doppel_2']['Gast_2_Prob'];
        $dualGast_name_22 = QueryController::getSpielerName($dualGast_22);
    }
    if (isset($response['Doppel_2']['Satz_1'])) {
        if (isset($response['Doppel_2']['Satz_1']['Punkte_Heim'])) {
            $dualSatz_1_heim2 = $response['Doppel_2']['Satz_1']['Punkte_Heim'];
            $dualSatz_1_heim2_Prob = $response['Doppel_2']['Satz_1']['Punkte_Heim_Prob'];
        }
        if (isset($response['Doppel_2']['Satz_1']['Punkte_Gast'])) {
            $dualSatz_1_gast2 = $response['Doppel_2']['Satz_1']['Punkte_Gast'];
            $dualSatz_1_gast2_Prob = $response['Doppel_2']['Satz_1']['Punkte_Gast_Prob'];
        }
    }
    if (isset($response['Doppel_2']['Satz_2'])) {
        if (isset($response['Doppel_2']['Satz_2']['Punkte_Heim'])) {
            $dualSatz_2_heim2 = $response['Doppel_2']['Satz_2']['Punkte_Heim'];
            $dualSatz_2_heim2_Prob = $response['Doppel_2']['Satz_2']['Punkte_Heim_Prob'];
        }
        if (isset($response['Doppel_2']['Satz_2']['Punkte_Gast'])) {
            $dualSatz_2_gast2 = $response['Doppel_2']['Satz_2']['Punkte_Gast'];
            $dualSatz_2_gast2_Prob = $response['Doppel_2']['Satz_2']['Punkte_Gast_Prob'];
        }
    }
    if (isset($response['Doppel_2']['Satz_3'])) {
        if (isset($response['Doppel_2']['Satz_3']['Punkte_Heim'])) {
            $dualSatz_3_heim2 = $response['Doppel_2']['Satz_3']['Punkte_Heim'];
            $dualSatz_3_heim2_Prob = $response['Doppel_2']['Satz_3']['Punkte_Heim_Prob'];
        }
        if (isset($response['Doppel_2']['Satz_3']['Punkte_Gast'])) {
            $dualSatz_3_gast2 = $response['Doppel_2']['Satz_3']['Punkte_Gast'];
            $dualSatz_3_gast2_Prob = $response['Doppel_2']['Satz_3']['Punkte_Gast_Prob'];
        }
    }
}

if (isset($response['Doppel_3'])) {
    if (isset($response['Doppel_3']['Heim_1'])) {
        $dualHeim_13 = $response['Doppel_3']['Heim_1'];
        $dualHeim_name_13_Prob = $response['Doppel_3']['Heim_1_Prob'];
        $dualHeim_name_13 = QueryController::getSpielerName($dualHeim_13);
    }
    if (isset($response['Doppel_3']['Heim_2'])) {
        $dualHeim_23 = $response['Doppel_3']['Heim_2'];
        $dualHeim_name_23_Prob = $response['Doppel_3']['Heim_2_Prob'];
        $dualHeim_name_23 = QueryController::getSpielerName($dualHeim_23);
    }
    if (isset($response['Doppel_3']['Gast_1'])) {
        $dualGast_13 = $response['Doppel_3']['Gast_1'];
        $dualGast_name_13_Prob = $response['Doppel_3']['Gast_1_Prob'];
        $dualGast_name_13 = QueryController::getSpielerName($dualGast_13);
    }
    if (isset($response['Doppel_3']['Gast_2'])) {
        $dualGast_23 = $response['Doppel_3']['Gast_2'];
        $dualGast_name_23_Prob = $response['Doppel_3']['Gast_2_Prob'];
        $dualGast_name_23 = QueryController::getSpielerName($dualGast_23);
    }
    if (isset($response['Doppel_3']['Satz_1'])) {
        if (isset($response['Doppel_3']['Satz_1']['Punkte_Heim'])) {
            $dualSatz_1_heim3 = $response['Doppel_3']['Satz_1']['Punkte_Heim'];
            $dualSatz_1_heim3_Prob = $response['Doppel_3']['Satz_1']['Punkte_Heim_Prob'];
        }
        if (isset($response['Doppel_3']['Satz_1']['Punkte_Gast'])) {
            $dualSatz_1_gast3 = $response['Doppel_3']['Satz_1']['Punkte_Gast'];
            $dualSatz_1_gast3_Prob = $response['Doppel_3']['Satz_1']['Punkte_Gast_Prob'];
        }
    }
    if (isset($response['Doppel_3']['Satz_2'])) {
        if (isset($response['Doppel_3']['Satz_2']['Punkte_Heim'])) {
            $dualSatz_2_heim3 = $response['Doppel_3']['Satz_2']['Punkte_Heim'];
            $dualSatz_2_heim3_Prob = $response['Doppel_3']['Satz_2']['Punkte_Heim_Prob'];
        }
        if (isset($response['Doppel_3']['Satz_2']['Punkte_Gast'])) {
            $dualSatz_2_gast3 = $response['Doppel_3']['Satz_2']['Punkte_Gast'];
            $dualSatz_2_gast3_Prob = $response['Doppel_3']['Satz_2']['Punkte_Gast_Prob'];
        }
    }
    if (isset($response['Doppel_3']['Satz_3'])) {
        if (isset($response['Doppel_3']['Satz_3']['Punkte_Heim'])) {
            $dualSatz_3_heim3 = $response['Doppel_3']['Satz_3']['Punkte_Heim'];
            $dualSatz_3_heim3_Prob = $response['Doppel_3']['Satz_3']['Punkte_Heim_Prob'];
        }
        if (isset($response['Doppel_3']['Satz_3']['Punkte_Gast'])) {
            $dualSatz_3_gast3 = $response['Doppel_3']['Satz_3']['Punkte_Gast'];
            $dualSatz_3_gast3_Prob = $response['Doppel_3']['Satz_3']['Punkte_Gast_Prob'];
        }
    }
}

if (isset($response['Doppel_4'])) {
    if (isset($response['Doppel_4']['Heim_1'])) {
        $dualHeim_14 = $response['Doppel_4']['Heim_1'];
        $dualHeim_name_14_Prob = $response['Doppel_4']['Heim_1_Prob'];
        $dualHeim_name_14 = QueryController::getSpielerName($dualHeim_14);
    }
    if (isset($response['Doppel_4']['Heim_2'])) {
        $dualHeim_24 = $response['Doppel_4']['Heim_2'];
        $dualHeim_name_24_Prob = $response['Doppel_4']['Heim_2_Prob'];
        $dualHeim_name_24 = QueryController::getSpielerName($dualHeim_24);
    }
    if (isset($response['Doppel_4']['Gast_1'])) {
        $dualGast_14 = $response['Doppel_4']['Gast_1'];
        $dualGast_name_14_Prob = $response['Doppel_4']['Gast_1_Prob'];
        $dualGast_name_14 = QueryController::getSpielerName($dualGast_14);
    }
    if (isset($response['Doppel_4']['Gast_2'])) {
        $dualGast_24 = $response['Doppel_4']['Gast_2'];
        $dualGast_name_24_Prob = $response['Doppel_4']['Gast_2_Prob'];
        $dualGast_name_24 = QueryController::getSpielerName($dualGast_24);
    }
    if (isset($response['Doppel_4']['Satz_1'])) {
        if (isset($response['Doppel_4']['Satz_1']['Punkte_Heim'])) {
            $dualSatz_1_heim4 = $response['Doppel_4']['Satz_1']['Punkte_Heim'];
            $dualSatz_1_heim4_Prob = $response['Doppel_4']['Satz_1']['Punkte_Heim_Prob'];
        }
        if (isset($response['Doppel_4']['Satz_1']['Punkte_Gast'])) {
            $dualSatz_1_gast4 = $response['Doppel_4']['Satz_1']['Punkte_Gast'];
            $dualSatz_1_gast4_Prob = $response['Doppel_4']['Satz_1']['Punkte_Gast_Prob'];
        }
    }
    if (isset($response['Doppel_4']['Satz_2'])) {
        if (isset($response['Doppel_4']['Satz_2']['Punkte_Heim'])) {
            $dualSatz_2_heim4 = $response['Doppel_4']['Satz_2']['Punkte_Heim'];
            $dualSatz_2_heim4_Prob = $response['Doppel_4']['Satz_2']['Punkte_Heim_Prob'];
        }
        if (isset($response['Doppel_4']['Satz_2']['Punkte_Gast'])) {
            $dualSatz_2_gast4 = $response['Doppel_4']['Satz_2']['Punkte_Gast'];
            $dualSatz_2_gast4_Prob = $response['Doppel_4']['Satz_2']['Punkte_Gast_Prob'];
        }
    }
    if (isset($response['Doppel_4']['Satz_3'])) {
        if (isset($response['Doppel_4']['Satz_3']['Punkte_Heim'])) {
            $dualSatz_3_heim4 = $response['Doppel_4']['Satz_3']['Punkte_Heim'];
            $dualSatz_3_heim4_Prob = $response['Doppel_4']['Satz_3']['Punkte_Heim_Prob'];
        }
        if (isset($response['Doppel_4']['Satz_3']['Punkte_Gast'])) {
            $dualSatz_3_gast4 = $response['Doppel_4']['Satz_3']['Punkte_Gast'];
            $dualSatz_3_gast4_Prob = $response['Doppel_4']['Satz_3']['Punkte_Gast_Prob'];
        }
    }
}

if (isset($response['Einzel_1'])) {
    if (isset($response['Einzel_1']['Heim'])) {
        $soloHeim_1 = $response['Einzel_1']['Heim'];
        $soloHeim_name_1_Prob = $response['Einzel_1']['Heim_Prob'];
        $soloHeim_name_1 = QueryController::getSpielerName($soloHeim_1);
    }

    if (isset($response['Einzel_1']['Gast'])) {
        $soloGast_1 = $response['Einzel_1']['Gast'];
        $soloGast_name_1_Prob = $response['Einzel_1']['Gast_Prob'];
        $soloGast_name_1 = QueryController::getSpielerName($soloGast_1);
    }

    if (isset($response['Einzel_1']['Satz_1'])) {
        if (isset($response['Einzel_1']['Satz_1']['Punkte_Heim'])) {
            $soloSatz_1_heim1 = $response['Einzel_1']['Satz_1']['Punkte_Heim'];
            $soloSatz_1_heim1_Prob = $response['Einzel_1']['Satz_1']['Punkte_Heim_Prob'];
        }
        if (isset($response['Einzel_1']['Satz_1']['Punkte_Gast'])) {
            $soloSatz_1_gast1 = $response['Einzel_1']['Satz_1']['Punkte_Gast'];
            $soloSatz_1_gast1_Prob = $response['Einzel_1']['Satz_1']['Punkte_Gast_Prob'];
        }
    }
    if (isset($response['Einzel_1']['Satz_2'])) {
        if (isset($response['Einzel_1']['Satz_2']['Punkte_Heim'])) {
            $soloSatz_2_heim1 = $response['Einzel_1']['Satz_2']['Punkte_Heim'];
            $soloSatz_2_heim1_Prob = $response['Einzel_1']['Satz_2']['Punkte_Heim_Prob'];
        }
        if (isset($response['Einzel_1']['Satz_2']['Punkte_Gast'])) {
            $soloSatz_2_gast1 = $response['Einzel_1']['Satz_2']['Punkte_Gast'];
            $soloSatz_2_gast1_Prob = $response['Einzel_1']['Satz_2']['Punkte_Gast_Prob'];
        }
    }
    if (isset($response['Einzel_1']['Satz_3'])) {
        if (isset($response['Einzel_1']['Satz_3']['Punkte_Heim'])) {
            $soloSatz_3_heim1 = $response['Einzel_1']['Satz_3']['Punkte_Heim'];
            $soloSatz_3_heim1_Prob = $response['Einzel_1']['Satz_3']['Punkte_Heim_Prob'];
        }
        if (isset($response['Einzel_1']['Satz_3']['Punkte_Gast'])) {
            $soloSatz_3_gast1 = $response['Einzel_1']['Satz_3']['Punkte_Gast'];
            $soloSatz_3_gast1_Prob = $response['Einzel_1']['Satz_3']['Punkte_Gast_Prob'];
        }
    }
}

if (isset($response['Einzel_2'])) {
    if (isset($response['Einzel_2']['Heim'])) {
        $soloHeim_2 = $response['Einzel_2']['Heim'];
        $soloHeim_name_2_Prob = $response['Einzel_2']['Heim_Prob'];
        $soloHeim_name_2 = QueryController::getSpielerName($soloHeim_2);
    }

    if (isset($response['Einzel_2']['Gast'])) {
        $soloGast_2 = $response['Einzel_2']['Gast'];
        $soloGast_name_2_Prob = $response['Einzel_2']['Gast_Prob'];
        $soloGast_name_2 = QueryController::getSpielerName($soloGast_2);
    }

    if (isset($response['Einzel_2']['Satz_1'])) {
        if (isset($response['Einzel_2']['Satz_1']['Punkte_Heim'])) {
            $soloSatz_1_heim2 = $response['Einzel_2']['Satz_1']['Punkte_Heim'];
            $soloSatz_1_heim2_Prob = $response['Einzel_2']['Satz_1']['Punkte_Heim_Prob'];
        }
    }
    if (isset($response['Einzel_2']['Satz_1']['Punkte_Gast'])) {
        $soloSatz_1_gast2 = $response['Einzel_2']['Satz_1']['Punkte_Gast'];
        $soloSatz_1_gast2_Prob = $response['Einzel_2']['Satz_1']['Punkte_Gast_Prob'];
    }
}
if (isset($response['Einzel_2']['Satz_2'])) {
    if (isset($response['Einzel_2']['Satz_2']['Punkte_Heim'])) {
        $soloSatz_2_heim2 = $response['Einzel_2']['Satz_2']['Punkte_Heim'];
        $soloSatz_2_heim2_Prob = $response['Einzel_2']['Satz_2']['Punkte_Heim_Prob'];
    }
    if (isset($response['Einzel_2']['Satz_2']['Punkte_Gast'])) {
        $soloSatz_2_gast2 = $response['Einzel_2']['Satz_2']['Punkte_Gast'];
        $soloSatz_2_gast2_Prob = $response['Einzel_2']['Satz_2']['Punkte_Gast_Prob'];
    }
}
if (isset($response['Einzel_2']['Satz_3'])) {
    if (isset($response['Einzel_2']['Satz_3']['Punkte_Heim'])) {
        $soloSatz_3_heim2 = $response['Einzel_2']['Satz_3']['Punkte_Heim'];
        $soloSatz_3_heim2_Prob = $response['Einzel_2']['Satz_3']['Punkte_Heim_Prob'];
    }
    if (isset($response['Einzel_2']['Satz_3']['Punkte_Gast'])) {
        $soloSatz_3_gast2 = $response['Einzel_2']['Satz_3']['Punkte_Gast'];
        $soloSatz_3_gast2_Prob = $response['Einzel_2']['Satz_3']['Punkte_Gast_Prob'];
    }
}

if (isset($response['Einzel_3'])) {
    if (isset($response['Einzel_3']['Heim'])) {
        $soloHeim_3 = $response['Einzel_3']['Heim'];
        $soloHeim_name_3 = QueryController::getSpielerName($soloHeim_3);
    }

    if (isset($response['Einzel_3']['Gast'])) {
        $soloGast_3 = $response['Einzel_3']['Gast'];
        $soloGast_name_3 = QueryController::getSpielerName($soloGast_3);
    }

    if (isset($response['Einzel_3']['Satz_1'])) {
        if (isset($response['Einzel_3']['Satz_1']['Punkte_Heim'])) {
            $soloSatz_1_heim3 = $response['Einzel_3']['Satz_1']['Punkte_Heim'];
        }
        if (isset($response['Einzel_3']['Satz_1']['Punkte_Gast'])) {
            $soloSatz_1_gast3 = $response['Einzel_3']['Satz_1']['Punkte_Gast'];
        }
    }
    if (isset($response['Einzel_3']['Satz_2'])) {
        if (isset($response['Einzel_3']['Satz_2']['Punkte_Heim'])) {
            $soloSatz_2_heim3 = $response['Einzel_3']['Satz_2']['Punkte_Heim'];
        }
        if (isset($response['Einzel_3']['Satz_2']['Punkte_Gast'])) {
            $soloSatz_2_gast3 = $response['Einzel_3']['Satz_2']['Punkte_Gast'];
        }
    }
    if (isset($response['Einzel_3']['Satz_3'])) {
        if (isset($response['Einzel_3']['Satz_3']['Punkte_Heim'])) {
            $soloSatz_3_heim3 = $response['Einzel_3']['Satz_3']['Punkte_Heim'];
        }
        if (isset($response['Einzel_3']['Satz_3']['Punkte_Gast'])) {
            $soloSatz_3_gast3 = $response['Einzel_3']['Satz_3']['Punkte_Gast'];
        }
    }
}

if (isset($response['Einzel_4'])) {
    if (isset($response['Einzel_4']['Heim'])) {
        $soloHeim_4 = $response['Einzel_4']['Heim'];
        $soloHeim_name_4 = QueryController::getSpielerName($soloHeim_4);
    }

    if (isset($response['Einzel_4']['Gast'])) {
        $soloGast_4 = $response['Einzel_4']['Gast'];
        $soloGast_name_4 = QueryController::getSpielerName($soloGast_4);
    }

    if (isset($response['Einzel_4']['Satz_1'])) {
        if (isset($response['Einzel_4']['Satz_1']['Punkte_Heim'])) {
            $soloSatz_1_heim4 = $response['Einzel_4']['Satz_1']['Punkte_Heim'];
        }
        if (isset($response['Einzel_4']['Satz_1']['Punkte_Gast'])) {
            $soloSatz_1_gast4 = $response['Einzel_4']['Satz_1']['Punkte_Gast'];
        }
    }
    if (isset($response['Einzel_4']['Satz_2'])) {
        if (isset($response['Einzel_4']['Satz_2']['Punkte_Heim'])) {
            $soloSatz_2_heim4 = $response['Einzel_4']['Satz_2']['Punkte_Heim'];
        }
        if (isset($response['Einzel_4']['Satz_2']['Punkte_Gast'])) {
            $soloSatz_2_gast4 = $response['Einzel_4']['Satz_2']['Punkte_Gast'];
        }
    }
    if (isset($response['Einzel_4']['Satz_3'])) {
        if (isset($response['Einzel_4']['Satz_3']['Punkte_Heim'])) {
            $soloSatz_3_heim4 = $response['Einzel_4']['Satz_3']['Punkte_Heim'];
        }
        if (isset($response['Einzel_4']['Satz_3']['Punkte_Gast'])) {
            $soloSatz_3_gast4 = $response['Einzel_4']['Satz_3']['Punkte_Gast'];
        }
    }
}

@endphp
@section('page-content')
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
    <section>
        <h3 class="font-bold  text-2xl">Spielberichtsbogen</h3>
    </section>
    <section class="mt-10 overflow-auto">
        <div class="w-full flex flex-row lg:justify-center">
            <form class="flex flex-col mx-3 mb-6" method="POST" onsubmit="return validateInputs();" action="{{ url('/upload') }}">
                @csrf
                <input type="hidden" id="matchID" name="matchID">
                <input type="hidden" id="soloCount" name="soloCount" value="2">
                <input type="hidden" id="doubleCount" name="doubleCount" value="4">
                <div class="flex mb-4" id="matchRow">
                    <div class="w-1/full bg-green-400 h-12">
                        <label class="block text-gray-900 text-sm font-bold mb-2 ml-3">Region:</label>
                        <input onfocus="javascript:$(this).autocomplete('search');" oninput="regioncheck()" type="text" id="region" name="region" class="bg-gray-100 text-gray-900 border-gray-700 border-r-2 w-full focus:outline-none border-b-full border-gray-700 focus:border-green-500 transition duration-500 px-3 pb-3">

                    </div>
                    <div class=" w-1/full bg-green-400 h-12">
                        <label class="block text-gray-900 text-sm font-bold mb-2 ml-3">Staffel:</label>
                        <input type="text" onfocus="javascript:$(this).autocomplete('search');" oninput="check()" id="liga" name="liga" class="bg-gray-100 border-gray-700 border-r-2 text-gray-900 w-full focus:outline-none border-b-full border-gray-700 focus:border-green-500 transition duration-500 px-3 pb-3">
                    </div>
                    <div class="w-1/full bg-green-400 h-12">
                        <label class="block text-gray-900 text-sm font-bold mb-2 ml-3">Saison:</label>
                        <input type="text" oninput="saisoncheck()" onfocus="javascript:$(this).autocomplete('search');" name="saison" id="saison" class="bg-gray-100 text-gray-900 border-gray-700 border-r-2  w-full focus:outline-none border-b-full border-gray-700 focus:border-green-500 transition duration-500 px-3 pb-3">
                    </div>
                    <div class="w-1/full bg-green-400 h-12">
                        <label class="block text-gray-900 text-sm font-bold mb-2 ml-3">Runde:</label>
                        <input type="text" oninput="rundecheck()" onfocus="javascript:$(this).autocomplete('search');" name="runde" id="runde" class="bg-gray-100 text-gray-900 border-gray-700 border-r-2  w-full focus:outline-none border-b-full border-gray-700 focus:border-green-500 transition duration-500 px-3 pb-3">
                    </div>
                    <div class="w-1/full bg-green-400 h-12">
                        <label class="block text-gray-900 text-sm font-bold mb-2 ml-3">Spieltag:</label>
                        <input type="text" oninput="tagcheck()" onfocus="javascript:$(this).autocomplete('search');" name="tag" id="tag" class="bg-gray-100 text-gray-900 w-full focus:outline-none border-b-full border-gray-700 border-r-2 focus:border-green-500 transition duration-500 px-3 pb-3">
                    </div>
                    <div class="w-1/full bg-green-400 h-12">
                        <label class="block text-gray-900 text-sm font-bold mb-2 ml-3" for="home">Heimverein:</label>
                        <input onload="MannschaftenH();" onfocus="javascript:MannschaftenH();$(this).autocomplete('search');" oninput="MannschaftenH()" type="text" name=" tfHome" id="tfHome" class="{{ $Heimmannschaft_Prob ? 'bg-gray-100 text-gray-900  w-full focus:outline-none border-b-full border-gray-700 border-r-2  focus:border-green-500 transition duration-500 px-3 pb-3' : 'bg-yellow-300 text-gray-900  w-full focus:outline-none border-b-full border-gray-700 border-r-2  focus:border-green-500 transition duration-500 px-3 pb-3' }}" value="{{ $Heim[0]->Name ?? '' }}">
                    </div>
                    <div class="w-1/full bg-green-400 h-12">
                        <label class="block text-gray-900 text-sm font-bold mb-2 ml-3" for="away">Gastverein:</label>
                        <input onload="MannschaftenG();" onfocus="javascript:MannschaftenG();$(this).autocomplete('search');" type="text" oninput="MannschaftenG()" name="tfAway" id="tfAway" class="{{ $Gastmannschaft_Prob ? 'bg-gray-100 text-gray-900  w-full focus:outlie-none border-b-full border-gray-700  border-r-2 focus:border-green-500 transition duration-500 px-3 pb-3' : 'bg-yellow-300 text-gray-900  w-full focus:outlie-none border-b-full border-gray-700  border-r-2 focus:border-green-500 transition duration-500 px-3 pb-3' }}" value="{{ $Gast[0]->Name ?? '' }}">
                    </div>
                    <div class="w-1/full bg-green-400 h-12">
                        <label class="block text-gray-900 text-sm font-bold mb-2 ml-3" for="away">Schiedsrichter:</label>
                        <input type="text" name="schiri" id="schiri" class="bg-gray-100 text-gray-900  w-full  border-gray-700 border-r-2 focus:outline-none border-b-full border-gray-700 focus:border-green-500 transition duration-500 px-3 pb-3">
                    </div>
                    <div class="w-1/full bg-green-400 h-12">
                        <label class="block text-gray-900 text-sm font-bold mb-2 ml-3" for="away">Austragungsort:</label>
                        <input type="text" name="tfPlace" id="tfPlace" class="bg-gray-100 text-gray-900  w-full focus:outline-none border-b-full border-gray-700 focus:border-green-500 transition duration-500 px-3 pb-3">
                    </div>
                </div>
                <h1>Doppel</h1>
                <table class="w-full flex flex-row flex-wrap rounded-lg my-5" id="tabDouble">
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
                            <th class="w-full  sm:w-4 h-8 sm:h-auto text-center">Gast</th>
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
                            <th class="w-full  sm:w-4 h-8 sm:h-auto text-center">Gast</th>
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
                            <th class="w-full  sm:w-4 h-8 sm:h-auto text-center">Gast</th>
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
                            <th class="w-full  sm:w-4 h-8 sm:h-auto text-center">Gast</th>
                        </tr>
                    </thead>
                    <tbody class="flex-1 sm:flex-none" id="tabDoubleBody">
                        <tr class="border-solid border-b-2 border-black w-44 sm:w-auto flex flex-col flex-no wrap sm:table-row mb-2 sm:mb-0" id="doppel1">
                            <input type="hidden" id="doppelDuellID1" name="doppelDuellID1">
                            <td class="bg-gray-100 h-8 text-black border-solid border-b-2 sm:border-r-2 border-black">
                                <input type="text" list="arten" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300" name="dualType1" id="dualType1" value="GD" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                <input type="text" onload="VnameH(this.id)" oninput="VnameH(this.id)" onfocus="javascript:VnameH(this.id);$(this).autocomplete('search');" size="20" name="dualVnameHeim11" id="dualVnameHeim11" value="{{ $dualHeim_name_11[0]->Vorname ?? '' }}" class="{{ $dualHeim_name_11_Prob ? 'bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 sm:p-1.5' : 'bg-yellow-300 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 sm:p-1.5' }}" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                <input type="text" onload="NnameH(this.id)" oninput="NnameH(this.id)" onfocus="javascript:NnameH(this.id);$(this).autocomplete('search');" size="20" class="{{ $dualHeim_name_11_Prob ? 'bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5' : 'bg-yellow-300 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5' }}" name="dualNnameHeim11" id="dualNnameHeim11" value="{{ $dualHeim_name_11[0]->Nachname ?? '' }}" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                <input type="text" onload="VnameH(this.id)" oninput="VnameH(this.id)" onfocus="javascript:VnameH(this.id);$(this).autocomplete('search');" size="20" class="{{ $dualHeim_name_21_Prob ? 'bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5' : 'bg-yellow-300 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5' }}" name="dualVnameHeim21" id="dualVnameHeim21" value="{{ $dualHeim_name_21[0]->Vorname ?? '' }}" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                <input type="text" onload="NnameH(this.id)" oninput="NnameH(this.id)" onfocus="javascript:NnameH(this.id);$(this).autocomplete('search');" size="20" class="{{ $dualHeim_name_21_Prob ? 'bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5' : 'bg-yellow-300 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5' }}" name="dualNnameHeim21" id="dualNnameHeim21" value="{{ $dualHeim_name_21[0]->Nachname ?? '' }}" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                <input type="text" onload="VnameG(this.id)" oninput="VnameG(this.id)" onfocus="javascript:VnameG(this.id);$(this).autocomplete('search');" size="20" class="{{ $dualGast_name_11_Prob ? 'bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 sm:p-1.5' : 'bg-yellow-300 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 sm:p-1.5' }}" name="dualVnameGast11" id="dualVnameGast11" value="{{ $dualGast_name_11[0]->Vorname ?? '' }}" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                <input type="text" onload="NnameG(this.id)" oninput="NnameG(this.id)" onfocus="javascript:NnameG(this.id);$(this).autocomplete('search');" size="20" class="{{ $dualGast_name_11_Prob ? 'bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5' : 'bg-yellow-300 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5' }}" name="dualNnameGast11" id="dualNnameGast11" value="{{ $dualGast_name_11[0]->Nachname ?? '' }}" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                <input type="text" onload="VnameG(this.id)" oninput="VnameG(this.id)" onfocus="javascript:VnameG(this.id);$(this).autocomplete('search');" size="20" class="{{ $dualGast_name_21_Prob ? 'bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5' : 'bg-yellow-300 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5' }}" name="dualVnameGast21" id="dualVnameGast21" value="{{ $dualGast_name_21[0]->Vorname ?? '' }}" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                <input type="text" onload="NnameG(this.id)" oninput="NnameG(this.id)" onfocus="javascript:NnameG(this.id);$(this).autocomplete('search');" size="20" class="{{ $dualGast_name_21_Prob ? 'bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5' : 'bg-yellow-300 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5' }}" name="dualNnameGast21" id="dualNnameGast21" value="{{ $dualGast_name_21[0]->Nachname ?? '' }}" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                <input type="text" size="4" class="{{ $dualSatz_1_heim1_Prob ? 'bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5' : 'bg-yellow-300 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5' }}" onchange=" changeSetSumD(1)" name="dualSatz1heim1" id="dualSatz1heim1" value="{{ $dualSatz_1_heim1 }}" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                <input type="text" size="4" class="{{ $dualSatz_1_gast1_Prob ? 'bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5' : 'bg-yellow-300 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5' }}" onchange=" changeSetSumD(1)" name="dualSatz1gast1" id="dualSatz1gast1" value="{{ $dualSatz_1_gast1 }}" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                <input type="text" size="4" class="{{ $dualSatz_2_heim1_Prob ? 'bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5' : 'bg-yellow-300 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5' }}" onchange="changeSetSumD(1)" name="dualSatz2heim1" id="dualSatz2heim1" value="{{ $dualSatz_2_heim1 }}" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                <input type="text" size="4" class="{{ $dualSatz_2_gast1_Prob ? 'bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5' : 'bg-yellow-300 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5' }}" onchange=" changeSetSumD(1)" name="dualSatz2gast1" id="dualSatz2gast1" value="{{ $dualSatz_2_gast1 }}" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                <input type="text" size="4" class="{{ $dualSatz_3_heim1_Prob ? 'bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5' : 'bg-yellow-300 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5' }}" onchange=" changeSetSumD(1)" name="dualSatz3heim1" id="dualSatz3heim1" value="{{ $dualSatz_3_heim1 }}" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                <input type="text" size="4" class="{{ $dualSatz_3_gast1_Prob ? 'bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5' : 'bg-yellow-300 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5' }}" onchange=" changeSetSumD(1)" name="dualSatz3gast1" id="dualSatz3gast1" value="{{ $dualSatz_3_gast1 }}" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right p-1.5" readonly="readonly" tabindex="-1" name="dualSetpointHeim1" id="dualSetpointHeim1" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full p-1.5" readonly="readonly" tabindex="-1" name="dualSetpointGast1" id="dualSetpointGast1" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right p-1.5" readonly="readonly" tabindex="-1" name="dualWonSetHeim1" id="dualWonSetHeim1" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full p-1.5" readonly="readonly" tabindex="-1" name="dualWonSetGast1" id="dualWonSetGast1" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right p-1.5" readonly="readonly" tabindex="-1" name="dualWonMatchHeim1" id="dualWonMatchHeim1" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full p-1.5" readonly="readonly" tabindex="-1" name="dualWonMatchGast1" id="dualWonMatchGast1" />
                            </td>
                        </tr>

                        <tr class="border-solid border-b-2 border-black w-44 sm:w-auto flex flex-col flex-no wrap sm:table-row mb-2 sm:mb-0" id="doppel2">
                            <input type="hidden" id="doppelDuellID2" name="doppelDuellID2">
                            <td class="bg-gray-100 h-8 text-black border-solid border-b-2 sm:border-r-2 border-black">
                                <input type="text" list="arten" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300" name="dualType2" id="dualType2" value="GD" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                <input type="text" onload="VnameH(this.id)" oninput="VnameH(this.id)" onfocus="javascript:VnameH(this.id);$(this).autocomplete('search');" size="20" class="{{ $dualHeim_name_12_Prob ? ' bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 sm:p-1.5 ' : ' bg-yellow-300 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 sm:p-1.5' }}" name="dualVnameHeim12" id="dualVnameHeim12" value="{{ $dualHeim_name_12[0]->Vorname ?? '' }}" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                <input type="text" onload="NnameH(this.id)" oninput="NnameH(this.id)" onfocus="javascript:NnameH(this.id);$(this).autocomplete('search');" class="{{ $dualHeim_name_12_Prob ? ' bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5' : ' bg-yellow-300 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5' }}" name="dualNnameHeim12" id="dualNnameHeim12" value="{{ $dualHeim_name_12[0]->Nachname ?? '' }}" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                <input type="text" onload="VnameH(this.id)" oninput="VnameH(this.id)" onfocus="javascript:VnameH(this.id);$(this).autocomplete('search');" size="20" class="{{ $dualHeim_name_22_Prob ? ' bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5' : ' bg-yellow-300 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5' }}" name="dualVnameHeim22" id="dualVnameHeim22" value="{{ $dualHeim_name_22[0]->Vorname ?? '' }}" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                <input type="text" onload="NnameH(this.id)" oninput="NnameH(this.id)" onfocus="javascript:NnameH(this.id);$(this).autocomplete('search');" size="20" class="{{ $dualHeim_name_22_Prob ? 'bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5' : 'bg-yellow-300 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5' }}" name="dualNnameHeim22" id="dualNnameHeim22" value="{{ $dualHeim_name_22[0]->Nachname ?? '' }}" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                <input type="text" onload="VnameG(this.id)" oninput="VnameG(this.id)" onfocus="javascript:VnameG(this.id);$(this).autocomplete('search');" size="20" class="{{ $dualGast_name_12_Prob ? ' bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 sm:p-1.5' : ' bg-yellow-300 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 sm:p-1.5' }}" name="dualVnameGast12" id="dualVnameGast12" value="{{ $dualGast_name_12[0]->Vorname ?? '' }}" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                <input type="text" onload="NnameG(this.id)" oninput="NnameG(this.id)" onfocus="javascript:NnameG(this.id);$(this).autocomplete('search');" class="{{ $dualGast_name_12_Prob ? 'bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5' : 'bg-yellow-300 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5' }}" name="dualNnameGast12" id="dualNnameGast12" value="{{ $dualGast_name_12[0]->Nachname ?? '' }}" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                <input type="text" onload="VnameG(this.id)" oninput="VnameG(this.id)" onfocus="javascript:VnameG(this.id);$(this).autocomplete('search');" size="20" class="{{ $dualGast_name_22_Prob ? 'bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5' : 'bg-yellow-300 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5' }}" name="dualVnameGast22" id="dualVnameGast22" value="{{ $dualGast_name_22[0]->Vorname ?? '' }}" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                <input type="text" onload="NnameG(this.id)" oninput="NnameG(this.id)" onfocus="javascript:NnameG(this.id);$(this).autocomplete('search');" size="20" class="{{ $dualGast_name_22_Prob ? 'bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5' : 'bg-yellow-300 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5' }}" name="dualNnameGast22" id="dualNnameGast22" value="{{ $dualGast_name_22[0]->Nachname ?? '' }}" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                <input type="text" size="4" class="{{ $dualSatz_1_heim2_Prob ? ' bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5' : ' bg-yellow-300 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5' }}" onchange="changeSetSumD(2)" name="dualSatz1heim2" id="dualSatz1heim2" value="{{ $dualSatz_1_heim2 }}" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                <input type="text" size="4" class="{{ $dualSatz_1_gast2_Prob ? 'bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5' : 'bg-yellow-300 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5' }}" onchange=" changeSetSumD(2)" name="dualSatz1gast2" id="dualSatz1gast2" value="{{ $dualSatz_1_gast2 }}" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                <input type="text" size="4" class="{{ $dualSatz_2_heim2_Prob ? ' bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5' : ' bg-yellow-300 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5' }}" onchange=" changeSetSumD(2)" name="dualSatz2heim2" id="dualSatz2heim2" value="{{ $dualSatz_2_heim2 }}" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                <input type="text" size="4" class="{{ $dualSatz_2_gast2_Prob ? 'bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5' : 'bg-yellow-300 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5' }}" onchange=" changeSetSumD(2)" name="dualSatz2gast2" id="dualSatz2gast2" value="{{ $dualSatz_2_gast2 }}" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                <input type="text" size="4" class="{{ $dualSatz_3_heim2_Prob ? 'bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5' : 'bg-yellow-300 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5' }}" onchange="changeSetSumD(2)" name="dualSatz3heim2" id="dualSatz3heim2" value="{{ $dualSatz_3_heim2 }}" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                <input type="text" size="4" class="{{ $dualSatz_3_gast2_Prob ? 'bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5' : 'bg-yellow-300 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5' }}" onchange=" changeSetSumD(2)" name="dualSatz3gast2" id="dualSatz3gast2" value="{{ $dualSatz_3_gast2 }}" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right p-1.5" readonly="readonly" tabindex="-1" name="dualSetpointHeim2" id="dualSetpointHeim2" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full p-1.5" readonly="readonly" tabindex="-1" name="dualSetpointGast2" id="dualSetpointGast2" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right p-1.5" readonly="readonly" tabindex="-1" name="dualWonSetHeim2" id="dualWonSetHeim2" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full p-1.5" readonly="readonly" tabindex="-1" name="dualWonSetGast2" id="dualWonSetGast2" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right p-1.5" readonly="readonly" tabindex="-1" name="dualWonMatchHeim2" id="dualWonMatchHeim2" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full p-1.5" readonly="readonly" tabindex="-1" name="dualWonMatchGast2" id="dualWonMatchGast2" />
                            </td>
                        </tr>

                        <tr class="border-solid border-b-2 border-black w-44 sm:w-auto flex flex-col flex-no wrap sm:table-row mb-2 sm:mb-0" id="doppel3">
                            <input type="hidden" id="doppelDuellID3" name="doppelDuellID3">
                            <td class="bg-gray-100 h-8 text-black border-solid border-b-2 sm:border-r-2 border-black">
                                <input type="text" list="arten" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300" name="dualType3" id="dualType3" value="DD" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                <input type="text" onload="VnameH(this.id)" oninput="VnameH(this.id)" onfocus="javascript:VnameH(this.id);$(this).autocomplete('search');" size="20" class="{{ $dualHeim_name_13_Prob ? ' bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 sm:p-1.5' : ' bg-yellow-300 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 sm:p-1.5' }}" name="dualVnameHeim13" id="dualVnameHeim13" value="{{ $dualHeim_name_13[0]->Vorname ?? '' }}" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                <input type="text" onload="NnameH(this.id)" oninput="NnameH(this.id)" onfocus="javascript:NnameH(this.id);$(this).autocomplete('search');" size="20" class="{{ $dualHeim_name_13_Prob ? 'bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5' : 'bg-yellow-300 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5' }}" name="dualNnameHeim13" id="dualNnameHeim13" value="{{ $dualHeim_name_13[0]->Nachname ?? '' }}" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                <input type="text" onload="VnameH(this.id)" oninput="VnameH(this.id)" onfocus="javascript:VnameH(this.id);$(this).autocomplete('search');" size="20" class="{{ $dualHeim_name_23_Prob ? 'bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5' : 'bg-yellow-300 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5' }}" name="dualVnameHeim23" id="dualVnameHeim23" value="{{ $dualHeim_name_23[0]->Vorname ?? '' }}" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                <input type="text" onload="NnameH(this.id)" oninput="NnameH(this.id)" onfocus="javascript:NnameH(this.id);$(this).autocomplete('search');" size="20" class="{{ $dualHeim_name_23_Prob ? 'bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5' : 'bg-yellow-300 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5' }}" name="dualNnameHeim23" id="dualNnameHeim23" value="{{ $dualHeim_name_23[0]->Nachname ?? '' }}" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                <input type="text" onload="VnameG(this.id)" oninput="VnameG(this.id)" onfocus="javascript:VnameG(this.id);$(this).autocomplete('search');" size="20" class="{{ $dualGast_name_13_Prob ? 'bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 sm:p-1.5' : 'bg-yellow-300 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 sm:p-1.5' }}" name="dualVnameGast13" id="dualVnameGast13" value="{{ $dualGast_name_13[0]->Vorname ?? '' }}" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                <input type="text" onload="NnameG(this.id)" oninput="NnameG(this.id)" onfocus="javascript:NnameG(this.id);$(this).autocomplete('search');" size="20" class="{{ $dualGast_name_13_Prob ? 'bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5' : 'bg-yellow-300 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5' }}" name="dualNnameGast13" id="dualNnameGast13" value="{{ $dualGast_name_13[0]->Nachname ?? '' }}" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                <input type="text" onload="VnameG(this.id)" oninput="VnameG(this.id)" onfocus="javascript:VnameG(this.id);$(this).autocomplete('search');" size="20" class="{{ $dualGast_name_23_Prob ? 'bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5' : 'bg-yellow-300 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5' }}" name="dualVnameGast23" id="dualVnameGast23" value="{{ $dualGast_name_23[0]->Vorname ?? '' }}" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                <input type="text" onload="NnameG(this.id)" oninput="NnameG(this.id)" onfocus="javascript:NnameG(this.id);$(this).autocomplete('search');" size="20" class="{{ $dualGast_name_23_Prob ? 'bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5' : 'bg-yellow-300 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5' }}" name="dualNnameGast23" id="dualNnameGast23" value="{{ $dualGast_name_23[0]->Nachname ?? '' }}" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                <input type="text" size="4" class="{{ $dualSatz_1_heim3_Prob ? 'bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5' : 'bg-yellow-300 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5' }}" onchange=" changeSetSumD(3)" name="dualSatz1heim3" id="dualSatz1heim3" value="{{ $dualSatz_1_heim3 }}" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                <input type="text" size="4" class="{{ $dualSatz_1_gast3_Prob ? 'bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5' : 'bg-yellow-300 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5' }}" onchange=" changeSetSumD(3)" name="dualSatz1gast3" id="dualSatz1gast3" value="{{ $dualSatz_1_gast3 }}" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                <input type="text" size="4" class="{{ $dualSatz_2_heim3_Prob ? 'bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5' : 'bg-yellow-300 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5' }}" onchange="changeSetSumD(3)" name="dualSatz2heim3" id="dualSatz2heim3" value="{{ $dualSatz_2_heim3 }}" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                <input type="text" size="4" class="{{ $dualSatz_2_gast3_Prob ? 'bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5' : 'bg-yeellow-300 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5' }}" onchange=" changeSetSumD(3)" name="dualSatz2gast3" id="dualSatz2gast3" value="{{ $dualSatz_2_gast3 }}" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                <input type="text" size="4" class="{{ $dualSatz_3_heim3_Prob ? 'bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5' : 'bg-yellow-300 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5' }}" onchange=" changeSetSumD(3)" name="dualSatz3heim3" id="dualSatz3heim3" value="{{ $dualSatz_3_heim3 }}" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                <input type="text" size="4" class="{{ $dualSatz_3_gast3_Prob ? 'bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5' : 'bg-yellow-300 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5' }}" onchange=" changeSetSumD(3)" name="dualSatz3gast3" id="dualSatz3gast3" value="{{ $dualSatz_3_gast3 }}" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right p-1.5" readonly="readonly" tabindex="-1" name="dualSetpointHeim3" id="dualSetpointHeim3" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full p-1.5" readonly="readonly" tabindex="-1" name="dualSetpointGast3" id="dualSetpointGast3" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right p-1.5" readonly="readonly" tabindex="-1" name="dualWonSetHeim3" id="dualWonSetHeim3" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full p-1.5" readonly="readonly" tabindex="-1" name="dualWonSetGast3" id="dualWonSetGast3" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right p-1.5" readonly="readonly" tabindex="-1" name="dualWonMatchHeim3" id="dualWonMatchHeim3" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full p-1.5" readonly="readonly" tabindex="-1" name="dualWonMatchGast3" id="dualWonMatchGast3" />
                            </td>
                        </tr>
                        <tr class="border-solid border-b-2 border-black w-44 sm:w-auto flex flex-col flex-no wrap sm:table-row mb-2 sm:mb-0" id="doppel4">
                            <input type="hidden" id="doppelDuellID4" name="doppelDuellID4">
                            <td class="bg-gray-100 h-8 text-black border-solid border-b-2 sm:border-r-2 border-black">
                                <input type="text" list="arten" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300" name="dualType4" id="dualType4" value="HD" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                <input type="text" onload="VnameH(this.id)" oninput="VnameH(this.id)" onfocus="javascript:VnameH(this.id);$(this).autocomplete('search');" size="20" class="{{ $dualHeim_name_14_Prob ? 'bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 sm:p-1.5' : 'bg-yellow-300 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 sm:p-1.5' }}" name="dualVnameHeim14" id="dualVnameHeim14" value="{{ $dualHeim_name_14[0]->Vorname ?? '' }}" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                <input type="text" onload="NnameH(this.id)" oninput="NnameH(this.id)" onfocus="javascript:NnameH(this.id);$(this).autocomplete('search');" size="20" class="{{ $dualHeim_name_14_Prob ? 'bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5' : 'bg-yellow-300 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5' }}" name="dualNnameHeim14" id="dualNnameHeim14" value="{{ $dualHeim_name_14[0]->Nachname ?? '' }}" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                <input type="text" onload="VnameH(this.id)" oninput="VnameH(this.id)" onfocus="javascript:VnameH(this.id);$(this).autocomplete('search');" size="20" class="{{ $dualHeim_name_24_Prob ? 'bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5' : 'bg-yellow-300 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5' }}" name="dualVnameHeim24" id="dualVnameHeim24" value="{{ $dualHeim_name_24[0]->Vorname ?? '' }}" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                <input type="text" onload="NnameH(this.id)" oninput="NnameH(this.id)" onfocus="javascript:NnameH(this.id);$(this).autocomplete('search');" size="20" class="{{ $dualHeim_name_24_Prob ? 'bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5' : 'bg-yellow-300 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5' }}" name="dualNnameHeim24" id="dualNnameHeim24" value="{{ $dualHeim_name_24[0]->Nachname ?? '' }}" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                <input type="text" onload="VnameG(this.id)" oninput="VnameG(this.id)" onfocus="javascript:VnameG(this.id);$(this).autocomplete('search');" size="20" class="{{ $dualGast_name_14_Prob ? 'bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 sm:p-1.5' : 'bg-yellow-300 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 sm:p-1.5' }}" name="dualVnameGast14" id="dualVnameGast14" value="{{ $dualGast_name_14[0]->Vorname ?? '' }}" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                <input type="text" onload="NnameG(this.id)" oninput="NnameG(this.id)" onfocus="javascript:NnameG(this.id);$(this).autocomplete('search');" size="20" class="{{ $dualGast_name_14_Prob ? 'bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5' : 'bg-yellow-300 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5' }}" name="dualNnameGast14" id="dualNnameGast14" value="{{ $dualGast_name_14[0]->Nachname ?? '' }}" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                <input type="text" onload="VnameG(this.id)" oninput="VnameG(this.id)" onfocus="javascript:VnameG(this.id);$(this).autocomplete('search');" size="20" class="{{ $dualGast_name_24_Prob ? 'bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5' : 'bg-yellow-300 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5' }}" name="dualVnameGast24" id="dualVnameGast24" value="{{ $dualGast_name_24[0]->Vorname ?? '' }}" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                <input type="text" onload="NnameG(this.id)" oninput="NnameG(this.id)" onfocus="javascript:NnameG(this.id);$(this).autocomplete('search');" size="20" class="{{ $dualGast_name_24_Prob ? 'bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5' : 'bg-yellow-300 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5' }}" name="dualNnameGast24" id="dualNnameGast24" value="{{ $dualGast_name_24[0]->Nachname ?? '' }}" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                <input type="text" size="4" class="{{ $dualSatz_1_heim4_Prob ? ' bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5' : ' bg-yellow-300 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5' }}" onchange=" changeSetSumD(4)" name="dualSatz1heim4" id="dualSatz1heim4" value="{{ $dualSatz_1_heim4 }}" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                <input type="text" size="4" class="{{ $dualSatz_1_gast4_Prob ? 'bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5' : 'bg-yellow-300 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5' }}" onchange=" changeSetSumD(4)" name="dualSatz1gast4" id="dualSatz1gast4" value="{{ $dualSatz_1_gast4 }}" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                <input type="text" size="4" class="{{ $dualSatz_2_heim4_Prob ? 'bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5' : ' bg-yellow-300 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5' }}" onchange="changeSetSumD(4)" name="dualSatz2heim4" id="dualSatz2heim4" value="{{ $dualSatz_2_heim4 }}" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                <input type="text" size="4" class="{{ $dualSatz_2_gast4_Prob ? 'bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5' : 'bg-yellow-300 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5' }}" onchange=" changeSetSumD(4)" name="dualSatz2gast4" id="dualSatz2gast4" value="{{ $dualSatz_2_gast4 }}" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                <input type="text" size="4" class="{{ $dualSatz_3_heim4_Prob ? 'bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5' : 'bg-yellow-300 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5' }}" onchange=" changeSetSumD(4)" name="dualSatz3heim4" id="dualSatz3heim4" value="{{ $dualSatz_3_heim4 }}" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                <input type="text" size="4" class="{{ $dualSatz_3_gast4_Prob ? 'bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5' : 'bg-yellow-300 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5' }}" onchange=" changeSetSumD(4)" name="dualSatz3gast4" id="dualSatz3gast4" value="{{ $dualSatz_3_gast4 }}" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right p-1.5" readonly="readonly" tabindex="-1" name="dualSetpointHeim4" id="dualSetpointHeim4" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full p-1.5" readonly="readonly" tabindex="-1" name="dualSetpointGast4" id="dualSetpointGast4" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right p-1.5" readonly="readonly" tabindex="-1" name="dualWonSetHeim4" id="dualWonSetHeim4" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full p-1.5" readonly="readonly" tabindex="-1" name="dualWonSetGast4" id="dualWonSetGast4" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right p-1.5" readonly="readonly" tabindex="-1" name="dualWonMatchHeim4" id="dualWonMatchHeim4" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full p-1.5" readonly="readonly" tabindex="-1" name="dualWonMatchGast4" id="dualWonMatchGast4" />
                            </td>
                        </tr>
                        <tr class="border-solid border-black w-44 sm:w-auto flex flex-col flex-no wrap sm:table-row mb-2 sm:mb-0">
                            <td colspan="15" class="invisible border-solid sm:border-r-2 border-black">
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right cursor-default p-1.5" readonly="readonly" tabindex="-1" name="sumSetHomeDual" id="sumSetHomeDual" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full cursor-default p-1.5" readonly="readonly" tabindex="-1" name="sumSetGuestDual" id="sumSetGuestDual" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right cursor-default p-1.5" readonly="readonly" tabindex="-1" name="sumWonSetHomeDual" id="sumWonSetHomeDual" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full cursor-default p-1.5" readonly="readonly p-1.5" tabindex="-1" name="sumWonSetGuestDual" id="sumWonSetGuestDual" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right cursor-default p-1.5" readonly="readonly" tabindex="-1" name="sumWonMatchHomeDual" id="sumWonMatchHomeDual" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full cursor-default p-1.5" readonly="readonly" tabindex="-1" name="sumWonMatchGuestDual" id="sumWonMatchGuestDual" />
                            </td>
                        </tr>
                    </tbody>
                </table>


                <h1 class="pt-5">Einzel</h1>

                <input type="hidden" name="regionID" id="regionID">
                <input type="hidden" name="ligaID" id="ligaID">
                <input type="hidden" name="HeimID" id="HeimID" value="{{ $HeimID }}">
                <input type="hidden" name="GastID" id="GastID" value="{{ $GastID }}">
                <input type="hidden" name="saisonID" id="saisonID">
                <input type="hidden" name="rundeID" id="rundeID">
                <input type="hidden" name="tagID" id="tagID">
                <table class="w-full flex flex-row flex-wrap rounded-lg my-5" id="tabSolo">
                    <thead>
                        <tr class="bg-green-400 flex flex-col sm:table-row rounded-l-lg sm:rounded-none mb-2 sm:mb-0">
                            <th class="w-28 h-8 sm:h-auto sm:w-4 border-solid sm:border-r-2 align-middle text-center">Art</th>
                            <th class="w-28 h-16 sm:h-auto sm:w-4 border-solid sm:border-r-2 align-middle text-center" colspan="2">Spieler: Heim</th>
                            <th class="w-28 h-16 sm:h-auto sm:w-4 border-solid sm:border-r-2 align-middle text-center" rowspan="2" colspan="2">Spieler: Gast</th>
                            <th class="w-28 h-48 sm:h-auto sm:w-4 border-solid sm:border-r-2 align-middle text-center" rowspan="6" colspan="6">Satzergebnisse</th>
                            <th class="w-28 h-16 sm:h-auto sm:w-4 border-solid sm:border-r-2 align-middle text-center" rowspan="2" colspan="2">Summe: Spielpunkte</th>
                            <th class="w-28 h-16 sm:h-auto sm:w-4 border-solid sm:border-r-2 align-middle text-center" rowspan="2" colspan="2">Summe: Sätze</th>
                            <th class="w-28 h-16 sm:h-auto sm:w-4 border-solid align-middle text-center" rowspan="2" colspan="2">Punkte</th>
                        </tr>

                        <tr class="bg-green-400 flex flex-col sm:table-row rounded-l-lg sm:rounded-none mb-2 sm:mb-0">
                            <th class="w-28 h-8 sm:h-auto sm:w-4 border-solid sm:border-r-2 sm:text-center">Art</th>
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
                            <th class="w-full sm:w-4 h-8 sm:h-auto text-center">Gast</th>
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
                            <th class="w-full sm:w-4 h-8 sm:h-auto text-center">Gast</th>
                        </tr>
                    </thead>
                    <tbody class="flex-1 sm:flex-none" id="tabSoloBody">

                        <tr class="border-solid border-b-2 border-black w-44 sm:w-auto flex flex-col flex-no wrap sm:table-row mb-2 sm:mb-0" id="solo1">
                            <input type="hidden" id="duellID1" name="duellID1">
                            <td class="bg-gray-100 h-8 text-black border-solid border-b-2 sm:border-r-2 border-black">
                                <input type="text" list="arten" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300" name="soloType1" id="soloType1" value="HE" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                <input type="text" onload="VnameH(this.id)" oninput="VnameH(this.id)" onfocus="VnameH(this.id);javascript:$(this).autocomplete('search');" size="20" class="{{ $soloHeim_name_1_Prob ? ' bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 sm:p-1.5' : ' bg-yellow-300 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 sm:p-1.5' }}" name="soloVnameHeim1" id="soloVnameHeim1" value="{{ $soloHeim_name_1[0]->Vorname ?? '' }}" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                <input type="text" onload="NnameH(this.id)" oninput="NnameH(this.id)" onfocus="NnameH(this.id);javascript:$(this).autocomplete('search');" size="20" class="{{ $soloHeim_name_1_Prob ? ' bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5' : 'bg-yellow-300 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5' }}" name="soloNnameHeim1" id="soloNnameHeim1" value="{{ $soloHeim_name_1[0]->Nachname ?? '' }}" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                <input type="text" onload="VnameG(this.id)" onfocus="javascript:VnameG(this.id);$(this).autocomplete('search');" oninput="VnameG(this.id)" size="20" class="{{ $soloGast_name_1_Prob ? 'bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5' : 'bg-yellow-300 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5' }}" name="soloVnameGast1" id="soloVnameGast1" value="{{ $soloGast_name_1[0]->Vorname ?? '' }}" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                <input type="text" onload="NnameG(this.id)" onfocus="javascript:NnameG(this.id);$(this).autocomplete('search');" oninput="NnameG(this.id)" size="20" class="{{ $soloGast_name_1_Prob ? 'bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5' : 'bg-yellow-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5' }}" name="soloNnameGast1" id="soloNnameGast1" value="{{ $soloGast_name_1[0]->Nachname ?? '' }}" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                <input type="text" size="4" class="{{ $soloSatz_1_heim1_Prob ? 'bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5' : 'bg-yellow-300 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5' }}" onchange=" changeSetSumS(1)" name="soloSatz1heim1" id="soloSatz1heim1" value="{{ $soloSatz_1_heim1 }}" />

                            </td>
                            <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                <input type="text" size="4" class="{{ $soloSatz_1_gast1_Prob ? 'bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5' : 'bg-yellow-300 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5' }}" onchange=" changeSetSumS(1)" name="soloSatz1gast1" id="soloSatz1gast1" value="{{ $soloSatz_1_gast1 }}" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                <input type="text" size="4" class="{{ $soloSatz_2_gast1_Prob ? 'bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5' : 'bg-yellow-300 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5' }}" onchange=" changeSetSumS(1)" name="soloSatz2heim1" id="soloSatz2heim1" value="{{ $soloSatz_2_heim1 }}" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                <input type="text" size="4" class="{{ $soloSatz_1_gast1_Prob ? 'bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5' : 'bg-yellow-300 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5' }}" onchange=" changeSetSumS(1)" name="soloSatz2gast1" id="soloSatz2gast1" value="{{ $soloSatz_2_gast1 }}" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                <input type="text" size="4" class="{{ $soloSatz_3_heim1_Prob ? 'bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5' : 'bg-yellow-300 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5' }}" onchange=" changeSetSumS(1)" name="soloSatz3heim1" id="soloSatz3heim1" value="{{ $soloSatz_3_heim1 }}" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                <input type="text" size="4" class="{{ $soloSatz_3_gast1_Prob ? 'bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5' : 'bg-yellow-300 text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5' }}" onchange=" changeSetSumS(1)" name="soloSatz3gast1" id="soloSatz3gast1" value="{{ $soloSatz_3_gast1 }}" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right p-1.5" readonly="readonly" tabindex="-1" name="soloSetpointHeim1" id="soloSetpointHeim1" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full p-1.5" readonly="readonly" tabindex="-1" name="soloSetpointGast1" id="soloSetpointGast1" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right p-1.5" readonly="readonly" tabindex="-1" name="soloWonSetHeim1" id="soloWonSetHeim1" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full p-1.5" readonly="readonly" tabindex="-1" name="soloWonSetGast1" id="soloWonSetGast1" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right p-1.5" readonly="readonly" tabindex="-1" name="soloWonMatchHeim1" id="soloWonMatchHeim1" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full p-1.5" readonly="readonly" tabindex="-1" name="soloWonMatchGast1" id="soloWonMatchGast1" />
                            </td>
                        </tr>

                        <tr class="border-solid border-b-2 border-black w-44 sm:w-auto flex flex-col flex-no wrap sm:table-row mb-2 sm:mb-0" id="solo2">
                            <input type="hidden" id="duellID2" name="duellID2">
                            <td class="bg-gray-100 h-8 text-black border-solid border-b-2 sm:border-r-2 border-black">
                                <input type="text" list="arten" size="4" class="bg-gray-100 text-black w-full h-full focus:bg-green-400 transition duration-300" name="soloType2" id="soloType2" value="DE" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                <input type="text" onload="VnameH(this.id)" onfocus="javascript:VnameH(this.id);$(this).autocomplete('search');" oninput="VnameH(this.id)" size="20" size="20" class="{{ $soloHeim_name_2_Prob ? 'bg-gray-100 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5' : 'bg-yellow-300 text-black w-full h-full sm:text-right focus:bg-green-400 transition duration-300 p-1.5' }}" name="soloVnameHeim2" id="soloVnameHeim2" value="{{ $soloHeim_name_2[0]->Vorname ?? '' }}" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                <input type="text" onload="NnameH(this.id)" onfocus="javascript:NnameH(this.id);$(this).autocomplete('search');" oninput="NnameH(this.id)" size="20" class="{{ $soloHeim_name_2_Prob ? 'bg-gray-100 p-1.5 text-black w-full focus:bg-green-400 transition duration-300' : 'bg-yellow-300 p-1.5 text-black w-full focus:bg-green-400 transition duration-300' }}" name="soloNnameHeim2" id="soloNnameHeim2" value="{{ $soloHeim_name_2[0]->Nachname ?? '' }}" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                <input type="text" onload="VnameG(this.id)" onfocus="javascript:VnameG(this.id);$(this).autocomplete('search');" oninput="VnameG(this.id)" size="20" class="{{ $soloGast_name_2_Prob ? 'bg-gray-100 text-black w-full h-full sm:text-right  focus:bg-green-400 transition duration-300 p-1.5' : 'bg-yellow-300 text-black w-full h-full sm:text-right  focus:bg-green-400 transition duration-300 p-1.5' }}" name="soloVnameGast2" id="soloVnameGast2" value="{{ $soloGast_name_2[0]->Vorname ?? '' }}" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                <input type="text" onload="NnameG(this.id)" onfocus="javascript:NnameG(this.id);$(this).autocomplete('search');" oninput="NnameG(this.id)" size="20" class="{{ $soloGast_name_2_Prob ? ' bg-gray-100 p-1.5 text-black w-full focus:bg-green-400 transition duration-300' : ' bg-yellow-300 p-1.5 text-black w-full focus:bg-green-400 transition duration-300' }}" name="soloNnameGast2" id="soloNnameGast2" value="{{ $soloGast_name_2[0]->Nachname ?? '' }}" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                <input type="text" size="4" class="{{ $soloSatz_1_heim2_Prob ? 'bg-gray-100 sm:text-right text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5' : 'bg-yellow-300 sm:text-right text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5' }}" onchange=" changeSetSumS(2)" name="soloSatz1heim2" id="soloSatz1heim2" value="{{ $soloSatz_1_heim2 }}" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                <input type="text" size="4" class="{{ $soloSatz_1_gast2_Prob ? 'bg-gray-100 p-1.5 text-black w-full focus:bg-green-400 transition duration-300' : 'bg-yellow-300 p-1.5 text-black w-full focus:bg-green-400 transition duration-300' }}" onchange=" changeSetSumS(2)" name="soloSatz1gast2" id="soloSatz1gast2" value="{{ $soloSatz_1_gast2 }}" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                <input type="text" size="4" class="{{ $soloSatz_2_heim2_Prob ? 'bg-gray-100 sm:text-right text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5' : 'bg-yellow-300 sm:text-right text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5' }}" onchange=" changeSetSumS(2)" name="soloSatz2heim2" id="soloSatz2heim2" value="{{ $soloSatz_2_heim2 }}" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                <input type="text" size="4" class="{{ $soloSatz_2_gast2_Prob ? 'bg-gray-100 p-1.5 text-black w-full focus:bg-green-400 transition duration-300' : 'bg-yellow-300 p-1.5 text-black w-full focus:bg-green-400 transition duration-300' }}" onchange=" changeSetSumS(2)" name="soloSatz2gast2" id="soloSatz2gast2" value="{{ $soloSatz_2_gast2 }}" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                <input type="text" size="4" class="{{ $soloSatz_3_heim2_Prob ? 'bg-gray-100 sm:text-right text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5' : 'bg-yellow-300 sm:text-right text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5' }}" onchange=" changeSetSumS(2)" name="soloSatz3heim2" id="soloSatz3heim2" value="{{ $soloSatz_3_heim2 }}" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                <input type="text" size="4" class="{{ $soloSatz_3_gast2_Prob ? ' bg-gray-100 p-1.5 text-black w-full focus:bg-green-400 transition duration-300' : ' bg-yellow-300 p-1.5 text-black w-full focus:bg-green-400 transition duration-300' }}" onchange=" changeSetSumS(2)" name="soloSatz3gast2" id="soloSatz3gast2" value="{{ $soloSatz_3_gast2 }}" />
                            </td>
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                <input type="text" size="4" class="bg-gray-100 sm:text-right text-black w-full h-full p-1.5" readonly="readonly" tabindex="-1" name="soloSetpointHeim2" id="soloSetpointHeim2" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                <input type="text" size="4" class="bg-gray-100 p-1.5 text-black w-full focus:bg-green-400 transition duration-300" readonly="readonly" tabindex="-1" name="soloSetpointGast2" id="soloSetpointGast2" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                <input type="text" size="4" class="bg-gray-100 sm:text-right text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" name="soloWonSetHeim2" readonly="readonly" tabindex="-1" id="soloWonSetHeim2" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                <input type="text" size="4" class="bg-gray-100 p-1.5 text-black w-full focus:bg-green-400 transition duration-300" readonly="readonly" tabindex="-1" name="soloWonSetGast2" id="soloWonSetGast2" />
                            <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                <input type="text" size="4" class="bg-gray-100 sm:text-right text-black w-full h-full focus:bg-green-400 transition duration-300 p-1.5" name="soloWonMatchHeim2" readonly="readonly" tabindex="-1" id="soloWonMatchHeim2" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black">
                                <input type="text" size="4" class="bg-gray-100 p-1.5 text-black w-full focus:bg-green-400 transition duration-300" readonly="readonly" tabindex="-1" name="soloWonMatchGast2" id="soloWonMatchGast2" />
                            </td>
                        </tr>

                        <tr class="border-solid border-black w-44 sm:w-auto flex flex-col flex-no wrap sm:table-row mb-2 sm:mb-0">
                            <td colspan="11" class="invisible border-solid sm:border-r-2 border-black">
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right cursor-default p-1.5" readonly="readonly" tabindex="-1" name="sumSetHomeSolo" id="sumSetHomeSolo" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full cursor-default p-1.5" readonly="readonly" tabindex="-1" name="sumSetGuestSolo" id="sumSetGuestSolo" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right cursor-default p-1.5" readonly="readonly" tabindex="-1" name="sumWonSetHomeSolo" id="sumWonSetHomeSolo" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full cursor-default p-1.5" readonly="readonly p-1.5" tabindex="-1" name="sumWonSetGuestSolo" id="sumWonSetGuestSolo" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right cursor-default p-1.5" readonly="readonly" tabindex="-1" name="sumWonMatchHomeSolo" id="sumWonMatchHomeSolo" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full cursor-default p-1.5" readonly="readonly" tabindex="-1" name="sumWonMatchGuestSolo" id="sumWonMatchGuestSolo" />
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table>
                    <thead>
                        <tr class="bg-green-400 flex flex-col sm:table-row rounded-l-lg sm:rounded-none mb-2 sm:mb-0">
                            <th class="w-28 h-16 sm:h-auto sm:w-4 border-solid sm:border-r-2 align-middle text-center">Spielpunkte Gesamt: Heim</th>
                            <th class="w-28 h-16 sm:h-auto sm:w-4 border-solid sm:border-r-2 align-middle text-center">Spielpunkte Gesamt: Gast</th>
                            <th class="w-28 h-16 sm:h-auto sm:w-4 border-solid sm:border-r-2 align-middle text-center">Sätze Gesamt: Heim</th>
                            <th class="w-28 h-16 sm:h-auto sm:w-4 border-solid sm:border-r-2 align-middle text-center">Sätze Gesamt: Gast</th>
                            <th class="w-28 h-16 sm:h-auto sm:w-4 border-solid sm:border-r-2 align-middle text-center">Punkte Gesamt: Heim</th>
                            <th class="w-28 h-16 sm:h-auto sm:w-4 border-solid sm:border-r-2 align-middle text-center">Punkte Gesamt: Gast</th>
                        </tr>
                    </thead>
                    <tbody class="flex-1 sm:flex-none" id="tabTotal">
                        <tr class="border-solid border-black w-44 sm:w-auto flex flex-col flex-no wrap sm:table-row mb-2 sm:mb-0">
                            <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right cursor-default p-1.5" readonly="readonly" tabindex="-1" name="sumSetHomeTotal" id="sumSetHomeTotal" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full cursor-default p-1.5" readonly="readonly" tabindex="-1" name="sumSetGuestTotal" id="sumSetGuestTotal" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right cursor-default p-1.5" readonly="readonly" tabindex="-1" name="sumWonSetHomeTotal" id="sumWonSetHomeTotal" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-solid sm:border-r-2 border-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full cursor-default p-1.5" readonly="readonly p-1.5" tabindex="-1" name="sumWonSetGuestTotal" id="sumWonSetGuestTotal" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black border-dashed sm:border-r-2 border-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full sm:text-right cursor-default p-1.5" readonly="readonly" tabindex="-1" name="sumWonMatchHomeTotal" id="sumWonMatchHomeTotal" />
                            </td>
                            <td class="bg-gray-100 h-8 text-black">
                                <input type="text" size="4" class="bg-gray-100 text-black w-full h-full cursor-default p-1.5" readonly="readonly" tabindex="-1" name="sumWonMatchGuestTotal" id="sumWonMatchGuestTotal" />
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="mt-3 flex place-content-end">
                    <div>
                        <button class="my-2 float-right px-3 py-3 rounded bg-green-500 active:bg-green-700 text-white text-sm   font-bold" type="submit" id="submitBTN" name="submit">Absenden</button>
                    </div>
                </div>
            </form>

        </div>
    </section>
@endsection

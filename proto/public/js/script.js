function activateSubmit() {
    var btSubmit = document.getElementById("submitBTN");
    btSubmit.disabled = false;
}

function validateInputs() {
    var complete = true;
    var soloCount = document.getElementById("soloCount").value; //Anzahl verwendeter Reihen
    var doubleCount = parseInt(document.getElementById("doubleCount").value);
    console.log(soloCount);
    var league = document.getElementById("liga");
    var home = document.getElementById("tfHome");
    var away = document.getElementById("tfAway");
    var place = document.getElementById("tfPlace");
    //Wird Bericht abgelehtn, findet keine Pruefung statt, da nichts geupdated wird.
    //Dies wird im QueryController beruecksichtigt
    var selectedRB = document.getElementsByName("rbState");
    if (selectedRB[1].checked == true) {
        return true;
    }
    //Oberste Reihen Pruefen
    if (league.value.trim() == "") {
        complete = false;
        alert("Liga fehlt");
    }
    if (home.value.trim() == "") {
        complete = false;
        alert("Heim fehlt");

    }
    if (away.value.trim() == "") {
        complete = false;
        alert("Gast fehlt");
    }
    if (place.value.trim() == "") {
        complete = false;
        alert("Spielstätte fehlt");
    }
    if (soloCount >= 1) {
        var type1 = document.getElementById("soloType1").value.trim();
        var hVName1 = document.getElementById("soloVnameHeim1").value.trim();
        var hNName1 = document.getElementById("soloNnameHeim1").value.trim();
        var gVName1 = document.getElementById("soloVnameGast1").value.trim();
        var gNName1 = document.getElementById("soloNnameGast1").value.trim();
        var hSatz1_1 = document.getElementById("soloSatz1heim1").value.trim();
        var gSatz1_1 = document.getElementById("soloSatz1gast1").value.trim();
        var hSatz2_1 = document.getElementById("soloSatz2heim1").value.trim();
        var gSatz2_1 = document.getElementById("soloSatz2gast1").value.trim();
        var hSatz3_1 = document.getElementById("soloSatz2heim1").value.trim();
        var gSatz3_1 = document.getElementById("soloSatz2gast1").value.trim();
        var hWonSets1 = document.getElementById("soloSumpointHeim1").value.trim();
        var gWonSets1 = document.getElementById("soloSumpointGast1").value.trim();
        var hWonGames1 = document.getElementById("soloPointHeim1").value.trim();
        var gWonGames1 = document.getElementById("soloPointGast1").value.trim();
        if (type1 == "" || hVName1 == "" || hNName1 == "" || gVName1 == "" || hSatz1_1 == "" ||
            gSatz1_1 == "" || hSatz2_1 == "" || gSatz2_1 == "" || hSatz3_1 == "" || gSatz3_1 == "" ||
            hWonSets1 == "" || gWonSets1 == "" || hWonGames1 == "" || gWonGames1 == "") {
            complete = false;
            alert("Fehlender Eintrag in Zeile 1");
        }

    }
    if (soloCount >= 2) {
        var type2 = document.getElementById("soloType2").value.trim();
        var hVName2 = document.getElementById("soloVnameHeim2").value.trim();
        var hNName2 = document.getElementById("soloNnameHeim2").value.trim();
        var gVName2 = document.getElementById("soloVnameGast2").value.trim();
        var gNName2 = document.getElementById("soloNnameGast2").value.trim();
        var hSatz1_2 = document.getElementById("soloSatz1heim2").value.trim();
        var gSatz1_2 = document.getElementById("soloSatz1gast2").value.trim();
        var hSatz2_2 = document.getElementById("soloSatz2heim2").value.trim();
        var gSatz2_2 = document.getElementById("soloSatz2gast2").value.trim();
        var hSatz3_2 = document.getElementById("soloSatz2heim2").value.trim();
        var gSatz3_2 = document.getElementById("soloSatz2gast2").value.trim();
        var hWonSets2 = document.getElementById("soloSumpointHeim2").value.trim();
        var gWonSets2 = document.getElementById("soloSumpointGast2").value.trim();
        var hWonGames2 = document.getElementById("soloPointHeim2").value.trim();
        var gWonGames2 = document.getElementById("soloPointGast2").value.trim();
        if (type2 == "" || hVName2 == "" || hNName2 == "" || gVName2 == "" || hSatz1_2 == "" ||
            gSatz1_2 == "" || hSatz2_2 == "" || gSatz2_2 == "" || hSatz3_2 == "" || gSatz3_2 == "" ||
            hWonSets2 == "" || gWonSets2 == "" || hWonGames2 == "" || gWonGames2 == "") {
            complete = false;
            alert("Fehlender Eintrag in Zeile 2");
        }
    } {
        var type3 = document.getElementById("soloType3").value.trim();
        var hVName3 = document.getElementById("soloVnameHeim3").value.trim();
        var hNName3 = document.getElementById("soloNnameHeim3").value.trim();
        var gVName3 = document.getElementById("soloVnameGast3").value.trim();
        var gNName3 = document.getElementById("soloNnameGast3").value.trim();
        var hSatz1_3 = document.getElementById("soloSatz1heim3").value.trim();
        var gSatz1_3 = document.getElementById("soloSatz1gast3").value.trim();
        var hSatz2_3 = document.getElementById("soloSatz2heim3").value.trim();
        var gSatz2_3 = document.getElementById("soloSatz2gast3").value.trim();
        var hSatz3_3 = document.getElementById("soloSatz2heim3").value.trim();
        var gSatz3_3 = document.getElementById("soloSatz2gast3").value.trim();
        var hWonSets3 = document.getElementById("soloSumpointHeim3").value.trim();
        var gWonSets3 = document.getElementById("soloSumpointGast3").value.trim();
        var hWonGames3 = document.getElementById("soloPointHeim3").value.trim();
        var gWonGames3 = document.getElementById("soloPointGast3").value.trim();
        if (type3 == "" || hVName3 == "" || hNName3 == "" || gVName3 == "" || hSatz1_3 == "" ||
            gSatz1_3 == "" || hSatz2_3 == "" || gSatz2_3 == "" || hSatz3_3 == "" || gSatz3_3 == "" ||
            hWonSets3 == "" || gWonSets3 == "" || hWonGames3 == "" || gWonGames3 == "") {
            complete = false;
            alert("Fehlender Eintrag in Zeile 3");
        }
    }
    if (soloCount >= 4) {
        var type4 = document.getElementById("soloType4").value.trim();
        var hVName4 = document.getElementById("soloVnameHeim4").value.trim();
        var hNName4 = document.getElementById("soloNnameHeim4").value.trim();
        var gVName4 = document.getElementById("soloVnameGast4").value.trim();
        var gNName4 = document.getElementById("soloNnameGast4").value.trim();
        var hSatz1_4 = document.getElementById("soloSatz1heim4").value.trim();
        var gSatz1_4 = document.getElementById("soloSatz1gast4").value.trim();
        var hSatz2_4 = document.getElementById("soloSatz2heim4").value.trim();
        var gSatz2_4 = document.getElementById("soloSatz2gast4").value.trim();
        var hSatz3_4 = document.getElementById("soloSatz2heim4").value.trim();
        var gSatz3_4 = document.getElementById("soloSatz2gast4").value.trim();
        var hWonSets4 = document.getElementById("soloSumpointHeim4").value.trim();
        var gWonSets4 = document.getElementById("soloSumpointGast4").value.trim();
        var hWonGames4 = document.getElementById("soloPointHeim4").value.trim();
        var gWonGames4 = document.getElementById("soloPointGast4").value.trim();
        if (type4 == "" || hVName4 == "" || hNName4 == "" || gVName4 == "" || hSatz1_4 == "" ||
            gSatz1_4 == "" || hSatz2_4 == "" || gSatz2_4 == "" || hSatz3_4 == "" || gSatz3_4 == "" ||
            hWonSets4 == "" || gWonSets4 == "" || hWonGames4 == "" || gWonGames4 == "") {
            complete = false;
            alert("Fehlender Eintrag in Zeile 4");
        }
    }
    if (doubleCount >= 1) {

    }
    if (doubleCount >= 2) {

    }
    if (complete == false) {
        return false;
    }

    return true;
}
function hello() {
    console.log("Hanlo");
}

function changeSetSumS(row) {
    var homeGes = 0;
    var guestGes = 0;
    if (row == 1) {
        var home1 = parseInt(document.getElementById("soloSatz1heim1").value.trim());
        var home2 = parseInt(document.getElementById("soloSatz2heim1").value.trim());
        var home3 = parseInt(document.getElementById("soloSatz3heim1").value.trim());
        var guest1 = parseInt(document.getElementById("soloSatz1gast1").value.trim());
        var guest2 = parseInt(document.getElementById("soloSatz2gast1").value.trim());
        var guest3 = parseInt(document.getElementById("soloSatz3gast1").value.trim());
        var homeSum = home1 + home2 + home3;
        var guestSum = guest1 + guest2 + guest3;
        homeGes = homeGes + homeSum;
        guestGes = guestGes + guestSum;
        document.getElementById("soloSetpointHeim1").value = homeSum;
        document.getElementById("soloSetpointGast1").value = guestSum;
        document.getElementById("soloSumpointHeim1").value = homeGes;
        document.getElementById("soloSumpointGast1").value = guestGes;
        if (homeSum > guestSum) {
            document.getElementById("soloPointHeim1").value = "2";
            document.getElementById("soloPointGastt1").value = "0";
        } else if (homeSum < guestSum) {
            document.getElementById("soloPointHeim1").value = "0";
            document.getElementById("soloPointGast1").value = "2";

        } else {
            document.getElementById("soloPointHeim1").value = "1";
            document.getElementById("soloPointGast1").value = "1";

        }

    } else if (row == 2) {

    } else if (row == 3) {

    } else if (row == 4) {

    }
}

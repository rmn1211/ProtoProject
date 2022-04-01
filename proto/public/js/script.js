function activateSubmit()
{
    var btSubmit = document.getElementById("submitBTN");
    btSubmit.disabled = false;
    btSubmit.classList.remove('opacity-70');
    btSubmit.classList.add('opacity-100');
}

function validateInputs()
{
    var complete = true;
    var soloCount = document.getElementById("soloCount").value; //Anzahl verwendeter Reihen
    var doubleCount = parseInt(document.getElementById("doubleCount").value);
    console.log(soloCount);
    var league = document.getElementById("liga");
    var home = document.getElementById("tfHome");
    var away = document.getElementById("tfAway");
    var tag = document.getElementById("tag");
    var place = document.getElementById("tfPlace");
    //Wird Bericht abgelehtn, findet keine Pruefung statt, da nichts geupdated wird.
    //Dies wird im QueryController beruecksichtigt
    var selectedRB = document.getElementsByName("rbState");
    if (selectedRB[1].checked == true)
    {
        return true;
    }
    //Oberste Reihen Pruefen
    if (league.value.trim() == "")
    {
        complete = false;
        alert("Liga fehlt");
    }
    if (home.value.trim() == "")
    {
        complete = false;
        alert("Heim fehlt");

    }
    if (away.value.trim() == "")
    {
        complete = false;
        alert("Gast fehlt");
    }
    if (place.value.trim() == "")
    {
        complete = false;
        alert("Spielstätte fehlt");
    }
    if (soloCount >= 1)
    {
        var type1 = document.getElementById("soloType1").value.trim();
        var hVName1 = document.getElementById("soloVnameHeim1").value.trim();
        var hNName1 = document.getElementById("soloNnameHeim1").value.trim();
        var gVName1 = document.getElementById("soloVnameGast1").value.trim();
        var gNName1 = document.getElementById("soloNnameGast1").value.trim();
        var hSatz1_1 = document.getElementById("soloSatz1heim1").value.trim();
        var gSatz1_1 = document.getElementById("soloSatz1gast1").value.trim();
        var hSatz2_1 = document.getElementById("soloSatz2heim1").value.trim();
        var gSatz2_1 = document.getElementById("soloSatz2gast1").value.trim();
        var hSatz3_1 = document.getElementById("soloSatz3heim1").value.trim();
        var gSatz3_1 = document.getElementById("soloSatz3gast1").value.trim();
        var hWonSets1 = document.getElementById("soloWonSetHeim1").value.trim();
        var gWonSets1 = document.getElementById("soloWonSetGast1").value.trim();
        var hWonGames1 = document.getElementById("soloWonMatchHeim1").value.trim();
        var gWonGames1 = document.getElementById("soloWonMatchGast1").value.trim();
        if (type1 == "" || hVName1 == "" || hNName1 == "" || gVName1 == "" || gNName1 == "" || hSatz1_1 == "" ||
            gSatz1_1 == "" || hSatz2_1 == "" || gSatz2_1 == "" || hSatz3_1 == "" || gSatz3_1 == "" ||
            hWonSets1 == "" || gWonSets1 == "" || hWonGames1 == "" || gWonGames1 == "")
        {
            complete = false;
            alert("Fehlender Eintrag in Zeile 1");
        }

    }
    if (soloCount >= 2)
    {
        var type2 = document.getElementById("soloType2").value.trim();
        var hVName2 = document.getElementById("soloVnameHeim2").value.trim();
        var hNName2 = document.getElementById("soloNnameHeim2").value.trim();
        var gVName2 = document.getElementById("soloVnameGast2").value.trim();
        var gNName2 = document.getElementById("soloNnameGast2").value.trim();
        var hSatz1_2 = document.getElementById("soloSatz1heim2").value.trim();
        var gSatz1_2 = document.getElementById("soloSatz1gast2").value.trim();
        var hSatz2_2 = document.getElementById("soloSatz2heim2").value.trim();
        var gSatz2_2 = document.getElementById("soloSatz2gast2").value.trim();
        var hSatz3_2 = document.getElementById("soloSatz3heim2").value.trim();
        var gSatz3_2 = document.getElementById("soloSatz3gast2").value.trim();
        var hWonSets2 = document.getElementById("soloWonSetHeim2").value.trim();
        var gWonSets2 = document.getElementById("soloWonSetGast2").value.trim();
        var hWonGames2 = document.getElementById("soloWonMatchHeim2").value.trim();
        var gWonGames2 = document.getElementById("soloWonMatchGast2").value.trim();
        if (type2 == "" || hVName2 == "" || hNName2 == "" || gVName2 == "" || gNName2 == "" || hSatz1_2 == "" ||
            gSatz1_2 == "" || hSatz2_2 == "" || gSatz2_2 == "" || hSatz3_2 == "" || gSatz3_2 == "" ||
            hWonSets2 == "" || gWonSets2 == "" || hWonGames2 == "" || gWonGames2 == "")
        {
            complete = false;
            alert("Fehlender Eintrag in Zeile 2");
        }
    } if (soloCount >= 3)
    {
        var type3 = document.getElementById("soloType3").value.trim();
        var hVName3 = document.getElementById("soloVnameHeim3").value.trim();
        var hNName3 = document.getElementById("soloNnameHeim3").value.trim();
        var gVName3 = document.getElementById("soloVnameGast3").value.trim();
        var gNName3 = document.getElementById("soloNnameGast3").value.trim();
        var hSatz1_3 = document.getElementById("soloSatz1heim3").value.trim();
        var gSatz1_3 = document.getElementById("soloSatz1gast3").value.trim();
        var hSatz2_3 = document.getElementById("soloSatz2heim3").value.trim();
        var gSatz2_3 = document.getElementById("soloSatz2gast3").value.trim();
        var hSatz3_3 = document.getElementById("soloSatz3heim3").value.trim();
        var gSatz3_3 = document.getElementById("soloSatz3gast3").value.trim();
        var hWonSets3 = document.getElementById("soloWonSetHeim3").value.trim();
        var gWonSets3 = document.getElementById("soloWonSetGast3").value.trim();
        var hWonGames3 = document.getElementById("soloWonMatchHeim3").value.trim();
        var gWonGames3 = document.getElementById("soloWonMatchGast3").value.trim();
        if (type3 == "" || hVName3 == "" || hNName3 == "" || gVName3 == "" || gNName3 == "" || hSatz1_3 == "" ||
            gSatz1_3 == "" || hSatz2_3 == "" || gSatz2_3 == "" || hSatz3_3 == "" || gSatz3_3 == "" ||
            hWonSets3 == "" || gWonSets3 == "" || hWonGames3 == "" || gWonGames3 == "")
        {
            complete = false;
            alert("Fehlender Eintrag in Zeile 3");
        }
    }
    if (soloCount >= 4)
    {
        var type4 = document.getElementById("soloType4").value.trim();
        var hVName4 = document.getElementById("soloVnameHeim4").value.trim();
        var hNName4 = document.getElementById("soloNnameHeim4").value.trim();
        var gVName4 = document.getElementById("soloVnameGast4").value.trim();
        var gNName4 = document.getElementById("soloNnameGast4").value.trim();
        var hSatz1_4 = document.getElementById("soloSatz1heim4").value.trim();
        var gSatz1_4 = document.getElementById("soloSatz1gast4").value.trim();
        var hSatz2_4 = document.getElementById("soloSatz2heim4").value.trim();
        var gSatz2_4 = document.getElementById("soloSatz2gast4").value.trim();
        var hSatz3_4 = document.getElementById("soloSatz3heim4").value.trim();
        var gSatz3_4 = document.getElementById("soloSatz3gast4").value.trim();
        var hWonSets4 = document.getElementById("soloWonSetHeim4").value.trim();
        var gWonSets4 = document.getElementById("soloWonSetGast4").value.trim();
        var hWonGames4 = document.getElementById("soloWonMatchHeim4").value.trim();
        var gWonGames4 = document.getElementById("soloWonMatchGast4").value.trim();
        if (type4 == "" || hVName4 == "" || hNName4 == "" || gVName4 == "" || gNName4 == "" || hSatz1_4 == "" ||
            gSatz1_4 == "" || hSatz2_4 == "" || gSatz2_4 == "" || hSatz3_4 == "" || gSatz3_4 == "" ||
            hWonSets4 == "" || gWonSets4 == "" || hWonGames4 == "" || gWonGames4 == "")
        {
            complete = false;
            alert("Fehlender Eintrag in Zeile 4");
        }
    }
    if (doubleCount >= 1)
    {
        var dualType1 = document.getElementById("dualType1").value.trim();
        var hVName1_1 = document.getElementById("dualVnameHeim11").value.trim();
        var hNName1_1 = document.getElementById("dualNnameHeim11").value.trim();
        var hVName2_1 = document.getElementById("dualVnameHeim21").value.trim();
        var hNName2_1 = document.getElementById("dualNnameHeim21").value.trim();
        var gVName1_1 = document.getElementById("dualVnameGast11").value.trim();
        var gNName1_1 = document.getElementById("dualNnameGast11").value.trim();
        var gVName2_1 = document.getElementById("dualVnameGast21").value.trim();
        var gNName2_1 = document.getElementById("dualNnameGast21").value.trim();
        var hSatz1_1 = document.getElementById("dualSatz1heim1").value.trim();
        var gSatz1_1 = document.getElementById("dualSatz1gast1").value.trim();
        var hSatz2_1 = document.getElementById("dualSatz2heim1").value.trim();
        var gSatz2_1 = document.getElementById("dualSatz2gast1").value.trim();
        var hSatz3_1 = document.getElementById("dualSatz3heim1").value.trim();
        var gSatz3_1 = document.getElementById("dualSatz3gast1").value.trim();
        var hWonSets1 = document.getElementById("dualWonSetHeim1").value.trim();
        var gWonSets1 = document.getElementById("dualWonSetGast1").value.trim();
        var hWonGames1 = document.getElementById("dualWonMatchHeim1").value.trim();
        var gWonGames1 = document.getElementById("dualWonMatchGast1").value.trim();
        if (dualType1 == "" || hVName1_1 == "" || hNName1_1 == "" || hVName2_1 == "" || hNName2_1 == "" || gVName1_1 == "" || gNName1_1 == "" || gVName2_1 == "" || gNName2_1 == "" ||
            hSatz1_1 == "" || gSatz1_1 == "" || hSatz2_1 == "" || gSatz2_1 == "" || hSatz3_1 == "" || gSatz3_1 == "" ||
            hWonSets1 == "" || gWonSets1 == "" || hWonGames1 == "" || gWonGames1 == "")
        {
            complete = false;
            alert("Fehlender Eintrag in Zeile 1 der Doppel");
        }
    }
    if (doubleCount >= 2)
    {
        var dualType1 = document.getElementById("dualType1").value.trim();
        var hVName1_2 = document.getElementById("dualVnameHeim12").value.trim();
        var hNName1_2 = document.getElementById("dualNnameHeim12").value.trim();
        var hVName2_2 = document.getElementById("dualVnameHeim22").value.trim();
        var hNName2_2 = document.getElementById("dualNnameHeim22").value.trim();
        var gVName1_2 = document.getElementById("dualVnameGast12").value.trim();
        var gNName1_2 = document.getElementById("dualNnameGast12").value.trim();
        var gVName2_2 = document.getElementById("dualVnameGast22").value.trim();
        var gNName2_2 = document.getElementById("dualNnameGast22").value.trim();
        var hSatz1_2 = document.getElementById("dualSatz1heim2").value.trim();
        var gSatz1_2 = document.getElementById("dualSatz1gast2").value.trim();
        var hSatz2_2 = document.getElementById("dualSatz2heim2").value.trim();
        var gSatz2_2 = document.getElementById("dualSatz2gast2").value.trim();
        var hSatz3_2 = document.getElementById("dualSatz3heim2").value.trim();
        var gSatz3_2 = document.getElementById("dualSatz3gast2").value.trim();
        var hWonSets2 = document.getElementById("dualWonSetHeim2").value.trim();
        var gWonSets2 = document.getElementById("dualWonSetGast2").value.trim();
        var hWonGames2 = document.getElementById("dualWonMatchHeim2").value.trim();
        var gWonGames2 = document.getElementById("dualWonMatchGast2").value.trim();
        if (dualType2 == "" || hVName1_2 == "" || hNName1_2 == "" || hVName2_2 == "" || hNName2_2 == "" || gVName1_2 == "" || gNName1_2 == "" || gVName2_2 == "" || gNName2_2 == "" ||
            hSatz1_2 == "" || gSatz1_2 == "" || hSatz2_2 == "" || gSatz2_1 == "" || hSatz3_2 == "" || gSatz3_2 == "" ||
            hWonSets2 == "" || gWonSets2 == "" || hWonGames2 == "" || gWonGames2 == "")
        {
            complete = false;
            alert("Fehlender Eintrag in Zeile 2 der Doppel");
        }
    }
    if (doubleCount >= 3)
    {
        var dualType3 = document.getElementById("dualType3").value.trim();
        var hVName1_3 = document.getElementById("dualVnameHeim13").value.trim();
        var hNName1_3 = document.getElementById("dualNnameHeim13").value.trim();
        var hVName2_3 = document.getElementById("dualVnameHeim23").value.trim();
        var hNName2_3 = document.getElementById("dualNnameHeim23").value.trim();
        var gVName1_3 = document.getElementById("dualVnameGast13").value.trim();
        var gNName1_3 = document.getElementById("dualNnameGast13").value.trim();
        var gVName2_3 = document.getElementById("dualVnameGast23").value.trim();
        var gNName2_3 = document.getElementById("dualNnameGast23").value.trim();
        var hSatz1_3 = document.getElementById("dualSatz1heim3").value.trim();
        var gSatz1_3 = document.getElementById("dualSatz1gast3").value.trim();
        var hSatz2_3 = document.getElementById("dualSatz2heim3").value.trim();
        var gSatz2_3 = document.getElementById("dualSatz2gast3").value.trim();
        var hSatz3_3 = document.getElementById("dualSatz3heim3").value.trim();
        var gSatz3_3 = document.getElementById("dualSatz3gast3").value.trim();
        var hWonSets3 = document.getElementById("dualWonSetHeim3").value.trim();
        var gWonSets3 = document.getElementById("dualWonSetGast3").value.trim();
        var hWonGames3 = document.getElementById("dualWonMatchHeim3").value.trim();
        var gWonGames3 = document.getElementById("dualWonMatchGast3").value.trim();
        if (dualType3 == "" || hVName1_3 == "" || hNName1_3 == "" || hVName2_3 == "" || hNName2_3 == "" || gVName1_3 == "" || gNName1_3 == "" || gVName2_3 == "" || gNName2_3 == "" ||
            hSatz1_3 == "" || gSatz1_3 == "" || hSatz2_3 == "" || gSatz2_3 == "" || hSatz3_3 == "" || gSatz3_3 == "" ||
            hWonSets3 == "" || gWonSets3 == "" || hWonGames3 == "" || gWonGames3 == "")
        {
            complete = false;
            alert("Fehlender Eintrag in Zeile 3 der Doppel");
        }
    }
    if (doubleCount >= 4)
    {
        var dualType4 = document.getElementById("dualType4").value.trim();
        var hVName1_4 = document.getElementById("dualVnameHeim14").value.trim();
        var hNName1_4 = document.getElementById("dualNnameHeim14").value.trim();
        var hVName2_4 = document.getElementById("dualVnameHeim24").value.trim();
        var hNName2_4 = document.getElementById("dualNnameHeim24").value.trim();
        var gVName1_4 = document.getElementById("dualVnameGast14").value.trim();
        var gNName1_4 = document.getElementById("dualNnameGast14").value.trim();
        var gVName2_4 = document.getElementById("dualVnameGast24").value.trim();
        var gNName2_4 = document.getElementById("dualNnameGast24").value.trim();
        var hSatz1_4 = document.getElementById("dualSatz1heim4").value.trim();
        var gSatz1_4 = document.getElementById("dualSatz1gast4").value.trim();
        var hSatz2_4 = document.getElementById("dualSatz2heim4").value.trim();
        var gSatz2_4 = document.getElementById("dualSatz2gast4").value.trim();
        var hSatz3_4 = document.getElementById("dualSatz3heim4").value.trim();
        var gSatz3_4 = document.getElementById("dualSatz3gast4").value.trim();
        var hWonSets4 = document.getElementById("dualWonSetHeim4").value.trim();
        var gWonSets4 = document.getElementById("dualWonSetGast4").value.trim();
        var hWonGames4 = document.getElementById("dualWonMatchHeim4").value.trim();
        var gWonGames4 = document.getElementById("dualWonMatchGast4").value.trim();
        if (dualType4 == "" || hVName1_4 == "" || hNName1_4 == "" || hVName2_4 == "" || hNName2_4 == "" || gVName1_4 == "" || gNName1_4 == "" || gVName2_4 == "" || gNName2_4 == "" ||
            hSatz1_4 == "" || gSatz1_4 == "" || hSatz2_4 == "" || gSatz2_4 == "" || hSatz3_4 == "" || gSatz3_4 == "" ||
            hWonSets4 == "" || gWonSets4 == "" || hWonGames4 == "" || gWonGames4 == "")
        {
            complete = false;
            alert("Fehlender Eintrag in Zeile 4 der Doppel");
        }
    }

    if (complete == false)
    {
        return false;
    }

    return true;
}

function validateInputsUpload()
{
    var complete = true;
    var soloCount = document.getElementById("soloCount").value; //Anzahl verwendeter Reihen
    var doubleCount = parseInt(document.getElementById("doubleCount").value);
    console.log(soloCount);
    var league = document.getElementById("liga");
    var home = document.getElementById("tfHome");
    var away = document.getElementById("tfAway");
    var tag = document.getElementById("tag");
    var place = document.getElementById("tfPlace");
    //Wird Bericht abgelehtn, findet keine Pruefung statt, da nichts geupdated wird.
    //Dies wird im QueryController beruecksichtigt

    //Oberste Reihen Pruefen
    if (league.value.trim() == "")
    {
        complete = false;
        alert("Liga fehlt");
    }
    if (home.value.trim() == "")
    {
        complete = false;
        alert("Heim fehlt");

    }
    if (away.value.trim() == "")
    {
        complete = false;
        alert("Gast fehlt");
    }
    if (place.value.trim() == "")
    {
        complete = false;
        alert("Spielstätte fehlt");
    }

    var type1 = document.getElementById("soloType1").value.trim();
    var hVName1 = document.getElementById("soloVnameHeim1").value.trim();
    var hNName1 = document.getElementById("soloNnameHeim1").value.trim();
    var gVName1 = document.getElementById("soloVnameGast1").value.trim();
    var gNName1 = document.getElementById("soloNnameGast1").value.trim();
    var hSatz1_1 = document.getElementById("soloSatz1heim1").value.trim();
    var gSatz1_1 = document.getElementById("soloSatz1gast1").value.trim();
    var hSatz2_1 = document.getElementById("soloSatz2heim1").value.trim();
    var gSatz2_1 = document.getElementById("soloSatz2gast1").value.trim();
    var hSatz3_1 = document.getElementById("soloSatz3heim1").value.trim();
    var gSatz3_1 = document.getElementById("soloSatz3gast1").value.trim();
    var hWonSets1 = document.getElementById("soloWonSetHeim1").value.trim();
    var gWonSets1 = document.getElementById("soloWonSetGast1").value.trim();
    var hWonGames1 = document.getElementById("soloWonMatchHeim1").value.trim();
    var gWonGames1 = document.getElementById("soloWonMatchGast1").value.trim();
    if (type1 != "" && hVName1 != "" && hNName1 != "" && gVName1 != "" && gNName1 != "" && hSatz1_1 != "" &&
        gSatz1_1 != "" && hSatz2_1 != "" && gSatz2_1 != "" && hSatz3_1 != "" && gSatz3_1 != "" &&
        hWonSets1 != "" && gWonSets1 != "" && hWonGames1 != "" && gWonGames1 != "")
    {
        document.getElementById("soloCount").value = 1;
    }
    else
    {
        complete = false; alert("mindestestn ein Spiel eintragen");
    }



    var type2 = document.getElementById("soloType2").value.trim();
    var hVName2 = document.getElementById("soloVnameHeim2").value.trim();
    var hNName2 = document.getElementById("soloNnameHeim2").value.trim();
    var gVName2 = document.getElementById("soloVnameGast2").value.trim();
    var gNName2 = document.getElementById("soloNnameGast2").value.trim();
    var hSatz1_2 = document.getElementById("soloSatz1heim2").value.trim();
    var gSatz1_2 = document.getElementById("soloSatz1gast2").value.trim();
    var hSatz2_2 = document.getElementById("soloSatz2heim2").value.trim();
    var gSatz2_2 = document.getElementById("soloSatz2gast2").value.trim();
    var hSatz3_2 = document.getElementById("soloSatz3heim2").value.trim();
    var gSatz3_2 = document.getElementById("soloSatz3gast2").value.trim();
    var hWonSets2 = document.getElementById("soloWonSetHeim2").value.trim();
    var gWonSets2 = document.getElementById("soloWonSetGast2").value.trim();
    var hWonGames2 = document.getElementById("soloWonMatchHeim2").value.trim();
    var gWonGames2 = document.getElementById("soloWonMatchGast2").value.trim();
    if (type2 != "" && hVName2 != "" && hNName2 != "" && gVName2 != "" && gNName2 != "" && hSatz1_2 != "" &&
        gSatz1_2 != "" && hSatz2_2 != "" && gSatz2_2 != "" && hSatz3_2 != "" && gSatz3_2 != "" &&
        hWonSets2 != "" && gWonSets2 != "" && hWonGames2 != "" && gWonGames2 != "")
    {
        document.getElementById("soloCount").value = 2;
    }

    var type3 = document.getElementById("soloType3").value.trim();
    var hVName3 = document.getElementById("soloVnameHeim3").value.trim();
    var hNName3 = document.getElementById("soloNnameHeim3").value.trim();
    var gVName3 = document.getElementById("soloVnameGast3").value.trim();
    var gNName3 = document.getElementById("soloNnameGast3").value.trim();
    var hSatz1_3 = document.getElementById("soloSatz1heim3").value.trim();
    var gSatz1_3 = document.getElementById("soloSatz1gast3").value.trim();
    var hSatz2_3 = document.getElementById("soloSatz2heim3").value.trim();
    var gSatz2_3 = document.getElementById("soloSatz2gast3").value.trim();
    var hSatz3_3 = document.getElementById("soloSatz3heim3").value.trim();
    var gSatz3_3 = document.getElementById("soloSatz3gast3").value.trim();
    var hWonSets3 = document.getElementById("soloWonSetHeim3").value.trim();
    var gWonSets3 = document.getElementById("soloWonSetGast3").value.trim();
    var hWonGames3 = document.getElementById("soloWonMatchHeim3").value.trim();
    var gWonGames3 = document.getElementById("soloWonMatchGast3").value.trim();
    if (type3 != "" && hVName3 != "" && hNName3 != "" && gVName3 != "" && gNName3 != "" && hSatz1_3 != "" &&
        gSatz1_3 != "" && hSatz2_3 != "" && gSatz2_3 != "" && hSatz3_3 != "" && gSatz3_3 != "" &&
        hWonSets3 != "" && gWonSets3 != "" && hWonGames3 != "" && gWonGames3 != "")
    {
        document.getElementById("soloCount").value = 3;
    }

    var type4 = document.getElementById("soloType4").value.trim();
    var hVName4 = document.getElementById("soloVnameHeim4").value.trim();
    var hNName4 = document.getElementById("soloNnameHeim4").value.trim();
    var gVName4 = document.getElementById("soloVnameGast4").value.trim();
    var gNName4 = document.getElementById("soloNnameGast4").value.trim();
    var hSatz1_4 = document.getElementById("soloSatz1heim4").value.trim();
    var gSatz1_4 = document.getElementById("soloSatz1gast4").value.trim();
    var hSatz2_4 = document.getElementById("soloSatz2heim4").value.trim();
    var gSatz2_4 = document.getElementById("soloSatz2gast4").value.trim();
    var hSatz3_4 = document.getElementById("soloSatz3heim4").value.trim();
    var gSatz3_4 = document.getElementById("soloSatz3gast4").value.trim();
    var hWonSets4 = document.getElementById("soloWonSetHeim4").value.trim();
    var gWonSets4 = document.getElementById("soloWonSetGast4").value.trim();
    var hWonGames4 = document.getElementById("soloWonMatchHeim4").value.trim();
    var gWonGames4 = document.getElementById("soloWonMatchGast4").value.trim();
    if (type4 != "" && hVName4 != "" && hNName4 != "" && gVName4 != "" && gNName4 != "" && hSatz1_4 != "" &&
        gSatz1_4 != "" && hSatz2_4 != "" && gSatz2_4 != "" && hSatz3_4 != "" && gSatz3_4 != "" &&
        hWonSets4 != "" && gWonSets4 != "" && hWonGames4 != "" && gWonGames4 != "")
    {
        document.getElementById("soloCount").value = 4;
    }

    var dualType1 = document.getElementById("dualType1").value.trim();
    var hVName1_1 = document.getElementById("dualVnameHeim11").value.trim();
    var hNName1_1 = document.getElementById("dualNnameHeim11").value.trim();
    var hVName2_1 = document.getElementById("dualVnameHeim21").value.trim();
    var hNName2_1 = document.getElementById("dualNnameHeim21").value.trim();
    var gVName1_1 = document.getElementById("dualVnameGast11").value.trim();
    var gNName1_1 = document.getElementById("dualNnameGast11").value.trim();
    var gVName2_1 = document.getElementById("dualVnameGast21").value.trim();
    var gNName2_1 = document.getElementById("dualNnameGast21").value.trim();
    var hSatz1_1 = document.getElementById("dualSatz1heim1").value.trim();
    var gSatz1_1 = document.getElementById("dualSatz1gast1").value.trim();
    var hSatz2_1 = document.getElementById("dualSatz2heim1").value.trim();
    var gSatz2_1 = document.getElementById("dualSatz2gast1").value.trim();
    var hSatz3_1 = document.getElementById("dualSatz3heim1").value.trim();
    var gSatz3_1 = document.getElementById("dualSatz3gast1").value.trim();
    var hWonSets1 = document.getElementById("dualWonSetHeim1").value.trim();
    var gWonSets1 = document.getElementById("dualWonSetGast1").value.trim();
    var hWonGames1 = document.getElementById("dualWonMatchHeim1").value.trim();
    var gWonGames1 = document.getElementById("dualWonMatchGast1").value.trim();
    if (dualType1 != "" && hVName1_1 != "" && hNName1_1 != "" && hVName2_1 != "" && hNName2_1 != "" && gVName1_1 != "" && gNName1_1 != "" && gVName2_1 != "" && gNName2_1 != "" &&
        hSatz1_1 != "" && gSatz1_1 != "" && hSatz2_1 != "" && gSatz2_1 != "" && hSatz3_1 != "" && gSatz3_1 != "" &&
        hWonSets1 != "" && gWonSets1 != "" && hWonGames1 != "" && gWonGames1 != "")
    {
        document.getElementById("doubleCount").value = 1;
    }

    var dualType2 = document.getElementById("dualType2").value.trim();
    var hVName1_2 = document.getElementById("dualVnameHeim12").value.trim();
    var hNName1_2 = document.getElementById("dualNnameHeim12").value.trim();
    var hVName2_2 = document.getElementById("dualVnameHeim22").value.trim();
    var hNName2_2 = document.getElementById("dualNnameHeim22").value.trim();
    var gVName1_2 = document.getElementById("dualVnameGast12").value.trim();
    var gNName1_2 = document.getElementById("dualNnameGast12").value.trim();
    var gVName2_2 = document.getElementById("dualVnameGast22").value.trim();
    var gNName2_2 = document.getElementById("dualNnameGast22").value.trim();
    var hSatz1_2 = document.getElementById("dualSatz1heim2").value.trim();
    var gSatz1_2 = document.getElementById("dualSatz1gast2").value.trim();
    var hSatz2_2 = document.getElementById("dualSatz2heim2").value.trim();
    var gSatz2_2 = document.getElementById("dualSatz2gast2").value.trim();
    var hSatz3_2 = document.getElementById("dualSatz3heim2").value.trim();
    var gSatz3_2 = document.getElementById("dualSatz3gast2").value.trim();
    var hWonSets2 = document.getElementById("dualWonSetHeim2").value.trim();
    var gWonSets2 = document.getElementById("dualWonSetGast2").value.trim();
    var hWonGames2 = document.getElementById("dualWonMatchHeim2").value.trim();
    var gWonGames2 = document.getElementById("dualWonMatchGast2").value.trim();
    if (dualType2 != "" && hVName1_2 != "" && hNName1_2 != "" && hVName2_2 != "" && hNName2_2 != "" && gVName1_2 != "" && gNName1_2 != "" && gVName2_2 != "" && gNName2_2 != "" &&
        hSatz1_2 != "" && gSatz1_2 != "" && hSatz2_2 != "" && gSatz2_1 != "" && hSatz3_2 != "" && gSatz3_2 != "" &&
        hWonSets2 != "" && gWonSets2 != "" && hWonGames2 != "" && gWonGames2 != "")
    {
        document.getElementById("doubleCount").value = 2;
    }

    var dualType3 = document.getElementById("dualType3").value.trim();
    var hVName1_3 = document.getElementById("dualVnameHeim13").value.trim();
    var hNName1_3 = document.getElementById("dualNnameHeim13").value.trim();
    var hVName2_3 = document.getElementById("dualVnameHeim23").value.trim();
    var hNName2_3 = document.getElementById("dualNnameHeim23").value.trim();
    var gVName1_3 = document.getElementById("dualVnameGast13").value.trim();
    var gNName1_3 = document.getElementById("dualNnameGast13").value.trim();
    var gVName2_3 = document.getElementById("dualVnameGast23").value.trim();
    var gNName2_3 = document.getElementById("dualNnameGast23").value.trim();
    var hSatz1_3 = document.getElementById("dualSatz1heim3").value.trim();
    var gSatz1_3 = document.getElementById("dualSatz1gast3").value.trim();
    var hSatz2_3 = document.getElementById("dualSatz2heim3").value.trim();
    var gSatz2_3 = document.getElementById("dualSatz2gast3").value.trim();
    var hSatz3_3 = document.getElementById("dualSatz3heim3").value.trim();
    var gSatz3_3 = document.getElementById("dualSatz3gast3").value.trim();
    var hWonSets3 = document.getElementById("dualWonSetHeim3").value.trim();
    var gWonSets3 = document.getElementById("dualWonSetGast3").value.trim();
    var hWonGames3 = document.getElementById("dualWonMatchHeim3").value.trim();
    var gWonGames3 = document.getElementById("dualWonMatchGast3").value.trim();
    if (dualType3 != "" && hVName1_3 != "" && hNName1_3 != "" && hVName2_3 != "" && hNName2_3 != "" && gVName1_3 != "" && gNName1_3 != "" && gVName2_3 != "" && gNName2_3 != "" &&
        hSatz1_3 != "" && gSatz1_3 != "" && hSatz2_3 != "" && gSatz2_3 != "" || hSatz3_3 != "" && gSatz3_3 != "" &&
        hWonSets3 != "" && gWonSets3 != "" && hWonGames3 != "" && gWonGames3 != "")
    {
        document.getElementById("doubleCount").value = 3;
    }

    var dualType4 = document.getElementById("dualType4").value.trim();
    var hVName1_4 = document.getElementById("dualVnameHeim14").value.trim();
    var hNName1_4 = document.getElementById("dualNnameHeim14").value.trim();
    var hVName2_4 = document.getElementById("dualVnameHeim24").value.trim();
    var hNName2_4 = document.getElementById("dualNnameHeim24").value.trim();
    var gVName1_4 = document.getElementById("dualVnameGast14").value.trim();
    var gNName1_4 = document.getElementById("dualNnameGast14").value.trim();
    var gVName2_4 = document.getElementById("dualVnameGast24").value.trim();
    var gNName2_4 = document.getElementById("dualNnameGast24").value.trim();
    var hSatz1_4 = document.getElementById("dualSatz1heim4").value.trim();
    var gSatz1_4 = document.getElementById("dualSatz1gast4").value.trim();
    var hSatz2_4 = document.getElementById("dualSatz2heim4").value.trim();
    var gSatz2_4 = document.getElementById("dualSatz2gast4").value.trim();
    var hSatz3_4 = document.getElementById("dualSatz3heim4").value.trim();
    var gSatz3_4 = document.getElementById("dualSatz3gast4").value.trim();
    var hWonSets4 = document.getElementById("dualWonSetHeim4").value.trim();
    var gWonSets4 = document.getElementById("dualWonSetGast4").value.trim();
    var hWonGames4 = document.getElementById("dualWonMatchHeim4").value.trim();
    var gWonGames4 = document.getElementById("dualWonMatchGast4").value.trim();
    if (dualType4 != "" && hVName1_4 != "" && hNName1_4 != "" && hVName2_4 != "" && hNName2_4 != "" && gVName1_4 != "" && gNName1_4 != "" && gVName2_4 != "" && gNName2_4 != "" &&
        hSatz1_4 != "" && gSatz1_4 != "" && hSatz2_4 != "" && gSatz2_4 != "" || hSatz3_4 != "" && gSatz3_4 != "" &&
        hWonSets4 != "" && gWonSets4 != "" && hWonGames4 != "" && gWonGames4 != "")
    {
        document.getElementById("doubleCount").value = 4;
    }

    if (complete == false)
    {
        return false;
    }

    return true;
}
function changeSetSumS(row)
{
    var homeGes = 0;
    var guestGes = 0;
    var home1 = 0;
    var home2 = 0;
    var home3 = 0;
    var guest1 = 0;
    var guest2 = 0;
    var guest3 = 0;
    var homeSum = 0;
    var guestSum = 0;
    var homeWin = 0;
    var guestWin = 0;
    var sumSetHome = 0;
    var sumSetGuest = 0;
    var sumWonSetHome = 0;
    var sumWonSetGuest = 0;
    var sumWonMatchHome = 0;
    var sumWonMatchGuest = 0;



    home1 = parseInt(document.getElementById("soloSatz1heim" + row).value.trim());
    home2 = parseInt(document.getElementById("soloSatz2heim" + row).value.trim());
    home3 = parseInt(document.getElementById("soloSatz3heim" + row).value.trim());
    guest1 = parseInt(document.getElementById("soloSatz1gast" + row).value.trim());
    guest2 = parseInt(document.getElementById("soloSatz2gast" + row).value.trim());
    guest3 = parseInt(document.getElementById("soloSatz3gast" + row).value.trim());
    if (home1 > guest1)
    {
        homeWin++;
    }
    else if (home1 < guest1)
    {
        guestWin++;
    }
    if (home2 > guest2)
    {
        homeWin++;
    }
    else if (home2 < guest2)
    {
        guestWin++;
    }
    if (home3 > guest3)
    {
        homeWin++;
    }
    else if (home3 < guest3)
    {
        guestWin++;
    }
    homeSum = home1 + home2 + home3;
    guestSum = guest1 + guest2 + guest3;
    homeGes = homeSum;
    guestGes = guestSum;
    document.getElementById("soloSetpointHeim" + row).value = homeWin;
    document.getElementById("soloSetpointGast" + row).value = guestWin;
    document.getElementById("soloWonSetHeim" + row).value = homeGes;
    document.getElementById("soloWonSetGast" + row).value = guestGes;

    if (homeWin > guestWin)
    {
        document.getElementById("soloWonMatchHeim" + row).value = 1;
        document.getElementById("soloWonMatchGast" + row).value = 0;
    }
    else if (homeWin < guestWin)
    {
        document.getElementById("soloWonMatchHeim" + row).value = 0;
        document.getElementById("soloWonMatchGast" + row).value = 1;
    }
    else
    {
        document.getElementById("soloWonMatchHeim" + row).value = 0;
        document.getElementById("soloWonMatchGast" + row).value = 0;
    }
    for (i = 1; i <= 4; i++) //Momentaner max-Wert bei Solospielen muss bei Aenderungen angepsst werden
    {
        try
        {
            var soloSetPointHeim = parseInt(document.getElementById("soloSetpointHeim" + i).value.trim());
            var soloSetPointGast = parseInt(document.getElementById("soloSetpointGast" + i).value.trim());
            var soloWonSetHeim = parseInt(document.getElementById("soloWonSetHeim" + i).value.trim());
            var soloWonSetGast = parseInt(document.getElementById("soloWonSetGast" + i).value.trim());
            var soloWonMatchHeim = parseInt(document.getElementById("soloWonMatchHeim" + i).value.trim());
            var soloWonMatchGast = parseInt(document.getElementById("soloWonMatchGast" + i).value.trim());
        }
        catch (e)
        {
            console.log("Solo: Row " + i + " missing: Values set to 0.")
            var soloSetPointHeim = 0;
            var soloSetPointGast = 0;
            var soloWonSetHeim = 0;
            var soloWonSetGast = 0;
            var soloWonMatchHeim = 0;
            var soloWonMatchGast = 0;
        }

        sumSetHome += soloSetPointHeim;
        sumSetGuest += soloSetPointGast;
        sumWonSetHome += soloWonSetHeim;
        sumWonSetGuest += soloWonSetGast;
        sumWonMatchHome += soloWonMatchHeim;
        sumWonMatchGuest += soloWonMatchGast;

    }

    document.getElementById("sumSetHomeSolo").value = sumSetHome;
    document.getElementById("sumSetGuestSolo").value = sumSetGuest;
    document.getElementById("sumWonSetHomeSolo").value = sumWonSetHome;
    document.getElementById("sumWonSetGuestSolo").value = sumWonSetGuest;
    document.getElementById("sumWonMatchHomeSolo").value = sumWonMatchHome;
    document.getElementById("sumWonMatchGuestSolo").value = sumWonMatchGuest;


}

function changeSetSumD(row)
{
    var homeGes = 0;
    var guestGes = 0;
    var home1 = 0;
    var home2 = 0;
    var home3 = 0;
    var guest1 = 0;
    var guest2 = 0;
    var guest3 = 0;
    var homeSum = 0;
    var guestSum = 0;
    var homeWin = 0;
    var guestWin = 0;
    var sumSetHome = 0;
    var sumSetGuest = 0;
    var sumWonSetHome = 0;
    var sumWonSetGuest = 0;
    var sumWonMatchHome = 0;
    var sumWonMatchGuest = 0;



    home1 = parseInt(document.getElementById("dualSatz1heim" + row).value.trim());
    home2 = parseInt(document.getElementById("dualSatz2heim" + row).value.trim());
    home3 = parseInt(document.getElementById("dualSatz3heim" + row).value.trim());
    guest1 = parseInt(document.getElementById("dualSatz1gast" + row).value.trim());
    guest2 = parseInt(document.getElementById("dualSatz2gast" + row).value.trim());
    guest3 = parseInt(document.getElementById("dualSatz3gast" + row).value.trim());
    if (home1 > guest1)
    {
        homeWin++;
    }
    else if (home1 < guest1)
    {
        guestWin++;
    }
    if (home2 > guest2)
    {
        homeWin++;
    }
    else if (home2 < guest2)
    {
        guestWin++;
    }
    if (home3 > guest3)
    {
        homeWin++;
    }
    else if (home3 < guest3)
    {
        guestWin++;
    }
    homeSum = home1 + home2 + home3;
    guestSum = guest1 + guest2 + guest3;
    homeGes = homeSum;
    guestGes = guestSum;
    document.getElementById("dualSetpointHeim" + row).value = homeWin;
    document.getElementById("dualSetpointGast" + row).value = guestWin;
    document.getElementById("dualWonSetHeim" + row).value = homeGes;
    document.getElementById("dualWonSetGast" + row).value = guestGes;

    if (homeWin > guestWin)
    {
        document.getElementById("dualWonMatchHeim" + row).value = 1;
        document.getElementById("dualWonMatchGast" + row).value = 0;
    }
    else if (homeWin < guestWin)
    {
        document.getElementById("dualWonMatchHeim" + row).value = 0;
        document.getElementById("dualWonMatchGast" + row).value = 1;
    }
    else
    {
        document.getElementById("dualWonMatchHeim" + row).value = 0;
        document.getElementById("dualWonMatchGast" + row).value = 0;
    }
    for (i = 1; i <= 2; i++) //Momentaner max-Wert bei dualspielen muss bei Aenderungen angepsst werden
    {
        try
        {
            var dualSetPointHeim = parseInt(document.getElementById("dualSetpointHeim" + i).value.trim());
            var dualSetPointGast = parseInt(document.getElementById("dualSetpointGast" + i).value.trim());
            var dualWonSetHeim = parseInt(document.getElementById("dualWonSetHeim" + i).value.trim());
            var dualWonSetGast = parseInt(document.getElementById("dualWonSetGast" + i).value.trim());
            var dualWonMatchHeim = parseInt(document.getElementById("dualWonMatchHeim" + i).value.trim());
            var dualWonMatchGast = parseInt(document.getElementById("dualWonMatchGast" + i).value.trim());
        }
        catch (e)
        {
            console.log("Double: Row " + i + " not initialized: Values set to 0.")
            var dualSetPointHeim = 0;
            var dualSetPointGast = 0;
            var dualWonSetHeim = 0;
            var dualWonSetGast = 0;
            var dualWonMatchHeim = 0;
            var dualWonMatchGast = 0;
        }

        sumSetHome += dualSetPointHeim;
        sumSetGuest += dualSetPointGast;
        sumWonSetHome += dualWonSetHeim;
        sumWonSetGuest += dualWonSetGast;
        sumWonMatchHome += dualWonMatchHeim;
        sumWonMatchGuest += dualWonMatchGast;

    }

    document.getElementById("sumSetHomeDual").value = sumSetHome;
    document.getElementById("sumSetGuestDual").value = sumSetGuest;
    document.getElementById("sumWonSetHomeDual").value = sumWonSetHome;
    document.getElementById("sumWonSetGuestDual").value = sumWonSetGuest;
    document.getElementById("sumWonMatchHomeDual").value = sumWonMatchHome;
    document.getElementById("sumWonMatchGuestDual").value = sumWonMatchGuest;
}

function markInput(elem)
{
    elem.style.backgroundColor = "#a9dfbf";
}
function tabClick()
{
    var keyEvent = document.dispatchEvent(new KeyboardEvent("keydown", {
        key: "Tab",
        keyCode: 9,
        code: "Tab", // put everything you need in this object.
        which: 9,
        shiftKey: false, // you don't need to include values
        ctrlKey: false,  // if you aren't going to use them.
        metaKey: false
    }));
    console.log(keyEvent.key);

}

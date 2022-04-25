//Berechnet die Punkte beim Laden der Seite
var errColor = "#F08080"
window.onload = function ()
{
    var doubleTable = document.getElementById("tabDouble");
    var soloTable = document.getElementById("tabSolo");
    var valRow = 1;
    for (var i = 0, row; row = doubleTable.rows[i]; i++)
    {
        if (row.id.startsWith("doppel"))
        {
            changeSetSumD(valRow);
            valRow++
        }
    }
    valRow = 1;
    for (var i = 0, row; row = soloTable.rows[i]; i++)
    {
        if (row.id.startsWith("solo"))
        {
            changeSetSumS(valRow);
            valRow++
        }
    }
    totalResult();
}

// Aktiviert den Submitbutton, wodurch Bericht abgeschickt werden kann
function activateSubmit()
{
    var btSubmit = document.getElementById("submitBTN");
    btSubmit.disabled = false;
    btSubmit.classList.remove('opacity-70');
    btSubmit.classList.add('opacity-100');
}

//Wenn verwendet: onsubmit aendern, oberste reihe id geben, namen der Inputs anpassen
function validateInputs()
{
    try
    {
        var correct = true;
        var matchRow = document.getElementById("matchRow").getElementsByTagName('div');
        var doubleTable = document.getElementById("tabDoubleBody").getElementsByTagName('input');
        var soloTable = document.getElementById("tabSoloBody").getElementsByTagName('input');

        //Check Top Row
        for (i = 0; i < matchRow.length; i++)
        {
            var matchTF = matchRow[i].getElementsByTagName('input');
            if (matchTF[0].value.trim() == "")
            {
                matchTF[0].style.backgroundColor = errColor;
                correct = false;
            }

        }

        //Check DoubleTab
        for (i = 0; i < doubleTable.length; i++)
        {
            if (doubleTable[i].type != "hidden" && doubleTable[i].value.trim() == "")
            {
                doubleTable[i].style.backgroundColor = errColor;
                correct = false;
            }
        }

        //Check SoloTab
        for (i = 0; i < soloTable.length; i++)
        {
            if (soloTable[i].type != "hidden" && soloTable[i].value.trim() == "")
            {
                soloTable[i].style.backgroundColor = errColor;
                correct = false;
            }
        }

    }
    catch (err)
    {
        console.log('Exception');
        console.log(err);
        return false;
    }

    return correct;
}

function changeSetSumS(row)
{
    console.log("Reihe: " + row + " Solo Change");
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



    home1 = parseInt(document.getElementById("soloSatz1heim" + row).value.trim()) || 0;
    home2 = parseInt(document.getElementById("soloSatz2heim" + row).value.trim()) || 0;
    home3 = parseInt(document.getElementById("soloSatz3heim" + row).value.trim()) || 0;
    guest1 = parseInt(document.getElementById("soloSatz1gast" + row).value.trim()) || 0;
    guest2 = parseInt(document.getElementById("soloSatz2gast" + row).value.trim()) || 0;
    guest3 = parseInt(document.getElementById("soloSatz3gast" + row).value.trim()) || 0;
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
    for (i = 1; i <= 5; i++) //Momentaner max-Wert bei Solospielen muss bei Aenderungen angepsst werden
    {
        try
        {
            var soloSetPointHeim = parseInt(document.getElementById("soloSetpointHeim" + i).value.trim()) || 0;
            var soloSetPointGast = parseInt(document.getElementById("soloSetpointGast" + i).value.trim()) || 0;
            var soloWonSetHeim = parseInt(document.getElementById("soloWonSetHeim" + i).value.trim()) || 0;
            var soloWonSetGast = parseInt(document.getElementById("soloWonSetGast" + i).value.trim()) || 0;
            var soloWonMatchHeim = parseInt(document.getElementById("soloWonMatchHeim" + i).value.trim()) || 0;
            var soloWonMatchGast = parseInt(document.getElementById("soloWonMatchGast" + i).value.trim()) || 0;
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

    totalResult();
}

function changeSetSumD(row)
{
    console.log("Reihe: " + row + " Double Change");

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



    home1 = parseInt(document.getElementById("dualSatz1heim" + row).value.trim()) || 0;
    home2 = parseInt(document.getElementById("dualSatz2heim" + row).value.trim()) || 0;
    home3 = parseInt(document.getElementById("dualSatz3heim" + row).value.trim()) || 0;
    guest1 = parseInt(document.getElementById("dualSatz1gast" + row).value.trim()) || 0;
    guest2 = parseInt(document.getElementById("dualSatz2gast" + row).value.trim()) || 0;
    guest3 = parseInt(document.getElementById("dualSatz3gast" + row).value.trim()) || 0;
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
    for (i = 1; i <= 5; i++) //Momentaner max-Wert bei dualspielen muss bei Aenderungen angepsst werden
    {
        try
        {
            var dualSetPointHeim = parseInt(document.getElementById("dualSetpointHeim" + i).value.trim()) || 0;
            var dualSetPointGast = parseInt(document.getElementById("dualSetpointGast" + i).value.trim()) || 0;
            var dualWonSetHeim = parseInt(document.getElementById("dualWonSetHeim" + i).value.trim()) || 0;
            var dualWonSetGast = parseInt(document.getElementById("dualWonSetGast" + i).value.trim()) || 0;
            var dualWonMatchHeim = parseInt(document.getElementById("dualWonMatchHeim" + i).value.trim()) || 0;
            var dualWonMatchGast = parseInt(document.getElementById("dualWonMatchGast" + i).value.trim()) || 0;
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
    totalResult();
}

function totalResult()
{
    //TF Soloergebnisse
    var sumSetHomeSolo = parseInt(document.getElementById("sumSetHomeSolo").value) || 0;
    var sumSetGuestSolo = parseInt(document.getElementById("sumSetGuestSolo").value) || 0;

    var sumWonSetHomeSolo = parseInt(document.getElementById("sumWonSetHomeSolo").value) || 0;
    var sumWonSetGuestSolo = parseInt(document.getElementById("sumWonSetGuestSolo").value) || 0;

    var sumWonMatchHomeSolo = parseInt(document.getElementById("sumWonMatchHomeSolo").value) || 0;
    var sumWonMatchGuestSolo = parseInt(document.getElementById("sumWonMatchGuestSolo").value) || 0;
    //TF Doppelergebnisse
    var sumSetHomeDual = parseInt(document.getElementById("sumSetHomeDual").value) || 0;
    var sumSetGuestDual = parseInt(document.getElementById("sumSetGuestDual").value) || 0;

    var sumWonSetHomeDual = parseInt(document.getElementById("sumWonSetHomeDual").value) || 0;
    var sumWonSetGuestDual = parseInt(document.getElementById("sumWonSetGuestDual").value) || 0;

    var sumWonMatchHomeDual = parseInt(document.getElementById("sumWonMatchHomeDual").value) || 0;
    var sumWonMatchGuestDual = parseInt(document.getElementById("sumWonMatchGuestDual").value) || 0;

    //Addieren der jeweiligen Felder und Hinzufügen in Gesamttabelle
    var sumSetHomeTotal = sumSetHomeSolo + sumSetHomeDual;
    document.getElementById("sumSetHomeTotal").value = sumSetHomeTotal;
    var sumSetGuestTotal = sumSetGuestSolo + sumSetGuestDual;
    document.getElementById("sumSetGuestTotal").value = sumSetGuestTotal;
    var sumWonSetHomeTotal = sumWonSetHomeSolo + sumWonSetHomeDual;
    document.getElementById("sumWonSetHomeTotal").value = sumWonSetHomeTotal;
    var sumWonSetGuestTotal = sumWonSetGuestSolo + sumWonSetGuestDual;
    document.getElementById("sumWonSetGuestTotal").value = sumWonSetGuestTotal;
    var sumWonMatchHomeTotal = sumWonMatchHomeSolo + sumWonMatchHomeDual;
    document.getElementById("sumWonMatchHomeTotal").value = sumWonMatchHomeTotal;
    var sumWonMatchGuestTotal = sumWonMatchGuestSolo + sumWonMatchGuestDual;
    document.getElementById("sumWonMatchGuestTotal").value = sumWonMatchGuestTotal;
    console.log(sumWonSetGuestSolo);
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

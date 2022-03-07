

var RechercheOrigin;
var isRecherchePanelDisplayed = false;
function displayRecherchePanel(rechercheName, rechercheUrlImage, info) {


    const panel = '<div class="specificInfoPanel">';


    let container = document.getElementById("recherchePanelContainer");

    if (!isRecherchePanelDisplayed) {
        RechercheOrigin = container.innerHTML;
    }


    let addition = "";
    if (rechercheName == "EntrepotDePierre" ||
        rechercheName == "EntrepotDeBois" ||
        rechercheName == "Silo") {
        addition = 'capacité : <span class="storageCapacity' + rechercheName + '"></span> <br>';
    } else if (
        rechercheName == "Scierie" || rechercheName == "Carriere" || rechercheName == "Ferme"
    ) {
        addition = 'ressource par heure : <span class="ressourceRate' + rechercheName + '"></span> <br>';
    } else {
        addition = 'bonus  : <span class="bonus' + rechercheName + '"></span>% <br>';

    }


    container.innerHTML += panel +
        '<div class="headPanel">' +
        '<h1>' +
        rechercheName +
        '</h1>' +
        '<button onclick="closeRecherchePanel()">' +
        'Fermer' +
        '</button>' +
        '</div>' +
        '<div class="subFlexPanel">' +
        '<img src="' + rechercheUrlImage + '">' +
        '<div class="infoBlocPanel">' +
        'recherche level : <span class="lvl' + rechercheName + '"></span> <br>' + addition +
        '<div class="ressourceCostPanel">' +
        '<div class="ressourceBlock">' +
        '<img src="./ressource/image/woodIcon.png">' +
        '<span class="woodCost' + rechercheName + '"></span>' +
        '</div>' +
        '<div class="ressourceBlock">' +
        '<img src="./ressource/image/rockIcon.png">' +
        '<span class="pierreCost' + rechercheName + '"></span>' +
        '</div>' +
        '<div class="ressourceBlock">' +
        '<img src="./ressource/image/foodIcon.png">' +
        '<span class="foodCost' + rechercheName + '"></span>' +
        '</div>' +
        '<button onclick="onAmeliorationRechercheClick(\'' + rechercheName + '\')">' +
        'Upgrade' +
        '</button>' +
        '</div>' +
        '</div>' +
        '</div>' +
        '<div class="infoPanel">' +
        info +
        '</div>' +
        '</div>';



    isRecherchePanelDisplayed = true;
}

document.body.addEventListener("changePage", getDataRecherche, false);


function getDataRecherche() {

    const container = document.getElementById('recherchePanelContainer');
    if (!container) return;

    var xhr = getXMLHttp();

    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            let response = xhr.responseText;
            // console.log("receive : " + response);
            const object = JSON.parse(response);
            Object.keys(object).forEach(function (key, index) {
                let batimentName = key;
                let field = document.getElementById(batimentName);

                if (field) field.innerHTML = "";
                Object.keys(object[key]).forEach(function (key, index) {
                    let fieldName = key;
                    let spanfields = document.getElementsByClassName(fieldName + batimentName);
                    if (spanfields.length > 0) {
                        for (let index = 0; index < spanfields.length; index++) {
                            const spanfield = spanfields[index];
                            spanfield.innerHTML = object[batimentName][fieldName];
                        }
                    }
                    if (field) field.innerHTML += fieldName + " " + object[batimentName][fieldName] + "\n<br>";

                });


                let fieldName = 'nextlvl';
                let spanfields = document.getElementsByClassName(fieldName + batimentName);
                for (let index = 0; index < spanfields.length; index++) {
                    const spanfield = spanfields[index];
                    spanfield.innerHTML = parseFloat(object[batimentName]['lvl']) + 1;
                }



                if (object[batimentName]['timefrom'] != 0) {
                    var percentComplition = object[batimentName]['timeRemaining'] / object[batimentName]['timefrom'] * 100;
                    let elementLoadings = document.getElementsByClassName('timeRemaining' + batimentName);
                    if (elementLoadings) {
                        for (let index = 0; index < elementLoadings.length; index++) {
                            const elementBlackLoading = elementLoadings[index].parentNode;
                            // console.log(elementBlackLoading);

                            elementBlackLoading.style.opacity = 1;
                            elementBlackLoading.style.height = percentComplition + "%";

                        }
                    }
                } else {
                    let elementLoadings = document.getElementsByClassName('timeRemaining' + batimentName);
                    if (elementLoadings) {
                        for (let index = 0; index < elementLoadings.length; index++) {
                            const allNodes = elementLoadings[index].parentNode;
                            allNodes.style.opacity = 0;
                        }
                    }
                }
            });
            setTimeout(getDataRecherche, 1000);

        }
    }

    xhr.open('GET', './controller/recherche.php?all=true', true);
    xhr.send(null);
}

function closeRecherchePanel() {
    let container = document.getElementById("recherchePanelContainer");
    if (isRecherchePanelDisplayed) {
        container.innerHTML = RechercheOrigin;
        isRecherchePanelDisplayed = false;
    }
}


function onAmeliorationRechercheClick(recherche) {
    // console.log("amelioration" + recherche);

    var xhr = getXMLHttp();
    var saisie;

    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            let response = xhr.responseText;
            // console.log("receive : " + response);
            if (response == "erreur") alert("Impossible pour le moment");
        }
    }

    xhr.open('GET', './controller/recherche.php?upgrade=' + recherche, true);
    xhr.send(null);

}
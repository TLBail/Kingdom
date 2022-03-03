

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
        addition = 'nombre de villageois : <span class="ressourceRate' + rechercheName + '"></span> <br>';

    }


    container.innerHTML += panel +
        '<div class="headPanel">' +
        '<h1>' +
        rechercheName +
        '</h1>' +
        '<button onclick="closepanel()">' +
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


function closeRecherchePanel() {
    let container = document.getElementById("recherchePanelContainer");
    if (isRecherchePanelDisplayed) {
        container.innerHTML = RechercheOrigin;
        isRecherchePanelDisplayed = false;
    }
}


function onAmeliorationRechercheClick(recherche) {
    console.log("amelioration" + recherche);

    var xhr = getXMLHttp();
    var saisie;

    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            let response = xhr.responseText;
            console.log("receive : " + response);
            if (response == "erreur") alert("Impossible pour le moment");
            const object = JSON.parse(response);
            let field = document.getElementById(recherche);
            field.innerHTML = "";
            if (object[recherche]) {
                Object.keys(object[recherche]).forEach(function (key, index) {
                    let fieldName = key;
                    field.innerHTML += fieldName + " " + object[recherche][fieldName] + "<br>";
                });
            } else {
                field.innerHTML = "recherche non débloquer ";
            }
        }
    }

    xhr.open('GET', './controller/recherche.php?upgrade=' + recherche, true);
    xhr.send(null);

}
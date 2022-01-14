
const panel = '<div class="batimentPanel">';


var origin;
var ispaneldisplayed = false;
function displayPanel(batimentName, batimentUrlImage, info) {

    let container = document.getElementById("batimentPanelContainer");

    if (!ispaneldisplayed) {
        origin = container.innerHTML;
    }

    let addition = "";
    if (batimentName == "EntrepotDePierre" ||
        batimentName == "EntrepotDeBois" ||
        batimentName == "Silo") {
        addition = 'capacité : <span class="storageCapacity' + batimentName + '"></span> <br>';
    } else if (
        batimentName == "Scierie" || batimentName == "Carriere" || batimentName == "Ferme"
    ) {
        addition = 'ressource par heure : <span class="ressourceRate' + batimentName + '"></span> <br>';
    } else {
        addition = 'nombre de villageois : <span class="ressourceRate' + batimentName + '"></span> <br>';

    }


    container.innerHTML += panel +
        '<div class="headPanel">' +
        '<h1>' +
        batimentName +
        '</h1>' +
        '<button onclick="closepanel()">' +
        'Fermer' +
        '</button>' +
        '</div>' +
        '<div class="subFlexPanel">' +
        '<img src="' + batimentUrlImage + '">' +
        '<div class="infoBlocPanel">' +
        'batiment level : <span class="lvl' + batimentName + '"></span> <br>' + addition +
        '<div class="ressourceCostPanel">' +
        '<div class="ressourceBlock">' +
        '<img src="./ressource/image/woodIcon.png">' +
        '<span class="woodCost' + batimentName + '"></span>' +
        '</div>' +
        '<div class="ressourceBlock">' +
        '<img src="./ressource/image/rockIcon.png">' +
        '<span class="pierreCost' + batimentName + '"></span>' +
        '</div>' +
        '<div class="ressourceBlock">' +
        '<img src="./ressource/image/foodIcon.png">' +
        '<span class="foodCost' + batimentName + '"></span>' +
        '</div>' +
        '<button onclick="onAmeliorationClick(\'' + batimentName + '\')">' +
        'Upgrade' +
        '</button>' +
        '</div>' +
        '</div>' +
        '</div>' +
        '<div class="infoPanel">' +
        info +
        '</div>' +
        '</div>';


    ispaneldisplayed = true;
    updateCanvas();

}


function closepanel() {
    let container = document.getElementById("batimentPanelContainer");
    if (ispaneldisplayed) {
        container.innerHTML = origin;
        ispaneldisplayed = false;
        updateCanvas();
    }
}
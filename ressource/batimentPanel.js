
const panel = '<div class="batimentPanel">';


var origin;
var ispaneldisplayed = false;
function displayPanel(batimentName) {

    let container = document.getElementById("batimentPanelContainer");

    if (!ispaneldisplayed) {
        origin = container.innerHTML;
    }
    container.innerHTML += panel +
        '<h1>' +
        batimentName +
        '</h1>' +
        '<p>' +
        'salut a tous c ' + batimentName +
        '</p>' +
        '<p id="' + batimentName + '"></p>' +
        '<button onclick="onAmeliorationClick(\'' + batimentName + '\')">' +
        'Upgrade' +
        '</button>' +
        '<button onclick="closepanel()">' +
        'Fermer' +
        '</button>' +
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
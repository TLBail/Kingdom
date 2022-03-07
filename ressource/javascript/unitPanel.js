


var origin;
var ispaneldisplayed = false;
function displayUnitPanel(unitName, unitUrlImage, info) {

    let container = document.getElementById("unitPanelContainer").parentNode;

    if (!ispaneldisplayed) {
        origin = container.innerHTML;
    }
    container.innerHTML +=
        '<div class="specificInfoPanel">' +
        '<div class="headPanel">' +
        '<h1>' +
        unitName +
        '</h1>' +
        '<button onclick="closepanel()">' +
        'Fermer' +
        '</button>' +
        '</div>' +
        '<div class="subFlexPanel">' +
        '<img src="' + unitUrlImage + '">' +
        '<div class="infoBlocPanel">' +
        'nombre d\'unite : <span class="number' + unitName + '">0</span> <br>' +
        '<div class="ressourceCostPanel">' +
        '<div class="ressourceBlock">' +
        '<img src="./ressource/image/woodIcon.png">' +
        '<span class="woodCost' + unitName + '"></span>' +
        '</div>' +
        '<div class="ressourceBlock">' +
        '<img src="./ressource/image/rockIcon.png">' +
        '<span class="pierreCost' + unitName + '"></span>' +
        '</div>' +
        '<div class="ressourceBlock">' +
        '<img src="./ressource/image/foodIcon.png">' +
        '<span class="foodCost' + unitName + '"></span>' +
        '</div>' +
        '<input type="number" name="' + unitName + 'ToBuy" id="' + unitName + 'ToBuy">' +
        '<button onclick="addUnit(\'' + unitName + '\')">' +
        'entrainer' +
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

document.body.addEventListener("changePage", updateUnitCost, false);

function updateUnitCost() {
    const fond = document.getElementById('unitePanelFon');

    if (!fond) return;

    var xhr = getXMLHttp();
    var saisie;


    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            let response = xhr.responseText;
            const object = JSON.parse(response);
            //console.log("receive : " + response);
            Object.keys(object).forEach(function (key, index) {
                let unitName = key;

                let field = document.getElementById(unitName);
                if (field) field.innerHTML = "";
                Object.keys(object[key]).forEach(function (key, index) {
                    let fieldName = key;
                    let spanfields = document.getElementsByClassName(fieldName + unitName);
                    for (let index = 0; index < spanfields.length; index++) {
                        const spanfield = spanfields[index];
                        spanfield.innerHTML = object[unitName][fieldName];
                    }
                    if (field) field.innerHTML += fieldName + " " + object[unitName][fieldName] + "\n<br>";
                });

                if (object[unitName]['timefrom'] != 0) {
                    var percentComplition = object[unitName]['timeRemaining'] / object[unitName]['timefrom'] * 100;
                    let elementLoadings = document.getElementsByClassName('timeRemaining' + unitName);
                    if (elementLoadings) {
                        for (let index = 0; index < elementLoadings.length; index++) {
                            const elementBlackLoading = elementLoadings[index].parentNode;
                            elementBlackLoading.style.opacity = 1;
                            elementBlackLoading.style.height = percentComplition + "%";

                        }
                    }
                } else {
                    let elementLoadings = document.getElementsByClassName('timeRemaining' + unitName);
                    if (elementLoadings) {
                        for (let index = 0; index < elementLoadings.length; index++) {
                            const allNodes = elementLoadings[index].parentNode;
                            allNodes.style.opacity = 0;
                        }
                    }
                }

                let elementToAddMax = document.getElementById('nb' + unitName);
                if (elementToAddMax) {
                    elementToAddMax.max = object[unitName]['number'];
                }
            });
            setTimeout(updateUnitCost, 1000);
        }
    }

    xhr.open('GET', './controller/unit.php?all=true', true);
    xhr.send(null);
}

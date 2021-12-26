function getXMLHttp() {
    var xhr = null;
    xhr = new XMLHttpRequest();
    return xhr;
}

function onAmeliorationClick(batiment) {
    console.log("amelioration" + batiment);

    var xhr = getXMLHttp();
    var saisie;

    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            let response = xhr.responseText;
            console.log("receive : " + response);
            if (response == "erreur") alert("Impossible pour le moment");
            const object = JSON.parse(response);
            let field = document.getElementById(batiment);
            field.innerHTML = "";
            if (object[batiment]) {
                Object.keys(object[batiment]).forEach(function (key, index) {
                    let fieldName = key;
                    field.innerHTML += fieldName + " " + object[batiment][fieldName] + "<br>";
                });
            } else {
                field.innerHTML = "batiment non débloquer ";
            }
        }
    }

    xhr.open('GET', './controller/batiment.php?upgrade=' + batiment, true);
    xhr.send(null);

}


displayBatiment();
function displayBatiment() {
    var xhr = getXMLHttp();
    var saisie;

    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            let response = xhr.responseText;
            console.log("receive : " + response);
            const object = JSON.parse(response);
            Object.keys(object).forEach(function (key, index) {
                let batimentName = key;
                let field = document.getElementById(batimentName);
                field.innerHTML = "";
                Object.keys(object[key]).forEach(function (key, index) {
                    let fieldName = key;
                    field.innerHTML += fieldName + " " + object[batimentName][fieldName] + "<br>";
                });
            });
        }
    }

    xhr.open('GET', './controller/batiment.php?all=true', true);
    xhr.send(null);
}



displayRessources();
function displayRessources() {
    var xhr = getXMLHttp();
    var saisie;

    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            let response = xhr.responseText;
            console.log("receive : " + response);
            const object = JSON.parse(response);
            let field = document.getElementById("ressourceContainer");
            field.innerHTML = "";
            Object.keys(object).forEach(function (key, index) {
                let ressourceName = key;
                let ammount = object[ressourceName];
                field.innerHTML += ressourceName + " " + ammount + "<br>";
            });
        }
    }

    xhr.open('GET', './controller/ressource.php?all=true', true);
    xhr.send(null);
}

displayVillageois();
function displayVillageois() {
    var xhr = getXMLHttp();
    var saisie;

    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            let response = xhr.responseText;
            console.log("receive : " + response);
            let field = document.getElementById("villageoisContainer");
            field.innerHTML = response;
        }
    }

    xhr.open('GET', './controller/ressource.php?villageois=true', true);
    xhr.send(null);
}



var intervalId = window.setInterval(function () {
    /// call your function here
    displayBatiment();
    displayRessources();
    displayVillageois();
}, 1000);





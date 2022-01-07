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


// displayBatiment();
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



function displayRessources() {
    var xhr = getXMLHttp();
    var foodFields = document.getElementsByClassName("foodNumber");
    var pierreFields = document.getElementsByClassName("pierreNumber");
    var boisFields = document.getElementsByClassName("boisNumber");

    var foodMaxFields = document.getElementsByClassName("nourritureMaxCapacity");
    var boisMaxFields = document.getElementsByClassName("boisMaxCapacity");
    var pierreMaxFields = document.getElementsByClassName("pierreMaxCapacity");

    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            let response = xhr.responseText;
            console.log("receive : " + response);
            const object = JSON.parse(response);

            for (let index = 0; index < foodFields.length; index++) {
                const foodField = foodFields[index];
                foodField.innerHTML = object['nourriture']['amout'];
            }
            for (let index = 0; index < pierreFields.length; index++) {
                const pierreField = pierreFields[index];
                pierreField.innerHTML = object['pierre']['amout'];

            }
            for (let index = 0; index < boisFields.length; index++) {
                const boisField = boisFields[index];
                boisField.innerHTML = object['bois']['amout'];
            }


            for (let index = 0; index < foodMaxFields.length; index++) {
                const foodMaxField = foodMaxFields[index];
                foodMaxField.innerHTML = object['nourriture']['capacity'];
            }

            for (let index = 0; index < boisMaxFields.length; index++) {
                const boisMaxField = boisMaxFields[index];
                boisMaxField.innerHTML = object['bois']['capacity'];
            }
            for (let index = 0; index < pierreMaxFields.length; index++) {
                const pierreMaxField = pierreMaxFields[index];
                pierreMaxField.innerHTML = object['pierre']['capacity'];
            }

        }
    }

    xhr.open('GET', './controller/ressource.php?all=true', true);
    xhr.send(null);
}

displayVillageois();
function displayVillageois() {
    var xhr = getXMLHttp();
    var fields = document.getElementsByClassName("villageoisNumber");

    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            let response = xhr.responseText;
            console.log("receive : " + response);
            for (let index = 0; index < fields.length; index++) {
                const field = fields[index];
                field.innerHTML = response;
            }
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





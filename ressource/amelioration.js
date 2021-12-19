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
            const object = JSON.parse(response);
            document.getElementById("lvl" + batiment).innerHTML = object[batiment];
        }
    }

    xhr.open('GET', './controller/ressource.php?upgrade=' + batiment, true);
    xhr.send(null);

}


displayLvl();
function displayLvl() {
    var xhr = getXMLHttp();
    var saisie;

    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            let response = xhr.responseText;
            console.log("receive : " + response);
            const object = JSON.parse(response);
            document.getElementById("lvlScierie").innerHTML = object.Scierie;
            document.getElementById("lvlCarriere").innerHTML = object.Carriere;
            document.getElementById("lvlFerme").innerHTML = object.Ferme;
            document.getElementById("lvlEntrepotDeBois").innerHTML = object.EntrepotDeBois;
            document.getElementById("lvlEntrepotDePierre").innerHTML = object.EntrepotDePierre;
            document.getElementById("lvlSilo").innerHTML = object.Silo;
            document.getElementById("lvlMaison").innerHTML = object.Maison;
        }
    }

    xhr.open('GET', './controller/ressource.php?lvl=true', true);
    xhr.send(null);
}
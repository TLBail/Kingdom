function getXMLHttp() {
    var xhr = null;
    xhr = new XMLHttpRequest();
    return xhr;
}

function onAmeliorationClick(batiment) {
    console.log("amelioration" + batiment);

    var xhr = getXMLHttp();
    var saisie;

    var fieldNames = [
        "lvl",
        "ressourceRate",
        "woodCost",
        "pierreCost",
        "storageCapacity",
        "nourritureCost",
        "villageoisCost"
    ];

    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            let response = xhr.responseText;
            console.log("receive : " + response);
            if (response == "erreur") alert("Ressources insufisantes");
            const object = JSON.parse(response);
            fieldNames.forEach(fieldName => {
                let field = document.getElementById(fieldName + batiment);
                if (field && object[batiment]) field.innerHTML = object[batiment][fieldName];
            });
        }
    }

    xhr.open('GET', './controller/ressource.php?upgrade=' + batiment, true);
    xhr.send(null);

}



displayBatiment();
function displayBatiment() {
    var xhr = getXMLHttp();
    var saisie;

    var batimentNames = [
        "Scierie",
        "Carriere",
        "Ferme",
        "EntrepotDeBois",
        "EntrepotDePierre",
        "Silo",
        "Immeuble",
        "Maison"
    ];

    var fieldNames = [
        "lvl",
        "ressourceRate",
        "woodCost",
        "pierreCost",
        "storageCapacity",
        "nourritureCost",
        "villageoisCost"
    ];

    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            let response = xhr.responseText;
            console.log("receive : " + response);
            const object = JSON.parse(response);
            batimentNames.forEach(batimentName => {
                fieldNames.forEach(fieldName => {
                    let field = document.getElementById(fieldName + batimentName);
                    if (field && object[batimentName]) field.innerHTML = object[batimentName][fieldName];
                });
            }
            );
        }
    }

    xhr.open('GET', './controller/ressource.php?all=true', true);
    xhr.send(null);
}
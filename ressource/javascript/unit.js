function addUnit(unitName) {

    let nbUnit = document.getElementById(unitName + 'ToBuy').valueAsNumber;
    console.log("ajout de " + nbUnit + unitName);
    console.log(unitName + 'QuiArrive');
    var field = document.getElementById(unitName + 'QuiArrive');
    var xhr = getXMLHttp();

    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            let response = xhr.responseText;
            console.log("receive : " + response);
            if (response == "erreur") alert("Impossible pour le moment");
            field.innerHTML = unitName + "qui arrive " + nbUnit;

        }
    }

    xhr.open('GET', './controller/unit.php?addUnite=' + nbUnit + '&addUniteName=' + unitName, true);
    xhr.send(null);


}


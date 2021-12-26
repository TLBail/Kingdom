var woodCount = document.querySelector('#woodCount');
var stoneCount = document.querySelector('#stoneCount');
var foodCount = document.querySelector('#foodCount');
var villagerCount = document.querySelector('#villagerCount');

var xhr = getXMLHttp();

xhr.onreadystatechange = function () {
    if (xhr.readyState == 4 && xhr.status == 200) {
        let response = xhr.responseText;
        var ressourcesValues = getValues(response);
        woodCount.innerHTML = ressourcesValues[0];
        stoneCount.innerHTML = ressourcesValues[1];
        foodCount.innerHTML = ressourcesValues[2];
        villagerCount.innerHTML = ressourcesValues[3];
        console.log(response);
    }
}

xhr.open('GET', './controller/ressource.php?start=true', true);// mettre le bon controller;
xhr.send(null);

function getValues(text) {
    return text.split("/");
}
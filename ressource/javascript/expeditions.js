var troupe;
var coord;

document.body.addEventListener("changePage", updateExpeditions, false);


function updateExpeditions() {

    const field = document.getElementById('expeditionsListContainer');

    if (!field) return;

    var xhr = new XMLHttpRequest();

    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            let response = xhr.responseText;
            // console.log("receive : " + response);
            if (response == "erreur") alert("Impossible pour le moment");
            const object = JSON.parse(response);

            if (!field || !object) {
                setTimeout(updateExpeditions, 1000);

                return;
            }
            field.innerHTML = "";
            Object.keys(object).forEach(function (key, index) {
                const element = object[key];



                let bloc = " expeditions " + " : <br>";
                bloc += "date de départ de l'expédition : " + object[key]['depart'] + "<br>";
                bloc += " position a laquel l'expéditon est envoyé : " + object[key]['coo'] + "<br>";
                if (object[key]['arriver'] && object[key]['arriver'] > 0)
                    bloc += "temps restant avant arrivé : " + object[key]['arriver'] + "<br>";
                bloc += " unité :" + "<br>";
                if (object[key]['chasseur']) bloc += "- chasseur : " + object[key]['chasseur'] + "<br>";
                if (object[key]['chevalier']) bloc += "- chevalier : " + object[key]['chevalier'] + "<br>";
                if (object[key]['templier']) bloc += "- templier : " + object[key]['templier'] + "<br>";

                field.innerHTML += bloc + "<br>";
            });

            setTimeout(updateExpeditions, 1000);
        }
    }

    xhr.open('GET', './controller/expeditions.php?all=true', true);
    xhr.send(null);


}


function sendExpeditions() {

    if (troupe) {
        //on est a l'étape 2
        changePage('pages/expedition.html');
        let msg = "troupe envoyé :";
        Object.keys(troupe).forEach(function (key, index) {
            msg += key + " " + troupe[key] + " |";
        });
        let coo;
        let cooField = document.getElementById("coordinate");
        if (cooField == null && coord) coo = coord;
        else coo = cooField.value;
        const xhr = getXMLHttp();
        let request = './controller/expeditions.php?new=true&coo=' + coo;
        if (troupe['nbchasseur']) request += '&chasseur=' + troupe['nbchasseur'];
        if (troupe['nbtemplier']) request += '&templier=' + troupe['nbtemplier'];
        if (troupe['nbchevalier']) request += '&chevalier=' + troupe['nbchevalier'];

        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                let response = xhr.responseText;
                if (response == "erreur") alert("Impossible pour le moment");
                console.log(response);
                try {
                    const object = JSON.parse(response);
                    alert(msg);

                }
                catch (err) {
                    alert(msg);
                }
            }
        }
        xhr.open('GET', request, true);
        xhr.send(null);
        troupe = null;
        coord = null;

    } else {
        // on est a l'étape 1
        troupe = Array();
        if (document.getElementById("nbchasseur").value || document.getElementById("nbtemplier").value ||
            document.getElementById("nbchevalier").value) {
            if (!coord)
                changePage('pages/expeditionsSubPage/expeditions2.html');
            if (document.getElementById("nbchasseur").value)
                troupe['nbchasseur'] = document.getElementById("nbchasseur").value;
            if (document.getElementById("nbtemplier").value)
                troupe['nbtemplier'] = document.getElementById("nbtemplier").value;
            if (document.getElementById("nbchevalier").value)
                troupe['nbchevalier'] = document.getElementById("nbchevalier").value;

            if (coord)
                sendExpeditions()

        } else {
            troupe = null;
            alert("expéditions vide !");
        }

    }

}

function lamax(elementId) {

    let max = document.getElementById(elementId).max;
    document.getElementById(elementId).value = max;

}




showPlayers();
function showPlayers() {

    var xhr = new XMLHttpRequest();

    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            let response = xhr.responseText;
            // console.log("receive : " + response);
            if (response == "erreur") alert("Impossible pour le moment");
            const object = JSON.parse(response);
            const field = document.getElementById('playerList');

            if (!field || !object) {
                setTimeout(showPlayers, 1000);

                return;
            }
            let playerList = []
            //TODO ajouter dans le dict ["username":position] puis ajouter dans le html
            Object.keys(object).forEach((key, index) => {
                const element = object[key];
                playerList[element["username"]] = element["position"]
                let playerBtn = document.createElement("p")
                playerBtn.id = element["username"]
                playerBtn.innerHTML += "username : " + element["username"] + "<br>"
                playerBtn.innerHTML += "position : " + prettyCoordinates(element["position"]) + "<br>"
                playerBtn.addEventListener("click", () => coordo(playerList[element["username"]]))
                field.appendChild(playerBtn)
            })

            /*Object.keys(object).forEach(function (key, index) {
                const element = object[key];
                let futurToAdd = document.createElement("p")
                futurToAdd.id = element['username']
                let playerList = []
                futurToAdd.addEventListener("click", coordo(element['position']))
                Object.keys(element).forEach(function (key, index) {
                    futurToAdd.innerHTML += key + " " + element[key] + "<br>";
                });
                field.appendChild(futurToAdd);
            });*/

            setTimeout(showPlayers, 1000);
        }
    }

    xhr.open('GET', './controller/expeditions.php?players=true', true);
    xhr.send(null);


}

function prettyCoordinates(c) {
    let coord = JSON.parse(c)
    return "x: " + coord.x + " y:" + coord.y
}

function coordo(coordone) {
    document.getElementById("coordinate").value = coordone;
}
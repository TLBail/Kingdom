var troupe;

updateExpeditions();
function updateExpeditions() {

    console.log('salut');
    var xhr = getXMLHttp();
    var saisie;

    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            let response = xhr.responseText;
            // console.log("receive : " + response);
            if (response == "erreur") alert("Impossible pour le moment");
            // const object = JSON.parse(response);
            const field = document.getElementById('expeditionsListContainer');
            if (field) {
                field.innerHTML = response;
            }
            setTimeout(updateExpeditions, 1000);
        }
    }

    xhr.open('GET', './controller/expeditions.php?all=true', true);
    xhr.send(null);


}


function sendExpeditions() {

    if (troupe) {
        //on est a l'étape 2
        changePage('view/expedition.html');
        let msg = "troupe envoyé :";
        Object.keys(troupe).forEach(function (key, index) {
            msg += key + " " + troupe[key] + " |";
        });
        alert(msg);
        troupe = null;


    } else {
        // on est a l'étape 1
        troupe = Array();
        if (document.getElementById("nbchasseur").value || document.getElementById("nbtemplier").value ||
            document.getElementById("nbchevalier").value) {
            changePage('view/expeditionsSubPage/expeditions2.html');
            if (document.getElementById("nbchasseur").value)
                troupe['nbchasseur'] = document.getElementById("nbchasseur").value;
            if (document.getElementById("nbtemplier").value)
                troupe['nbtemplier'] = document.getElementById("nbtemplier").value;
            if (document.getElementById("nbchevalier").value)
                troupe['nbchevalier'] = document.getElementById("nbchevalier").value;

        } else {
            troupe = null;
            alert("expéditions vide !");
        }

    }

}
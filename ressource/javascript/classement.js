document.body.addEventListener("changePage", reloadClassement, false);
function reloadClassement() {

    let xhr = getXMLHttp();
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            let response = xhr.responseText;
            console.log("receive : " + response);
            const object = JSON.parse(response);

            const tableau = document.getElementById('tableauClassement');
            var content = `<table>
                        <thead>
                        <tr>
                            <th colspan="2">classement</th>
                        </tr>       
                        </thead >
                        <tbody>                     
                        `;
            content += '<tr>' +
                '<td><strong>Joueur</strong></td>' +
                '<td><strong>Score</strong></td>' +
                '</tr>';


            Object.keys(object).forEach(function (key, index) {
                const element = object[key];
                content += '<tr>' +
                    '<td>' + key + '</td>' +
                    '<td>' + element + '</td>' +
                    '</tr>';
            });
            content += '</tbody>';
            content += '</table>';

            tableau.innerHTML += content;

        }
    }

    xhr.open('GET', './controller/classement.php?', true);
    xhr.send(null);
}
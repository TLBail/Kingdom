var working = false;
// console.log("salut");
function onLogin() {
    console.log("login..");
    let targetURL = './session.php';
    let newURL = document.createElement('a');
    newURL.href = targetURL;
    document.body.appendChild(newURL);
    newURL.click();
}


function getXMLHttp() {
    var xhr = null;
    xhr = new XMLHttpRequest();
    return xhr;
}

function updateMsg() {

    // console.log("update msg..");
    var xhr = getXMLHttp();

    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            let response = xhr.responseText;
            // console.log("receive : " + response);

            if (document.getElementById("mainchat")) {
                document.getElementById("mainchat").innerHTML = response;
            }
            setTimeout(updateMsg, 1000);
        }
    }

    xhr.open('GET', './controller/chatUpdater.php', true);
    xhr.send(null);

}

updateMsg();

function sendChat() {
    var xhr = getXMLHttp();

    xhr.open('GET', './controller/chatUpdater.php?newChatMessage=' + document.getElementById('newChatMessage').value, true);
    xhr.send(null);
}

function closeChat() {
    let container = document.getElementById("chatcontainer");
    container.innerHTML = "chat";
    container.classList.remove('onchat');
    setTimeout(() => {
        actived = false;
    }, 500);
}



const panelchat =
    '<main id="mainchat">' +
    '</main>' +
    '<button onclick="closeChat()" style="position: absolute;right: 0;">' +
    'fermer' +
    '</button>' +
    '<section class="chatbox">' +
    '        ton message :' +
    '        <input type="text" name="newChatMessage" id="newChatMessage">' +
    '        <input type="submit" onclick="sendChat()" value="newChat">' +
    '</section>';


var actived = false;
function showchat() {

    if (!actived) {

        let container = document.getElementById("chatcontainer");
        container.innerHTML = panelchat;
        container.classList.add('onchat');
        actived = true;

    }


}


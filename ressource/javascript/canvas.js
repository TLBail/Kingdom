async function getBatimentLvl() {
    return await new Promise(resolve => {

        var xhr = getXMLHttp();

        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                let response = JSON.parse(xhr.responseText);
                let toReturn = {};
                for ([key, value] of Object.entries(response)) {
                    toReturn[key.toLowerCase()] = value.lvl;
                };
                resolve(toReturn);
            }
        }

        xhr.open('GET', './controller/batiment.php?all=true', true);
        xhr.send(null);
    })
}

async function updateCanvas() {

    var canvas = document.getElementById('canvasBatiments');
    if (!canvas) {
        console.log("pas de canvas");
        return setTimeout(() => {
            updateCanvas
        }, 1000);
    };
    canvas.width = document.getElementById("PageContainer").offsetWidth;
    //canvas.height = document.getElementById("PageContainer").offsetHeight / 100 * 66;
    canvas.height = 450;
    var ctx = canvas.getContext('2d');
    ctx.fillStyle = 'rgb(0, 0, 0)';
    ctx.fillRect(0, 0, 150, 150);


    var img1 = new Image();
    img1.src = './ressource/backgroundCanvas.png';
    img1.onload = function () {

        ctx.drawImage(img1, 0, 0, canvas.width, canvas.height);
    };

    let levelList = await getBatimentLvl();
    console.log(levelList);

    var harbor = new Image();
    harbor.src = "./ressource/assets/harbor.png";
    harbor.onload = function () {
        ctx.drawImage(harbor, 212, 252, 128, 128);
    };

    await new Promise(resolve => {
        setTimeout(() => {
            resolve();
        }, 1000);
    })
    let topMargin = 0;
    console.log(levelList);
    for (const batimentSection of document.getElementById("batimentContainer").childNodes) {
        if (batimentSection.nodeType !== 1) {
            continue;
        } else {
            console.log(batimentSection);
            let batimentName = batimentSection.childNodes[3].innerText.replace("è", "e").toLowerCase();
            displayBatimentOnCanvas(ctx, canvas.width, batimentName.replace(/ +/gi, "-"), levelList[batimentName], topMargin);
            topMargin += 50;
        }
    }

}

function displayBatimentOnCanvas(ctx, width, name, level, offsetHeight) {
    let rightMargin = 10;
    console.log("Processing " + name + " with level " + level);
    var iMax = level;
    switch(name){
        case "immeuble" : {
            iMax = Math.min(iMax, 10);
            break;
        }
        case "maison" : {
            iMax = Math.min(iMax, 15);
            break;
        }
        case "silo" : {
            iMax = Math.min(iMax, 20);
            break;
        }
        default:{
            iMax = Math.min(iMax, 25);
            break;
        }
    }
    for (let i = 0; i < iMax; i++) {
        let image = new Image();

        image.src = `./ressource/assets/${name}.png`;
        image.onerror = () => {
            image.src = `./ressource/assets/test.png`
        };

        image.onload = () => {
            ctx.drawImage(image, width - rightMargin - 55, offsetHeight, 55, 55);
            rightMargin += 45;
        };
    }
}

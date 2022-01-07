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


    var harbor = new Image();
    harbor.src = "./ressource/assets/harbor.png";
    harbor.onload = function () {

        ctx.drawImage(harbor, 212, 500, 128, 128);
    };

    await new Promise(resolve => {
        setTimeout(() => {
            resolve();
        }, 1000);
    })
    let topMargin = 0;
    for (const batimentSection of document.getElementById("batimentContainer").childNodes) {
        if (batimentSection.nodeType !== 1) {
            continue;
        } else {
            displayBatimentOnCanvas(ctx, canvas.width, batimentSection.childNodes[3].id, parseInt(batimentSection.childNodes[3].innerText.split("\n")[0].replace("lvl ", "")), topMargin);
            topMargin += 50
        }
    }

}

function displayBatimentOnCanvas(ctx, width, name, level, offsetHeight) {
    console.log(`Processing ${name}|`);
    let rightMargin = 10;
    for (let i = 0; i < level; i++) {
        let image = new Image();
        image.src = `./ressource/assets/${name}.png`;

        image.onerror = () => image.src = `./ressource/assets/test.png`;

        image.onload = () => {
            ctx.drawImage(image, width - rightMargin - 55, offsetHeight, 55, 55);
            rightMargin += 45;
        };
    }
}

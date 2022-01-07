function updateCanvas() {

    var canvas = document.getElementById('canvasBatiments');
    if (!canvas) {
        console.log("pas de canvas");
        return updateCanvas()
    };
    canvas.width = document.getElementById("PageContainer").offsetWidth;
    canvas.height = document.getElementById("PageContainer").offsetHeight;

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

}

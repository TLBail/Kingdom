var playersCoordinate = []
var players = []

function test(x, y) {
    let i =playersCoordinate.some((t) => isEqual(t,{"x":x,"y":y}));
    if(i != -1)
        console.log(players[i]);
}


function test2(x,y, ctx) {
    if(playersCoordinate.some(t => isEqual(t, {"x":x,"y":y})))
        //TODO dessiner texte avec un offset
        //ctx.fillStyle = 'black'
        //ctx.fillText();
        return;
}

function getPlayerCoordinateList(ctx, cellSize){
    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = ()=>{
        if(xhr.readyState == 4 && xhr.status == 200)
            processResponse(xhr.responseText, ctx, cellSize)
    }
    xhr.open("GET", "./controller/map.php?")
    xhr.send(null)
}



function processResponse(response, ctx, cellSize){
    const playerListJSON = JSON.parse(response);
    Object.keys(playerListJSON).forEach((key, index)=>{
        let position = JSON.parse(playerListJSON[key]['position'])
        let player = playerListJSON[key]['username']
        playersCoordinate.push(position) 
        players.push(player)
    })
    playersCoordinate.forEach(coord => {
        drawPresence(ctx, cellSize, coord.x, coord.y)
    });
}

const isEqual = (first, second)=>{
    return JSON.stringify(first) === JSON.stringify(second)
}


function drawGrid(canvas, ctx, cellSize) {
    ctx.fillStyle = 'white'
    ctx.fillRect(0,0,canvas.width, canvas.height)
    for (let i = 0; i <= canvas.width; i+=cellSize) {
        ctx.moveTo(i,0)
        ctx.lineTo(i,canvas.height)
        ctx.moveTo(0,i) 
        ctx.lineTo(canvas.width, i)
    }
    ctx.strokeStyle = "black"
    ctx.stroke()
}

function drawPresence(ctx, cellSize, x, y) {
    ctx.font = '12px serif'
    ctx.fillStyle = "black"
    ctx.textAlign = 'center'
    ctx.fillText("here", x*cellSize+cellSize/2, y*cellSize+cellSize/2+6, 40);
}


document.body.addEventListener("changePage", ()=>{
    let contentContainer = document.querySelector("#PageContainer")

    let canvas = document.createElement("canvas")
    canvas.width = 600
    canvas.height = 600
    contentContainer.append(canvas)

    let ctx = canvas.getContext("2d")
    let cellSize = 40

    canvas.addEventListener("click", event => test(Math.floor(event.offsetX/cellSize),Math.floor(event.offsetY/cellSize)))
    canvas.addEventListener("mouseover", event => test2(Math.floor(event.offsetX/cellSize), Math.floor(event.offsetY.cellSize), ctx))
    drawGrid(canvas, ctx, cellSize)
    getPlayerCoordinateList(ctx, cellSize);
    /*document.querySelector(".top-btn").addEventListener("click", ()=>{
        getPlayerCoordinateList(ctx, cellSize)
    })
    document.querySelector(".left-btn").addEventListener("click", ()=>{
        getPlayerCoordinateList(ctx, cellSize)
    })
    document.querySelector(".right-btn").addEventListener("click", ()=>{
        getPlayerCoordinateList(ctx, cellSize)
    })
    document.querySelector(".down-btn").addEventListener("click", ()=>{
        getPlayerCoordinateList(ctx, cellSize)
    })*/
}, false)






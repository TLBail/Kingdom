var playersCoordinate = []
var players = []

function test(x, y) {
    let i =playersCoordinate.findIndex((t) => isEqual(t,{"x":x,"y":y}));
    if(i != -1)
        console.log(players[i])
    //TODO link au expedition
}


function test2(x,y, canvas, ctx, cellSize) {
    let i =playersCoordinate.findIndex((t) => isEqual(t,{"x":x,"y":y}));
    if(i != -1){
        ctx.fillStyle = "black"
        ctx.font = "12px serif"
        console.log(x*cellSize+cellSize/2, y*cellSize)
        ctx.fillText(players[i], x*cellSize+cellSize/2, y*cellSize)
    }else{
        drawGrid(canvas, ctx,cellSize)
        playersCoordinate.forEach(coord =>{
            drawPresence(ctx, cellSize, coord.x, coord.y)
        })
    }
}

function getPlayerCoordinateList(canvas, ctx, cellSize){
    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = ()=>{
        if(xhr.readyState == 4 && xhr.status == 200)
            processResponse(xhr.responseText,canvas, ctx, cellSize)
    }
    xhr.open("GET", "./controller/map.php?")
    xhr.send(null)
}



function processResponse(response, canvas, ctx, cellSize){
    const playerListJSON = JSON.parse(response);
    Object.keys(playerListJSON).forEach((key, index)=>{
        let position = JSON.parse(playerListJSON[key]['position'])
        let player = playerListJSON[key]['username']
        playersCoordinate.push(position) 
        players.push(player)
    })
    drawGrid(canvas, ctx, cellSize)
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
    ctx.fillText("here", x*cellSize+cellSize/2, y*cellSize+cellSize/2+6, cellSize);
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
    canvas.addEventListener("pointermove", event => test2(Math.floor(event.offsetX/cellSize), Math.floor(event.offsetY/cellSize), canvas,ctx,cellSize))
    drawGrid(canvas, ctx, cellSize)
    getPlayerCoordinateList(canvas, ctx, cellSize);
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






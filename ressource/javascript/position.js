var playersCoordinate = []
var players = []
var x
var y
var offset

function expedition(x, y) {
    let i =playersCoordinate.findIndex((t) => isEqual(t,{"x":x,"y":y}));
    if(i != -1)
        console.log(players[i])
    //TODO link au expedition
}


function tooltip(x,y, canvas, ctx, cellSize) {
    let i =playersCoordinate.findIndex((t) => isEqual(t,{"x":x,"y":y}));
    if(i != -1){
        redraw(canvas, ctx, cellSize)
        ctx.fillStyle = "black"
        ctx.font = "12px serif"
        ctx.fillText(players[i], x*cellSize+cellSize/2, y*cellSize+12)
    }else{
        redraw(canvas, ctx, cellSize)
    }
}

function redraw(canvas, ctx, cellSize) {
    drawGrid(canvas, ctx,cellSize)
    for (const coord of playersCoordinate) {
        console.log(coord,coord.x, coord.y, x,x+offset, y, y+offset, coord.x>= x && coord.x<x+offset && coord.y>=y && coord.y<y+offset)
        if(coord.x>= x && coord.x<x+offset && coord.y>=y && coord.y<y+offset){
            console.log("je suis la")
            drawPresence(ctx, cellSize, coord.x-x, coord.y-y)
        }
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
    for (const coord of playersCoordinate) {
        if(coord.x>= x && coord.x<x+offset && coord.y>=y && coord.y<y+offset)
            drawPresence(ctx, cellSize, coord.x-x, coord.y-y)
    }
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
    let canvas = document.querySelector("#map")
    canvas.width = 600
    canvas.height = 600

    let ctx = canvas.getContext("2d")
    let cellSize = 40

    canvas.addEventListener("click", event => expedition(Math.floor(event.offsetX/cellSize),Math.floor(event.offsetY/cellSize)))
    canvas.addEventListener("pointermove", event => tooltip(Math.floor(event.offsetX/cellSize), Math.floor(event.offsetY/cellSize), canvas,ctx,cellSize))

    x = 0
    y = 0

    getPlayerCoordinateList(canvas, ctx, cellSize, x, y)

    offset = canvas.width/cellSize

    document.querySelector(".top-btn").addEventListener("click", ()=>{
        y-=offset
        getPlayerCoordinateList(canvas, ctx, cellSize)
    })
    document.querySelector(".left-btn").addEventListener("click", ()=>{
        x-=offset
        getPlayerCoordinateList(canvas, ctx, cellSize)
    })
    document.querySelector(".right-btn").addEventListener("click", ()=>{
        x+=offset
        getPlayerCoordinateList(canvas, ctx, cellSize)
    })
    document.querySelector(".down-btn").addEventListener("click", ()=>{
        y+=offset
        getPlayerCoordinateList(canvas, ctx, cellSize)
    })
}, false)






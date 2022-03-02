

function test(e) {
    let x =Math.floor(e.clientX/cellSize)
    let y = Math.floor(e.clientY/cellSize)
    if(playersCoordinate.some(e => isEqual(e, {x,y})))
        console.log("jfdklmsqfjdklsm")
}

function getPlayerCoordinateList(){
    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = ()=>{
        if(xhr.readyState == 4 && xhr.status == 200)
            processResponse(xhr.responseText)
    }
    xhr.open("GET", "./controller/map.php?")
    xhr.send(null)
}

var playersCoordinate = [];

function processResponse(response){
    const playerListJSON = JSON.parse(response);
    Object.keys(playerListJSON).forEach((key, index)=>{
        let x = parseInt(playerListJSON[key]['x'])
        let y = parseInt(playerListJSON[key]['y'])
        playersCoordinate.push({x,y}) 
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
    let x = 0;
    let y = 0;
    let contentContainer = document.querySelector(".PageContainer")

    let canvas = document.createElement("canvas")
    canvas.width = 800
    canvas.height = 800
    contentContainer.append(canvas)

    let ctx = canvas.getContext("2d")
    let cellSize = 40

    canvas.addEventListener("click",test)
    drawGrid(canvas, ctx, cellSize)
    getPlayerCoordinateList();
    document.querySelector(".top-btn").addEventListener("click", ()=>{
        y-=10
        getPlayerCoordinateList()
    })
    document.querySelector(".left-btn").addEventListener("click", ()=>{
        x-=10
        getPlayerCoordinateList()
    })
    document.querySelector(".right-btn").addEventListener("click", ()=>{
        x+=10
        getPlayerCoordinateList()
    })
    document.querySelector(".down-btn").addEventListener("click", ()=>{
        y+=10
        getPlayerCoordinateList()
    })
}, false)






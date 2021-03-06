//!GLOBAL VARIABLES
var canvas
var ctx
var cellSize

var playersCoordinate = []
var players = []

var currentUserPosition;


var offsetX
var offsetY
var boxNumber

//TODO refaire toute la partie coordonnée

document.body.addEventListener("changePage", ()=>{

    initGlobalValues(600)
    if(canvas == null) return;

    canvas.addEventListener("click", event => expedition(calculateEventXPosOnGrid(event.offsetX), calculateEventYPosOnGrid(event.offsetY)))
    canvas.addEventListener("pointermove", event => tooltip(calculateEventXPosOnGrid(event.offsetX), calculateEventYPosOnGrid(event.offsetY)))

    getCurrentPosition()
    getPlayerCoordinateList()

    document.querySelector(".top-btn").addEventListener("click", ()=>{
        offsetY--
        getPlayerCoordinateList()
    })
    document.querySelector(".left-btn").addEventListener("click", ()=>{
        offsetX--
        getPlayerCoordinateList()
    })
    document.querySelector(".right-btn").addEventListener("click", ()=>{
        offsetX++
        getPlayerCoordinateList()
    })
    document.querySelector(".down-btn").addEventListener("click", ()=>{
        offsetY++
        getPlayerCoordinateList()
    })
}, false)




function initGlobalValues(size) {
    canvas = document.querySelector("#map")
    if(canvas == null) return;
    canvas.width = size
    canvas.height = size
    ctx = canvas.getContext("2d")
    cellSize = 40
    boxNumber = size/cellSize
    offsetX = 0
    offsetY = 0
}


function expedition(x, y) {
    let i =playersCoordinate.findIndex((t) => isEqual(t,{"x":calculateMapPosXtoStoredPosX(x),"y":calculateMapPosYtoStoredPosY(y)}));
    if(i != -1 && JSON.stringify(currentUserPosition) !== JSON.stringify(playersCoordinate[i])){
        coord  = playersCoordinate[i];
        changePage('pages/expedition.html')
    }
}


function tooltip(coordX, coordY) {
    let i =playersCoordinate.findIndex((t) => isEqual(t,{"x":calculateMapPosXtoStoredPosX(coordX),"y":calculateMapPosYtoStoredPosY(coordY)}));
    if(i != -1) {
        drawAllPresence()
        drawTooltip(players[i], coordX, coordY)
    }
    else drawAllPresence()
}

//!AJAX FUNCTIONS
function getPlayerCoordinateList(){
    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = ()=>{
        if(xhr.readyState == 4 && xhr.status == 200)
            processCoordinateList(xhr.responseText)
    }
    xhr.open("GET", './controller/map.php?')
    xhr.send(null)
}

function processCoordinateList(response){
    players = []
    playersCoordinate = []
    const playerListJSON = JSON.parse(response);
    parseResponse(playerListJSON)
    drawAllPresence()
}

function getCurrentPosition() {
    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = ( )=>{
        if(xhr.readyState == 4 && xhr.status == 200)
            processCurrentPosition(xhr.responseText)
    }
    xhr.open("GET", './controller/centerMap.php?')
    xhr.send(null)
}

function processCurrentPosition(response) {
    currentUserPosition = JSON.parse(response)
    offsetX = calculateOffset(currentUserPosition.x)
    offsetY = calculateOffset(currentUserPosition.y)
}


//! UTILITIES FUNCTIONS
function calculateCenteredPosXOnCanvas(x) {
    return (x)*(cellSize)+(cellSize/2)
}

function calculateCenteredPosYOnCanvas(y) {
    return (y)*(cellSize)+(cellSize/2)
}
function calculateEventXPosOnGrid(x) {
    return Math.floor(x/cellSize)
}

function calculateEventYPosOnGrid(y) {
    return Math.floor(y/cellSize)
}

function calculateStoredPosXToMapPosX(x) {
    return x-offsetX*boxNumber
}

function calculateStoredPosYtoMapPosY(y) {
    return y-offsetY*boxNumber
}

function calculateMapPosXtoStoredPosX(x) {
    return x+offsetX*boxNumber
}

function calculateMapPosYtoStoredPosY(y) {
    return y+offsetY*boxNumber
}

function calculateOffset(p) {
    return Math.floor(p / boxNumber)
}

function parseResponse(response) {
    Object.keys(response).forEach((key)=>{
        let position = JSON.parse(response[key]['position'])
        let player = response[key]['username']
        playersCoordinate.push(position) 
        players.push(player)
    })
}

const isEqual = (first, second)=>{
    return JSON.stringify(first) === JSON.stringify(second)
}

//!DRAW FUNCTIONS
function drawAllPresence() {
    resetCanvas()
    drawGrid()
    for (const coord of playersCoordinate) {
        if(coord.x >= offsetX*boxNumber && coord.x < offsetX*boxNumber+boxNumber && coord.y >=offsetY*boxNumber && coord.y < offsetY*boxNumber+boxNumber)
            drawPresence(calculateStoredPosXToMapPosX(coord.x), calculateStoredPosYtoMapPosY(coord.y))
    }
}

function resetCanvas() {
    ctx.fillStyle = 'white'
    ctx.fillRect(0,0,canvas.width, canvas.height)
}

function drawGrid() {
    for (let i = 0; i <= canvas.width; i+=cellSize) {
        ctx.moveTo(i,0)
        ctx.lineTo(i,canvas.height)
        ctx.moveTo(0,i) 
        ctx.lineTo(canvas.width, i)
    }
    ctx.fillStyle= "black"
    ctx.strokeStyle = "black"
    ctx.stroke()
}

function drawPresence(x, y) {
    ctx.font = '24px serif'
    ctx.fillStyle = "black"
    ctx.textAlign = 'center'
    ctx.fillText("🏠", calculateCenteredPosXOnCanvas(x), calculateCenteredPosYOnCanvas(y)+8, cellSize);
}

function drawTooltip(playerUsername, x, y) {
    ctx.fillStyle = "black"
    ctx.font = "18px serif"
    ctx.fillText(playerUsername, calculateCenteredPosXOnCanvas(x), calculateCenteredPosYOnCanvas(y)-20 <= 0 ? calculateCenteredPosYOnCanvas(y)+40 : calculateCenteredPosYOnCanvas(y)-20)
}
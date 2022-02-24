function populateMapGrid(x, y, playersCoordinate) {
    let mapGrid = document.querySelector(".map-grid");
    mapGrid.innerHTML = ""
    for (let i = 0; i < 10; i++)
        for(let j = 0; j < 10; j++)
            mapGrid.appendChild(createElement(x+i, y+j, playersCoordinate));
}

function createElement(i, j, playersCoordinate){
    item = document.createElement("div")
    if(playersCoordinate.includes(i+j))
        item.innerHTML = i + ", " + j
    item.classList.add("map-grid-item")
    return item
}

document.body.addEventListener("changePage", ()=>{
    let x = 0;
    let y = 0;
    let playersCoordinate;
    getPlayerCoordinateList(playersCoordinate);
    populateMapGrid(x, y, playersCoordinate);
    document.querySelector(".top-btn").addEventListener("click", ()=>{
        x-=10
        getPlayerCoordinateList(playersCoordinate)
        populateMapGrid(x,y,playersCoordinate)
    })
    document.querySelector(".left-btn").addEventListener("click", ()=>{
        y-=10
        getPlayerCoordinateList(playersCoordinate)
        populateMapGrid(x,y,playersCoordinate)
    })
    document.querySelector(".right-btn").addEventListener("click", ()=>{
        y+=10
        getPlayerCoordinateList(playersCoordinate)
        populateMapGrid(x,y,playersCoordinate)
    })
    document.querySelector(".down-btn").addEventListener("click", ()=>{
        x+=10
        getPlayerCoordinateList(playersCoordinate)
        populateMapGrid(x,y,playersCoordinate)
    })
}, false)


function getPlayerCoordinateList(playersCoordinate){
    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = ()=>{
        if(xhr.readyState == 4 && xhr.status == 200)
            playersCoordinate = processResponse(xhr.responseText)
    }
    xhr.open("GET", "./controller/map.php?")
    xhr.send(null)
}

function processResponse(response){
    const playerListJSON = JSON.parse(response);
    let playersCoordinate = [];
    Object.keys(playerListJSON).forEach((key, index)=>{
      playersCoordinate.push(playerListJSON[key]['position'])  
    })
    return playersCoordinate
}
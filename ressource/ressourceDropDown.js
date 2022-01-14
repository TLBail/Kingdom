var ressourceBarWrapper = document.getElementById('resourceBarWrapper');
var ressourceBar = document.getElementById('ressourceBar');
var original = ressourceBarWrapper.innerHTML;

ressourceBar.addEventListener('mouseenter', e => {
    console.log("salut");
    ressourceBarWrapper.innerHTML += '<div id="dropdown-content"> ' +
        '<h1> ' +
        ' Salut ' +
        ' </h1 > ' +
        ' </div > ';
});

ressourceBar.addEventListener('mouseleave', e => {
    ressourceBarWrapper.innerHTML = original;
});

function onRessourceBarHover() {
    console.log("salut");
    ressourceBarWrapper.innerHTML += '< div id = "dropdown-content" > ' +
        '<h1> ' +
        ' Salut ' +
        ' </h1 > ' +
        ' </div > ';
}


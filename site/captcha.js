// Sélectionner toutes les images dans la div "board"
var images = document.querySelectorAll("#board img");

var currTile;
var otherTile;

// Mélanger les images dans le tableau
var imageArray = Array.from(images);
imageArray.sort(function() {
    return 0.5 - Math.random();
});

// Réinsérer les images mélangées dans la div "board"
var board = document.getElementById("board");
board.innerHTML = "";
imageArray.forEach(function(image) {
    board.appendChild(image);
   

    // Attacher des événements aux images
    image.addEventListener("dragstart", dragStart);
    image.addEventListener("dragover", dragOver);
    image.addEventListener("dragenter", dragEnter);
    image.addEventListener("dragleave", dragLeave);
    image.addEventListener("drop", dragDrop);
    image.addEventListener("dragend", dragEnd);
});

function dragStart(e) {
    currTile = this;
}

function dragOver(e) {
    e.preventDefault();
}

function dragEnter(e) {
    e.preventDefault();
}

function dragLeave(e) {
}

function dragDrop(e) {
    e.preventDefault();
    otherTile = this;
}

function dragEnd(e) {
    if (otherTile) {
        // Échanger les sources des images
        var currSrc = currTile.src;
        currTile.src = otherTile.src;
        otherTile.src = currSrc;
    }
}

function checkOrder() {
    var order = ["img/SPLITE/captcha-split/imageonline/0.png", "img/SPLITE/captcha-split/imageonline/1.png", "img/SPLITE/captcha-split/imageonline/2.png", "img/SPLITE/captcha-split/imageonline/3.png", "img/SPLITE/captcha-split/imageonline/4.png", "img/SPLITE/captcha-split/imageonline/5.png"];

    const div = document.querySelector('#board');

    const images = div.querySelectorAll('img');
    var c = 0;
    for (i = 0; i < 6; i++) {
        res = images[i].src;
        
        if (res.endsWith(order[i])) {
            c++;
            if (c == 6) {
                window.location.href = "recup.php";
                return;
            }
        }
    }
    console.log("nn c fonction pas");
}

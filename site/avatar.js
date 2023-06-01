
let i = 0;
function myFunction(){
    console.log(i)
    var blue = "layers/back/BLUE.png";


    var gold = "layers/back/GOLD.png";

    var green = "layers/back/green.png";


    var perpel = "layers/back/PERPEL.png";


    var red = "layers/back/RED.png";


    var simon = "layers/back/SIMON.png";


    var white = "layers/back/white.png";
    let len = 6;
    
    let body=[blue,gold,green,perpel,red,simon,white]
    let image = document.getElementById("bg").src = body[i];
    if (i == len) {
        i = 0;
    }
    else{
        i++;
    }
    
    
}
let s=0 ;
function skine(){
    console.log(s)
    var normal = "layers/SKINY/NORMAL.png";


    var dark = "layers/SKINY/DARK_SKINY.png";

    var gold = "layers/SKINY/GOLDEN.png";


    var zombie = "layers/SKINY/ZOMBIE.png";

    let len = 3;
    
    let skin=[normal,dark,gold,zombie]
    let image = document.getElementById("skin").src = skin[s];
    if (s == len) {
        s = 0;
    }
    else{
        s++;
    }
    
}


let m=0 ;
function clothes(){
    console.log(m)
    var normal = "layers/clothes/NORMAL.png";


    var green = "layers/clothes/GREEN.png";

    var gold = "layers/clothes/GOLD.png";


    var ORANGE = "layers/clothes/ORANGE.png";


    var perpel = "layers/clothes/PERPUL.png";

    var red = "layers/clothes/RED.png";

    let len = 5;
    
    let skin=[normal,green,gold,ORANGE,perpel,red]
    let image = document.getElementById("clothes").src = skin[m];
    if (m == len) {
        m = 0;
    }
    else{
        m++;
    }
    
}


let v=0 ;
function ex(){
    console.log(v)
    var normal = "layers/EXOSSIERS/NORMAL.png";

    var gold = "layers/EXOSSIERS/GOLDEN.png";

    let len = 1;
    
    let skin=[normal,gold]
    let image = document.getElementById("EXOSSIERS").src = skin[v];
    
    if (v == len) {
        v = 0;
    }
    else{
        v++;
    }
    
}


let g = 0;
function eye(){
    console.log(g)
    var blue = "layers/EYE/BLUE.png";


    var gold = "layers/EYE/GOLDEN.png";

    var green = "layers/EYE/ZOMBIE.png";


    var perpel = "layers/EYE/GLASSES.png";


    var red = "layers/EYE/VAMPIER.png";


    var simon = "layers/EYE/NORMAL.png";


    var white = "layers/EYE/OBITO.png";
    let len = 6;
    
    let eye=[blue,gold,green,perpel,red,simon,white]
    let image = document.getElementById("eye").src = eye[g];
    if (g == len) {
        g = 0;
    }
    else{
        g++;
    }
    
}




let f = 0;
function cap(){
    console.log(f)
    var blue = "layers/HAT/CAP.png";


    var gold = "layers/HAT/FLYING_CAP.png";

    var green = "layers/HAT/KARATE.png";



    let len = 2;
    
    let eye=[blue,gold,green]
    let image = document.getElementById("cap").src = eye[f];
    if (f == len) {
        f = 0;
    }
    else{
        f++;
    }
    
}

let h=0 ;
function th(){
    console.log(h)
    var normal = "layers/TEATH/NORMAL.png";

    var gold = "layers/TEATH/GOLDEN.png";

    let len = 1;
    
    let skin=[normal,gold]
    let image = document.getElementById("th").src = skin[h];
    
    if (h == len) {
        h = 0;
    }
    else{
        h++;
    }
    
}



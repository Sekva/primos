
var side_nav_aberto = false;

function trocarNav() {
    if(side_nav_aberto) {
        side_nav_aberto = false;
        closeNav();
    } else {
        side_nav_aberto = true;
        openNav();
    }
}


function openNav() {
    document.getElementById("sidenav").style.width = "250px";
    document.getElementById("main").style.marginLeft = "250px";
    document.body.style.backgroundColor = "rgba(0,0,0,0.4)";
}

function closeNav() {
    document.getElementById("sidenav").style.width = "0";
    document.getElementById("main").style.marginLeft= "0";
    document.body.style.backgroundColor = "white";
}



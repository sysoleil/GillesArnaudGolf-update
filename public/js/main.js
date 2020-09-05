// ------------------------- CAROUSEL 1 ----------------------------------------------
var angle = 0;
function galleryspin(sign) {
    spinner = document.querySelector("#spinner");
    if (!sign) { angle = angle + 45; } else { angle = angle - 45; }
    spinner.setAttribute("style","-webkit-transform: rotateY("+ angle +"deg); -moz-transform: rotateY("+ angle +"deg); transform: rotateY("+ angle +"deg);");
}

// ------------------------- CAROUSEL 2 ----------------------------------------------
var angle = 0;
function galleryspin2(sign) {
    spinner = document.querySelector("#spinner2");
    if (!sign) { angle = angle + 45; } else { angle = angle - 45; }
    spinner.setAttribute("style","-webkit-transform: rotateY("+ angle +"deg); -moz-transform: rotateY("+ angle +"deg); transform: rotateY("+ angle +"deg);");
}

// ------------------------- suite ----------------------------------------------
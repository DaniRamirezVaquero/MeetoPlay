let scrollF = document.getElementById("scroll");
let arrow = document.getElementById("dropDownArrow");
arrow.style.position="sticky";
arrow.style.left="510px";

scrollF.onscroll = function () {
    scrollRotation(scrollF.scrollTop);
    console.log(scrollF.scrollTop);
}

function scrollRotation(scroll) {
    arrow.style.transform = "rotate(" + (scroll / 330) * 180 + "deg)";
}

let navbar = document.querySelector('.navbar');

document.querySelector('#menu').onclick = () =>{
    navbar.classList.toggle('active');
}

window.onscroll = () =>{
    navbar.classList.remove('active');
}


//ANTI RABIES MODAL INFO
function openDogRabiesModal() {
    document.getElementById("dogRabiesModal").style.display = "flex";
}
function closeDogRabiesModal() {
    document.getElementById("dogRabiesModal").style.display = "none";
}


function openCatRabiesModal() {
    document.getElementById('catRabiesModal').style.display = 'flex';
}
function closeCatRabiesModal() {
    document.getElementById('catRabiesModal').style.display = 'none';
}


function openRatRabiesModal() {
    document.getElementById('ratRabiesModal').style.display = 'flex';
}
function closeRatRabiesModal() {
    document.getElementById('ratRabiesModal').style.display = 'none';
}
//END OF ANTI RABIES MODAL INFO



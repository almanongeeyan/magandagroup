let navbar = document.querySelector('.navbar');

document.querySelector('#menu').onclick = () =>{
    navbar.classList.toggle('active');
}

window.onscroll = () =>{
    navbar.classList.remove('active');
}

//FOR LOGIN MODALS
function openLoginModal() {
    document.getElementById("LoginModal").style.display = "flex";
}
function closeLoginModal() {
    document.getElementById("LoginModal").style.display = "none";
}

window.onclick = function(event) {
    let modal = document.getElementById("LoginModal");
    if (event.target === modal) {
        closeModal();
    }
};
//END OF LOGIN MODALS



//FOR REGISTRATION MODALS
function openModal() {
    document.getElementById("registerModal").style.display = "flex";
}
function closeModal() {
    document.getElementById("registerModal").style.display = "none";
}

window.onclick = function(event) {
    let modal = document.getElementById("registerModal");
    if (event.target === modal) {
        closeModal();
    }
};
//END OF REGISTRATION MODALS



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

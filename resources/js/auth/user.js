const token = localStorage.getItem("token");

if (!token) {
    window.location.href = "/login";
}

const userData = localStorage.getItem("user");
const user = JSON.parse(userData);
const username = document.getElementById("username");
username.innerText = user.nom + " " + user.prenom;

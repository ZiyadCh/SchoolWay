import token from "./token.js";

const userData = localStorage.getItem("user");
const user = JSON.parse(userData);
const username = document.getElementById("username");
username.innerText = user.prenom + " " + user.nom;

export default user;

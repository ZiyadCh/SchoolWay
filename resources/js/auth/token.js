import unauthorizedPage from "./logout.js";
export default function getToken() {
    let token = localStorage.getItem("token");
    if (token) {
        return token;
    }

    unauthorizedPage();

    return null;
}

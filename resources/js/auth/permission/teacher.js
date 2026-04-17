import user from "../user.js";
import unauthorizedPage from "../logout.js";

if (user.role != "teacher") {
    unauthorizedPage();
}

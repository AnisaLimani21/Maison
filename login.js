const loginForm = document.getElementById("loginForm");

if (loginForm) {
    loginForm.addEventListener("submit", function(event) {
        event.preventDefault();

        const user = document.getElementById("user").value.trim();
        const pass = document.getElementById("pass").value.trim();

        const userR = /^[a-zA-Z0-9]{4,15}$/;
        const passS = /^(?=.*[A-Za-z])(?=.*\d).{6,}$/;

        const userError = document.getElementById("userError");
        const passError = document.getElementById("passError");

        userError.textContent = "";
        passError.textContent = "";

        let valid = true;

        if (!userR.test(user)) {
            userError.textContent = "Username must contain only letters and numbers, and be 4–15 characters long!";
            valid = false;
        }

        if (!passS.test(pass)) {
            passError.textContent = "Password must contain at least 6 characters, including at least one letter and one number!";
            valid = false;
        }

        if (valid) {
            loginForm.submit();
        }
    });
}
function searchProduct() {
    const input = document.getElementById('searchInput').value.toLowerCase().trim();

    const pages = {
        "muffins": "Muffins.html",
        "cookies": "Cookies.html",
        "donuts": "Donuts.html",
        "macarons": "Macarons.html",
        "chocolates": "Chocolates.html",
        "brownies": "Brownies.html",
        "croissants": "Croissants.html",
        "cheesecakes": "Cheesecakes.html",
        "pralines": "Pralines.html",
        "wine": "Wine.html",
        "login": "login.html",
        "boba":"Boba.html",
        "products": "Produktet.html"
    };

    if(pages[input]) {
        window.location.href = pages[input];
    } else {
        alert("Product not found");
    }
}
const hamburger = document.getElementById("hamburger");
const navLinks = document.getElementById("nav-links");
hamburger.addEventListener("click", () => {
    navLinks.classList.toggle("active");
});


const createForm=document.getElementById("createForm");

if(createForm){
    createForm.addEventListener("submit",function(event){
        event.preventDefault();

        const name=document.getElementById("name").value.trim();
        const email=document.getElementById("email").value.trim();
        const user=document.getElementById("user").value.trim();
        const pass = document.getElementById("pass").value.trim();
        const confirmPass=document.getElementById("confirmPass").value.trim();

        const nameE = /^[a-zA-Z]{2,}$/;
        const emailL=/^[a-z0-9]+@[a-z0-9]+\.[a-z]{2,4}$/;
        const userR=/^[a-zA-Z0-9]{4,}$/;
        const passS = /^(?=.*[A-Za-z])(?=.*\d).{6,}$/;
      //  const confirmPassS = /^(?=.*[A-Za-z])(?=.*\d).{6,}$/;

        const nameError=document.getElementById("nameError");
        const emailError=document.getElementById("emailError");
        const usernameError=document.getElementById("usernameError");
        const passError=document.getElementById("passError");
        const confirmPassError=document.getElementById("confirmPassError");


        nameError.textContent="";
        emailError.textContent="";
        usernameError.textContent="";
        passError.textContent="";
        confirmPassError.textContent="";

        let valid=true;

        if(!nameE.test(name)){
            nameError.textContent="Name must contain only letters, and have more than 2 letters!";
            valid=false;
        }
        if(!emailL.test(email)){
            emailError.textContent="Enter a valid email (only letters and numbers, e.g. user@domain.com)";
            valid=false;
        }

        if(!userR.test(user)){
            usernameError.textContent="Username must contain only letters and numbers, and be 4–15 characters long!";
            valid=false;
        }

        if(!passS.test(pass)){
            passError.textContent="Password must contain at least 6 characters, including at least one letter and one number!";
            valid=false;
        }
        if(pass !== confirmPass){
    confirmPassError.textContent = "Passwords do not match!";
    valid = false;
}

        if(valid){
            createForm.submit();
        }});

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

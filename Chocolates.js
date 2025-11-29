const mainChocolate = document.getElementById('mainChocolate');
const chocName = document.getElementById('chocName');
const chocPrice = document.getElementById('chocPrice');

const thumbnails = document.querySelectorAll('.thumbnails img');

thumbnails.forEach(thumb => {
    thumb.addEventListener('click', () => {
        mainChocolate.src = thumb.src;
        chocName.textContent = thumb.dataset.name;
        chocPrice.textContent = thumb.dataset.price;
    });
});

const hamburger = document.getElementById("hamburger");
const navLinks = document.getElementById("nav-links");
hamburger.addEventListener("click", () => {
    navLinks.classList.toggle("active");
});

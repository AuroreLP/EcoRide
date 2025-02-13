document.addEventListener("DOMContentLoaded", function () {
    let dropdown = document.querySelector(".dropdown");

    dropdown.addEventListener("mouseenter", function () {
        this.querySelector(".dropdown-menu").classList.add("show");
    });

    dropdown.addEventListener("mouseleave", function () {
        this.querySelector(".dropdown-menu").classList.remove("show");
    });
});


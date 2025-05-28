const hamBurger = document.querySelector(".toggle-btn");
const sidebar = document.querySelector("#sidebar");

hamBurger.addEventListener("click", function () {
    sidebar.classList.toggle("expand");
});

window.addEventListener("resize", function() {
    if (window.innerWidth > 1024) {
        sidebar.classList.add("expand");
    } else {
        sidebar.classList.remove("expand");
    }
});

if (window.innerWidth > 1024) {
    sidebar.classList.add("expand");
} else {
    sidebar.classList.remove("expand");
}

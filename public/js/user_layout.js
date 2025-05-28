let sidebar = document.querySelector(".sidebar");
let closeBtn = document.querySelector("#btn");

function closeSidebar() {
    sidebar.classList.remove("open");
    menuBtnChange();
}

function openSidebar() {
    sidebar.classList.add("open");
    menuBtnChange();
}

window.addEventListener('DOMContentLoaded', () => {
    openSidebar();
});

window.addEventListener('DOMContentLoaded', () => {
    if (window.innerWidth > 1024) {
        openSidebar();
    } else {
        closeSidebar();
    }
});

window.addEventListener('resize', () => {
    if (window.innerWidth <= 1024) {
        closeSidebar();
    } else {
        openSidebar();
    }
});

closeBtn.addEventListener("click", () => {
    sidebar.classList.toggle("open");
    menuBtnChange();
});

function menuBtnChange() {
    if (sidebar.classList.contains("open")) {
        closeBtn.classList.replace("bx-menu", "bx-menu-alt-right");
    } else {
        closeBtn.classList.replace("bx-menu-alt-right", "bx-menu");
    }
}

if (window.AOS) {
    AOS.init();
}


const sections = document.querySelectorAll("section[id]");

window.addEventListener("scroll", navHighlighter);

function navHighlighter() {

    let scrollY = window.pageYOffset;

    sections.forEach(current => {
        const sectionHeight = current.offsetHeight;
        const sectionTop = current.offsetTop - 50;
        let sectionId = current.getAttribute("id");
        const menuLink = document.querySelector(".menu-navbar a[href*=" + sectionId + "]");

        if (!menuLink) {
            return;
        }

        if (
            scrollY > sectionTop &&
            scrollY <= sectionTop + sectionHeight
        ) {
            menuLink.classList.add("active-menu");
        } else {
            menuLink.classList.remove("active-menu");
        }
    });
}


if (localStorage.getItem("language-storage") == null) {
    localStorage.setItem('language-storage', 0);
}
let translationSwitcher = function () {
    return {
        selected: localStorage.getItem('language-storage'),
        footer_fh: {
            id: "Fakultas Hukum",
        },
        footer_feb: {
            id: "Fakultas Ekonomi dan Bisnis",
        },
        footer_isip: {
            id: "Fakultas Ilmu Sosial dan Politik",
        },
        footer_fp: {
            id: "Fakultas Pertanian",
        },
        footer_ft: {
            id: "Fakultas Teknik",
        },
        footer_fk: {
            id: "Fakultas Kedokteran",
        },
        nav_unib: {
            id: "Universitas Bengkulu",
        },

        countries: [{
                label: "Indonesia",
                lang: "id",
                flag: "id",
            },

        ],
        menuToggle: false,
    };
};


// When the user scrolls down 80px from the top of the document, resize the navbar's padding and the logo's font size
window.onscroll = function () {
    scrollFunction()
};

function scrollFunction() {
    const navbar = document.getElementById("navbar");
    const listMenu = document.getElementById("list-menu");

    if (!navbar || !listMenu) {
        return;
    }

    if (document.body.scrollTop > 80 || document.documentElement.scrollTop > 80) {
        navbar.style.padding = "10px 25px";
        navbar.classList.add("nav-scroll");
        navbar.classList.add("shadow-lg");
        listMenu.classList.add("list-menu-scroll");
    } else {
        navbar.style.padding = "15px 25px";
        navbar.classList.remove("nav-scroll");
        navbar.classList.remove("shadow-lg");
        listMenu.classList.remove("list-menu-scroll");
    }
}

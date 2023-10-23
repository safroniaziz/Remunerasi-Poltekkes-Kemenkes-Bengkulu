AOS.init();


const sections = document.querySelectorAll("section[id]");

window.addEventListener("scroll", navHighlighter);

function navHighlighter() {

    let scrollY = window.pageYOffset;

    sections.forEach(current => {
        const sectionHeight = current.offsetHeight;
        const sectionTop = current.offsetTop - 50;
        sectionId = current.getAttribute("id");
        if (
            scrollY > sectionTop &&
            scrollY <= sectionTop + sectionHeight
        ) {
            document.querySelector(".menu-navbar a[href*=" + sectionId + "]").classList.add(
                "active-menu");
        } else {
            document.querySelector(".menu-navbar a[href*=" + sectionId + "]").classList.remove(
                "active-menu");
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
    if (document.body.scrollTop > 80 || document.documentElement.scrollTop > 80) {
        document.getElementById("navbar").style.padding = "10px 25px";
        document.getElementById("navbar").classList.add("nav-scroll");
        document.getElementById("navbar").classList.add("shadow-lg");
        document.getElementById("list-menu").classList.add("list-menu-scroll");
    } else {
        document.getElementById("navbar").style.padding = "15px 25px";
        document.getElementById("navbar").classList.remove("nav-scroll");
        document.getElementById("navbar").classList.remove("shadow-lg");
        document.getElementById("list-menu").classList.remove("list-menu-scroll");
    }
}

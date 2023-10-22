AOS.init();


const sections = document.querySelectorAll("section[id]");

window.addEventListener("scroll", navHighlighter);

function navHighlighter() {

    let scrollY = window.pageYOffset;

    sections.forEach(current => {
        const sectionHeight = current.offsetHeight;
        const sectionTop = current.offsetTop - 250;
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
            en: "Faculty of Law",
            id: "Fakultas Hukum",
            de: "Rechtswissenschaftliche Fakultät",
        },
        footer_feb: {
            en: "Faculty of Economics and Business",
            id: "Fakultas Ekonomi dan Bisnis",
            de: "Wirtschaftswissenschaftliche Fakultät",
        },
        footer_isip: {
            en: "Faculty Ilmu Social dan Politics",
            id: "Fakultas Ilmu Sosial dan Politik",
            de: "Fakultät für Sozial- und Politikwissenschaften",
        },
        footer_fp: {
            en: "Faculty of Agriculture",
            id: "Fakultas Pertanian",
            de: "Fakultät der Landwirtschaft",
        },
        footer_ft: {
            en: "Faculty of Engineering",
            id: "Fakultas Teknik",
            de: "Fakultät für Ingenieurwissenschaften",
        },
        footer_fk: {
            en: "Faculty of Medicine",
            id: "Fakultas Kedokteran",
            de: "Medizinische Fakultät",
        },
        nav_unib: {
            en: "University of Bengkulu",
            id: "Universitas Bengkulu",
            de: "Universität Bengkulu",
        },

        countries: [{
                label: "Indonesia",
                lang: "id",
                flag: "id",
            },
            {
                label: "English",
                lang: "en",
                flag: "gb",
            },

            {
                label: "German",
                lang: "de",
                flag: "de",
            },
        ],
        menuToggle: false,
    };
};


// When the user scrolls down 80px from the top of the document, resize the navbar's padding and the logo's font size
window.onscroll = function () {
    scrollFunction();
    navMobileHome();
};

function scrollFunction() {
    if (document.body.scrollTop > 80 || document.documentElement.scrollTop > 80) {
        document.getElementById("navbar").style.padding = "10px 25px";
        document.getElementById("top-bar").classList.add("hidden");
        document.getElementById("navbar").classList.add("nav-scroll");
        document.getElementById("navbar").classList.add("shadow-lg");
        document.getElementById("list-menu").classList.add("list-menu-scroll");
    } else {
        document.getElementById("top-bar").classList.remove("hidden");
        document.getElementById("navbar").style.padding = "15px 25px";
        document.getElementById("navbar").classList.remove("nav-scroll");
        document.getElementById("navbar").classList.remove("shadow-lg");
        document.getElementById("list-menu").classList.remove("list-menu-scroll");
    }
}

var startProductBarPos = -1;
function navMobileHome() {
  var bar = document.getElementById("mobile-nav");
  if (startProductBarPos < 0) startProductBarPos = findPosY(bar);

  if (pageYOffset > startProductBarPos) {
    bar.style.position = "fixed";
    bar.style.paddingTop = "0px";
    bar.style.top = "65px";
  } else {
    bar.style.position = "absolute";
    bar.style.paddingTop = "40px";
  }
};

function findPosY(obj) {
  var curtop = 0;
  if (typeof obj.offsetParent != "undefined" && obj.offsetParent) {
    while (obj.offsetParent) {
      curtop += obj.offsetTop;
      obj = obj.offsetParent;
    }
    curtop += obj.offsetTop;
  } else if (obj.y) curtop += obj.y;
  return curtop;
}

 var cont = 0;
 function loopSlider() {
   var xx = setInterval(function () {
     switch (cont) {
       case 0: {
         $("#slider-1").fadeOut(400);
         $("#slider-2").delay(400).fadeIn(400);
         $("#sButton1").removeClass("bg-purple-800");
         $("#sButton2").addClass("bg-purple-800");
         cont = 1;

         break;
       }
       case 1: {
         $("#slider-2").fadeOut(400);
         $("#slider-1").delay(400).fadeIn(400);
         $("#sButton2").removeClass("bg-purple-800");
         $("#sButton1").addClass("bg-purple-800");

         cont = 0;

         break;
       }
     }
   }, 8000);
 }

 function reinitLoop(time) {
   clearInterval(xx);
   setTimeout(loopSlider(), time);
 }

 function sliderButton1() {
   $("#slider-2").fadeOut(400);
   $("#slider-1").delay(400).fadeIn(400);
   $("#sButton2").removeClass("bg-purple-800");
   $("#sButton1").addClass("bg-purple-800");
   reinitLoop(4000);
   cont = 0;
 }

 function sliderButton2() {
   $("#slider-1").fadeOut(400);
   $("#slider-2").delay(400).fadeIn(400);
   $("#sButton1").removeClass("bg-purple-800");
   $("#sButton2").addClass("bg-purple-800");
   reinitLoop(4000);
   cont = 1;
 }

 $(window).ready(function () {
   $("#slider-2").hide();
   $("#sButton1").addClass("bg-purple-800");

   loopSlider();
 });



var sideBar = document.getElementById("mobile-nav");
var openSidebar = document.getElementById("openSideBar");
var closeSidebar = document.getElementById("closeSideBar");
sideBar.style.transform = "translateX(-260px)";

function sidebarHandler(flag) {
  if (flag) {
    sideBar.style.transform = "translateX(0px)";
    openSidebar.classList.add("hidden");
    closeSidebar.classList.remove("hidden");
  } else {
    sideBar.style.transform = "translateX(-260px)";
    closeSidebar.classList.add("hidden");
    openSidebar.classList.remove("hidden");
  }
}


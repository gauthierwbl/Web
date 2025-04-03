document.addEventListener("DOMContentLoaded", function () {

    /* ---- Gestion du menu de navigation ---- */

    const bouton = document.getElementById("bouton-projets");
    const nav = document.querySelector(".navplus");
    const icons = document.getElementById("icons");

    document.addEventListener("click", (event) => {
        const isClickInsideNav = nav.contains(event.target) || icons.contains(event.target);
        const isClickInsideButton = bouton.contains(event.target);

        if (isClickInsideNav || isClickInsideButton) {
            icons.classList.toggle("active");
            nav.classList.toggle("active");
        } else {
            icons.classList.remove("active");
            nav.classList.remove("active");
        }
    });

    bouton.addEventListener("click", (event) => {
        event.stopPropagation();
        nav.classList.toggle("active");
    });

    const links = document.querySelectorAll(".navplus li");
    links.forEach((link) => {
        link.addEventListener("click", () => {
            nav.classList.remove("active");
            icons.classList.remove("active");
        });
    });


    /* ---- Gestion de l'animation des boutons wishlist ---- */

    const wishlistButtons = document.querySelectorAll(".wishlist");

    wishlistButtons.forEach(button => {
        button.addEventListener("click", function (event) {
            event.stopPropagation(); // Empêche de propager au clic global

            if (!this.classList.contains("like-active")) {
                this.classList.add("anim-like"); // Lance l'animation si le cœur s'allume
                setTimeout(() => {
                    this.classList.remove("anim-like"); // Enlève l'animation après 1s
                }, 1000);
            }

            this.classList.toggle("like-active"); // Active/désactive le cœur
        });
    });

});

document.addEventListener("DOMContentLoaded", function () {
    var wishlistButtons = document.querySelectorAll(".wishlist");

    wishlistButtons.forEach(button => {
        button.addEventListener("click", function () {
            if (!this.classList.contains("like-active")) {
                this.classList.add("anim-like"); // Ajoute l'animation seulement si le cœur s'allume
                setTimeout(() => {
                    this.classList.remove("anim-like"); // Supprime l'animation après 1000ms
                }, 1000);
            }

            this.classList.toggle("like-active"); // Active ou désactive le cœur
        });
    });
});

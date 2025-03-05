function uppercaseName(input) {
    input.value = input.value.toUpperCase();
};
function validatePostalCode(input) {
    const regex = /^\d{5}$/;
    const errorSpan = document.getElementById('codePostalError');

    if (regex.test(input)) {
        errorSpan.style.display = 'none';
    } else {
        errorSpan.style.display = 'block';
    }
};

document.addEventListener('DOMContentLoaded', function () {
    const forms = document.querySelectorAll('.verif');

    forms.forEach(function (form) {
        form.addEventListener('submit', function (event) {
            let champsRemplis = true;
            const inputs = form.querySelectorAll('input, select, textarea');

            inputs.forEach(function (input) {
                if (input.value.trim() === '') {
                    champsRemplis = false;
                    return;
                }
            });

            if (!champsRemplis) {
                event.preventDefault();
                alert('Veuillez remplir tous les champs.');
            }
        });
    });
});


document.addEventListener("DOMContentLoaded", function () {
    // Toggle Nav and Icons
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
        });
    });

    // Like System
    const handleWishlistClick = (button) => {
        var offreId = button.id.split('_')[1];
        if (button.classList.contains("like-active")) {
            // Unliking an offer
            fetch("/rmWishlist/" + offreId, { method: "POST" })
                .then(response => {
                    if (response.status === 200) {
                        button.classList.remove("like-active");
                    }
                });
        } else {
            // Liking an offer
            fetch("/addWishlist/" + offreId, { method: "POST" })
                .then(response => {
                    if (response.status === 200) {
                        button.classList.add("like-active");
                        button.offsetWidth; // Trigger a reflow to restart the animation
                        button.classList.add("anim-like");
                        setTimeout(() => button.classList.remove("anim-like"), 500);
                    }
                });
        }
    };

    var wishlistButtons = document.querySelectorAll(".wishlist");
    wishlistButtons.forEach(button => {
        button.addEventListener("click", function () {
            handleWishlistClick(this);
        });
    });


});

document.addEventListener("DOMContentLoaded", function () {

    // Fonction pour créer les champs lors du chargement de la page
    window.onload = function () {
        var nbrAdresse = document.getElementById('nbrAdresse').value;
        var html = '';

        for (var i = 1; i <= nbrAdresse; i++) {
            html += "<div class='form-group'>";
            html += "<label for='adresse" + i + "'>Adresse " + i + " :</label>";
            html += "<input type='text' name='adresse" + i + "' id='adresse" + i + "'><br>";
            html += "</div>";

            html += "<div class='form-group'>";
            html += "<label for='zipCode" + i + "'>Code Postal " + i + " :</label>";
            html += "<input type='text' class='form-control' name='zipCode" + i + "' id='zipCode" + i + "' placeholder='' value='' oninput='validatePostalCode(this.value)'>";
            html += "<span id='codePostalError' style='color: red; display: none;'>Le code postal doit contenir 5 chiffres</span>"
            html += "</div>";

            html += "<div class='form-group'>";
            html += "<label for='city" + i + "'>Ville " + i + " :</label>";
            html += "<select class='form-control' name='city" + i + "' id='city" + i + "'><option value='option1'></option></select>";
            html += "</div>";
        }

        document.getElementById('adresses').innerHTML = html; // Afficher les champs générés

        var case_CP = document.getElementById('zipCode1');
        var selectVille = document.getElementById('city1');
        console.log(case_CP);

        case_CP.addEventListener('input', function () {
            console.log("test");
            var cp = case_CP.value;
            if (cp.length === 5) {
                fetch('https://apicarto.ign.fr/api/codes-postaux/communes/' + cp)
                    .then(response => {
                        if (response.status === 200) {
                            selectVille.classList.add('active');
                            response.json().then(data => {
                                selectVille.innerHTML = '';
                                data.forEach(item => {
                                    var option = document.createElement('option');
                                    option.value = item.nomCommune;
                                    option.textContent = item.nomCommune;
                                    selectVille.appendChild(option);
                                });
                            });
                        }
                    })
                    .catch(error => console.log('Error fetching city data:', error));
            } else {
                console.log('Code postal incorrect');
            }
        });
    };

    // Écouter les changements du nombre d'adresses
    document.getElementById('nbrAdresse').addEventListener('change', function () {
        if (nbrAdresse !== 1) {
            var nbrAdresse = this.value;
            var html = '';

            for (var i = 1; i <= nbrAdresse; i++) {
                html += "<div class='form-group'>";
                html += "<label for='adresse" + i + "'>Adresse " + i + " :</label>";
                html += "<input type='text' name='adresse" + i + "' id='adresse" + i + "'><br>";
                html += "</div>";

                html += "<div class='form-group'>";
                html += "<label for='zipCode" + i + "'>Code Postal " + i + " :</label>";
                html += "<input type='text' class='form-control' name='zipCode" + i + "' id='zipCode" + i + "' placeholder='' value='' oninput='validatePostalCode(this.value)'>";
                html += "<span id='codePostalError' style='color: red; display: none;'>Le code postal doit contenir 5 chiffres</span>"
                html += "</div>";

                html += "<div class='form-group'>";
                html += "<label for='city" + i + "'>Ville " + i + " :</label>";
                html += "<select class='form-control' name='city" + i + "' id='city" + i + "'><option value='option1'></option></select>";
                html += "</div>";
            }

            document.getElementById('adresses').innerHTML = html; // Afficher les champs générés
            // API CARTO
            var adresseElements = document.getElementById('nbrAdresse').value;

            for (var i = 1; i <= adresseElements; i++) {
                console.log(i);
                (function (index) {
                    var case_CP = document.getElementById('zipCode' + index);
                    var selectVille = document.getElementById('city' + index);

                    case_CP.addEventListener('input', function () {
                        var cp = case_CP.value;
                        if (cp.length === 5) {
                            fetch('https://apicarto.ign.fr/api/codes-postaux/communes/' + cp)
                                .then(response => {
                                    if (response.status === 200) {
                                        selectVille.classList.add('active');
                                        response.json().then(data => {
                                            selectVille.innerHTML = '';
                                            data.forEach(item => {
                                                var option = document.createElement('option');
                                                option.value = item.nomCommune;
                                                option.textContent = item.nomCommune;
                                                selectVille.appendChild(option);
                                            });
                                        });
                                    }
                                })
                                .catch(error => console.log('Error fetching city data:', error));
                        } else {
                            console.log('Code postal incorrect');
                        }
                    });
                })(i);
            };
        } else {
            var case_CP = document.getElementById('zipCode1');
            var selectVille = document.getElementById('city1');

            case_CP.addEventListener('input', function () {
                var cp = case_CP.value;
                if (cp.length === 5) {
                    fetch('https://apicarto.ign.fr/api/codes-postaux/communes/' + cp)
                        .then(response => {
                            if (response.status === 200) {
                                selectVille.classList.add('active');
                                response.json().then(data => {
                                    selectVille.innerHTML = '';
                                    data.forEach(item => {
                                        var option = document.createElement('option');
                                        option.value = item.nomCommune;
                                        option.textContent = item.nomCommune;
                                        selectVille.appendChild(option);
                                    });
                                });
                            }
                        })
                        .catch(error => console.log('Error fetching city data:', error));
                } else {
                    console.log('Code postal incorrect');
                }
            });
        }

    });

    document.querySelector('.loader').style.display = 'block';
});




// A tester 

//Vérification de l'email
function validateEmail(email) {
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailPattern.test(email);
}

document.getElementById('validateButton').addEventListener('click', () => {
    const emailInput = document.getElementById('email').value; // Modification ici
    const errorSpan = document.getElementById('emailError');

    if (validateEmail(emailInput)) {
        errorSpan.style.display = 'none'; // Cacher le message d'erreur
        alert('Adresse e-mail valide !');
    } else {
        errorSpan.style.display = 'inline'; // Afficher le message d'erreur
        errorSpan.textContent = 'Adresse e-mail invalide.';
    }
});

// Vérification du fichier CV
const cvInput = document.getElementById('fileToUpload'); // Modification ici

cvInput.addEventListener("change", function () {
    const allowedFormats = ["pdf", "doc", "docx", "odt", "rtf", "jpg", "png"];
    const file = cvInput.files[0];
    if (file) {
        const fileSizeMB = file.size / 1024 / 1024; // Taille en Mo
        const fileExtension = file.name.split('.').pop().toLowerCase();

        // Vérification du format de fichier
        if (!allowedFormats.includes(fileExtension)) {
            alert("Format de fichier non accepté. Formats autorisés : pdf, doc, docx, odt, rtf, jpg, png.");
            cvInput.value = ""; // Réinitialiser le champ fichier
        }

        // Vérification de la taille du fichier
        if (fileSizeMB > 2) {
            alert("Le fichier est trop volumineux. Taille maximale : 2 Mo.");
            cvInput.value = "";
        }
    }
});

document.addEventListener("DOMContentLoaded", function() {
    const form = document.querySelector('.verif');
    
    form.addEventListener('submit', function(event) {
      let valid = true;
  
      // Récupération des valeurs des champs
      const dureeOffre = document.getElementById('dureeOffre').value;
      const baseOffre = document.getElementById('baseOffre').value;
      const nombreOffre = document.getElementById('nombreOffre').value;
      const dateOffre = document.getElementById('dateOffre').value;
  
      // Vérification de la durée de stage
      if (!isPositiveInteger(dureeOffre)) {
        alert("Veuillez entrer un nombre valide pour la Durée de stage.");
        valid = false;
      }
  
      // Vérification de la base de rémunération
      if (!isPositiveNumber(baseOffre)) {
        alert("Veuillez entrer un nombre valide pour la Base de rémunération.");
        valid = false;
      }
  
      // Vérification du nombre de places disponibles
      if (!isPositiveInteger(nombreOffre)) {
        alert("Veuillez entrer un nombre valide pour le Nombre de places disponibles.");
        valid = false;
      }
  
      // Vérification du format de la date
      if (!isValidDate(dateOffre)) {
        alert("Veuillez entrer une date valide au format YYYY-MM-DD pour la Date de l'offre.");
        valid = false;
      }
  
      // Si une des validations échoue, empêcher l'envoi du formulaire
      if (!valid) {
        event.preventDefault();
      }
    });
  
    function isPositiveInteger(value) {
      return /^\d+$/.test(value);
    }
  
    function isPositiveNumber(value) {
      return /^\d+(\.\d+)?$/.test(value);
    }
  
    function isValidDate(dateString) {
      const regex = /^\d{4}-\d{2}-\d{2}$/;
      if (!dateString.match(regex)) return false; // Vérifie le format YYYY-MM-DD
  
      const date = new Date(dateString);
      return date instanceof Date && !isNaN(date);
    }
  });
  
 

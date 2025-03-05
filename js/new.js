document.addEventListener("DOMContentLoaded", function() {
    const form = document.querySelector('.verif');
  
    form.addEventListener('submit', function(event) {
      let valid = true;
  
      // Récupération des valeurs des champs
      const zipCode1 = document.getElementById('zipCode1').value;
      const zipCode2 = document.getElementById('zipCode2').value; // Assurez-vous que cet ID est correct
      const dureeOffre = document.getElementById('dureeOffre').value; // Assurez-vous que cet ID est correct
      const baseOffre = document.getElementById('baseOffre').value; // Assurez-vous que cet ID est correct
      const nombreOffre = document.getElementById('nombreOffre').value; // Assurez-vous que cet ID est correct
      const dateOffre = document.getElementById('dateOffre').value; // Assurez-vous que cet ID est correct
  
      // Vérification des codes postaux
      if (!isValidZipCode(zipCode1)) {
        alert("Veuillez entrer un code postal valide pour l'adresse 1 (5 chiffres).");
        valid = false;
      }
  
      if (!isValidZipCode(zipCode2)) {
        alert("Veuillez entrer un code postal valide pour l'adresse 2 (5 chiffres).");
        valid = false;
      }
  
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
  
    function isValidZipCode(value) {
      return /^\d{5}$/.test(value); // Vérifie que le code postal est composé de 5 chiffres
    }
  
    function isPositiveInteger(value) {
      return /^\d+$/.test(value); // Vérifie que la valeur est un entier positif
    }
  
    function isPositiveNumber(value) {
      return /^\d+(\.\d+)?$/.test(value); // Vérifie que la valeur est un nombre positif
    }
  
    function isValidDate(dateString) {
      const regex = /^\d{4}-\d{2}-\d{2}$/; // Vérifie le format YYYY-MM-DD
      if (!dateString.match(regex)) return false;
  
      const date = new Date(dateString);
      return date instanceof Date && !isNaN(date); // Vérifie que la date est valide
    }
  });

  document.addEventListener("DOMContentLoaded", function() {
    const forms = document.querySelectorAll('form.verif'); // Sélectionne tous les formulaires avec la classe 'verif'
  
    forms.forEach(form => {
      form.addEventListener('submit', function(event) {
        let valid = true;
  
        // Vérification des champs de texte
        const textInputs = form.querySelectorAll('input[type="text"], input[type="password"], input[type="number"]');
        textInputs.forEach(input => {
          if (input.value.trim() === '') {
            alert(`Le champ "${input.name || input.id}" ne peut pas être vide.`);
            valid = false;
          }
        });
  
        // Vérification des sélecteurs
        const selects = form.querySelectorAll('select');
        selects.forEach(select => {
          if (select.value === '' || select.value === null) {
            alert(`Veuillez sélectionner une option pour "${select.name || select.id}".`);
            valid = false;
          }
        });
  
        // Vérification des textareas
        const textareas = form.querySelectorAll('textarea');
        textareas.forEach(textarea => {
          if (textarea.value.trim() === '') {
            alert(`Le champ "${textarea.name || textarea.id}" ne peut pas être vide.`);
            valid = false;
          }
        });
  
        // Si une des validations échoue, empêcher l'envoi du formulaire
        if (!valid) {
          event.preventDefault();
        }
      });
    });
  });
  
  
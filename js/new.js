document.addEventListener("DOMContentLoaded", function () {
  const forms = document.querySelectorAll('form.verif');

  forms.forEach(form => {
    form.addEventListener('submit', function (event) {
      let valid = true;

      // Supprimer les anciens messages d'erreur
      form.querySelectorAll('.error-message').forEach(el => el.remove());
      form.querySelectorAll('.error').forEach(el => el.classList.remove('error'));

      // Vérification des codes postaux
      const zipCodes = form.querySelectorAll('[id^="zipCode"]');
      zipCodes.forEach(zipCode => {
        if (!isValidZipCode(zipCode.value)) {
          showError(zipCode, "Le code postal doit contenir exactement 5 chiffres.");
          valid = false;
        }
      });

      // Vérification des champs numériques positifs
      const numericFields = [
        { id: 'dureeOffre', label: 'Durée de stage', validator: isPositiveInteger },
        { id: 'baseOffre', label: 'Base de rémunération', validator: isPositiveNumber },
        { id: 'nombreOffre', label: 'Nombre de places disponibles', validator: isPositiveInteger }
      ];
      numericFields.forEach(field => {
        const input = form.querySelector(`#${field.id}`);
        if (input && !field.validator(input.value)) {
          showError(input, `Veuillez entrer un numéro de ${field.label}.`);
          valid = false;
        }
      });

      // Vérification de la date
      const dateInput = form.querySelector('#dateOffre');
      if (dateInput && !isValidDate(dateInput.value)) {
        showError(dateInput, "Veuillez entrer une date valide au format YYYY-MM-DD.");
        valid = false;
      }

      // Vérification des champs obligatoires (text, password, number)
      const textInputs = form.querySelectorAll('input[type="text"], input[type="password"], input[type="number"]');
      textInputs.forEach(input => {
        if (input.value.trim() === '') {
          showError(input, "Champ obligatoire.");
          valid = false;
        }
      });

      // Vérification des sélecteurs
      const selects = form.querySelectorAll('select');
      selects.forEach(select => {
        if (select.value === '' || select.value === null) {
          showError(select, "Veuillez sélectionner une option.");
          valid = false;
        }
      });

      // Vérification des textareas
      const textareas = form.querySelectorAll('textarea');
      textareas.forEach(textarea => {
        if (textarea.value.trim() === '') {
          showError(textarea, "Champ obligatoire.");
          valid = false;
        }
      });

      // Si une des validations échoue, empêcher l'envoi du formulaire
      if (!valid) {
        event.preventDefault();
      }
    });
  });

  function isValidZipCode(value) {
    return /^[0-9]{5}$/.test(value);
  }

  function isPositiveInteger(value) {
    return /^\d+$/.test(value);
  }

  function isPositiveNumber(value) {
    return /^\d+(\.\d+)?$/.test(value);
  }

  function isValidDate(dateString) {
    const regex = /^\d{4}-\d{2}-\d{2}$/;
    if (!dateString.match(regex)) return false;
    const date = new Date(dateString);
    return date instanceof Date && !isNaN(date);
  }

  function showError(element, message) {
    element.classList.add('error'); // Ajoute une bordure rouge
    let errorMessage = document.createElement('div');
    errorMessage.classList.add('error-message');
    errorMessage.style.color = 'red';
    errorMessage.style.fontSize = '12px';
    errorMessage.textContent = message;
    element.parentNode.insertBefore(errorMessage, element.nextSibling);
  }
});

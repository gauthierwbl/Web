<?php

class ValidationHelper {
    // Vérifie si l'entrée est valide
    public static function isValidInput($input) {
        $pattern = "/^[a-zA-Z0-9\s\p{L}-]+$/u"; // Lettres, chiffres, espaces, accents
        return preg_match($pattern, $input);
    }

    // Nettoie l'entrée pour éviter les failles XSS
    public static function sanitizeInput($input) {
        return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
    }

    // Valide et nettoie en une seule fonction
    public static function validateAndSanitize($input) {
        if (!self::isValidInput($input)) {
            throw new Exception("Erreur : Données invalides détectées.");
        }
        return self::sanitizeInput($input);
    }
}

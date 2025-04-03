<?php

// Déclaration de la classe UserModel qui va gérer les opérations liées aux utilisateurs
class UserModel {
    // Propriété privée pour stocker l'objet PDO (connexion à la base de données)
    private $pdo;

    // Constructeur : il reçoit une instance PDO et l'assigne à la propriété $pdo
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Méthode pour rechercher un utilisateur en fonction de son nom d'utilisateur
    public function findUserByUsername($login) {
        // Prépare une requête SQL pour sélectionner un utilisateur par son username
        $stmt = $this->pdo->prepare('SELECT mot_de_passe, login, id_role FROM utilisateurs WHERE login = :login');
        $stmt->execute(['login' => $login]);

        // Retourne la première ligne trouvée sous forme de tableau associatif
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    // Création d'un nouvel utilisateur avec mot de passe sécurisé
public function createUser($login, $hashedPassword) {
    $stmt = $this->pdo->prepare('INSERT INTO utilisateurs (login, password, date_inscription) VALUES (:login, :password, NOW())');
    return $stmt->execute([
        'login' => $login,
        'password' => $hashedPassword
    ]);
}

}

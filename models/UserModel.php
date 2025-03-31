<?php

class UserModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function findUserByUsername($username) {
        $stmt = $this->pdo->prepare('SELECT * FROM utilisateurs WHERE username = :username');
        $stmt->execute(['username' => $username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function hasAccess($role, $required_role) {
        $roles = ['user' => 1, 'pilote' => 2, 'admin' => 3];
        return $roles[$role] >= $roles[$required_role];
    }
}

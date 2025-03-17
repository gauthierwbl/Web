<?php

class DatabaseConnection implements IDatabaseConnection {
    
    private $connection;
    private $host = 'localhost'; // Adresse de ton serveur DB
    private $dbname = 'nom_de_la_base'; // Nom de ta base de données
    private $username = 'root'; // Utilisateur
    private $password = ''; // Mot de passe

    public function connect() {
        try {
            $this->connection = new PDO(
                "mysql:host={$this->host};dbname={$this->dbname}",
                $this->username,
                $this->password
            );
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection échouée : " . $e->getMessage());
        }
    }

    public function disconnect() {
        $this->connection = null;
    }

    public function getConnection() {
        return $this->connection;
    }
}

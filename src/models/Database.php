<?php 
/*
class Database {
    private static $pdo = null;

    public static function getConnection() {
        if (self::$pdo === null) { // Vérifie si la connexion n'existe pas déjà
            try {
                self::$pdo = new PDO("mysql:host=localhost;dbname=cesi_ton_stage;charset=utf8", "root", "", [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                ]);
            } catch (PDOException $e) {
                die("Erreur de connexion : " . $e->getMessage());
            }
        }
        return self::$pdo;
    }
}

// Test de la connexion avec une requête SQL
$db = Database::getConnection();

// Exécuter une requête simple
$query = $db->query("SELECT * FROM candidater WHERE id_status = 3");

$tables = $query->fetchAll(PDO::FETCH_ASSOC);

var_dump($tables); // Affiche la liste des tables dans la BDD

*/
class Database {
    public static function getConnection() {
        return new PDO("mysql:host=localhost;dbname=cesi; charset=utf8", "root", "", [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    }
}
?>
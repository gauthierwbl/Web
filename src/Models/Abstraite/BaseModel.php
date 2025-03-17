<?php

abstract class BaseModel {

    protected $db;

    public function __construct(IDatabaseConnection $dbConnection) {
        $this->db = $dbConnection;
        $this->db->connect();
    }

    // Méthode pour exécuter une requête simple (ex: SELECT)
    protected function query($sql, $params = []) {
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Méthode pour exécuter une requête d'insertion, mise à jour ou suppression
    protected function execute($sql, $params = []) {
        $stmt = $this->db->getConnection()->prepare($sql);
        return $stmt->execute($params);
    }

    // Méthode abstraite pour obtenir un enregistrement par ID
    abstract public function getById($id);

    // Méthode abstraite pour ajouter un nouvel enregistrement
    abstract public function create($data);

    // Méthode abstraite pour mettre à jour un enregistrement existant
    abstract public function update($id, $data);

    // Méthode abstraite pour supprimer un enregistrement
    abstract public function delete($id);
}

<?php

class EntrepriseModel extends BaseModel {

    public function __construct(IDatabaseConnection $dbConnection) {
        parent::__construct($dbConnection);
    }

    public function getById($id) {
        $sql = "SELECT * FROM entreprises WHERE id = :id";
        return $this->query($sql, ['id' => $id]);
    }

    public function create($data) {
        $sql = "INSERT INTO entreprises (nom, adresse, contact_email) VALUES (:nom, :adresse, :contact_email)";
        return $this->execute($sql, $data);
    }

    public function update($id, $data) {
        $sql = "UPDATE entreprises SET nom = :nom, adresse = :adresse, contact_email = :contact_email WHERE id = :id";
        $data['id'] = $id;
        return $this->execute($sql, $data);
    }

    public function delete($id) {
        $sql = "DELETE FROM entreprises WHERE id = :id";
        return $this->execute($sql, ['id' => $id]);
    }
}

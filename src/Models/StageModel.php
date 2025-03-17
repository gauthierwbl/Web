<?php

class StageModel extends BaseModel {

    public function __construct(IDatabaseConnection $dbConnection) {
        parent::__construct($dbConnection);
    }

    public function getById($id) {
        $sql = "SELECT * FROM stages WHERE id = :id";
        return $this->query($sql, ['id' => $id]);
    }

    public function create($data) {
        $sql = "INSERT INTO stages (titre, description, entreprise_id, date_debut, date_fin) VALUES (:titre, :description, :entreprise_id, :date_debut, :date_fin)";
        return $this->execute($sql, $data);
    }

    public function update($id, $data) {
        $sql = "UPDATE stages SET titre = :titre, description = :description, entreprise_id = :entreprise_id, date_debut = :date_debut, date_fin = :date_fin WHERE id = :id";
        $data['id'] = $id;
        return $this->execute($sql, $data);
    }

    public function delete($id) {
        $sql = "DELETE FROM stages WHERE id = :id";
        return $this->execute($sql, ['id' => $id]);
    }
}

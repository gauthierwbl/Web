<?php

class UserModel extends BaseModel {

    public function __construct(IDatabaseConnection $dbConnection) {
        parent::__construct($dbConnection);
    }

    public function getById($id) {
        $sql = "SELECT * FROM users WHERE id = :id";
        return $this->query($sql, ['id' => $id]);
    }

    public function create($data) {
        $sql = "INSERT INTO users (username, password, email, role) VALUES (:username, :password, :email, :role)";
        return $this->execute($sql, $data);
    }

    public function update($id, $data) {
        $sql = "UPDATE users SET username = :username, password = :password, email = :email, role = :role WHERE id = :id";
        $data['id'] = $id;
        return $this->execute($sql, $data);
    }

    public function delete($id) {
        $sql = "DELETE FROM users WHERE id = :id";
        return $this->execute($sql, ['id' => $id]);
    }
}

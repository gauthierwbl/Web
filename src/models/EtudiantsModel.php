<?php

class EtudiantsModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Compter le nombre total d'étudiants
    public function countEtudiants() {
        $query = "SELECT COUNT(*) FROM utilisateurs WHERE id_role = 3"; // 3 = étudiant
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return (int) $stmt->fetchColumn();
    }

    // Récupérer les étudiants paginés
    public function getEtudiantsPaginated($page, $limit) {
        $offset = ($page - 1) * $limit;
        $query = "
            SELECT u.*, c.nom_campus
            FROM utilisateurs u
            LEFT JOIN campus c ON u.id_campus = c.id_campus
            WHERE u.id_role = 3
            LIMIT :limit OFFSET :offset
        ";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Supprimer un étudiant
    public function delete($id_utilisateur) {
        $stmt = $this->pdo->prepare("DELETE FROM utilisateurs WHERE id_utilisateur = :id");
        $stmt->bindParam(':id', $id_utilisateur, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Récupérer un étudiant par ID
    public function getById($id) {
        $stmt = $this->pdo->prepare("
            SELECT u.*, c.nom_campus
            FROM utilisateurs u
            LEFT JOIN campus c ON u.id_campus = c.id_campus
            WHERE u.id_utilisateur = :id AND u.id_role = 3
        ");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Mettre à jour les infos d'un étudiant
    public function update($id, $email, $telephone, $id_campus) {
        $stmt = $this->pdo->prepare("
            UPDATE utilisateurs 
            SET email = :email, telephone = :telephone, id_campus = :id_campus 
            WHERE id_utilisateur = :id AND id_role = 3
        ");
        return $stmt->execute([
            ':id' => $id,
            ':email' => $email,
            ':telephone' => $telephone,
            ':id_campus' => $id_campus
        ]);
    }

    // Récupérer le mot de passe d'un étudiant (hashé en BDD)
    public function getMotDePasse($id_utilisateur) {
        $stmt = $this->pdo->prepare("
            SELECT mot_de_passe 
            FROM utilisateurs 
            WHERE id_utilisateur = :id AND id_role = 3
        ");
        $stmt->bindParam(':id', $id_utilisateur, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn();
    }
}

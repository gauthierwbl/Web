<?php

class ProfilModel {
    private $db;

    public function __construct($database) {
        $this->db = $database;
    }

    /**
     * Récupère les informations du profil utilisateur
     * @param int $userId ID de l'utilisateur
     * @return array Données du profil
     */
    public function getProfilById($userId) {
        $query = "SELECT login FROM utilisateurs WHERE id_utilisateurs = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère les informations supplémentaires (identité) de l'utilisateur
     * @param int $userId ID de l'utilisateur
     * @return array Les informations supplémentaires (prénom, nom)
     */
    public function getIdentiteByUserId($userId) {
        // Requête avec une jointure entre utilisateurs et identites sur id_identite
        $stmt = $this->db->prepare("
        SELECT i.prenom, i.nom
        FROM identites i
        JOIN utilisateurs u ON u.id_identite = i.id_identite
        WHERE u.id_utilisateurs = :userId");
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAdresseByUserId($userId) {
        $stmt = $this->db->prepare("
        SELECT a.adresse, v.zipcode, v.nom_ville
        FROM utilisateurs u
        JOIN affilier a_f ON u.id_adresse = a_f.id_adresse
        JOIN villes v ON a_f.id_ville = v.id_ville
        JOIN adresses a ON a_f.id_adresse = a.id_adresse
        WHERE u.id_utilisateurs = :userId
    ");

        // On associe les paramètres
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);

        // On exécute la requête
        $stmt->execute();

        // Retourne les données sous forme de tableau associatif
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getCampusInfoByUserId($userId) {
        $stmt = $this->db->prepare("
        SELECT c.nom_campus, p.promotions, m.nom_mineure
        FROM utilisateurs u
        JOIN promotions p ON u.id_promo = p.id_promo
        JOIN campus c ON p.id_campus = c.id_campus
        JOIN mineures m ON p.id_mineure = m.id_mineure
        WHERE u.id_utilisateurs = :userId
    ");
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }



    /**
     * Met à jour les informations du profil
     * @param int $userId ID de l'utilisateur
     * @param array $data Nouvelles données du profil
     * @return bool Succès de la mise à jour
     */
    public function updateProfil($userId, $data) {
        // Construction de la requête de mise à jour
        $query = "UPDATE utilisateurs SET ";
        $params = [];

        foreach ($data as $key => $value) {
            if ($key != 'id') { // Exclure l'ID de la mise à jour
                $query .= "$key = :$key, ";
                $params[":$key"] = $value;
            }
        }

        // Suppression de la virgule finale
        $query = rtrim($query, ", ");
        $query .= " WHERE id = :id";
        $params[':id'] = $userId;

        $stmt = $this->db->prepare($query);
        return $stmt->execute($params);
    }

    /**
     * Met à jour la photo de profil
     * @param int $userId ID de l'utilisateur
     * @param string $photoPath Chemin de la nouvelle photo
     * @return bool Succès de la mise à jour
     */
    public function updateProfilePhoto($userId, $photoPath) {
        $query = "UPDATE utilisateurs SET photo_profil = :photo WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':photo', $photoPath, PDO::PARAM_STR);
        $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
        return $stmt->execute();
    }
}

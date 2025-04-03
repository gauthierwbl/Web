<?php

class ProfilModel {
    private $db;

    public function __construct($database) {
        $this->db = $database;
    }

    // Récupère les informations du profil utilisateur
    public function getProfilById($userId) {
        try {
            $query = "SELECT id_utilisateurs, login FROM utilisateurs WHERE id_utilisateurs = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur dans getProfilById: " . $e->getMessage());
            return false;
        }
    }

    // Récupère les informations supplémentaires (identité) de l'utilisateur
    public function getIdentiteByUserId($userId) {
        try {
            $stmt = $this->db->prepare("
            SELECT i.prenom, i.nom, i.id_identite
            FROM identites i
            JOIN utilisateurs u ON u.id_identite = i.id_identite
            WHERE u.id_utilisateurs = :userId");
            $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return $result ?: [
                'prenom' => 'Non défini',
                'nom' => 'Non défini',
                'id_identite' => null
            ];
        } catch (PDOException $e) {
            error_log("Erreur dans getIdentiteByUserId: " . $e->getMessage());
            return [
                'prenom' => 'Non défini',
                'nom' => 'Non défini',
                'id_identite' => null
            ];
        }
    }

    // Récupère l'adresse de l'utilisateur
    public function getAdresseByUserId($userId) {
        try {
            $stmt = $this->db->prepare("
            SELECT a.adresse, v.zipcode, v.nom_ville, a.id_adresse, v.id_ville
            FROM utilisateurs u
            JOIN affilier a_f ON u.id_adresse = a_f.id_adresse
            JOIN villes v ON a_f.id_ville = v.id_ville
            JOIN adresses a ON a_f.id_adresse = a.id_adresse
            WHERE u.id_utilisateurs = :userId
            ");
            $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return $result ?: [
                'adresse' => 'Non définie',
                'zipcode' => 'Non défini',
                'nom_ville' => 'Non définie',
                'id_adresse' => null,
                'id_ville' => null
            ];
        } catch (PDOException $e) {
            error_log("Erreur dans getAdresseByUserId: " . $e->getMessage());
            return [
                'adresse' => 'Non définie',
                'zipcode' => 'Non défini',
                'nom_ville' => 'Non définie',
                'id_adresse' => null,
                'id_ville' => null
            ];
        }
    }

    // Récupère les informations du campus
    public function getCampusInfoByUserId($userId) {
        try {
            $stmt = $this->db->prepare("
            SELECT c.nom_campus, p.promotions, m.nom_mineure
            FROM utilisateurs u
            LEFT JOIN promotions p ON u.id_promo = p.id_promo
            LEFT JOIN campus c ON p.id_campus = c.id_campus
            LEFT JOIN mineures m ON p.id_mineure = m.id_mineure
            WHERE u.id_utilisateurs = :userId
            ");
            $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return $result ?: [
                'nom_campus' => 'Non défini',
                'promotions' => 'Non définie',
                'nom_mineure' => 'Non définie'
            ];
        } catch (PDOException $e) {
            error_log("Erreur dans getCampusInfoByUserId: " . $e->getMessage());
            return [
                'nom_campus' => 'Non défini',
                'promotions' => 'Non définie',
                'nom_mineure' => 'Non définie'
            ];
        }
    }

    // Récupère le nombre d'offres dans la wishlist de l'utilisateur
    public function getWishlistCount($userId) {
        try {
            $stmt = $this->db->prepare("
            SELECT COUNT(*) as wishlist_count
            FROM ajouter_wishlist
            WHERE id_utilisateurs = :userId
            ");
            $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ? $result['wishlist_count'] : 0;
        } catch (PDOException $e) {
            error_log("Erreur dans getWishlistCount: " . $e->getMessage());
            return 0;
        }
    }

    // Récupère le nombre de stages complétés par l'utilisateur
    public function getCompletedInternshipsCount($userId) {
        try {
            $stmt = $this->db->prepare("
            SELECT COUNT(*) as completed_count
            FROM candidater
            WHERE id_utilisateurs = :userId
            AND id_status = 3
            ");
            $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ? $result['completed_count'] : 0;
        } catch (PDOException $e) {
            error_log("Erreur dans getCompletedInternshipsCount: " . $e->getMessage());
            return 0;
        }
    }

    // Récupère le nombre total de candidatures envoyées par l'utilisateur
    public function getApplicationsCount($userId) {
        try {
            $stmt = $this->db->prepare("
            SELECT COUNT(*) as applications_count
            FROM candidater
            WHERE id_utilisateurs = :userId
            ");
            $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ? $result['applications_count'] : 0;
        } catch (PDOException $e) {
            error_log("Erreur dans getApplicationsCount: " . $e->getMessage());
            return 0;
        }
    }

    // Récupère la photo de profil en vérifiant si le fichier existe dans le dossier images
    public function getProfilePhoto($userId) {
        $photoPath = 'src/Views/img/id' . $userId . 'profil.png';

        // Vérifie si la photo existe dans le dossier
        if (file_exists($photoPath)) {
            return $photoPath;
        }

        // Retourne une photo par défaut si l'image n'existe pas
        return 'src/Views/img/profil.png';
    }

    // Met à jour les informations du profil utilisateur
    public function updateProfil($userId, $data) {
        try {
            $this->db->beginTransaction();

            // Mettre à jour les informations dans la table utilisateurs
            if (isset($data['login'])) {
                $stmt = $this->db->prepare("UPDATE utilisateurs SET login = :login WHERE id_utilisateurs = :id");
                $stmt->bindValue(':login', $data['login'], PDO::PARAM_STR);
                $stmt->bindValue(':id', $userId, PDO::PARAM_INT);
                $stmt->execute();
            }

            // Mettre à jour les informations d'identité
            if (isset($data['prenom']) || isset($data['nom'])) {
                // Récupérer l'ID de l'identité de l'utilisateur
                $identite = $this->getIdentiteByUserId($userId);
                if ($identite && isset($identite['id_identite'])) {
                    $query = "UPDATE identites SET ";
                    $params = [];

                    if (isset($data['prenom'])) {
                        $query .= "prenom = :prenom";
                        $params[':prenom'] = $data['prenom'];
                        if (isset($data['nom'])) {
                            $query .= ", ";
                        }
                    }

                    if (isset($data['nom'])) {
                        $query .= "nom = :nom";
                        $params[':nom'] = $data['nom'];
                    }

                    $query .= " WHERE id_identite = :id_identite";
                    $params[':id_identite'] = $identite['id_identite'];

                    $stmt = $this->db->prepare($query);
                    foreach ($params as $key => $value) {
                        $stmt->bindValue($key, $value);
                    }
                    $stmt->execute();
                }
            }

            // Mettre à jour les informations d'adresse
            if (isset($data['adresse'])) {
                $adresseInfo = $this->getAdresseByUserId($userId);
                if ($adresseInfo && isset($adresseInfo['id_adresse'])) {
                    $stmt = $this->db->prepare("UPDATE adresses SET adresse = :adresse WHERE id_adresse = :id_adresse");
                    $stmt->bindValue(':adresse', $data['adresse'], PDO::PARAM_STR);
                    $stmt->bindValue(':id_adresse', $adresseInfo['id_adresse'], PDO::PARAM_INT);
                    $stmt->execute();
                }
            }

            // Mettre à jour les informations de ville et code postal
            if ((isset($data['ville']) || isset($data['zipcode']))) {
                $adresseInfo = $this->getAdresseByUserId($userId);

                if ($adresseInfo && isset($adresseInfo['id_ville'])) {
                    $query = "UPDATE villes SET ";
                    $params = [];

                    if (isset($data['ville'])) {
                        $query .= "nom_ville = :nom_ville";
                        $params[':nom_ville'] = $data['ville'];
                        if (isset($data['zipcode'])) {
                            $query .= ", ";
                        }
                    }

                    if (isset($data['zipcode'])) {
                        $query .= "zipcode = :zipcode";
                        $params[':zipcode'] = $data['zipcode'];
                    }

                    $query .= " WHERE id_ville = :id_ville";
                    $params[':id_ville'] = $adresseInfo['id_ville'];

                    $stmt = $this->db->prepare($query);
                    foreach ($params as $key => $value) {
                        $stmt->bindValue($key, $value);
                    }
                    $stmt->execute();
                }
            }

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            error_log("Erreur dans updateProfil: " . $e->getMessage());
            return false;
        }
    }

    // Met à jour la photo de profil
    public function updateProfilePhoto($userId, $photoFile) {
        // Le chemin où la photo sera enregistrée
        $targetDir = 'src/Views/img/';

        // Créer le répertoire s'il n'existe pas
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $targetFile = $targetDir . 'id' . $userId . 'profil.png';

        // Vérification et traitement du fichier uploadé
        if (move_uploaded_file($photoFile['tmp_name'], $targetFile)) {
            return true;
        }

        return false; // En cas d'échec du téléchargement
    }
}
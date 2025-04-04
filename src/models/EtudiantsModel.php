<?php

class EtudiantsModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function countEtudiants() {
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM utilisateurs WHERE id_role = 2");
        return (int) $stmt->fetchColumn();
    }

    public function getEtudiantsPaginated($page, $limit) {
        $offset = ($page - 1) * $limit;

        $query = "
            SELECT u.id_utilisateurs, u.login, u.date_inscription,
                   i.nom, i.prenom, a.adresse, v.nom_ville, v.zipcode
            FROM utilisateurs u
            JOIN identites i ON u.id_identite = i.id_identite
            JOIN adresses a ON u.id_adresse = a.id_adresse
            JOIN affilier af ON a.id_adresse = af.id_adresse
            JOIN villes v ON af.id_ville = v.id_ville
            WHERE u.id_role = 2
            ORDER BY u.id_utilisateurs ASC
            LIMIT :limit OFFSET :offset
        ";

        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Rechercher des étudiants dans le dashboard
     */
    public function rechercherEtudiantsDashboard($terme) {
        try {
            $query = "
                SELECT u.id_utilisateurs, u.login, u.date_inscription,
                       i.nom, i.prenom, a.adresse, v.nom_ville, v.zipcode
                FROM utilisateurs u
                JOIN identites i ON u.id_identite = i.id_identite
                JOIN adresses a ON u.id_adresse = a.id_adresse
                JOIN affilier af ON a.id_adresse = af.id_adresse
                JOIN villes v ON af.id_ville = v.id_ville
                WHERE u.id_role = 2
                    AND (i.nom LIKE :terme 
                    OR i.prenom LIKE :terme 
                    OR u.login LIKE :terme)
                ORDER BY u.id_utilisateurs ASC
            ";
            
            $stmt = $this->pdo->prepare($query);
            
            // Définir le paramètre de recherche
            $termeRecherche = "%" . $terme . "%";
            $stmt->bindParam(':terme', $termeRecherche, PDO::PARAM_STR);
            
            // Exécuter la requête
            $stmt->execute();
            
            // Retourner les résultats
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur lors de la recherche d'étudiants dans le dashboard : " . $e->getMessage());
            return [];
        }
    }

    public function getById($id) {
        $stmt = $this->pdo->prepare("
            SELECT u.id_utilisateurs, u.login, i.nom, i.prenom, a.adresse,
                   v.id_ville, v.nom_ville, v.zipcode
            FROM utilisateurs u
            JOIN identites i ON u.id_identite = i.id_identite
            JOIN adresses a ON u.id_adresse = a.id_adresse
            JOIN affilier af ON a.id_adresse = af.id_adresse
            JOIN villes v ON af.id_ville = v.id_ville
            WHERE u.id_utilisateurs = :id
        ");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getVilles() {
        $stmt = $this->pdo->query("SELECT * FROM villes");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($login, $mot_de_passe, $nom, $prenom, $adresse, $id_ville) {
        try {
            // Démarrer une transaction
            $this->pdo->beginTransaction();
            
            // Insérer dans identites
            $stmt = $this->pdo->prepare("INSERT INTO identites (nom, prenom) VALUES (:nom, :prenom)");
            $stmt->execute([':nom' => $nom, ':prenom' => $prenom]);
            $id_identite = $this->pdo->lastInsertId();

            // Insérer dans adresses
            $stmt = $this->pdo->prepare("INSERT INTO adresses (adresse) VALUES (:adresse)");
            $stmt->execute([':adresse' => $adresse]);
            $id_adresse = $this->pdo->lastInsertId();

            // Insérer dans affilier
            $stmt = $this->pdo->prepare("INSERT INTO affilier (id_adresse, id_ville) VALUES (:id_adresse, :id_ville)");
            $stmt->execute([':id_adresse' => $id_adresse, ':id_ville' => $id_ville]);

            // Insérer dans utilisateurs
            $stmt = $this->pdo->prepare("INSERT INTO utilisateurs (login, mot_de_passe, date_inscription, id_adresse, id_identite, id_role)
                                        VALUES (:login, :mot_de_passe, NOW(), :id_adresse, :id_identite, 2)");
            $result = $stmt->execute([
                ':login' => $login,
                ':mot_de_passe' => $mot_de_passe,
                ':id_adresse' => $id_adresse,
                ':id_identite' => $id_identite
            ]);
            
            // Valider la transaction
            $this->pdo->commit();
            return $result;
            
        } catch (PDOException $e) {
            // En cas d'erreur, annuler toutes les modifications
            $this->pdo->rollBack();
            error_log("Erreur lors de la création d'un étudiant : " . $e->getMessage());
            return false;
        }
    }

    public function update($id, $login, $mot_de_passe = null, $nom, $prenom, $adresse, $id_ville) {
        try {
            // Démarrer une transaction
            $this->pdo->beginTransaction();
            
            // Récupérer les IDs associés
            $stmt = $this->pdo->prepare("SELECT id_adresse, id_identite FROM utilisateurs WHERE id_utilisateurs = :id");
            $stmt->execute([':id' => $id]);
            $ids = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$ids) {
                throw new PDOException("Étudiant non trouvé.");
            }

            // Mettre à jour utilisateurs
            if ($mot_de_passe) {
                $stmt = $this->pdo->prepare("UPDATE utilisateurs SET login = :login, mot_de_passe = :mot_de_passe WHERE id_utilisateurs = :id");
                $stmt->execute([':login' => $login, ':mot_de_passe' => $mot_de_passe, ':id' => $id]);
            } else {
                $stmt = $this->pdo->prepare("UPDATE utilisateurs SET login = :login WHERE id_utilisateurs = :id");
                $stmt->execute([':login' => $login, ':id' => $id]);
            }

            // Mettre à jour identites
            $stmt = $this->pdo->prepare("UPDATE identites SET nom = :nom, prenom = :prenom WHERE id_identite = :id_identite");
            $stmt->execute([':nom' => $nom, ':prenom' => $prenom, ':id_identite' => $ids['id_identite']]);

            // Mettre à jour adresses
            $stmt = $this->pdo->prepare("UPDATE adresses SET adresse = :adresse WHERE id_adresse = :id_adresse");
            $stmt->execute([':adresse' => $adresse, ':id_adresse' => $ids['id_adresse']]);

            // Mettre à jour affilier
            $stmt = $this->pdo->prepare("UPDATE affilier SET id_ville = :id_ville WHERE id_adresse = :id_adresse");
            $stmt->execute([':id_ville' => $id_ville, ':id_adresse' => $ids['id_adresse']]);

            // Valider la transaction
            $this->pdo->commit();
            return true;
            
        } catch (PDOException $e) {
            // En cas d'erreur, annuler toutes les modifications
            $this->pdo->rollBack();
            error_log("Erreur lors de la mise à jour d'un étudiant : " . $e->getMessage());
            return false;
        }
    }

    public function delete($id) {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM utilisateurs WHERE id_utilisateurs = :id");
            return $stmt->execute([':id' => $id]);
        } catch (PDOException $e) {
            error_log("Erreur lors de la suppression d'un étudiant : " . $e->getMessage());
            return false;
        }
    }
}
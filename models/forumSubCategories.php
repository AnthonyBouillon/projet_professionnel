<?php

/**
 * Classe forumSubCategories qui permet de créer, afficher, modifier, supprimer une catégories
 * La classe forumSubCategories hérite de la classe database qui contient la connexion à la base de données
 */
class forumSubCategories extends database {

    public $id_user = 0;
    public $id_category = 0;
    public $id_subCategory = 0;
    public $name = '';
    public $description = '';

    /**
     *  Ajout de la méthode parent __construct qui provient de la classe database du model database qui contient la connexion à la base de données
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Méthode qui me permet de créer une sous-catégorie lié à la catégorie
     * l'id de la sous-catégorie est lié à l'utilisateur
     */
    public function createSubCategories() {
        $query = 'INSERT INTO `' . PREFIXE . 'forumSubCategories`(`name`, `description`, `id_cuyn_forumCategories`,id_cuyn_users ) VALUES (:name, :description, :id_cuyn_forumCategories, :id_cuyn_users)';
        $request = $this->db->prepare($query);
        $request->bindValue('name', $this->name, PDO::PARAM_STR);
        $request->bindValue('description', $this->description, PDO::PARAM_STR);
        $request->bindValue('id_cuyn_forumCategories', $this->id_category, PDO::PARAM_INT);
        $request->bindValue('id_cuyn_users', $this->id_user, PDO::PARAM_INT);
        return $request->execute();
    }

    /**
     * Méthode qui me permet de sélectionner les sous-catégories lié au catégorie
     */
    public function readSubCategories() {
        $query = 'SELECT `id`,`name`, `description` FROM `' . PREFIXE . 'forumSubCategories` WHERE id_cuyn_forumCategories=:id_cuyn_forumCategories';
        $request = $this->db->prepare($query);
        $request->bindValue('id_cuyn_forumCategories', $this->id_category, PDO::PARAM_INT);
        $request->execute();
        return $request->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     *  Méthode qui permet de modifier une sous-catégorie lié à son id
     */
    public function updateSubCategories() {
        $query = 'UPDATE `' . PREFIXE . 'forumSubCategories` SET `name` =:name, description=:description WHERE `id`=:id';
        $request = $this->db->prepare($query);
        $request->bindValue(':name', $this->name, PDO::PARAM_STR);
        $request->bindValue(':description', $this->description, PDO::PARAM_STR);
        $request->bindValue(':id', $this->id_subCategory, PDO::PARAM_INT);
        return $request->execute();
    }

    /**
     *  Méthode qui permet de supprimer une sous-catégorie lié à son id
     */
    public function deleteSubCategories() {
        try {
            $this->db->beginTransaction();
            //  Requête qui permet de supprimer la sous-catégorie sélectionné
            $query = 'DELETE FROM `' . PREFIXE . 'forumSubCategories` WHERE id=:id';
            $request = $this->db->prepare($query);
            $request->bindValue(':id', $this->id_subCategory, PDO::PARAM_INT);
            $request->execute();
            //  Requête qui permet de supprimer les topics du forum lié à la sous-catégorie
            $query = 'DELETE FROM `' . PREFIXE . 'forumTopics` WHERE `id_cuyn_forumSubCategories` = :id_cuyn_forumSubCategories';
            $request = $this->db->prepare($query);
            $request->bindValue(':id_cuyn_forumSubCategories', $this->id_subCategory, PDO::PARAM_INT);
            $request->execute();
            //  Requête qui permet de supprimer les posts du forum lié au topic
            $query = 'DELETE FROM `' . PREFIXE . 'forumPosts` WHERE `id_cuyn_forumPosts` = :id_cuyn_forumPosts';
            $request = $this->db->prepare($query);
            $request->bindValue(':id_cuyn_forumPosts', $this->id_subCategory, PDO::PARAM_INT);
            $request->execute();
            // Valide la transaction
            $this->db->commit();
            $reponseDelete = true;
        } catch (Exception $ex) {
            $reponseDelete = false;
            // Annule la transaction et reviens en arrière
            $this->db->rollBack;
            echo "Failed: " . $ex->getMessage();
        }
        // Retourne vrais ou faux
        return $reponseDelete;
    }

    /**
     *  Ajout de la méthode parent __destruct qui provient de la classe database du model database qui contient la fermeture de la base de données
     */
    public function __destruct() {
        parent::__destruct();
    }

}

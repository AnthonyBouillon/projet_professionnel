<?php

/**
 * Classe forumSubCategories qui me permet de créer, afficher, modifier et supprimer des sous-catégories
 */
class forumSubCategories extends database {

    public $id_user = 0;
    public $id_categories = 0;
    public $id_subCategories = 0;
    public $name = '';
    public $description = '';

    /**
     *  Connexion à la base de données
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Méthode qui me permet de créer une sous-catégorie lié à la catégorie
     * l'id de la sous-catégorie est lié à l'utilisateur
     */
    public function createSubCategories() {
        $query = 'INSERT INTO `' . SELF::prefix . 'forumSubCategories`(`name`, `description`, `id_cuyn_forumCategories`,id_cuyn_users ) VALUES (:name, :description, :id_cuyn_forumCategories, :id_cuyn_users)';
        $request = $this->db->prepare($query);
        $request->bindValue('name', $this->name, PDO::PARAM_STR);
        $request->bindValue('description', $this->description, PDO::PARAM_STR);
        $request->bindValue('id_cuyn_forumCategories', $this->id_categories, PDO::PARAM_INT);
        $request->bindValue('id_cuyn_users', $this->id_user, PDO::PARAM_INT);
        return $request->execute();
    }

    /**
     * Méthode qui me permet de sélectionner les catégories
     */
    public function readSubCategories() {
        $query= 'SELECT `id`,`name`, `description` FROM `' . SELF::prefix . 'forumSubCategories` WHERE id_cuyn_forumCategories=:id_cuyn_forumCategories';
        $request = $this->db->prepare($query);
        $request->bindValue('id_cuyn_forumCategories', $this->id_categories, PDO::PARAM_INT);
        $request->execute();
        return $request->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     *  Méthode qui permet de modifier une sous-catégorie
     */
    public function updateSubCategories() {
        $query = 'UPDATE `' . SELF::prefix . 'forumSubCategories` SET `name` =:name, description=:description WHERE `id`=:id';
        $request = $this->db->prepare($query);
        $request->bindValue(':name', $this->name, PDO::PARAM_STR);
        $request->bindValue(':description', $this->description, PDO::PARAM_STR);
        $request->bindValue(':id', $this->id_subCategories, PDO::PARAM_INT);
        return $request->execute();
    }

    /**
     *  Méthode qui permet de supprimer une sous-catégorie lié à son id
     */
    public function deleteSubCategories() {
        $query = 'DELETE FROM `' . SELF::prefix . 'forumSubCategories` WHERE id=:id';
        $request = $this->db->prepare($query);
        $request->bindValue(':id', $this->id_subCategories, PDO::PARAM_INT);
        $result = $request->execute();
        return $result;
    }

    /**
     *  Déconnexion de la base de données
     */
    public function __destruct() {
        parent::__destruct();
    }

}

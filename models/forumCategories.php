<?php

/**
 * Classe forumCategories qui permet de créer, afficher, modifier, supprimer une ou des catégories
 * La classe forumCategories hérite de la classe database qui contient la connexion à la base de données
 */
class forumCategories extends database {

    /**
     * Ajouts des attributs qui servira à stocker les valeurs pour la création, l'affichage, la modification et la suppression d'une catégories
     * L'id de l'utilisateur
     * L'id de la catégorie
     * L'id de la sous catégorie
     * L'id du topic
     * Le nom de la catégorie
     * La description de la catégorie
     */
    public $id_user = 0;
    public $id_category = 0;
    public $id_subCategory = 0;
    public $id_topic = 0;
    public $name = '';
    public $description = '';

    /**
     *  Ajout de la méthode parent __construct qui provient de la classe database du model database qui contient la connexion à la base de données
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     *  Méthode qui me permet d'inserer une catégorie avec comme valeur le nom, la description et l'id de l'utilisateur
     *  C'est une requete préparé pour plus de sécurité
     *  Nous ajoutons comme parammètre sa nature ( chaine de caractère et un integer )
     */
    public function createCategories() {
        $query = 'INSERT INTO `' . PREFIXE . 'forumCategories`(`name`, `description`, id_cuyn_users) VALUES (:name, :description, :id_cuyn_users)';
        $request = $this->db->prepare($query);
        $request->bindValue('name', $this->name, PDO::PARAM_STR);
        $request->bindValue('description', $this->description, PDO::PARAM_STR);
        $request->bindValue('id_cuyn_users', $this->id_user, PDO::PARAM_INT);
        return $request->execute();
    }

    /**
     *  Méthode qui me permet de sélectionner toutes les catégories
     */
    public function readCategories() {
        $query = 'SELECT `id`,`name`, `description` FROM `' . PREFIXE . 'forumCategories`';
        $request = $this->db->prepare($query);
        $request->execute();
        return $request->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     *  Méthode qui me permet de modifier une catégories
     * Je modifie la valeur du nom et de la description de la catégorie lié à son ID
     */
    public function updateCategories() {
        $query = 'UPDATE `' . PREFIXE . 'forumCategories` SET `name` =:name, description=:description WHERE `id`=:id';
        $request = $this->db->prepare($query);
        $request->bindValue(':name', $this->name, PDO::PARAM_STR);
        $request->bindValue(':description', $this->description, PDO::PARAM_STR);
        $request->bindValue(':id', $this->id_category, PDO::PARAM_INT);
        return $request->execute();
    }

    /**
     *  Méthode qui permet de supprimer une catégorie et tous ce qui est lié à la catégorie
     *  En cas d'erreur, on affiche un message d'erreur ainsi que les erreurs en question
     */
    public function deleteCategories() {
        try {
            // On commence la transaction
            $this->db->beginTransaction();

            $query = 'DELETE FROM `' . PREFIXE . 'forumPosts` WHERE id_cuyn_forumTopics=:id_cuyn_forumTopics';
            $request = $this->db->prepare($query);
            $request->bindValue(':id_cuyn_forumTopics', $this->id_topic, PDO::PARAM_INT);
            $request->execute();

            $query = 'DELETE FROM `' . PREFIXE . 'forumTopics` WHERE id_cuyn_forumSubCategories=:id_cuyn_forumSubCategories';
            $request = $this->db->prepare($query);
            $request->bindValue(':id_cuyn_forumSubCategories', $this->id_subCategory, PDO::PARAM_INT);
            $request->execute();

            $query = 'DELETE FROM `' . PREFIXE . 'forumSubCategories` WHERE id_cuyn_forumCategories=:id_cuyn_forumCategories';
            $request = $this->db->prepare($query);
            $request->bindValue(':id_cuyn_forumCategories', $this->id_category, PDO::PARAM_INT);
            $request->execute();

            $query = 'DELETE FROM `' . PREFIXE . 'forumCategories` WHERE id=:id';
            $request = $this->db->prepare($query);
            $request->bindValue(':id', $this->id_category, PDO::PARAM_INT);
            $request->execute();

            // Valide la transaction
            $this->db->commit();
            $reponseDelete = true;
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
            $reponseDelete = false;
        }
        // Retourne vrai vrai si les requêtes on fonctionné et faux si les requête on échoué
        return $reponseDelete;
    }

    /**
     *  Ajout de la méthode parent __destruct qui provient de la classe database du model database qui contient la fermeture de la base de données
     */
    public function __destruct() {
        parent::__destruct();
    }

}

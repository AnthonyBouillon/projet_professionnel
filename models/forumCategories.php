<?php


/**
 * Classe forumCategories qui permet de créer et afficher des catégories
 */
class forumCategories extends database {

    // Ajouts des attributs qui servira à stocker les valeurs pour la création, l'affichage, la modification et la suppression d'une catégories
    public $id_users = 0;
    public $id_categories = 0;
    public $name = '';
    public $description = '';

    /**
     * __construct de la classe database contenant la connexion de la base de données
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
        $request->bindValue('id_cuyn_users', $this->id_users, PDO::PARAM_INT);
        return $request->execute();
    }

    /**
     *  Méthode qui me permet de sélectionner les catégories
     */
    public function readCategories() {
        $query = 'SELECT `id`,`name`, `description` FROM `' . PREFIXE . 'forumCategories`';
        $request = $this->db->query($query);
        return $request->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     *  Méthode qui permet de modifier une catégories
     */
    public function updateCategories() {
        $query = 'UPDATE `' . PREFIXE . 'forumCategories` SET `name` =:name, description=:description WHERE `id`=:id';
        $request = $this->db->prepare($query);
        $request->bindValue(':name', $this->name, PDO::PARAM_STR);
        $request->bindValue(':description', $this->description, PDO::PARAM_STR);
        $request->bindValue(':id', $this->id_categories, PDO::PARAM_INT);
        return $request->execute();
    }

    /**
     *  Méthode qui permet de supprimer une catégorie et la sous-catégorie lié à la catégorie
     */
    public function deleteCategories() {
        try {
            $query = 'DELETE FROM `' . PREFIXE . 'forumSubCategories` WHERE id_cuyn_forumCategories=:id_cuyn_forumCategories';
            $request = $this->db->prepare($query);
            $request->bindValue(':id_cuyn_forumCategories', $this->id_categories, PDO::PARAM_INT);
            $request->execute();
            
            $query = 'DELETE FROM `' . PREFIXE . 'forumCategories` WHERE id=:id';
            $request = $this->db->prepare($query);
            $request->bindValue(':id', $this->id_categories, PDO::PARAM_INT);
            $request->execute();
            return $request;
        } catch (Exception $e) { //en cas d'erreur
            //on affiche un message d'erreur ainsi que les erreurs
            die('Erreur : ' . $e->getMessage());
        }
    }

    /**
     * __destruct de la classe database contenant la déconnexion de la base de données
     */
    public function __destruct() {
        parent::__destruct();
    }

}

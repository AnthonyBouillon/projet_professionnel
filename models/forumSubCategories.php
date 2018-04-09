<?php

/**
 * Classe forumSubCategories qui permet de créer, afficher, modifier, supprimer une catégories
 * La classe forumSubCategories hérite de tout le contenu de la classe database
 */
class forumSubCategories extends database {

    /**
     *  Attributs : 
     *  ID de l'utilisateur
     *  ID de la catégorie
     *  ID de la sous-catégorie
     *  NOM et DESCRIPTION de la sous-catégorie
     */
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
     *  La méthode me permet d'insérer dans la table des sous-catégorie : le nom, la description, l'id de la catégorie et l'id de l'utilisateur
     *  les sous-catégorie sont lié au catégorie et à l'utilisateur
     *  On utilise la méthode prepare afin d'éviter les injections SQL
     *  On utilise la méthode bindValue qui nous permet d'associer nos marqueurs nominatif à des variables qui contiennent des données de type différents
     *  On utilise les constantes de classe (ex : PDO::PARAM_STR) qui représente le type de données qui sera inséré
     * @return type booléen
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
     *  La méthode me permet de sélectionner l'id, le nom et la description qui sont lié à la catégorie
     *  c'est pour cette raison qu'il me faut l'id de la catégorie, pour qu'il me retourne les résultats, suivant dans quel catégorie on ce trouve.
     * @return type array
     */
    public function readSubCategories() {
        $query = 'SELECT `id`,`name`, `description` FROM `' . PREFIXE . 'forumSubCategories` WHERE id_cuyn_forumCategories=:id_cuyn_forumCategories';
        $request = $this->db->prepare($query);
        $request->bindValue('id_cuyn_forumCategories', $this->id_category, PDO::PARAM_INT);
        $request->execute();
        return $request->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     *  La méthode me permet de modifier : le nom et la description des sous-catégories 
     *  j'ai besoin de l'id de la sous-catégorie afin de savoir laquelle sera modifié
     * @return type booléen
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
     *  La méthode me permet de supprimer une sous-catégorie ainsi que tout ce qui est lié à celui-ci, comme le topic et la réponse au topic
     *  On commence par essayer de démarrer une transaction, si une requête me retourne false, dans ce cas, toutes les requêtes sont annulés
     *  Si toutes les requêtes retourne vrais, on valide la transaction et les requêtes sont exécutés
     * @return type booléen
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

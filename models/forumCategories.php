<?php

/**
 * Classe forumCategories qui permet de créer, afficher, modifier, supprimer une ou des catégories
 * La classe forumCategories hérite de la classe database qui contient la connexion à la base de données
 */
class forumCategories extends database {

    /**
     *  Attributs : 
     *  L'id de l'utilisateur
     *  L'id de la catégorie
     *  L'id de la sous catégorie
     *  L'id du topic
     *  Le nom de la catégorie
     *  La description de la catégorie
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
     *  La méthode me permet d'insérer dans la table "forumCategorie : le nom, la description et l'id de l'utilisateur
     *  La catégorie est lié à l'utilisateur
     *  On utilise la méthode prepare afin d'éviter les injections SQL
     *  On utilise la méthode bindValue qui nous permet d'associer nos marqueurs nominatif à des variables qui contiennent des données de type différents
     *  On utilise les constantes de classe (ex : PDO::PARAM_STR) qui représente le type de données qui sera inséré
     * @return type booléen
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
     *  La méthode me permet de sélectionner toutes les informations de la table forumCategories
     * @return type array
     */
    public function readCategories() {
        $query = 'SELECT `id`,`name`, `description` FROM `' . PREFIXE . 'forumCategories`';
        $request = $this->db->prepare($query);
        $request->execute();
        return $request->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     *  La méthode me permet de modifier le nom et la description d'une catégorie
     *  Je précise donc l'id de la catégorie
     * @return type booléen
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
     *  La méthode me permet de supprimer une catégorie ainsi que tout ce qui est lié à celui-ci, comme la sous-catégorie, le topic et la réponse au topic
     *  On commence par essayer de démarrer une transaction, si une requête me retourne false, dans ce cas, toutes les requêtes sont annulés
     *  Si toutes les requêtes retourne vrais, on valide la transaction et les requêtes sont exécutés
     * @return type booléen
     */
    public function deleteCategories() {
        try {
            // On commence la transaction
            $this->db->beginTransaction();
            // Supprime les réponses du sujet lié au topic
            $query = 'DELETE FROM `' . PREFIXE . 'forumPosts` WHERE id_cuyn_forumTopics=:id_cuyn_forumTopics';
            $request = $this->db->prepare($query);
            $request->bindValue(':id_cuyn_forumTopics', $this->id_topic, PDO::PARAM_INT);
            $request->execute();
            // Supprime les topics lié à la sous-catégorie
            $query = 'DELETE FROM `' . PREFIXE . 'forumTopics` WHERE id_cuyn_forumSubCategories=:id_cuyn_forumSubCategories';
            $request = $this->db->prepare($query);
            $request->bindValue(':id_cuyn_forumSubCategories', $this->id_subCategory, PDO::PARAM_INT);
            $request->execute();
            // Supprime les sous-catégories lié à la catégorie
            $query = 'DELETE FROM `' . PREFIXE . 'forumSubCategories` WHERE id_cuyn_forumCategories=:id_cuyn_forumCategories';
            $request = $this->db->prepare($query);
            $request->bindValue(':id_cuyn_forumCategories', $this->id_category, PDO::PARAM_INT);
            $request->execute();
            // Supprime les catégories 
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
        // Retourne vrai si les requêtes on fonctionnés et faux si les requêtes on échoués
        return $reponseDelete;
    }

    /**
     *  Ajout de la méthode parent __destruct qui provient de la classe database du model database qui contient la fermeture de la base de données
     */
    public function __destruct() {
        parent::__destruct();
    }

}

<?php

/**
 * Classe forumTopics qui permet de créer, afficher, modifier, supprimer une ou des topics
 * La classe forumTopics hérite de la classe database qui contient la connexion à la base de données
 */
class forumTopics extends database {

    /**
     * Ajouts des attributs qui servira à stocker les valeurs pour la création, l'affichage, la modification et la suppression d'un topics
     * L'id de la sous catégorie
     * L'id du topics
     * L'id de l'utilisateur
     * Le nom du topic
     */
    public $id_topic = 0;
    public $id_subCategory = 0;
    public $id_user = 0;
    public $name = '';

    /**
     *  Ajout de la méthode parent __construct qui provient de la classe database du model database qui contient la connexion à la base de données
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Méthode qui me permet d'inserer une un topic qui sera lié à la sous-catégorie et à l'utilisateur
     */
    public function createTopics() {
        $request = $this->db->prepare('INSERT INTO `cuyn_forumTopics`(`subject`, `id_cuyn_forumSubCategories`,id_cuyn_users ) VALUES (:subject, :id_cuyn_forumSubCategories, :id_cuyn_users)');
        $request->bindValue(':subject', $this->name, PDO::PARAM_STR);
        $request->bindValue(':id_cuyn_forumSubCategories', $this->id_subCategory, PDO::PARAM_INT);
        $request->bindValue(':id_cuyn_users', $this->id, PDO::PARAM_INT);
        return $request->execute();
    }

    /**
     *  Méthode qui me permet de sélectionner les topics lié à la sous-catégorie
     */
    public function readTopics() {
        $request = $this->db->prepare('SELECT `id`,`name` FROM `cuyn_forumTopics` WHERE id_cuyn_forumSubCategories=:id_cuyn_forumSubCategories');
        $request->bindValue(':id_cuyn_forumSubCategories', $this->id_subCategory, PDO::PARAM_INT);
        $request->execute();
        return $request->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * Méthode qui me permet de modifier un topic
     */
    public function updateTopics() {
        
    }

    /**
     *  Méthode qui me permet de supprimer un topic
     */
    public function deleteTopics() {
        
    }

    /**
     *  Ajout de la méthode parent __destruct qui provient de la classe database du model database qui contient la fermeture de la base de données
     */
    public function __destruct() {
        parent::__destruct();
    }

}

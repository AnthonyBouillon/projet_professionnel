<?php

/**
 * Classe forumTopics qui permet de créer, afficher, modifier, supprimer une ou des topics
 * La classe forumTopics hérite de tout le contenu de la classe database
 */
class forumTopics extends database {

    /**
     *  Attributs : 
     *  L'id du topic
     *  L'id de la sous catégorie
     *  L'id de l'utilisateur
     *  Le nom du topic
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
     *  La méthode me permet d'insérer dans la table forumTopics : le nom, l'id de la sous-catégorie et l'id de l'utilisateur
     *  Le topic est lié à la sous-catégorie et à l'utilisateur
     *  On utilise la méthode prepare afin d'éviter les injections SQL
     *  On utilise la méthode bindValue qui nous permet d'associer nos marqueurs nominatif à des variables qui contiennent des données de type différents
     *  On utilise les constantes de classe (ex : PDO::PARAM_STR) qui représente le type de données qui sera inséré
     * @return type booléen
     */
    public function createTopics() {
        $query = 'INSERT INTO `' . PREFIXE . 'forumTopics`(`name`, `id_cuyn_forumSubCategories`,id_cuyn_users ) VALUES (:name, :id_cuyn_forumCategories, :id_cuyn_users)';
        $request = $this->db->prepare($query);
        $request->bindValue('name', $this->name, PDO::PARAM_STR);
        $request->bindValue('id_cuyn_forumCategories', $this->id_subCategory, PDO::PARAM_INT);
        $request->bindValue('id_cuyn_users', $this->id_user, PDO::PARAM_INT);
        return $request->execute();
    }

    /**
     *  La méthode me permet de sélectionner : l'id et le nom du topic de la sous-catégorie
     *  C'est pour cette raison que l'id de la sous-catégorie met utile afin de retourner les lignes désirés
     * @return type array
     */
    public function readTopics() {
        $request = $this->db->prepare('SELECT `id`,`name` FROM `cuyn_forumTopics` WHERE id_cuyn_forumSubCategories=:id_cuyn_forumSubCategories');
        $request->bindValue(':id_cuyn_forumSubCategories', $this->id_subCategory, PDO::PARAM_INT);
        $request->execute();
        return $request->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     *  La méthode me permet de sélectionner le nom du topic
     *  Je me sert de cette requête afin d'afficher le nom du topic dans la partie réponse du forum
     */
    public function readNameByTopic() {
        $query = 'SELECT `name` FROM `' . PREFIXE . 'forumTopics` WHERE id=:id_cuyn_forumTopics';
        $request = $this->db->prepare($query);
        $request->bindValue('id_cuyn_forumTopics', $this->id_topic, PDO::PARAM_INT);
        $request->execute();
        return $request->fetch(PDO::FETCH_OBJ);
    }

    public function updateTopics() {
        
    }

    public function deleteTopics() {
        
    }

    /**
     *  Ajout de la méthode parent __destruct qui provient de la classe database du model database qui contient la fermeture de la base de données
     */
    public function __destruct() {
        parent::__destruct();
    }

}

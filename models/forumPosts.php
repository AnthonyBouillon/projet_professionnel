<?php

/**
 * Classe forumPosts qui permet de créer, afficher, modifier et supprimer des posts d'un topics
 * La classe formPosts hérite de tout le contenu de la classe database
 */
class forumPosts extends database {

    /**
     *  Attributs :
     *  L'id du posts
     *  L'id du topic
     *  L'id de l'utilisateur
     *  Le contenu du post
     */
    public $id_post = 0;
    public $id_topic = 0;
    public $id_user = 0;
    public $message = '';

    /**
     *  Ajout de la méthode parent __construct qui provient de la classe database du model database qui contient la connexion à la base de données
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     *  La méthode me permet d'insérer le message, l'id du topic et l'id de l'utilisateur
     *  Le message est lié au topic et à l'utilisateur
     *  On utilise la méthode prepare afin d'éviter les injections SQL
     *  On utilise la méthode bindValue qui nous permet d'associer nos marqueurs nominatif à des variables qui contiennent des données de type différents
     *  On utilise les constantes de classe (ex : PDO::PARAM_STR) qui représente le type de données qui sera inséré
     * @return type booléen
     */
    public function createPosts() {
        $query = 'INSERT INTO `' . PREFIXE . 'forumPosts`(`message`, `id_cuyn_forumTopics`,id_cuyn_users ) VALUES (:message, :id_cuyn_forumTopics, :id_cuyn_users)';
        $request = $this->db->prepare($query);
        $request->bindValue('message', $this->message, PDO::PARAM_STR);
        $request->bindValue('id_cuyn_forumTopics', $this->id_topic, PDO::PARAM_INT);
        $request->bindValue('id_cuyn_users', $this->id_user, PDO::PARAM_INT);
        return $request->execute();
    }

    /**
     *  La méthode me permet de sélectionner toutes les informations dont j'ai besoin :
     *  Table forumPosts : id, message, date au format français
     *  Table users : pseudo, image et la date d'inscription
     *  Table admin : les droits
     *  On par de la table forumPost est on join la table users, la clé étrangère est égale à l'id de l'utilisateur
     *  Ensuite on join la table admin en précisant que l'id de la table admin est égale à la clé étrangère de la table users
     *  Toutes ces informations sont lié au topic
     * @return type array
     */
    public function readPosts() {
        $query = 
                'SELECT `' . PREFIXE . 'forumPosts`.`id`,`' . PREFIXE . 'forumPosts`.`message`, DATE_FORMAT(`' . PREFIXE . 'forumPosts`.`createDate`, \' %d/%m/%Y à %Hh%i \') AS datePost, `' . PREFIXE . 'users`.`username`, `' . PREFIXE . 'users`.`avatar`, DATE_FORMAT(`' . PREFIXE . 'users`.`createDate`,  \' %d/%m/%Y à %Hh%i \') AS dateUsers, `' . PREFIXE . 'admin`.`rights`'
                . ' FROM `' . PREFIXE . 'forumPosts` '
                . 'INNER JOIN `' . PREFIXE . 'users` ON `' . PREFIXE . 'forumPosts`.`id_cuyn_users` = `' . PREFIXE . 'users`.`id` '
                . 'INNER JOIN `' . PREFIXE . 'admin` ON `' . PREFIXE . 'admin`.`id` = `' . PREFIXE . 'users`.`id_cuyn_admin`'
                . '  WHERE id_cuyn_forumTopics=:id_cuyn_forumTopics';
        $request = $this->db->prepare($query);
        $request->bindValue('id_cuyn_forumTopics', $this->id_topic, PDO::PARAM_INT);
        $request->execute();
        return $request->fetchAll(PDO::FETCH_OBJ);
    }

    public function updatePosts() {
        
    }

    public function deletePosts() {
        
    }

    /**
     *  Ajout de la méthode parent __destruct qui provient de la classe database du model database qui contient la fermeture de la base de données
     */
    public function __destruct() {
        parent::__destruct();
    }

}

<?php

/**
 * Classe forumPosts qui permet de créer, afficher, modifier et supprimer des posts d'un topics
 * Elle hérite de la classe database qui contient la connexion à la base de données
 */
class forumPosts extends database {

    /**
     * Ajout des attributs
     * L'id de l'utilisateur
     * L'id du topic
     * le contenu du post
     * l'id du post
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
     *  Méthode qui permet d'insérer un post lié à l'utilisateur qui est lié à au topic
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
     *  Méthode qui permet de récupèrer les posts liés aux topics et au l'utilisateurs
     */
    public function readPosts() {
        $query = 'SELECT `' . PREFIXE . 'forumPosts`.`id`,`' . PREFIXE . 'forumPosts`.`message`, DATE_FORMAT(`' . PREFIXE . 'forumPosts`.`createDate`, \' %d/%m/%Y à %Hh%i \') AS datePost, `' . PREFIXE . 'users`.`username`, `' . PREFIXE . 'users`.`avatar`, DATE_FORMAT(`' . PREFIXE . 'users`.`createDate`,  \' %d/%m/%Y à %Hh%i \') AS dateUsers, `' . PREFIXE . 'admin`.`rights`'
                . ' FROM `' . PREFIXE . 'forumPosts` '
                . 'INNER JOIN `' . PREFIXE . 'users` ON `' . PREFIXE . 'forumPosts`.`id_cuyn_users` = `' . PREFIXE . 'users`.`id` '
                . 'INNER JOIN `' . PREFIXE . 'admin` ON `' . PREFIXE . 'admin`.`id` = `' . PREFIXE . 'users`.`id_cuyn_admin`'
                . '  WHERE id_cuyn_forumTopics=:id_cuyn_forumTopics';
        $request = $this->db->prepare($query);
        $request->bindValue('id_cuyn_forumTopics', $this->id_topic, PDO::PARAM_INT);
        $request->execute();
        return $request->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     *  Méthode qui permet de récupèrer les posts liés aux topics et au l'utilisateurs
     */
    public function readName() {
        $query = 'SELECT  `' . PREFIXE . 'forumTopics`.`name` FROM `' . PREFIXE . 'forumTopics` WHERE id=:id_cuyn_forumTopics';
        $request = $this->db->prepare($query);
        $request->bindValue('id_cuyn_forumTopics', $this->id_topic, PDO::PARAM_INT);
        $request->execute();
        return $request->fetch(PDO::FETCH_OBJ);
    }

    /**
     *  Méthode qui permet de modifier un post appartenant à l'utilisateur qui est lié à au topic
     */
    public function updatePosts() {
        
    }

    /**
     *  Méthode qui permet de supprimer un post choisi grâce à son id et qui est lié à l'utilisateur
     */
    public function deletePosts() {
        
    }

    /**
     *  Ajout de la méthode parent __destruct qui provient de la classe database du model database qui contient la fermeture de la base de données
     */
    public function __destruct() {
        parent::__destruct();
    }

}

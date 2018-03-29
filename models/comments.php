<?php

/**
 * Classe comments qui permet de créer, afficher, modifier et supprimer des commentaires
 * Elle hérite de la classe database qui contient la connexion à la base de données
 */
class comments extends database {

    /**
     * Ajout des attributs
     * L'id de l'utilisateur
     * L'id de l'article
     * le contenue du commentaire
     * l'id du commentaire
     */
    public $id_user = 0;
    public $id_new = 0;
    public $id_comment = 0;
    public $comments = '';

    /**
     *  Ajout de la méthode parent __construct qui provient de la classe database du model database qui contient la connexion à la base de données
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     *  Méthode qui permet d'insérer un commentaire lié à l'utilisateur qui est lié à l'article
     */
    public function createComments() {
        $query = 'INSERT INTO `' . PREFIXE . 'comments`(`comment`, `id_cuyn_users`, `id_cuyn_news`) VALUES (:comment, :id_cuyn_users, :id_cuyn_news)';
        $request = $this->db->prepare($query);
        $request->bindValue(':comment', $this->comments, PDO::PARAM_STR);
        $request->bindValue(':id_cuyn_users', $this->id_user, PDO::PARAM_INT);
        $request->bindValue(':id_cuyn_news', $this->id_new, PDO::PARAM_INT);
        return $request->execute();
    }

    /**
     *  Méthode qui permet de récupèrer les commentaires liés aux articles et au l'utilisateurs
     *  Sélection : l'id du commentaire, le contenu du commentaire, l'id de l'utilisateur, l'id de l'article, l'image de profil, la date au format français et le pseudo des l'utilisateurs
     *  La table des commentaires et des utilisateurs sont join
     *  INNER JOIN : Afin de récupérer les commentaires lié à l'utilisateur correspondant
     *  Ces informations sont récupérer suivant l'id de l'article
     */
    public function readComments() {
        $query = 'SELECT `' . PREFIXE . 'comments`.`id`, ' . '`' . PREFIXE . 'comments`.`comment`, `' . PREFIXE . 'comments`.`id_cuyn_users`, `' . PREFIXE . 'comments`.`id_cuyn_news`, `' . PREFIXE . 'users`.`avatar`, DATE_FORMAT(`' . PREFIXE . 'comments`.`createDate`, \' %d/%m/%Y à %Hh%i \') AS `date`, `' . PREFIXE . 'users`.`username` '
                . 'FROM `' . PREFIXE . 'comments` '
                . 'INNER JOIN `' . PREFIXE . 'users` ON `' . PREFIXE . 'comments`.`id_cuyn_users` = `' . PREFIXE . 'users`.`id` '
                . 'WHERE `' . PREFIXE . 'comments`.`id_cuyn_news`=:id_cuyn_news ORDER BY id DESC';
        $request = $this->db->prepare($query);
        $request->bindValue(':id_cuyn_news', $this->id_new, PDO::PARAM_INT);
        $request->execute();
        return $request->fetchAll(PDO::FETCH_OBJ);
    }
    
    /**
     * Méthode qui me permet de compter le nombre de commentaires lié à l'article
     */
    public function countComments() {
        $query = 'SELECT COUNT(*) AS nbComments FROM `' . PREFIXE . 'comments` WHERE id_cuyn_news =:id_cuyn_news';
        $request = $this->db->prepare($query);
        $request->bindValue(':id_cuyn_news', $this->id_new, PDO::PARAM_INT);
        $request->execute();
        return $request->fetch(PDO::FETCH_OBJ)->nbComments;
    }

    /**
     *  Méthode qui permet de modifier un commentaire appartenant à l'utilisateur qui est lié à l'article
     */
    public function updateComments() {
        $query = 'UPDATE `' . PREFIXE . 'comments` SET `comment`=:comment WHERE `id`=:id AND id_cuyn_users=:id_cuyn_users';
        $request = $this->db->prepare($query);
        $request->bindValue(':id', $this->id_comment, PDO::PARAM_INT);
        $request->bindValue(':id_cuyn_users', $this->id_user, PDO::PARAM_INT);
        $request->bindValue(':comment', $this->comment, PDO::PARAM_STR);
        return $request->execute();
    }

    /**
     *  Méthode qui permet de supprimer un commentaire choisi grâce à son id et qui est lié à l'utilisateur
     */
    public function deleteComments() {
        $query = 'DELETE FROM `' . PREFIXE . 'comments` WHERE `id`=:id AND id_cuyn_users=:id_cuyn_users';
        $request = $this->db->prepare($query);
        $request->bindValue(':id', $this->id_comment, PDO::PARAM_INT);
        $request->bindValue(':id_cuyn_users', $this->id_user, PDO::PARAM_INT);
        return $request->execute();
    }

    /**
     *  Ajout de la méthode parent __destruct qui provient de la classe database du model database qui contient la fermeture de la base de données
     */
    public function __destruct() {
        parent::__destruct();
    }

}

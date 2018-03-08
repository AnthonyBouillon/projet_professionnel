<?php
/**
 * Classe comments qui permet de créer, afficher, modifier et supprimer un commentaire
 */
class comments extends database {

    // Ajouts des attributs
    public $id_user = 0;
    public $id_new = 0;
    public $comments = '';
    public $id_comment = '';

    /**
     *  Connexion à la base de données
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     *  Méthode qui permet d'inserer un commentaire lié à l'utilisateur et à l'article
     */
    public function createComments() {
        $query = 'INSERT INTO `' . SELF::prefix . 'comments`(`comment`, `id_cuyn_users`, `id_cuyn_news`) VALUES (:comment, :id_cuyn_users, :id_cuyn_news)';
        $request = $this->db->prepare($query);
        $request->bindValue(':comment', $this->comments, PDO::PARAM_STR);
        $request->bindValue(':id_cuyn_users', $this->id_user, PDO::PARAM_INT);
        $request->bindValue(':id_cuyn_news', $this->id_new, PDO::PARAM_INT);
        return $request->execute();
    }

    /**
     *  Méthode qui permet de récupèrer les commentaires liés aux articles et à l'utilisateur
     *  Date format française
     */
    public function readComments() {
        $query = 'SELECT `' . SELF::prefix . 'comments`.`id`, `' . SELF::prefix . 'comments`.`comment`, `' . SELF::prefix . 'comments`.`id_cuyn_users`, `' . SELF::prefix . 'comments`.`id_cuyn_news`, DATE_FORMAT(`' . SELF::prefix . 'comments`.`createDate`, \' %d/%m/%Y à %Hh%i \') AS `date`, `' . SELF::prefix . 'users`.`username` FROM `' . SELF::prefix . 'comments` LEFT JOIN `' . SELF::prefix . 'users` ON `' . SELF::prefix . 'comments`.`id_cuyn_users` = `' . SELF::prefix . 'users`.`id` WHERE `' . SELF::prefix . 'comments`.`id_cuyn_news`=:id_cuyn_news ORDER BY id DESC';
        $request = $this->db->prepare($query);
        $request->bindValue(':id_cuyn_news', $this->id_new, PDO::PARAM_INT);
        $request->execute();
        return $request->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     *  Méthode qui permet de modifier un commentaire appartenant à l'utilisateur qui est lié à l'article
     */
    public function updateComments() {
        $query = 'UPDATE `' . SELF::prefix . 'comments` SET `comment`=:comment WHERE `id`=:id AND id_cuyn_users=:id_cuyn_users';
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
        $query = 'DELETE FROM `' . SELF::prefix . 'comments` WHERE `id`=:id AND id_cuyn_users=:id_cuyn_users';
        $request = $this->db->prepare($query);
        $request->bindValue(':id', $this->id_comment, PDO::PARAM_INT);
        $request->bindValue(':id_cuyn_users', $this->id_user, PDO::PARAM_INT);
        return $request->execute();
    }

    /**
     *  Déconnexion de la base de données
     */
    public function __destruct() {
        parent::__destruct();
    }

}

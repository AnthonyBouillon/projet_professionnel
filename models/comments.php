<?php

class comments extends database {

    // Ajouts des attributs
    public $sessionID = '';
    public $getID = '';
    public $comments = '';
    public $commentUpdate = '';
    public $idComment = '';

    // Méthode qui permet d'inserer des commentaires qui est lié à l'id de l'utilisateur et de l'article
    public function createComment() {
        $request = $this->db->prepare('INSERT INTO `' . SELF::prefix . 'comments`(`comment`, `id_cuyn_users`, `id_cuyn_news`) VALUES (:comment, :id_cuyn_users, :id_cuyn_news)');
        $request->bindValue(':comment', $this->comments, PDO::PARAM_STR);
        $request->bindValue(':id_cuyn_users', $this->sessionID, PDO::PARAM_INT);
        $request->bindValue(':id_cuyn_news', $this->getID, PDO::PARAM_INT);
        return $request->execute();
    }

    // Méthode qui permet de sélectionner les commentaires de l'article suivant son id
    public function readComments() {
        $request = $this->db->prepare('SELECT `' . SELF::prefix . 'comments`.`id`, `' . SELF::prefix . 'comments`.`comment`, `' . SELF::prefix . 'comments`.`id_cuyn_users`, `' . SELF::prefix . 'comments`.`id_cuyn_news`, DATE_FORMAT(`' . SELF::prefix . 'comments`.`createDate`, \' %d/%m/%Y à %Hh%i \') AS `date`, `' . SELF::prefix . 'users`.`username` FROM `' . SELF::prefix . 'comments` LEFT JOIN `' . SELF::prefix . 'users` ON `' . SELF::prefix . 'comments`.`id_cuyn_users` = `' . SELF::prefix . 'users`.`id` WHERE `' . SELF::prefix . 'comments`.`id_cuyn_news`=:id_cuyn_news ORDER BY id DESC');
        $request->bindValue(':id_cuyn_news', $_GET['id'], PDO::PARAM_INT);
        $request->execute();
        return $request->fetchAll(PDO::FETCH_OBJ);
    }

    // Méthode qui permet de modifier les commentaires suivant si le commentaire lui appartient
    public function updateComments() {
        $request = $this->db->prepare('UPDATE `' . SELF::prefix . 'comments` SET `comment`=:comment WHERE `id`=:id AND id_cuyn_users=:id_cuyn_users');
        $request->bindValue(':id', $this->idComment, PDO::PARAM_INT);
        $request->bindValue(':id_cuyn_users', $_SESSION['id'], PDO::PARAM_INT);
        $request->bindValue(':comment', $this->commentUpdate, PDO::PARAM_STR);
        return $request->execute();
    }

    // Méthode qui permet de supprimer les commentaires si le commentaire lui appartient
    public function deleteComments() {
        $request = $this->db->prepare('DELETE FROM `' . SELF::prefix . 'comments` WHERE `id`=:id AND id_cuyn_users=:id_cuyn_users');
        $request->bindValue(':id', $this->idComment, PDO::PARAM_INT);
        $request->bindValue(':id_cuyn_users', $_SESSION['id'], PDO::PARAM_INT);
        return $request->execute();
    }

}

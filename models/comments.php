<?php

class comments extends database {

    // Ajouts des attributs
    public $sessionID = '';
    public $getID = '';
    public $comments = '';
    public $commentUpdate = '';
    public $idComment = '';

    // Méthode qui permet d'inserer des commentaires qui est lié à l'id de l'utilisateur et de l'article
    public function InsertComment() {
        $request = $this->db->prepare('INSERT INTO `' . SELF::prefix . 'comments`(`comment`, `id_cuyn_users`, `id_cuyn_news`) VALUES (:comment, :id_cuyn_users, :id_cuyn_news)');
        $request->bindValue(':comment', $this->comments, PDO::PARAM_STR);
        $request->bindValue(':id_cuyn_users', $this->sessionID, PDO::PARAM_INT);
        $request->bindValue(':id_cuyn_news', $this->getID, PDO::PARAM_INT);
        return $request->execute();
    }

    // Méthode qui permet de sélectionner les commentaires de l'article suivant son id
    public function getComments() {
        $request = $this->db->prepare('SELECT `cuyn_comments`.`id`, `cuyn_comments`.`comment`, `cuyn_comments`.`idUser`, `cuyn_comments`.`idArticle`, DATE_FORMAT(`cuyn_comments`.`date`, \' %d/%m/%Y à %Hh%i \') AS `date`, `cuyn_members`.`username` FROM `cuyn_comments` LEFT JOIN `cuyn_members` ON `cuyn_comments`.`idUser` = `cuyn_members`.`id` WHERE `cuyn_comments`.`idArticle`=:idArticle ORDER BY id DESC');
        $request->bindValue(':idArticle', $_GET['id'], PDO::PARAM_INT);
        $request->execute();
        return $request->fetchAll(PDO::FETCH_OBJ);
    }

    // Méthode qui permet de modifier les commentaires suivant si le commentaire lui appartient
    public function updateComments() {
        $request = $this->db->prepare('UPDATE `cuyn_comments` SET `comment`=:comment WHERE `id`=:id AND idUser=:idUser');
        $request->bindValue(':id', $this->idComment, PDO::PARAM_INT);
        $request->bindValue(':idUser', $_SESSION['id'], PDO::PARAM_INT);
        $request->bindValue(':comment', $this->commentUpdate, PDO::PARAM_STR);
        return $request->execute();
    }

    // Méthode qui permet de supprimer les commentaires si le commentaire lui appartient
    public function deleteComments() {
        $request = $this->db->prepare('DELETE FROM `cuyn_comments` WHERE `id`=:id AND idUser=:idUser');
        $request->bindValue(':id', $this->idComment, PDO::PARAM_INT);
        $request->bindValue(':idUser', $_SESSION['id'], PDO::PARAM_INT);
        return $request->execute();
    }

}

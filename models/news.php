<?php

class news extends database {

    // Ajout des attributs
    public $id = 0;
    public $title = '';
    public $plateform = '';
    public $resume = '';
    public $content = '';
    public $picture = '';
    // Attributs pour la pagination
    public $firstEntry = '';
    public $limitArticles = '';
    // Attribut pour la barre de recherche
    public $search = "";

    // Ajout de la connexion à la base de donnée qui provient de son parent
    public function __construct() {
        parent::__construct();
    }

    // Méthode qui permet d'enregistrer dans la base de donnée un nouvelle article
    public function addNews() {
        $request = $this->db->prepare('INSERT INTO `' . SELF::prefix . 'news`(`title`, `plateform`, `resume`,`content`, `picture`, id_cuyn_users) VALUES(:title, :plateform, :resume, :content, :picture, :id_cuyn_users)');
        $request->bindValue(':title', $this->title, PDO::PARAM_STR);
        $request->bindValue(':plateform', $this->plateform, PDO::PARAM_STR);
        $request->bindValue(':resume', $this->resume, PDO::PARAM_STR);
        $request->bindValue(':content', $this->content, PDO::PARAM_STR);
        $request->bindValue(':picture', $this->picture, PDO::PARAM_STR);
        $request->bindValue(':id_cuyn_users', $this->id, PDO::PARAM_STR);
        return $request->execute();
    }

    // Méthode qui permet d'enregistrer dans la base de donnée un nouvelle article
    public function deleteNews() {
        $request = $this->db->prepare('DELETE FROM `' . SELF::prefix . 'news` WHERE id=:id');
        $request->bindValue(':id', $this->id, PDO::PARAM_INT);
        return $request->execute();
    }

    // Méthode qui permet de récuperé l'id d'un article afin de l'afficher
    public function getArticleById() {
        $request = $this->db->prepare('SELECT `title`, `plateform`, `picture`, `content`, `picture`, DATE_FORMAT(`createdate`, \' %d/%m/%Y \') AS date FROM `' . SELF::prefix . 'news` WHERE id=:id');
        $request->bindValue(':id', $this->id, PDO::PARAM_INT);
        $request->execute();
        return $request->fetchAll(PDO::FETCH_OBJ);
    }

    // Méthode qui me permet de compter le nombre d'article
    public function countArticles() {
        $request = $this->db->prepare('SELECT COUNT(`id`) AS `numbersArticles` FROM `' . SELF::prefix . 'news`');
        $request->execute();
        return $request->fetch(PDO::FETCH_OBJ);
    }

    // Méthode qui me permet d'afficher tous les articles et de faire une pagination
    public function checkArticle() {
        $request = $this->db->prepare('SELECT `id`, `title`, `plateform`, `picture`, `resume`, DATE_FORMAT(`createDate`, \' %d/%m/%Y \') AS date  FROM `' . SELF::prefix . 'news` WHERE `title`LIKE :word OR `plateform` LIKE :word  ORDER BY `id` DESC LIMIT ' . $this->firstEntry . ', ' . $this->limitArticles . '');
        $request->bindValue(':word', '%' . $this->search . '%', PDO::PARAM_STR);
        $request->execute();
        return $request->fetchAll(PDO::FETCH_OBJ);
    }

    // Fermeture de la connexion à la base de donnée qui provient de son parent
    public function __destruct() {
        parent::__destruct();
    }

}

<?php

/**
 * Classe news qui me permet de créer, de compter le nombre d'article, d'afficher tout les articles ou juste l'article selectionner, de modifier et de supprimer des articles et commentaire lié à l'article
 */
class news extends database {

    // Ajout des attributs
    public $id_user = 0;
    public $id_new = 0;
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

    /**
     *  Connexion à la base de données
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     *  Méthode qui permet d'enregistrer un article qui est lié à l'utilisateur
     */
    public function createNews() {
        $query = 'INSERT INTO `' . SELF::prefix . 'news`(`title`, `plateform`, `resume`,`content`, `picture`, id_cuyn_users) VALUES(:title, :plateform, :resume, :content, :picture, :id_cuyn_users)';
        $request = $this->db->prepare($query);
        $request->bindValue(':title', $this->title, PDO::PARAM_STR);
        $request->bindValue(':plateform', $this->plateform, PDO::PARAM_STR);
        $request->bindValue(':resume', $this->resume, PDO::PARAM_STR);
        $request->bindValue(':content', $this->content, PDO::PARAM_STR);
        $request->bindValue(':picture', $this->picture, PDO::PARAM_STR);
        $request->bindValue(':id_cuyn_users', $this->id_user, PDO::PARAM_INT);
        return $request->execute();
    }

    /**
     *  Méthode qui me permet de compter le nombre d'id dans la table qui contient les articles
     */
    public function countNews() {
        $query = 'SELECT COUNT(`id`) AS `numbersArticles` FROM `' . SELF::prefix . 'news`';
        $request = $this->db->prepare($query);
        $request->execute();
        return $request->fetch(PDO::FETCH_OBJ);
    }

    /**
     *  Méthode qui permet d'afficher tous les articles
     *  Puis de recupérer seulement ce que l'utilisateur à rechercher
     *  Et de limité l'affichage à trois par page
     *  Date au format français
     */
    public function readNews() {
        $query = 'SELECT `id`, `title`, `plateform`, `picture`, `resume`, DATE_FORMAT(`createDate`, \' %d/%m/%Y \') AS date  FROM `' . SELF::prefix . 'news` WHERE `title`LIKE :word OR `plateform` LIKE :word  ORDER BY `id` DESC LIMIT ' . $this->firstEntry . ', ' . $this->limitArticles . '';
        $request = $this->db->prepare($query);
        $request->bindValue(':word', '%' . $this->search . '%', PDO::PARAM_STR);
        $request->execute();
        return $request->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     *  Méthode qui permet de récupérer l'id de l'article selectionnée
     *  Date au format français
     */
    public function readNewsById() {
        $query = 'SELECT `title`, `plateform`, `picture`, `content`, `picture`, DATE_FORMAT(`createdate`, \' %d/%m/%Y \') AS date FROM `' . SELF::prefix . 'news` WHERE id=:id';
        $request = $this->db->prepare($query);
        $request->bindValue(':id', $this->id_new, PDO::PARAM_INT);
        $request->execute();
        return $request->fetchAll(PDO::FETCH_OBJ);
    }

    public function updateNews() {
        
    }

    /**
     *  Méthode qui permet de supprimer un article où se trouve son id
     */
    public function deleteNews() {
        $query = 'DELETE FROM `' . SELF::prefix . 'comments` WHERE id_cuyn_news=:id_cuyn_news';
        $request = $this->db->prepare($query);
        $request->bindValue(':id_cuyn_news', $this->id_new, PDO::PARAM_INT);
        $request->execute();
        $query = 'DELETE FROM `' . SELF::prefix . 'news` WHERE id=:id';
        $request = $this->db->prepare($query);
        $request->bindValue(':id', $this->id_new, PDO::PARAM_INT);
        return $request->execute();
    }

    /**
     *  Déconnexion de la base de données
     */
    public function __destruct() {
        parent::__destruct();
    }

}

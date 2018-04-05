<?php

/**
 * Classe news qui me permet de créer, de compter le nombre d'article, d'afficher tout les articles ou juste l'article selectionner, de modifier et de supprimer des articles et commentaire lié à l'article
 * La classe news hérite de la classe database qui contient la connexion à la base de données
 */
class news extends database {

    /**
     * Ajout des attributs
     * l'id de l'utilisateur
     * l'id de l'article
     * le titre de l'article
     * la plateforme de l'article
     * le resumé de l'article
     * le contenu de l'article
     * l'image de l'article
     */
    public $id_user = 0;
    public $id_new = 0;
    public $title = '';
    public $plateform = '';
    public $resume = '';
    public $content = '';
    public $picture = '';

    /**
     * Ajout des attributs pour la pagination
     * La limite d'article par page
     */
    public $firstEntry = '';
    public $limitArticles = '';

    /**
     *  Ajout de la méthode parent __construct qui provient de la classe database du model database qui contient la connexion à la base de données
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     *  Méthode qui permet d'enregistrer un article qui est lié à l'utilisateur
     *  Sélection de tous les éléments
     */
    public function createNews() {
        $query = 'INSERT INTO `' . PREFIXE . 'news`(`title`, `plateform`, `resume`,`content`, `picture`, id_cuyn_users) VALUES(:title, :plateform, :resume, :content, :picture, :id_cuyn_users)';
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
     *  Méthode qui me permet de compter le nombre d'article dans la table news
     * La méthode me retourne directement le nombre total de ligne contenu dans la table news
     */
    public function countNews() {
        $query = 'SELECT COUNT(`id`) AS `numbersArticles` FROM `' . PREFIXE . 'news`';
        $request = $this->db->prepare($query);
        $request->execute();
        return $request->fetch(PDO::FETCH_OBJ)->numbersArticles;
    }

/**
 *  Méthode qui permet d'afficher tous les articles
 *  Table join  : news avec users
 *  INNER JOIN : car tous les commentaires sont obligatoirement relié à un utilisateur
 *  La limite d'article est définit par un LIMIT
 *  Date au format français
 */
public function readNews() {
$query = 'SELECT `' . PREFIXE . 'news`.`id`, `' . PREFIXE . 'news`.`title`, `' . PREFIXE . 'news`.`plateform`, `' . PREFIXE . 'news`.`picture`, `' . PREFIXE . 'news`.`resume`, DATE_FORMAT(`' . PREFIXE . 'news`.`createDate`, \' %d/%m/%Y \') AS date, `' . PREFIXE . 'users`.`username`  FROM `' . PREFIXE . 'news` INNER JOIN `' . PREFIXE . 'users` ON `' . PREFIXE . 'news`.`id_cuyn_users` = `' . PREFIXE . 'users`.`id`  ORDER BY `id` DESC LIMIT ' . $this->firstEntry . ', ' . $this->limitArticles . '';
$request = $this->db->prepare($query);
$request->execute();
return $request->fetchAll(PDO::FETCH_OBJ);
}

/**
 *  Méthode qui permet d'afficher l'article selectionnée par son id
 *  Date au format français
 */
public function readNewsById() {
$query = 'SELECT `title`, `plateform`, `picture`, `content`, `picture`, DATE_FORMAT(`createdate`, \' %d/%m/%Y \') AS date FROM `' . PREFIXE . 'news` WHERE id=:id';
$request = $this->db->prepare($query);
$request->bindValue(':id', $this->id_new, PDO::PARAM_INT);
$request->execute();
return $request->fetchAll(PDO::FETCH_OBJ);
}

/**
 * Méthode qui permet de modifier le titre d'un article lié à l'article
 */
public function updateTitle() {
$query = 'UPDATE `' . PREFIXE . 'news` SET `title`=:title  WHERE id = :id_news';
$request = $this->db->prepare($query);
$request->bindValue(':id_news', $this->id_new, PDO::PARAM_INT);
$request->bindValue(':title', $this->title, PDO::PARAM_STR);
return $request->execute();
}

/**
 * Méthode qui permet de modifier le nom de la plateforme d'un article lié à l'id de l'article
 */
public function updatePlateform() {
$query = 'UPDATE `' . PREFIXE . 'news` SET `plateform`=:plateform WHERE id = :id_news';
$request = $this->db->prepare($query);
$request->bindValue(':id_news', $this->id_new, PDO::PARAM_INT);
$request->bindValue(':plateform', $this->plateform, PDO::PARAM_STR);
return $request->execute();
}

/**
 * Méthode qui permet de modifier le résumer d'un article lié à l'id de l'article
 */
public function updateResume() {
$query = 'UPDATE `' . PREFIXE . 'news` SET `resume`=:resume WHERE id = :id_news';
$request = $this->db->prepare($query);
$request->bindValue(':id_news', $this->id_new, PDO::PARAM_INT);
$request->bindValue(':resume', $this->resume, PDO::PARAM_STR);

return $request->execute();
}

/**
 * Méthode qui permet de modifier le contenu d'un article lié à l'id de l'article
 */
public function updateContent() {
$query = 'UPDATE `' . PREFIXE . 'news` SET `content`=:content WHERE id = :id_news';
$request = $this->db->prepare($query);
$request->bindValue(':id_news', $this->id_new, PDO::PARAM_INT);
$request->bindValue(':content', $this->content, PDO::PARAM_STR);
return $request->execute();
}

/**
 * Méthode qui permet de modifier l'image d'un article lié à l'id de l'article
 */
public function updatePicture() {
$query = 'UPDATE `' . PREFIXE . 'news` SET `picture`=:picture WHERE id = :id_news';
$request = $this->db->prepare($query);
$request->bindValue(':id_news', $this->id_new, PDO::PARAM_INT);
$request->bindValue(':picture', $this->picture, PDO::PARAM_STR);
return $request->execute();
}

/**
 *  Méthode qui permet de supprimer les commentaires lié à l'article et de supprimer l'article en question
 */
public function deleteNews() {
try {
    $this->db->beginTransaction();
    $query = 'DELETE FROM `' . PREFIXE . 'comments` WHERE id_cuyn_news=:id_cuyn_news';
    $request = $this->db->prepare($query);
    $request->bindValue(':id_cuyn_news', $this->id_new, PDO::PARAM_INT);
    $request->execute();
    $query = 'DELETE FROM `' . PREFIXE . 'news` WHERE id=:id';
    $request = $this->db->prepare($query);
    $request->bindValue(':id', $this->id_new, PDO::PARAM_INT);
    $request->execute();
    // Valide la transaction
    $this->db->commit();
    $reponseDelete = true;
} catch (Exception $ex) {
    $reponseDelete = false;
    // Annule la transaction
    $this->db->rollBack;
    echo "Failed: " . $ex->getMessage();
}
return $reponseDelete;
}

/**
 *  Ajout de la méthode parent __destruct qui provient de la classe database du model database qui contient la fermeture de la base de données
 */
public function __destruct() {
parent::__destruct();
}

}

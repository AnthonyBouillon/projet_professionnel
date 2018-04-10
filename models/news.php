<?php

/**
 * Classe news qui me permet de créer, de compter le nombre d'article, d'afficher tout les articles ou juste l'article selectionner, de modifier et de supprimer des articles et commentaire lié à l'article
 * La classe news hérite de tout le contenu de la classe database
 */
class news extends database {

    /**
     *  Attributs
     *  l'id de l'utilisateur
     *  l'id de l'article
     *  le titre de l'article
     *  la plateforme de l'article
     *  le résumé de l'article
     *  le contenu de l'article
     *  l'image de l'article
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
     *  La méthode me permet d'insérer le titre, la plateforme, le résumé, le contenu, le nom de l'image et l'id de l'utilisateur
     *  chaque article est lié à l'utilisateur
     *  On utilise la méthode prepare afin d'éviter les injections SQL
     *  On utilise la méthode bindValue qui nous permet d'associer nos marqueurs nominatif à des variables qui contiennent des données de type différents
     *  On utilise les constantes de classe (ex : PDO::PARAM_STR) qui représente le type de données qui sera inséré
     * @return type booléen
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
     *  La méthode me permet de compter le nombre d'id dans la table "news"
     *  Afin de connaitre le nombre d'article contenu dans la table
     */
    public function countNews() {
        $query = 'SELECT COUNT(`id`) AS `numbersArticles` FROM `' . PREFIXE . 'news`';
        $request = $this->db->prepare($query);
        if ($request->execute()) {
            return $request->fetch(PDO::FETCH_OBJ)->numbersArticles;
        }
    }

    /**
     *  La méthode me permet de sélectionner tous les champs dans la table "news" et le pseudo de la table "users"
     *  La date est formaté grâce à la fonction DATE_FORMAT au format français
     *  La table users et news sont join grâce à la méthode INNER JOIN car les données des deux tables correspondent obligatoirement
     *  Ils sont  jointe avec la clé étrangère de la table news qui correspond à l'id de la table users
     *  Les articles sont trié du plus récent au plus ancien.
     *  Et la limite d'affichage va de 0 à 3, ces valeurs peut être changé via le controlleur
     * @return type array
     */
    public function readNews() {
        $query = 'SELECT `' . PREFIXE . 'news`.`id`, `' . PREFIXE . 'news`.`title`, `' . PREFIXE . 'news`.`plateform`, `' . PREFIXE . 'news`.`picture`, `' . PREFIXE . 'news`.`resume`, DATE_FORMAT(`' . PREFIXE . 'news`.`createDate`, \' %d/%m/%Y \') AS date, `' . PREFIXE . 'users`.`username`  FROM `' . PREFIXE . 'news` INNER JOIN `' . PREFIXE . 'users` ON `' . PREFIXE . 'news`.`id_cuyn_users` = `' . PREFIXE . 'users`.`id`  ORDER BY `id` DESC LIMIT ' . $this->firstEntry . ', ' . $this->limitArticles . '';
        $request = $this->db->prepare($query);
        $request->execute();
        return $request->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     *  La méthode me permet de sélectionner toutes les informations d'un article qui à était sélectionné par l'utilisateur
     *  c'est pour cette raison que j'ai besoin de l'id de l'article
     * @return type array
     */
    public function readNewsById() {
        $query = 'SELECT `title`, `plateform`, `picture`, `content`, `picture`, DATE_FORMAT(`createdate`, \' %d/%m/%Y \') AS date FROM `' . PREFIXE . 'news` WHERE id=:id';
        $request = $this->db->prepare($query);
        $request->bindValue(':id', $this->id_new, PDO::PARAM_INT);
        $request->execute();
        return $request->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     *  La méthode me permet de modifier le titre d'un article précis
     *  c'est pour cette raison que j'ai besoin de l'id de l'article afin de modifier le titre de tel article
     * @return type booléen
     */
    public function updateTitle() {
        $query = 'UPDATE `' . PREFIXE . 'news` SET `title`=:title  WHERE id=:id_news';
        $request = $this->db->prepare($query);
        $request->bindValue(':id_news', $this->id_new, PDO::PARAM_INT);
        $request->bindValue(':title', $this->title, PDO::PARAM_STR);
        return $request->execute();
    }

    /**
     *  La méthode me permet de modifier le nom de la plateforme d'un article précis
     *  c'est pour cette raison que j'ai besoin de l'id de l'article afin de modifier le nom de la plateforme de tel article
     * @return type booléen
     */
    public function updatePlateform() {
        $query = 'UPDATE `' . PREFIXE . 'news` SET `plateform`=:plateform WHERE id=:id_news';
        $request = $this->db->prepare($query);
        $request->bindValue(':id_news', $this->id_new, PDO::PARAM_INT);
        $request->bindValue(':plateform', $this->plateform, PDO::PARAM_STR);
        return $request->execute();
    }

    /**
     *  La méthode me permet de modifier le résumé d'un article précis
     *  c'est pour cette raison que j'ai besoin de l'id de l'article afin de modifier le résumé de tel article
     * @return type booléen
     */
    public function updateResume() {
        $query = 'UPDATE `' . PREFIXE . 'news` SET `resume`=:resume WHERE id=:id_news';
        $request = $this->db->prepare($query);
        $request->bindValue(':id_news', $this->id_new, PDO::PARAM_INT);
        $request->bindValue(':resume', $this->resume, PDO::PARAM_STR);
        return $request->execute();
    }

    /**
     *  La méthode me permet de modifier le contenu d'un article précis
     *  c'est pour cette raison que j'ai besoin de l'id de l'article afin de modifier le contenu de tel article
     * @return type booléen
     */
    public function updateContent() {
        $query = 'UPDATE `' . PREFIXE . 'news` SET `content`=:content WHERE id=:id_news';
        $request = $this->db->prepare($query);
        $request->bindValue(':id_news', $this->id_new, PDO::PARAM_INT);
        $request->bindValue(':content', $this->content, PDO::PARAM_STR);
        return $request->execute();
    }

    /**
     *  La méthode me permet de modifier l'image d'un article précis
     *  c'est pour cette raison que j'ai besoin de l'id de l'article afin de modifier l'image de tel article
     * @return type booléen
     */
    public function updatePicture() {
        $query = 'UPDATE `' . PREFIXE . 'news` SET `picture`=:picture WHERE id=:id_news';
        $request = $this->db->prepare($query);
        $request->bindValue(':id_news', $this->id_new, PDO::PARAM_INT);
        $request->bindValue(':picture', $this->picture, PDO::PARAM_STR);
        return $request->execute();
    }

    /**
     *  La méthode contient deux requêtes qui me permet de supprimer un article ainsi que tout les commentaires lié à l'article
     *  On commence par essayer de démarrer une transaction, si une requête me retourne false, dans ce cas, toutes les requêtes sont annulés
     *  Si toutes les requêtes retourne vrais, on valide la transaction et les requêtes sont exécutés
     * @return boolean
     */
    public function deleteNews() {
        try {
            $this->db->beginTransaction();
            // Supprime les commentaires lié à l'article
            $query = 'DELETE FROM `' . PREFIXE . 'comments` WHERE id_cuyn_news=:id_cuyn_news';
            $request = $this->db->prepare($query);
            $request->bindValue(':id_cuyn_news', $this->id_new, PDO::PARAM_INT);
            $request->execute();
            // Supprime l'article en question
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

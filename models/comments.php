<?php

/**
 * Classe comments qui permet de créer, afficher, modifier, supprimer et compter les commentaires
 * Elle hérite de la classe database qui contient la connexion à la base de données
 */
class comments extends database {

    /**
     *  Attributs : 
     *  L'id de l'utilisateur
     *  L'id de l'article
     *  L'id du commentaire
     *  Le contenu du commentaire
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
     *  La méthode me permet d'insérer dans la table "comments" : le contenu du commentaire, l'id de l'utilisateur et l'id de l'article
     *  Le commentaire est lié à l'article et à l'utilisateur
     *  On utilise la méthode prepare afin d'éviter les injections SQL
     *  On utilise la méthode bindValue qui nous permet d'associer nos marqueurs nominatif à des variables qui contiennent des données de type différents
     *  On utilise les constantes de classe (ex : PDO::PARAM_STR) qui représente le type de données qui sera inséré
     * @return type booléen
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
     *  La méthode me permet de sélectionner : l'id du commentaire, le contenu du commentaire, l'id de l'utilisateur, l'id de l'article, le nom de l'image et le pseudo de l'utilisateur, ainsi que la date du commentaire au format français
     *  Pour ce faire j'ai dû joindre la table "comments" ave la table "users",
     *  en précisant que la clé étrangère de la table "comments" est égale à l'id de la table "users"
     *  Nous précisons que la ligne où il doit lire ses informations, ce trouve à l'id de l'article indiqué
     *  Nous trions avec ORDER BY, du plus ancien au plus récent
     * @return type array
     */
    public function readComments() {
        $query = 'SELECT `' . PREFIXE . 'comments`.`id`, ' . '`' . PREFIXE . 'comments`.`comment`, `' . PREFIXE . 'comments`.`id_cuyn_users`, `' . PREFIXE . 'comments`.`id_cuyn_news`, `' . PREFIXE . 'users`.`avatar`, DATE_FORMAT(`' . PREFIXE . 'comments`.`createDate`, \' %d/%m/%Y à %Hh%i \') AS `date`, `' . PREFIXE . 'users`.`username` FROM `' . PREFIXE . 'comments` '. 'INNER JOIN `' . PREFIXE . 'users` ON `' . PREFIXE . 'comments`.`id_cuyn_users` = `' . PREFIXE . 'users`.`id` WHERE `' . PREFIXE . 'comments`.`id_cuyn_news`=:id_cuyn_news ORDER BY id ASC';
        $request = $this->db->prepare($query);
        $request->bindValue(':id_cuyn_news', $this->id_new, PDO::PARAM_INT);
        $request->execute();
        return $request->fetchAll(PDO::FETCH_OBJ);
    }
    
    /**
     *  La méthode me permet de compter le nombre d'id dans la table comments, suivant l'id de l'article
     *  La requête me retourne une ligne de résultat 
     */
    public function countComments() {
        $query = 'SELECT COUNT(`id`) AS nbComments FROM `' . PREFIXE . 'comments` WHERE id_cuyn_news =:id_cuyn_news';
        $request = $this->db->prepare($query);
        $request->bindValue(':id_cuyn_news', $this->id_new, PDO::PARAM_INT);
        $request->execute();
        return $request->fetch(PDO::FETCH_OBJ)->nbComments;
    }

    /**
     *  La méthode me permet de modifier un commentaire qui est lié à l'utilisateur,
     *  c'est pour cette raison que j'ai besoin de l'id du commentaire et l'id de l'utilisateur
     * @return type booléen
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
     *  La méthode me permet de supprimer un commentaire lié à l'utilisateur, ainsi que toute sa ligne dans la table "comments"
     *  c'est pour cette raison que j'ai besoin de l'id du commentaire et l'id de l'utilisateur
     * @return type booléen
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

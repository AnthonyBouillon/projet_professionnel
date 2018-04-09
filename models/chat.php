<?php

/**
 * Classe chat qui me permet d'insérer et d'afficher les messages et les pseudos de l'utilisateur 
 * La classe chat hérite de tout le contenu de la classe database
 */
class chat extends database {

    /**
     *  Les attributs sont l'id et le contenu du message de l'utilisateur 
     * @var type int et char
     */
    public $id_user = 0;
    public $message = '';

    /**
     *  Ajout de la méthode parent __construct qui provient de la classe database du model database qui contient la connexion à la base de données
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     *  La méthode me permet d'insérer dans la table chat, le message et l'id de l'utilisateur
     *  Si l'utilisateur n'est pas connecté, l'id de l'utilisateur deviendra NULL
     *  On utilise les constantes de classe (ex : PDO::PARAM_STR) qui représente le type de données qui sera inséré
     *  On utilise la méthode bindValue qui nous permet d'associer nos marqueurs nominatif à des variables qui contiennent des données de type différents
     * @return type booléen
     */
    public function createMessage() {
        $query = 'INSERT INTO `' . PREFIXE . 'chat`(`message`, `id_cuyn_users`) VALUES(:message, :id_cuyn_users)';
        $request = $this->db->prepare($query);
        $request->bindValue(':message', $this->message, PDO::PARAM_STR);
        if (!empty($this->id_user)) {
            $request->bindValue(':id_cuyn_users', $this->id_user, PDO::PARAM_INT);
        } else {
            $request->bindValue(':id_cuyn_users', NULL, PDO::PARAM_INT);
        }
        return $request->execute();
    }

    /**
     *  La méthode me permet de sélectionner, le message, la date et le pseudo de l'utilisateur,
     *  pour ce faire, j'ai dû joindre la table chat avec la table users, en précisant que notre clé étrangère de la table chat est égale à l'id de la table users
     *  La méthode utilisé est le LEFT JOIN car il n'y a pas toujours de correspondance entre les deux tables (l'id de l'utilisateur peut être NULL)
     *  J'ai utilisé la fonction DATE_FORMAT afin de formater la date, afin quelle soit au format français
     *  Notre méthode nous retourne un tableau qui contient toutes les lignes de la table
     *  PDO::FETCH_OBJ nous retourne le résultat du tableau en objet
     * @return type array
     */
    public function readMessage() {
        $query = 'SELECT `' . PREFIXE . 'chat`.`message`, DATE_FORMAT(`' . PREFIXE . 'chat`.`createDate`, \' %d/%m/%Y à %Hh%i \') AS `date`,  `' . PREFIXE . 'users`.`username` FROM `' . PREFIXE . 'chat` LEFT JOIN `' . PREFIXE . 'users`  ON  `' . PREFIXE . 'chat`.`id_cuyn_users` = `' . PREFIXE . 'users`. `id`  ORDER BY `' . PREFIXE . 'chat`.`id` DESC LIMIT 50';
        $request = $this->db->prepare($query);
        $request->execute();
        return $request->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     *  Ajout de la méthode parent __destruct qui provient de la classe database du model database qui contient la fermeture de la base de données
     */
    public function __destruct() {
        parent::__destruct();
    }

}

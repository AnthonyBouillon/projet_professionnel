<?php

/**
 * Classe chat qui me permet d'inserer et d'afficher les messages et les pseudos de l'utilisateur
 * La classe chat hérite de la classe database
 */
class chat extends database {
    /*
     *  Ajout des attributs pour stocker des données
     *  Attribut qui contiendra l'id et le message de l'utilisateur
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
     *  Méthode qui permet d'insérer le message lié à l'utilisateur si il est connecté
     *  Sinon la méthode insère le message seul et l'id du visiteur est NULL, ce qui me permet d'afficher le message même si l'utilisateur n'est pas connecté
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
     *  Méthode qui permet de récupèrer les messages lié au utilisateurs dans la base de données
     *  Sélection : messages, date format français, pseudo de l'utilisateur
     *  Table join : Chat avec users
     *  LEFT JOIN : Me permet de récupérer les messages des visiteurs sans id correspondant
     *  id_user de la table chat correspond avec l'id de la table users
     *  Limite l'affichage à 50 messages trié par id des messages dans l'ordre descendant
     *  Tableau qui me retourne un objet
     */
    public function readMessage() {
        $query = 'SELECT `' . PREFIXE . 'chat`.`message`, DATE_FORMAT(`' . PREFIXE . 'chat`.`createDate`, \' %d/%m/%Y à %Hh%i \') AS `date`,  `' . PREFIXE . 'users`.`username` FROM `' . PREFIXE . 'chat` LEFT JOIN `' . PREFIXE . 'users`  ON  `' . PREFIXE . 'chat`.`id_cuyn_users` = `' . PREFIXE . 'users`. `id`  ORDER BY `' . PREFIXE . 'chat`.`id` DESC LIMIT 50';
        $request = $this->db->query($query);
        return $request->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     *  Ajout de la méthode parent __destruct qui provient de la classe database du model database qui contient la fermeture de la base de données
     */
    public function __destruct() {
        parent::__destruct();
    }

}

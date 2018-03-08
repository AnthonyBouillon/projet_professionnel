<?php

/**
 * Classe chat qui permet de créer et d'afficher un message
 */
class chat extends database {

    // Ajout des attributs pour stocker des données
    public $id_user = 0;
    public $message = '';

    /**
     *  Connexion à la base de données
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     *  Méthode qui permet d'inserer le message lié à l'utilisateur si il est connecté
     *  Sinon la méthode insère le message seul
     */
    public function createMessage() {
        $query = 'INSERT INTO `' . SELF::prefix . 'chat`(`message`, `id_cuyn_users`) VALUES(:message, :id_cuyn_users)';
        $request = $this->db->prepare($query);
        if (!empty($this->id_user)) {
            $request->bindValue(':id_cuyn_users', $this->id_user, PDO::PARAM_INT);
        } else {
            $request->bindValue(':id_cuyn_users', NULL, PDO::PARAM_INT);
        }
        $request->bindValue(':message', $this->message, PDO::PARAM_STR);
        return $request->execute();
    }

    /**
     *  Méthode qui permet de récupèrer tous les messages de la base de donnée
     */
    public function readMessage() {
        $query = 'SELECT `' . SELF::prefix . 'chat`.`id_cuyn_users`, `' . SELF::prefix . 'chat`.`message`, `' . SELF::prefix . 'users`.`username` FROM `' . SELF::prefix . 'chat` LEFT JOIN `' . SELF::prefix . 'users`  ON  `' . SELF::prefix . 'chat`.`id_cuyn_users` = `' . SELF::prefix . 'users`. `id`  ORDER BY `' . SELF::prefix . 'chat`.`id` DESC LIMIT 50';
        $request = $this->db->query($query);
        return $request->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     *  Déconnexion de la base de données
     */
    public function __destruct() {
        parent::__destruct();
    }

}

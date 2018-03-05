<?php

// Classe chat qui hérite de la classe database qui contient la connexion à la base de donnée
class chat extends database {

    // Ajout des attributs
    public $message = '';
    public $sessionID = '';

    // Ajout de la connexion à la base de donnée, qui provient de son parent
    public function __construct() {
        parent::__construct();
    }

    // Méthode qui permet d'inserer les messages et le pseudo des utilisateurs du tchat (insert 'Visiteur' à la place du pseudo si non connecté)
    public function insertMessage() {
        $request = $this->db->prepare('INSERT INTO `' . SELF::prefix . 'chat`(`message`, `id_cuyn_users`) VALUES(:message, :id_cuyn_users)');
        if (!empty($_SESSION['id'])) {
            $request->bindValue(':id_cuyn_users', $this->sessionID, PDO::PARAM_INT);
        } else {
            $request->bindValue(':id_cuyn_users', 0, PDO::PARAM_INT);
        }
        $request->bindValue(':message', $this->message, PDO::PARAM_STR);
        return $request->execute();
    }

    // Méthode qui permet de sélectionner le contenu des messages lié à leurs pseudos des utilisateurs du tchat
    public function checkMessage() {
        $request = $this->db->query('SELECT `' . SELF::prefix . 'chat`.`id_cuyn_users`, `cuyn_chat`.`message`,  `cuyn_users`.`username`, DATE_FORMAT(`cuyn_chat`.`createDate`, \' %Hh%i \') AS `date` FROM `cuyn_chat` LEFT JOIN `cuyn_users`  ON  `cuyn_chat`.`id_cuyn_users` = `cuyn_users`. `id`  ORDER BY `cuyn_chat`.`id` DESC LIMIT 50');
        return $request->fetchAll(PDO::FETCH_OBJ);
    }

    // Fermeture de la connexion à la base de donnée, qui provient de son parent
    public function __destruct() {
        parent::__destruct();
    }

}

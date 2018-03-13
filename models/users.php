<?php

/**
 * Classe users qui me permet de créer, afficher, modifier, supprimer un utilisateur
 */
class users extends database {

// Ajout des attributs pour l'inscription
    public $id = 0;
    public $username = '';
    public $mail = '';
    public $password = '';
    public $newPassword = '';
    public $passwordHash = '';
    public $keyMail = '';
    public $extension = '';

    /**
     * Ajout de la connexion à la base de donnée qui provient de son parent
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Méthode qui permet d'enregistrer dans la base de données un nouveau utilisateur
     * Le compte utilisateur sera inactif
     */
    public function createUsers() {
        $query = 'INSERT INTO `' . SELF::prefix . 'users`(`username`, `mail`, `password`,`avatar`, `keyMail`, `actif`) VALUES(:username, :mail, :password, :avatar, :keyMail, :actif)';
        $request = $this->db->prepare($query);
        $request->bindValue(':username', $this->username, PDO::PARAM_STR);
        $request->bindValue(':mail', $this->mail, PDO::PARAM_STR);
        $request->bindValue(':password', $this->passwordHash, PDO::PARAM_STR);
        $request->bindValue(':keyMail', $this->keyMail, PDO::PARAM_STR);
        $request->bindValue(':actif', 0, PDO::PARAM_BOOL);
        $request->bindValue(':avatar', 'fake.jpg', PDO::PARAM_STR);
        return $request->execute();
    }

    /**
     * Méthode qui me permet de récupérer une information précise de l'utilisateur afin de les affichers
     */
    public function readUsers() {
        $query = 'SELECT `id`, `username`,`password`, `mail`, `avatar`, `keyMail`, `actif`, DATE_FORMAT(`createDate`, \' %d/%m/%Y à %Hh%i \' ) AS date FROM `' . SELF::prefix . 'users` WHERE `username` = :username OR`mail`=:mail OR `id`=:id';
        $request = $this->db->prepare($query);
        $request->bindValue('username', $this->username, PDO::PARAM_STR);
        $request->bindValue('mail', $this->mail, PDO::PARAM_STR);
        $request->bindValue('id', $this->id, PDO::PARAM_INT);
        $request->execute();
        return $request->fetch(PDO::FETCH_OBJ);
    }

    /**
     * Méthode qui me permet de récupérer une information précise de l'utilisateur afin de les affichers
     */
    public function readMail() {
        $query = 'SELECT * FROM `' . SELF::prefix . 'users` WHERE `mail`=:mail ';
        $request = $this->db->prepare($query);
        $request->bindValue('mail', $this->mail, PDO::PARAM_STR);
        $request->execute();
        return $request->fetch(PDO::FETCH_OBJ);
    }

    /**
     * Méthode qui permet de valider un compte utilisateur
     */
    public function updateCountActif() {
        $query = 'UPDATE `' . SELF::prefix . 'users` SET `actif` =:actif WHERE `id` =:id';
        $request = $this->db->prepare($query);
        $request->bindValue(':actif', 1, PDO::PARAM_BOOL);
        $request->bindValue(':id', $this->id, PDO::PARAM_INT);
        return $request->execute();
    }

    /**
     * Méthode qui permet de modifier le mot de passe de l'utilisateur
     */
    public function updatePassword() {
        $query = 'UPDATE `' . SELF::prefix . 'users` SET `password` =:password WHERE `id` =:id';
        $request = $this->db->prepare($query);
        $request->bindValue(':password', $this->passwordHash, PDO::PARAM_STR);
        $request->bindValue(':id', $this->id, PDO::PARAM_INT);
        return $request->execute();
    }

    /**
     * Méthode qui permet de modifier l'adresse e-mail de l'utilisateur
     */
    public function updateMail() {
        $query = 'UPDATE `' . SELF::prefix . 'users` SET `mail` =:mail WHERE `id` =:id';
        $request = $this->db->prepare($query);
        $request->bindValue(':mail', $this->mail, PDO::PARAM_STR);
        $request->bindValue(':id', $this->id, PDO::PARAM_INT);
        return $request->execute();
    }

    /**
     * Méthode qui permet de modifier une image de profil
     */
    public function updateAvatar() {
        $query = 'UPDATE `' . SELF::prefix . 'users` SET `avatar` =:avatar WHERE `id` =:id';
        $request = $this->db->prepare($query);
        $request->bindValue(':avatar', $this->id . '.' . $this->extension);
        $request->bindValue(':id', $this->id);
        return $request->execute();
    }

    /**
     * Méthode qui permet de supprimer un compte utilisateur
     */
    public function deleteUsers() {
        try {
            $this->db->beginTransaction();

            $query = 'DELETE FROM `' . SELF::prefix . 'forumCategories` WHERE `id_cuyn_users` = :id_cuyn_users';
            $request = $this->db->prepare($query);
            $request->bindValue(':id_cuyn_users', $this->id, PDO::PARAM_INT);
            $request->execute();

            $query = 'DELETE FROM `' . SELF::prefix . 'forumSubCategories` WHERE `id_cuyn_users` = :id_cuyn_users';
            $request = $this->db->prepare($query);
            $request->bindValue(':id_cuyn_users', $this->id, PDO::PARAM_INT);
            $request->execute();

            $query = 'DELETE FROM `' . SELF::prefix . 'forumTopics` WHERE `id_cuyn_users` = :id_cuyn_users';
            $request = $this->db->prepare($query);
            $request->bindValue(':id_cuyn_users', $this->id, PDO::PARAM_INT);
            $request->execute();

            $query = 'DELETE FROM `' . SELF::prefix . 'forumPosts` WHERE `id_cuyn_users` = :id_cuyn_users';
            $request = $this->db->prepare($query);
            $request->bindValue(':id_cuyn_users', $this->id, PDO::PARAM_INT);
            $request->execute();

            $query = 'DELETE FROM `' . SELF::prefix . 'news` WHERE `id_cuyn_users` = :id_cuyn_users';
            $request = $this->db->prepare($query);
            $request->bindValue(':id_cuyn_users', $this->id, PDO::PARAM_INT);
            $request->execute();

            $query = 'DELETE FROM `' . SELF::prefix . 'comments` WHERE `id_cuyn_users` = :id_cuyn_users';
            $request = $this->db->prepare($query);
            $request->bindValue(':id_cuyn_users', $this->id, PDO::PARAM_INT);
            $request->execute();

            $query = 'DELETE FROM `' . SELF::prefix . 'chat` WHERE `id_cuyn_users` = :id_cuyn_users';
            $request = $this->db->prepare($query);
            $request->bindValue(':id_cuyn_users', $this->id, PDO::PARAM_INT);
            $request->execute();

            $query = 'DELETE FROM `' . SELF::prefix . 'users` WHERE `id`=:id';
            $request = $this->db->prepare($query);
            $request->bindValue(':id', $this->id, PDO::PARAM_INT);
            $request->execute();

            $this->db->commit();
            $reponseDelete = true;
        } catch (Exception $ex) {
            $reponseDelete = false;
            $this->db->rollBack;
            echo "Failed: " . $ex->getMessage();
        }
        return $reponseDelete;
    }

    /**
     *  Déconnexion de la base de données
     */
    public function __destruct() {
        parent::__destruct();
    }

}

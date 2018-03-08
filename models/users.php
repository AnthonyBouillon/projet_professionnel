<?php

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
     * @return type
     */
    public function __construct() {
        parent::__construct();
    }

    /** 
     * Méthode qui permet d'enregistrer dans la base de donnée un nouveau utilisateur
     * @return type
     */
    public function createUsers() {
        $request = $this->db->prepare('INSERT INTO `' . SELF::prefix . 'users`(`username`, `mail`, `password`,`avatar`, `keyMail`, `actif`) VALUES(:username, :mail, :password, :avatar, :keyMail, :actif)');
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
     * @return type
     */
    public function readUsers() {
        $request = $this->db->prepare('SELECT `id`, `username`,`password`, `mail`, `avatar`, `keyMail`, `actif`, DATE_FORMAT(`createDate`, \' %d/%m/%Y à %Hh%i \' ) AS date FROM `' . SELF::prefix . 'users` WHERE `username` = :username OR`mail`=:mail OR `id`=:id');
        $request->bindValue('username', $this->username, PDO::PARAM_STR);
        $request->bindValue('mail', $this->mail, PDO::PARAM_STR);
        $request->bindValue('id', $this->id, PDO::PARAM_INT);
        $request->execute();
        return $request->fetch(PDO::FETCH_OBJ);
    }

    // Méthode qui permet de valider un compte utilisateur
    public function updateCountActif() {
        $request = $this->db->prepare('UPDATE `' . SELF::prefix . 'users` SET `actif` =:actif WHERE `id` =:id');
        $request->bindValue(':actif', 1, PDO::PARAM_BOOL);
        $request->bindValue(':id', $this->id, PDO::PARAM_INT);
        return $request->execute();
    }

    // Méthode qui permet de modifier le mot de passe de l'utilisateur
    public function updatePassword() {
        $request = $this->db->prepare('UPDATE `' . SELF::prefix . 'users` SET `password` =:password WHERE `id` =:id');
        $request->bindValue(':password', $this->passwordHash, PDO::PARAM_STR);
        $request->bindValue(':id', $this->id, PDO::PARAM_INT);
        return $request->execute();
    }

    // Méthode qui permet de modifier l'e mot de passe 'adresse e-mail de l'utilisateur
    public function updateMail() {
        $request = $this->db->prepare('UPDATE `' . SELF::prefix . 'users` SET `mail` =:mail WHERE `id` =:id');
        $request->bindValue(':mail', $this->mail, PDO::PARAM_STR);
        $request->bindValue(':id', $this->id, PDO::PARAM_INT);
        return $request->execute();
    }

    // Méthode qui permet de modifier une image de profil
    public function updateAvatar() {
        $request = $this->db->prepare('UPDATE `' . SELF::prefix . 'users` SET `avatar` =:avatar WHERE `id` =:id');
        $request->bindValue(':avatar', $this->id . '.' . $this->extension);
        $request->bindValue(':id', $this->id);
        return $request->execute();
    }

    // Méthode qui permet de supprimer un compte
    public function deleteUsers() {
        $request = $this->db->prepare('DELETE FROM `' . SELF::prefix . 'users` WHERE id=:id');
        $request->bindValue(':id', $this->id, PDO::PARAM_INT);
        $request->execute();
    }

    // Fermeture de la connexion à la base de donnée qui provient de son parent
    public function __destruct() {
        parent::__destruct();
    }

}

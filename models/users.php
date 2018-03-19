<?php

/**
 * Classe users qui me permet de créer, afficher, modifier, supprimer un ou des utilisateurs
 * La classe users hérite de la classe database
 */
class users extends database {
    /*
     * Nous héritons de l'attribut de la classe database
     * $db
     */

    /* Ajout des attributs pour l'inscription de l'utilisateur
     * L'id
     * Le pseudo
     * Le mot de passe
     * Le mot de passe pour la modification de celui ci
     * Le mot de passe chiffré
     * La clé pour la validation du compte
     * L'extension d'une image
     */

    public $id = 0;
    public $username = '';
    public $mail = '';
    public $password = '';
    public $newPassword = '';
    public $passwordHash = '';
    public $keyMail = '';
    public $extension = '';

    /**
     * Ajout de la méthode __construct qui provient de la classe database du model database qui contient la connexion à la base de données
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Méthode qui permet d'enregistrer dans la base de données un nouveau utilisateur
     * Le compte utilisateur sera inactif par defaut
     * Utilisation des marqueurs nominatif et des bindValues pour plus de sécurité
     * Utilisation des paramètres
     * La méthode retourne l'éxécution de la requete
     */
    public function createUsers() {
        $query = 'INSERT INTO `' . PREFIXE . 'users`(`username`, `mail`, `password`,`avatar`, `keyMail`, `actif`) VALUES(:username, :mail, :password, :avatar, :keyMail, :actif)';
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
     * Méthode qui me permet de récupérer des informations sur l'utilisateur qui correspond avec sont pseudo, l'e-mail ou son id
     * Date et heure au format français
     * Utilisation des marqueurs nominatif et des bindValues pour plus de sécurité
     * Utilisation des paramètres
     * La méthode retourne une ligne d'information et le retourne en objet
     */
    public function readUsers() {
        $query = 'SELECT `id`, `username`,`password`, `mail`, `avatar`, `keyMail`, `actif`, DATE_FORMAT(`createDate`, \' %d/%m/%Y à %Hh%i \' ) AS date FROM `' . PREFIXE . 'users` WHERE `username` = :username OR `mail` = :mail OR `id` = :id';
        $request = $this->db->prepare($query);
        $request->bindValue(':username', $this->username, PDO::PARAM_STR);
        $request->bindValue(':mail', $this->mail, PDO::PARAM_STR);
        $request->bindValue(':id', $this->id, PDO::PARAM_INT);
        $request->execute();
        return $request->fetch(PDO::FETCH_OBJ);
    }
    
    public function readAllUsers() {
        $query = 'SELECT * FROM `' . PREFIXE . 'users`';
        $request = $this->db->query($query);
        return $request->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * Méthode qui me permet de vérifié si l'adresse e-mail saisie existe dans la base de données pour la modification de l'adresse e-mail
     * Utilisation d'un marqeur nominatif et du bindValue 
     * Utilisation du paramètre : chaine de caractère (STR)
     * On éxécute
     * La méthode retourne une ligne d'information et le retourne en objet
     */
    public function readMail() {
        $query = 'SELECT * FROM `' . PREFIXE . 'users` WHERE `mail` = :mail ';
        $request = $this->db->prepare($query);
        $request->bindValue('mail', $this->mail, PDO::PARAM_STR);
        $request->execute();
        return $request->fetch(PDO::FETCH_OBJ);
    }

    /**
     * Méthode qui permet de valider un compte utilisateur pour qu'il puisse se connecter
     * On modifie dans le champ actif correspondant à son ID le false en true (le booléen 0 en 1)
     * La méthode retourne l'éxécution de la requete
     */
    public function updateCountActif() {
        $query = 'UPDATE `' . PREFIXE . 'users` SET `actif` = :actif WHERE `id` = :id';
        $request = $this->db->prepare($query);
        $request->bindValue(':actif', 1, PDO::PARAM_BOOL);
        $request->bindValue(':id', $this->id, PDO::PARAM_INT);
        return $request->execute();
    }

    /**
     * Méthode qui permet de modifier le mot de passe de l'utilisateur
     * On modifie dans le champ password correspondant à son ID par le nouveau mot de passe qui à était chiffré
     * La méthode retourne l'éxécution de la requete
     */
    public function updatePassword() {
        $query = 'UPDATE `' . PREFIXE . 'users` SET `password` = :password WHERE `id` = :id';
        $request = $this->db->prepare($query);
        $request->bindValue(':password', $this->passwordHash, PDO::PARAM_STR);
        $request->bindValue(':id', $this->id, PDO::PARAM_INT);
        return $request->execute();
    }

    /**
     * Méthode qui permet de modifier l'adresse e-mail de l'utilisateur
     * On modifie dans le champ mail correspondant à sont ID par la nouvelle adresse e-mail 
     * La méthode retourne l'éxécution de la requete
     */
    public function updateMail() {
        $query = 'UPDATE `' . PREFIXE . 'users` SET `mail` = :mail WHERE `id` = :id';
        $request = $this->db->prepare($query);
        $request->bindValue(':mail', $this->mail, PDO::PARAM_STR);
        $request->bindValue(':id', $this->id, PDO::PARAM_INT);
        return $request->execute();
    }

    /**
     * Méthode qui permet de modifier l'image de profil de l'utilisateur
     * On modifie dans le champ avatar correspondant à son ID par la nouvelle image 
     * L'image contient son ID + . + l'extension de l'image
     * La méthode retourne l'éxécution de la requete
     */
    public function updateAvatar() {
        $query = 'UPDATE `' . PREFIXE . 'users` SET `avatar` = :avatar WHERE `id` = :id';
        $request = $this->db->prepare($query);
        $request->bindValue(':avatar', $this->id . '.' . $this->extension);
        $request->bindValue(':id', $this->id);
        return $request->execute();
    }

    /**
     * Méthode qui permet de supprimer un compte utilisateur ainsi que toutes les données lié à celui ci
     * Dans le bloc try :
     * Nous démarrons une transaction
     * Si la méthode retourne vrai
     * Nous supprimons les données des champs qui ce trouve dans les tables qui sont lié à son ID
     * Si la méthode retourne false
     * Nous annulons la transaction
     */
    public function deleteUsers() {
        try {
            $this->db->beginTransaction();
            // FORUM CATEGORIE
            $query = 'DELETE FROM `' . PREFIXE . 'forumCategories` WHERE `id_cuyn_users` = :id_cuyn_users';
            $request = $this->db->prepare($query);
            $request->bindValue(':id_cuyn_users', $this->id, PDO::PARAM_INT);
            $request->execute();
            // FORUM SOUS CATEGORIE
            $query = 'DELETE FROM `' . PREFIXE . 'forumSubCategories` WHERE `id_cuyn_users` = :id_cuyn_users';
            $request = $this->db->prepare($query);
            $request->bindValue(':id_cuyn_users', $this->id, PDO::PARAM_INT);
            $request->execute();
            // FORUM TOPICS
            $query = 'DELETE FROM `' . PREFIXE . 'forumTopics` WHERE `id_cuyn_users` = :id_cuyn_users';
            $request = $this->db->prepare($query);
            $request->bindValue(':id_cuyn_users', $this->id, PDO::PARAM_INT);
            $request->execute();
            // FORUM RÉPONSES
            $query = 'DELETE FROM `' . PREFIXE . 'forumPosts` WHERE `id_cuyn_users` = :id_cuyn_users';
            $request = $this->db->prepare($query);
            $request->bindValue(':id_cuyn_users', $this->id, PDO::PARAM_INT);
            $request->execute();
            // ARTICLES
            $query = 'DELETE FROM `' . PREFIXE . 'news` WHERE `id_cuyn_users` = :id_cuyn_users';
            $request = $this->db->prepare($query);
            $request->bindValue(':id_cuyn_users', $this->id, PDO::PARAM_INT);
            $request->execute();
            // COMMENTAIRES
            $query = 'DELETE FROM `' . PREFIXE . 'comments` WHERE `id_cuyn_users` = :id_cuyn_users';
            $request = $this->db->prepare($query);
            $request->bindValue(':id_cuyn_users', $this->id, PDO::PARAM_INT);
            $request->execute();
            // TCHAT
            $query = 'DELETE FROM `' . PREFIXE . 'chat` WHERE `id_cuyn_users` = :id_cuyn_users';
            $request = $this->db->prepare($query);
            $request->bindValue(':id_cuyn_users', $this->id, PDO::PARAM_INT);
            $request->execute();
            // UTILISATEUR
            $query = 'DELETE FROM `' . PREFIXE . 'users` WHERE `id`= :id';
            $request = $this->db->prepare($query);
            $request->bindValue(':id', $this->id, PDO::PARAM_INT);
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
     *  Ajout de la méthode __destruct qui provient de la classe database du model database qui contient la fermeture de la base de données
     */
    public function __destruct() {
        parent::__destruct();
    }

}

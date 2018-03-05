<?php

class forumCategories extends database {

    public $id = 0;
    public $name = '';
    public $description = '';

    // Ajout de la connexion à la base de donnée, qui provient de son parent
    public function __construct() {
        parent::__construct();
    }

    // Méthode qui me permet de sélectionner les catégories
    public function getCategories() {
        $request = $this->db->query('SELECT `id`,`name`, `description` FROM `cuyn_forumCategories`');
        return $request->fetchAll(PDO::FETCH_OBJ);
    }

    // Méthode qui me permet de sélectionner les catégories
    public function getSubCategories() {
        $request = $this->db->prepare('SELECT `id`,`name`, `description` FROM `cuyn_forumSubCategories` WHERE id_forumCategories=:id');
        $request->bindValue('id', $_GET['id'], PDO::PARAM_INT);
        $request->execute();
        return $request->fetchAll(PDO::FETCH_OBJ);
    }

    // Méthode qui me permet d'inserer une sous-catégorie
    public function InsertCategories() {
        $request = $this->db->prepare('INSERT INTO `cuyn_forumCategories`(`name`, `description`) VALUES (:name, :description)');
        $request->bindValue('name', $_POST['name'], PDO::PARAM_STR);
        $request->bindValue('description', $_POST['description'], PDO::PARAM_STR);
        return $request->execute();
    }

// Méthode qui permet de modifier l'e mot de passe 'adresse e-mail de l'utilisateur
    public function updateCategories() {
        $request = $this->db->prepare('UPDATE `' . SELF::prefix . 'forumCategories` SET `name` =:name, description=:description WHERE `id` =:id');
        $request->bindValue(':name', $this->name, PDO::PARAM_STR);
        $request->bindValue(':description', $this->description, PDO::PARAM_STR);
        $request->bindValue(':id', $this->id, PDO::PARAM_INT);
        return $request->execute();
    }

    // Méthode qui permet de supprimer un compte
    public function deleteCategories() {


        try {
            $result = false;
            $this->db->beginTransaction();
            
            $request = $this->db->prepare('DELETE FROM `' . SELF::prefix . 'forumSubCategories` WHERE id_forumCategories=:id');
            $request->bindValue(':id', $this->id, PDO::PARAM_INT);
            $result = $request->execute();
            
            $request = $this->db->prepare('DELETE FROM `' . SELF::prefix . 'forumCategories` WHERE id=:id');
            $request->bindValue(':id', $this->id, PDO::PARAM_INT);
            $result = $request->execute();
            
            $this->db->commit();
            return $result;
        } catch (Exception $e) { //en cas d'erreur
            //on annule la transation
            $this->db->rollback();

            //on affiche un message d'erreur ainsi que les erreurs
            var_dump( 'Tout ne s\'est pas bien passé, voir les erreurs ci-dessous<br />');
            var_dump( 'Erreur : ' . $e->getMessage() . '<br />');
            var_dump( 'N° : ' . $e->getCode());
            //on arrête l'exécution s'il y a du code après
            exit();
        }
    }

    // Fermeture de la connexion à la base de donnée, qui provient de son parent
    public function __destruct() {
        parent::__destruct();
    }

}

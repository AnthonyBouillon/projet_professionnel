<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of forumSubCategories
 *
 * @author bouillon
 */
class forumSubCategories extends database {

    // Ajout de la connexion à la base de donnée, qui provient de son parent
    public function __construct() {
        parent::__construct();
    }

    // Méthode qui me permet de sélectionner les catégories
    public function getSubCategories() {
        $request = $this->db->prepare('SELECT `id`,`name`, `description` FROM `cuyn_forumSubCategories` WHERE id_forumCategories=:id');
        $request->bindValue('id', $_GET['id'], PDO::PARAM_INT);
        $request->execute();
        return $request->fetchAll(PDO::FETCH_OBJ);
    }

    // Méthode qui me permet d'inserer une sous-catégorie
    public function InsertSubCategories() {
        $request = $this->db->prepare('INSERT INTO `cuyn_forumSubCategories`(`name`, `description`, `id_forumCategories`) VALUES (:name, :description, :id_forumCategories)');
        $request->bindValue('name', $_POST['name'], PDO::PARAM_STR);
        $request->bindValue('description', $_POST['description'], PDO::PARAM_STR);
        $request->bindValue('id_forumCategories', $_GET['id'], PDO::PARAM_INT);
        return $request->execute();
    }

    // Fermeture de la connexion à la base de donnée, qui provient de son parent
    public function __destruct() {
        parent::__destruct();
    }

}

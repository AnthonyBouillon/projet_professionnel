<?php

/**
 * Classe database servant à se connecter à la base de données
 */
class database {

    // Attribut qui est disponible que dans cette classe et tous ceux qui en hérite
    protected $db;

    /**
     *  Connexion à la base de données
     *  méthode en protected qui ne pourra être appelé que dans la classe et les classes qui en hérite
     *  Si la connexion ne marche pas on attrape l'erreur et on l'affiche
     */
    protected function __construct() {
        try {
            $this->db = new PDO('mysql:host=' . HOST . ';dbname=' . DBNAME . ';charset=utf8', USER, PASSWORD, array(PDO::ATTR_PERSISTENT => true));
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    /**
     *  Déconnexion de la base de données
     *  méthode en protected qui ne pourra être appelé que dans la classe et les classes qui en hérite
     */
    protected function __destruct() {
        $this->db = NULL;
    }

}

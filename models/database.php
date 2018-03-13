<?php

/**
 * Classe database servant à se connecter à la base de données
 */
class database {

    // Attribut qui est disponible dans cette classe et tous ceux qui en hérite
    protected $db;

    /**
     * Constance contenant le préfixe des tables afin de le cacher
     */
    CONST prefix = 'cuyn_';

    /**
     *  Connexion à la base de données
     */
    protected function __construct() {
        try {
            $this->db = new PDO('mysql:host=' . HOST . ';dbname=' . DBNAME . ';charset=utf8', USER, PASSWORD);
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    /**
     *  Déconnexion de la base de données
     */
    protected function __destruct() {
        $this->db = NULL;
    }

}

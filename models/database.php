<?php

class database {

    // Attribut qui a pour valeur la connexion à la base de donnée
    protected $db;

    // Créer une constance afin de caché son préfixe des tables de la base de donnée
    CONST prefix = 'cuyn_';

    public function __construct() {
        // Connexion à la base de donnée
        try {
            $this->db = new PDO('mysql:host=localhost;dbname=apt;charset=utf8', 'root', '789789');
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    // Fermeture de la base de donnée
    public function __destruct() {
        $this->db = NULL;
    }

}

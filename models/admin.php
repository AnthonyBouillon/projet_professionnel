<?php

/**
 * Classe admin qui me permet d'afficher toutes les données contenu dans la table
 * La classe chat hérite de tout le contenu de la classe database
 */
class admin extends database {
    /**
     *  Ajout de la méthode __construct qui provient de la classe database du model database qui contient la connexion à la base de données
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     *  La méthode me permet de sélectionner l'id et les droits de la table admin
     *  On utilise la méthode prepare afin d'éviter les injections SQL
     *  Notre méthode nous retourne un tableau qui contient toutes les lignes de la table
     *  PDO::FETCH_OBJ nous retourne le résultat du tableau en objet
     * @return type array
     */
    public function readAllStatus() {
        $query = 'SELECT `id`, `rights` FROM `' . PREFIXE . 'admin`';
        $request = $this->db->prepare($query);
        $request->execute();
        return $request->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     *  Ajout de la méthode __destruct qui provient de la classe database du model database qui contient la fermeture de la base de données
     */
    public function __destruct() {
        parent::__destruct();
    }

}

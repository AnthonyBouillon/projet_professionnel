<?php

class admin extends database {

    /**
     * Ajout de la méthode __construct qui provient de la classe database du model database qui contient la connexion à la base de données
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Méthode qui contient une requête qui nous permet de sélectionner tous les droits de la table administrateur
     */
    public function readAllStatus() {
        $query = 'SELECT `id`, `rights` FROM cuyn_admin';
        $request = $this->db->query($query);
        return $request->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     *  Ajout de la méthode __destruct qui provient de la classe database du model database qui contient la fermeture de la base de données
     */
    public function __destruct() {
        parent::__destruct();
    }

}

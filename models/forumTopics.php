<?php


class forumTopics extends database{
    // Méthode qui me permet de sélectionner les catégories
    public function getTopics() {
        $request = $this->db->prepare('SELECT `id`,`name` FROM `cuyn_forumTopics` WHERE id_forumSubCategory=:id');
        $request->bindValue('id', $_GET['id'], PDO::PARAM_INT);
        $request->execute();
        return $request->fetchAll(PDO::FETCH_OBJ);
    }
}

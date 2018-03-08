<?php

class forumTopics extends database {

    // Méthode qui me permet d'inserer une sous-catégorie
    public function InsertTopics() {
        $request = $this->db->prepare('INSERT INTO `cuyn_forumTopics`(`subject`, `id_cuyn_forumSubCategories`,id_cuyn_users ) VALUES (:subject, :id_cuyn_forumSubCategories, :id_cuyn_users)');
        $request->bindValue(':subject', $_POST['name'], PDO::PARAM_STR);
        $request->bindValue(':id_cuyn_forumSubCategories', $_GET['id'], PDO::PARAM_INT);
        $request->bindValue(':id_cuyn_users', $_SESSION['id'], PDO::PARAM_INT);
        return $request->execute();
    }

    // Méthode qui me permet de sélectionner les catégories
    public function getTopics() {
        $request = $this->db->prepare('SELECT `id`,`name` FROM `cuyn_forumTopics` WHERE id_cuyn_forumSubCategories=:id_cuyn_forumSubCategories');
        $request->bindValue(':id_cuyn_forumSubCategories', $_GET['id'], PDO::PARAM_INT);
        $request->execute();
        return $request->fetchAll(PDO::FETCH_OBJ);
    }

}

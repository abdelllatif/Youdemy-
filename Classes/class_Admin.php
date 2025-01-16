<?php class Admin extends User {
    public function getDashboard() {
        return "Dashboard administrateur pour {$this->name}";
    }

    public function validateTeacherAccount($teacherId) {
        // Logique pour valider un compte enseignant
    }

    public function manageUsers() {
        // Logique pour gérer les utilisateurs
    }

    public function manageContent() {
        // Logique pour gérer les cours, catégories et tags
    }

    public function getStatistics() {
        // Logique pour obtenir des statistiques globales
    }
}
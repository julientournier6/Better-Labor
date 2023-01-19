function rowClick() {
    id = this.id;
    window.location.href = "../espace-membre/donnees.php?id=" + id;
}

function chefrowClick() {
    id = this.id;
    window.location.href = "../espace-membre/modification_profil_gestionnaire.php?own=0&id=" + id;
}
function rowClick() {
    id = this.id;
    role = "chef";
    fetch("../database/gestion_profil.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8",
        },
        body: `gestion=${1}&role=${role}&id=${id}`,
      })
    //   .then((response) => response.text())
    //   .then((res) => (alert(res)));
      window.location.reload();
}
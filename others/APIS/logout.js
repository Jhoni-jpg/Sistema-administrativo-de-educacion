document.addEventListener("DOMContentLoaded", () => {
  document
    .querySelector(".userAction__logout")
    .addEventListener("click", async (e) => {
      await fetch("/views/menuPrincipal.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ cerrarSesion: "ok" }),
      }).catch((err) => console.log(`Ha ocurrido un error inesperado ${err}`));
    });
});

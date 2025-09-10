export function initEvent_programs() {
  document.addEventListener("DOMContentLoaded", () => {
    const listPrograms = () => {
      const button = document.querySelector(".listPrograms__toggleButton");
      const container = document.querySelector(".dropdown-menu");
      let buttonPressed = false;

      button.addEventListener("click", async () => {
        if (!buttonPressed) {
          await fetch("/views/panelAdministrativo.php", {
            method: "POST",
            headers: { "Content-type": "application/json" },
            body: JSON.stringify({ listarProgramas: "ok" }),
          })
            .then((res) => {
              const tipo = res.headers.get("Content-Type") || "";
              if (!res.ok || !tipo.includes("application/json")) {
                return res.text().then((html) => {
                  throw new Error(`Respuesta inválida: ${res.status}\n${html}`);
                });
              }
              return res.json();
            })
            .then((data) => {
              container.replaceChildren();
              if (data.estado == "error") {
                container.innerHTML += `<li class='dropdown-item'>No hay programas disponibles</li>`;
                return;
              }

              if (Object.entries(data).length != 0) {
                Object.values(data).forEach((element) => {
                  container.innerHTML += `
                <form action="/?view=panelAdministrativo" method="post">
                <li class='d-flex justify-content-start align-items-center'>
                <a class='dropdown-item'>${element.nombre}</a>
                <input type='hidden' name='id_program' value='${element.id}'></input>
                  <button name='dropProgram' class='btn btn-outline-danger m-3 d-flex justify-content-center align-items-center' type='submit'><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293z" />
                                            </svg></button>
                </li>
                </form>
                `;
                });
              }
            })
            .catch((err) => `Ha ocurrido un error en la comunicacion: ${err}`);

          buttonPressed = true;

          setTimeout(() => {
            buttonPressed = false;
          }, 2000);
        }
      });
    };

    listPrograms();
  });
}

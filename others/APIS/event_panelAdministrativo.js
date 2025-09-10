import { initEvent_programs } from "../APIS/components/event_programs.js";
import { initRandom_ficha } from "../APIS/components/randomFicha.js";
const page = "../../views/panelAdministrativo.php";

const fetchFunction = async (opcion) => {
  const contentContainer =
    document.querySelector(".mainContent__sectionInformation") ?? "";

  await fetch(page, {
    method: "POST",
    headers: { "Content-type": "application/json" },
    body: JSON.stringify({ typeOption: opcion }),
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
      if (data.status == "ok") {
        if (contentContainer.children.length > 0) {
          contentContainer.innerHTML = "";

          if (contentContainer.children.length == 0) {
            contentContainer.innerHTML = data.html;
            initEvent_programs();
            initRandom_ficha();
          }
        } else {
          if (contentContainer.children.length == 0) {
            contentContainer.innerHTML = data.html;
            initEvent_programs();
            initRandom_ficha();
          }
        }

        return;
      }

      if (data.status == "error") {
        console.log(data.message);
        return;
      }
    })
    .catch((err) => {
      console.log(
        `Ha ocurrido un error inesperado en la conexion o peticion no encontrada ${err}`
      );
      alert("Error de conexion");
      location.reload();
      return;
    });
};

document.addEventListener("DOMContentLoaded", () => {
  const opcionesSidebar = () => {
    const elemento = document.querySelectorAll(".sidebar__listOptions") ?? "";

    if (elemento == "" && contentContainer == "") {
      console.log(
        "Los elementos listados no se encuentran disponibles en el DOM"
      );
      alert("Ha ocurrido un error al entrar a la seccion requerida");
      location.reload();
      return;
    }

    elemento.forEach((element) => {
      element.addEventListener("click", async (e) => {
        const opcionSeleccionada = element.dataset.option;

        if (opcionSeleccionada == "estudiante") {
          fetchFunction(opcionSeleccionada);
        } else {
          console.log("Data no encontrada");
        }
      });
    });
  };

  opcionesSidebar();
});

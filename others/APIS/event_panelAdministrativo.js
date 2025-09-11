import { initEvent_programs } from "../APIS/components/event_programs.js";
import { initRandom_ficha } from "../APIS/components/randomFicha.js";
const page = "../../views/panelAdministrativo.php";

const contentContainer = document.querySelector(".mainContent__sectionInformation") ?? '';
const elemento = document.querySelectorAll(".sidebar__listOptions");

const fetchFunction = async (opcion) => {
  try {
    const res = await fetch(page, {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ typeOption: opcion }),
    });

    const tipo = res.headers.get("Content-Type") || "";
    if (!res.ok || !tipo.includes("application/json")) {
      const html = await res.text();
      throw new Error(`Respuesta inválida: ${res.status}\n${html}`);
    }

    const data = await res.json();
    contentContainer.innerHTML = "";

    if (data.status === "ok") {
      contentContainer.innerHTML = data.html;
      initEvent_programs();
      initRandom_ficha();
    } else if (data.status === "error") {
      console.log(data.message);
    }
  } catch (err) {
    console.error("Error inesperado en la conexión:", err);
    alert("Error de conexión. Intenta nuevamente.");
  }
};

const vistaCargada = () => {
  const value = localStorage.getItem('opcionSeleccionada');
  return value != null || value != '';
}

document.addEventListener("DOMContentLoaded", () => {
  const opcionesSidebar = () => {
    let onHold = false;

    if (elemento.length == 0 && contentContainer == '') {
      console.log(
        "Los elementos listados no se encuentran disponibles en el DOM"
      );
      alert("Ha ocurrido un error al entrar a la seccion requerida");
      return;
    }

    elemento.forEach((element) => {
      element.addEventListener("click", async (e) => {

        if (onHold) {
          console.log('Cooldown activado');
          return;
        }


        const opcionSeleccionada = element.dataset.option.trim();

        localStorage.setItem('opcionSeleccionada', opcionSeleccionada);
        if (opcionSeleccionada == "estudiante") {
          if (opcionSeleccionada) {
            fetchFunction(opcionSeleccionada);
          }
        } else {
          console.log("Data no encontrada");
        }

        onHold = true;
        setTimeout(() => {
          onHold = false;
        }, 3000);
      });
    });

    if (vistaCargada()) {
      fetchFunction(localStorage.getItem('opcionSeleccionada'));
      return;
    }
  };
  opcionesSidebar();
});

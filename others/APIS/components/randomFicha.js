export function initRandom_ficha() {
  const getNum = (digito) => {
    const min = Math.pow(10, digito - 1);
    const max = Math.pow(10, digito) - 1;
    return Math.floor(Math.random() * (max - min + 1)) + min;
  };

  const randomNum = async (page) => {
    const num = getNum(7);
    await fetch(page, {
      method: "POST",
      header: { "Content-type": "application/json" },
      body: JSON.stringify({ num }),
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
        console.log(data);
      })
      .catch((err) => {
        console.log(`Ha ocurrido un error inesperado en la peticion: ${err}`);
      });
  };

  randomNum("/views/panelAdministrativo.php");
}

export function initRandom_ficha() {
  const getNum = (digito) => {
    const min = Math.pow(10, digito - 1);
    const max = Math.pow(10, digito) - 1;
    return Math.floor(Math.random() * (max - min + 1)) + min;
  };

  const randomNum = async (page) => {
    const num = getNum(7);

    try {
      const res = await fetch(page, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ num }),
      });

      const contentType = res.headers.get("Content-Type") || "";
      const status = res.status;
      const clone = res.clone();

      if (!res.ok || !contentType.includes("application/json")) {
        const htmlError = await clone.text();

        console.group("🚨 Error de respuesta inesperada");
        console.log("🔗 URL:", page);
        console.log("📦 Payload:", { num });
        console.log("📄 Content-Type:", contentType);
        console.log("📊 Status:", status);
        console.log("🧾 HTML recibido:\n", htmlError);
        console.groupEnd();

        throw new Error(`Respuesta inválida (${status})`);
      }

      const data = await res.json();

      console.group("✅ Respuesta JSON válida");
      console.log("📈 Data:", data);
      console.groupEnd();
    } catch (err) {
      console.group("❌ Error en la petición");
      console.error("🧠 Mensaje:", err.message);
      console.error("📚 Stack:", err.stack);
      console.groupEnd();
    }
  };

  randomNum("auth/estudiantes");
}

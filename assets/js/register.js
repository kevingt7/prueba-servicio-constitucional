

document.getElementById("registerForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Evita el envío del formulario por defecto

    // Obtiene los valores de los campos
    const email = document.getElementById("email").value;
    const password = document.getElementById("password").value;

    // Envía los datos al servidor
    fetch("../api/register.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: new URLSearchParams({ action: "register", email: email, password: password })
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message); // Muestra el mensaje del servidor

        if (data.status === "success") {
            // Si el registro fue exitoso, redirige o realiza otra acción
            window.location.href = "./login.html";
        }
    })
    .catch(error => console.error("Error:", error));
});
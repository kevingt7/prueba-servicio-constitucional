document.getElementById("loginForm").addEventListener("submit", function(event) {
    event.preventDefault();

    const email = document.getElementById("email").value;
    const password = document.getElementById("password").value;

    // Ruta del archivo php
    fetch("../api/login.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: new URLSearchParams({ email: email, password: password })
    })
    .then(response => response.json())
    .then(data => {
        console.log("Respuesta del servidor:", data); // Para debugging
        alert(data.message);

        if (data.status === "success") {
            window.location.href = "./to-do-list.html";
        }
    })
    .catch(error => {
        console.error("Error:", error);
        alert("Error al intentar iniciar sesión");
    });
});
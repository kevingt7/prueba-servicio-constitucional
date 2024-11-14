document.getElementById("registerForm").addEventListener("submit", function(event) {
    event.preventDefault();

    const email = document.getElementById("email").value.trim();
    const password = document.getElementById("password").value.trim();

    if (email === "" || password === "") {
        alert("Por favor, completa todos los campos.");
        return;
    }

    fetch("../api/register.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: new URLSearchParams({ email: email, password: password })
    })
    .then(response => response.json())
    .then(data => {
        console.log("Respuesta del servidor:", data);
        alert(data.message);

        if (data.status === "success") {
            window.location.href = "./login.html";
        }
    })
    .catch(error => {
        console.error("Error:", error);
        alert("Error al registrar usuario. Por favor, intenta de nuevo.");
    });
});

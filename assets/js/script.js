// Obtener los elementos 
const input = document.getElementById("taskInput");
const addButton = document.getElementById("addButton");
const ul = document.getElementById("taskList");

let tasks = JSON.parse(localStorage.getItem("tasks")) || [];

function renderTasks() {
    ul.innerHTML = ""; // Limpiar la lista
    tasks.forEach((task, index) => {
        const li = document.createElement("li");
        li.classList.add("mb-2", "list-group-item"); // clases Bootstrap
        li.innerHTML = `${task} <button class="btn-delete btn-danger">Eliminar</button>`;
        
        // botón de eliminar para cada tarea
        const deleteButton = li.querySelector(".btn-delete");
        deleteButton.addEventListener("click", () => {
            tasks.splice(index, 1); // Eliminar la tarea del array
            updateLocalStorage(); // Actualizar localStorage
            renderTasks(); // Volver a renderizar
        });

        ul.appendChild(li);
    });
}

// actualizar
function updateLocalStorage() {
    localStorage.setItem("tasks", JSON.stringify(tasks));
}

// agregar
function addTask() {
    const task = input.value;

    if (task !== "") {
        tasks.push(task); 
        updateLocalStorage();
        renderTasks(); 
        input.value = "";
    }
}

addButton.addEventListener("click", (e) => {
    e.preventDefault();
    addTask();
});

input.addEventListener("keypress", (e) => {
    if (e.key === "Enter") {
        e.preventDefault();
        addTask();
    }
});

// Mostrar tareas guardadas en localStorage
document.addEventListener("DOMContentLoaded", renderTasks);

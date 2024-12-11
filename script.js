document.addEventListener("DOMContentLoaded", function () {
    const mechanicSelect = document.getElementById("mechanic");

    fetch("get_mechanics.php")
        .then(response => response.json())
        .then(mechanics => {
            mechanics.forEach(mechanic => {
                const option = document.createElement("option");
                option.value = mechanic.id;
                option.textContent = `${mechanic.name} (Available Slots: ${mechanic.max_clients - mechanic.current_clients})`;
                mechanicSelect.appendChild(option);
            });
        });
});

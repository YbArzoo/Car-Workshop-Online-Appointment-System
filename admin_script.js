document.addEventListener("DOMContentLoaded", function () {
    const mechanicsList = document.getElementById("mechanics-list");

    // Fetch and display mechanic availability
    fetch("get_mechanics.php")
        .then(response => response.json())
        .then(mechanics => {
            console.log(mechanics); // Debug: Check the returned data in the console
            
            mechanics.forEach(mechanic => {
                const availableSlots = mechanic.max_clients - mechanic.current_clients;

                const row = document.createElement("tr");

                // Check the mechanic object fields
                console.log("Mechanic:", mechanic); // Debug individual mechanic objects

                row.innerHTML = `
                    <td>${mechanic.id}</td>                <!-- Mechanic ID -->
                    <td>${mechanic.name}</td>              <!-- Mechanic Name -->
                    <td>${mechanic.max_clients}</td>       <!-- Max Clients -->
                    <td>${mechanic.current_clients}</td>   <!-- Current Clients -->
                    <td>${availableSlots}</td>             <!-- Available Slots -->
                `;

                mechanicsList.appendChild(row);
            });
        })
        .catch(error => console.error("Error fetching mechanics:", error));
});

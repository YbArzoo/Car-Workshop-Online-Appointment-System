document.addEventListener("DOMContentLoaded", function () {
    const appointmentsList = document.getElementById("appointments-list");
    const mechanicsList = document.getElementById("mechanics-list");

    // Fetch and display appointments
    fetch("get_appointments.php")
        .then(response => response.json())
        .then(appointments => {
            console.log("Appointments Data:", appointments); // Debug to see the fetched appointments

            if (appointments.length === 0) {
                appointmentsList.innerHTML = "<tr><td colspan='6'>No appointments available.</td></tr>";
                return;
            }

            appointments.forEach(appointment => {
                const row = document.createElement("tr");

                row.innerHTML = `
                    <td>${appointment.client_name}</td>
                    <td>${appointment.phone}</td>
                    <td>${appointment.car_license}</td>
                    <td>${appointment.date}</td>
                    <td>${appointment.mechanic_name}</td>
                    <td>
                        <button onclick="editAppointment(${appointment.appointment_id})">Edit</button>
                        <button onclick="deleteAppointment(${appointment.appointment_id})" style="background-color: red; color: white;">Delete</button>
                    </td>
                `;

                appointmentsList.appendChild(row);
            });
        })
        .catch(error => {
            console.error("Error fetching appointments:", error);
            appointmentsList.innerHTML = "<tr><td colspan='6'>Failed to load appointments.</td></tr>";
        });

    // Fetch and display mechanic availability
    fetch("get_mechanics.php")
        .then(response => response.json())
        .then(mechanics => {
            console.log("Mechanics Data:", mechanics); // Debug to see the fetched mechanics

            mechanics.forEach(mechanic => {
                const availableSlots = mechanic.max_clients - mechanic.current_clients;

                const row = document.createElement("tr");

                row.innerHTML = `
                    <td>${mechanic.id}</td>
                    <td>${mechanic.name}</td>
                    <td>${mechanic.max_clients}</td>
                    <td>${mechanic.current_clients}</td>
                    <td>${availableSlots}</td>
                `;

                mechanicsList.appendChild(row);
            });
        })
        .catch(error => console.error("Error fetching mechanics:", error));
});

function editAppointment(appointmentId) {
    const newDate = prompt("Enter new date (YYYY-MM-DD):");
    const newMechanicId = prompt("Enter new mechanic ID:");

    if (newDate && newMechanicId) {
        fetch("edit_appointment.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({
                appointment_id: appointmentId,
                new_date: newDate,
                new_mechanic_id: newMechanicId,
            }),
        })
            .then(response => response.text())
            .then(message => {
                alert(message);
                location.reload(); // Reload page to update tables
            })
            .catch(error => console.error("Error editing appointment:", error));
    }
}

function deleteAppointment(appointmentId) {
    if (confirm("Are you sure you want to delete this appointment?")) {
        fetch("delete_appointment.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({ appointment_id: appointmentId }),
        })
        .then(response => response.text())
        .then(message => {
            alert(message);
            location.reload(); // Reload page to update tables
        })
        .catch(error => console.error("Error deleting appointment:", error));
    }
}

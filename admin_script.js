document.addEventListener("DOMContentLoaded", function () {
    const appointmentsList = document.getElementById("appointments-list");

    fetch("get_appointments.php")
        .then(response => response.json())
        .then(appointments => {
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
                    </td>
                `;

                appointmentsList.appendChild(row);
            });
        });
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
            .then(message => alert(message))
            .catch(error => console.error("Error:", error));
    }
}

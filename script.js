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


document.getElementById("appointment-form").addEventListener("submit", function (e) {
    const name = document.getElementById("name").value.trim();
    const address = document.getElementById("address").value.trim();
    const phone = document.getElementById("phone").value.trim();
    const carLicense = document.getElementById("car_license").value.trim();
    const carEngine = document.getElementById("car_engine").value.trim();
    const date = document.getElementById("date").value.trim();
    const mechanic = document.getElementById("mechanic").value.trim();

    let errorMessage = "";

    // Validate Name
    if (name === "") {
        errorMessage += "Name is required.\n";
    }

    // Validate Address
    if (address === "") {
        errorMessage += "Address is required.\n";
    }

    // Validate Phone
    if (!/^\d{10}$/.test(phone)) {
        errorMessage += "Phone number must be 10 digits.\n";
    }

    // Validate Car License
    if (carLicense === "") {
        errorMessage += "Car license number is required.\n";
    }

    // Validate Car Engine
    if (!/^\w+$/.test(carEngine)) {
        errorMessage += "Car engine number must be alphanumeric.\n";
    }

    // Validate Date
    if (date === "") {
        errorMessage += "Appointment date is required.\n";
    }

    // Validate Mechanic
    if (mechanic === "") {
        errorMessage += "You must select a mechanic.\n";
    }

    // Show Errors and Prevent Form Submission
    if (errorMessage !== "") {
        alert(errorMessage);
        e.preventDefault(); // Prevent form submission
    }
});

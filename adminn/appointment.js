document.addEventListener('DOMContentLoaded', function() {
    var fileButtons = document.querySelectorAll('.file-button');
    var modal = document.getElementById('fileModal');
    var span = document.getElementsByClassName("close")[0];
    var patientInfoDiv = document.getElementById('patientInfo');

    fileButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            var userId = this.getAttribute('data-user-id');
            fetchPatientInfo(userId);
            modal.style.display = "block";
        });
    });

    span.onclick = function() {
        modal.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    function fetchPatientInfo(userId) {
        fetch('get_patient_info.php?user_id=' + userId)
            .then(response => response.json())
            .then(data => {
                patientInfoDiv.innerHTML = `
                    <p><strong>First Name:</strong> ${data.fname}</p>
                    <p><strong>Last Name:</strong> ${data.lname}</p>
                    <p><strong>Age:</strong> ${data.age}</p>
                    <p><strong>Gender:</strong> ${data.gender}</p>
                    <p><strong>Contact Number:</strong> ${data.cnumber}</p>
                    <p><strong>Date of Exposure:</strong> <input type="date" id="date_exposure"></p>
                    <p><strong>Date Treatment Started:</strong> <input type="date" id="date_treatment"></p>
                    <p><strong>Vaccine:</strong> <label><input type="checkbox" id="PCEC">PCEC</label> <label><input type="checkbox" id="PVRV">PVRV</label></p>
                    <p><strong>Brand Name:</strong> <input type="text" id="brand_name"></p>
                    <p><strong>Route:</strong> <label><input type="checkbox" id="Intradermal">Intradermal Regiment</label> <label><input type="checkbox" id="Intramuscular">Intramuscular Regimen</label></p>
                `;
            });
    }
});

function toggleMenu() {
    document.body.classList.toggle("menu-open");
}
document.addEventListener('DOMContentLoaded', function() {
    const deleteButtons = document.querySelectorAll('.delete-button');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const userId = this.dataset.userId;

            if (confirm('Are you sure you want to delete this appointment?')) {
                fetch('delete_appointment.php', { // Create this PHP file
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'user_id=' + encodeURIComponent(userId),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Remove the row from the table
                        this.closest('tr').remove();
                    } else {
                        alert('Failed to delete appointment.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred.');
                });
            }
        });
    });
});
// Function to validate the form
function validateForm(event) {
    event.preventDefault(); // Prevent form submission by default

    let isValid = true;

    // Clear previous error messages
    document.querySelectorAll('.error').forEach(el => el.textContent = '');

    // Validate day and time selections
    const dayTimeSelections = Array.from(document.getElementById('dayTime').selectedOptions);
    const certificateFile = document.getElementById('certificate').files[0];

    if (dayTimeSelections.length === 0) {
        document.getElementById('dayTimeError').textContent = 'At least one day and time must be selected.';
        isValid = false;
    }

    // Validate certificate upload (only allow .pdf files)
    if (!certificateFile) {
        document.getElementById('certificateError').textContent = 'Certificate is required.';
        isValid = false;
    } else if (certificateFile.type !== 'application/pdf') {
        document.getElementById('certificateError').textContent = 'Only .pdf files are allowed for the certificate.';
        isValid = false;
    }

    // If form is valid, submit it
    if (isValid) {
        document.getElementById('applyForm').submit();
    }
}

// Attach the validation function to form submission
document.addEventListener("DOMContentLoaded", function () {
    const applyForm = document.getElementById('applyForm');
    if (applyForm) {
        applyForm.addEventListener('submit', validateForm);
    }
});

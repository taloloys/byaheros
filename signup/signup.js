swal.setDefaults({
    customClass: {
        container: 'sweet-font' // Define the custom class for the container
    }
});

console.log("JavaScript file loaded");
// Function to display success message
function showSuccessMessage() {
    swal("Success!", "You have signed up successfully!", "success");
}

// Function to display error message
function showErrorMessage() {
    swal("Oops!", "An error occurred while signing up.", "error");
}

// Function to display error message for empty fields
function showEmptyFieldsMessage() {
    swal("Error!", "Please fill in all fields.", "error");
}

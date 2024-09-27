document.addEventListener("DOMContentLoaded", function() {
    const loginForm = document.getElementById("loginForm");

    loginForm.addEventListener("submit", function(event) {
        event.preventDefault();

        const formData = new FormData(loginForm);
        const xhr = new XMLHttpRequest();
        const url = "login_process.php"; // Update the URL to your login processing script

        xhr.open("POST", url, true);

        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    const responseText = xhr.responseText.trim();
                    console.log(responseText); // For debugging purposes

                    try {
                        const jsonResponse = JSON.parse(responseText);
                        if (jsonResponse.status === "success") {
                            // Redirect to the dashboard page upon successful login
                            window.location.href = "../user/dashboard.php";
                        } else {
                            // Display error message based on the response
                            if (jsonResponse.message === 'Your account is currently blocked. Please contact support for assistance.') {
                                showError("Your account is currently blocked. Please contact support for assistance.");
                            } else if (jsonResponse.message === 'Invalid username or password') {
                                showError("Incorrect Username or Password.");
                            } else {
                                showError(jsonResponse.message);
                            }
                        }
                    } catch (e) {
                        // Display error message for unexpected errors
                        showError("An unexpected error occurred. Please try again later.");
                    }
                } else {
                    // Display error message for HTTP errors
                    showError("Error occurred. Status: " + xhr.status);
                }
            }
        };

        xhr.send(formData);
    });
});

function showError(message) {
    // Create a div element to center the text
    const errorDiv = document.createElement('div');
    errorDiv.style.textAlign = 'center';
    errorDiv.style.fontSize = '20px';
    errorDiv.textContent = message;

    // Display error message with SweetAlert
    swal({
        title: "Error!",
        content: errorDiv,
        icon: "error"
    });
}

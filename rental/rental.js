document.addEventListener("DOMContentLoaded", function() {
    const rentalForm = document.getElementById("rentalForm");

    if (rentalForm) {
        rentalForm.addEventListener("submit", function(event) {
            event.preventDefault();
            
            console.log("Form submitted");

            const formData = new FormData(rentalForm);
            const xhr = new XMLHttpRequest();
            const url = "rental_process.php"; // Ensure this is the correct path

            xhr.open("POST", url, true);

            xhr.onreadystatechange = function() {
                console.log(`ReadyState: ${xhr.readyState}, Status: ${xhr.status}`);
                
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        const responseText = xhr.responseText.trim();
                        console.log("Rental Response Text: ", responseText); // For debugging purposes

                        try {
                            const jsonResponse = JSON.parse(responseText);
                            console.log("Parsed JSON Response: ", jsonResponse);

                            if (jsonResponse.status === "success") {
                                // Display success message with SweetAlert
                                Swal.fire({
                                    title: "Success!",
                                    text: jsonResponse.message,
                                    icon: "success",
                                    didClose: () => {
                                        // Redirect to another page 
                                        window.location.href = "rental_form.php";
                                    }
                                        });

                                // Optionally, you can redirect the user to another page after successful rental
                                // window.location.href = "success_page.php";
                            } else {
                                // Display error message with SweetAlert
                                Swal.fire({
                                    title: "Error!",
                                    text: jsonResponse.message,
                                    icon: "error"
                                });
                            }
                        } catch (e) {
                            console.error("Error parsing JSON response: ", e);
                            console.error("Raw Response Text: ", responseText);
                            // Display error message with SweetAlert for unexpected errors
                            Swal.fire({
                                title: "Error!",
                                text: "An unexpected error occurred. Please try again later.",
                                icon: "error"
                            });
                        }
                    } else {
                        console.error("HTTP Error: ", xhr.status);
                        // Display error message with SweetAlert for HTTP errors
                        Swal.fire({
                            title: "Error!",
                            text: "Error occurred. Status: " + xhr.status,
                            icon: "error"
                        });
                    }
                }
            };

            xhr.send(formData); // Send the form data
        });
    } else {
        console.error("Rental form not found");
    }
});



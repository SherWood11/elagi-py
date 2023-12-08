<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $patientName = test_input($_POST['patientName']);
    $phoneNumber = test_input($_POST['phoneNumber']);
    $residence = test_input($_POST['residence']);
    $diagnosis = test_input($_POST['diagnosis']);
    $age = test_input($_POST['age']);

    // Validate form data (add more validation if needed)
    if (empty($patientName) || empty($phoneNumber) || empty($residence) || empty($diagnosis) || empty($age)) {
        die("All fields are required");
    }

    // Save data to the database (replace with your database connection code)
    $servername = "your_server_name";
    $username = "your_username";
    $password = "your_password";
    $dbname = "your_database_name";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO patient_data (patientName, phoneNumber, residence, diagnosis, age)
            VALUES ('$patientName', '$phoneNumber', '$residence', '$diagnosis', $age)";

    if ($conn->query($sql) !== TRUE) {
        die("Error: " . $sql . "<br>" . $conn->error);
    }

    // Close the database connection
    $conn->close();

    // Send email notification
    $to = "sherwedahmed1@gmail.com";
    $subject = "New Patient Information";
    $message = "A new patient has submitted information.\n\n"
             . "Patient Name: $patientName\n"
             . "Phone Number: $phoneNumber\n"
             . "Place of Residence: $residence\n"
             . "Medical Diagnosis: $diagnosis\n"
             . "Age: $age\n";

    mail($to, $subject, $message);

    echo "Data submitted successfully!";
} else {
    // Handle invalid request method
    echo "Invalid request method";
}

// Function to sanitize input data
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

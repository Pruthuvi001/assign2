<!DOCTYPE html>
<html lang="">
<head>
	<meta charset="utf-8">
	<meta name="description"	content="COS10026 Assignment 2">
	<meta name="keywords"		content="Swinburne COS10026 Assignment 2">	
</head>
<body>
<?php
require_once ("settings.php");	
	$conn = @mysqli_connect($host,$user,$pwd,$sql_db);
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $jobReferenceNumber = $_POST["job_reference_number"];
    $firstName = $_POST["first_name"];
    $lastName = $_POST["last_name"];
    $dateOfBirth = $_POST["date_of_birth"];
    $gender = $_POST["gender"];
    $streetAddress = $_POST["street_address"];
    $suburbTown = $_POST["suburb_town"];
    $state = $_POST["state"];
    $postcode = $_POST["postcode"];
    $emailAddress = $_POST["email_address"];
    $phoneNumber = $_POST["phone_number"];
    $requiredSkills = isset($_POST["required_skills"]) ? implode(', ', $_POST["required_skills"]) : "";
    $otherSkills = $_POST["other_skills"];
    
    $errors = [];

    if (!preg_match('/^[A-Za-z0-9]{5}$/', $jobReferenceNumber)) {
        $errors[] = "Job reference number must be exactly 5 alphanumeric characters.";
    }

    if (strlen($firstName) > 20 || !preg_match('/^[A-Za-z]+$/', $firstName)) {
        $errors[] = "First name must be max 20 alpha characters.";
    }

    if (strlen($lastName) > 20 || !preg_match('/^[A-Za-z]+$/', $lastName)) {
        $errors[] = "Last name must be max 20 alpha characters.";
    }

    $dobParts = explode("/", $dateOfBirth);
    if (count($dobParts) === 3) {
        list($day, $month, $year) = $dobParts;
        if (!checkdate($month, $day, $year) || $year < date("Y") - 80 || $year > date("Y") - 15) {
            $errors[] = "Invalid date of birth.";
        }
    } else {
        $errors[] = "Invalid date of birth format.";
    }

    if (!filter_var($emailAddress, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email address format.";
    }
        $createTableSQL = "CREATE TABLE IF NOT EXISTS EOInumber (
            id INT AUTO_INCREMENT PRIMARY KEY,
            job_reference_number VARCHAR(5) NOT NULL,
            first_name VARCHAR(20) NOT NULL,
            last_name VARCHAR(20) NOT NULL,
            date_of_birth DATE,
            gender ENUM('Male', 'Female', 'Other'),
            street_address VARCHAR(40),
            suburb_town VARCHAR(40),
            state ENUM('VIC', 'NSW', 'QLD', 'NT', 'WA', 'SA', 'TAS', 'ACT'),
            postcode CHAR(4),
            email_address VARCHAR(255),
            phone_number VARCHAR(20),
            required_skills VARCHAR(255),
            other_skills TEXT
        )";

        if ($conn->query($createTableSQL) === TRUE) {
            // Insert data into the EOI table
            $insertSQL = "INSERT INTO EOInumber (job_reference_number, first_name, last_name, date_of_birth, gender, street_address, suburb_town, state, postcode, email_address, phone_number, required_skills, other_skills)
            VALUES ('$jobReferenceNumber', '$firstName', '$lastName', '$dateOfBirth', '$gender', '$streetAddress', '$suburbTown', '$state', '$postcode', '$emailAddress', '$phoneNumber', '$requiredSkills', '$otherSkills')";

            if ($conn->query($insertSQL) === TRUE) {
                $autoGeneratedID = $conn->insert_id;
                echo "<h2>EOI submitted successfully!</h2>";
                echo "<p>Your unique EOInumber: $autoGeneratedID</p>";
            } else {
                echo "Error: " . $
</body>
</html>
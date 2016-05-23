<?php 
$mysqli = new mysqli("localhost", "sienasel_iat", "SienaIAT!", "sienasel_iat");

if ($mysqli->connect_errno) {
    echo "Connect failed: ".$mysqli->connect_error;
    exit();
}

/* check connection 
if ($mysqli->connect_errno) {
    printf("Connect failed: %s\n", $mysqli->connect_error);
    exit();
}

// Create table doesn't return a resultset * /
if ($mysqli->query("CREATE TABLE MyGuests (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
firstname VARCHAR(30) NOT NULL,
lastname VARCHAR(30) NOT NULL,
email VARCHAR(50),
reg_date TIMESTAMP
)") === TRUE) {
    printf("Table successfully created.\n");
}

// Select queries return a resultset * /
if ($result = $mysqli->query("SELECT firstname FROM MyGuests")) {
    printf("Select returned %d rows.\n", $result->num_rows);

    // free result set * /
    $result->close();
}*/



?>
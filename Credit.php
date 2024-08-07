<?php
$servername = "localhost";  // Change this if your database is hosted elsewhere
$username = "root";         // Database username
$password = "Suma@2004";             // Database password
$dbname = "banking";           // Database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST['user_id'];
    $deposit_amount = $_POST['amount'];

    // Retrieve the current balance
    $sql = "SELECT balance FROM transactions WHERE id = $user_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch the current balance
        $row = $result->fetch_assoc();
        $current_balance = $row['balance'];

        if ($deposit_amount > 0) {
            // Calculate new balance
            $new_balance = $current_balance + $deposit_amount;

            // Update the balance in the database
            $sql = "UPDATE transactions SET balance = $new_balance WHERE id = $user_id";

            if ($conn->query($sql) === TRUE) {
                echo "<p>Deposit successful! New balance: Rs." . $new_balance . "</p>";
            } else {
                echo "<p>Error updating record: " . $conn->error . "</p>";
            }
        } else {
            echo "<p>Invalid amount. Please enter a value greater than zero.</p>";
        }
    } else {
        echo "<p>Invalid user ID. Please ensure the user ID exists.</p>";
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deposit Money</title>
</head>
<body>
    <link rel="Stylesheet" href="Credit.css">
    <section id="main">
    <nav>
        <lable class="logo" ><a href="#" style="color: aliceblue"><b>Money-Deposit</b></a></lable>
        <ul> 
         <li><a  class="active" href="Index.html" style="color: aliceblue"><b>Home</b></a></li>
         <li><a href="Transactions.html" style="color: aliceblue"><b>Back</b></a></li>
         </ul>
         </nav>
    <form method="POST" >
        <label for="user_id">User ID      :</label>
        <input type="number" id="user_id" name="user_id" min="1" required autofocus>
        <br><br>
        <label for="amount">Amount to Deposit    :</label>
        <input type="number" id="amount" name="amount" min="1" required>
        <br><br>
        <button type="submit">Deposit</button>
    </form>
</section>
</body>
</html>
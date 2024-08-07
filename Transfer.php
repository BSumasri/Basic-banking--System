
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
    $from_user_id = $_POST['from_user'];
    $to_user_id = $_POST['to_user'];
    $transfer_amount = $_POST['amount'];

    // Check if both users exist and get their balances
    $sql = "SELECT id, balance FROM transactions WHERE id IN ($from_user_id, $to_user_id)";
    $result = $conn->query($sql);

    if ($result->num_rows == 2) {
        // Fetch balances
        while ($row = $result->fetch_assoc()) {
            if ($row['id'] == $from_user_id) {
                $from_user_balance = $row['balance'];
            }
            if ($row['id'] == $to_user_id) {
                $to_user_balance = $row['balance'];
            }
        }

        if ($transfer_amount > 0 && $transfer_amount <= $from_user_balance) {
            // Calculate new balances
            $new_from_user_balance = $from_user_balance - $transfer_amount;
            $new_to_user_balance = $to_user_balance + $transfer_amount;

            // Update the balances in the database
            $conn->begin_transaction();

            try {
                $sql = "UPDATE transactions SET balance = $new_from_user_balance WHERE id = $from_user_id";
                $conn->query($sql);

                $sql = "UPDATE transactions SET balance = $new_to_user_balance WHERE id = $to_user_id";
                $conn->query($sql);

                $conn->commit();

                echo "<p>Transfer successful! New balances:</p>";
                echo "<p>From User (ID $from_user_id): Rs" . $new_from_user_balance . "</p>";
                echo "<p>To User (ID $to_user_id): Rs" . $new_to_user_balance . "</p>";
            } catch (Exception $e) {
                $conn->rollback();
                echo "<p>Error during transfer: " . $e->getMessage() . "</p>";
            }
        } else {
            echo "<p>Invalid amount. Please enter a value less than or equal to the balance of the from user.</p>";
        }
    } else {
        echo "<p>Invalid user IDs. Please ensure both user IDs exist.</p>";
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transfer Money</title>
</head>
<body>
<link rel="Stylesheet" href="Transfer.css">
    <section id="main">
    <nav>
        <lable class="logo" ><a href="#" style="color: aliceblue"><b>Money-Transfer</b></a></lable>
        <ul> 
         <li><a  class="active" href="Index.html" style="color: aliceblue"><b>Home</b></a></li>
         <li><a href="Transactions.html" style="color: aliceblue"><b>Back</b></a></li>
         <li><a href="Viewdetails.php" style="color: aliceblue"><b>User-Details</b></a></li>
         </ul>
         </nav>
    <form action="transfer.php" method="POST">
        <label for="from_user">From User ID:</label>
        <input type="number" id="from_user" name="from_user" min="1" required>
        <br><br>
        <label for="to_user">To User ID:</label>
        <input type="number" id="to_user" name="to_user" min="1" required>
        <br><br>
        <label for="amount">Amount to Transfer:</label>
        <input type="number" id="amount" name="amount" min="1" required>
        <br><br>
        <button type="submit">Transfer</button>
    </form>


</section>
</body>
</html>
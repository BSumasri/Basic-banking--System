
<?php
$pw ="Suma@2004";
$Conn = new mysqli('localhost','root',$pw,'banking');
if($Conn->connect_error)
{
echo  $Conn->connect_error;
die("Connection failed:".$Conn->connect_error);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
$cname=$_POST['cname'];
$cid=$_POST['uid'];
$withdraw_amount=$_POST['amount'];
$sql = "SELECT balance FROM transactions WHERE id = $cid";  // Assuming user ID is 1
    $result = $Conn->query($sql);
    if ($result->num_rows > 0)
     {
        // Fetch the current balance
        $row = $result->fetch_assoc();
        $current_balance = $row['balance'];
        if ($withdraw_amount > 0 && $withdraw_amount <= $current_balance)
         {
            // Calculate new balance
            $new_balance = $current_balance - $withdraw_amount;

            // Update the balance in the database
            $sql = "UPDATE transactions SET balance = $new_balance WHERE  id = $cid";

            if ($Conn->query($sql) === TRUE) {
                echo "<p>Withdrawal successful! $cid New balance:  " . $new_balance . " .Rs Only </p>";
            } 
            else {
                echo "<p>Error updating record: " . $conn->error . "</p>";
            }
        } 
    else
    {
            echo "<p>Invalid amount. Please enter a value less than or equal to your current balance.</p>";
    }
}
    else 
    {
        echo "<p>No user found.</p>";
    }
}
?>
<html>
<head>
    <title>Withdraw money</title>
</head>
<body>
<link rel="Stylesheet" href="Withdraw.css">
    <section id="main">
    <nav>
        <lable class="logo" ><a href="#" style="color: aliceblue"><b>Money-Withdrawal</b></a></lable>
        <ul> 
         <li><a  class="active" href="Index.html" style="color: aliceblue"><b>Home</b></a></li>
         <li><a href="Transactions.html" style="color: aliceblue"><b>Back</b></a></li>
         </ul>
         </nav>
<form method ='Post'>
    <lable>Enter Customer Name  :</lable>
  <input type="text" name="cname" require autofocus/> <br/> <br/>
  <lable>Enter User Id :</lable>
  <input type="number" name="uid" require/><br/> <br/>
  <lable>Enter Ammount to be Debited :</lable>
  <input type="number" id="amount" name="amount" require/><br/> <br/>
  <button>Withdraw</button>
</form>
</section>
</body>
</html>

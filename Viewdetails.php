<html>
<head>
<title>Customer details</title>
</head>
<body>
<link rel="Stylesheet" href="viewdetails.css">
   <section id="main">
    <nav>
        <lable class="logo" ><a href="#" style="color: aliceblue"><b>Customer-Details</b></a></lable>
        <ul> 
         <li><a  class="active" href="Index.html" style="color: aliceblue"><b>Home</b></a></li>
         <li><a href="contact.html" style="color: aliceblue"><b>Contact</b></a></li>
         <li><a href="Transfer.php" style="color: aliceblue"><b>Money-Transfer</b></a></li>
         </ul>
         </nav>
         
         <?php
$pw ="Suma@2004";
$Conn = new mysqli('localhost','root',$pw,'banking');
if($Conn->connect_error)
{
echo  $Conn->connect_error;
die("Connection failed:".$Conn->connect_error);
}
else
{
    $query="select * from transactions;";
    $result = $Conn->query($query);

    if ($result->num_rows>0)
    {
        while ($row = $result->fetch_assoc())
        {
      echo "User Id:". $row["id"]."   -   "."Customer Name:". $row["Customername"]."   -   "."Email Id:" .$row["email"]."  -   "."Phone Number:".$row["phonenumber"]."   -  "."Balance:".$row["Balance"]."<br/>";
        }
  }
    else
    {
       echo"0 results";
    }
    $Conn->close();
}
?>

</section>
</body>
</html>
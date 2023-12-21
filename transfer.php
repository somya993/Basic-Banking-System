<!--
	This is Html souce code od bank system for intrenship of Spark Foundation
	The Code is written by me (Prathamesh Chougule)
 -->
<!DOCTYPE html>
<html>
<head> 
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!--header -->
        <link rel="stylesheet" type="text/css" href="css\header.css">
        <!--footer -->
        <link rel="stylesheet" type="text/css" href="css\footer.css">
        <!--main css  -->
        <link rel="stylesheet" type="text/css" href="css\customer.css">
        <link rel="stylesheet" type="text/css" href="css\transfer.css">
        <!--external  -->
        <script src="https://kit.fontawesome.com/29d0d4479a.js" crossorigin="anonymous"></script>
</head>
 
     <title>SPARK BANK | Transfer Money</title>
 
 <body>
 <header>
 <!--navbar-->
 <div id="navbar">
 <nav>
      <div class="logo"><img src="bank.svg"></div>
         <input type="checkbox" id="click">
          <label for="click" class="menu-btn">
                 <i class="fas fa-bars"></i>
           </label>
         <ul>
            <li><a href="index.html">Home</a></li>
 
            <li><a href="aboutme.html">About</a></li>

			<li><a href="contactus.html">Contact US</a></li>
         </ul>
     </div>
 </nav>
 </div>
 </header>
 <!--nav end header end-->
 <!--main section-->
<div class="title-transfer">
    <h2>Customer Details</h2>
</div>
<!--php code-->
<?php
    

    $server="localhost";
    $username="root";
    $password="";
    $db="banksystem";
    
    $conn=mysqli_connect($server,$username,$password,$db);
    
    if (!$conn) {
        die("Connection failed: ". mysqli_connect_error());
    }
    
    
    if(isset($_POST['submit']))
    {
        $from = mysqli_real_escape_string($conn, $_GET['id']);
        $to = mysqli_real_escape_string($conn, $_POST['to']);
        $amount = mysqli_real_escape_string($conn, $_POST['amount']);

        $sql = "SELECT * from users where id=$from";
        $query = mysqli_query($conn,$sql);
        $sql1 = mysqli_fetch_array($query); 

        $sql = "SELECT * from users where id=$to";
        $query = mysqli_query($conn,$sql);
        $sql2 = mysqli_fetch_array($query);

        if($amount > $sql1['balance']) 
        {
            echo '<script type="text/javascript">';
            echo ' alert("Insufficient Balance")'; //alert box
            echo '</script>';
        }
        else if($amount == 0)
        {
            echo "<script type='text/javascript'>";
            echo "alert('Select Amount more than 0')"; //alert box
            echo "</script>";
        }
        else 
        {
            $newbalance = $sql1['balance'] - $amount; // deducting balance from sender's account
            $sql = "UPDATE users set balance=$newbalance where id=$from";
            mysqli_query($conn,$sql);
                    
            $newbalance = $sql2['balance'] + $amount; // adding balance to reciever's account
            $sql = "UPDATE users set balance=$newbalance where id=$to";
            mysqli_query($conn,$sql);
            

            $sender = $sql1['name'];
            $receiver = $sql2['name'];
            $sql = "INSERT INTO `transaction` (`sender`, `receiver`, `balance`, `datetime`) VALUES ('$sender','$receiver','$amount',current_timestamp())";
            $query=mysqli_query($conn,$sql);


            echo "<script> alert('Money Transfered Successfuly');
                window.location='transferhistory.php';
                </script>";             
            
            $newbalance= 0;
            $amount =0;
        } 
    }
    
     

    $sid = isset($_GET['id']) ? $_GET['id'] : 0; // Default to 0 or any suitable default value

    $sql = "SELECT * FROM users WHERE id=$sid";
    
    $result=mysqli_query($conn,$sql);
    if ($result) {
        $rows = mysqli_fetch_assoc($result);
    
        // Check if $rows is not null before accessing its elements
        if ($rows !== null) {
            // Access array elements here
            $id = $rows['id'];
            $name = $rows['name'];
            $email = $rows['email'];
            $balance = $rows['balance'];
    
            // Use these variables in your HTML or further processing
        } else {
            // Handle the case where no rows are fetched
            echo "No rows fetched from the database.";
        }
    } else {
        // Handle the case where the query fails
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
?>
<form method="post" name="tcredit" class="tabletext" ><br>
    <div>
        <table class="table table-striped table-condensed table-bordered">
            <tr>
                <th class="text-center">Id</th>
                <th class="text-center">Name</th>
                <th class="text-center">Email</th>
                <th class="text-center">Balance</th>
            </tr>
            <tr>
                <td class="py-2"><?php echo isset($rows['id']) ? $rows['id'] : 'N/A'; ?></td>
                <td class="py-2"><?php echo isset($rows['name']) ? $rows['name'] : 'N/A'; ?></td>
                <td class="py-2"><?php echo isset($rows['email']) ? $rows['email'] : 'N/A'; ?></td>
                <td class="py-2"><?php echo isset($rows['balance']) ? $rows['balance'] : 'N/A'; ?></td>
            </tr>

        </table>
    </div>
    <br>
    <div class="title">
    <h3>Transfer Money</h3>
    </div>
    <div class=container-transfer>
        <div class="transferto">
            <label>Transfer To:</label>
                    <select name="to" class="form-control" required>
                        <option value="" disabled selected>Select Reciver  ..</option>
                        <?php
                            
                            $server="localhost";
                            $username="root";
                            $password="";
                            $db="banksystem";
                            
                            $conn=mysqli_connect($server,$username,$password,$db);
                            
                            if($conn){
                            //Connection successfully established
                            }
                        
                            else
                                die("connection to this database failed due to " .mysqli_connect_error()); //connection not establised
                    
                            $sid=$_GET['id'];
                            $sql = "SELECT * FROM users where id!=$sid";
                            $result=mysqli_query($conn,$sql);
                            if(!$result)
                            {
                                echo "Error ".$sql."<br>".mysqli_error($conn);
                            }
                            while($rows = mysqli_fetch_assoc($result)) {
                        ?>
                        <option class="table" value="<?php echo $rows['id'];?>" >
                            <?php echo $rows['name'] ;?>
                        </option>
                        <?php 
                            } 
                        ?>
                    </select>
                </div>
            <div class="amount">        
                <label>Amount:</label>
                <input type="number" value="Enter Amount" class="form-control" name="amount" required>   
                <br><br>
                <button class="btn btn-primary" name="submit" type="submit" id="btn">Transfer</button>
            </div>
    </div>    
</form>
<!--end Main-->
 <!--footer-->
 <footer>
 <div class="footer">
     <!--footer centre-->
     <div class="footer-center">
         <p class="footer-company-name">© SPARK BANK 2023 | Designed by Somya Gupta</p>
                 
     </div>		
 </div>
 </footer>	
 <!--end footer-->
 </body>
 </html>

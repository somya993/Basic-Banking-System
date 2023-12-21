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
        <link rel="stylesheet" type="text/css" href="css\transferhistory.css">
        <!--external  -->
        <script src="https://kit.fontawesome.com/29d0d4479a.js" crossorigin="anonymous"></script> 
</head>
 
     <title>SPARK BANK | Transfer History</title>
 
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

 <div class="container">
    <div class="main">
		<a href="index.html"><button>GOTO Home</button></a>	    
		<a href="customer.php"><button>View Customers</button></a>	
	</div>
    <div class="title">
        <h2>Transactions</h2>
    </div>
        <table>
        <tr>
        <th>Sender</th>
        <th>Reciever</th>
        <th>Balance</th>
        <th>Date-Time</th>
        </tr>
        <?php
            $conn = mysqli_connect("localhost", "root", "", "banksystem");
            // Check connection
            if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
            }
            $sql = "SELECT * FROM banksystem.transaction";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
            // output data of each row
                while($row = $result->fetch_assoc()) {
       
                    echo '<tr>';
                    echo '<td>'.$row['sender'].'</td>';
                    echo '<td>'.$row['receiver'].'</td>';
                    echo '<td>'.$row['balance'].'</td>';
                    echo '<td>'.$row['datetime'].'</td>';
                    echo '</tr>';
        
                }
                echo "</table>";
            } else { echo "0 results"; }
            $conn->close();
        ?>
    </table>

</div>

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
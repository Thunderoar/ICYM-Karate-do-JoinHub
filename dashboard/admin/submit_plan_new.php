<?php
require '../../include/db_conn.php';
page_protect();

	$planid =$_POST['planid'];
    $name = $_POST['planname'];
    $desc = $_POST['desc'];
    //$planval = $_POST['planval'];
    $planType = $_POST['plantype'];
    $amount = $_POST['amount'];

    
   //Inserting data into plan table
    $query="insert into plan(planid,planName,description,planType,amount,active) values('$planid','$name','$desc','$planType','$amount','yes')";
   
   

	 if(mysqli_query($con,$query)==1){
        
        echo "<head><script>alert('PLAN Added ');</script></head></html>";
        echo "<meta http-equiv='refresh' content='0; url=view_plan.php'>";
       
      }

    else{
        echo "<head><script>alert('NOT SUCCESSFUL, Check Again');</script></head></html>";
        echo "error".mysqli_error($con);
      }

?>

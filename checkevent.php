<?php
     include 'connection.php';
     header('Access-Control-Allow-Origin: *');
	 $response=array();
if($con){

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
     function test_input($data) {
				  global $con;
				  global $response;
  				$data = trim($data);
  				$data = stripslashes($data);
  				$data = htmlspecialchars($data);
				$data = mysqli_real_escape_string($con,$data);
  				return $data;
			}

     function result($status,$msg){
				global $response;
				global $con;
				mysqli_close($con);
				$response['statuscode']=$status;
				$response['msg']=$msg;
				echo json_encode($response);
			}

             $postdata=file_get_contents("php://input");
	         $postdata=json_decode($postdata,true);
	         $UID=test_input($_POST['userId']);
             $event_type=test_input($_POST['event_type']);
             $sql="SELECT * FROM eventregister WHERE reg_no='$UID' and event_type='$event_type'";
             $query = mysqli_query($con,$sql);
		         $count = mysqli_num_rows($query);
		         if ($count>=2 && $event_type=='track') {
			         result(0,'You are already registered with Two Track Events');  
                    }
                    else if($count>=2 && $event_type=='field'){
                    result(0,'You are already registered with Two Field Events'); 
                    }
		          else{ 
                     result(0,'success');
                    }
    }
    }else{
		die("Connection failed: " . mysqli_connect_error());
	}

?>
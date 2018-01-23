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
             $password=test_input($_POST['password']);
             $sql="SELECT id,reg_no,password FROM usertable WHERE reg_no='$UID' and password='$password'";
             $query = mysqli_query($con,$sql);
		         $count = mysqli_num_rows($query);
		         if ($count == 0) {
			         result(0,'Invalid username or Password');  
                    }
		          else{ 
					   $query="SELECT id,Stu_name,Stu_school,Stu_section,reg_no FROM usertable WHERE reg_no='$UID'";
					   $result = mysqli_query($con,$query);
                       while($row=mysqli_fetch_assoc($result)){
                        $data[]=$row; 
                     }
                       mysqli_close($con);
				       $response['data']=$data;
				       $response['statuscode']=1;
				       echo json_encode($response);
					   }
    }
    }else{
		die("Connection failed: " . mysqli_connect_error());
	}

?>
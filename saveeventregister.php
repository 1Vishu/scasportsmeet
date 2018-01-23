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
       $UID=test_input($_POST['reg_no']);
       $student_name=test_input($_POST['student_name']);
       $student_school=test_input($_POST['student_school']);
       $student_section=test_input($_POST['student_section']);
       $event_discription=test_input($_POST['discription']);
       $doe=test_input($_POST['date']);
	   $event_name=test_input($_POST['event_name']);
	   $event_type=test_input($_POST['event_type']);
	   $place=test_input($_POST['place']);
	   $is_register=test_input($_POST['is_register']);
       $sql = "INSERT INTO eventregister (event_name,doe,place,event_discription,reg_no,stu_name,stu_section,event_type,is_register) 
                         VALUES ('$event_name','$doe','$place','$event_discription','$UID','$student_name','$student_section','$event_type','$is_register')";
							if(mysqli_query($con,$sql)){
								result(1,"success");
							}else{
								result(0,$sql);
							}
				}   
    }else{
		die("Connection failed: " . mysqli_connect_error());
	}
?>


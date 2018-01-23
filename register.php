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
       $name=test_input($_POST['name']);
       $contact=test_input($_POST['phone']);
       $section=test_input($_POST['section']);
       $regno=test_input($_POST['regno']);
       $gender=test_input($_POST['gender']);
       $schoolname=test_input($_POST['schoolname']);
       $query="SELECT reg_no FROM usertable WHERE reg_no ='$regno'";     
        if($result=mysqli_query($con,$query)){
				if(mysqli_num_rows($result)>0){
					 result(0,"Registeration Number is already used");
				}
				else{
				
				      $sql = "INSERT INTO usertable (Stu_name,reg_no,Stu_section,Stu_school,contact_no,gender) 
                         VALUES ('$name','$regno','$section','$schoolname','$contact','$gender')";
							if(mysqli_query($con,$sql)){
								result(1,"success");
							}else{
								result(0,"fail");
							}
					
					}
				}
			}   
    }else{
		die("Connection failed: " . mysqli_connect_error());
	}
?>


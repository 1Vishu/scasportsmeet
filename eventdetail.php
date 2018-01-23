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
       $event_id=test_input($_POST['event_id']);
       $query="SELECT id,event_name,event_description,event_type,doe,place,event_imgurl From eventtable WHERE id='$event_id' AND is_active=1";    
        if($result=mysqli_query($con,$query)){
				if(mysqli_num_rows($result)<=0){
					 result(0,"No Events");
				}
				else{
				
                     while($row=mysqli_fetch_assoc($result)){
                        $data[]=$row; 
                     }
                       mysqli_close($con);
				       $response['data']=$data;
				       $response['statuscode']=1;
				       echo json_encode($response);
					
					}
				}
			}   
    }else{
		die("Connection failed: " . mysqli_connect_error());
	}
?>


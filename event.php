<?php
include 'connection.php';
     header('Access-Control-Allow-Origin: *');
     $data=array();
	 $response=array();
     if($con){
         if($_SERVER['REQUEST_METHOD'] == 'GET'){
             $query="SELECT id,event_name,event_description,event_type,doe,place,event_imgurl From eventtable WHERE is_active=1";
             $result=mysqli_query($con,$query);
             if(mysqli_num_rows($result) > 0){
                 while($row=mysqli_fetch_assoc($result)){
                     $data[]=$row; 
                 }
                 mysqli_close($con);
				 $response['data']=$data;
				 $response['statuscode']=1;
				 echo json_encode($response);
             }else{
				$response['data']=[];
				$response['statuscode']=0;
				echo json_encode($response);
			}   
         }

     }else{
		die("Connection failed: " . mysqli_connect_error());
	}
?>
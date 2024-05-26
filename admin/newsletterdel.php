<?php

include ('db.php');

$id=$_GET['eid'];
if($id=="")
{
echo '<script>alert("Lấy làm tiếc ! Nhập sai") </script>' ;
		header("Location: messages.php");


}

else{
$view="DELETE FROM `contact` WHERE id ='$id' ";

	if($re = mysqli_query($con,$view))
	{
		echo '<script>alert("Người đăng ký nhận thư tin tức Xóa") </script>' ;
		header("Location: messages.php");
	}


}







?>
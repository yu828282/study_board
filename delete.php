<?php
	include ("./connect.php");  

	$sql = "DELETE FROM st_board WHERE number = ".$_GET["number"]." ";  
  $result = mysqli_query($conn,$sql);  //연결객체 conn을 통해 쿼리 실행 
 
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>삭제하기</title>
</head>
<body>
<script type="text/javascript">alert("삭제되었습니다.");</script>
<a href="./list.php">[목록으로]</a>

</body>
</html>


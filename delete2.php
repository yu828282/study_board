<?php
	include ("./connect.php");  

  $sql = "UPDATE st_board SET delete_2 = 'yes' where number = ".$_GET["number"].""; 
  $result = mysqli_query($conn,$sql);  //연결객체 conn을 통해 쿼리 실행 
 
?>
<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>안보이게하기</title>
</head>
<body>
<script type="text/javascript">alert("안 보이게 되었습니다.");</script>
<a href="./list.php">[목록으로]</a>

</body>
</html>


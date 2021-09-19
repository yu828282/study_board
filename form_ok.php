<?php
include ("./connect.php");  

$date = date('Y-m-d H:i:s');  

$sql = "INSERT INTO st_board (title, writer, content, date) VALUES ('".$_POST['title']."', '".$_SESSION['user_id']."', '".$_POST['content']."', '".$date."')"; // sql 에 담아 놓고 
$result = mysqli_query($conn, $sql);// 데이터베이스에 접속해 sql에 내용 담기 

  print "[입력한 내용]<br><br>";
  print "제목 : ".$_POST['title']."<br>";
  print "작성자 : ".$_SESSION['user_id']."<br>";
  print "내용 : ".$_POST['content']."<br>";
  print "시간 : ".$date."<br>";

if($result == false){  
  echo "<script> alert('내용을 저장하지 못했습니다.'); </script>"; 
}else{
  echo"<script> alert('저장했습니다.'); </script>"; 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>게시글 올리기</title>
</head>
<body>
  <div style="text-align:center; padding-top:10px">
      <a href="./list.php">게시판으로 가기</a>
  </div>
</body>
</html>




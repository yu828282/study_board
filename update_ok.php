<?php
include ("./connect.php");  
 
$sql = "UPDATE st_board SET title = '".$_POST['title']."', writer = '".$_POST['writer']."', content = '".$_POST['content']."' WHERE number = '".$_GET['number']."' "; 
$result = mysqli_query($conn, $sql); 

print "<hr><br>[수정한 내용]<br>";
print "제목 : " .$_POST['title']. "<br>";
print "작성자 : " .$_POST['writer']. "<br>";
print "내용 : " .$_POST['content']. "<br>";

if($result == false){  
  echo "<script> alert('내용을 수정하지 못했습니다.'); </script>"; 
}else{
  echo"<script> alert('수정했습니다.'); </script>"; 
}
?>

<!DOCTYPE html>
<html lang="ko">
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
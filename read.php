<?php 
	include ("./connect.php");  
 
  $sql = "SELECT * FROM st_board WHERE number = ".$_GET["number"]." ORDER BY number DESC";
  $result = mysqli_query($conn,$sql);  //연결객체 conn을 통해 쿼리 실행
  $row = mysqli_fetch_array($result); //레코드를 1개씩 리턴하는 함수

  $hit = "UPDATE st_board SET view = view+1 WHERE number = ".$_GET["number"]." ";  
  $result = mysqli_query($conn,$hit); //쿼리 재실행해 조회수 업데이트
?>

<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $row["title"];?></title>
</head>
<body> 
  <div>
    <h2>제목 : <?php echo $row['title']; ?></h2> 
    작성자 : <?php echo $row['writer'] . "</br>"; ?> 
    시간 : <?php echo $row['date'] . "</br>"; ?>  
    조회 : <?php echo $row['view'] . "</br>"; ?>  
    <h2>내용 : <?php echo nl2br("$row[content]") . "</br>"; ?> </h2> 
    <a href="./list.php">[목록으로]</a>
    <a href="./update.php?number=<?php echo $row["number"]; ?>" >[수정하기]</a> 
    <a href="./delete.php?number=<?php echo $row["number"]; ?>" >[삭제하기]</a> 
    <a href="./delete2.php?number=<?php echo $row["number"]; ?>" >[안보이게하기]</a> 
  </div>  
</body>
</html> 



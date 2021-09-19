<?php
	include ("./connect.php"); 

  session_start();   

  $sql = "SELECT * FROM st_board WHERE number = ".$_GET["number"]." ORDER BY number DESC";
  $result = mysqli_query($conn,$sql);  //연결객체 conn을 통해 쿼리 실행
  $row = mysqli_fetch_array($result); //레코드를 1개씩 리턴하는 함수  
 
  if($_SESSION['user_id'] != $row['writer']){
    echo '<script> alert("권한이 없습니다."); history.back(); </script>';
  }
?>

<html>
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>글수정하기</title>
</head>
<body>
  <div style="text-align:center; padding-top:10px">
    <h1>글수정</h1>
  </div>
  <form method = "post" action = "update_ok.php?number=<?php echo $_GET["number"] ?>">  
    <table align = center> 
      <tr>
        <td>제목</td>
        <td><input type = text name = title size=82 value="<?php echo $row['title'];?>"></td>
      </tr>       
      <tr>
        <td>작성자</td>
        <td><input type="hidden" name="name" value="<?=$_SESSION['user_id']?>"><?=$_SESSION['user_id']?></td> 
      </tr> 
      <tr>
        <td>내용</td>
        <td><textarea name = content cols=84 rows=15><?php echo $row['content']; ?></textarea></td>
      </tr>
      <tr>
  	    <td align=center colspan=2><input type=submit value=수정></td>
    	</tr>
    </table>
  </form> 
  <div style="text-align:center; padding-top:10px">
    <a href="./list.php">게시판으로 가기</a> 
  </div>
</body>
</html>
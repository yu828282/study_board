<?php
session_start();

if(!isset($_SESSION['user_id'])) {
  echo '<script> alert("로그인 해주세요."); history.back(); </script>';
}

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>글쓰기</title>
</head>
<body>
  <div style="text-align:center; padding-top:10px">
    <h1>글작성</h1>
  </div>
  <form method = "post" action = "form_ok.php">  
    <table align = center> 
      <tr>
        <td>제목</td>
        <td><input type = text name = title size=82></td>
      </tr>       
      <tr>
        <td>작성자</td>
        <td><input type="hidden" name="name" value="<?=$_SESSION['user_id']?>"><?=$_SESSION['user_id']?></td> 
      </tr> 
      <tr>
        <td>내용</td>
        <td><textarea name = content cols=84 rows=15></textarea></td>
      </tr>
      <tr>
  	    <td align=center colspan=2><input type=submit value=전송></td>
    	</tr>
    </table>
  </form> 
  <div style="text-align:center; padding-top:10px">
    <a href="./list.php">게시판으로 가기</a>
  </div>
</body>
</html>
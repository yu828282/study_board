<?php
include ("./connect.php");  

$user_address = "(".$_POST['user_zip'] . ") " . $_POST['user_ad'] . ", " . $_POST['user_add'];
$date = date('Y-m-d H:i:s');

$sql = "INSERT INTO st_member (id, name, pw, address, date) VALUES ('".$_POST['user_id']."', '".$_POST['user_name']."', '".$_POST['user_pw']."', '".$user_address."', '".$date."')"; // sql 에 담아 놓고 
$result = mysqli_query($conn, $sql);// 데이터베이스에 접속해 sql에 내용 담기   

print "[입력한 내용]<br><br>";
print "ID : ".$_POST['user_id']."<br>";
print "이름 : ".$_POST['user_name']."<br>";
print "비밀번호 : ".$_POST['user_pw']."<br>";
print "주소 : ".$user_address."<br>";
print "가입 시간 : ".$date."<br>";

if($result == false) {
  echo "<script> alert('내용을 저장하지 못했습니다.'); </script>"; 
}else{
  echo"<script> alert('저장했습니다.'); </script>";  
}
?> 
<br><a href="./list.php">[게시판으로]</a>
<a href="./list.php">[로그인]</a>



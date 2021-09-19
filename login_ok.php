<?php	
include ("./connect.php");  
session_start();

if($_POST['id'] == "" || $_POST['pw'] == ""){
  echo '<script> alert("아이디나 패스워드 입력하세요"); history.back(); </script>';
}else{ 
  $id = $_POST['id'];
  $pw = $_POST['pw'];

  $sql = "select * from st_member where id='$id'";
  $result = mysqli_query($conn, $sql);// 데이터베이스에 접속해 sql에 내용 담기  

}
if(mysqli_num_rows($result)==1){ // 아이디 있는지 확인
  $row=mysqli_fetch_assoc($result);

    if($row['pw']==$pw){ // 비밀번호 맞는지 확인 
      $_SESSION['user_id']=$id;

      if(isset($_SESSION['user_id'])){
        echo "<script>alert('로그인되었습니다.'); location.href='./list.php';</script>";
      }else{
        echo "<script>alert('아이디와 비밀번호를 확인하세요.'); history.back();</script>";
      }
    } 
}

?>
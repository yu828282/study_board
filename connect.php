<?php
  /*$host = "localhost";    //DB에 접속하기 위한 설정을 변수로 미리 선언
  $user = "wtwt";
  $pw = "123123";
  $dbName ="study";

  $db = new mysqli($host, $user, $pw, $dbName);*/

  $conn = new mysqli('localhost', 'wtwt', '123123', 'study');

  if($conn){echo "Connection established! 연결 잘 됩니다"."<br>"; }
  else{ die('Could not connect(연결 안됨): ' .mysqli_connect_error() ); }   //die()함수를 통해서 메시지를 보여주고 PHP를 종료 
  
  session_start();

?>
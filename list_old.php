<?php
  include ("./connect.php");

  $query = "select * from st_board";
  $result = mysqli_query($conn, $query);
   
  /*print_r($result);

    while($row=mysqli_fetch_array($result)){
    echo '<pre>';
    ob_start();
    print_r($row).PHP_EOL;
    echo htmlspecialchars(ob_get_clean());
    echo '</pre>'; 
    
    //echo "<xmp>".print_r($row,true)."</xmp>";
    //print_r($row).PHP_EOL;

  }*/


// 게시판 출력
$query = "select * from st_board"; //게시판 전체 보이게 하기
//$query = "select * from st_board ORDER BY writer DESC;"; // 내림차순
//$query = "select * from st_board ORDER BY writer ASC;";  //오름차순
//$query = "select * from st_board WHERE content LIKE '%안%'"; // 내용 중 '안'포함된 글만 보이게 하기

$result = mysqli_query($conn, $query);  

while ( $row = mysqli_fetch_assoc($result) ) {
    $rows[] = $row;
}
 
// 로우 개수 구하기
$query = "select COUNT(*) from st_board";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_array($result);
$total_rows = $row[0]; 
?> 

<h1>ROW 개수는 <?php echo $total_rows; ?>개 입니다. </h1>
</br>
<h1>st_board 게시판 </h1>
<hr>
<table border="2">
    <thead>
        <tr>
            <th>번호</th>
            <th>글쓴이</th>
            <th>날짜</th>
            <th>조회수</th>
            <th>제목</th>
            <th>내용</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($rows as $row) { ?>
        <tr>
            <td>
                <?=$row['number']?>
            </td>
            <td>
                <a href=#>
                    <?=$row['writer']?>
                </a>
            </td>
            <td>
                <?=$row['date']?>
            </td>
            <td>
                <?=$row['view']?>
            </td>
            <td>
                <?=$row['title']?>
            </td>
            <td>
                <?=$row['content']?>
            </td>
        </tr>
        <?php } ?>
    </tbody>


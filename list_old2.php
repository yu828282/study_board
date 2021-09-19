<?php
    $currentPage = 1; // https://lkg3796.tistory.com/62   https://blog.naver.com/PostView.nhn?isHttpsRedirect=true&blogId=bgpoilkj&logNo=221265496444
   
    if (isset($_GET["currentPage"])) {
        $currentPage = $_GET["currentPage"];
    }else {
		$currentPage = 1;
	}
    include ("./connect.php");      

    $sqlCount = "SELECT count(*) FROM st_board"; //테이블 내 전체 행 갯수 조회 쿼리
    $resultCount = mysqli_query($conn,$sqlCount);
    
    if($rowCount = mysqli_fetch_array($resultCount)){ //php는 지역 변수를 밖에서 사용 가능.
       $totalRowNum = $rowCount["count(*)"];  
    } 
    
    if($resultCount) { //행 갯수 조회 쿼리가 실행 됐는지 여부
        echo "행 갯수 조회 성공 : ". $totalRowNum."<br>"; 
    } else {
        echo "결과 없음: ".mysqli_error($conn);
    }
                
    $rowPerPage = 10;   //페이지당 보여줄 게시글
    $block_ct = 5; //블록당 보여줄 페이지 개수 

    $begin = ($currentPage -1) * $rowPerPage; 
    $sql = "SELECT * FROM st_board ORDER BY number DESC limit ".$begin.",".$rowPerPage.""; // 필드값을 내림차순으로 정렬해 가져옴, 행의 시작과 갯수가 매번 바뀌게 설정
    $result = mysqli_query($conn,$sql);  
 
    $block_num = ceil($currentPage / $block_ct); //현재 페이지 블록 구하기, 블록 당 10개의 게시글을 보여줌
    $block_start = (($block_num - 1) * $block_ct) + 1; // 블록의 시작번호
    $block_end = $block_start + $block_ct - 1; //블록 마지막 번호

    $total_page = ceil($totalRowNum / 10); // 페이징한 페이지 수 구하기
    if($block_end > $total_page) $block_end = $total_page; //만약 블록의 마지박 번호가 페이지수보다 많다면 마지박번호는 페이지 수
    $total_block = ceil($total_page / $block_ct); //블럭 총 개수
    $start_num = ($currentPage - 1) * 10; //시작번호 (page-1)에서 페이지 수를 곱한다.
    $numbering = 55 - ( ($currentPage - 1) * 10 ) + 1; //넘버링

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>자유게시판</title>
<script>
    function search1(){
        if(frm1.search.value){
            frm1.submit();
        }else{
            location.href="list.php";
        }
    }
</script>
</head>
<body>
    <h3>자유게시판</h3>
    <table border="2">
            <tr>
                <th>넘버링</th>
                <th>번호</th>
                <th>글쓴이</th>
                <th>날짜</th>
                <th>조회수</th>
                <th>제목</th>
                <th>내용</th>
            </tr>
            <?php 
                while($row = mysqli_fetch_array($result)){  //반복문을 이용하여 result 변수에 담긴 값을 row변수에 계속 담아서 row변수의 값을 테이블에 출력한다.                    
                $numbering--;
            ?> 
            <tr>
                <td><?php echo $numbering; ?></td>
                <td><?php echo $row["number"]; ?></td>
                <td><a href=#> <?php echo $row["writer"]; ?></a></td>
                <td><?php echo $row["date"]; ?></td>
                <td><?php echo $row["view"]; ?></td>
                <td><?php echo $row["title"]; ?></td>
                <td><?php echo $row["content"]; ?></td>
            </tr>
            <?php 
                } 
            ?>
    </table>
    <p style="text-align: center;"> 
    <?php
        if($currentPage <= 1){ //현재 페이지가 1보다 크거나 같을때만 활성화
            echo "<span><b>처음</b></span>"; 
        }
        else{
             echo "<span><a href='?page=1'>처음</a></span>"; //처음이라 표시하고 1번페이지로 링크걸기
        }
        if($currentPage <= 1){ //현재 페이지가 1보다 크거나 같다면 빈값으로 두기
        }
        else{        
            $pre = $currentPage-1; //만약 현재 페이지가 3인데 이전버튼을 누르면 2번페이지로 갈 수 있게 함
            echo "<span><a href='?currentPage=$pre'>이전</a></span>"; //이전글자에 링크 표시
        }

        for($i=$block_start; $i<=$block_end; $i++){ //초기값부터 마지막 불록값까지 $i를 반복시킨다

            if($currentPage== $i){ //만약 page가 $i와 같다면 
                echo "<span><b>[$i]</b></span>"; //현재 페이지에 해당하는 번호에 굵은 글씨 적용
            }else{
                echo "<span><a href='?currentPage=$i'>[$i]</a></span>"; //아니라면 링크
            }
        }
        if($currentPage == $total_page){ //만약 현재 블록이 블록 총개수랑 같다면 빈 값
        }
        else{
            $next = $currentPage + 1; //next변수에 page + 1을 해준다.
            echo "<span><a href='?currentPage=$next'>다음</a></span>"; //다음글자에 next 링크. 
        }
        if($currentPage >= $total_page){ //만약 page가 총 페이지수보다 크거나 같다면
            echo "<span><b>끝</b></span>"; //끝 글자는 굵게 
        }else{
            echo "<span><a href='?currentPage=$total_page'>끝</a></span>"; //아니라면 끝 글자에 total_page를 링크
        }
    ?> 
    <span><a href="/page/board/write.php"><button>글쓰기</button></a>
    </p>
</span> 
</body> 
</html>
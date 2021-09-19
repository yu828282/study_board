<?php //https://chamggae.tistory.com/83

include ("./connect.php");     
include ("./pagination.php");     

$pagination = new Pagination(); 

$pagination->pagecheck(); // 현재 페이지를 확인하는 함수
$pagination->posttoget(); //검색 post 값을 get으로 변환하는 함수

for($i = 0; $i < count($category); $i++){ // 선택한 검색 항목만큼 반복
    if($category) {
        $sql_search[] = "$category[$i] like '%$search_con%' ";  
        $sql_category[] = "$category[$i]";  
    }
}

$add_query = "";  // 검색 단어 변수 초기화
if($search_con != "") {$add_query = " and (" . implode($sql_search, " or ").")";} // 검색어가 공백이아니면 검색어 배열을 하나의 문자열로 변환하고 or 붙이기 
$add_category = implode($sql_category, "+"); //검색 카테고리 문자열로 변환하고 + 붙이기  

$block = 5;    // 페이지 당 블록 수 
$list_num = 10;     // 페이지 당 게시글 수

$begin = ($currentPage -1) * $list_num;  ////  시작 row 설정    

$sql = "SELECT * FROM st_board where delete_2 = 'no' ".$add_query." ORDER BY number DESC limit ".$begin.", $list_num"; //페이지 당 표시할 글 찾기
$sqlCount = "SELECT count(*) FROM st_board where delete_2 = 'no' ".$add_query." ";  // 전체 글 수 찾기

$result = mysqli_query($conn,$sql); //정렬한 글 갯수 가져오기
$resultCount = mysqli_query($conn,$sqlCount); //전체 게시글 가져오기

$totalRowNum = mysqli_fetch_array($resultCount)["count(*)"];  // 레코드를 호출해서 전체 게시글을 1개씩 배열 형태로 리턴     

$numbering = $totalRowNum - (($currentPage - 1) * $list_num) + 1; //표시할 게시글 넘버링 

$num = $pagination->makepaging($totalRowNum, $currentPage, $block, $list_num, $add_category, $search_con); // 하단 페이징을 만드는 함수
?> 

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" /> 
</head>
<body>
    <h3>자유게시판</h3> 
    <div style : align="right">
      <?php if(isset($_SESSION['user_id'])) { echo $_SESSION['user_id']. " 님 안녕하세요."; ?> <a href="./logout.php">[로그아웃]</a>
      <?php  }else { ?> <a href="./join.php">[회원가입]</a> <a href="./login.php">[로그인] </a>
      <?php } ?>
    </div> 
    <div>
        <form action="list.php" method="post">
            <input type="checkbox"  name="catego[]"   value="title" />제목
            <input type="checkbox"  name="catego[]"   value="writer" />글쓴이
            <input type="checkbox"  name="catego[]"   value='content'  />내용
            <input type="text"      name="search"   size="10" required="required"/> <button>검색</button>
        </form>
    </div>
    <table border="2">
            <tr>
              <th>넘버링</th>
              <th>번호</th>
              <th>글쓴이</th>
              <th>날짜</th>
              <th>조회</th>
              <th width="350">제목</th>
              <th width="400">내용</th>
            </tr>
            <?php 
              while($row = mysqli_fetch_array($result)){  //반복문으로 result 변수에 담긴 값을 row변수에 하나씩 계속해서 담아서 row변수의 값을 테이블에 출력한다.                    
              $numbering--;
            ?> 
            <tr>
              <td><?php echo $numbering; ?></td>
              <td><?php echo $row["number"]; ?></td>
              <td><?php echo $row["writer"]; ?></a></td>
              <td><?php echo $row["date"]; ?></td>
              <td><?php echo $row["view"]; ?></td>
              <td><a href="./read.php?number=<?php echo $row["number"]; ?>" ><?php echo $row["title"]; ?></a></td>     
              <td><?php echo $row["content"]; ?></td>
            </tr>
            <?php  
                } 
            ?>
    </table>
    <p style="text-align: center;"> 
        <span><a href="./list.php"><button>전체글</button></a></span> 
          <?php echo $num; ?> 
        <span><a href="./form.php"><button>글쓰기</button></a></span>         
    </p>
</body> 
</html> 
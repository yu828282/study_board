<?php  
    include ("./connect.php");      

    if (isset($_GET["currentPage"])) {
        $currentPage = $_GET["currentPage"];
    }else {
		$currentPage = 1;
	}

    $sqlCount = "SELECT count(*) FROM st_board "; //테이블 내 전체 행 갯수 조회 쿼리
    $resultCount = mysqli_query($conn,$sqlCount); 
    
    if($rowCount = mysqli_fetch_array($resultCount)){ //php는 지역 변수를 밖에서 사용 가능.
       $totalRowNum = $rowCount["count(*)"];  
    } 
    
    if($resultCount) { //행 갯수 조회 쿼리가 실행 됐는지 여부
        echo "행 갯수 조회 성공 : ". $totalRowNum."<br>"; 
    } else {
        echo "결과 없음: ".mysqli_error($conn);
    }

    if(!empty($_POST['search']))
    {
        $catagory = $_POST['catgo']; 
        $search_con = $_POST['search']; 
    }
    else
    {
        $catagory = $_GET['catgo']; 
        $search_con = $_GET['search']; 
    } 

    $begin = ($currentPage -1) * 10; //페이지의 첫 게시글 설정
    

    if (empty( $search_con)) {   //검색 값이 비어있으면 전체 게시글을 가져옴
        $sql = "SELECT * FROM st_board ORDER BY number DESC limit ".$begin.",10"; // 필드값을 내림차순으로 정렬해 가져옴, 행의 시작과 갯수가 매번 바뀌게 설정
        $sqlCount = "SELECT count(*) FROM st_board "; 
    }
    else{ 
        $sql = "SELECT * FROM st_board where $catagory like '%$search_con%' ORDER BY number DESC limit ".$begin.",10"; // 필드값을 내림차순으로 정렬해 가져옴, 행의 시작과 갯수가 매번 바뀌게 설정
        $sqlCount = "SELECT count(*) FROM st_board where $catagory like '%$search_con%'";
     }

    $resultCount = mysqli_query($conn,$sqlCount);  //전체 게시글 수 조회
    $result = mysqli_query($conn,$sql);   

    if($rowCount = mysqli_fetch_array($resultCount)){  
        $totalRowNum = $rowCount["count(*)"];  
     } 
     
 
    $block_num = ceil($currentPage / 5); //현재 페이지 블록 구하기, 블록 당 10개의 게시글을 보여줌
    $block_start = (($block_num - 1) * 5) + 1; // 블록의 시작번호
    $block_end = $block_start + 5 - 1; //블록 마지막 번호

    $total_page = ceil($totalRowNum / 10); // 페이징한 페이지 수 구하기
    if($block_end > $total_page) $block_end = $total_page; //만약 블록의 마지박 번호가 페이지수보다 많다면 마지박번호는 페이지 수
    $total_block = ceil($total_page / 5); //블럭 총 개수
    $start_num = ($currentPage - 1) * 10; //시작번호 (page-1)에서 페이지 수를 곱한다.
    $numbering = $totalRowNum - ( ($currentPage - 1) * 10) + 1; //넘버링  

    
    echo "행 갯수 재조회 : ". $totalRowNum."<br>"; 

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" /> 
</head>
<body>
    <h3>자유게시판</h3> 
    <div>
        <form action="list_old3.php" method="post">
        <!--
        <select name="catgo">
            <option value="title">제목</option>
            <option value="name">글쓴이</option>
            <option value="content">내용</option>
        </select>
         -->
        <input type="checkbox"  name="catgo"     value="title" /><label>제목</label>
        <input type="checkbox"  name="catgo"    value="writer" /><label>글쓴이</label>
        <input type="checkbox"  name="catgo"   value='content' /><label>내용</label> 
        <input type="text"      name="search"       size="10" required="required"/> <button>검색</button>
        </form>
    </div>
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
            echo "<span><b>처음</b></span>". "&nbsp"; 
        }
        else{
             echo "<span><a href='?page=1'>처음</a></span>". "&nbsp"; //처음이라 표시하고 1번페이지로 링크걸기
        }
        if($currentPage <= 1){ //현재 페이지가 1보다 크거나 같다면 빈값으로 두기
        }
        else{        
            $pre = $currentPage-1; //만약 현재 페이지가 3인데 이전버튼을 누르면 2번페이지로 갈 수 있게 함
            echo "<span><a href='?currentPage=$pre'>이전</a></span>". "&nbsp"; //이전글자에 링크 표시
        }

        for($i=$block_start; $i<=$block_end; $i++){ //초기값부터 마지막 불록값까지 $i를 반복시킨다

            if($currentPage== $i){ //만약 페이지수가 $i와 같다면 
                echo "<span><b>[$i]</b></span>". "&nbsp"; //현재 페이지에 해당하는 번호에 굵은 글씨 적용
            }else{
                echo "<span><a href='?catgo=$catagory&search=$search_con&currentPage=$i'>[$i]</a></span>". "&nbsp"; //아니라면 링크
            }
        }
        if($currentPage == $total_page){ //만약 현재 블록이 블록 총개수랑 같다면 빈 값
        }
        else{
            $next = $currentPage + 1; //next변수에 page + 1을 해준다.
            echo "<span><a href='?currentPage=$next'>다음</a></span>". "&nbsp"; //다음글자에 next 링크. 
        }
        if($currentPage >= $total_page){ //만약 page가 총 페이지수보다 크거나 같다면
            echo "<span><b>끝</b></span>"; //끝 글자는 굵게 
        }else{
            echo "<span><a href='?currentPage=$total_page'>끝</a></span>". "&nbsp"; //아니라면 끝 글자에 total_page를 링크
        } 
    ?> 
    <span><a href="./form.php"><button>글쓰기</button></a>
    </p>
</span> 
</body> 
</html>



<?php 
/*    include ("./connect.php");     
    include ("./function.php");     
    include ("./class.php");    

    pagecheck(); // 현재 페이지 확인
    posttoget(); //검색 post 값을 get으로 변환

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

    $sql = "SELECT * FROM st_board where delete_2 = 'no' ".$add_query." ORDER BY number DESC limit ".$begin.", $list_num";  
    $sqlCount = "SELECT count(*) FROM st_board where delete_2 = 'no' ".$add_query." ";  // 글 수 조회

    $resultCount = mysqli_query($conn,$sqlCount); //전체 게시글 가져오기
    $result = mysqli_query($conn,$sql); //정렬한 글 갯수 가져오기 
    
    $totalRowNum = mysqli_fetch_array($resultCount)["count(*)"];  // 레코드를 호출해서 전체 게시글을 1개씩 배열 형태로 리턴     
    
    $numbering = $totalRowNum - (($currentPage - 1) * $list_num) + 1; //표시할 게시글 넘버링  */


include ("./connect.php");     
include ("./function.php");     
include ("./class.php");    

pagecheck(); // 현재 페이지 확인
posttoget(); //검색 post 값을 get으로 변환

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

$sql = "SELECT * FROM st_board where delete_2 = 'no' ".$add_query." ORDER BY number DESC limit ".$begin.", $list_num";  
$sqlCount = "SELECT count(*) FROM st_board where delete_2 = 'no' ".$add_query." ";  // 글 수 조회

$resultCount = mysqli_query($conn,$sqlCount); //전체 게시글 가져오기
$result = mysqli_query($conn,$sql); //정렬한 글 갯수 가져오기 

$totalRowNum = mysqli_fetch_array($resultCount)["count(*)"];  // 레코드를 호출해서 전체 게시글을 1개씩 배열 형태로 리턴     

$numbering = $totalRowNum - (($currentPage - 1) * $list_num) + 1; //표시할 게시글 넘버링  



?> 

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" /> 
</head>
<body>
    <h3>자유게시판</h3> 
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
                <th>조회수</th>
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
              <?php makepaging($totalRowNum, $currentPage, $block, $list_num, $add_category, $search_con); ?>
        <span><a href="./form.php"><button>글쓰기</button></a></span>         
    </p>
</body> 
</html> 
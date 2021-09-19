<?php  
    function makepaging($totalRowNum, $currentPage, $block, $list_num, $add_category, $search_con){  
        //총 게시글 수, 현재페이지, 총 블록 수, 페이지 당 게시글 수, 검색 카테고리, 검색어
   
        $block_num = ceil($currentPage / $block); //현재 페이지 블록 구하기 
        $block_start = (($block_num - 1) * $block) + 1; // 블록 시작번호
        $block_end = $block_start + $block - 1; //블록 마지막 번호
        $total_page = ceil($totalRowNum / $list_num); // 페이징한 페이지 수 구하기
        $pre = $currentPage - 1;
        $next = $currentPage + 1;

        if($block_end > $total_page) $block_end = $total_page; //만약 블록의 마지박 번호가 페이지수보다 많다면 블록 마지막 번호는 페이지 수
        
        $total_block = ceil($total_page / $block); //블럭 총 개수
        $start_num = ($currentPage - 1) * $list_num; //시작번호 (page-1)에서 페이지 수를 곱한다.
        
        if($currentPage == 1){ 
            echo "<span><b>처음</b></span>" . " "; 
        }else{
            echo "<span><a href='?catego=$add_category&search=$search_con&page=1'>처음</a></span>" . " ";  //처음이라 표시하고 1번페이지로 링크걸기
            echo "<span><a href='?catego=$add_category&search=$search_con&currentPage=$pre'>이전</a></span>" . " ";  //이전글자에 링크 표시 
        }
        for($i=$block_start; $i<=$block_end; $i++){ //초기값부터 마지막 불록값까지 $i를 반복시킨다
            if($currentPage== $i){  
                echo "<span><b>[$i]</b></span>" . " ";  //현재 페이지에 해당하는 번호에 굵은 글씨 적용
            }else{
                echo "<span><a href='?catego=$add_category&search=$search_con&currentPage=$i'>[$i]</a></span>" . " ";  //아니라면 링크 걸기
            }
        }
        if($currentPage == $total_page){ //만약 현재 블록이 블록 총개수랑 같다면 
            echo "<span><b>끝</b></span>" . "&nbsp";  //끝 글자는 굵게 
        }else{
            echo "<span><a href='?catego=$add_category&search=$search_con&currentPage=$next'>다음</a></span>" . " ";  //아니라면 다음글자에 next 링크. 
            echo "<span><a href='?catego=$add_category&search=$search_con&currentPage=$total_page'>끝</a></span>" . "   ";  // 끝 글자에 total_page를 링크 
        }
    } 

    function posttoget(){ //post 값을 get 으로 변경
        global $category, $search_con;
  
        if(!empty($_POST['search'])){   
            $category = $_POST['catego']; 
            $search_con = $_POST['search']; 
        }else{
            $category = explode(" ", $_GET['catego']); 
            //explode :  문자열을 분리해 배열로 저장하는 함수 -> 검색한 카테고리를 공백을 기준으로 arry(배열)로 변환
            $search_con = $_GET['search']; 
        }      
  
      }

    function pagecheck(){
      global $currentPage;
      if(isset($_GET["currentPage"])) {  // isset() : 설정된 변수인지 확인하는 함수
          $currentPage = $_GET["currentPage"]; 
      }else{
          $currentPage = 1;
          }  
    }

?>
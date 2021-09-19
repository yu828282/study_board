
<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>회원가입</title>
</head>
<body> 
  <div align='center'>
  <h3>회원가입</h3> 
    <form method='POST' action='join_ok.php'>
      <p>아이디 : <input type="text" name="user_id"></p>
      <p>이름 : <input type="text" name="user_name"></p>
      <p>비밀번호 : <input type="password" name="user_pw"></p>
      <p>주소 : <input id="member_zip" name="user_zip" type="text" placeholder="우편번호 검색" readonly onclick="findAddr()">
                <input id="member_addr" name="user_ad" type="text" placeholder="주소" readonly> 
                <input type="text" name="user_add" placeholder="상세주소"> <br>  <br> 
      <input type="submit" value="회원가입">  <br>  <br> 
      <br><a href="./list.php">[게시판으로]</a>
      <a href="./login.php">[로그인]</a>
    </form>  
  </div> 
</body>
<script>function findAddr(){
        new daum.Postcode({
              oncomplete: function(data) {
                console.log(data);                
                  // 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.
                  // 도로명 주소의 노출 규칙에 따라 주소를 표시한다.
                  // 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
                  var roadAddr = data.roadAddress; // 도로명 주소 변수
                  var jibunAddr = data.jibunAddress; // 지번 주소 변수
                  // 우편번호와 주소 정보를 해당 필드에 넣는다.
                  document.getElementById('member_zip').value = data.zonecode;
                  if(roadAddr !== ''){
                      document.getElementById("member_addr").value = roadAddr;
                  } 
                  else if(jibunAddr !== ''){
                      document.getElementById("member_addr").value = jibunAddr;
                  }
              }
          }).open();
        }
</script>
<script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script> 
</body>
</html> 

<?php 



/* PHP 샘플 코드 */
$ch = curl_init();
$url = 'http://openapi.epost.go.kr/postal/retrieveNewAdressAreaCdSearchAllService/retrieveNewAdressAreaCdSearchAllService/getNewAddressListAreaCdSearchAll'; /*URL*/
$queryParams = '?' . urlencode('ServiceKey') . '=WksdJq29vDrZPWnb2pGWw7i/gBFt6VQkJhgyd9wvxi5s6FV33j4OL3zNl/+gl1DT1L3N7ohxaIJiO8ajYZpNAA=='; /*Service Key*/
$queryParams .= '&' . urlencode('srchwrd') . '=' . urlencode('공평동'); /**/
$queryParams .= '&' . urlencode('countPerPage') . '=' . urlencode('10'); /**/
$queryParams .= '&' . urlencode('currentPage') . '=' . urlencode('1'); /**/

curl_setopt($ch, CURLOPT_URL, $url . $queryParams);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
$response = curl_exec($ch);
curl_close($ch);

var_dump($response);
/* PHP 샘플 코드 */
?>
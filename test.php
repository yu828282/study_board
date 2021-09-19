<?php
 /*
 * 라이센스 키를 rawurlencode 하는 이유는
 * 있는 그대로 사용하면 SERVICE KEY IS NOT REGISTERED ERROR 라는 오류를 뱉기 때문이다.
 */
 $serviceKey = rawurlencode([WksdJq29vDrZPWnb2pGWw7i/gBFt6VQkJhgyd9wvxi5s6FV33j4OL3zNl/+gl1DT1L3N7ohxaIJiO8ajYZpNAA==);
 $charset = 'utf-8';

 

 /*
 * 검색타입은 총 3가지이다.
 * road : 도로명+건물번호 / dong : 동(읍/면/리)명+지번 / post : 구지번
 */
 $searchSe = $_POST['searchSe']; //검색타입

 

 /*
  * $srchwrd 요놈은 PHP 전용 함수인 urlencode 해서 넘겨주면 인식을 못한다.
  * 따라서, PHP 자체함수는 자제하고 검색시 자바스크립트로 encodeURIComponent 로 값을 바꿔 받아
  * rawurlencode 로 재처리 하여 보내준다.
 */
 $srchwrd = rawurlencode($_POST['srchwrd']); //검색어
    
 /*
 * 아래 URL이 공공데이터센터에서 제공하는 URL
 */
 $url = "http://openapi.epost.go.kr/postal/retrieveNewAdressService/retrieveNewAdressService/getNewAddressList?ServiceKey={$serviceKey}&searchSe={$searchSe}&srchwrd={$srchwrd}&encoding={$charset}";  
 $xmlData = curlListMaking($url);
 
 if(!isset($xmlData->cmmMsgHeader)) { //cmmMsgHeader 없으면 오류 뱉어내고 멈춘다.
  echo $xmlData;
  exit;
 }

 $postList = array();
 
 foreach ($xmlData->newAddressList as $item) {
  $postList[] = array(
   "zipNo" => $item->zipNo
   , "lnmAdres" => curlCharcterSet($item->lnmAdres) //한글 치환
   , "rnAdres" => curlCharcterSet($item->rnAdres) //한글 치환
  );
 }

 print_r($postList); //결과 값
 
 function curlListMaking($url)
 {  
  $result = array();
  $ch = curl_init();
  curl_setopt ($ch, CURLOPT_URL, $url); //접속할 URL 주소
  curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
  curl_setopt ($ch, CURLOPT_HEADER, 0);
  curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
  curl_setopt ($ch, CURLOPT_TIMEOUT, 0);
  curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
  $result = curl_exec($ch);
  $errno = curl_errno($ch);
    
  if ($errno > 0) {
   if ($errno === 28) {
    return "Connection timed out.";
   }
   else {
    return "Error #" . $errno . " : " . curl_error($ch);
   }
  }else{
   $load_string = simplexml_load_string($result);
   return $load_string;
  }
  curl_close($ch);
 }
 
 function curlCharcterSet($str)
 {
  $str = iconv("UTF-8", "EUC-KR//TRANSLIT", $str);
  $str = addslashes($str);
  return $str;
 } 
?> 
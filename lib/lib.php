<?php
// 사용할 함수만 모아놓는 파일입니다.
// 앞으로 추가될 기능이 많아지실테니 따로 파일을 만들어 관리하시는게 좋아요.
/* 전화번호 하이픈 추가*/
function add_hyphen_telNo($tel){
	$tel = preg_replace("/[^0-9]/", "", $tel);	// 숫자 이외 제거
	if (substr($tel,0,2)=='02'){
		$renum =  preg_replace("/([0-9]{2})([0-9]{3,4})([0-9]{4})$/", "$1-$2-$3", $tel);
	}else if (strlen($tel)=='8' && (substr($tel,0,2)=='15' || substr($tel,0,2)=='16' || substr($tel,0,2)=='18') ){	// 지능망 번호이면
		$renum =  preg_replace("/([0-9]{4})([0-9]{4})$/", "$1-$2", $tel);
	}else{
		$renum =  preg_replace("/([0-9]{3})([0-9]{3,4})([0-9]{4})$/", "$1-$2-$3", $tel);
	}
	if( $tel === $renum ){
		return false;
	}
	$last_chk = preg_replace("/[^0-9]/", "", $renum);
	if( $last_chk ){
		return $renum;
	}else{
		return false;
	}
}
/* 사업자번호 하이픈 추가 */
function add_hyphen_saup( $saup ){
	$saup = preg_replace("/[^0-9]/", "", $saup);
	if( strlen($saup) !== 10 ){
		return false;
	}
	$renum = preg_replace("/([0-9]{3})([0-9]{2})([0-9]{5})$/", "$1-$2-$3", $saup);
	$last_chk = preg_replace("/[^0-9]/", "", $renum);
	if( $last_chk ){
		return $renum;
	}else{
		return false;
	}
}
?>
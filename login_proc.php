<?php
	error_reporting(E_ALL);
	ini_set("display_errors", 1);
	session_start();
	include_once ('dbconfig.php');
	$mysqli = new mysqli('1.221.118.86', 'admin', 'fbckddn7', 'management');
	if (mysqli_connect_error()) {
		exit('Connect Error (' . mysqli_connect_errno() . ') '. mysqli_connect_error());
	}

	$member_id = $_POST['member_id'];
	$member_pw = $_POST['member_pw'];
	

	$_SESSION['is_logged'] = '';
	
	



$q = "SELECT * FROM member WHERE member_id='$member_id'";
$result = $mysqli->query( $q);


if($result->num_rows==1) {
    //해당 ID 의 회원이 존재할 경우
    // 암호가 맞는지를 확인

    $row = $result->fetch_array(MYSQLI_ASSOC);
    if( $row['member_pw'] == $member_pw ) {
        // 올바른 정보
		$_SESSION['is_logged'] = 'YES';
		$_SESSION['user_id'] = $member_id;
        $_SESSION['user_level'] = $row['member_grade'];
		$_SESSION['user_store'] = $row['member_store'];
		header("Location: http://1.221.118.86/sellmanage/main.php");
		
        exit();
    }
    else {
        // 암호가 틀렸음
        $msg = '비밀번호 들렸습니다';
	?>
      <script>
         alert("<?php echo $msg?>");
		 history.back();
      </script>
	 <?php 
    }

}
else {
    // 없거나, 비정상
    $msg= '아이디가 없습니다';
	?>
	
      <script>
         alert("<?php echo $msg?>");
		 history.back();
      </script>
	  <?php
}
extract($_POST); 
?>
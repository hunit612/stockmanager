<?php
	session_start();


	// 현재 페이지 이름가져오기.
	$pathinfo		= pathinfo($_SERVER['PHP_SELF']);
	$pageName	= $pathinfo['filename'];


	$member_grade = $_SESSION['user_level'];

	$is_logged = $_SESSION['is_logged'];

	if($is_logged=='YES') {
		if($member_grade <= 10){
			$member_id = $_SESSION['user_id'];
			$member_grade = $_SESSION['user_level'];
			$message = $member_id . ' 님, 로그인 했습니다.';
		}else{
			$msg = '권한이 없습니다.';
		?>
		  <script>
			 alert("<?php echo $msg?>");
			 history.back();
		  </script>
		  <?php
		}
	}
	else {
		$message = '로그인이 실패했습니다.';
	}
	
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="style/style.css" type="text/css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript">
/*
jQuery(function($){

  var current_menu = function(){
    $("#topMenu>ul>li>a").each(function(){ 
      var $this = $(this),
          pageURL = location.href, 
          menuURL = $this.attr("href");
      if ( pageURL.indexOf(menuURL) !== -1 ) {
        $this.parent().addClass("current"); 
      } else {
        $this.parent().removeClass("current");
      }
    });
  };

  current_menu(); 

  $(document).ajaxComplete(current_menu);

  $(document).on("click", "#topMenu>ul>li>a", function(){ 
    setTimeout(function(){
      current_menu();
    },200);
  });

});

*/
</script>
<style>
.current>a{
  font-weight:bold;
  color: #75adcd !important;
}
</style>
</head>
<body>
<div id="header">
<a class="logoimg" href="/sellmanage/main.php"><img src="http://1.221.118.86/sellmanage/img/header_logo.png"></a>
<div id="dayT"><?php echo date("Y년 m월 d일"); ?></div><div id="loginfo"><?php echo "$message"; ?><a href='http://1.221.118.86/sellmanage/logout.php' id='logoutinfo'>로그아웃</a></div>
</div>

<nav id="topMenu">
  <ul>
    <li<?php echo ($pageName === 'main')?' class="current"':'';?>><a class="menuLink" href="http://1.221.118.86/sellmanage/main.php"><img src="http://1.221.118.86/sellmanage/img/<?php echo ($pageName === 'main')?'menubox1_blue.jpg':'menubox1.jpg';?>" /></a></li>
    <li<?php echo ($pageName === 'order_list')?' class="current"':'';?>><a class="menuLink" href="http://1.221.118.86/sellmanage/order_list.php"><img src="http://1.221.118.86/sellmanage/img/<?php echo ($pageName === 'order_list')?'menubox2_blue.jpg':'menubox2.jpg';?>" /></a></li>
    <li<?php echo ($pageName === 'out')?' class="current"':'';?>><a class="menuLink" href="http://1.221.118.86/sellmanage/out.php"><img src="http://1.221.118.86/sellmanage/img/<?php echo ($pageName === 'out')?'menubox3_blue.jpg':'menubox3.jpg';?>" /></a></li>
    <li<?php echo ($pageName === 'in')?' class="current"':'';?>><a class="menuLink" href="http://1.221.118.86/sellmanage/in.php"><img src="http://1.221.118.86/sellmanage/img/<?php echo ($pageName === 'in')?'menubox4_blue.jpg':'menubox4.jpg';?>" /></a></li>
    <li<?php echo ($pageName === 'order_s')?' class="current"':'';?>><a class="menuLink" href="http://1.221.118.86/sellmanage/order/order_s.php"><img src="http://1.221.118.86/sellmanage/img/<?php echo ($pageName === 'order_s')?'menubox5_blue.jpg':'menubox5.jpg';?>" /></a></li>
    <li<?php echo ($pageName === 'order_i')?' class="current"':'';?>><a class="menuLink" href="http://1.221.118.86/sellmanage/order/order_i.php"><img src="http://1.221.118.86/sellmanage/img/<?php echo ($pageName === 'order_i')?'menubox6_blue.jpg':'menubox6.jpg';?>" /></a></li>
    <li<?php echo ($pageName === 'product')?' class="current"':'';?>><a class="menuLink" href="http://1.221.118.86/sellmanage/product/product.php"><img src="http://1.221.118.86/sellmanage/img/<?php echo ($pageName === 'product')?'menubox7_blue.jpg':'menubox7.jpg';?>" /></a></li>
  </ul>
</nav>
</body>
</html>
<?php
 session_start( ); // $_SESSION 를 사용할수있게 해줌
 session_destroy( ); // $_SESSION 을 지움 

 echo"<div style='font-size:20px; margin-left:43%; margin-top:25%;' >로그아웃되었습니다.</div>";
   echo"<meta http-equiv='Refresh' content='1;URL=index.php'>";

?>
<link rel='stylesheet' href='../style/style.css' type='text/css'>
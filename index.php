<html>
    <head>
        <title>로그인</title>
        <meta charset="utf-8" >
	<link rel="stylesheet" href="style/style.css" type="text/css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
    </head>
    <body>
		<div class="loginBg">
		<div class="loginForm">
			 <form name="login_form" class="formBg" method="post" action="login_proc.php" >
				<div class="logoimg"><img src="http://1.221.118.86/img/hun/login_logo.png" style="width:32%; padding-bottom: 5%;"></div>
				<p class="loginTitle">안녕하세요 하늘건강나음터입니다.</p>
				<p class="loginSub">하늘건강나음터 재고관리 프로그램을 찾아주셔서 감사합니다.</p>
				<input type="text" class="loginInput" placeholder="id" name="member_id" /><br />
				<input type="password" class="loginInput" placeholder="password" name="member_pw" /><br />
				<input type="submit" class="loginBtn" value="LOGIN" />
			</form>  
		</div>
        </div>
    </body>
</html>
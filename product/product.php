<?php
include_once("../dbconfig.php");


	session_start();

	$member_grade = $_SESSION['user_level'];

	$is_logged = $_SESSION['is_logged'];

	if($is_logged=='YES') {
		if($member_grade == 10){
			$member_id = $_SESSION['user_id'];
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
<meta charset="utf-8">
<title>나음터재고관리</title>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.11.1.js"></script>
  <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
  <script src="http://code.jquery.com/jquery-1.10.2.js"></script>
  <script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<link rel='stylesheet' href='../style/style.css' type='text/css'>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
<script>
function check(){

var str = document.getElementById('pName');

 

if( str.value == '' || str.value == null ){
    alert( '상품을 입력해주세요' );
    return false;
}

var blank_pattern = /^\s+|\s+$/g;
if( str.value.replace( blank_pattern, '' ) == "" ){
    alert(' 공백만 입력되었습니다 ');
    return false;
}



var special_pattern = /[`~!@#$%^&*|\\\'\";:\/?]/gi;

if( special_pattern.test(str.value) == true ){
    alert('특수문자는 사용할 수 없습니다.');
    return false;
}
}

</script>
</head>
<body>
<?php 
include("../header.php");
?>
	<article class="boardArticle">
	<div class="pd-wrap">
		<div id="boardWrite">
			<form action="product_update.php" method="post">
				<!--<table id="boardWrite">
					<tbody>
						<tr>
							<th scope="row"><label for="pName">상품명</label></th>
							<td rowspan="2"><button type="submit" id="pdInsert" class="btnSubmit btn btn-default" onclick="return check();">등록</button></td>
						</tr>
						<tr>
							<td class="name"><input type="text" name="pName" id="pName" ></td>
						</tr>
					</tbody>
				</table>-->
				<div class="pdadd-wrap">
					<div class="pdadd-img"><img src="../img/product_update_icon.png"></div>
					<p class="pdadd-title"><label for="pName" class="insertP">상 품 등 록</label></p>
					<div class="pdadd-input">
						<input type="text" name="pName" id="pName" placeholder="상품명을 입력하세요" >
					</div>
					<div class="pdadd-btn">
						<button type="submit" id="pdInsert" class="btnSubmit" onclick="return check();">등록</button>
					</div>
				</div>
			</form>
		</div>
		
	</div>
	<div class="pd-wrap2">
		<div id="list">
			<table id="list" class="table-striped table-hover">
				<thead>
					<tr>
						<th class="p-code" scope="row">상품코드</th>
						<th class="p-name" scope="row">상품명</th>
					</tr>
				</thead>
				<tbody>
					<?php

						$sql = 'select p_code, p_name from product order by p_code asc limit 25';
						$result = $db->query($sql);
						while($row = $result->fetch_assoc())
						{
							$datetime = explode(' ', $row['s_date']);
							$date = $datetime[0];
							$time = $datetime[1];
							if($date == Date('Y-m-d'))
								$row['s_date'] = $time;
							else
								$row['s_date'] = $date;
					?>
				<tr>
					<td class="code"><?php echo $row['p_code']?></td>
					<td class="name"><?php echo $row['p_name']?></td>
				</tr>
					<?php
						}
					?>					
				</tbody>
			</table>
		</div>
		<div id="list2">
			<table id="list" class="table-striped table-hover">
				<thead>
					<tr>
						<th class="p-code" scope="row">상품코드</th>
						<th class="p-name" scope="row">상품명</th>
					</tr>
				</thead>
				<tbody>
					<?php

						$sql = 'select p_code, p_name from product order by p_code asc limit 25, 25';
						$result = $db->query($sql);
						while($row = $result->fetch_assoc())
						{
							$datetime = explode(' ', $row['s_date']);
							$date = $datetime[0];
							$time = $datetime[1];
							if($date == Date('Y-m-d'))
								$row['s_date'] = $time;
							else
								$row['s_date'] = $date;
					?>
				<tr>
					<td class="code"><?php echo $row['p_code']?></td>
					<td class="name"><?php echo $row['p_name']?></td>
				</tr>
					<?php
						}
					?>					
				</tbody>
			</table>
		</div>
		<div id="list3">
			<table id="list" class="table-striped table-hover">
				<thead>
					<tr>
						<th class="p-code" scope="row">상품코드</th>
						<th class="p-name" scope="row">상품명</th>
					</tr>
				</thead>
				<tbody>
					<?php

						$sql = 'select p_code, p_name from product order by p_code asc limit 50, 75';
						$result = $db->query($sql);
						while($row = $result->fetch_assoc())
						{
							$datetime = explode(' ', $row['s_date']);
							$date = $datetime[0];
							$time = $datetime[1];
							if($date == Date('Y-m-d'))
								$row['s_date'] = $time;
							else
								$row['s_date'] = $date;
					?>
				<tr>
					<td class="code"><?php echo $row['p_code']?></td>
					<td class="name"><?php echo $row['p_name']?></td>
				</tr>
					<?php
						}
					?>					
				</tbody>
			</table>
		</div>
		</div>
	</article>
</body>
</html>
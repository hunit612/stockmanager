<?php
	require_once("dbconfig.php");
	include("header.php");


	session_start();
	$member_grade = $_SESSION['user_level'];
	$is_logged = $_SESSION['is_logged'];

	if($is_logged=='YES') {
		if($member_grade <= 10){
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
	<meta charset="utf-8" />
	<title>나음터재고관리</title>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.11.1.js"></script>
	<link rel="stylesheet" href="style/style.css" type="text/css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script>
$(function() {
  $( "#datepicker" ).datepicker({
    dateFormat: 'yy-mm-dd',
    prevText: '이전 달',
    nextText: '다음 달',
    monthNames: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
    monthNamesShort: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
    dayNames: ['일','월','화','수','목','금','토'],
    dayNamesShort: ['일','월','화','수','목','금','토'],
    dayNamesMin: ['일','월','화','수','목','금','토'],
    showMonthAfterYear: true,
    changeMonth: true,
    changeYear: true,
    yearSuffix: '년'
  });
  $( "#datepicker2" ).datepicker({
    dateFormat: 'yy-mm-dd',
    prevText: '이전 달',
    nextText: '다음 달',
    monthNames: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
    monthNamesShort: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
    dayNames: ['일','월','화','수','목','금','토'],
    dayNamesShort: ['일','월','화','수','목','금','토'],
    dayNamesMin: ['일','월','화','수','목','금','토'],
    showMonthAfterYear: true,
    changeMonth: true,
    changeYear: true,
    yearSuffix: '년'
  });
});
	Date.prototype.yyyymmdd = function() {
		var yyyy = this.getFullYear().toString();
		var mm = (this.getMonth()+1).toString();
		var dd = this.getDate().toString();

		return yyyy + '-' + (mm[1]?mm:"0"+mm[0]) + '-' + (dd[1]?dd:"0"+dd[0]);
	};
	$(document).ready(function(){
	  $( "#datepicker" ).datepicker();
      $( "#datepicker" ).datepicker("option","dateFormat","yy-mm-dd");
	  $( "#datepicker2" ).datepicker();
      $( "#datepicker2" ).datepicker("option","dateFormat","yy-mm-dd");
     // $("input[name=selectedDateS]").val(new Date().yyyymmdd()); 
     // $("input[name=selectedDateE]").val(new Date().yyyymmdd());
		
		

		$("#btnSearch").click(function(){
			$("#selectedDate").val($("#datepicker").val());
			$("#submitForm").submit();
		});

		
	  $('input[name=selectedDateS]').datepicker("option", "onClose", function ( selectedDate ) {
         $("input[name=selectedDateE]").datepicker( "option", "minDate", selectedDate );
      });
      $('input[name=selectedDateE]').datepicker("option", "onClose", function ( selectedDate ) {
         $("input[name=selectedDateS]").datepicker( "option", "maxDate", selectedDate );
      });
		/*
		$("#btnSearchM").click(function(){
			$("#selectedMonth").val($("#datepicker").val());
			$("#submitFormMonth").submit();
		});
		*/
	});

</script>
</head>
<body>
	<article class="boardArticleM">
			<form id='submitForm' action="main_search.php" method="get">
				<!--
				<input name="selectedMonth" id="datepicker3" />
				<button type="button" id="btnSearchM" class="btn btn-default"> 월별조회</button>
				-->
				<?php
				$selectedDateS = $_GET['selectedDateS'];
				$selectedDateE = $_GET['selectedDateE'];
				if( !$selectedDateS ) $selectedDateS = date("Y-m-d",$_SERVER['REQUEST_TIME']);
				if( !$selectedDateE ) $selectedDateE = date("Y-m-d",$_SERVER['REQUEST_TIME']);
				?>
			
		   <input name="selectedDateS" id="datepicker" value="<?php echo $selectedDateS;?>"/><label for="datepicker"><img src="img/calendar_icon.png" class="calimg"></label> ~ 
		   <input name="selectedDateE" id="datepicker2" value="<?php echo $selectedDateE;?>"/><label for="datepicker2"><img src="img/calendar_icon.png" class="calimg"></label>


		   <button type="button" id="btnSearch" class="btnSearch2 btn btn-default">조회</button>
			</form>
		<form action="product_search.php" class="searchM" method="post">
			   <select name="searchType" class="searchSelect">
				<option value="p_name">상품명</option>
			   </select>
			   <input type="text" class="form-control searchInput" name="search">
				<button type="submit" class="searchBtn btn btn-default">검색</button>
		</form>

		<table class="stock-table table table-striped table-hover">
			<thead>
				<tr>
					<th scope="col" class="product">상품명</th>
					<th scope="col" class="stock">총재고</th>
					<th scope="col" class="in">입고</th>
					<th scope="col" class="out">출고</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$total_array = array();
					$sql = 'select p.p_code, sum(s.s_instock + s.s_return), sum(s.s_outstock)  from product as p, stock as s WHERE p.p_code = s.s_code AND DATE_FORMAT(s_date, "%Y-%m-%d") <= "'.$selectedDateE.'" group by p.p_code';
					$result = $db->query($sql);
					while($row = $result->fetch_assoc()){
						$total_array[$row['p_code']] = $row['sum(s.s_instock + s.s_return)'] - $row['sum(s.s_outstock)'];
					}
					$sql = 'select p.p_code, p.p_name, sum(s.s_instock + s.s_return), sum(s.s_outstock) from product as p, stock as s where p.p_code = s.s_code AND DATE_FORMAT(s_date, "%Y-%m-%d") BETWEEN "'.$selectedDateS.'" and "'.$selectedDateE.'" group by p.p_code';
					$result = $db->query($sql);
						while($row = $result->fetch_assoc())
						{
							$row['total']		= $total_array[$row['p_code']];
							$datetime = explode(' ', $row['s_date']);
							$date = $datetime[0];
							$time = $datetime[1];
							if($date == Date('Y-m-d'))
								$row['s_date'] = $time;
							else
								$row['s_date'] = $date;
				?>
				<tr>
					<td class="product"><?php echo $row['p_name']?></td>
					<td class="stock" style="color:#4da3fb; font-weight:bold;"><?php echo $row['total']?></td>
					<td class="in"><?php echo $row['sum(s.s_instock + s.s_return)']?></td>
					<td class="out"><?php echo $row['sum(s.s_outstock)']?></td>
				</tr>
					<?php
						}
					?>
			</tbody>
		</table>
	</article>
</body>
</html>
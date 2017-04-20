
<?php
	require_once("dbconfig.php");
	include("header.php");

	session_start();

	$is_logged = $_SESSION['is_logged'];
	if($is_logged=='YES') {
		$user_id = $_SESSION['user_id'];
		$message = $user_id . ' 님, 로그인 했습니다.';
	}
	else {
		$message = '로그인이 실패했습니다.';
	}
?>
<?php
// 정렬 구분용은 하나만 사용하죠
$order_type_print = array(
	'asc' => '▲',
	'desc' => '▼',
);
$typeOfOtype = $_GET['typeOfOtype'];
$typeOfOstore = $_GET['typeOfOstore'];
if( !$typeOfOtype ) $typeOfOtype = 'desc';			// 2개뿐이니 그냥 배열 사용안하고 바로 지정했어요.
if( !$typeOfOstore ) $typeOfOstore = 'desc';

/*
$ord_array = array('desc','asc'); // 정렬 방법 (내림차순, 오름차순)
$ord_arrow = array('▼','▲'); // 정렬 구분용
$ord = isset($_GET['ord']) && in_array($_GET['ord'],$ord_array) ? $_GET['ord'] : $ord_array[0]; // 지정된 정렬이면 그 값, 아니면 기본 정렬(내림차순)

$ord_key = array_search($ord,$ord_array); // 해당 키 찾기 (0, 1)
$ord_rev = $ord_array[($ord_key+1)%2]; // 내림차순→오름차순, 오름차순→내림차순

///////////////////////////////////////////////////////////////////////////

$ord_array2 = array('desc','asc'); // 정렬 방법 (내림차순, 오름차순)
$ord_arrow2 = array('▼','▲'); // 정렬 구분용
$ord2 = isset($_GET['ord2']) && in_array($_GET['ord2'],$ord_array2) ? $_GET['ord2'] : $ord_array2[0]; // 지정된 정렬이면 그 값, 아니면 기본 정렬(내림차순)

$ord_key2 = array_search($ord2,$ord_array2); // 해당 키 찾기 (0, 1)
$ord_rev2 = $ord_array2[($ord_key2+1)%2]; // 내림차순→오름차순, 오름차순→내림차순
*/
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>출입고조회</title>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.11.1.js"></script>
	<link rel='stylesheet' href='style/style.css' type='text/css'>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script src="js/jquery.btechco.excelexport.js"></script>
</head>
<script>
    function downloadExcel(targetId, SaveFileName) {
        var browser = navigator.userAgent.toLowerCase();
        // ie 구분
        if (-1 != browser.indexOf('trident')) {
			alert("크롬에서 동작하세요.");
        } else {
			window.open('data:application/vnd.ms-excel,' + encodeURI($('#divOutbound').html()));
        }
    }
    function downloadExcel2(targetId, SaveFileName) {
        var browser = navigator.userAgent.toLowerCase();
        // ie 구분
        if (-1 != browser.indexOf('trident')) {
			alert("크롬에서 동작하세요.");
        } else {
			window.open('data:application/vnd.ms-excel,' + encodeURI($('#divInbound').html()));
        }
    }
</script>
<script>
$(document).ready(function(){
	/*
	$("#aOrd").click(function(){
		$("#hiddenForm").submit();
	
	});
	$("#aOrd2").click(function(){
		$("#hiddenForm").submit();
	
	});
	*/
	$( ".btn_order" ).click(function(){
			var target = $( this ).attr("data-target");
			var type = $( this ).attr("data-type");
			var ntype = 'desc';
			if( type == 'desc' ){
				ntype = 'asc';
			}
			$( "#"+target ).val( ntype );
			$("#hiddenForm").submit();
		});
});
</script>

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
	});

</script>
<body>
<?php
$selectedDateS = $_GET['selectedDateS'];
$selectedDateE = $_GET['selectedDateE'];
if( !$selectedDateS ) $selectedDateS = date("Y-m-d",$_SERVER['REQUEST_TIME']);
if( !$selectedDateE ) $selectedDateE = date("Y-m-d",$_SERVER['REQUEST_TIME']);
?>
	<form id="hiddenForm" style="display:none;" action="changwon.php" method="get">
			<input type="hidden" name="selectedDateS" value="<?php echo $selectedDateS;?>"/>  
		   <input type="hidden" name="selectedDateE" value="<?php echo $selectedDateE;?>"/>
		   <input type="text" name="typeOfOtype" id="o_type" value="<?php echo $typeOfOtype?>" />
		   <input type="text" name="typeOfOstore" id="o_store" value="<?php echo $typeOfOstore?>" />
	</form>
	<article class="boardArticle">
		<h3>창원지점</h3>
		<form id='submitForm' action="changwon.php" method="get">
			
		   <input name="selectedDateS" class="dapi" id="datepicker" value="<?php echo $selectedDateS;?>"/><label for="datepicker"><img src="img/calendar_icon.png" class="calimg"></label> ~ 
		   <input name="selectedDateE" class="dapi" id="datepicker2" value="<?php echo $selectedDateE;?>"/><label for="datepicker2"><img src="img/calendar_icon.png" class="calimg"></label>


		   <button type="button" id="btnSearch" class="btnSearch2 btn btn-default">조회</button>
		   
				<a href="#csearch" class="cns">출고 보기</a>
				<a href="#isearch" class="ins">입고 보기</a>
		</form>
		<div class="change-wrap">
		<select class="changec" onchange='location.href=this.value'>
						<option value=''>지점을 고르세요</option>
						<option value='order_list.php'>전체보기</option>
						<option value='skyhealth.php'>본점</option>
						<option value='changwon.php'>창원</option>
		</select>
		</div>
		<form action="search_update.php" class="searchM3" method="post">
			   <select name="searchType" class="searchSelect">
				<option value="O.o_name">이름</option>
				<option value="O.o_tel">전화번호</option>
				<option value="O.o_delivery_num">운송장번호</option>
			   </select>
			   <input type="text" class="form-control searchInput" name="search">
				<button type="submit" class="searchBtn btn btn-default"><img src="img/search_icon.png"></button>
		</form>

		<div class="box_table">
		<table class="total-table">
			<tbody>
				<?php
					$sql = "select COALESCE(sum(o_box),0), COALESCE(FORMAT(sum(o_delivery),0),0) from orders where DATE_FORMAT(o_date, '%Y-%m-%d') BETWEEN '".$selectedDateS."' and '".$selectedDateE."' AND o_store = '창원'  ";
					$result = $db->query($sql);
					while($row = $result->fetch_assoc())
					{
						$datetime = explode(' ', $row['o_date']);
						$date = $datetime[0];
						$date = $datetime[1];
						if($date == Date('Y-m-d'))
							$row['o_date'] = $time;
						else
							$row['o_date'] = $date;
				?>
				<tr>
					<td>출입고 수량 : <?php echo $row['COALESCE(sum(o_box),0)']?></td>
					<td>운송비용 : <?php echo $row['COALESCE(FORMAT(sum(o_delivery),0),0)']?></td>
				<?php
					}
				?>
				<?php
					$sql = "select COALESCE(sum(o_box),0), COALESCE(FORMAT(sum(o_delivery),0),0) from orders where DATE_FORMAT(o_date, '%Y-%m-%d') BETWEEN '".$selectedDateS."' and '".$selectedDateE."' AND (o_type = '택배' OR o_type = '직접배송' OR o_type = '해외배송' OR o_type = '퀵' OR o_type = '이동' OR o_type = '기타배송')  AND o_store = '창원'";
					$result = $db->query($sql);
					while($row = $result->fetch_assoc())
					{
						$datetime = explode(' ', $row['o_date']);
						$date = $datetime[0];
						$date = $datetime[1];
						if($date == Date('Y-m-d'))
							$row['o_date'] = $time;
						else
							$row['o_date'] = $date;
				?>
					<td>택배수량 : <?php echo $row['COALESCE(sum(o_box),0)']?></td>
					<td>비용 : <?php echo $row['COALESCE(FORMAT(sum(o_delivery),0),0)']?></td>
				</tr>
				<?php
					}
				?>
			</tbody>
		</table>
		</div>


			<div class="csearch">
				<a href="#csearch" class="cns">출고 조회</a>
				<a href="#isearch" class="ins">입고 조회</a>
			</div>

		<h3 id="csearch">출고</h3>
		<div id="divOutbound">
			<table class="table table-striped" id="tblOutbound">
				<thead>
					<tr>
						<th class="num" scope="col">번호</th>
<!--						<th class="user_id" scope="col"><a href="javascript:;" class="btn_order" data-target="o_store" data-type="<?php echo $typeOfOstore;?>"  id="aOrd2">지점<?php echo $order_type_print[$typeOfOstore]; ?></a></th> -->
						<th class="user_id" scope="col">지점</th>
						<th class="date" scope="col">날짜</th>
						<th class="user" scope="col">성함</th>
						<th class="tel" scope="col">연락처</th>
						<th scope="col">주&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;소</th>
						<th class="pd" scope="col">상품</th>
						<!--<th class="qty" scope="col">수량</th>-->
						<th class="addpd" scope="col">지원품목</th>
						<th class="boxs" scope="col">박스</th>
						<th class="coast" scope="col">비용</th>
						<th class="dn" scope="col">운송장번호</th>
						<th class="dt" scope="col"><a href="javascript:;" class="btn_order" data-target="o_type" data-type="<?php echo $typeOfOtype;?>" id="aOrd">배송타입<?php echo $order_type_print[$typeOfOtype]; ?></a></th>
						<th class="bgo" scope="col">비&nbsp;&nbsp;&nbsp;&nbsp;고</th>
					</tr>
				</thead>
				<tbody>
						<?php
							$selectedDate = $_POST['selectedDate'];
							$sql = "select 
								   O.*, FORMAT(o_delivery,0), G.og_num, G.og_qty, P.p_name
								FROM
									orders AS O
								LEFT JOIN 
									orders_goods AS G
								ON
									O.o_no = G.og_num
								LEFT JOIN
									product AS P
								ON
									G.p_code = P.p_code
								WHERE
									DATE_FORMAT(O.o_date, '%Y-%m-%d') BETWEEN '".$selectedDateS."' and '".$selectedDateE."'
								AND o_store = '창원'
								AND 
									(o_type = '택배' OR o_type = '직접배송' OR o_type = '해외배송' OR o_type = '퀵' OR o_type = '이동' OR o_type = '기타출고') order by O.o_Type " . $typeOfOtype . ", O.o_no desc";
							$result = $db->query($sql);
							$old_ono = '';
							$list_arr = array();
							$rown = 0;
							$pnum = 0;
							while($row = $result->fetch_assoc()){
								if( $old_ono != $row['og_num'] ){
									$rown++;
									$pnum = 0;
									$datetime = explode(' ', $row['o_date']);
									$date = $datetime[0];
									$time = $datetime[1];
									if($date == Date('Y-m-d'))
										$row['o_date'] = $time;
									else
										$row['o_date'] = $date;
									$list_arr[$rown] = $row;
									$list_arr[$rown]['p_name'] = array();
									$list_arr[$rown]['og_qty'] = array();
									$list_arr[$rown]['p_name'][$pnum]	= $row['p_name'];
									$list_arr[$rown]['og_qty'][$pnum]		= $row['og_qty'];
									$pnum++;
								}else{
									$list_arr[$rown]['p_name'][$pnum] = $row['p_name'];
									$list_arr[$rown]['og_qty'][$pnum] = $row['og_qty'];
									$pnum++;
								}
								
								$old_ono = $row['og_num'];
							}
							foreach( $list_arr AS $key => $row ){
						?>
					<tr>
						<td><?php echo $row['o_no']?></td>
						<td><?php echo $row['o_store']?></td>
						<td><?php echo $row['o_date']?></td>
						<td><?php echo $row['o_name']?></td>
						<td><?php echo $row['o_tel']?></td>
						<td><?php echo $row['o_address']?></td>
						<td>
							<?php
							//2017-03-23 이부분 수정 엑셀
								foreach( $row['p_name'] AS $inkey => $invalue){
									echo $invalue . ' ' .  $row['og_qty'][$inkey];
									if(count($row['p_name']) > 1){
										echo ' , ';
									}
								}
							?>
						</td>
					<!--
						<td>
							<?php
							foreach( $row['og_qty'] AS $inkey => $invalue ){
								echo $invalue . '<BR>';
							}
							?>
						</td>
					-->
						<td><?php echo $row['o_ex']?></td>
						<td><?php echo $row['o_box']?></td>
						<td><?php echo $row['FORMAT(o_delivery,0)']?></td>
						<td><?php echo $row['o_delivery_num']?></td>
						<td><?php echo $row['o_type']?></td>
						<td><?php echo $row['o_ex2']?></td>
					</tr>
				<?php
					}
				?>
				</tbody>
			</table>
		</div>
			<button onclick="downloadExcel('tblOutbound');" class="exBtn"><img src="img/excel_button.jpg"></button>

		<h3 id="isearch">입고</h3>
		<div id="divInbound">
		<table class="table table-striped">
			<thead>
				<tr>
						<th class="num" scope="col">번호</th>
<!--						<th class="user_id" scope="col"><a href="javascript:;" class="btn_order" data-target="o_store" data-type="<?php echo $typeOfOstore;?>"  id="aOrd2">지점<?php echo $order_type_print[$typeOfOstore]; ?></a></th> -->
						<th class="user_id" scope="col">지점</th>
						<th class="date" scope="col">날짜</th>
						<th class="user" scope="col">성함</th>
						<th class="tel" scope="col">연락처</th>
						<th scope="col">주&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;소</th>
						<th class="pd" scope="col">상품</th>
						<!--<th class="qty" scope="col">수량</th>-->
						<th class="addpd" scope="col">지원품목</th>
						<th class="boxs" scope="col">박스</th>
						<th class="coast" scope="col">비용</th>
						<th class="dn" scope="col">운송장번호</th>
						<th class="dt" scope="col">배송타입</th>
						<th class="bgo" scope="col">비&nbsp;&nbsp;&nbsp;&nbsp;고</th>
				</tr>
			</thead>
			<tbody>
					<?php
						$selectedDate = $_POST['selectedDate'];
						$sql = "select 
							   O.*,G.og_num, G.og_qty, P.p_name
							FROM
								orders AS O
							LEFT JOIN 
								orders_goods AS G
							ON
								O.o_no = G.og_num
							LEFT JOIN
								product AS P
							ON
								G.p_code = P.p_code
							WHERE
								DATE_FORMAT(O.o_date, '%Y-%m-%d') BETWEEN '".$selectedDateS."' and '".$selectedDateE."' 
								AND o_store = '창원'
							AND 
								(o_type = '입고'  OR o_type = '반품' OR o_type = '기타입고')";

						
						$result = $db->query($sql);
						$old_ono = '';
						$list_arr = array();
						$rown = 0;
						$pnum = 0;
						while($row = $result->fetch_assoc()){
							if( $old_ono != $row['og_num'] ){
								$rown++;
								$pnum = 0;
								$datetime = explode(' ', $row['o_date']);
								$date = $datetime[0];
								$time = $datetime[1];
								if($date == Date('Y-m-d'))
									$row['o_date'] = $time;
								else
									$row['o_date'] = $date;
								$list_arr[$rown] = $row;
								$list_arr[$rown]['p_name'] = array();
								$list_arr[$rown]['og_qty'] = array();
								$list_arr[$rown]['p_name'][$pnum]	= $row['p_name'];
								$list_arr[$rown]['og_qty'][$pnum]		= $row['og_qty'];
								$pnum++;
							}else{
								$list_arr[$rown]['p_name'][$pnum] = $row['p_name'];
								$list_arr[$rown]['og_qty'][$pnum] = $row['og_qty'];
								$pnum++;
							}
							
							$old_ono = $row['og_num'];
						}
						foreach( $list_arr AS $key => $row ){
					?>
				<tr>
					<td><?php echo $row['o_no']?></td>
					<td><?php echo $row['o_store']?></td>
					<td><?php echo $row['o_date']?></td>
					<td><?php echo $row['o_name']?></td>
					<td><?php echo $row['o_tel']?></td>
					<td><?php echo $row['o_address']?></td>
					<td>
							<?php
							//2017-03-23 이부분 수정 엑셀
								foreach( $row['p_name'] AS $inkey => $invalue){
									echo $invalue . ' ' .  $row['og_qty'][$inkey];
									if(count($row['p_name']) > 1){
										echo ' , ';
									}
								}
							?>
					</td>
					<td><?php echo $row['o_ex']?></td>
					<td><?php echo $row['o_box']?></td>
					<td><?php echo $row['FORMAT(o_delivery,0)']?></td>
					<td><?php echo $row['o_delivery_num']?></td>
					<td><?php echo $row['o_type']?></td>
					<td><?php echo $row['o_ex2']?></td>
				</tr>
			<?php
				}
			?>
			</tbody>
		</table>
		</div>
			<button onclick="downloadExcel2('tblOutbound');" class="exBtn2"><img src="img/excel_button.jpg"></button>

	</article>
</body>
</html>

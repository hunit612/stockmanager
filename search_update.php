<?php
	require_once("dbconfig.php");
	include("header.php");

	$search = $_POST["search"];
	$searchType = $_POST["searchType"];
?>

<?php
/*
$ord_array = array('desc','asc'); // 정렬 방법 (내림차순, 오름차순)
$ord_arrow = array('▼','▲'); // 정렬 구분용
$ord = isset($_POST['ord']) && in_array($_POST['ord'],$ord_array) ? $_POST['ord'] : $ord_array[0]; // 지정된 정렬이면 그 값, 아니면 기본 정렬(내림차순)
$ord_key = array_search($ord,$ord_array); // 해당 키 찾기 (0, 1)
$ord_rev = $ord_array[($ord_key+1)%2]; // 내림차순→오름차순, 오름차순→내림차순
*/
?>
						
<html>
<head>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.11.1.js"></script>
	<link rel="stylesheet" href="http://1.221.118.86/manager/style/style.css" type="text/css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script>
$(document).ready(function(){
	$("#aOrd").click(function(){
		$("#hiddenForm").submit();
	
	});

});
</script>


</head>
<body>

	<article class="boardArticle">
		<h3>출입고 조회 검색결과</h3>
	<form id="hiddenForm" style="display:none;" action="search_update.php" method="post">
		   <input type="text" name="search" value="<?php echo $search?>" >
		   <input type="text" name="searchType" value="<?php echo $searchType?>" >
		   <input type="text" name="ord" value="<?php echo $ord_rev?>" >
	</form>
		<table class="table table-striped">
			<thead>
				<tr>
					<th class="num" scope="col">번호</th>
					<th scope="col">이름</th>
					<th scope="col">연락처</th>
					<th scope="col">주소</th>
					<th class="pd" scope="col">품목</th>
					<th class="qty" scope="col">수량</th>
					<th scope="col">고객지원</th>
					<th class="box" scope="col">박스</th>
					<th scope="col">비용</th>
					<th class="dn" scope="col">운송장번호</th>
					<th class="dt" scope="col">배송타입</th>
					<th scope="col">비고</th>
					<!--<th class="dt" scope="col"><a href="?ord=<?php echo $ord_rev; ?>">배송타입<?php echo $ord_arrow[$ord_key]; ?></a></th> -->
				</tr>
			</thead>
			<tbody>
					<?php
					if($searchType && $search){
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
								$searchType like '%$search%'";
						
					}
					
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
					<td><?php echo $row['o_name']?></td>
					<td><?php echo $row['o_tel']?></td>
					<td><?php echo $row['o_address']?></td>
					<td>
						<?php
						foreach( $row['p_name'] AS $inkey => $invalue ){
							echo $invalue.'<br>';
						}
						?>
					</td>
					<td>
						<?php
						foreach( $row['og_qty'] AS $inkey => $invalue ){
							echo $invalue.'<br>';
						}
						?>
					</td>
					<td><?php echo $row['o_ex']?></td>
					<td><?php echo $row['o_box']?></td>
					<td><?php echo $row['o_delivery']?></td>
					<td><?php echo $row['o_delivery_num']?></td>
					<td><?php echo $row['o_type']?></td>
					<td><?php echo $row['o_ex2']?></td>
				</tr>
			<?php
				}
			?>
			</tbody>
		</table>
</article>
</body>
</html>
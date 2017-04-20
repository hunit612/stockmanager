<?php
	error_reporting(E_ALL);
	ini_set("display_errors", 1);
	require_once("../dbconfig.php");
	$mode		= $_POST['mode'];
	if(!$mode ){
		echo "
		<script>
		alert('잘못된 접근입니다.');
		history.back();
		</script>
		";
	}
	$no = $_POST['no'];
	$ex = $_POST['ex'];
	$ex2 = $_POST['ex2'];
	$box = $_POST['box'];
	$delivery = $_POST['delivery'];
	$delivery_num = $_POST['delivery_num'];




	if( $mode === 'update' ){		// 수정일때
		$query3 = "update orders set o_ex = '$ex', o_ex2 = '$ex2', o_box = ".intVal($box).", o_delivery = ".intVal($delivery).", o_delivery_num = '$delivery_num' where o_no = '$no'";
		$result = $db->query($query3);
		
	}else if( $mode === 'delete' ){
		$sql = "SELECT 
					   O.*,G.og_num, G.p_code, G.og_qty, P.p_name
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
						O.o_no = '{$no}'";
		$query = $db->query($sql);

		while( $list = $query->fetch_assoc() ){

			 $inquery = "update product set p_stock = p_stock - ".intVal($list['og_qty'])." where p_code = '{$list['p_code']}'";
			 $db->query($inquery);
		}
		// 재고관련 작업후 삭제
		$inquery = "delete from orders where o_no = '{$no}'";
		$db->query($inquery);

		$inquery = "delete from orders_goods where og_num = '{$no}'";
		$result = $db->query($inquery);

		$inquery =  "delete from stock where og_num = '{$no}'";	
		 $db->query($inquery);

	}
	
	
	
   if($result) { // query가 정상실행 되었다면,
      $msg = "수정 되었습니다.";
      $replaceURL = 'order_s.php';
   } else {
      $msg = "수정 하지 못했습니다.";
?>
      <script>
         alert("<?php echo $msg?>");
      history.back();
      </script>
<?php
   }
?>
<script>
  alert("<?php echo $msg?>");
   location.replace("<?php echo $replaceURL?>");
</script>

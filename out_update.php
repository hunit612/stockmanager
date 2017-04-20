<?php
   ini_set("display_errors", 1);


   require_once("dbconfig.php");
   $mode = $_POST['mode'];
   $store = $_POST['oStore'];
   $name = $_POST['name'];
   $tel = $_POST['tel'];
   $address = $_POST['address'];
   $code = $_POST['code'];
   $qty = $_POST['qty'];
   $ex = $_POST['ex'];
   $ex2 = $_POST['ex2'];
   $type = $_POST['type'];

$today = date("Y-m-d",$_SERVER['REQUEST_TIME']);
$insert_n = 0;
if( !$mode ){		// 중복검사에서 mode에 nchk를 넣어 줍니다. 한번 중복검사를 마치고 온 자료라서 금일자료를 검색하지 않습니다. 
	foreach( $name AS $key => $value ){
		// 입력전 금일 저장된 자료가 있는지 검색
		$row = '';
		$searchKey = add_hyphen_telNo($tel[$key]);
		$query = "SELECT count(*) AS cou from orders WHERE o_tel = '{$searchKey}' AND DATE_FORMAT(o_date, '%Y-%m-%d') = '{$today}'";
		$result = $db->query($query);
		$row = $result->fetch_assoc();
		if( $row['cou'] ){
			$insert_n++;
		}
	}
}
if( $insert_n ){
	// 중복된 자료가 검색되었습니다.
	// 저장할지 안할지 확인후 현재페이지로 다시 넘겨주도록 할께요.
?>
	<!DOCTYPE html>
	<html>
	<head>
	<meta charset="utf-8">
	<title></title>
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.11.1.js"></script>	
	</head>
	<body>
	<form id="reform" method="post">
		<input type="hidden" name="mode" value="nchk">
		<?php
		foreach( $_POST AS $key => $value ){
			if( is_array($value) ){
				foreach( $value AS $inkey => $invalue ){
					if( is_array($invalue) ){
						foreach( $invalue AS $prdkey => $prdvalue ){
		?>
			<input type="hidden" name="<?php echo $key;?>[<?php echo $inkey;?>][<?php echo $prdkey;?>]" value="<?php echo $prdvalue;?>">		
		<?php
						}
					}else{
		?>
			<input type="hidden" name="<?php echo $key;?>[]" value="<?php echo $invalue;?>">
		<?php
					}
				}
			}
		}
		?>
	</form>
	<script>
		var savechk = confirm("중복된 자료가 <?php echo number_format($insert_n);?>건 있습니다. \n 계속 진행하시겠습니까?");
		if( savechk ){
			$( "#reform" ).submit();
		}else{
			// 여기에 취소했을때 이동하는 스크립트나.. 뭐 그런거 작성하시면 되요.
			location.href = 'out.php';
//			history.back();
		}
	</script>
	</body>
	</html>
<?php
	exit();
}



$result = true;
foreach( $name AS $key => $value ){
	$tel[$key] = add_hyphen_telNo($tel[$key]);
   $query = "insert into orders ( o_name, o_store, o_tel, o_address, o_ex, o_ex2, o_type, o_date) values ('{$value}','{$store}','{$tel[$key]}','{$address[$key]}','{$ex[$key]}','{$ex2[$key]}','{$type[$key]}', now())";
   $db->query($query);
   $oid = $db->insert_id;
   if( !$oid ){
      $result = false;
   }else{
      foreach( $code[$key] AS $inkey => $invalue ){
         $query = "insert into orders_goods ( og_num, p_code, og_qty ) values ( '{$oid}', '{$invalue}','{$qty[$key][$inkey]}' )";
         $db->query($query);

		 $query =  "insert into stock  ( s_code, og_num, s_outstock, s_date) values ( '{$invalue}','{$oid}','{$qty[$key][$inkey]}',now())";
		 $db->query($query);

		 $query = "update product set p_stock = p_stock - ".intVal($qty[$key][$inkey])." where p_code = '$invalue'";
		  $db->query($query);
      }
   }
}

   if($result) { // query가 정상실행 되었다면,
      $msg = "입력이 완료 되었습니다.";
      $replaceURL = 'order_list.php';
   } else {
      $msg = "입력 실패했습니다.";
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

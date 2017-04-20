<?php
	require_once("../dbconfig.php");

	$pName = $_POST['pName'];
    $mode = $_POST['mode'];


	$insert_n = 0;
	if( !$mode ){		
//		foreach( $pName AS $key => $value ){
			$row = '';
			$query = "SELECT count(*) AS cou from product WHERE p_name = '{$pName}'";
			$result = $db->query($query);
			$row = $result->fetch_assoc();
			if( $row['cou'] ){
				$insert_n++;
			}
//		}
	}
	if( $insert_n ){
		echo "<script>alert('상품이 중복되었습니다.'); history.back(-1);</script>";
		exit();
	}



	$sql = 'insert into product (p_code, p_name) select concat((select lpad(count(*)+1,3,"0") from product)), "' . $pName . '"';

	$result = $db->query($sql);
	if($result) { // query가 정상실행 되었다면,
		$msg = "상품이 등록되었습니다.";
		$replaceURL = 'product.php';
	} else {
		$msg = "상품을 등록하지 못했습니다.";
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
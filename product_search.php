<?php
	require_once("dbconfig.php");
	include("header.php");

	$search = $_POST["search"];
	$searchType = $_POST["searchType"];


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
		<h3>상품 검색결과</h3>
	<form id="hiddenForm" style="display:none;" action="search_update.php" method="post">
		   <input type="text" name="search" value="<?php echo $search?>" >
		   <input type="text" name="searchType" value="<?php echo $searchType?>" >
		   <input type="text" name="ord" value="<?php echo $ord_rev?>" >
	</form>
		<table class="table table-striped">
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
					if($searchType && $search){
						$sql = "select p.p_code, p.p_name, p.p_stock, sum(s.s_instock + s.s_return), sum(s.s_outstock) from product as p, stock as s where p.p_code = s.s_code and $searchType like '%$search%'";
					}
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
					<td class="product"><?php echo $row['p_name']?></td>
					<td class="stock"><?php echo $row['p_stock']?></td>
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
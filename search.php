<?php 
	require_once("dbconfig.php");
	include("header.php");
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
<body>
<form action="search_update.php" method="post">
	   <select name="searchType">
		<option value="O.o_name">이름</option>
		<option value="O.o_tel">전화번호</option>
		<option value="O.o_delivery_num">운송장번호</option>
	   </select>
       <input type="text" class="form-control" name="search">
        <button type="submit">검색</button>
</form>
</body>
</head>
</html>
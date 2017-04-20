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
		jQuery.noConflict();
			(function($){
				$(document).on("keyup", "input:text[dnum]", function(){$(this).val($(this).val().replace(/[^0-9:\-]/gi,""));});
			$(document).ready(function(){
				

				//삭제 버튼
				$( "#input_table" ).on("click",".del",function() {
				 $( this ).closest("tr").remove();
				});
			  /* 기본 폼 복사 */
				var cloneEleTr = $( "#default_form").clone();
			  cloneEleTr.removeAttr("id");
			  cloneEleTr.find("input").val("");
				//추가 버튼을 눌렀을경우
				$("#add").click(function(){
					$("#input_table").append(cloneEleTr.clone());
				});
			});
		})(jQuery);
	</script>
</head>
<body>
		<?php
			//echo '<div id="day3">'. ("TODAY : ") . date("Y-m-d") . '</div>'
			include("../header.php");
		?>
	<article class="boardArticle">
	
		
		
		<table class="table table-striped table-hover">
			<thead>
				<tr>
					<th class="num" scope="col">번호</th>
					<th class="user_id" scope="col">지점</th>
					<th class="user" scope="col">이름</th>
					<th class="phone" scope="col">연락처</th>
					<th class="add2" scope="col">주&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;소</th>
					<th class="pd" scope="col">품&nbsp;&nbsp;&nbsp;&nbsp;목</th>
					<th class="qty" scope="col">수량</th>
					<th class="cs" scope="col">지원품목</th>
					<th class="box2" scope="col">박스</th>
					<th class="coast2" scope="col">비용</th>
					<th class="dn" scope="col">운송장번호</th>
					<th class="dt" scope="col">배송타입</th>
					<th scope="col">비&nbsp;&nbsp;&nbsp;&nbsp;고</th>
					<th class="gr" scope="col">관리</th>
				</tr>
			</thead>
			<tbody>
					<?php
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
								date_format( O.o_date,  '%Y-%m-%d' ) = CURRENT_DATE() 
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
				  <td><input type='hidden' class='no' value='<?php echo $row['o_no']?>' readonly /><?php echo $row['o_no']?></td>
				  <td><?php echo $row['o_store'];?></td>
				  <td><?php echo $row['o_name'];?></td>
				  <td><?php echo $row['o_tel'];?></td>
				  <td><?php echo $row['o_address'];?></td>
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
						?>
						<?php
							echo $invalue.'<br>';
						}
						?>
					</td>
				  <td><input type='text' class='ex' value='<?php echo $row['o_ex'];?>' /></td>
				  <td><input type="number" class="box" value="<?php echo $row['o_box']?>" /></td>
				  <td><input type="text" class="delivery" value="<?php echo $row['o_delivery']?>" onkeyPress="if ((event.keyCode<48) || (event.keyCode>57)) event.returnValue=false;" /></td>
				  <td><input type="text" class="delivery_num" value="<?php echo $row['o_delivery_num']?>" dnum="true"  /></td>
				  <td><?php echo $row['o_type'];?></td>
				  <td><input type='text' class='ex2' value='<?php echo $row['o_ex2'];?>' /></td>
				  <td>
				  <button type="button" class="update btn btn-default">입력</button>
				  <button type="button" id="deleteForm" class="delete btn btn-default">삭제</button>
				  </td>
			   </tr>
			   </form>
					<?php
						}
					?>
			</tbody>
		</table>
		<form action="order_s_inupdate.php" method="post" id="order_update">
			<input type="hidden" class="input_mode" name="mode" value="update">
			<input type='hidden' class='no'  name='no' value='<?php echo $row['o_ex'];?>' />
			<input type='hidden' class='ex' name='ex' value='<?php echo $row['o_ex'];?>' />
			<input type='hidden' class='ex2' name='ex2' value='<?php echo $row['o_ex2'];?>' />
			<input type='hidden' class='box' name='box' value='<?php echo $row['o_ex2'];?>' />
			<input type="hidden" class="delivery" name='delivery' value="<?php echo $row['o_delivery']?>" />
			<input type="hidden" class="delivery_num" name='delivery_num' value="<?php echo $row['o_delivery_num']?>" />
		</form>
		<script type="text/javascript">
		 (function($) {
			 var isClick = false;
			$( ".update" ).click(function(){
				var target = $( this ).closest("tr");
				values( target, "update" );
			});
			$( ".delete" ).click(function(){
				
			if (confirm("삭제하시겠습니까?") == true && isClick == false){
				   isClick = true;
			  }
			  else{ //취소
				 return false;
			  }
				var target = $( this ).closest("tr");
				values( target, "delete" );
			});
			function values( n , type ){
				var no = n.find( "input.no" ).val();

				var ex = n.find( "input.ex" ).val();
				var ex2 = n.find( "input.ex2" ).val();
				var box = n.find( "input.box" ).val();
				var delivery = n.find( "input.delivery" ).val();
				var delivery_num = n.find( "input.delivery_num" ).val();

				$( "#order_update" ).find(  "input.input_mode" ).val( type );
				$( "#order_update" ).find(  "input.no" ).val( no );
				$( "#order_update" ).find(  "input.ex" ).val( ex );
				$( "#order_update" ).find(  "input.ex2" ).val( ex2 );
				$( "#order_update" ).find(  "input.box" ).val( box );
				$( "#order_update" ).find(  "input.delivery" ).val( delivery );
				$( "#order_update" ).find(  "input.delivery_num" ).val( delivery_num );
				$( "#order_update" ).submit();
			}
		})(jQuery);
		</script>
		
		
					
		
	</article>
</body>
</html>

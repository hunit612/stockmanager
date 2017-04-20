<?php
include_once("dbconfig.php");

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
<meta charset="utf-8">
<title>나음터재고관리</title>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.11.1.js"></script>
  <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
  <script src="http://code.jquery.com/jquery-1.10.2.js"></script>
  <script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<link rel='stylesheet' href='style/style.css' type='text/css'>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
<script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
<script>
	function onlyNumber(event){
		event = event || window.event;
		var keyID = (event.which) ? event.which : event.keyCode;
		if ( (keyID >= 48 && keyID <= 57) || (keyID >= 96 && keyID <= 105 || keyID ==9) || keyID == 8 || keyID == 46 || keyID == 37 || keyID == 39 ) 
			return;
		else
			return false;
	}
	function removeChar(event) {
		event = event || window.event;
		var keyID = (event.which) ? event.which : event.keyCode;
		if ( keyID == 8 || keyID == 46 || keyID == 37 || keyID == 39 ) 
			return;
		else
			event.target.value = event.target.value.replace(/[^0-9]/g, "");
	}

	//주소관련
    function sample6_execDaumPostcode(target) {
        new daum.Postcode({
            oncomplete: function(data) {
                // 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

                // 각 주소의 노출 규칙에 따라 주소를 조합한다.
                // 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
                var fullAddr = ''; // 최종 주소 변수
                var extraAddr = ''; // 조합형 주소 변수

                // 사용자가 선택한 주소 타입에 따라 해당 주소 값을 가져온다.
                if (data.userSelectedType === 'R') { // 사용자가 도로명 주소를 선택했을 경우
                    fullAddr = data.roadAddress;

                } else { // 사용자가 지번 주소를 선택했을 경우(J)
                    fullAddr = data.jibunAddress;
                }

                // 사용자가 선택한 주소가 도로명 타입일때 조합한다.
                if(data.userSelectedType === 'R'){
                    //법정동명이 있을 경우 추가한다.
                    if(data.bname !== ''){
                        extraAddr += data.bname;
                    }
                    // 건물명이 있을 경우 추가한다.
                    if(data.buildingName !== ''){
                        extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
                    }
                    // 조합형주소의 유무에 따라 양쪽에 괄호를 추가하여 최종 주소를 만든다.
                    fullAddr += (extraAddr !== '' ? ' ('+ extraAddr +')' : '');
                }

                document.getElementById(target).value = fullAddr;

                // 커서를 상세주소 필드로 이동한다.
                document.getElementById(target).focus();
            }
        }).open();
    }

 $(document).ready(function(){
	$('input[name=oName]').keyup(function(event){
		regexp = /^[가-힣a-zA-Z]+$/g;
		v = $(this).val();
		if (regexp.test(v))
		{
			$(this).val(v.replace(regexp,''));
		}
	});

  var rowTag = $("#input_table").html();
  $(".tbtd_caption").data("rowTag", rowTag);  
  //키값 rowTag로 테이블의 기본 row 값의 Html태그 저장
 }); 
  

 /*  현재행 삭제 기능 */ 
 function rowDelete(obj){
  $(obj).parent().parent().remove();
 }

 /*  체크박스 선택행 삭제 기능 */ 
 function rowCheDel(){
  var $obj = $("input.chk_list");
  var checkCount = $obj.size();
  for (var i=0; i<checkCount; i++){
   if($obj.eq(i).is(":checked")){
   $obj.eq(i).parent().parent().remove();
   }
  }
  renumbering();
 }
 function rowCheDel2(){
  var $obj = $("input.chk_list");
  var checkCount = $obj.size();
  for (var i=0; i<checkCount; i++){
   if($obj.eq(i).is(":checked")){
   $obj.eq(i).parent().parent().remove();
   }
  }
  renumbering();
 }
 // document ready 안에 있는 함수를 한번 더 써줬어요.
 // 삭제후에 번호 새로 매기기
function renumbering(){
	$( ".renumber_wrap" ).each(function(e){// tr each
		var num = e+1;
		$( this ).find("td.input_tablen").html( num );	// 번호 

		$( this ).find("input.renumber_chk_list").attr({"name":"chk_list["+e+"]"});	// 체크박스
		$( this ).find("input.renumber_oName").attr({"name":"oName["+e+"]"});		// 성함
		$( this ).find("input.renumber_oTel").attr({"name":"oTel["+e+"]"});			// 연락처
		$( this ).find("input.renumber_oAddress").attr({"name":"oAddress["+e+"]"}).attr({"id": "sample6_address_" +  e  });		// 주소
		$( this ).find("input.renumbr_oAddress_btn").attr({"onclick":"sample6_execDaumPostcode(\"sample6_address_"+e+"\")"});		// 주소 버튼
		$( this ).find("button.renumber_itemSearch_btn").attr({"data-index":e});		// 상품검색 버튼
		$( this ).find("td.renumber_oCode_td").attr({"id":"oCode_"+e}).find("input.renumber_oCode").each(function(n){
			$( this ).attr({"name":"oCode["+e+"]["+n+"]"});		// 등록된 품목
		});
		$( this ).find("td.renumber_oQty_td").attr({"id":"oQty_"+e}).find("input.renumber_oQty").each(function(n){
			$( this ).attr({"name":"oQty["+e+"]["+n+"]"});			// 등록된 수량
		});
		$( this ).find("select.renumber_oType").attr({"name":"oType["+e+"]"});		// 배송타입
		$( this ).find("input.renumber_oEx2").attr({"name":"oEx2["+e+"]"});
	});
	/*
	$( ".input_tablen" ).each(function(e){
		var num = e+1;
		$( this ).html( num );
	});
	*/
}

 /* 체크박스 전체선택/해제 기능 */
 function selectAll(){
  if($("#chk_list").is(":checked")){

  //  $("input[name=chk]").attr("checked",true);
	//$("input[name=chk]").prop("checked",true);
	$(".chk_list").prop("checked",true);
  }
  else{
	//$("input[name=chk]").prop("checked",false);
	$(".chk_list").prop("checked",false);
  }
 }
</script>
<script>
jQuery.noConflict();
(function($){
    $(document).ready(function(){
		// 출고 테이블이 만들어진 직후 번호를 매겨줍니다.
		renumbering();
		var isClick = false;
		/* 전송버튼 */
		$("#sendSubmit").click(function(){
		  if (confirm("입력 하시겠습니까?") == true && isClick == false){
			   isClick = true;
			   $("#send").submit();
		  }
		  else{ //취소
			 return false;
		  }
		});
		$("#delForm").click(function(){
		if (confirm("삭제하시겠습니까?") == true && isClick == false){
			   isClick = true;
		  }
		  else{ //취소
			 return false;
		  }
		});
		$("#downSubmit").click(function(){
			var isOk = true;
			$("#input_table").find("tr").each(function(e){
				if( e > 0 ){
					var validationCode = $( this ).find("[name^='oCode']");
					var validationQty = $( this ).find("[name^='oQty']");
					// 선택된 항목이 있는지검사.
					var lenchk = validationCode.length;
					if( !lenchk ){
						isOk = false;
						alert('상품을 선택하세요.');
						return false;
					}
					// 품목 따로 수량 따로 검사.
					validationCode.each(function(){
						var valchk = $( this ).val();
						if( !valchk ) isOk = false;
					});
					validationQty.each(function(){
						var valchk = $( this ).val();
						if( !valchk ) isOk = false;
					});
					if( !isOk ){
						alert("품목 및 수량을 입력하세요.");
						return false;
					}
				}
			});
			if( isOk ){
				$("#upForm").submit();
			}
			
		});


        //삭제 버튼
		
        $( "#input_table" ).on("click",".del",function() {
         $( this ).closest("tr").remove();
        });
        $( "#input_table2" ).on("click",".del",function() {
         $( this ).closest("tr").remove();
        });
        //추가 버튼을 눌렀을경우
        $("#add").click(function(){
         var tr_n = $( "#input_table" ).find("tr").size();
		 tr_n = parseInt( tr_n,10 )-1;
         var html = $('<tr class="renumber_wrap">'+
               '<td><input type="checkbox" name="chk_list['+tr_n+']" class="chk_list renumber_chk_list" value=""/></td>'+
               '<td class="input_tablen"></td>'+
               '<td><input type="text" name="oName['+tr_n+']" class="renumber_oName" value=""/></td>'+
            '<td><input type="text" name="oTel['+tr_n+']" class="renumber_oTel" onkeydown="return onlyNumber(event)" onkeyup="removeChar(event)"  value=""/></td>'+
            '<td><input type="text" id="sample6_address_+'+tr_n+'" placeholder="주소"  class="inputBox2 renumber_oAddress" name="oAddress['+tr_n+']"  value=""/><input type="button" class="inputBtn renumbr_oAddress_btn" onclick="sample6_execDaumPostcode(\'sample6_address_+'+tr_n+'\')" value=""></td>'+
            '<td><button class="btnItemSearch btn btn-default renumber_itemSearch_btn" type="button" data-index="'+tr_n+'">상품검색</button></td>'+
            '<td id="oCode_'+tr_n+'" class="renumber_oCode_td"></td>'+
            '<td id="oQty_'+tr_n+'" class="renumber_oQty_td"></td>'+
            '<td><select name="oType['+tr_n+']" class="renumber_oType">'+
                  '<option value="입고">입고</option>'+
                 '<option value="반품">반품</option>'+
                 '<option value="기타입고">기타입고</option>'+
                  '</select>'+
            '</td>'+ 
            '<td><input type="text" name="oEx2['+tr_n+']" class="renumber_oEx2" value=""/></td>'+ 
            '</tr>');
            $("#input_table").append(html);
			renumbering();
        });
		function renumbering(){
			$( ".renumber_wrap" ).each(function(e){// tr each
				var num = e+1;
				$( this ).find("td.input_tablen").html( num );	// 번호 
				$( this ).find("input.renumber_chk_list").attr({"name":"chk_list["+e+"]"});	// 체크박스
				$( this ).find("input.renumber_oName").attr({"name":"oName["+e+"]"});		// 성함
				$( this ).find("input.renumber_oTel").attr({"name":"oTel["+e+"]"});			// 연락처
				$( this ).find("input.renumber_oAddress").attr({"name":"oAddress["+e+"]"}).attr({"id": "sample6_address_" +  e  });		// 주소
				$( this ).find("input.renumbr_oAddress_btn").attr({"onclick":"sample6_execDaumPostcode(\"sample6_address_"+e+"\")"});		// 주소 버튼
				$( this ).find("button.renumber_itemSearch_btn").attr({"data-index":e});		// 상품검색 버튼
				$( this ).find("td.renumber_oCode_td").attr({"id":"oCode_"+e}).find("input.renumber_oCode").each(function(n){
					$( this ).attr({"name":"oCode["+e+"]["+n+"]"});		// 등록된 품목
				});
				$( this ).find("td.renumber_oQty_td").attr({"id":"oQty_"+e}).find("input.renumber_oQty").each(function(n){
					$( this ).attr({"name":"oQty["+e+"]["+n+"]"});			// 등록된 수량
				});
				$( this ).find("select.renumber_oType").attr({"name":"oType["+e+"]"});		// 배송타입
				$( this ).find("input.renumber_oEx2").attr({"name":"oEx2["+e+"]"});
			});
			/*
			$( ".input_tablen" ).each(function(e){
				var num = e+1;
				$( this ).html( num );
			});
			*/
		}
   $( "#input_table" ).on("click",".btnItemSearch",function(){
      var index = $( this ).attr("data-index");
      
      $( "#add_codes" ).attr({"data-index":index});
      $( "#itemDiv" ).find(".code_checkbox").prop({"checked":false});
      $( "#itemDiv" ).show();
   });

   $( "#add_codes" ).click(function(){      // 상품 확인 클릭
      var index = $( this ).attr("data-index");
      $( "#oCode_"+index ).empty();            // 기존 선택 상품 삭제
      $( "#oQty_"+index ).empty();               // 기존 선택 상품 삭제
      var num = 0;
      $( ".code_checkbox" ).each(function(){
         var value = $( this ).attr("data-code");
         var name = $( this ).attr("data-name");
         if( $( this ).prop("checked") ){
            $( "#oCode_"+index ).append( $( '<input type="hidden" name="oCode['+index+']['+num+']" class="renumber_oCode" value="'+value+'|'+name+'"><input type="text" readonly value="'+name+'" /><br>' ) );
            $( "#oQty_"+index ).append( $( '<input type="number" name="oQty['+index+']['+num+']" class="renumber_oQty" value="1"><br>' ) );
            num++;
         }
      });
      // 닫기
      $( "#itemDiv" ).find(".code_checkbox").prop({"checked":false});
      $( "#itemDiv" ).hide();

   });
    
    });	


})(jQuery);
 </script>
</head>
<body>
		<?php
//			echo '<div id="day">'. ("TODAY : ") . date("Y-m-d") . '</div>'
			//$selectedDate = $_POST['selectedDate'];
			//echo '".$selectedDate ."' ;
			
		?>

   <article class="boardArticle">
<form id="upForm" action="in.php" method="post">
<div class="btn-wrapio">
<button type="button" id="add" class="inout"><img src="img/plus_icon.jpg"></button>
<button type="button" class="del" onClick="rowCheDel();"><img src="img/delet_icon.jpg"></button>
<button type="button" id="downSubmit" class="inout"><img src="img/enter_icon.jpg"></button>
</div>
<?php
// 품목 sql
$oCode_sql = "select p_name,p_code from product ORDER BY p_name asc"; 
$oCode_result = $db->query($oCode_sql);
$ocode_arr = array();
while( $list =$oCode_result->fetch_assoc() ){      // mysql_fetch_array OR mysql_fetch_assoc
   $ocode_arr[] = $list;
}
?>
<table id="input_table" class="table table-striped table-hover tbtd_caption">
    <tr>
      <th class="chkinput" scope="row"><INPUT TYPE="checkbox" ID="chk_list" name="chk_list" value="" onClick="selectAll()" ></th>
      <th class="num2" scope="row"><label for="oNum">번호</label></th>
      <th class="userid" scope="row"><label for="oName">성함</label></th>
      <th class="tel2" scope="row"><label for="oTel">연락처</label></th>
      <th class="add" scope="row"><label for="oAddress">주&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;소</label></th>
      <th scope="row"><label for="productSearch">상품검색</label></th>
      <th class="prd" scope="row"><label for="oCode">품목</label></th>
      <th class="qty2" scope="row"><label for="oQty">수량</label></th>
      <th scope="row" class="btype"><label for="oType">배송타입</label></th>  
      <th scope="row"><label for="oEx2">비&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;고</label></th>
    </tr>
   <?php
   $row_count = count( $_POST['oName'] );
   if( !$row_count ) $row_count = 1;
   for($i = 0; $i < $row_count; $i++ ){
   ?>
    <tr<?php echo ($i == 0 )?' id="default_form"':'';?> class="insert_form renumber_wrap">
		<td><INPUT TYPE="checkbox" name="chk_list" class="chk_list renumber_chk_list"></td>
        <td class="input_tablen"></td>
        <td><input type='text' class="inputBox" name='oName[<?php echo $i;?>]' class="renumber_oName" style="ime-mode:active;" value="<?php echo $_POST['oName'][$i];?>"/></td>
        <td><input type='text' class="inputBox" name='oTel[<?php echo $i;?>]' class="renumber_oTel" onkeydown='return onlyNumber(event)' onkeyup='removeChar(event)' style='ime-mode:disabled;' value="<?php echo $_POST['oTel'][$i];?>"/></td>
        <td>	<input type="text" id="sample6_address_<?php echo $i;?>" placeholder="주소"  class="inputBox2 renumber_oAddress" name='oAddress[<?php echo $i;?>]' value="<?php echo $_POST['oAddress'][$i];?>">
				<input type="button" class="inputBtn renumbr_oAddress_btn" onclick="sample6_execDaumPostcode('sample6_address_<?php echo $i;?>')" value=""></td>
        <td><button class="btnItemSearch btn btn-default renumber_itemSearch_btn" type="button" data-index="<?php echo $i;?>">상품검색</button></td> 
        <td id="oCode_<?php echo $i;?>" class="renumber_oCode_td">
         
         <?php
         foreach( $_POST['oCode'][$i] AS $key => $value ){
            $codearr = array();
              $codearr = explode("|",$value);
         ?>
         <input type="hidden" name="oCode[<?php echo $i;?>][<?php echo $key;?>]" value="<?php echo $value;?>">
         <?php echo $codearr[1];?>
         <br>
         <?php
         }
         ?>
      </td>  
        <td id="oQty_<?php echo $i;?>" class="renumber_oQty_td">
         <?php
         foreach( $_POST['oQty'][$i] AS $key => $value ){
         ?>
         <input type="text" class="inputBox" name="oQty[<?php echo $i;?>][<?php echo $key;?>]" value="<?php echo $value;?>">
         <br>
         <?php
         }
         ?>
      </td>  
      <td><select class="inputBox" name='oType[<?php echo $i;?>]' class="renumber_oType">
      <option value="입고">입고</option>
      <option value="반품">반품</option>
      <option value="기타입고">기타입고</option>
     </select></td> 
        <td><input type='text' class="inputBox" name='oEx2[<?php echo $i;?>]' class="renumber_oEx2" value="<?php echo $_POST['oEx2'][$i];?>"/></td> 
    </tr>
   <?php
   }
   ?>
</table>
</form>
<br/>

<form action="in_update.php" method="post" id="send" name="send" class="table table-striped table-hover">
<input type="hidden" name='oStore' value='<?php echo $_SESSION["user_store"];?>' />
<?php
if( is_array( $_POST['oName'] ) ){
   $post_count      = count( $_POST['oName'] );
?>
<p class="sub-title2">출고 재확인</p>
<div class="btn-wrapio2"><button type="button" class="del in-btn" onClick="rowCheDel();"><img src="img/delet_icon.jpg"></button>
<button type="button" id="sendSubmit"  class="inout" ><img src="img/enter_icon.jpg"></button>
</div>

<table id="input_table2" class="table table-striped table-hover inTable">
    <tr>
      <th class="chkinput" scope="row"></th>
      <th class="num2" scope="row"><label for="oNum">번호</label></th>
      <th class="userid" scope="row"><label for="oName">성함</label></th>
      <th class="tel2" scope="row"><label for="oTel">연락처</label></th>
      <th class="add" scope="row"><label for="oAddress">주소</label></th>
      <th class="prd" scope="row"><label for="oCode">품목</label></th>
      <th class="qty2" scope="row"><label for="oQty">수량</label></th>
      <th scope="row" class="btype"><label for="oType">배송타입</label></th>  
      <th scope="row"><label for="oEx2">비고</label></th> 
    </tr>
   <?php
   for( $i = 0; $i < $post_count; $i++ ){
   
   ?>
   <tr>
        <td><INPUT TYPE="checkbox" ID="chk_list" name="chk_list" class="chk_list"></td>
        <td class="input_tablen"></td>
      <td><input type='text' name='name[]' value='<?php echo $_POST['oName'][$i];?>' readonly /></td>
      <td><input type='text' name='tel[]' value='<?php echo $_POST['oTel'][$i];?>' readonly /></td>
      <td><input type='text' name='address[]' value='<?php echo $_POST['oAddress'][$i];?>' readonly /></td>
      <td>
      <?php
      foreach( $_POST['oCode'][$i] AS $key => $value ){
        $codearr = array();
        $codearr = explode("|",$value);
      ?>
      <input type='hidden' name='code[<?php echo $i;?>][<?php echo $key;?>]' value='<?php echo $codearr[0];?>'><input type="text" value="<?php echo $codearr[1];?>" readonly><br>
      <?php
      }
      ?>
      </td>
      <td>
		  <?php
		  foreach( $_POST['oQty'][$i] AS $key => $value ){
		  ?>
		  <input type="text" name="qty[<?php echo $i;?>][<?php echo $key;?>]" value="<?php echo $value;?>" readonly><br>
		  <?php
		  }
      ?>
	  </td>
      <td><input type='text' name='type[]' value='<?php echo $_POST['oType'][$i];?>' readonly /></td>
      <td><input type='text' name='ex2[]' value='<?php echo $_POST['oEx2'][$i];?>' readonly /></td>
   </tr>
   <?php
   }
   ?>
</table>
<?php
}
?>
</form>

<script type="text/javascript" >
var $pop = $('#itemDiv').clone();
var left = ( $(window).scrollLeft() + ($(window).width() - $pop.width())/2);
var top = ( $(window).scrollTop() + ($(window).height() - $pop.height())/2);
$pop.css({'left':left,'top':top, 'position':'absolute'});
//$pop.show();
$('body').css('position','relative').append($pop);
</script>

<div id="itemDiv" style="width:50%; height:auto; position:fixed;  background:#FFF; z-index:2; border:1px solid #CCC; display:none; ">
   <ul id="itemGrid">
      <?php
      foreach( $ocode_arr AS $key => $value ){
      ?>
      <li class="productList">
         <input type="checkbox" id="code_checkbox_<?php echo $key;?>" class="code_checkbox" data-code="<?php echo $value['p_code'];?>" data-name="<?php echo $value['p_name'];?>">
         <label class="pList" for="code_checkbox_<?php echo $key;?>"><?php echo $value['p_name'];?></label>
      </li>
      <?php
      }
      ?>
   </ul>
   <div class="btn-wrap">
   <button class="btn btn-default" id="add_codes" data-index="">확인</button>
   </div>
</div>
</article>
</body>
</html>
<?php require 'tpl/header.php';?>
<div class="main">
	<div class="step">
		<ul>
			<li class="ok" class="ok"><em>1</em><?php echo $lang['detection_environment']; ?></li>
			<li class="ok"><em>2</em><?php echo $lang['data_create']; ?></li>
			<li class="current"><em>3</em><?php echo $lang['complete_installation']; ?></li>
		</ul>
	</div>
	<div class="process"><div class="process_go">0%</div></div>
	<div class="install_process"></div>
	<div class="action">
	<a href="javascript:history.go(-1);" class="btn_blue"><?php echo $lang['previous'];?></a><a href="javascript:void(0);"  onClick="$('#install').submit();return false;" class="btn_x pre" id="finish"><?php echo $lang['Installation'];?>..</a>
</div>
<script type="text/javascript">
var timerId;
var num =0;
$(function(){
	//install(0);
	postData();
	$('.install_process').append('<p><?php echo $lang['Data_initialization'];?>...</p>').scrollTop(500000);
	timerId = setInterval(setNext,1000);

})

function postData() {
	$.post('index.php?step=4',{'act':'db'},function(data){
		clearInterval(timerId);
		if(data.status == 'error') {
			
			$('.install_process').append('<p style="color:red;">'+data.info+'</p>').scrollTop(500000);				
			$('.install_process').append('<p style="color:red;"><?php echo $lang['installation_failed_reinstall']; ?></p>');		
			$('#finish').removeClass('pre');
			$('#finish').html('<?php echo $lang['installation_failed']; ?>');
			//alert(data.info);
			return false;
		}else if(data.status == 'success_all') {			
			$('.process_go').width('100%');
			$('.process_go').html('100%');
			$('.install_process').append('<p>'+data.info+'</p>').scrollTop(500000);
			$('.install_process').append('<p style="color:green;"><?php echo $lang['installation_complete']; ?></p>');
			$('#finish').removeClass('pre');
			$('#finish').html('<?php echo $lang['installation_complete']; ?>');
			setTimeout(function(){window.location.href = 'index.php?step=5'},1000);
		}
	},'json');
}

function setNext() {
	num = num+10;
	$('.process_go').width(num+'%');
	$('.process_go').html(num+'%');
	if(num >= 100) {
		num = 0;
	}
}
</script>
</body>
</html>
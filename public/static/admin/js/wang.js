/**
 * Created by Administrator on 2016-08-10.
 */
;$(function(){
	//清除缓存
	$("#clear-cache").click(function(){
		$.ajax({
			url:'/admin/index/clear',
			dataType:'json',
			success:function(res){
				if(res.status){
					alertw(res.msg);
					//location.reload();
				} else {
					alertw(res.msg);
				}
			},
			error:function(res){
				alertw('error');
			}
		});
	});
});
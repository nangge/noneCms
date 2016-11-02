/**
 * Created by Administrator on 2016-08-10.
 */
;$(function(){
	/**登录**/
	//验证码简单处理
	$("input[name='captcha']").focus(function(){
		$(this).val('');
		$(".captcha").show();
	});

	$("#login-submit").click(function(){
			var username = $("input[name='username']").val();
			var passwd = $("input[name='password']").val();
			var captcha = $("input[name='captcha']").val();
			if(!username){
				alerts('用户名不能为空！');
				return false;
			}

			if(!passwd){
				alerts('密码不能为空！');
				return false;
			}

			if(!captcha){
				alerts('验证码不能为空！');
				return false;
			}

			$.ajax({
				url: login,
				data: {
					username: username,
					password: passwd,
					captcha: captcha
				},
				type: 'post',
				dataType: 'json',
				success:function(res){
					if(res.status){
						window.location.href = res.url;
					} else {
						alerts(res.msg);
					}
				},
				error:function(res){
					alerts('error');
				}
			});
		});
	
	//退出登录
	$("#logout").click(function(){
		$.ajax({
			url:logout,
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
				console.log(res);
				alertw('error');
			}
		});
	});

	/**清除缓存**/
	$("#clear-cache").click(function(){
		$.ajax({
			url:cache,
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
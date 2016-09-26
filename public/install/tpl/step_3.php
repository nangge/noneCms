<?php require 'tpl/header.php';?>
	<div class="main">
		<div class="step">
			<ul>
				<li class="ok"><em>1</em><?php echo $lang['detection_environment']; ?></li>
				<li class="current"><em>2</em><?php echo $lang['data_create']; ?></li>
				<li><em>3</em><?php echo $lang['complete_installation']; ?></li>
			</ul>
		</div>
		<form action="index.php?step=3" method="post">
		<table class="table1">
			<tr>
				<th width="10%">数据库服务器</th>
				<th>安装后,原数据库会被清空,请做好备份</th>
				<th>&nbsp;</th>
			</tr>
			<tr>
				<td><font class="red">*</font>&nbsp;数据库服务器：</td>
				<td><input type="text" class="text" value="127.0.0.1" name="DB_HOST" /></td>
				<td>本地填写：127.0.0.1或IP</td>
			</tr>
			<tr>
				<td><font class="red">*</font>&nbsp;数据库端口：</td>
				<td><input type="text" class="text" value="3306" name="DB_PORT" /></td>
				<td>数据库端口默认为3306</td>
			</tr>
			<tr>
				<td><font class="red">*</font>&nbsp;数据库用户名：</td>
				<td><input type="text" class="text" value="root" name="DB_USER" /></td>
				<td>请填写具有root权限的用户</td>
			</tr>
			<tr>
				<td>数据库密码：</td>
				<td><input type="text" class="text" value="" name="DB_PWD" /></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td><font class="red">*</font>&nbsp;数据库名称：</td>
				<td><input type="text" class="text" value="wang" name="DB_NAME" /></td>
				<td>不存在则自动创建</td>
			</tr>
			<tr>
				<td><font class="red">*</font>&nbsp;数据库表前缀：</td>
				<td><input type="text" class="text" value="wang_" name="DB_PREFIX" /></td>
				<td>不推荐使用默认表前缀</td>
			</tr>
			<tr>
				<th>网站配置</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
			</tr>
			<tr>
				<td>网站名称：</td>
				<td><input type="text" class="text" value="我的网站" name="WEB_NAME" /></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td><font class="red">*</font>&nbsp;网站网址：</td>
				<td><input type="text" class="text" value="<?php echo $weburl;?>" name="WEB_URL" /></td>
				<td>请带上协议头http://或https://</td>
			</tr>
			<!--<tr>
				<td><font class="red">*</font>&nbsp;网站风格：</td>
				<td><input type="radio" name="WEB_STYLE" value="default" checked="checked">< ?php /*echo $lang['site_style_c']; */?><input type="radio" name="WEB_STYLE" value="blog">< ?php /*echo $lang['site_style_b']; */?></td>
				<td>&nbsp;</td>
			</tr>-->
			<tr>
				<th>网站超级管理员</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
			</tr>
			<tr>
				<td><font class="red">*</font>&nbsp;用户名：</td>
				<td><input type="text" class="text" value="wang" name="username" /></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td><font class="red">*</font>&nbsp;密　码：</td>
				<td><input type="text" class="text" value="" name="password" /></td>
				<td>请设置最少6位密码</td>
			</tr>
			<tr>
				<td><font class="red"></font>&nbsp;E-mail：</td>
				<td><input type="text" class="text" value="" name="email" /></td>
				<td>&nbsp;</td>
			</tr>			
			<tr>
				<td>测试数据：</td>
				<td><label><input type="checkbox" value="1" name="add_test" /><?php echo $lang['test_data_intro']; ?></label></td>
				<td>&nbsp;</td>
			</tr>			
		</table>
		<div class="action"><a href="javascript:history.go(-1);" class="btn_blue">上一步</a>&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" class="btn_blue" onclick="postData()">下一步</a></div>
		</form>
	</div>
<script type="text/javascript">
function postData() {
	var _postForm = $('form').serialize();
	$.post('index.php?step=3',_postForm,function(data){
		if(data.status == 'error') {
			alert(data.info);
			return false;
		} else {

			window.location.href = 'index.php?step=4';
		}
	},'json');
}
</script>
</body>
</html>
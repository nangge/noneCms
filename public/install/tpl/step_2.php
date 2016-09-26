<?php require 'tpl/header.php';?>
	<div class="main">
		<div class="step">
			<ul>
				<li class="current"><em>1</em><?php echo $lang['detection_environment']; ?></li>
				<li><em>2</em><?php echo $lang['data_create']; ?></li>
				<li><em>3</em><?php echo $lang['complete_installation']; ?></li>
			</ul>
		</div>
		<table class="table1">
			<tr>
				<th><?php echo $lang['environmental_testing']; ?></th>
				<th><?php echo $lang['recommended_configuration']; ?></th>
				<th><?php echo $lang['current_status']; ?></th>
			</tr>
			<tr>
				<td><?php echo $lang['operating_system']; ?></td>
				<td>Linux&nbsp;/&nbsp;WNT</td>
				<td><?php echo $os_software;?></td>
			</tr>
			<tr>
				<td>PHP <?php echo $lang['version']; ?></td>
				<td>&gt;<?php echo $version;?></td>
				<td><?php echo $phpversion;?></td>
			</tr>
			<tr>
				<td>Mysql <?php echo $lang['version']; ?></td>
				<td>&gt;<?php echo $mysql_lowest;?></td>
				<td><?php echo $environment_mysql;?></td>
			</tr>
			<tr>
				<td><?php echo $lang['attachment_upload']; ?></td>
				<td>&gt;2M</td>
				<td><?php echo $environment_upload;?></td>
			</tr>
			<tr>
				<td>SESSION</td>
				<td><?php echo $lang['mustopen'];?></td>
				<td><?php echo $environment_session;?></td>
			</tr>
			<tr>
				<td>ICONV</td>
                <td><?php echo $lang['mustopen'];?></td>
				<td><?php echo $environment_iconv;?></td>
			</tr>
			<tr>
				<td>GD <?php echo $lang['extension'];?></td>
                <td><?php echo $lang['mustopen'];?></td>
				<td><?php echo $environment_gd;?></td>
			</tr>			
			<tr>
				<td>mbstring <?php echo $lang['extension'];?></td>
                <td><?php echo $lang['mustopen'];?></td>
				<td><?php echo $environment_mb;?></td>
			</tr>
		</table>
		<table class="table1">
			<tr>
				<th><?php echo $lang['directory_permissions'];?></th>
				<th>&nbsp;</th>
				<th><?php echo $lang['write'];?></th>
				<th><?php echo $lang['read'];?></th>
			</tr>
			<?php foreach ($file as $dirvalue) {?>
			<tr>
				<td colspan="2"><?php echo $dirvalue?></td>
				<td>
				<?php 
					$dirvalue = dirname(getcwd()).'/'.ltrim($dirvalue,'/');
					echo is_readable($dirvalue) ? '<span class="ok">&nbsp;</span>' : '<span class="no">&nbsp;</span>';
				?>
				</td>
				<td><?php echo is_writable($dirvalue) ? '<span class="ok">&nbsp;</span>' : '<span class="no">&nbsp;</span>';?></td>
			</tr>
			<?php }?>
		</table>
		<div class="action"><a href="javascript:history.go(-1);" class="btn_blue"><?php echo $lang['previous'];?></a>&nbsp;&nbsp;&nbsp;<a href="index.php?step=3" class="btn_blue"><?php echo $lang['next'];?></a></div>
	</div>
</body>
</html>
<html>
	<head>
		<style>
			body {padding:0px; margin:0px; overflow:hidden; background:#efefef;}

			div.clear {clear:both;}
		</style>

		<link href="/res/css/dropdown.css" media="screen" rel="stylesheet" type="text/css" />
		<link href="/res/css/default.ultimate.css" media="screen" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="/res/js/jquery.js"></script>
		<script type="text/javascript" src="/res/js/jquery.json.js"></script>
		<!--[if lt IE 7]>
		<script type="text/javascript" src="/res/js/jquery.dropdown.js"></script>
		<![endif]-->
	</head>
	<body>
		<div class="head">
			<img id="sitelogo" src="<?php echo $outArray['logo_url']; ?>" />
			<div class="banner"><?php
				echo $outArray['banner']; ?>

			</div>
		</div>

		<div class="menu">
			<ul id="nav" class="dropdown dropdown-horizontal"><?php
				if(is_array($outArray['menu']) && count($outArray['menu'])>0){
					echo "\n";
					foreach($outArray['menu'] as $k=>$v){
						echo getNodeMenuHTML($outArray['menu'], $k, 3);
					}
				}?>

			</ul>
		</div>

		<div class="loginForm">
			<h3>登陆</h3>
			<ul class="form">
				<li><label>用户名:</label><input type="text" class="username" value="" /></li>
				<li><label>密码:</label><input type="password" class="userpass" value="" /></li>
			</ul>
			<ul class="operate">
				<li><input type="button" class="bt_submit" value="OK" /></li>
				<li><input type="button" class="bt_cancel" value="Cancel" /></li>
			</ul>
		</div>
		<div class="foot">
			<p>&copy;2010 power by <a href="http://www.mrshelly.com" target="_blank">mrshelly</a></p>
		</div>

	</body>

	<script type="text/javascript">
		var refUrl = '<?php echo $ref; ?>';
		$("div.loginForm ul.operate li input.bt_submit").click(function(){
			if(($('input.username', $(this).parent().parent().parent()).val() == '')){
				$('input.username', $(this).parent().parent().parent())[0].select();
				return false;
			}

			if(($('input.userpass', $(this).parent().parent().parent()).val() == '')){
				$('input.userpass', $(this).parent().parent().parent())[0].select();
				return false;
			}

			var postObj = {};
			postObj['u'] = $('input.username', $(this).parent().parent().parent()).val();
			postObj['p'] = $('input.userpass', $(this).parent().parent().parent()).val();

			$.post('/?mod=act&act=login&o=jssz&t='+Math.random(), {'data':$.toJSON(postObj)}, function(ret){
				document.location.href = refUrl;
			});

		});

		$("div.loginForm ul.form li input.username").val('')[0].select();
	</script>
</html>

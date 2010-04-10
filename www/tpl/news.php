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

		<div class="news"><?php
			if(is_array($outArray['news']) && count($outArray['news'])>0){
				foreach($outArray['news'] as $k=>$v){?>

			<ul class="newlist">
				<li class="id"><a href="/?mod=sys&sys=shown&id=<?php echo $v['id']; ?>"><?php echo $v['id']; ?></a></li>
				<li class="title"><a href="/?mod=sys&sys=shown&id=<?php echo $v['id']; ?>" target="_blank"><?php echo $v['title']; ?></a></li>
				<li class="crts"><?php echo date("Y-m-d", $v['crts']); ?></li><?php
				if($authInfo['uid'] == $siteCfg['admin_user']){?>

				<li class="op_edit"><a href="/?mod=sys&sys=editnew&id=<?php echo $v['id']; ?>">修改</a></li>
				<li class="op_del"><a href="/?mod=act&sys=delnew&id=<?php echo $v['id']; ?>">删除</a></li><?php
				}?>

			</ul><?php
				}
			}?>

		</div>

		<div class="foot">
			<p>&copy;2010 power by <a href="http://www.mrshelly.com" target="_blank">mrshelly</a></p>
		</div>

	</body>

	<script type="text/javascript"><?php
	if($authInfo['uid'] == $siteCfg['admin_user']){?>

		$("div.news ul.newlist li.op_del a").click(function(){
			var postObj = {};
			postObj['id'] = $('li.id a', $(this).parent().parent()).html();

			$.post("/?mod=act&act=delnew&o=jssz&t="+Math.random(), {'data':$.toJSON(postObj)}, function(ret){
				try{
					eval(ret);
				}catch(e){
					var retObj = {'ret':'err', 'msg':'unknow error!'};
				}

				if((typeof(retObj['ret']) != 'undefined') && retObj['ret'] == 'ok'){
					alert(retObj['msg']);
					document.location.reload();
				}else{
					alert(retObj['msg']);
				}
				return false;
			});

			return false;

		});<?php
	}?>

	</script>
</html>

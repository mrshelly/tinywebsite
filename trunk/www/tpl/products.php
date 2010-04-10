<html>
	<head>
		<style>
			body {padding:0px; margin:0px; background:#efefef;}

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

		<div class="<?php echo $part; ?>s"><?php
			if(is_array($outArray["{$part}s"]) && count($outArray["{$part}s"])>0){
				foreach($outArray["{$part}s"] as $k=>$v){?>

			<ul class="<?php echo $part; ?>list"><?php
					foreach(array_keys($v) as $kk=>$vv){
						if(in_array($vv, array('crts'))){
							$v[$vv] = date("Y-m-d", $v[$vv]);
						}
						if(in_array($vv, array('id', 'name', 'title'))){?>

				<li class="<?php echo $vv; ?>"><a href="/?mod=sys&sys=show<?php echo $part; ?>&id=<?php echo $v['id']; ?>"><?php echo $v[$vv]; ?></a></li><?php
						}else{?>

				<li class="<?php echo $vv; ?>"><?php echo $v[$vv]; ?></li><?php
						}
					}
					if($authInfo['uid'] == $siteCfg['admin_user']){?>

				<li class="op_edit"><a href="/?mod=sys&sys=edit<?php echo $part; ?>&id=<?php echo $v['id']; ?>">修改</a></li>
				<li class="op_del"><a href="/?mod=act&sys=del<?php echo $part; ?>&id=<?php echo $v['id']; ?>">删除</a></li><?php
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

		$("div.<?php echo $part; ?>s ul.<?php echo $part; ?>list li.op_del a").click(function(){
			var postObj = {};
			postObj['id'] = $('li.id a', $(this).parent().parent()).html();

			$.post("/?mod=act&act=del<?php echo $part; ?>&o=jssz&t="+Math.random(), {'data':$.toJSON(postObj)}, function(ret){
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

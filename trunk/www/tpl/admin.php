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

		<div class="home_news_list">
			<h3><?php echo $outArray['menu']['news']['name']; ?></h3><a href="/?mod=sys&sys=addnew">添加</a><?php
				if(is_array($outArray['home_news']) && count($outArray['home_news'])>0){
					foreach($outArray['home_news'] as $k=>$v){?>

			<ul>
				<li class="new_<?php echo $v['id']; ?>"></li>
				<li class="title_<?php echo $v['id']; ?>"><a href="/?mod=sys&sys=shown&id=<?php echo $v['id']; ?>" target="_blank"><?php echo $v['title']; ?></a></li>
				<li class="crts_<?php echo $v['id']; ?>"><?php echo date("Y-m-d", $v['crts']); ?></li>
				<li class="edit_<?php echo $v['id']; ?>"><a href="/?mod=sys&sys=editnew&id=<?php echo $v['id']; ?>">修改</a></li>
				<li class="del_<?php echo $v['id']; ?>"><a href="/?mod=act&act=delnew&id=<?php echo $v['id']; ?>">删除</a></li>
			</ul><?php
					}
				}?>

		</div>

		<div class="home_product_list">
			<h3><?php echo $outArray['menu']['product']['name']; ?></h3><a href="/?mod=sys&sys=addproduct">添加</a><?php
				if(is_array($outArray['home_product']) && count($outArray['home_product'])>0){
					foreach($outArray['home_product'] as $k=>$v){?>

			<ul>
				<li class="img_<?php echo $v['id']; ?>"><img src="<?php echo $v['img']; ?>" /></li>
				<li class="name_<?php echo $v['id']; ?>"><a href="/?mod=sys&sys=showp&id=<?php echo $v['id']; ?>" target="_blank"><?php echo $v['name']; ?></a></li>
				<li class="edit_<?php echo $v['id']; ?>"><a href="/?mod=sys&sys=editproduct&id=<?php echo $v['id']; ?>">修改</a></li>
				<li class="del_<?php echo $v['id']; ?>"><a href="/?mod=act&act=delproduct&id=<?php echo $v['id']; ?>">删除</a></li>
			</ul><?php
					}
				}?>

		</div>

		<div class="foot">
			<p>&copy;2010 power by <a href="http://www.mrshelly.com" target="_blank">mrshelly</a></p>
		</div>

	</body>

	<script type="text/javascript">
	</script>
</html>

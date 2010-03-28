<html>
	<head>
		<style>
			body {padding:0px; margin:0px; overflow:hidden; background:#efefef;}

			div.clear {clear:both;}
		</style>
		<script type="text/javascript" src="/res/js/jquery.js"></script>
		<script type="text/javascript" src="/res/js/jquery.json.js"></script>
	</head>
	<body>
		<div class="head">
			<img id="sitelogo" src="<?php echo $outArray['logo_url']; ?>" />
			<div class="banner"><?php
				echo $outArray['banner']; ?>

			</div>
		</div>

		<div class="menu">
			<ul><?php
				if(is_array($outArray['menu']) && count($outArray['menu'])>0){
					foreach($outArray['menu'] as $k=>$v){?>

				<li class="<?php echo $k; ?>"><a href="<?php echo $v['url']; ?>"><?php echo $v['name']; ?></a></li><?php
					}
				}?>

			</ul>
		</div>

		<div class="<?php echo $part; ?>">
			<h3><?php echo $outArray[$part]['title']; ?></h3>
			<ul class="<?php echo $part; ?>info">
				<li class="crts_<?php echo $outArray[$part]['id']; ?>"><?php echo date("Y-m-d", $outArray[$part]['crts']); ?></li>
			</ul>
			<ul class="<?php echo $part; ?>content"><?php echo stripslashes($outArray[$part]['content']); ?>

			</ul>
		</div>

		<div class="foot">
			<p>&copy;2010 power by <a href="http://www.mrshelly.com" target="_blank">mrshelly</a></p>
		</div>

	</body>

	<script type="text/javascript">
	</script>
</html>

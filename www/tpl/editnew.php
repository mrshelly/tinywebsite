<html>
	<head>
		<style>
			body {padding:0px; margin:0px; background:#efefef;}

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

		<div class="addnewForm">
			<h3>修改新闻</h3>
			<ul class="form">
				<li><label>标题</label><input type="hidden" class="id" value="<?php echo $outArray['new']['id']; ?>" /><input type="text" class="title" value="<?php echo $outArray['new']['title']; ?>" /></li>
				<li>
					<label>内容</label>
					<textarea class="content" id="content"><?php echo htmlspecialchars($outArray['new']['content']); ?></textarea></li>
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

	<script type="text/javascript" src="/res/js/tiny_mce/jquery.tinymce.js"></script>
	<script type="text/javascript">
		$('textarea.content').tinymce({
			// Location of TinyMCE script
			script_url : '/res/js/tiny_mce/tiny_mce.js',
			width : '900px',
			height: '800px',
			theme : "advanced",
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			theme_advanced_resizing : true,
			content_css : "css/content.css"
		});

		var refUrl = '<?php echo $ref; ?>';
		$("div.addnewForm ul.operate li input.bt_submit").click(function(){
			if(($('input.title', $(this).parent().parent().parent()).val() == '')){
				$('input.title', $(this).parent().parent().parent())[0].select();
				return false;
			}

			if(($('textarea.content', $(this).parent().parent().parent()).html() == '')){
				try{
					$('textarea.content').tinymce().execCommand('mceFocus', true, 'mce_editor_0');
				}catch(e){
				}
				return false;
			}

			var postObj = {};
			postObj['id']= $('input.id', $(this).parent().parent().parent()).val();
			postObj['t'] = $('input.title', $(this).parent().parent().parent()).val();
			postObj['c'] = $('textarea.content', $(this).parent().parent().parent()).html();

			$.post('/?mod=act&act=editnew&o=jssz&t='+Math.random(), {'data':$.toJSON(postObj)}, function(ret){
				try{
					eval(ret);
				}catch(e){
					var retObj = {'ret':'err', 'msg':'unknow'};
				}

				if((typeof(retObj['ret']) != 'undefined') && retObj['ret'] == 'ok'){
					document.location.href = refUrl;
				}else{
					alert(retObj['msg']);
					return false;
				}
			});

		});

	</script>
</html>

<html>
	<head>
		<style>
			body {padding:0px; margin:0px; background:#efefef;}

			div.clear {clear:both;}
		</style>

		<link href="/res/css/dropdown.css" media="screen" rel="stylesheet" type="text/css" />
		<link href="/res/css/default.ultimate.css" media="screen" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="/res/js/jquery-1.4.2.js"></script>
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

		<div class="addnewForm">
			<h3>添加新闻</h3>
			<ul class="form">
				<li class="title"><label>标题</label><input type="text" class="title" value="" /></li>
				<li class="cate"><label class="cate">分类</label>
					<div class="catepath">
						<li class="cate_0_0">Loading...</li>
					</div>
					<div class="catepool">
					</div>
				</li>
				<li class="content">
					<label>内容</label>
					<textarea class="content" id="content"></textarea></li>
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
			postObj['t'] = $('input.title', $(this).parent().parent().parent()).val();
			postObj['c'] = $('textarea.content', $(this).parent().parent().parent()).html();
			postObj['l'] = new Array();
			var lis = $('li.cate div.catepool li', $(this).parent().parent().parent());
			for(var i =0; i<lis.size(); i++){
				if($('input.chkcate', $(lis[i])).attr('checked')){
					postObj['l'][postObj['l'].length] = $(lis[i]).attr('class').split('_')[1];
				}
			}
			postObj['l'] = postObj['l'].join(',');

			$.post('/?mod=act&act=addnew&o=jssz&t='+Math.random(), postObj, function(ret){
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

		// 分类选择
			$("div.addnewForm ul.form li.cate label").click(function(){
				var catePath = $('div.catepath li', $(this).parent());

				var curcate = parseInt($(catePath[catePath.length-1]).attr('class').split('_')[1]);

				$.get('/?mod=api&api=getNewsCateInfo&o=jssz&t='+Math.random(), {'id':curcate}, function(ret){
					try{
						eval(ret);
					}catch(e){
						var retObj = {'ret':'err', 'msg':'Unknow Error!'};
					}

					if((typeof(retObj['ret']) != 'undefined') && retObj['ret'] == 'ok'){
						if(retObj['data']['sinfo'].length>0){
							var subtmp = '';
							for(var i=0; i<retObj['data']['sinfo'].length; i++){
								var tplCateLabel = '<li class="cate_{cid}_{pid}"><input type="checkbox" class="chkcate" /><label>{cname}</label></li>'.replace(/{cid}/g, retObj['data']['sinfo'][i]['id']).replace(/{cname}/g, retObj['data']['sinfo'][i]['catename']).replace(/{pid}/g, retObj['data']['sinfo'][i]['pid']);
								subtmp += tplCateLabel;
							}

							var ptmp = '';
							if(retObj['data']['cinfo']['id'] >0){
								retObj['data']['pinfo'][retObj['data']['pinfo'].length] = retObj['data']['cinfo'];
							}else{
								retObj['data']['pinfo'][retObj['data']['pinfo'].length] = retObj['data']['sinfo'][0];
							}

							for(var i=0; i<retObj['data']['pinfo'].length; i++){
								var tplCateLabel = '<li class="cate_{cid}_{pid}">{cname}</li>'.replace(/{cid}/g, retObj['data']['pinfo'][i]['id']).replace(/{cname}/g, retObj['data']['pinfo'][i]['catename']).replace(/{pid}/g, retObj['data']['pinfo'][i]['pid']);
								ptmp += tplCateLabel;
							}
							$("div.addnewForm ul.form li.cate div.catepath").html(ptmp);

							$("div.addnewForm ul.form li.cate div.catepath li").click(function(){
								var cateInfo = {'id':parseInt($(this).attr('class').split('_')[1]), 'catename':$('label', $(this)).html(), 'pid':parseInt($(this).attr('class').split('_')[2])};

								var lis = $("li", $(this).parent());
								for(var i=lis.length-1; i>=0; i--){
									if(parseInt($(lis[i]).attr('class').split('_')[1]) == cateInfo['id'] && parseInt($(lis[i]).attr('class').split('_')[2]) == cateInfo['pid']){
										break;
									}else{
										$(lis[i]).remove();
									}
								}
								$("div.addnewForm ul.form li.cate label.cate").click();
								return false;
							});

							$("div.addnewForm ul.form li.cate div.catepool").html(subtmp);

							$("div.addnewForm ul.form li.cate div.catepool li label").click(function(){
								var cateInfo = {'id':parseInt($(this).parent().attr('class').split('_')[1]), 'catename':$(this).html(), 'pid':parseInt($(this).parent().attr('class').split('_')[2])};

								if(cateInfo['id']>0){
									$("input.chkcate", $(this).parent()).attr('checked', true);
									if(cateInfo['pid'] == 0){
										$("div.addnewForm ul.form li.cate label.cate").click();
										return false;
									}else{
										var tplCateLabel = '<li class="cate_{cid}_{pid}">{cname}</li>'.replace(/{cid}/g, cateInfo['id']).replace(/{cname}/g, cateInfo['catename']).replace(/{pid}/g, cateInfo['pid']);
										if($("div.addnewForm ul.form li.cate div.catepath li.cate_"+cateInfo['id']+"_"+cateInfo['pid']).size() == 0){
											$("div.addnewForm ul.form li.cate div.catepath li:last").after(tplCateLabel);
											$("div.addnewForm ul.form li.cate label.cate").click();
											return false;
										}
									}
								}

							});
						}
					}else{
						alert(retObj['ret']['msg']);
					}
				});
				return false;
			});

			$("div.addnewForm ul.form li.cate label").click();
	</script>
</html>

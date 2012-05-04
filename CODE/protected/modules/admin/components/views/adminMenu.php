<div id="menuBar">
				<ul id="ja-cssmenu">
					<?php 
					foreach ($list_menus as $id=>$menu){
						if($menu['havechild']){
							echo '<li class="havechild">';
							echo '<a id="'.$id.'" class="'.$menu['class'].'" href="'.$menu['url'].'">'.$menu['name'].'</a>';
							echo '<ul>';
							}
						elseif ($menu['class']=='x' || $menu['class']=='x active'){
							echo '<li class="x">';
							echo '<a id="'.$id.'" class="'.$menu['class'].'" href="'.$menu['url'].'">'.$menu['name'].'</a>';
							echo '<ul>';
						}
						else {
							echo '<li>';
							echo '<a id="'.$id.'" class="'.$menu['class'].'" href="'.$menu['url'].'">'.$menu['name'].'</a>';
							echo '</li>';
						}
						if($menu['close']) {
							for ($i=0;$i<$menu['close'];$i++) {
									echo '</ul>';
									echo '</li>';
							}
						}
					}
					?>
				</ul>
			</div>
<?php 
$cs = Yii::app()->getClientScript(); 
$cs->registerScriptFile(Yii::app()->request->getBaseUrl(true).'/js/common/jquery.alerts.js');
$cs->registerCssFile(Yii::app()->request->getBaseUrl(true).'/css/common/jquery.alerts.css');
?>

<script>
$("#ja-cssmenu").find("a").each(
		function(){
			$(this).click(function() {
				var menu_active_id=$(this).attr("id");
				$("#ja-cssmenu").find("a").each(
					function(){
							$(this).removeClass("active");	
					}
				)
				$(this).addClass("active");	
				jQuery.ajax({
        			'type':'GET',
        			'dataType':'json',
        			'url':'<?php echo Yii::app()->createUrl('/admin/category/setActiveAdminMenu')?>',
        			'cache':false,
        			'data':'id='+menu_active_id,
        		});
				});
		}
	)
</script>
<script type="text/javascript">
$("#ja-cssmenu").find("a").each(
		function(){
			if($(this).attr("href")=="<?php echo Yii::app()->createUrl('/admin/image/clear')?>" || $(this).attr("href")=="<?php echo Yii::app()->createUrl('/admin/video/clear')?>") {
				var link= $(this).attr("href");
				$(this).click(function() {
					jQuery.ajax({
	  					'success':function(data){
	  						if(data.success==true) 
		  						jAlert('Hoàn thành việc dọn dẹp dữ liệu');
	        			},
	        			'type':'POST',
	        			'dataType':'json',
	        			'url':link,
	        			'cache':false,
	        		});
	        		return false;
					});
				}
			}	
	)
</script>
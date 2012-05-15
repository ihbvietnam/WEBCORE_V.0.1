<div class="box-title"><label><?php echo Language::t('Danh mục sản phẩm');?></label></div>
                <div class="box-content">
                	<div class="menuleft">
                        <ul>
                    <?php 
					foreach ($list_menus as $id=>$menu){
						if($menu['havechild']){
							echo '<li>';
							echo '<a id="'.$id.'" href="'.$menu['url'].'">'.Language::t($menu['name']).'</a>';
							echo '<ul>';
							}
						elseif ($menu['class']=='x' || $menu['class']=='x active'){
							echo '<li>';
							echo '<a id="'.$id.'" href="'.$menu['url'].'">'.Language::t($menu['name']).'</a>';
							echo '<ul>';
						}
						else {
							echo '<li>';
							echo '<a id="'.$id.'" href="'.$menu['url'].'">'.Language::t($menu['name']).'</a>';
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
                    </div><!--menuleft-->
                </div><!--box-content-->
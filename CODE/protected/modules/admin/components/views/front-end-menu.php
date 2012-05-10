			<ul>
					<?php 
					foreach ($list_menus as $id=>$menu){
						if($menu['havechild']){
							echo '<li class="'.$menu['class'].'">';
							echo '<a id="'.$id.'" href="'.$menu['url'].'">'.$menu['name'].'</a>';
							echo '<ul>';
							}
						else {
							echo '<li class="'.$menu['class'].'">';
							echo '<a id="'.$id.'" href="'.$menu['url'].'">'.$menu['name'].'</a>';
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

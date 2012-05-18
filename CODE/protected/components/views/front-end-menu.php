   <ul>
   <?php foreach ($list_menus as $menu):?>
            <li class="<?php if(isset($menu['class'])) echo $menu['class'];?>"><a href="<?php echo $menu['url'];?>"><?php echo Language::t($menu['name']);?></a></li>
   <?php endforeach;?>
   </ul>

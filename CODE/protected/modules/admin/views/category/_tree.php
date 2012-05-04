<div class="fl menu-tree" style="width: 370px;">
<ul>
	<li><label><b>Cây danh mục</b></label></li>
	<li>
		<?php 
			if(isset ( $_GET ['lang'] )) {
			$lang = $_GET ['lang'];
			switch ($lang) {
				case 'en' :
					$code_lang = Article::LANG_EN;
					break;
				case 'vi' :
					$code_lang = Article::LANG_VI;
					break;
			}
			foreach ( $list as $id => $cat ) {
				if (isset($cat['lang']) && $cat ['lang'] == $code_lang)
					$list_category [$id] = $cat;
			}
			}
		if(!isset($list_category)) 	
			$list_category=$list;
		$list_style=array('color:red','color:blue','color:black');
		foreach ($list_category as $id=>$cat){
			$blank = "&nbsp";
			$prefix = "--";
			$style = $list_style[$cat['level']-1];
			for($i=1;$i<$cat['level'];$i++){
				$blank .= "&nbsp &nbsp &nbsp";
				$prefix .= "---";
			}
			$view =$blank."|".$prefix;
			echo "<div><label style=".$style.">".$view." ".$cat['name']."</label><a id='".$id."' class='i16 i16-statustext'></a><a id='".$id."'class='i16 i16-trashgray'></a></div>";
		}
		?>           
		</li>
</ul>
</div>
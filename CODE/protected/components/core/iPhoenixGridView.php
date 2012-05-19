<?php
Yii::import('zii.widgets.grid.CGridView');
class iPhoenixGridView extends CGridView
{
	public $checkboxCssClass = 'list-action-checbox';
	public $displayboxCssClass = 'display-box';
	public $actions = array ();
	public function init() {
		parent::init ();
		$this->beforeAjaxUpdate = 'function(id,options){
									name=$("thead :checkbox").attr("name");
									name=name.substring(0, name.length - 4) + "[]";
									list_checked=new Array();
									$("input[name=\'"+name+"\']:checked").each(function(i){
										list_checked[i] = $(this).val();
									});	
									list_unchecked = new Array();
            						$("input[name=\'"+name+"\']").not(":checked").each(function(i){
            							list_unchecked[i]=$(this).val();
									});	
									options.data={
										"list-checked":list_checked.toString(),
										"list-unchecked":list_unchecked.toString()
        							};
        							options.type="POST";
        							return true;
        						}';
	}
	public function renderCheckbox() {
		$cs = Yii::app ()->getClientScript ();
		$cs->registerScript ( 'js-checkbox', "jQuery(function($) { $('body').on('click','.action-checkbox',	
  		function(){  			
  			$.fn.yiiGridView.update('{$this->id}', {
			type:'GET',
			url:$(this).attr('href'),
			success:function(data) {
				$.fn.yiiGridView.update('{$this->id}');
				return false;
			},
		});
		return false;
        });
        })", CClientScript::POS_END );
		
		if (sizeof ( $this->actions ) > 0) {
			echo '<div class="' . $this->checkboxCssClass . '">';
			echo 'Công cụ: ';
			foreach ( $this->actions as $action ) {
				$this->renderAction ( $action );
				echo " ";
			}
			echo '</div>';
		}
	}

	protected function renderAction($action)
	{
		$url=Yii::app()->createUrl($action['url'],array('action'=>$action['action']));
		$label=$action['label'];
		if(isset($action['imageUrl']) && is_string($action['imageUrl']))
			echo 
			CHtml::link(
				CHtml::image(Yii::app()->request->getBaseUrl(true).$action['imageUrl'],$label),
				$url,
				array(
					'class'=>'action-checkbox'
				)
			);
		else
			echo CHtml::link($label,$url);
	}
	
	public function renderDisplaybox()
	{
		$cs = Yii::app()->getClientScript();
		$cs->registerScript(
  			'js-displaybox',
  			"jQuery(function($) { $('body').on('change','.{$this->displayboxCssClass}',	
  			function(){   				 			
  				$.fn.yiiGridView.update('{$this->id}', {
				type:'GET',
				data:{'pageSize':$(this).val()},
				success:function(data) {
					$.fn.yiiGridView.update('{$this->id}');
					return false;
				},
			});
			return false;
        	});
        })",
  		CClientScript::POS_END
		);
		$pageSize = Yii::app ()->user->getState ( 'pageSize', Setting::s('DEFAULT_PAGE_SIZE','System'));
		echo CHtml::dropDownList ( 'pageSize', $pageSize, array (Setting::s('DEFAULT_PAGE_SIZE','System') => Setting::s('DEFAULT_PAGE_SIZE','System'), 10*Setting::s('DEFAULT_PAGE_SIZE','System') => 10*Setting::s('DEFAULT_PAGE_SIZE','System'), 100*Setting::s('DEFAULT_PAGE_SIZE','System') => 100*Setting::s('DEFAULT_PAGE_SIZE','System')), array ('class' => $this->displayboxCssClass ) );
	}
}
?>
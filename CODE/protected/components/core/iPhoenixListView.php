<?php
Yii::import('zii.widgets.CListView');
class iPhoenixListView extends CListView
{
/**
	 * Renders the pager.
	 */
	public function renderPager()
	{
		if(!$this->enablePagination)
			return;
		$pager=array();
		$class='CLinkPager';
		if(is_string($this->pager))
			$class=$this->pager;
		else if(is_array($this->pager))
		{
			$pager=$this->pager;
			if(isset($pager['class']))
			{
				$class=$pager['class'];
				unset($pager['class']);
			}
		}
		$pager['pages']=$this->dataProvider->getPagination();

		if($pager['pages']->getPageCount()>1)
		{
			echo '<div class="pages">';
			echo '<div class="'.$this->pagerCssClass.'">';
			$this->widget($class,$pager);
			echo '</div>';
			echo '</div>';
		}
		else
			$this->widget($class,$pager);
	}
}
?>
  			<div id="slider" class="nivoSlider">
  			<?php $index=0;?>
  			<?php foreach ($list_images as $id):?>	
  				<?php 
  				$index++;
  				$image = Image::model ()->findByPk ( $id );
  				?>				
             	<img src="<?php echo $image->getThumb('Banner','headline')?>" alt="slider<?php echo $index?>"/>           
           <?php endforeach;?>
            </div>
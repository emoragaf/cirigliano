<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<div class="span9">
	<div id="content">
		<?php echo $content; ?>
	</div><!-- content -->
</div>
<?php if (isset($this->menu) && !empty($this->menu)): ?>
	<div class="span3 sidebar">
		<?php
			$this->widget('bootstrap.widgets.TbNav', array(
			    'type' => TbHtml::NAV_TYPE_TABS,
			    'stacked' => true,
			    'items'=>$this->menu,
			));
		?>
	</div>
	
<?php endif ?>
<?php $this->endContent(); ?>
<html>
  <head>
    <title>twigTpl</title>
  </head>
  <body>
    <h2><?php echo html::escapeHTML($core->blog->name); ?> &gt; twigTpl</h2>
    <?php if (!empty($message)):?>
    <p class="message"><?php echo $message;?></p>
    <?php endif;?>

    <div class="multi-part" id="twigtpl_settings" title="<?php echo __('Settings'); ?>">
      <form action="<?php echo $p_url;?>" method="post" enctype="multipart/form-data">
	<fieldset>
	  <legend><?php echo __('Plugin activation'); ?></legend>
	  <p class="field">
	    <?php echo form::checkbox('twigtpl_active', 1, $twigtpl_active); ?>
	    <label for="twigtpl_active" class="classic"><?php echo __('Enable twigTpl plugin');?></label>
	  </p>
	</fieldset>
	<?php echo form::hidden('p','twigTpl');?>
	<?php echo $core->formNonce();?>
	<input type="submit" name="saveconfig" value="<?php echo __('Save configuration'); ?>" />
      </form>
    </div>
    <?php dcPage::helpBlock('twigTpl');?>
  </body>
</html>

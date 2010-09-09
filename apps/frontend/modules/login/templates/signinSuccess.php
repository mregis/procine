<?php echo use_stylesheet('loginform.css','last') ?>
<div id="language_selector">
<?php 
/*
	$culture = $sf_user->getCulture();
	if($culture=='pt_BR') echo 'PT';
	else echo link_to('PT','/pt_BR/login');
	if($culture=='en') echo 'EN';
	else echo link_to('EN','/en/login');
*/	
?>
</div>
<div id="logo">
<?php echo image_tag('bossanovafilmes_logo.gif')?>
</div>
<form action="<?php echo url_for('@signin') ?>" method="post">
<?php echo $form->renderHiddenFields()?>
	<div class="form">
		<div>
			<?php echo $form['username']->renderLabel(__('Username').':')?>
			<?php echo $form['username']?>
			<?php echo $form['username']->renderError()?>
		</div> <br clear="all" />
		
		<div>
			<?php echo $form['password']->renderLabel(__('Password').':')?>
			<?php echo $form['password']?>
			<?php echo $form['password']->renderError()?>
		</div> <br clear="all" />
		<br />
		<div>
			<label>&nbsp;</label>
			<?php echo $form['remember']?>
			<?php echo $form['remember']->renderLabel(__('Remember'),array('style'=>'width:auto;margin-left:10pt'))?>
			
			<?php echo $form['remember']->renderError()?>
		</div> <br clear="all" />
		
		<div>
			<label>&nbsp;</label>
			<input type="submit" value="<?php echo __('Sign in') ?>" /> <br clear="all" />
			<br clear="all" />		

  			<label>&nbsp;</label> <a href="<?php echo url_for('@password') ?>"><?php echo __('Forgot password?') ?></a>		
		</div>				
	</div>
	
  
</form>

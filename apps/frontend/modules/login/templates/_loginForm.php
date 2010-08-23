
<form action="<?php echo url_for('@sf_guard_signin') ?>" method="post">
		<div>
			<?php echo $form['username']->renderLabel(__('Usuário: '))?>
			<?php echo $form['username']?>
			<?php echo $form['username']->renderError()?>
		</div> <br clear="all" />
		
		<div>
			<?php echo $form['password']->renderLabel(__('Senha: '))?>
			<?php echo $form['password']?>
			<?php echo $form['password']->renderError()?>
		</div> <br clear="all" />
		<div>
			<a href="#" onclick="jQuery(this).parent('form').submit()"><?php echo __('Entrar') ?></a>			
		</div>				
  
</form>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml2/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-br" lang="pt">
  <head> 
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico" />
    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>
 
  </head>
  <body>
  	<span class="titulo">&nbsp;</span>
<?php if($sf_user->isAuthenticated()): ?>

	<div id="dmn">
		<span class="sair_btn"><a href="<?php echo url_for('@signout') ?>"><?php echo __('Logoff')?></a></span>
		<div id="user_data">
			<label>usu�rio:</label>
			<?php echo $sf_user->getUsuario()->getNome()?>
		</div>		
		<ul id="mn">
			<li><a href="#">Produtora</a>
				<ul>
					<li><a href="#">Or�amento</a></li>
					<li><a href="#">Anexos do Job</a></li>
					<li><a href="#">Claquete</a></li>
					<li><a href="#">Acompanhamento</a></li>
					<li><a href="#">Pagamento</a></li>
					<li><a href="#">Faturamento</a></li>
					<li><a href="#">Aloca��o de Recursos</a></li>
					<li><a href="#">Cach�s</a></li>
					<li><a href="#">Controle Banc�rio</a></li>
				</ul>
			</li>
		
			<li><a href="#">Consultas</a></li>
			<li><a href="#">Relat�rios</a></li>
			<li><a href="#">Arquivos</a></li>
			<li><a href="#">Prefer�ncias do Sistema</a></li>
			<li><a href="#">Ajuda</a></li>
		</ul>
		
	</div>
<?php endif; ?> 
 	
    <?php echo $sf_content ?>
  </body>
</html>

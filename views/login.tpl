{extends file="views/structure.tpl"}

{block name="content"}

	{if isset($strError)}
		<div class="error">
			<p>{$strError}</p>
		</div>
	{/if}

	<form action="" method="post">
		<fieldset>
			<legend>Se connecter</legend>
			<p><label for="name">Nom</label>	<input id="name" type="text" name="name" value="" /></p>
			<p><label for="pwd">Mot de passe</label>	<input id="pwd" type="text" name="pwd" value="" /></p>
			<p><input type="submit" name="search" /></p>
		</fieldset>
	</form>

{/block}
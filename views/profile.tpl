{extends file="views/structure.tpl"}

{block name="content"}
	{include file="views/error_display.tpl"}

	<form action="index.php?ctrl=page&action=profile" method="post">
		<fieldset>
			<legend>Profile</legend>
			<input type="hidden" name="id" value="{$objUser->getId()}" />
			<p><label for="name">Nom</label>	<input id="name" type="text" name="name" value="{$objUser->getName()|unescape}" /></p>
			<p><label for="pwd">Mot de passe</label>	<input id="pwd" type="password" name="pwd" value="" /></p>
			<p><label for="confirmpwd">Confirmation du mot de passe</label>	<input id="confirmpwd" type="password" name="confirmpwd" value="" /></p>
			<p><label for="role">Rôle</label>	<select name="role" id="role">
			{foreach from=$arrRoleToDisplay item = objRole}
				<option {if (in_array($objRole->getId(), $arrSelectedRole))} selected {/if}  value='{$objRole->getId()}'>{$objRole->getLib()}</option>
			{/foreach}
				</select></p>
			<p><input type="submit" name="search" /></p>
		</fieldset>
	</form>

{/block}


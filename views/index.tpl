{extends file="views/structure.tpl"}

{block name="content"}

	<form action="" method="post">
		<fieldset>
			<legend>Recherche</legend>
			<p><label for="cat">Catégories</label>	
				<select id="cat" name="cat">
						<option value=""> -- </option>
						{foreach from=$arrCatToDisplay item=objCat} 
							<option {if (in_array($objCat->getId(), $arrSelectedCat))} selected {/if} value='{$objCat->getId()}'>{$objCat->getLib()}</option>
						{/foreach}
				</select>
			</p>
			<p><label for="mots_cles">Mots clés</label>	<input id="mots_cles" type="text" name="mots_cles" value="" /></p>
			<p><input type="submit" name="search" /></p>
		</fieldset>
	</form>
	{if isset($smarty.session.user.id) && $smarty.session.user.role == 1}
	<p><a href="index.php?ctrl=page&action=add_article">Ajouter un article</a></p>
	{/if}
	
	{foreach from=$arrResultArticle item=$arrDetResultArticle}
		{include file="views/resultArticle.tpl"}
	{/foreach}

{/block}
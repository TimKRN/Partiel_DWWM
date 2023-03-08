{extends file="views/structure.tpl"}

{block name="content"}
	{if $strPage == "add_article"}
	<p>Formulaire permettant d'ajouter un article</p>
	{else}
	<p>Formulaire permettant de modifier un article</p>
	{/if}
	{include file="views/error_display.tpl"}
	<form name="formAdd" method="post" action="index.php?ctrl=page&action={$strPage}" enctype="multipart/form-data">
		<fieldset>
			{if $strPage == "add_article"}
			<legend>Ajouter un article</legend>
			{else}
			<legend>Modifier un article</legend>
			{/if}
			<input type="hidden" name="id" value="{$objProduct->getId()}" />
			<p>
				<label for="title">Titre</label>
				<input id="title" type="text" name="title" value="{$objProduct->getTitle()}" />
			</p>
			<p>
				<label for="cat">Catégorie</label>	
				<select id="cat" name="cat">
					<option value="0"> -- </option>
					{foreach from=$arrCatToDisplay item=objCat} 
						<option {if (in_array($objCat->getId(), $arrSelectedCat))} selected {/if} value='{$objCat->getId()}'>{$objCat->getLib()}</option>
					{/foreach}
				</select>
			</p>
			<p>
				<label for="price">Prix</label>
				<input id="price" type="number" step="0.01" name="price" value="{$objProduct->getPrice()}" />
			</p>
			<p>
				{if $objProduct->getImg() != ''}
				<img src="assets/images/articles/{$objProduct->getImg()}" />
				<input type="hidden" name="img" value="{$objProduct->getImg()}" />
				{/if}
				<label for="image">Image</label>
				<input id="image" type="file" name="image" />
			</p>
			<p><input type="submit" value="{if $strPage == 'add_article'}Ajouter{else}Modifier{/if}" />
		</fieldset>
	</form>	
{/block}

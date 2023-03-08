{if count($arrError) > 0}
	<div class="error">
	{foreach from=$arrError item=strError}
		<p>{$strError}</p>
	{/foreach}
	</div>
{/if}
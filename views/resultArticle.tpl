<article>
		<header>
			<img src="assets/images/articles/{$arrDetResultArticle['product_img']}" />
		</header>
		<main>
			<h2>{$arrDetResultArticle['product_title']}</h2>
			<p class="cat">{$arrDetResultArticle['cat_lib']}</p>
			<p class="price">{$arrDetResultArticle['product_price']}€</p>
			<a href="index.php?ctrl=page&action=add_product">Ajouter au panier</a>
			{if isset($smarty.session.user.id) && $smarty.session.user.role == 1}
				<a href="index.php?ctrl=page&action=edit_article&id={$arrDetResultArticle['product_id']}">Modifier</a> <a href="index.php?ctrl=page&action=delete_article&id={$arrDetResultArticle['product_id']}">Supprimer</a>				
			{/if}
		</main>
	</article>
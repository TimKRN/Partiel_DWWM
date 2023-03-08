<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>CONTROLE PHP</title>
		<link rel="stylesheet" href="assets/css/styles.css">
    </head>
    <body id="include_file">
		<div id="container">
			<header id="logo">
				<a href="index.php?ctrl=page&action=accueil"><img src="assets/images/logo.png" /></a>
				<h1>Mon site e-commerce</h1>
				<div id="user">
					{if isset($smarty.session.user.id) && $smarty.session.user.id != ''}
						<a href="index.php?ctrl=page&action=logout">Se déconnecter</a>					
						Bonjour <a href="index.php?ctrl=page&action=profile">{$smarty.session.user.name}</a>
					{else}
						<a href="index.php?ctrl=page&action=login">Se connecter</a>
					{/if}
					<a href="index.php?ctrl=page&action=basket">Voir mon panier (5)</a>
				</div>
			</header>
			<h2>{$strTitle}</h2>

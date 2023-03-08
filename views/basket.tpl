{extends file="views/structure.tpl"}

{block name="content"}
	<a href="">Vider le panier</a>
	<table>
		<thead>
			<tr>
				<th>Libelle</td>
				<th>Quantité</td>
				<th>Prix unitaire</td>
				<th>Prix Total</td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>Bague d'humeur</td>
				<td>4</td>
				<td>5.70€</td>
				<td>22.80€</td>
			</tr>
			<tr>
				<td>Panda Tirelire</td>
				<td>1</td>
				<td>9.90€</td>
				<td>9.90€</td>
			</tr>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="3">Total</td>
				<td>32.70€</td>
			</tr>
		</tfoot>
	</table>	
{/block}			
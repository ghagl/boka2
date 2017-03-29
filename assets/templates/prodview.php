<?php
	/*
	 *
	 * Stockholms universitet
	 * DSV
	 *
	 * @dsvauthor Gustaf Haglund <ghaglund@dsv.su.se>
	 * <Please contact Erik Thuning instead.>
 	 *
 	 * Copyright (C) 2017 The Stockholm University
 	 *
 	 * This program is free software: you can redistribute it and/or modify
 	 * it under the terms of the GNU Affero General Public License as published by
 	 * the Free Software Foundation, either version 3 of the License, or
 	 * (at your option) any later version.
 	 *
 	 * This program is distributed in the hope that it will be useful,
 	 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 	 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 	 * GNU Affero General Public License for more details.
 	 *
 	 * You should have received a copy of the GNU Affero General Public License
 	 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 	 */

	$this->layout('main', ['title' => 'Bokningssystem - produktkategori '.$category['title'], 'admin' => $admin])
?>

<p>Du är inloggad som <?=$user?></p>
<?php if (!$admin): ?>
	<p>Tryck på produktnamn för att låna.</p>
	<em>Bokningar hämtas ut och hanteras av IT-Helpdesk:</em>
	<pre>
		Man kan ringa eller besöka helpdesken som är bemannad vardagar 9.00 - 11.00.

		Besöksadress: Kista, Isafjordsgatan 39, hiss B, plan 6, rum 6366
		Telefon: 08-16 16 48
		Epost: helpdesk@dsv.su.se
	</pre>
<?php endif; ?>

<noscript>
	<p>Du behöver Javascript för att kunna använda sökfunktionen.</p>
</noscript>

<input id="searchBox" class="searchBox" oninput="searchBox()" type="text" placeholder="Sök här..."/>

<table class="table table-responsive table-condensed">
	<thead>
		<tr>
			<th>Bild</th>
			<th>Produktnamn</th>
			<th>Produktbeskrivning (150 tecken)</th>
			<th>Status</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($products as $product): ?>
			<tr>
				<td><img src="./assets/objects/<?=$this->e($product['id'])?>.png" height="50" width="50"/></td>
				<td class="tdname"><?=$this->e($product['name'])?></td>
				<td><?=$product['information']?></td>
				<td>
					<?php if ($admin): ?>
						<a href="./admin_loan.php?id=<?=$product['id']?>">Låna ut</a>
					<?php else: ?>
						<?php if ($product['available'] === 0): ?>
							Nepp, inte tillgänglig
						<?php elseif ($product['available'] === 1): ?>
							Du har lånat
						<?php else: ?>
							Tillgänglig
						<?php endif; ?>
					<?php endif; ?>
				</td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>

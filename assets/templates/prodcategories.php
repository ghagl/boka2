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

	$this->layout('main', ['title' => 'Bokningssystem - produktkategorier', 'admin' => $admin])
?>

<p>Du är inloggad som <?=$user?></p>

<noscript><p>Notera att du behöver Javascript för att kunna använda sökfunktionen<?php if ($admin): ?> och låna ut<?php endif;?>.</p></noscript>
<input id="searchBox" class="searchBox" oninput="searchBoxProducts()" type="text" placeholder="Sök här... (produktnamn)"/>

<div id="searchNotice" style="display:none;">
	<strong>
		För full funktionalitet bör du välja en produktkategori och söka därifrån.
	</strong>

	<p id="bulkButtonNotice">Knappen för utlåning dyker upp när du har börjat markera objekt.</p>

	<?php if ($admin): ?>
		<p id="bulkListNotice">I din utlåningskorg:</p>
		<p id="informMarkedLoans" class="informMarkedLoans"></p>
		<a id="bulkLoanButton" style="display:none;" onclick="loanOutBulk()" href="javascript:void(0)">Låna ut samtliga</a>
	<?php endif; ?>
</div>

<table class="table table-condensed table-responsive" id="productSearch" style="display:none;">
	<thead>
		<tr>
			<th>Produktnamn</th>
			<th>Beskrivning</th>
			<th><?php if ($admin): ?>Markera för utlån<?php else: ?>Status<?php endif; ?></th>
		</tr>
	</thead>
	<tbody id="productParent">
		<!-- Här kommer sökresultaten -->
	</tbody>
</table>

<table class="table" id="regularTable">
	<thead>
		<tr>
			<th>Produktkategorier</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($categories as $category): ?>
			<tr>
				<td><a href="./category.php?id=<?=$this->e($category['id'])?>"><?=$this->e($category['title'])?></a></td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>

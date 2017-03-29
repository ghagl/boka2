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

	$this->layout('main', ['title' => 'Bokningssystem - låna ut', 'admin' => $admin])
?>

<noscript>
	<p>Du behöver Javascript för att kunna använda sökfunktionen och låna ut.</p>
</noscript>

<script>
	function initCalendar() {
		new dhtmlXCalendarObject(['dateBox']);
	}

	if (window.addEventListener) {
		document.addEventListener('DOMContentLoaded', initCalendar, false);
	} else {
		alert('Vänligen uppdatera till den senaste versionen av Mozilla Firefox');
	}
</script>

<br/>
<?php if ($product['json']): ?>
	<p>Du håller på att låna ut
		<?php $a = count($product); for ($c = 0; $c < $a; ++$c): ?>
			<?php if (!isset($product[$c]['name'])) continue; ?>
			<?php if ($c+2 !== $a && $c+3 !== $a): ?>
				"<?=$product[$c]['name']?>",
			<?php elseif ($c+2 !== $a): ?>
				"<?=$product[$c]['name']?>"
			<?php else: ?>
				och "<?=$product[$c]['name']?>"
			<?php endif; ?>
		<?php endfor;?>
		<?php /* Viktigt med korrekt grammatik. */ ?>
	</p>
<?php else: ?>
	<p>Du håller på att låna ut en "<?=$product['name']?>"</p>
<?php endif; ?>

<input id="dateBox" type="text" class="searchBox dateBox" placeholder="Skriv in det datum som lånet gäller till (ÅÅÅÅ-MM-DD)" required/>
<input id="searchBox" class="searchBox" oninput="searchBoxDaisy()" type="text" width="100%" placeholder="Sök här... (namn eller e-post)"/>

<table id="daisySearch" style="display:none;">
	<input type="hidden" id="productID" value="<?=$this->e($_GET['id'])?>"/>
	<thead>
		<tr>
			<th>Namn (tryck för att låna ut till)</th>
			<th>Epost</th>
		</tr>
	</thead>
	<tbody id="daisyParent">
	</tbody>
</table>

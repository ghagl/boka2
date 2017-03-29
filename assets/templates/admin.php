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

	$this->layout('main', ['title' => 'Bokningssystem - lån/administration', 'admin' => $admin])
?>

<p>Gå och bläddra bland produktkategorier för att låna ut objekt.</p>
<p>Om du vill ändra på ett objekts tillgänglighetsstatus, gå <a href="./admin_objects.php">hit</a>.</p>

<?php if ($limitnotice): ?>
	<?php if (!$nolimit): ?>
		<p>Notera att den här sidan bara visar de femtio senaste lånen per standard. <a href="./admin.php?limit=150<?php if ($history): ?>&history=true<?php endif;?>">Visa mer genom att klicka här</a></p>
		<p>Klicka <a href="./admin.php?nolimit=true<?php if ($history): ?>&history=true<?php endif;?>">här</a> om du vill ta bort begränsningen av sökresultat helt och hållet.</p>
	<?php endif; ?>
<?php endif; ?>

<?php if (@$loanSuccess): ?>
	<strong>Din handling gick igenom. Det borde synas här.</strong>
<?php endif; ?>

<br/>
<?php if ($listuser): ?>
	<p>Du visar just nu utlåningshistorik för <?=$loans[0]['daisy']['firstName']?> <?=$loans[0]['daisy']['lastName']?></p>
<?php endif; ?>

<noscript>
	<p>Du behöver Javascript för att kunna använda sökfunktionen. Du behöver också ha Referrer-headern aktiverad.</p>
</noscript>

<input id="searchBox" class="searchBox" oninput="searchBox()" type="text" width="100%" placeholder="Sök här... (namn eller e-post)"/>

<?php if ($listuser): ?>
	<table class="table">
		<thead>
			<tr>
				<th>Produktnamn</th>
				<th>Aktualitetsstatus</th>
				<th>Mörda utlån</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach(@$loans as $loan): ?>
				<tr>
					<td class="tdname">
						<?=$loan['product_name']?>
					</td>
					<td><?php if ($loan['valid']): ?>Aktuell (till <?=$loan['totime']?>)<?php elseif ($loan['valid'] === 2): ?>Avslutat lån<?php else: ?>Utgånget lån<?php endif; ?></td>
					<?php if ($loan['valid'] !== 2): ?>
						<td>
							<form id="<?=$loan['id']?>_form" action="./api/loan_remove.php" method="post">
								<input type="hidden" name="id" value="<?=$loan['id']?>" />
								<input type="hidden" name="csrf_token" value="<?=$csrf_token?>"/>
								<a href="javascript:void(0)" class="changeButton" onclick="document.getElementById('<?=$loan['id']?>_form').submit()">Markera som återlämnat</a>
							</form>
						</td>
					<?php endif; ?>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>
<?php else: ?>
	<table class="table">
		<thead>
			<tr>
				<th>Produktnamn</th>
				<th>Utlånad till</th>
				<th>Aktualitetsstatus</th>
				<th>Mörda utlån</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach(@$loans as $loan): ?>
				<tr>
					<input type="hidden" class="loaner_email" value="<?=$loan['loaner_email']?>"/>
					<td><?=$loan['product_name']?></td>
					<td class="tdname">
						<a href="./admin.php?email=<?=$loan['loaner_email']?>" title="Lista lån"><?=$loan['daisy']['firstName']?> <?=$loan['daisy']['lastName']?></a>
					</td>
					<td><?php if ($loan['valid'] === true): ?><a title="<?=$loan['timediff']?> kvar">Aktuell (till <?=$loan['totime']?>)</a><?php elseif ($loan['valid'] === 2): ?>Avslutat lån<?php else: ?>Utgånget lån<?php endif; ?></td>
					<?php if ($loan['valid'] !== 2): ?>
						<td>
							<form id="<?=$loan['id']?>_form" action="./api/loan_change.php" method="post">
								<input type="hidden" name="id" value="<?=$loan['id']?>" />
								<input type="hidden" name="csrf_token" value="<?=$csrf_token?>"/>
								<a href="javascript:void(0)" class="changeButton" onclick="document.getElementById('<?=$loan['id']?>_form').submit()">Markera som återlämnat</a>
							</form>
						</td>
					<?php endif; ?>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>
<?php endif; ?>

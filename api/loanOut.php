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

	require_once 'api.php';
	require_once 'core/boka.php';

	if (!Boka::admin($_SERVER['REMOTE_USER'])) {
		die('Du är inte behörig');
	}

	if (!isset($_POST['email']) || !isset($_POST['date']) || !isset($_POST['product'])) {
		die('Du måste skicka en e-postadress/ett datum också');
	}

	if (!strpos($_POST['email'], '@')) {
		die('E-postadressen måste ha en @');
	}

	if (!is_array(Boka::lookupProduct($_POST['product']))) {
		/* TODO: Does not check properly if $_POST['product'] is JSON, for now. */
		/* For example, if you send over some product IDs, where one ID is not a valid one,
		 * it will anyway pass this check. */
		die('Produkten/produkterna ser inte ut att finnas');
	}

	$_POST['date'] .= ' 23:59:59';
	/* Cheap hack to allow loans on the same day */

	if (strtotime($_POST['date']) < time()) {
		header('HTTP/1.1 403 Forbidden');
		die('Du måste ange ett datum i framtiden som lånet gäller till');
	}

	Boka::loanOut($_POST['product'], $_POST['email'], $_POST['date']);

?>

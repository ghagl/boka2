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
	require_once 'core/su.php';

	if (!Boka::admin($_SERVER['REMOTE_USER'])) {
		die('Du är inte behörig');
	}

	if (!isset($_POST['search'])) {
		die('Du måste söka på något');
	}

	//$boka = new Boka();
	$case = 'fullname';

	if (strpos($_POST['search'], '@')) {
		/* E-post */
		$case = 'email';
	}

	die(json_output(['result' => StockholmsUniversitet::search($case, $_POST['search'])]));
?>

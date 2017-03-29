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

	require_once 'base.php';

	if (!$admin) {
		die('Du är inte behörig');
	}

	$product = NULL;
	$user = NULL;
	$limit = 50;
	$limitnotice = true;
	$listuser = false;
	$history = false;
	$nolimit = false;

	if (isset($_GET['id'])) {
		$product = intval($_GET['id']);
		if ($product < 0) die('Cool kan du leka någon annan dag');
	} if (isset($_GET['limit'])) {
		$limit = intval($_GET['limit']);
		if ($limit < 0) die('Cool kan du leka någon annan dag');
		$limitnotice = false;
	} if (isset($_GET['loanSuccess']) && $_GET['loanSuccess'] == true) {
		$template_vars['loanSuccess'] = true;
	} if (isset($_GET['email'])) {
		if (!strpos($_GET['email'], '@')) {
			die('Du behöver ange en giltig e-post för att kunna lista en användares lån');
		}
		$listuser = true;
		$user = $_GET['email'];
	} if (isset($_GET['history']) && $_GET['history'] == true) {
		$history = true;
	} if (isset($_GET['nolimit']) && $_GET['nolimit'] == true) {
		$nolimit = true;
	}
	/* TODO: Maybe switch-case? */

	$template_vars = array_merge($template_vars, ['loans' => [], 'limitnotice' => $limitnotice, 'listuser' => $listuser, 'nolimit' => $nolimit, 'history' => $history]);

	if (($boka = $boka->getLoans($product, $limit, $user, $history, $nolimit)) !== NULL && $boka !== false) {
		$template_vars = array_merge($template_vars, ['loans' => $boka]);
	}

	//var_dump($template_vars['loans'][0]);
	echo $templates->render('admin', $template_vars);

?>

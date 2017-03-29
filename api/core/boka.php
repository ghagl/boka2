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

	require_once 'db.php';

	class Boka
	{
		public function __construct()
		{
			if (session_status() === PHP_SESSION_NONE && DISABLED_CSRF_PROTECTION === false)
			{
				$session_name = 'su_boka_session_id';
				$secure = true;
				$httponly = true; // This stops javascript being able to access the session id 

				ini_set('session.use_only_cookies', 1); // Forces sessions to only use cookies.
				ini_set('session.entropy_file', '/dev/urandom'); // better session id's
				ini_set('session.entropy_length', '512'); // better entropy

				$cookieParams = session_get_cookie_params(); // Gets current cookies params.
				session_set_cookie_params(86400, $cookieParams["path"], $cookieParams["domain"], $secure, $httponly);
				session_name($session_name);
				session_start();

				$_SESSION['csrf'] = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
			}
		}

		public function categories() {
			return DB::prepare("SELECT * FROM categories")->execute()->fetchAll();
		}

		public function getLoans($product, $limit, $user = NULL, $history = false, $nolimit = false)
		{
			/* $nolimit -> $history */
			$sql = "SELECT t1.id, t1.product_id, t1.loaner_email, t1.totime, t1.returned, t2.name AS product_name FROM loans t1, objects t2 WHERE t1.product_id = t2.id";
			$exec = [];

			if ($product !== NULL) {
				$sql .= " AND t1.product_id=?";
				array_push($exec, $product);
			} if ($user !== NULL) {
				$sql .= " AND t1.loaner_email=?";
				array_push($exec, $user);
			}

			if ($history === true) {
				$sql .= " AND t1.returned='true' ";
			} else {
				$sql .= " AND t1.returned='false' ";
			}

			/* Limit results to the latest loans if $nolimit === false */
			if ($nolimit === false) {
				$sql .= " ORDER BY t1.id DESC LIMIT ${limit}";
			}

			$data = DB::prepare($sql)->execute($exec)->fetchAll();
			//var_dump($sql);

			foreach ($data as $k => $loan) {
				$data[$k]['daisy'] = StockholmsUniversitet::search('email', $loan['loaner_email'], True);
				$data[$k]['valid'] = strtotime($loan['totime']) > time() ? true : false;
				if ($loan['returned'] === 'true') {
					$data[$k]['valid'] = 2;
				}

				/* User friendly time */
				$now = new DateTime();
				$dbdate = DateTime::createFromFormat('Y-m-d H:i:s', $loan['totime']);
				$data[$k]['totime'] = $dbdate->format('D d F Y');
				// diff...
				$interval = $dbdate->diff($now);
				$data[$k]['timediff'] .= $interval->format("%a dagar, %h timmar, %i minuter, %s sekunder");
			}

			return $data;
		}

		public function lookupLoan($product, $email)
		{
			$query = DB::prepare("SELECT * FROM loans WHERE product_id=:product AND loaner_email=:email AND totime > CURRENT_DATE()")->execute(['product' => $product, 'email' => $email])->fetchAll();
			if ($query !== (NULL || false)) {
				return true;
			}
			return false;
		}

		public function lookupCategory($id) {
			return DB::prepare("SELECT * FROM categories WHERE id=?")->execute([$id])->fetch();
		}

		public function lookupProduct($id)
		{
			$id_json = json_decode($id, true);

			/* If it can be processed as JSON, go with it */
			if (is_array($id_json))
			{
				$id = $id_json;
				$data = array('json' => true);
				foreach ($id as $i) {
					array_push($data, DB::prepare("SELECT * FROM objects WHERE id=?")->execute([$i['id']])->fetch());
				}
				return $data;
			}

			return DB::prepare("SELECT * FROM objects WHERE id=?")->execute([$id])->fetch();
		}

		public function products($category_id) {
			$data = DB::prepare("SELECT * FROM objects WHERE category_id=?")->execute([$category_id])->fetchAll();

			/* Look up if the user has loaned it */
			foreach ($data as $k => $product) {
				if ($this->lookupLoan($product['id'], StockholmsUniversitet::lookupUser($_SERVER['REMOTE_USER']))) {
					$data[$k]['available'] = 1;
				}
			}

			return $data;
		}

		public function searchProducts($search) {
			return DB::prepare("SELECT * FROM objects WHERE name LIKE ?")->execute(['%'.$search.'%'])->fetchAll();
		}

		public function loanOut($product, $email, $totime)
		{
			$product_json = json_decode($product, true);

			/* If it can be processed as JSON, go with it */
			if (is_array($product_json)) {
				foreach ($product_json as $product) {
					DB::prepare("INSERT INTO loans VALUES(0, ?, ?, now(), ?, 'false')")->execute([$product['id'], $email, $totime]);
				}
				return;
			}

			DB::prepare("INSERT INTO loans VALUES(0, ?, ?, now(), ?, 'false')")->execute([$product, $email, $totime]);
		}

		public function changeLoanToReturned($id) {
			DB::prepare("UPDATE loans SET returned='true' WHERE id=?")->execute([$id]);
		}

		public function loanRemove($id) {
			DB::prepare("DELETE FROM loans WHERE id=?")->execute([$id]);
		}

		public static function admin($user)
		{
			$data = DB::prepare("SELECT * FROM administrators WHERE uid=?")->execute([$user])->fetch();

			if (isset($data['uid'])) {
				return true;
			}

			return false;
		}
	}

?>

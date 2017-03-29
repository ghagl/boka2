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
	require_once __ROOT__.'/vendor/autoload.php';

	class StockholmsUniversitet
	{
		public static function lookupUser($username)
		{
			try {
				$response = \Httpful\Request::get("https://apitest.dsv.su.se/person/username/${username}")
					->expectsJson()->authenticateWith(DAISY_API_USERNAME, DAISY_API_PASSWORD)->send();
			} catch (Exception $e) {
				return $username;
			}

			return json_decode($response, true)[0];
		}

		public function search($case, $search, $expectOne = False)
		{
			$search = rawurlencode($search);

			$response = \Httpful\Request::get("https://apitest.dsv.su.se/rest/person?${case}=${search}")
				->expectsJson()->authenticateWith(DAISY_API_USERNAME, DAISY_API_PASSWORD)->send();
			$response = json_decode($response, true);

			if ($expectOne) {
				$response = $response[0];
			}

			return $response;
		}
	}

?>

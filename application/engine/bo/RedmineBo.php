<?php /*
	Copyright 2016 Cédric Levieux, Parti Pirate

	This file is part of Fabrilia.

    Fabrilia is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    Fabrilia is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with Fabrilia.  If not, see <http://www.gnu.org/licenses/>.
*/

class RedmineBo {
	var $pdo = null;
	var $database = "";

	function __construct($pdo, $database) {
		if ($database) {
			$this->database = $database . ".";
		}
		$this->pdo = $pdo;
	}

	static function newInstance($pdo, $database) {
		return new RedmineBo($pdo, $database);
	}

	function computePassword($password, $redmineUser) {
		$redminePassword = sha1($redmineUser["salt"] . sha1($password));
		
		return $redminePassword;
	}
	
	function updatePassword($userId, $password) {
		$query = "	UPDATE ".$this->database."users SET hashed_password = :password WHERE id = :userId";

		$args["userId"] = $userId;
		$args["password"] = $password;

		$statement = $this->pdo->prepare($query);

		//		echo showQuery($query, $args);

		try {
			$statement->execute($args);

			return $true;
		}
		catch(Exception $e){
			echo 'Erreur de requète : ', $e->getMessage();
		}

		return false;
	}
	
	function getUser($galetteUser) {
		$args = array();

		$query = "	SELECT users.id as redmine_user_id, users.*, email_addresses.*
					FROM ".$this->database."users 
					LEFT JOIN ".$this->database."email_addresses ON users.id = user_id 
					WHERE login = :login OR address = :email \n";

		$args["login"] = $galetteUser["login_adh"];
		$args["email"] = $galetteUser["email_adh"];

		$statement = $this->pdo->prepare($query);

//		echo showQuery($query, $args);

		try {
			$statement->execute($args);
			$results = $statement->fetchAll();

			if (!count($results)) return null;
			
			foreach($results as $key => $member) {
				foreach($member as $field => $value) {
					if (is_numeric($field)) {
						unset($results[$key][$field]);
					}
				}
			}

			return $results[0];
		}
		catch(Exception $e){
			echo 'Erreur de requète : ', $e->getMessage();
		}

		return null;
	}
	
	function getTasks($filters = null) {
		if (!$filters) $filters = array();
		
		$query = "	SELECT *, issues.id as issue_id  
					FROM ".$this->database."issues
					JOIN ".$this->database."issue_statuses ON status_id = issue_statuses.id 
					JOIN ".$this->database."projects ON issues.project_id = projects.id
					LEFT JOIN ".$this->database."members ON members.project_id = projects.id
					WHERE 1=1 	";

		$args = array();
		
		if (isset($filters["assigned_to_id"])) {
			$query .= " AND assigned_to_id = :assigned_to_id";
			$query .= " AND (members.user_id IS NULL OR members.user_id = :assigned_to_id)";
			
			$args["assigned_to_id"] = $filters["assigned_to_id"];
		}
		else {
			if (isset($filters["member_user_id"])) {			
				$query .= " AND (members.user_id IS NULL OR members.user_id = :member_user_id)";
				$args["member_user_id"] = $filters["member_user_id"];
			}
			else {
				$query .= " AND members.user_id IS NULL";
			}
		}

		if (isset($filters["not_assigned"])) {
			$query .= " AND assigned_to_id IS NULL";
		}

		if (isset($filters["no_closed"])) {
			$query .= " AND is_closed = 0";
		}

		if (isset($filters["is_public"])) {
			$query .= " AND is_public = :is_public";
			$args["is_public"] = $filters["is_public"];
		}

		if (isset($filters["status"])) {
			$query .= " AND status = :status";
			$args["status"] = $filters["status"];
		}

//		echo showQuery($query, $args);
		
		$statement = $this->pdo->prepare($query);
		
		try {
			$statement->execute($args);
			$results = $statement->fetchAll();
		
			if (!count($results)) return array();
				
			foreach($results as $key => $member) {
				foreach($member as $field => $value) {
					if (is_numeric($field)) {
						unset($results[$key][$field]);
					}
				}
			}
		
			return $results;
		}
		catch(Exception $e){
			echo 'Erreur de requète : ', $e->getMessage();
		}
		
		return array();
	}
}
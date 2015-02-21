<?php
namespace Model;

class Community
{
	/**
	 * Vrátí komunitu podle její URL
	 * @param  String $url URL komunity
	 * @return PDOStatement Výsledek dotazu
	 */
	public function getByUrl( $url )
	{
		return Database::parameters("
			SELECT * FROM `community`
			WHERE
			`url` = ?
		", array( $url ));
	}

	/**
	 * Vrátí komunity přihlášeného uživatele
	 * @return PDOStatement Výsledek dotazu
	 */
	public function getMyGroups()
	{
		return Database::parameters("
			SELECT * FROM `community`
			INNER JOIN `member` ON
			`community_id` = `community`.`id`
			WHERE
			`member`.`user_id` = ?
		", array( $_SESSION["data"]["id"] ));
	}
}
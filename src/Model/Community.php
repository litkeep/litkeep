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

	/**
	 *  Vrátí členy dané komunity
	 * @param  Integer $communityId Identifikační číslo komunity
	 * @return PDOStatement Výsledek dotazu
	 */
	public function getMembersById( $communityId )
	{
		return Database::parameters("
			SELECT * FROM `member`
			INNER JOIN `user` ON
			`user_id` = `user`.`id`
			WHERE
			`community_id` = ?
		", array( $communityId ));
	}

	public function isMemberById( $communityId, $userId )
	{
		$sql = Database::parameters("
			SELECT * FROM `member`
			WHERE
			`user_id` = ?
			AND
			`community_id` = ?
		", array( $userId, $communityId ));

		return !empty($sql->fetch());
	}

	public function getMemberById( $communityId, $userId )
	{
		return Database::parameters("
			SELECT * FROM `member`
			WHERE
			`user_id` = ?
			AND
			`community_id` = ?
		", array( $userId, $communityId ));
	}

	public function update( $values )
	{
		$sql = Database::parameters("
			UPDATE `community`
			SET
			`name` = :name,
			`description` = :description,
			`url` = :url
			WHERE
			`url` = :urlBefore
		", $values );
	}
}
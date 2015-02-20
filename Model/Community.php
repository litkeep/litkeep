<?php
namespace Model;

class Community
{
	public function getByUrl( $url )
	{
		return Database::parameters("
			SELECT * FROM `community`
			WHERE
			`url` = ?
		", array( $url ));
	}

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
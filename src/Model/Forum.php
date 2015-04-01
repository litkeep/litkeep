<?php
namespace Model;

class Forum
{
	public function getForumByUrl( $forumUrl )
	{
		return Database::parameters("
			SELECT * FROM `disc_forum`
			WHERE
			`url` = ? 
		", array($forumUrl));
	}

	public function getAllForums()
	{
		return Database::parameters("
			SELECT * FROM `disc_forum`
		");
	}

	public function newForum( $values )
	{
		$sql = Database::$connection->prepare("
			INSERT INTO `disc_forum`
			(`user_id`, `url`, `title`)
			VALUES
			(:user_id, :url, :title) 
		");

		$sql->bindParam(":user_id", $values["user_id"], \PDO::PARAM_INT );
		$sql->bindParam(":url", $values["url"]);
		$sql->bindParam(":title", $values["title"]);
		$sql->execute();

		return $sql;
	}
}
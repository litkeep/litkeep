<?php
namespace Model;

class Thread
{
	public function getThreadsByForumId( $forumId )
	{
		return Database::parameters("
			SELECT * FROM `disc_thread`
			WHERE
			`forum_id` = ?
		", array($forumId));
	}

	public function getThreadByUrl( $threadUrl )
	{
		return Database::parameters("
			SELECT * FROM `disc_thread`
			WHERE
			`url` = ?
		", array( $threadUrl ));
	}

	public function getById( $id )
	{
		return Database::parameters("
			SELECT * FROM `disc_thread`
			WHERE
			`id` = ?
		", array( $id ));
	}

	public function newThread( $values )
	{
		$sql = Database::$connection->prepare("
			INSERT INTO `disc_thread`
			(`user_id`, `forum_id`, `url`, `title`)
			VALUES
			(:user_id, :forum_id, :url, :title)
		");

		$sql->bindParam( ":user_id", $values["user_id"], \PDO::PARAM_INT );
		$sql->bindParam( ":forum_id", $values["forum_id"], \PDO::PARAM_INT );
		$sql->bindParam( ":url", $values["url"] );
		$sql->bindParam( ":title", $values["title"] );
		$sql->execute();
		return $sql;
	}
}
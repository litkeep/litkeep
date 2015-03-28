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
}
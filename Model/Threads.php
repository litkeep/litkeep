<?php
namespace Model;

class Threads
{
	public function getThreadsByForumId( $forumId )
	{
		return Database::parameters("
			SELECT * FROM `disc_thread`
			WHERE
			`forum_id` = ?
		", array($forumId));
	}
}
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
}
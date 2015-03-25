<?php
namespace Model;

class Forum
{
	public function getIdForumByUrl( $forumUrl )
	{
		return Database::parameters("
			SELECT `id` FROM `disc_forum`
			WHERE
			`url` = ? 
		", array($forumUrl));
	}
}
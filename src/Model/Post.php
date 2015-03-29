<?php
namespace Model;

class Post
{
	public function getPostsByThread( $threadId )
	{
		return Database::parameters("
			SELECT * FROM `disc_post`
			WHERE
			`thread_id` = ?
		", array($threadId) );
	}
}
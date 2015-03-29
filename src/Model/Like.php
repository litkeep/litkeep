<?php
namespace Model;

class Like
{
	public function addLike() 
	{
		
	}
	
	public function getByCommentId( $commentId )
	{
		return Database::parameters("
			SELECT * FROM `like`
			WHERE
			`comment_id` = ?
		", array($commentId));
	}
}
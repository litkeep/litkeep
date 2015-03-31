<?php
namespace Model;

class Article 
{
	public function getById( $articleId )
	{
		return Database::parameters("
			SELECT * FROM `article`
			WHERE
			`id` = ?
		", array($articleId));
	}
}
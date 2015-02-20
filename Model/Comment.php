<?php
namespace Model;

class Comment
{
	/**
	 * Vloží komentář
	 * @param Array([$values]) Pole hodnot 
	 * @access public
	 * @return PDOStatement Výsledek dotazu
	 */
	public function addComment( $values )
	{
		return Database::parameters("
			INSERT INTO `comment`
			(`article_id`, `user_id`, `content`)
			VALUES
			(?, ?, ?)
		", array(
			$values["articleId"],
			$values["userId"],
			$values["content"]
		));
	}

	/**
	 * Vrátí komentáře podle ID článku
	 * @param Integer[$articleId] ID článku
	 * @access public
	 * @return PDOStatement Výsledek dotazu
	 */
	public function getByArticleId( $articleId )
	{
		return Database::parameters("
			SELECT * FROM `comment`
			WHERE
			`article_id` = ?
		", array(
			$articleId
		));
	}
}
<?php
namespace Model;

class Score
{
	/**
	 * Zaznamená nové hodnocení článku
	 * @param Integer ID uživatele
	 * @param Integer ID článku
	 * @param Integer Hodnocení
	 * @access public
	 * @return void
	 */
	public function newScore( $user, $article, $value )
	{
		return Database::parameters("
			INSERT INTO `score`
			(`user_id`, `article_id`, `value`)
			VALUES
			(?, ?, ?)
		", array( $user, $article, $value ));
	}

	/**
	 * Vrátí hodnocení článku
	 * @param Integer ID článku
	 * @access public
	 * @return PDOStatement
	 */
	public function getByArticleId( $article )
	{
		return Database::parameters("
			SELECT * FROM `score`
			WHERE
			`article_id` = ?
		", array( $article ));
	}

	/**
	 * Vrátí hodnocení článku podle uživatele
	 * @param Integer ID článku
	 * @access public
	 * @return PDOStatement
	 */
	public function getByUserId( $user, $article )
	{
		return Database::parameters("
			SELECT * FROM `score`
			WHERE
			`user_id` = ?
			AND
			`article_id` = ?
		", array( $user, $article ));
	}
}
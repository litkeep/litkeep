<?php
namespace Model;
use Vendor;

class Comment
{
	public function __construct()
	{
		$this->auth = new Vendor\Auth;
	}

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
			(`guid`, `user_id`, `content`)
			VALUES
			(?, ?, ?)
		", array(
			$values["guid"],
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

	public function createGuid( $parent_id, $user_id, $timestamp )
	{
		return $this->auth->hash( $parent_id . $user_id . $timestamp );
	}

	public function createGuidMail( $parent_id, $sender, $recipient, $timestamp )
	{
		return $this->auth->hash( $parent_id . $sender . $reciptient . $timestamp );
	}

	public function getByGuid( $guid )
	{
		return Database::parameters("
			SELECT * FROM `comment`
			WHERE
			`guid` = ?
		", array( $guid ));
	}
}
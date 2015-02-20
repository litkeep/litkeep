<?php
namespace Model;

class Version
{
	/**
	 * Vrátí verzi článku podle URL
	 * @param String[$url] URL
	 * @access public
	 * @return PDOStatement Výsledek dotazu
	 */
	public function getByUrl( $url )
	{
		return Database::parameters("
			SELECT * FROM `version`
			INNER JOIN `article` 
			ON `version`.`article_id` = `article`.`id`
			WHERE
			`version`.`url` = ?
			ORDER BY `version`.`id` DESC LIMIT 1
		", array($url));
	}

	/**
	 * Vrátí verzi článku podle Id
	 * @param String[$url] id
	 * @access public
	 * @return PDOStatement Výsledek dotazu
	 */
	public function getById( $id )
	{
		return Database::parameters("
			SELECT * FROM `version`
			INNER JOIN `article` 
			ON `version`.`article_id` = `article`.`id`
			WHERE
			`version`.`id` = ?
			ORDER BY `version`.`id` DESC LIMIT 1
		", array($id));
	}

	/**
	 * Vrátí verzi článku podle Id článku
	 * @param String[$url] Id článku
	 * @access public
	 * @return PDOStatement Výsledek dotazu
	 */
	public function getByArticleId( $article_id )
	{
		return Database::parameters("
			SELECT * FROM `version`
			WHERE
			`article_id` = ?
		", array($article_id));
	}

	/**
	 * Vrátí verzi článku podle ID rodiče
	 * @param Integer[$parentId] ID rodiče
	 * @access public
	 * @return PDOStatement Výsledek dotazu
	 */
	public function getByParent( $parentId )
	{
		return Database::parameters("
			SELECT * FROM `version`
			WHERE `parent` = ? AND id IN (
			  SELECT MAX(id) FROM version
			  GROUP BY article_id
			)
		", array($parentId));
	}

	/**
	 * Vrátí rodiče
	 * @param Integer[$parentId] ID rodiče
	 * @access public
	 * @return PDOStatement Výsledek dotazu
	 */
	public function getParent( $parentId )
	{
		return Database::parameters("
			SELECT *
			FROM `version`
			WHERE `article_id` = ?
			ORDER BY `id` DESC LIMIT 1
		", array($parentId));
	}

	/**
	 * Vrátí rodiče
	 * @param Integer[$parentId] URL rodiče
	 * @access public
	 * @return PDOStatement Výsledek dotazu
	 */
	public function getParentURL( $parentURL )
	{
		return Database::parameters("
			SELECT *
			FROM `version`
			WHERE `url` = ?
			ORDER BY `id` DESC LIMIT 1
		", array($parentURL));
	}

	/**
	 * Vytvoří novou verzi článku
	 * @param Array()[$values] Hodnoty pro vložení
	 * @access public
	 * @return PDOStatement Výsledek dotazu
	 */
	public function newVersion( $values )
	{
		return Database::parameters("
			INSERT INTO `version`
			(`article_id`, `author_id`, `parent`, `url`, `title`, `content`)
			VALUES
			(?, ?, ?, ?, ?, ?)
		", array(
			$values["article_id"],
			$values["author_id"],
			$values["parent"],
			$values["url"],
			$values["title"],
			$values["content"]
		));
	}

	/**
	 * Vytvoří nový článek
	 * @param Boolean[$editable] Je článek upravitelný?
	 * @access public
	 * @return PDOStatement Výsledek dotazu
	 */
	public function newArticle( $editable )
	{
		return Database::parameters("
			INSERT INTO `article`
			(`editable`)
			VALUES
			(?)
		", array(
			$editable
		));
	}
}
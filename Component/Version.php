<?php
namespace Component;
use Vendor\Pattern as Pattern;
use Vendor;
use Model;

class Version extends Pattern
{
	/**
	 * Vendor\System
	 * @access private
	 */
	private $system;
	
	/**
	 * Vendor\Config
	 * @access private
	 */
	private $config;
	
	/**
	 * Model\Version
	 * @access private
	 */
	private $version;

	/**
	 * Konstruktor
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		$this->system = new Vendor\System;
		$this->config = new Vendor\Config;
		$this->version = new Model\Version;
	}

	/**
	 * Akce manažer pro editaci článku
	 * @param Array()[$article] Data článku
	 * @access public
	 * @return void
	 */
	public function actionEditForm( $article )
	{
		$this->data["type"] = "edit";
		$this->data["article"] = $article;

		if( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
			if( $this->validate() ) {

				$active = isset($_POST["active"]) ? 1 : 0;

				$query = $this->version->newVersion( array(
					"article_id" => $article["article_id"],
					"author_id" => $_SESSION["data"]["id"],
					"parent" => $article["parent"],
					"url" => $_POST["url"],
					"title" => $_POST["title"],
					"content" => $_POST["content"],
					"active" => $active
				));

				$this->system->flash("Článek byl upraven.");
				$this->redirect( $this->config->server . "/explore/" . $article["url"] );
			} else
				$this->redirect("");
			}
	}

	/**
	 * Akce manažer pro vytvoření článku
	 * @param Array()[$article] Data článku
	 * @access public
	 * @return void
	 */
	public function actionNewForm( $parent)
	{
		$this->data["type"] = "new";

		if( $_SERVER['REQUEST_METHOD'] == 'POST' ) {

			$urlExists = $this->version->getByUrl( $_POST["url"] )->fetch();

			if( isset( $urlExists["id"] ) ) {
				$this->system->flash("Tato URL adresa už existuje.");
			} else {

				if( $this->validate() ) {
					$article = $this->version->newArticle(1);

					$query = $this->version->newVersion( array(
						"article_id" => Model\Database::$connection->lastInsertId(),
						"author_id" => $_SESSION["data"]["id"],
						"parent" => $parent["article_id"],
						"url" => $_POST["url"],
						"title" => $_POST["title"],
						"content" => $_POST["content"]
					));

					$this->system->flash("Článek byl vytvořen.");
					$this->redirect( $this->config->server . "/explore/" . $parent["url"]);
				} else
					$this->redirect("");

			}
		}
	}

	/**
	 * Vyrenderuje formulář
	 * @access public
	 * @return void
	 */
	public function renderForm()
	{
		$this->renderView("article/form");
	}

	/**
	 * ¨Zvaliduje formulář
	 * @access public
	 * @return Boolean Je formulář v pořádku?
	 */
	public function validate()
	{
		if( empty($_POST["title"]) or empty($_POST["content"]) or empty($_POST["url"]) ) {
			$this->system->flash("Musíš vyplnit všechny údaje.");
			return False;
		} else
			return True;
	}
}

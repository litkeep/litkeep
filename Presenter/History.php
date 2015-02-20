<?php
namespace Presenter;
use Vendor\Pattern as Pattern;
use Vendor;
use Model;

class History extends Pattern
{
	/**
	 * Model\Version
	 * @access private
	 */
	private $version;

	/**
	 * Model\User
	 * @access private
	 */
	private $user;

	/**
	 * Vendor\System
	 * @access private
	 */
	private $system;

	/**
	 * Konstruktor
	 * @access public
	 * @return void
	 */
	public function start()
	{
		$this->version = new Model\Version;
		$this->user = new Model\User;
		$this->system = new Vendor\System;
	}

	/**
	 * Render metoda default
	* @access public
	* @return void
	*/
	public function renderDefault()
	{
		$article = $this->version->getByUrl( $this->var["url"] )->fetch();

		$this->data["article"] = $article;
		$this->data["type"] = "history";

		if( !empty($article) ) {
			$this->data["versions"] = $this->version->getByArticleId( $article["article_id"] )->fetchAll();
			
			foreach( $this->data["versions"] as $key => $value ) {
				$this->data["versions"][ $key ]["user"] = $this->user->getById( $this->data["versions"][ $key ]["author_id"])->fetch();
			}

			$this->renderView("menubar");
			$this->renderView("history/list");
		} else {
			$this->system->error404();
		}
	}

	/**
	 * Vykreslí verzi článku
	 * @access public
	 * @return void
	 */
	public function renderShow()
	{
		$version = $this->version->getById( $this->var["id"] )->fetch();

		if( !empty($version) ) {
			$this->data["article"] = $version;
			$this->renderView("history/show");
		} else {
			$this->system->error404();
		}
	}
} 
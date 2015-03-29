<?php
namespace Presenter;
use Vendor\Pattern as Pattern;
use Vendor;
use Model;
use Component;

class Article extends Pattern
{
	/**
	 * Model\Version
	 * @access private
	 */
	private $version;

	/**
	 * Component\Version
	 * @access private
	 */
	private $Version;

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
		$this->Version = new Component\Version;
		$this->system = new Vendor\System;
	}

	/**
	 * Akce pro editování článku
	 * @access public
	 * @return void
	 */
	public function actionEdit()
	{
		$this->articleData = $this->version->getByUrl( $this->var["url"] )->fetch();
		
		$this->isLogged();

		if( !$this->articleData["editable"] ) {
			$this->isAdmin();
		}

		$this->Version->actionEditForm( $this->articleData );
	}

	/**
	 * Akce pro vytvoření článku
	 * @access public
	 * @return void
	 */
	public function actionNew()
	{
		$this->parentData = $this->version->getParentURL( $this->var["parent"] )->fetch();
		$this->isLogged();

		$this->Version->actionNewForm( $this->parentData );
	}

	/**
	 * Vykreslí formulář pro editaci článku
	 * @access public
	 * @return void
	 */
	public function renderEdit() 
	{
		if( $this->isLogged() ) {
			$this->data["article"] = $this->articleData;
			$this->data["articleForm"] = $this->Version;
			$this->data["type"] = "edit";

			if( !empty($this->articleData) ) {
				$this->renderView("menubar");
				$this->renderView("article/edit");
			} else
				$this->system->error404();
		}
	}

	/**
	 * Vykreslí formulář pro editaci článku
	 * @access public
	 * @return void
	 */
	public function renderNew() 
	{
		if( $this->isLogged() ) {
			if( !empty($this->parentData) ) {
				$this->data["articleForm"] = $this->Version;
				$this->data["article"] = $this->parentData;
				$this->data["type"] = "new";
				$this->renderView("menubar");
				$this->renderView("article/new");
			} else {
				$this->system->error404();
			}
		}
	}
}
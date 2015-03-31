<?php
namespace Presenter;
use Vendor\Pattern as Pattern;
use Model;
use Vendor;

class Homepage extends Pattern {

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
	public function start()
	{
		$this->version = new Model\Version;
	}

	/**
	 * Render metoda default
	 * @access public
	 * @return void
	 */
	public function renderDefault()
	{
		$this->data["newArticles"] = $this->version->getByLimit(5)->fetchAll();
		$this->renderView("homepage/default");
	}
}
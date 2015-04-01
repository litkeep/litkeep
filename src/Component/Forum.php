<?php
namespace Component;
use Vendor\Pattern as Pattern;
use Vendor;
use Model;

class Forum extends Pattern
{
	public function __construct()
	{
		parent::__construct();
		$this->system = new Vendor\System;
		$this->config = new Vendor\Config;
		$this->forum = new Model\Forum;
	}

	public function actionForm()
	{
		if( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
			if( $this->validate() ) {
				$query = $this->forum->newForum( array(
					"user_id" => $_SESSION["data"]["id"],
					"url" => urlencode($_POST["title"]),
					"title" => $_POST["title"]
				));

				$this->system->flash("Nové fórum úspěšně založeno.");
				$this->redirect( $this->config->server . "/forum/" . urlencode($_POST["title"]) );
			} else
				$this->redirect("");
		}
	}

	public function renderForm()
	{
		$this->renderView("forum/new");
	}

	/**
	 * Zvaliduje formulář
	 * @access public
	 * @return Boolean Je formulář v pořádku?
	 */
	public function validate()
	{
		if( empty($_POST["title"]) ) {
			$this->system->flash("Musíš vyplnit všechny údaje.");
			return False;
		} else
			return True;
	}
}
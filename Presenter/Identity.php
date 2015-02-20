<?php
namespace Presenter;
use Vendor\Pattern as Pattern;
use Vendor;
use Model;

class Identity extends Pattern
{
	/**
	 * Model\User
	 * @access private
	 */
	private $user;

	/**
	 * Uživatelská data
	 * @access private
	 */
	private $userData;
	
	/**
	 * Vendor\Config
	 * @access private
	 */
	private $config;

	/**
	 * Konstruktor
	 * @access public
	 * @return void
	 */
	public function start()
	{
		$this->user = new Model\User;
		$this->system = new Vendor\System;
		$this->config = new Vendor\Config;
	}

	/**
	 * Akce pro profil
	 * @access public
	 * @return void
	 */
	public function actionProfile()
	{
		$this->userData = $this->user->getById( $this->var["id"] )->fetch();
	}

	/**
	 * Vykreslí profil
	 * @access public
	 * @return void
	 */
	public function renderProfile()
	{
		if( !empty($this->userData) ) {
			$this->data["identity"] = $this->userData;
			$this->renderView("identity/profile");
		} else {
			$this->system->error404();
		}
	}

	/**
	 * Akce pro nastavení uživatele
	 * @access public
	 * @return void
	 */
	public function actionSettings()
	{
		$this->userData = $this->user->getById( $_SESSION["data"]["id"] )->fetch();

		if( !empty( $_POST["userSettings"] ) ) {
			unset($_POST["userSettings"]);
			$query = $this->user->update( $_POST );

			$this->system->flash("Úspěšně jsi upravil(a) své nastavení. Znovu se přihlaš.");
			unset( $_SESSION["logged"] );
			unset( $_SESSION["data"] );
			$this->redirect( $this->config->server );
		}
	}

	/**
	 * Render metoda pro nastavení uživatele
	 * @access public
	 * @return void
	 */
	public function renderSettings()
	{
		$this->renderView("identity/settings");
	}
}
<?php
namespace Presenter;
use Vendor\Pattern as Pattern;
use Vendor;
use Model;

class Community extends Pattern
{
	/**
	 * Model\Community
	 * @access private
	 */
	private $community;
	
	/**
	 * Vendor\System
	 * @access private
	 */
	private $system;

	/**
	 * Konstruktor
	 * @return void
	 */
	public function start()
	{
		$this->community = new Model\Community;
		$this->system = new Vendor\System;
		$this->communityProfile = $this->community->getByUrl( $this->var["url"] )->fetch();
		$this->data["member"] = $this->community->getMemberById( $this->communityProfile["id"], $_SESSION["data"]["id"] )->fetch();
		$this->data["group"] = $this->communityProfile;
	}

	public function actionShow()
	{
		$this->data["showGroupMenu"] = True;
	}

	/**
	 * Renderovací metoda
	 * @return void
	 */
	public function renderShow()
	{	
		if( !empty( $this->communityProfile ) ) {
			$this->data["members"] = $this->community->getMembersById( $this->communityProfile["id"] );
			$this->renderView("community/show");
		} else {
			$this->system->error404();
		}
	}

	/**
	 * Administrace
	 * Action metoda
	 * @access public
	 * @return void
	 */
	public function actionAdmin()
	{
		$this->data["showGroupMenu"] = True;
		
		if( isset($_POST["community"]) ) {
			if( $this->validateCommunity() ) {
				unset( $_POST["community"] );
				$_POST["urlBefore"] = $this->var["url"];
				$this->community->update( $_POST );
				$this->system->flash("Úspěšně jsi editoval komunitu.");
				$this->redirect("");
			} else
				$this->redirect("");
		}
	}

	/**
	 * Vykreslí administraci
	 * Render metoda
	 * @access public
	 * @return void
	 */
	public function renderAdmin()
	{	
		if( ($this->data["member"]["id"]) && isset($this->communityProfile["id"]) && ($this->data["member"]["role"] == "Admin") ) {
			$this->data["group"] = $this->communityProfile;
			$this->data["members"] = $this->community->getMembersById( $community["id"] );
			$this->renderView("community/admin");
		} else
			$this->system->error404();
	}

	/**
	 * Zvaliduje formulář Community
	 * @access public
	 * @return void
	 */
	public function validateCommunity()
	{
		if( $_POST["name"] == "" or $_POST["description"] == "" or $_POST["url"] == "") {
			$this->system->flash("Musíš vyplnit všechny údaje.");
			return False;
		} else
			return True;
	}
}
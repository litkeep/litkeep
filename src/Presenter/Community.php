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
		$community = $this->community->getByUrl( $this->var["url"] )->fetch();
		
		if( !empty( $community ) ) {
			$this->data["group"] = $community;
			$this->data["members"] = $this->community->getMembersById( $community["id"] );
			$this->renderView("community/show");
		} else {
			$this->system->error404();
		}
	}
}
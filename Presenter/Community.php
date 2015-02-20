<?php
namespace Presenter;
use Vendor\Pattern as Pattern;
use Vendor;
use Model;

class Community extends Pattern
{
	private $community;
	private $system;

	public function start()
	{
		$this->community = new Model\Community;
		$this->system = new Vendor\System;
	}

	public function renderShow()
	{
		$community = $this->community->getByUrl( $this->var["url"] )->fetch();
		
		if( !empty( $community ) ) {
			$this->data["group"] = $community;
			$this->renderView("community/show");
		} else {
			$this->system->error404();
		}
	}
}
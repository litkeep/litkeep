<?php
namespace Presenter;
use Vendor\Pattern as Pattern;
<<<<<<< HEAD
use Vendor;
=======
>>>>>>> 3506036... Added files
use Model;

class Community extends Pattern
{
	private $community;
<<<<<<< HEAD
	private $system;
=======
>>>>>>> 3506036... Added files

	public function start()
	{
		$this->community = new Model\Community;
<<<<<<< HEAD
		$this->system = new Vendor\System;
=======
>>>>>>> 3506036... Added files
	}

	public function renderShow()
	{
		$community = $this->community->getByUrl( $this->var["url"] )->fetch();
		
		if( !empty( $community ) ) {
			$this->data["group"] = $community;
			$this->renderView("community/show");
<<<<<<< HEAD
		} else {
			$this->system->error404();
=======
>>>>>>> 3506036... Added files
		}
	}
}
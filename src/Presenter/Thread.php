<?php
namespace Presenter;
use Vendor\Pattern as Pattern;
use Vendor;
use Model;
use Component;

class Thread extends Pattern
{
	private $thread;
	private $user;

	public function start()
	{
		$this->thread = new Model\Thread;
		$this->user = new Model\User;
		$this->Comment = new Component\Comment;
		$this->comment = new Model\Comment;
		$this->system = new Vendor\System;
	}

	public function actionShow()
	{
		$this->data["parent"] = $this->thread->getThreadByUrl( $this->var["url"] )->fetch();
		$this->Comment->actionForm( $this->comment->createGuid( 
			$this->data["parent"]["id"], 
			$this->data["parent"]["user_id"], 
			$this->data["parent"]["timestamp"]
		));
	}

	public function renderShow()
	{
		if( $this->data["parent"] ) {
			$this->data["Comment"] = $this->Comment;
			$this->renderView("forum/thread");
		} else {
			$this->system->error404();
		}
	}
}
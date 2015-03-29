<?php
namespace Presenter;
use Vendor\Pattern as Pattern;
use Model;
use Vendor;

class Forum extends Pattern
{
	/**
	 * Model\Forum
	 * @access private
	 */
	private $forum;

	/**
	 * Model\Threads
	 * @access private
	 */
	private $threads;

	/**
	 * Konstruktor
	 * @access public
	 * @return void
	 */
	public function start()
	{
		$this->forum = new Model\Forum;
		$this->thread = new Model\Thread;
		$this->system = new Vendor\System;
	}

	public function renderShow()
	{
		$forum = $this->forum->getForumByUrl( $this->var["url"] )->fetch();

		if( !isset( $forum["id"] ) ) {
			$this->system->error404();
		} else {
			$this->data["parent"] = $forum;
			$this->data["threads"] = $this->thread->getThreadsByForumId( $forum["id"] )->fetchAll();
			$this->renderView("forum/forum");
		}
	}
}
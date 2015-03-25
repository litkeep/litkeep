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
		$this->threads = new Model\Threads;
		$this->system = new Vendor\System;
	}

	public function renderShow()
	{
		$forumId = $this->forum->getIdForumByUrl( $this->var["url"] )->fetch();
		$forumId = $forumId["id"];

		if( !isset( $forumId ) )
			$this->system->error404();

		$this->data["threads"] = $this->threads->getThreadsByForumId( $forumId )->fetchAll();
		$this->renderView("forum/forum");
	}
}
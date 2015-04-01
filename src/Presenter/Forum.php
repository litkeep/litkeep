<?php
namespace Presenter;
use Vendor\Pattern as Pattern;
use Model;
use Vendor;
use Component;

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
		$this->Thread = new Component\Thread;
		$this->Forum = new Component\Forum;
	}

	public function actionList()
	{
		$this->Forum->actionForm();
	}

	public function renderList()
	{
		$forum = $this->forum->getAllForums()->fetchAll();
		$this->data["forums"] = $forum;
		$this->data["Forum"] = $this->Forum;
		$this->renderView("forum/list");
	}

	public function actionShow()
	{
		$this->thisForum = $this->forum->getForumByUrl( $this->var["url"] )->fetch();

		$this->Thread->actionForm( $this->thisForum );
	}

	public function renderShow()
	{
		$forum = $this->thisForum;

		if( !isset( $forum["id"] ) ) {
			$this->system->error404();
		} else {
			$this->data["Thread"] = $this->Thread;
			$this->data["parent"] = $forum;
			$this->data["threads"] = $this->thread->getThreadsByForumId( $forum["id"] )->fetchAll();
			$this->renderView("forum/forum");
		}
	}
}
<?php
namespace Presenter;
use Vendor\Pattern as Pattern;
use Model;

class Thread extends Pattern
{
	private $thread;
	private $post;
	private $user;

	public function start()
	{
		$this->thread = new Model\Thread;
		$this->post = new Model\Post;
		$this->user = new Model\User;
	}

	public function renderShow()
	{
		$this->data["parent"] = $this->thread->getThreadByUrl( $this->var["url"] )->fetch();
		$this->data["comments"] = $this->post->getPostsByThread( $this->data["parent"]["id"] )->fetchAll();

		$i = 0;
		foreach( $this->data["comments"] as $comment) {
			$this->data["comments"][ $i ]["userData"] = $this->user->getById( $comment["user_id"] )->fetch();
			$i++;
		}

		$this->renderView("forum/thread");
	}
}
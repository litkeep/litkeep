<?php
namespace Presenter;
use Vendor\Pattern as Pattern;
use Model;
use Component;

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
		$this->Comment = new Component\Comment;
		$this->comment = new Model\Comment;
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
		$this->data["comments"] = $this->post->getPostsByThread( $this->data["parent"]["id"] )->fetchAll();

		$this->data["Comment"] = $this->Comment;
		$this->renderView("forum/thread");
	}
}
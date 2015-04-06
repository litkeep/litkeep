<?php
namespace Component;
use Vendor\Pattern as Pattern;
use Vendor;
use Model;

class Thread extends Pattern
{
	/**
	 * Model\Thread
	 * @access private
	 */
	private $thread;

	/**
	 * Vendor\Config
	 * @access private
	 */
	private $config;

	/**
	 * Vendor\System
	 * @access private
	 */
	private $system;

	/**
	 * Model\Comment
	 * @access private
	 */
	private $comment;
	
	/**
	 * Konstruktor
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		$this->thread = new Model\Thread;
		$this->config = new Vendor\Config;
		$this->system = new Vendor\System;
		$this->comment = new Model\Comment;
	}

	/**
	 * Vytvoří nové vlákno
	 * Action metoda
	 * @access public
	 * @return void
	 */
	public function actionForm( $forum )
	{
		if( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
			if( $this->validate() ) {

				$newAdded = $this->thread->getThreadByUrl( urlencode($_POST["title"]) )->fetch();

				if( !isset($newAdded["id"]) ) {
					$query = $this->thread->newThread( array(
						"user_id" => $_SESSION["data"]["id"],
						"forum_id" => $forum["id"],
						"url" => urlencode($_POST["title"]),
						"title" => $_POST["title"]
					));

					$guid = $this->comment->createGuid( $newAdded["id"], $newAdded["user_id"], $newAdded["timestamp"] );

					$comment = $this->comment->addComment( array(
						"guid" => $guid,
						"userId" => $_SESSION["data"]["id"],
						"content" => $_POST["content"])
					);

					if( $query )
						$this->system->flash("Nové vlákno úspěšně založeno.");
					else
						$this->flash("Někde se vyskytl problém.");
					
					$this->redirect( $this->config->server . "/forum/" . $forum["url"] . "/" . urlencode($_POST["title"]) );
				} else {
					$this->system->flash("Toto vlákno už existuje!");
					$this->redirect("");
				}
			} else
				$this->redirect("");
		}
	}

	/**
	 * Vykreslí formulář pro nové vlákno
	 * Render metoda
	 * @access public
	 * @return void
	 */
	public function renderForm()
	{
		$this->renderView("forum/thread/new");
	}

	/**
	 * Zvaliduje formulář
	 * @access public
	 * @return Boolean Je formulář v pořádku?
	 */
	public function validate()
	{
		if( empty($_POST["title"]) or empty($_POST["content"]) ) {
			$this->system->flash("Musíš vyplnit všechny údaje.");
			return False;
		} else
			return True;
	}
}
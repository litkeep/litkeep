<?php
namespace Component;
use Vendor\Pattern as Pattern;
use Vendor;
use Model;

class Comment extends Pattern
{
	/**
	 * Model\User
	 * @access private
	 */
	private $user;

	/**
	 * Model\Comment
	 * @access private
	 */
	private $comment;

	/**
	 * Model\Article
	 * @access private
	 */
	private $article;

	/**
	 * Model\Thread
	 * @access private
	 */
	private $thread;

	/**
	 * Vendor\System
	 * @access private
	 */
	private $system;

	/**
	 * Vendor\Auth
	 * @access private
	 */
	private $auth;

	/**
	 * Konstruktor
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		$this->user = new Model\User;
		$this->comment = new Model\Comment;
		$this->system = new Vendor\System;
		$this->article = new Model\Article;
		$this->thread = new Model\Thread;
		$this->auth = new Vendor\Auth;
		$this->mailbox = new Model\Mailbox;
	}

	/**
	 * Akce formuláře
	 * @access public
	 * @return void
	 */
	public function actionForm( $guid )
	{
		if( isset($_POST["comment"]) ) {
			if( $this->validateForm() ) {
				$this->comment->addComment( array(
					"guid" => $guid,
					"userId" => $_SESSION["data"]["id"],
					"content" => $_POST["content"])
				);
			}

			$this->redirect("");
		}
	}

	/**
	 * Vyrenderuje formulář
	 * @access public
	 * @return void
	 */
	public function render( $type, $parentId )
	{
		$parent = $this->$type->getById( $parentId )->fetch();

		$comments = $this->comment->getByGuid(
			$this->comment->createGuid( $parent["id"], $parent["user_id"], $parent["timestamp"] )
		)->fetchAll();

		$i = 0;
		foreach( $comments as $comment) {
			$comments[ $i ]["userData"] = $this->user->getById( $comment["user_id"] )->fetch();
			$i++;
		}

		$this->data["comments"] = $comments;

		$this->renderView("comment/list");
		$this->renderView("comment/form");
	}

	/**
	 * Zvaliduje formulář
	 * @access private
	 * @return Boolean
	 */
	private function validateForm()
	{
		if( trim($_POST["content"]) == "" ) {
			$this->system->flash("Musíš vyplnit obsah komentáře!");
			return False;
		} else {
			return True;
		}
	}
}

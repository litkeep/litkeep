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
	}

	/**
	 * Akce formuláře
	 * @access public
	 * @return void
	 */
	public function actionForm( $articleId )
	{
		if( isset($_POST["comment"]) ) {
			if( $this->validateForm() ) {
				$this->comment->addComment( array(
					"articleId" => $articleId,
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
	public function render( $articleId )
	{
		$comments = $this->comment->getByArticleId( $articleId )->fetchAll();

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

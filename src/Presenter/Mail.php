<?php
namespace Presenter;
use Vendor\Pattern as Pattern;
use Vendor;
use Model;
use Component;

class Mail extends Pattern
{
	private $mailbox;
	private $system;

	public function start()
	{
		$this->mailbox = new Model\Mailbox;
		$this->system = new Vendor\System;
		$this->Comment = new Component\Comment;
		$this->comment = new Model\Comment;

		$this->mailboxes = $this->mailbox->getMailboxesBySpeaker( $_SESSION["data"]["id"] );

		$i = 0;
		foreach ($this->mailboxes as $mailbox) {
			$this->mailboxes[ $i ]["speakers"] = $this->mailbox->getSpeakersByMailBox( $mailbox["id"] )->fetchAll();
			$i++;
		}
	}

	public function actionList()
	{
		if( $_SESSION["logged"] ) {
			$this->data["mailboxes"] = $this->mailboxes;
		}
	}

	public function renderList()
	{
		if( $_SESSION["logged"] ) {
			$this->renderView("mail/list");
		} else {
			$this->system->error404();
		}	
	}

	public function actionTalk()
	{
		$this->talk = $this->mailbox->getById( $this->var["id"] )->fetch();
		$this->Comment->actionForm( $this->comment->createGuid( $this->talk["id"], $this->talk["user_id"], $this->talk["timestamp"]) );
	} 

	public function renderTalk()
	{
		if( $this->talk and ($this->mailbox->isSpeaker($_SESSION["data"]["id"], $this->var["id"])) ) {
			$this->data["talk"] = $this->talk;
			$this->data["Comment"] = $this->Comment;
			$this->renderView("mail/talk");
		} else {
			$this->system->error404();
		}
	}
}
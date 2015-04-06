<?php
namespace Model;

class Mailbox
{
	private $user;

	public function __construct()
	{
		$this->user = new User;
	}

	public function getMailboxesBySpeaker( $speaker_id )
	{
		$ids = Database::parameters("
			SELECT * FROM `speakers`
			WHERE
			`user_id` = ?
		", array( $speaker_id ))->fetchAll();

		$mailboxes = array();

		foreach( $ids as $id ) {
			$mailboxes[] = Database::parameters("
				SELECT * FROM `mailbox`
				WHERE
				`id` = ?
			", array($id["mailbox_id"]))->fetch();
		}

		return $mailboxes;
	}

	public function getSpeakersByMailBox( $mailbox_id )
	{
		return Database::parameters("
			SELECT * FROM `speakers`
			INNER JOIN `user` ON 
			`user`.`id` = `speakers`.`user_id`
			WHERE
			`mailbox_id` = ?
		", array( $mailbox_id ));
	}

	public function isSpeaker( $speaker_id, $mailbox_id)
	{
		$sql = Database::parameters("
			SELECT * FROM `speakers`
			WHERE
			`user_id` = ?
			AND
			`mailbox_id` = ?
		", array( $speaker_id, $mailbox_id) )->fetch();

		if( $sql )
			return True;
		else
			return False;
	}

	public function getById( $mailbox_id )
	{
		return Database::parameters("
			SELECT * FROM `mailbox`
			WHERE
			`id` = ?
		", array( $mailbox_id ));
	}
}
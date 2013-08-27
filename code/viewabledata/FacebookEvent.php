<?php

	class FacebookEvent extends FacebookObject{

		static $singular_name = 'Facebook Event';
		static $plural_name = 'Facebook Events';
		static $description = 'A Facebook Event';

		static $casting = array(
			'Owner' => 'Int',
			'StartTime' => 'SS_Datetime',
			'EndTime' => 'SS_Datetime',
			'Location' => 'Varchar(255)',
			'Privacy' => 'Enum("OPEN, SECRET, FRIENDS, CLOSED")',
			'UpdatedTime' => 'SS_Datetime',
			'Picture' => 'Text',
			'TicketURI' => 'Text');

		public function buildEvent($eid = null, $name = null, $description = null, $owner = null, $startTime = null, $endTime = null, $location = null, $privacy = null, $updatedTime = null, $picture = null, $ticketURI = null){
			$this->buildObject($eid, $name, $description);
			$this->Owner = $owner;
			$this->StartTime = $startTime;
			$this->EndTime = $endTime;
			$this->Location = $location;
			$this->Privacy = $privacy;
			$this->UpdatedTime = $updatedTime;
			$this->Picture = $picture;
			$this->TicketURI = $ticketURI;
		}

		public function EventLink(){
			return Controller::curr()->Link('event/'.$this->ID);
		}

	}
<?php

	class FacebookObject extends ViewableData{

		static $singular_name = 'Facebook Object';
		static $plural_name = 'Facebook Objects';
		static $description = 'Base Facebook object for showing Facebook Open Graph data';

		static $casting = array(
			'ID' => 'Int',
			'Name' => 'Varchar(255)',
			'Description' => 'Text');

		public function buildObject($id = null, $name = null, $description = null){
			$this->ID = $id;
			$this->Name = $name;
			$this->Description = $description;
		}

		public function setObjectID($oid = null){
			$this->ID = $oid;
		}

		public function setName($name = null){
			$this->Name = $name;
		}

		public function setDescription($description = null){
			$this->Description = $description;
		}

		public function getObjectID(){
			return $this->ID;
		}

		public function getName(){
			return $this->Name;
		}

		public function getDescription(){
			return $this->Description;
		}

	}
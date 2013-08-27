<?php

	class FacebookAlbum extends FacebookObject{

		static $singular_name = 'Facebook Album';
		static $plural_name = 'Facebook Albums';
		static $description = 'A Facebook Album';

		static $casting = array(
			'Picture' => 'Text');

		public function buildAlbum($oid = null, $name = null, $description = null, $picture = null){
			$this->buildObject($oid, $name, $description);
			$this->Picture = $picture;
		}

		public function AlbumLink(){
			return Controller::curr()->Link('album/'.$this->ID);
		}

	}
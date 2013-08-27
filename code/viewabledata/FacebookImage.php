<?php

	class FacebookImage extends FacebookObject{

		static $singular_name = 'Facebook Album';
		static $plural_name = 'Facebook Albums';
		static $description = 'A Facebook Album';

		static $casting = array(
			'Caption' => 'Text',
			'SmallImage' => 'Text',
			'LargeImage' => 'Text');

		public function buildImage($oid = null, $name = null, $description = null, $caption = null, $smallImage = null, $largeImage = null){
			$this->buildObject($oid, $name, $description);
			$this->Caption = $caption;
			$this->SmallImage = $smallImage;
			$this->LargeImage = $largeImage;
		}

		public function AlbumLink(){
			return Controller::curr()->Link('album/'.$this->ID);
		}

	}
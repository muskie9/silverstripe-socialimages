<?php

	class FacebookPage extends Page{

		static $singular_name = 'Facebook Page';
		static $plural_name = 'Facebook Pages';
		static $description = 'A page that displays data from Facebook page or profile';

		/*private static $AppID;
		private static $AppSecret;
		private static $FacebookPageID;*/

		static $db = array(
			'DataType' => 'Enum("Albums, Events")');

		public function getCMSFields(){
			$fields = parent::getCMSFields();

			$fields->addFieldToTab('Root.Main', new DropdownField('DataType', 'Data to show', singleton('FacebookPage')->dbObject('DataType')->enumValues()), 'Content');

			return $fields;
		}

		public static function getAppSecret(){
			$config = SiteConfig::current_site_config();
			return $config->FacebookAppSecret;
		}

		public static function getAppID(){
			$config = SiteConfig::current_site_config();
			return $config->FacebookAppID;
		}

		public static function getFacebookPageID(){
			$config = SiteConfig::current_site_config();
			return $config->FacebookPageID;
		}

		public static function FacebookQuery($appID, $appSecret, $FBPageID, $queryType, $extraID){
			$facebook = new Facebook(array(
			  'appId'  => $appID,
			  'secret' => $appSecret,
			  'cookie' => true
			));

			$fbPageID = $FBPageID;

			//$results = $facebook->api('/111929852242482','GET');

			switch($queryType){
				case 'Events':
					$fql = 	"SELECT eid, name, description, pic, start_time, end_time, location, privacy, ticket_uri FROM event WHERE creator = $fbPageID";
				break;
				case 'Albums':
					$fql = "SELECT name, cover_object_id, object_id, description FROM album WHERE owner = $fbPageID";
				break;
				case 'event':
					$fql = "SELECT name, description, pic, start_time, end_time, location, privacy, ticket_uri FROM event WHERE object_id = $extraID";
				break;
				case 'album':
					$fql = "SELECT caption, src, src_big, src_small FROM photo WHERE album_object_id = $extraID";
				break;
				case 'album_cover':
					$fql = "SELECT src_big, src_small FROM photo WHERE object_id = $extraID";
				break;
				default:
					$fql = "SELECT name, description, pic_cover FROM page WHERE page_id = $FBPageID";
			}

			$param  =   array(
			'method'    => 'fql.query',
			'query'     => $fql,
			'callback'  => ''
			);

			$fqlResult = $facebook->api($param);

			return $fqlResult;
		}

	}

	class FacebookPage_Controller extends Page_Controller{

		public function init(){
			parent::init();

		}

		private static $allowed_actions = array(
			'index' => true,
			'album' => true,
			'event' => false);

		public function index(HTTP_Request $request){

			$appID = FacebookPage::getAppID();
			$appSecret = FacebookPage::getAppSecret();
			$FBPageID = FacebookPage::getFacebookPageID();

			$queryType = $this->Data()->DataType;

			$returnObjects = FacebookPage::FacebookQuery($appID, $appSecret, $FBPageID, $queryType, null);

			$rCount = count($returnObjects);
			$count = 0;
			$objects = ArrayList::create();


			if($queryType == 'Events'){

				while($count<$rCount){
					$e = $returnObjects[$count];
					if($e['start_time']>=SS_Datetime::create()->Now()){
						$event = new FacebookEvent();
						$event->buildEvent($e['eid'], $e['name'], $e['description'], null, $e['start_time'], $e['end_time'], $e['location'], $e['privacy'], null, $e['pic'], $e['ticket_uri']);
						$objects->push($event);
					}
					$count++;
				}
			}else{
				while($count<$rCount){
					$a = $returnObjects[$count];
					(isset($a['description'])) ? $description = $a['description'] : $description = null;
					$album = new FacebookAlbum();
					$album->buildAlbum($a['object_id'], $a['name'], $description);
					$coverID = $a['cover_object_id'];
					$picture = FacebookPage::FacebookQuery($appID, $appSecret, $FBPageID, 'album_cover', $coverID);
					$album->Picture = $picture[0]['src_big'];
					$objects->push($album);
					$count++;
				}
			}

			return $this->customise(array(
				'FacebookObjects' => $objects));

		}

		public function event(HTTP_Request $request){
			$params = $request->allParams();
			$eventID = $params['ID'];
		}

		public function album(HTTP_Request $request){
			$params = $request->allParams();
			$albumID = $params['ID'];
			$returnObjects = FacebookPage::FacebookQuery(FacebookPage::getAppID(), FacebookPage::getAppSecret(), FacebookPage::getFacebookPageID(), 'album', $albumID);
			$imageCount = count($returnObjects);
			$count = 0;
			$images = ArrayList::create();
			while($count<$imageCount){
				$i = $returnObjects[$count];
				$facebookImage = new FacebookImage();
				$facebookImage->buildImage(null, null, null, $i['caption'], $i['src'], $i['src_big'], $i['src_small']);
				$images->push($facebookImage);
				$count++;
			}

			return $this->customise(array(
				'FacebookObjects' => $images));
		}

	}
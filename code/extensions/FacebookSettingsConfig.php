<?php

class FacebookSettingsConfig extends DataExtension {

	private static $db = array(
		'FacebookAppID' => 'Text',
		'FacebookAppSecret' => 'Text',
		'FacebookPageID' => 'Text'
	);

	public function updateCMSFields(FieldList $fields) {
		$fields->addFieldToTab('Root.FacebookSettings', $appID = TextField::create('FacebookAppID')->setTitle('Facebook App ID'));
		$appID->setRightTitle('The Facebook App ID is needed to access information using the Facebook API');
		$fields->addFieldToTab('Root.FacebookSettings', $appSecret = TextField::create('FacebookAppSecret')->setTitle('Facebook App Secret'));
		$appSecret->setRightTitle('The Facebook App Secret is needed to access information using the Facebook API');
		$fields->addFieldToTab('Root.FacebookSettings', $pageID = TextField::create('FacebookPageID')->setTitle('Facebook Page ID'));
		$pageID->setRightTitle('The Facebook Page ID is used to pull data from the specified page.');
	}

}
<?php

class mandrillwrap extends CApplicationComponent {
	
	public $mandrillKey;
	public $fromEmail;
	public $fromName;
	public $to;
	public $images;
	public $attachments;
	public $text;
	public $html;
	public $subject;
	public $important;
	public $tags;
	
	public function init()
	{
		Yii::import('application.vendors.mandrill.Mandrill');
		$this->important = false;
		//define('MANDRILL_APIKEY',$this->mandrillKey);
	}
	
	public function sendEmail() {
		
		$mandrill = new Mandrill($this->mandrillKey);
    	$message = array(
        'html' => $this->html,
        'text' => $this->text,
        'subject' => $this->subject,
        'from_email' => $this->fromEmail,
        'from_name' => $this->fromName,
        'to' => $this->to,
        'headers' => array('Reply-To' => $this->fromEmail),
        'important' => false,
        'track_opens' => null,
        'track_clicks' => null,
        'auto_text' => null,
        'auto_html' => null,
        'inline_css' => null,
        'url_strip_qs' => null,
        'preserve_recipients' => null,
        'view_content_link' => null,
        'bcc_address' => null,
        'tracking_domain' => null,
        'signing_domain' => null,
        'return_path_domain' => null,
        'tags' => $this->tags,
        'attachments' => $this->attachments,
        'images' => $this->images,
    	);
	    $async = false;
	    $ip_pool = 'Main Pool';
	    $result = $mandrill->messages->send($message, $async, $ip_pool);
	    return $result;
	    }
	}

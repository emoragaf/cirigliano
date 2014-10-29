<?php

class mandrillwrap extends CApplicationComponent {
	
	public $mandrillKey;
	public $fromEmail;
	public $fromName;
	public $toEmail;
	public $toName;
	public $text;
	public $html;
	public $subject;
    public $tags;
	
	public function init()
	{
		Yii::import('application.vendors.mandrill.Mandrill');
		//define('MANDRILL_APIKEY','dLsiSqgctG1atlNvHqVdVg');
	}
	
	public function sendEmail() {
		
		$mandrill = new Mandrill('dLsiSqgctG1atlNvHqVdVg');
    	$message = array(
        'html' => '<p>Example HTML content</p>',
        'text' => 'Example text content',
        'subject' => 'example subject',
        'from_email' => $fromEmail,
        'from_name' => $fromName,
        'to' => array(
            array(
                'email' => $toEmail,
                'name' => $toName,
                'type' => 'to'
            )
        ),
        'headers' => array('Reply-To' => $fromEmail),
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
        'attachments' => array(
            array(
                'type' => 'text/plain',
                'name' => 'myfile.txt',
                'content' => 'ZXhhbXBsZSBmaWxl'
            )
        ),
        'images' => array(
            array(
                'type' => 'image/png',
                'name' => 'IMAGECID',
                'content' => 'ZXhhbXBsZSBmaWxl'
            )
        )
    );
    $async = false;
    $ip_pool = 'Main Pool';
    $send_at = 'example send_at';
    $result = $mandrill->messages->send($message, $async, $ip_pool, $send_at);
    print_r($result);
    }
}

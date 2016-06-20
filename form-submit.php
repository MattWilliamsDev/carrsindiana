<?php
require 'vendor/autoload.php';
// use Mailgun\Mailgun;
// use GuzzleHttp\Client as GuzzleClient;
// use \Http\Adapter\Guzzle6\Client as GuzzleAdapter;

require 'config.php';

// $client = new GuzzleClient();
// $adapter = new GuzzleAdapter( $client );
// $mg = new \Mailgun\Mailgun( API_KEY, $adapter );

$domain = 'carrsindiana.com';
$recipient = 'mark@carrsindiana.com';
// $recipient = 'bleacherbum17@gmail.com';
$recipientName = array( 'first' => 'Mark', 'last' => 'Collins' );

// $to      = 'Matt Williams <matt.williams@centricconsulting.com>';
$to      = 'Mark Collins <mark@carrsindiana.com>';
$subject = 'Submission received on carrsindiana.com';
$message = "<p>A submission has been received!</p><ul><li>Name: {$_POST[ 'name' ]}</li><li>Email: {$_POST[ 'email' ]}</li><li>Phone: {$_POST[ 'phone' ]}</li><li>Questions/Comments: {$_POST[ 'comments' ]}</li></ul>";
// To send HTML mail, the Content-type header must be set
$headers[] = 'MIME-Version: 1.0';
$headers[] = 'Content-type: text/html; charset=iso-8859-1';
$headers[] = "To: {$to}";
$headers[] = 'From: CARRSIndiana Admin <admin@carrsindiana.com>';
$headers[] = 'Reply-To: admin@carrsindiana.com';
$headers[] = 'X-Mailer: PHP/' . phpversion();


try {
    $result = mail( $to, $subject, $message, implode( "\r\n", $headers ) );
    /*$result = $mg->sendMessage(
        $domain
        , array(
            'from'         => 'CARRSIndiana Admin <admin@carrsindiana.com>'
            , 'to'         => "{$recipientName} <{$recipient}>"
            , 'subject'    => 'Submission received on carrsindiana.com'
            , 'html'       => "<p>A submission has been received!</p><ul><li>Name: {$_POST[ 'name' ]}</li><li>Email: {$_POST[ 'email' ]}</li><li>Phone: {$_POST[ 'phone' ]}</li><li>Questions/Comments: {$_POST[ 'comments' ]}</li></ul>"
            , 'h:Reply-To' => 'admin@carrsindiana.com'
        )
    );*/
    http_response_code( 200 );
} catch( Error $e ) {
    echo 'A send error occurred: ' . get_class( $e ) . ' - ' . $e->getMessage();
    throw $e;
    http_response_code( 500 );
}

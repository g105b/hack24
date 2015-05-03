<?php
namespace CTM\Page;
use CTM\Esendex\Inbox;

/**
 *
 */
class CheckSms extends \Gt\Page\Logic {

public function go() {
	if(isset($_GET["timestamp"])) {
		$this->session->delete("SmsTime");
		$this->session->set("SmsTime", $_GET["timestamp"]);
		die("timestamp is now $_GET[timestamp]");
	}

    $esendex = new Inbox();
    $messageArray = $esendex->getList();

	// The minimum timestamp to return:
    $smsTime = 0;

    if($this->session->exists("SmsTime")) {
		$smsTime = $this->session->get("SmsTime");
	}

	foreach($messageArray as $timestamp => $message) {
		if($timestamp <= $smsTime) {
			unset($messageArray[$timestamp]);
		}
	}

	$messageArray = array_reverse($messageArray);

	die(json_encode($messageArray));
}

}#

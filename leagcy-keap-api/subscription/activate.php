<?php
//Test Post URL
//https://members.nutritionsolutionslifestyle.com/api/nutrition/subscription/activate.php?auth=2udk2v4vek8zftwasdaihepq3uc9awdd3z&contactId=15

ini_set('display_errors', 1);
//error_reporting(E_ALL);
error_reporting(E_ALL & ~E_STRICT);

date_default_timezone_set('America/New_York');
//date_default_timezone_set('America/Los_Angeles');
//date_default_timezone_set('America/Phoenix');

// Include the SDK
require_once('../Infusionsoft/infusionsoft.php');

//Load config file with your clientid (key) and secret.
require '../Infusionsoft/config.php';


if (isset($_GET['auth'])) {
    if ($_GET['auth'] === '2udk2v4vek8zftwasdaihepq3uc9awdd3z') {
        
        
        echo '<p>Good to go!</p>';

        //$id = $_POST['contactId'];
        if( !empty($_REQUEST['contactId']) && is_numeric($_REQUEST['contactId']) ){
            $id = $_REQUEST['contactId'];
        } else if( !empty($_REQUEST['Id']) && is_numeric($_REQUEST['Id']) ){
            $id = $_REQUEST['Id'];
        } else{
            die("No contact info.");
        }
        echo "<p>Customer ID: ".$id."</p>";

        $subscriptions = Infusionsoft_DataService::query(new Infusionsoft_RecurringOrder(), array('ContactId' => $id));

        $lastSub = end($subscriptions);

        $lastSub->Status = 'Active';
        $lastSub->EndDate = null;
		
			$currentNBD = strtotime($lastSub->NextBillDate);
			$addSeven = strtotime("+7 day", $currentNBD);
		
		$lastSub->NextBillDate = date('c', $addSeven);

        $result = $lastSub->save();


        //Tag as Reactivate Subscription Successful
        $groupID = 2232; // A valid ID for an existing tag

        Infusionsoft_ContactService::addToGroup($id, $groupID);


    } else {
        echo '<p>Unautorized Access<br />System use not permitted!</p>';
    }
} else {
    echo '<p>Unautorized Access<br />System use not permitted!</p>';
}


?>
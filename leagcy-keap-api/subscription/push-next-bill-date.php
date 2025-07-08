<?php
//Posting URL Format
//http://members.nutritionsolutionslifestyle.com/api/subscription/push-next-bill-date.php?auth=2udk2v4vek8zftwasdaihepq3uc9awdd3z&days=1

$scriptVersion = 0.2;

//Check for authorization
if (isset($_GET['auth'])) {
    if ($_GET['auth'] === '2udk2v4vek8zftwasdaihepq3uc9awdd3z') {

        //Set defaults
        date_default_timezone_set('America/New_York');

        // Include the SDK
        require_once('../Infusionsoft/infusionsoft.php');

        //Load config file with your clientid (key) and secret.
        require '../Infusionsoft/config.php';

        //Get to work
        echo "<p>Authorized and running script version $scriptVersion!</p>";

        /*
        if (isset($_POST['contactId'])) {
            $id = $_POST['contactId'];
        } else if (isset($_POST['Id'])) {
            $id = $_POST['Id'];
        } else{
            die("No contact info.");
        }
        */

        if( !empty($_REQUEST['contactId']) && is_numeric($_REQUEST['contactId']) ){
            $id = $_REQUEST['contactId'];
        } else if( !empty($_REQUEST['Id']) && is_numeric($_REQUEST['Id']) ){
            $id = $_REQUEST['Id'];
        } else{
            die("No contact info.");
        }
        echo "<p>Customer ID: ".$id."</p>";

        //Don't need more contact info
        ////$contact = new Infusionsoft_Contact($id);
        
        //Get the contact's subs and find the most recent
        $subscriptions = Infusionsoft_DataService::query(new Infusionsoft_RecurringOrder(), array('ContactId' => $id));
        $lastSub = end($subscriptions);
        //var_dump($lastSub);

        // They aren't going to deactivate anymore
        ////$lastSub->Status = 'Active';
        ////$lastSub->EndDate = null;

        // Get the days to push
        if( !empty($_REQUEST['days']) && is_numeric($_REQUEST['days']) ){
            $days = $_REQUEST['days'];
        } else {
            die("Didn't get the number of days to push.");
        }
        //echo "<p>Days to Offset: ".$days."</p>";

        // Push the next bill date out
        $currentNBD = strtotime($lastSub->NextBillDate);
        $addSeven = strtotime("+$days day", $currentNBD);
        $lastSub->NextBillDate = date('c', $addSeven);

        //echo "<p>currentNBD: ".$currentNBD."</p>";
        //echo "<p>addSeven: ".$addSeven."</p>";

        // Save the new next bill date
        $result = $lastSub->save();

        // Tag as "Push Next Bill Date Successful"
        $groupID = 2672; // A valid ID for an existing tag

        Infusionsoft_ContactService::addToGroup($id, $groupID);

    } else {
        echo '<p>Unautorized Access<br />System use not permitted!</p>';
    }
} else {
    echo '<p>Unautorized Access<br />System use not permitted!</p>';
}


?>
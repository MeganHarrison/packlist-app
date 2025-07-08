<?php
//Posting URL Format
//http://members.nutritionsolutionslifestyle.com/api/subscription/sync-start-to-following-thursday.php?auth=19Ic2ovwShM7akwPX5dZ4zvrITl3aMX

$scriptVersion = 0.2;

//Check for authorization
if (isset($_GET['auth'])) {
    if ($_GET['auth'] === '19Ic2ovwShM7akwPX5dZ4zvrITl3aMX') {

        //Set defaults
        date_default_timezone_set('America/New_York');

        // Include Kint for Debugging
        //require_once('../Kint/Kint.class.php');

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
        //$contact = new Infusionsoft_Contact($id);
        
        //Get the contact's subs and find the most recent
        $subscriptions = Infusionsoft_DataService::query(new Infusionsoft_RecurringOrder(), array('ContactId' => $id));
        $lastSub = end($subscriptions);
        d($lastSub);

        //Push the next bill date to this Thursday
        $nextThursday = strtotime('next thursday');

        $lastSub->StartDate = date('c', $nextThursday);
        $lastSub->NextBillDate = date('c', $nextThursday);

        //This two lines add seven days to the next bill date
        $addSeven = strtotime("+7 day", $nextThursday);
        $lastSub->NextBillDate = date('c', $addSeven);

        //Save the new next bill date
        $result = $lastSub->save();

    } else {
        echo '<p>Unauthorized Access<br />System use not permitted!</p>';
    }
} else {
    echo '<p>Unauthorized Access<br />System use not permitted!</p>';
}


?>
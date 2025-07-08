<?php
//Reporting URL
//http://members.nutritionsolutionslifestyle.com/api/subscription/active-subscription-report.php

//Check for authorization
if (isset($_POST['auth'])) {
    if ($_POST['auth'] === 'u2QHHA46xCA7H') {

        //Set defaults
        date_default_timezone_set('America/New_York');

        // Include the SDK
        require_once('../Infusionsoft/infusionsoft.php');

        //Load config file with your clientid (key) and secret.
        require '../Infusionsoft/config.php';


//get some style
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Active Subscription Report</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
<?php

$date = date('m/d/Y', time());

echo "<h1>Active Subscription Report for $date</h1>";


/*
*  Get the contacts with active subscription in one API call
*/
    $saved_search_id = 2048;
    $saved_search_user_id = 51140;

    $all_cons = array();
    $page = 0;

        do{
            //$results = Infusionsoft_SearchService::getSavedSearchResults($saved_search_id, $saved_search_user_id, $page, array('Id'));
            $results = Infusionsoft_SearchService::getSavedSearchResultsAllFields($saved_search_id, $saved_search_user_id, $page);
            $all_cons = array_merge($results, $all_cons);
            $page++;
        }while(count($results) > 0);


//Start the table output

?>
    <div>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Contact</th>
                <th>Contact Id</th>
                <th>Email</th>
                <th>Billing amt</th>
                <th>Auto$</th>
                <th>Product name</th>
                <th>Start val</th>
                <th>End val</th>
                <th>Contact: meal plan</th>
                <th>Contact: delivery charge</th>
                <th>Contact: pick up location</th>
                <th>Promo</th>
                <th>Type</th>
                <th>Status</th>
                <th>Cycle</th>
                <th>Charges</th>
                <th>Last billed val</th>
                <th>Next Bill Date</th>
                <th>Cycle actual</th>
                <th>Product id</th>
            </tr>
        </thead>
        <tbody>
<?php


/*
*  Get all the subscription data to merge with the contact data
*/

        $page = 0;
        $subCounter = 0;
        do{
            $subscriptions = Infusionsoft_DataService::query(new Infusionsoft_RecurringOrder(), array('Status' => 'Active'), 1000, $page);


                foreach ($subscriptions as $subClass) {
                    $subData = $subClass->toArray();
                    
                    $key = array_search($subData['ContactId'], array_column($all_cons, 'ContactId'));
                    $merge = $all_cons[$key];


                    //Fix date formatting
                    if($merge['StartVal']<>null){
                        $startVal = date('m-d-Y', strtotime($merge['StartVal']));
                    }else{
                        $startVal = null;
                    };
                    if($merge['EndVal']<>null){
                        $endVal = date('m-d-Y', strtotime($merge['EndVal']));
                    }else{
                        $endVal = null;
                    };
                    if($merge['LastBilled']<>null){
                        $lastVal = date('m-d-Y', strtotime($merge['LastBilled']));
                    }else{
                        $lastVal = null;
                    };
                    if($subData['NextBillDate']<>null){
                        $nextVal = date('m-d-Y', strtotime($subData['NextBillDate']));
                    }else{
                        $nextVal = null;
                    };


                    echo '<tr>';

                        echo '<td>' . $merge['Contact'] . '</td>';
                        echo '<td>' . $merge['ContactId'] . '</td>';
                        echo '<td>' . $merge['Email'] . '</td>';
                        echo '<td>' . $merge['BillingAmt'] . '</td>';
                        echo '<td>' . $merge['Auto$'] . '</td>';
                        echo '<td>' . $merge['ProductName'] . '</td>';
                        echo '<td>' . $startVal . '</td>';
                        echo '<td>' . $endVal . '</td>';
                        echo '<td>' . $merge['Contact_MealPlan0'] . '</td>';
                        echo '<td>' . $merge['Contact_DELIVERYCHARGE'] . '</td>';
                        echo '<td>' . $merge['Contact_PickUpLocation'] . '</td>';
                        echo '<td>' . $merge['Promo'] . '</td>';
                        echo '<td>' . $merge['Type'] . '</td>';
                        echo '<td>' . $merge['Status'] . '</td>';
                        echo '<td>' . $merge['Cycle'] . '</td>';
                        echo '<td>' . $merge['Charges'] . '</td>';
                        echo '<td>' . $lastVal . '</td>';
                        echo '<td>' . $nextVal . '</td>';
                        echo '<td>' . $merge['CycleActual'] . '</td>';
                        echo '<td>' . $merge['ProductId'] . '</td>';

                    echo '</tr>';

                    $subCounter++;
                }
            $page++;
        }while(count($subscriptions) > 0);

?>
</tbody>
</table>
</div>
<?php

echo "<p>Found $subCounter results.</p>";

?>
</div>
</body>
</html>

<?php

    } else {
        echo '<p>Unautorized Access<br />System use not permitted!</p>';
    }
} else {
    echo '<p>Unautorized Access<br />System use not permitted!</p>';
}


?>

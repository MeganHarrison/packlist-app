<?php

$infusionsoft_host = 'qp158.infusionsoft.com';
//$infusionsoft_api_key = 'f6ad53c57534807119dd3cc59fab4eab';
$infusionsoft_api_key = '43b507ead4f51e9b4e589eea2a5997fcc2f83d81a45e9297408a479e57f07445';


//To Add Custom Fields, use the addCustomField method like below.
//Infusionsoft_Contact::addCustomField('_LeadScore');


//Below is just some magic...  Unless you are going to be communicating with more than one APP at the SAME TIME.  You can ignore it.
Infusionsoft_AppPool::addApp(new Infusionsoft_App($infusionsoft_host, $infusionsoft_api_key, 443));
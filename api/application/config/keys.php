<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Stripe Keys
| -------------------------------------------------------------------------
| sets the keys for stripe across the application
*/
$config['stripe'] = array(
        "secret_key"      => "sk_test_8h8vrFuUAvP0KbLQxXd2Avo9",
        "publishable_key" => "pk_test_6FK630uEMz94qw6rIw6Opv7M"
        );
// REMEMBER when changing the API key
// 			to clear the stripe_id's from the db so they can be refreshed!

/*
 | -------------------------------------------------------------------------
 | Facebook Keys
 | -------------------------------------------------------------------------
 | sets the keys for Facebook to use across the application
 */
$config['facebook'] = array(
		"app_id"      => "",
		"app_secret" => ""
);

/*
 | -------------------------------------------------------------------------
 | ChatAuth keys
 | -------------------------------------------------------------------------
 | sets the keys for Facebook to use across the application
 */
$config['chatauth'] = array(
		"connect_key" => ""
);

/*
| -------------------------------------------------------------------------
| Plaid Keys
| -------------------------------------------------------------------------
| sets the keys for Plaid across the application
*/
$config['plaid'] = array(
        'client_id' => '',
        'secret' => ''
        );
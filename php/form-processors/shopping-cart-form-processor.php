<?php
/**
 * Shopping cart form
 *
 * This form will be used to collect quantity of tickets desired and allow the user to see a preview of the order before checkout
 *
 * Created by Brendan Slevin
 */
session_start();
// require the event class to get the event data including the event/ticket price
require_once("../classes/event.php");

?>
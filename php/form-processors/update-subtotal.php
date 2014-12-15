<?php
if(session_status() === PHP_SESSION_NONE) {
	session_start();
}
$cartSubtotal	=	array();
$cartCount=count($_SESSION["cartItems"]);
foreach($_SESSION["cartItems"] as $item)	{
	$itemSubtotal	=	($item['qty']*$item['ticketPrice']);
	$_SESSION["cartItems"][$item['eventId']]['itemSubtotal'] = $itemSubtotal;
	$cartSubtotal[]	=	$itemSubtotal;
	for($i	=	0,	$cartTotal	=	0;	$i	<	$cartCount;	++$i)	{
		$cartTotal	=	$cartSubtotal[$i]+$cartTotal;
	}
	$_SESSION['cartSubtotal']	=	$cartTotal;

}

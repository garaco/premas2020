<?php

class header
{
	public function PushHeader($nombrePagina)
	{
	echo ' <meta charset="utf-8">
	<title>'.$nombrePagina.'</title>
    <link rel="stylesheet" type="text/css" href="'.PATH_PUBLIC.'/css/siderbar.css">
    <link rel="stylesheet" type="text/css" href="'.PATH_PUBLIC.'/css/style.css">
    <link rel="stylesheet" type="text/css" href="'.PATH_PUBLIC.'/fontello/css/fontello.css">
    <link rel="stylesheet" type="text/css" href="'.PATH_PUBLIC.'/font-awesome/css/font-awesome.css">
    <link rel="stylesheet" type="text/css" href="'.PATH_PUBLIC.'/boostrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="'.PATH_PUBLIC.'/css/alertify.css">
    <link rel="stylesheet" type="text/css" href="'.PATH_PUBLIC.'/css/themes/bootstrap.css">

    <link rel="icon" type="image/png"  href="'.PATH_PUBLIC.'/img/logo1.png">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" type="text/css" href="'.PATH_PUBLIC.'/css/loader.css">
   ';

	}
}


 ?>

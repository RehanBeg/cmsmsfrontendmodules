<?php

$form = 'login';
if( $this->LoggedInId() ) $form = 'logoutform';
require(__DIR__."/action.{$form}.php");

<?php

	if( !isset( $theme ) ){
		require( STYLESHEETPATH  . '/extension/AMTY.class.php' );
		$theme = new AMTY();
	}
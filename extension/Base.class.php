<?php

	if( !class_exists( 'BZ_Base' ) ){
		class BZ_Base{

			protected $domain = 'bz-base';

			public function __get( $key ){
				if( isset( $this->$key ) ){
					return $this->$key;
				}
			}

			public function __toString(){
				return strtolower( get_class( $this ) );
			}
		}
	}
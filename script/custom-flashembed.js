(function(){
	if( window.flashembed ){
		window.flashembed.custom = function( src, root, vars, params ){
			var _id = ( ( typeof root == 'string' ) ? root.replace( '#', '' ): root.id ) + '-flash';
			if( _id == '-flash' ) _id = Math.ceil( Math.random()*99999999+10000000 ) + _id;

			var _params = {src:src,version:[10,0],wmode:'opaque',id:_id};
			if( params ){
				for( var k in params ){
					if( params.hasOwnProperty( k ) ){
						_params[k] = params[k];
					}
				}
			}

			var _vars = {id:_params.id};
			if( vars ){
				for( var k in vars ){
					if( vars.hasOwnProperty( k ) ){
						_vars[k] = vars[k];
					}
				}
			}

			var _api = flashembed( root, _params, _vars );
			_api.id = _params.id;
			_api.flashobject = ( _api.getApi().nodeName == 'OBJECT' ) ? _api.getApi(): null;

			if( _params.callback ){
				var _onload = window.onload||function(){};
				window.onload = function(){
					_onload();
					setTimeout( function(){_params.callback( _api.flashobject !== null, _api );}, 500 );
				}
			}

			return _api;
		}
	}
})();

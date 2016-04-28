var $form = document.querySelectorAll('form');

for( var i = 0; i < $form.length; ++i ){
	console.log( $form[i] );
	$form[i].onsubmit = function( event ){
		event.preventDefault();
		
		submitForm( this );
	}
}

function submitForm( $form ){
	var url = $form.action;
	var param = [];
	$child = $form.children;
	
	for( var i = 0; i < $child.length; ++i ){
		if( $child[i].tagName === 'INPUT' ){
			param.push( $child[i].name + '=' + $child[i].value );
		}
	}
	param.pop(); // delete value of submit button
	param = param.join('&');
	
	url = url + '?' + param;
	
	var xhr = new XMLHttpRequest();
	xhr.onreadystatechange = function(){
		if( xhr.readyState == 4 && xhr.status == 200) {
			document.getElementById('output').innerHTML = xhr.responseText;
		}
	}
	xhr.open( 'GET', url );
	xhr.send();
}
$(document).ready(function(){

	// CKEditor
	ClassicEditor
    .create( document.querySelector( '#body' ) )
    .catch( error => {
        console.error( error );
    } );

    // rest of the code



});


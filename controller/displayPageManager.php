<?php

if ( !isset( $_POST[ 'pageName' ] ) ) {
    http_response_code( 404 );
    echo( '<img src="https://http.cat/404" alt="Error 404 : Not Found" />' )
    die();
} else {
    $pageName = $_POST[ 'pageName' ];
    
    //list every .php file in pages folder
    $phpFiles = glob('../view/pages/*.{php}', GLOB_BRACE );

    
    
}

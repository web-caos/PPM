<?php

Route::get( 'login', 'UserController@getLogin' );
Route::post( 'login', 'UserController@postLogin' );
Route::get( 'logout', 'UserController@getLogout' );

Route::get( '/', 'HomeController@getHome' );

Route::post( '/upload/PcPerformance', function () {

    if ( base64_decode( $_SERVER["HTTP_X_AUTHORIZATION"] ) == ("admin:Tr41n1t0!") ) {

        if ( move_uploaded_file( $_FILES['file']['tmp_name'], public_path() . '/listini/PcPerformance.xml' ) ) {
            echo "OK" . PHP_EOL;
        } else {
            echo "Errore: Impossibile salvare il catalogo prodotti";
            exit;
        }

    } else {
        echo "Errore: Nome utente o password errati;";
        exit;
    }

    $xml = simplexml_load_file(public_path() . '/listini/PcPerformance.xml');

    $rows = $xml->Products->Product;

    if ( $rows ) {
        DBase::insert( $rows );
    }

    $rows = $xml->UpdatedProducts->Product;

    if ( $rows ) {
        DBase::insert( $rows, 'update' );
    }

    $rows = $xml->DeletedProducts->Product;

    if ( $rows ) {
        DBase::insert( $rows, 'delete' );
    }

    Feeds::send();

} );

Route::post( '/upload/TotalTechnology', function () {

    if ( base64_decode( $_SERVER["HTTP_X_AUTHORIZATION"] ) == ("admin:Tr41n1t0!") ) {

        if ( move_uploaded_file( $_FILES['file']['tmp_name'], public_path() . '/listini/TotalTechnology.xml' ) ) {
            echo "OK" . PHP_EOL;
        } else {
            echo "Errore: Impossibile salvare il catalogo prodotti";
            exit;
        }

    } else {
        echo "Errore: Nome utente o password errati;";
        exit;
    }

    $xml = simplexml_load_file( public_path() . '/listini/TotalTechnology.xml' );

    $rows = $xml->Products->Product;

    if ( $rows ) {
        DBase::insertTotal( $rows );
    }

    $rows = $xml->UpdatedProducts->Product;

    if ( $rows ) {
        DBase::insertTotal( $rows, 'update' );
    }

    $rows = $xml->DeletedProducts->Product;

    if ( $rows ) {
        DBase::insertTotal( $rows, 'delete' );
    }

} );
Route::get( 'download/orders', function () {

    DBase::insertOrders();

    Feeds::getOrders();

} );

Route::get( 'import/orders', function () {

    DBase::insertOrders();

} );

function sendInventoryFeed( $feed ) {

    try {
        $amz = new AmazonFeed(); //if there is only one store in config, it can be omitted
        $amz->setFeedType( "_POST_FLAT_FILE_INVLOADER_DATA_" ); //feed types listed in documentation
        $amz->setFeedContent( $feed ); //can be either XML or CSV data; a file upload method is available as well
        $amz->submitFeed(); //this is what actually sends the request
        return $amz->getResponse();
    } catch ( Exception $ex ) {
        echo 'There was a problem with the Amazon library. Error: ' . $ex->getMessage();
    }
}

function getAmazonFeedStatus() {

    try {
        $amz = new AmazonFeedList( Config::get( 'amazon.storeName' ) );
        $amz->setTimeLimits( '- 720 hours' ); //limit time frame for feeds to any updated since the given time
        $amz->setFeedStatuses( array( "_SUBMITTED_", "_IN_PROGRESS_", "_DONE_" ) ); //exclude cancelled feeds
        $amz->fetchFeedSubmissions(); //this is what actually sends the request
        return $amz->getFeedList();
    } catch ( Exception $ex ) {
        echo 'There was a problem with the Amazon library. Error: ' . $ex->getMessage();
    }
}

function getAmazonOrders() {

    try {
        $amz = new AmazonOrderList( Config::get( 'amazon.storeName' ) ); //store name matches the array key in the config file
        $amz->setLimits( 'Modified', "- 720 hours" ); //accepts either specific timestamps or relative times
        $amz->setFulfillmentChannelFilter( "MFN" ); //no Amazon-fulfilled orders
        //$amz->setOrderStatusFilter(
        //array("Unshipped", "PartiallyShipped", "Shipped")
        //); //no shipped or pending orders
        $amz->setUseToken(); //tells the object to automatically use tokens right away
        $amz->fetchOrders(); //this is what actually sends the request
        return $amz->getList();
    } catch ( Exception $ex ) {
        echo 'There was a problem with the Amazon library. Error: ' . $ex->getMessage();
    }
}
<?php

class Amazon {

    public static function getOrders($status) {

        try {
            $amz = new AmazonOrderList(Config::get( 'amazon.storeName' ));
            $amz->setLimits( 'Modified', "- 72 hours" );
            $amz->setFulfillmentChannelFilter( "MFN" );
            $amz->setOrderStatusFilter( $status );
            $amz->setUseToken();
            $amz->fetchOrders();
            return $amz->getList();
        } catch ( Exception $ex ) {
            echo 'There was a problem with the Amazon library. Error: ' . $ex->getMessage();
        }

    }

    public static function getFeedStatus() {

        try {
            $amz = new AmazonFeedList(Config::get( 'amazon.storeName' ));
            $amz->setTimeLimits( '- 720 hours' ); //limit time frame for feeds to any updated since the given time
            $amz->setFeedStatuses( array( "_SUBMITTED_", "_IN_PROGRESS_", "_DONE_" ) ); //exclude cancelled feeds
            $amz->fetchFeedSubmissions(); //this is what actually sends the request
            return $amz->getFeedList();
        } catch ( Exception $ex ) {
            echo 'There was a problem with the Amazon library. Error: ' . $ex->getMessage();
        }
    }

    public static function sendInventoryFeed( $feed, $type ) {

        switch ( $type ) {
            case 'loader':
                $feedType = "_POST_FLAT_FILE_INVLOADER_DATA_";
                break;
            case 'quantity':
                $feedType = "_POST_FLAT_FILE_PRICEANDQUANTITYONLY_UPDATE_DATA_";
                break;
            default:
                $feedType = "_POST_FLAT_FILE_INVLOADER_DATA_";
                break;
        }
        try {
            $amz = new AmazonFeed(); //if there is only one store in config, it can be omitted
            $amz->setFeedType( $feedType ); //feed types listed in documentation
            $amz->setFeedContent( $feed ); //can be either XML or CSV data; a file upload method is available as well
            $amz->submitFeed(); //this is what actually sends the request
            return $amz->getResponse();
        } catch ( Exception $ex ) {
            echo 'There was a problem with the Amazon library. Error: ' . $ex->getMessage();
        }
    }

}
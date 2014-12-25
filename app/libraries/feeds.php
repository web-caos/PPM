<?php

class Feeds {

    public static function getOrders(){

        $orders = Order::all();

        if( $orders ){

            $head = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<EasyfattDocuments AppVersion="2" Creator="Danea Soft" CreatorUrl="www.danea.it">
</EasyfattDocuments>
XML;

            $xml       = new SimpleXMLElement($head);
            $documents = $xml->addChild( 'Documents' );

            foreach($orders as $order){

                if('Unshipped' == $order->OrderStatus){

                    /* Document */

                    $document = $documents->addChild( 'Document' );
                    $document->addChild( 'DocumentType', 'C' );
                    $document->addChild( 'Date', date( "Y-m-d", $order->PurchaseDate ) );
                    $document->addChild( 'Number', $order->id );
                    $document->addChild( 'Numbering', '/AMZ' );
                    $document->addChild( 'PricesIncludeVat', 'true' );
                    $document->addChild( 'InternalComment', 'Rif. Ordine Amazon ' . $order->AmazonOrderId );

                    $total = json_decode($order->OrderTotal);

                    $document->addChild( 'Total', $total->Amount );

                    /* Customer */

                    $customer = json_decode($order->ShippingAddress);

                    $document->addChild( 'CustomerWebLogin', $order->BuyerEmail );
                    if (!empty($customer->Name)) $document->addChild( 'CustomerName', $customer->Name );
                    if (!empty($customer->AddressLine1)) $document->addChild( 'CustomerAddress', $customer->AddressLine1 );
                    if (!empty($customer->PostalCode)) $document->addChild( 'CustomerPostcode', $customer->PostalCode );
                    if (!empty($customer->StateOrRegion)) $document->addChild( 'CustomerProvince', $customer->StateOrRegion );
                    if (!empty($customer->City)) $document->addChild( 'CustomerCity', $customer->City );
                    if (!empty($customer->Phone)) $document->addChild( 'CustomerTel', $customer->Phone );
                    $document->addChild( 'CustomerEmail', $order->BuyerEmail );

                    /* Products */

                    $rows = $document->addChild( 'Rows' );

                    foreach ( $order->items as $item ) {

                        $row = $rows->addChild( 'Row' );
                        $row->addChild( 'Code', $item->SellerSKU );
                        $row->addChild( 'Description', $item->Description );
                        $row->addChild( 'Qty', $item->QuantityOrdered );
                        $row->addChild( 'Price', ( $item->ItemPrice / $item->QuantityOrdered ) );
                        $vat = $row->addChild( 'VatCode', '22' );
                        $vat->addAttribute( 'Perc', '22' );

                    }

                }

            }

            echo $xml->asXML();

        }

    }

    public static function send(){
        $products = Product::all();
        if ( $products ) {
            $update = Array();
            $insert = Array();
            $delete = Array();
            foreach ( $products as $product ) {
                if ( $product->Code && $product->GrossPrice4 && isset($product->AvailableQty) ) {

                    $quantity = $product->AvailableQty;
                    if ( $product->AvailableQty < 0 ) {

                        $quantity = '0';

                    }

                    if ( $product->Total ) {

                        $quantity = ($quantity + $product->Total->AvailableQty);

                        if ( $quantity < 0 ) {

                            $quantity = '0';

                        }

                    }

                    $price = ($product->GrossPrice4 + $product->Shipping);

                    if ( 'Update' == $product->NextAction ) {

                        $row = array(
                            'sku'                          => $product->Code,
                            'price'                        => str_replace( '.', ',', $price ),
                            'minimum-seller-allowed-price' => '',
                            'maximum-seller-allowed-price' => '',
                            'quantity'                     => $quantity,
                            'fulfillment-channel'          => '',
                            'leadtime-to-ship'             => '',
                        );

                        $update[] = $row;

                    }

                    if ( 'Insert' == $product->NextAction ) {

                        if ( $product->BarCode ) {

                            $row = array(
                                'sku'                          => $product->Code,
                                'product-id'                   => $product->BarCode,
                                'product-id-type'              => '4',
                                'price'                        => str_replace( '.', ',', $price ),
                                'minimum-seller-allowed-price' => '',
                                'maximum-seller-allowed-price' => '',
                                'item-condition'               => '11',
                                'quantity'                     => $quantity,
                                'add-delete'                   => 'a',
                                'item-note'                    => '',
                                'expedited-shipping'           => '',
                                'will-ship-internationally'    => '',
                                'fulfillment-center-id'        => '',
                            );

                            $insert[] = $row;

                        }

                        $product->NextAction = 'Update';

                        $product->save();

                    }

                    if ( 'Delete' == $product->NextAction ) {

                        $row = array(
                            'sku'                          => $product->Code,
                            'product-id'                   => $product->BarCode,
                            'product-id-type'              => '4',
                            'price'                        => str_replace( '.', ',', $price ),
                            'minimum-seller-allowed-price' => '',
                            'maximum-seller-allowed-price' => '',
                            'item-condition'               => '11',
                            'quantity'                     => $quantity,
                            'add-delete'                   => 'x',
                            'item-note'                    => '',
                            'expedited-shipping'           => '',
                            'will-ship-internationally'    => '',
                            'fulfillment-center-id'        => '',
                        );

                        $delete[] = $row;

                        $product->delete();

                    }
                }
            }
            self::create( $update, 'products_update.txt', 'update' );
            self::create( $insert, 'products_insert.txt', 'insert' );
            self::create( $delete, 'products_delete.txt', 'delete' );

            if(!empty($delete)){
                $file = file_get_contents( public_path() . '/feeds/products_delete.txt' );
                Amazon::sendInventoryFeed( $file, 'loader' );
            }
            if(!empty($insert)){
                $file = file_get_contents( public_path() . '/feeds/products_insert.txt' );
                Amazon::sendInventoryFeed( $file, 'loader' );
            }
            if(!empty($update)){
                $file = file_get_contents( public_path() . '/feeds/products_update.txt' );
                Amazon::sendInventoryFeed( $file, 'quantity' );
            }
        }
    }

    public static function create($array, $filename, $mode) {

        $fp = fopen( public_path() . '/feeds/' . $filename, 'w' );

        switch ( $mode ) {
            case 'update':
                fputcsv( $fp, array(
                    'sku',
                    'price',
                    'minimum-seller-allowed-price',
                    'maximum-seller-allowed-price',
                    'quantity',
                    'fulfillment-channel',
                    'leadtime-to-ship',
                ), "\t", '"' );
                break;
            case 'insert':
                fputcsv( $fp, array(
                    'sku',
                    'product-id',
                    'product-id-type',
                    'price',
                    'minimum-seller-allowed-price',
                    'maximum-seller-allowed-price',
                    'item-condition',
                    'quantity',
                    'add-delete',
                    'item-note',
                    'expedited-shipping',
                    'will-ship-internationally',
                    'fulfillment-center-id'
                ), "\t", '"' );
                break;
            case 'delete':
                fputcsv( $fp, array(
                    'sku',
                    'product-id',
                    'product-id-type',
                    'price',
                    'minimum-seller-allowed-price',
                    'maximum-seller-allowed-price',
                    'item-condition',
                    'quantity',
                    'add-delete',
                    'item-note',
                    'expedited-shipping',
                    'will-ship-internationally',
                    'fulfillment-center-id'
                ), "\t", '"' );
                break;
        }

        foreach ( $array as $row ) {
            fputcsv( $fp, $row, "\t", '"' );
        }
        fclose( $fp );

    }
}
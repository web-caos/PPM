<?php

class DBase {

    public static function insert( $rows, $mode = 'full' ) {

        switch ( $mode ) {

            case 'full':

                DB::table('products')->update(array('NextAction' => 'Delete'));

                foreach ( $rows as $row ) {

                    if ( strpos( $row->CustomField1, 'VENDITA WEB' ) !== false ) {

                        $code = $row->Code;

                        $product = Product::find( $code );

                        if ( $product ) {

                            $product->BarCode = $row->Barcode;

                            $product->Description = $row->Description;

                            $product->ProducerName = $row->ProducerName;

                            $product->SupplierProductCode = $row->SupplierProductCode;

                            $product->AvailableQty = $row->AvailableQty;

                            $product->GrossPrice4 = $row->GrossPrice4;

                            $product->Shipping = str_replace(',', '.', $row->CustomField3);

                            $product->NextAction = 'Update';

                            $product->save();

                        } else {

                            $product = new Product;

                            $product->Code = $row->Code;

                            $product->Barcode = $row->Barcode;

                            $product->Description = $row->Description;

                            $product->ProducerName = $row->ProducerName;

                            $product->SupplierProductCode = $row->SupplierProductCode;

                            $product->AvailableQty = $row->AvailableQty;

                            $product->GrossPrice4 = $row->GrossPrice4;

                            $product->Shipping = str_replace(',', '.', $row->CustomField3);

                            $product->NextAction = 'Insert';

                            $product->save();

                        }
                    }

                }
                break;
            case 'update':
                foreach ( $rows as $row ) {
                    if ( strpos( $row->CustomField1, 'VENDITA WEB' ) !== false ) {

                        $code = $row->Code;

                        $product = Product::find( $code );

                        if ( $product ) {

                            $product->BarCode = $row->Barcode;

                            $product->Description = $row->Description;

                            $product->ProducerName = $row->ProducerName;

                            $product->SupplierProductCode = $row->SupplierProductCode;

                            $product->AvailableQty = $row->AvailableQty;

                            $product->GrossPrice4 = $row->GrossPrice4;

                            $product->Shipping = str_replace(',', '.', $row->CustomField3);

                            $product->NextAction = 'Update';

                            $product->save();

                        } else {

                            $product = new Product;

                            $product->Code = $row->Code;

                            $product->BarCode = $row->Barcode;

                            $product->Description = $row->Description;

                            $product->ProducerName = $row->ProducerName;

                            $product->SupplierProductCode = $row->SupplierProductCode;

                            $product->AvailableQty = $row->AvailableQty;

                            $product->GrossPrice4 = $row->GrossPrice4;

                            $product->Shipping = str_replace(',', '.', $row->CustomField3);

                            $product->NextAction = 'Insert';

                            $product->save();

                        }
                    }
                }
                break;
            case 'delete':
                foreach ( $rows as $row ) {
                    if ( strpos( $row->CustomField1, 'VENDITA WEB' ) !== false ) {

                        $code = $row->Code;

                        $product = Product::find( $code );

                        if ( $product ) {

                            $product->NextAction = 'Delete';

                            $product->save();

                        }
                    }
                }
                break;

        }

    }

    public static function insertTotal( $rows, $mode = 'full' ) {

        switch ( $mode ) {

            case 'full':

                Product2::truncate();

                foreach ( $rows as $row ) {

                    $product = new Product2;

                    $product->Code = $row->Code;

                    $product->AvailableQty = $row->AvailableQty;

                    $product->save();

                }
                break;

            case 'update':
                foreach ( $rows as $row ) {

                    $code = $row->Code;

                    $product = Product2::find( $code );

                    if ( $product ) {

                        $product->AvailableQty = $row->AvailableQty;

                        $product->save();

                    } else {

                        $product = new Product2;

                        $product->Code = $row->Code;

                        $product->AvailableQty = $row->AvailableQty;

                        $product->save();

                    }
                }
                break;
            case 'delete':
                foreach ( $rows as $row ) {

                    $code = $row->Code;

                    $product = Product2::find( $code );

                    if ( $product ) {

                        $product->delete();

                    }
                }
                break;

        }

    }

    public static function insertOrders(){
        $status = array(
            'Unshipped',
            'PartiallyShipped',
            'Shipped'
        );
        $orders = Amazon::getOrders( $status );
        if ( $orders ) {

            foreach ( $orders as $amz_order ) {

                $order = Order::where( 'AmazonOrderId', '=', $amz_order->getAmazonOrderId() )->first();

                if ( $order ) {

                    $order->OrderStatus = $amz_order->getOrderStatus();

                    $order->save();

                } else {

                    $order = new Order;

                    $order->AmazonOrderId   = $amz_order->getAmazonOrderId();
                    $order->PurchaseDate    = strtotime( $amz_order->getPurchaseDate() );
                    $order->OrderStatus     = $amz_order->getOrderStatus();
                    $order->ShippingAddress = json_encode( $amz_order->getShippingAddress() );
                    $order->OrderTotal      = json_encode( $amz_order->getOrderTotal() );
                    $order->BuyerEmail      = $amz_order->getBuyerEmail();

                    $order->save();

                    foreach ( $amz_order->fetchItems() as $amz_item ) {

                        $item = new Item;

                        $item->AmazonOrderId = $amz_order->getAmazonOrderId();
                        $item->ASIN          = $amz_item['ASIN'];
                        $item->SellerSKU     = $amz_item['SellerSKU'];

                        $product = Product::find( $amz_item['SellerSKU'] );

                        if ( $product ) {
                            $item->Description = $product->Description;
                        } else {
                            $item->Description = $amz_item['Title'];
                        }

                        $item->QuantityOrdered = $amz_item['QuantityOrdered'];
                        $item->ItemPrice       = $amz_item['ItemPrice']['Amount'];

                        $item->save();

                    }

                }
            }
        }
    }

}
<?php

class cartModel extends modelAbstract {

    protected $_table = 'cart';

    protected $_columns = [
        'token',
        'user_id',
    ];

    public function addProduct(int $product_id):void {
        $product = productModel::where('deleted','=',0)->find($product_id);
        if($product) {
            $cart_product = cartProductModel::where('product_id','=',$product_id)->where('cart_id','=',$this->id)->first();
            if(!$cart_product) {
                cartProductModel::create([
                    'cart_id' => $this->id,
                    'product_id' => $product_id,
                    'count' => 1
                ]);
            }
            else {
                $cart_product->count++;
                $cart_product->save();
            }
        }
    }

    public function removeProduct(int $product_id):void {
        $product = productModel::where('deleted','=',0)->find($product_id);
        if($product) {
            $cart_product = cartProductModel::where('product_id','=',$product_id)->where('cart_id','=',$this->id)->first();
            if($cart_product) {
                $cart_product->delete();
            }
        }
    }

    public function countProductUpdate(int $product_id, int $count):void {
        $product = productModel::where('deleted','=',0)->find($product_id);
        if($product) {
            $cart_product = cartProductModel::where('product_id', '=', $product_id)->where('cart_id', '=', $this->id)->first();
            if ($cart_product) {
                $cart_product->count = $count;
                $cart_product->save();
            }
        }
    }

}
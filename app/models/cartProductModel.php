<?php

class cartProductModel extends modelAbstract {

    protected $_table = 'cart_products';

    protected $_columns = [
        'cart_id',
        'product_id',
        'count',
        'price'
    ];

}
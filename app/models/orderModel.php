<?php

class orderModel extends modelAbstract {

    protected $_table = 'orders';

    protected $_columns = [
        'cart_id',
        'user_id',
        'status',
        'first_name',
        'last_name',
        'address',
        'city',
        'post_code',
        'delivery_type',
        'added_date',
        'sum'
    ];

}
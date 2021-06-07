<?php

class newsModel extends modelAbstract {

    protected $_table = 'news';

    protected $_columns = [
        'name',
        'code_name',
        'description',
        'added_date',
    ];

}
<?php

class newsCommentModel extends modelAbstract {

    protected $_table = 'news_comments';

    protected $_columns = [
        'news_id',
        'user_id',
        'comment',
        'added_date',
    ];

}
<?php 
return [
    'columns' => [
        'id' => [
            'type' => 'integer',
            'autoincrement' => true,
            'required' => true,
            'unsigned' => true,
            'comment' => '自增id',
        ],

        'app_id' => [
            'type' => 'string',
            'length' => 50,
            'default' => '',
            'required' => true,
            'comment' => '公众号appid',
        ],

        'type' => [
            'type' => 'string',
            'length' => 10,
            'default' => '',
            'required' => true,
            'comment' => '素材类型',
        ],

        'media_id' => [
            'type' => 'string',
            'default' => '',
            'required' => false,
            'comment' => '微信返回的素材id',
        ],

        'is_sync' => [
            'type' => 'boolean',
            'default' => 2,
            'required' => false,
            'comment' => '是否已同步至公众号，1已同步，2未同步',
        ],

        'is_tem' => [
            'type' => 'boolean',
            'default' => 2,
            'required' => false,
            'comment' => '是否是临时素材,1是，2不是'
        ],

    ],

    'primary' => 'id',
    'index' => [
        'appid' => ['columns' => ['app_id']],
        'mediaid' => ['columns' => ['media_id']],
    ],
    'comment' => '素材管理概表',
];


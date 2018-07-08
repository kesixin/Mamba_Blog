<?php

    return [
        'show'=>env("MINI_PROGRAM",false),
        'menu'=>[
            [
                'backend.home' => [
                    'icon'  => 'fa fa-home',
                    'name'  => '小程序管理'
                ]
            ],
            [
                'tree_title' => [
                    'icon' => 'fa fa-files-o',
                    'name' => '文章'
                ],
                'backend.article.index' => [
                    'icon' => '',
                    'name' => '文章管理'
                ],
                'backend.article.create' => [
                    'icon' => '',
                    'name' => '发布文章'
                ],
                'backend.category.index' => [
                    'icon' => '',
                    'name' => '文章分类'
                ]
            ],
        ]
    ];
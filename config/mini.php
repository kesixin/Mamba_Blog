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
                'backend.article.mini-index' => [
                    'icon' => '',
                    'name' => '文章管理'
                ],
                'backend.article.mini-create' => [
                    'icon' => '',
                    'name' => '发布文章'
                ],
                'backend.category.category-index' => [
                    'icon' => '',
                    'name' => '文章分类'
                ]
            ],
            [
                'backend.user.user-index' => [
                    'icon' => 'fa fa-user',
                    'name' => '用户列表'
                ]
            ],
            [
                'backend.comment.mini-index' => [
                    'icon' => 'fa fa-comment',
                    'name' => '评论列表'
                ]
            ],
        ]
    ];
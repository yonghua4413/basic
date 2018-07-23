<?php 
    return [
        [
            "name" => "文章管理",
            "type" => "list",
            "url" => "news",
            "pcode"=> "pnew_list",
            "class" => "glyphicon glyphicon-book",
            "list" => [
                [
                    "name" => "文章列表",
                    "code" => "news_list",
                    "url" => "news/index"
                ],
                [
                    "name" => "文章类型",
                    "code" => "new_type",
                    "url" => "news/type"
                ],
                [
                    "name" => "发布中心",
                    "code" => "push_center",
                    "url" => "news/push"
                ]
            ]
        ],
        [
            "name" => "手工位管理",
            "type" => "list",
            "url" => "manual",
            "pcode"=> "pmanual_list",
            "class" => "glyphicon glyphicon-wrench",
            "list" => [
                [
                    "name" => "手工位列表",
                    "code" => "	manual_list",
                    "url" => "manual/index"
                ],
                [
                    "name" => "手工位类型",
                    "code" => "manual_type",
                    "url" => "manual/type"
                ]
            ]
        ],
        [
            "name" => "系统管理",
            "type" => "list",
            "url" => "system",
            "pcode"=> "sys_list",
            "class" => "glyphicon glyphicon-cog",
            "list" => [
                [
                    "name" => "管理员",
                    "code" => "admin",
                    "url" => "admin/index"
                ],
                [
                    "name" => "权限",
                    "code" => "auth",
                    "url" => "auth/index"
                ],
                [
                    "name" => "角色",
                    "code" => "role",
                    "url" => "role/index"
                ]
            ]
        ],
        [
            "name" => "系统日志",
            "type" => "page",
            "url" => "logs/index",
            "pcode"=> "log_list",
            "class" => "glyphicon glyphicon-time"
        ]
    ];
?>
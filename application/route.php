<?php
//注册index模块路由规则
return [
    '[Listing]'   =>[
    	':cid' => ['index/listing/index',['method' => 'get'], ['cid' => '\d+']]
    ],
    '[Show]'   => [
    	':cid/:id' => ['index/show/index',['method' => 'get'],[['cid' => '\d+','id' => '\d+']]]
    ],
    '[Search]'  => [
    	':keywords' => ['index/search/index', ['method' => 'get']]
    ]


];


<?php
    return [
        '[app]' => [
            'category' => [
                'app/category/index',
                ['merge_extra_vars'=>true, 'method'=>'get|post']
            ],
            'exhibit'  => [
                'app/exhibit/index',
                ['merge_extra_vars'=>true, 'method'=>'get|post']
            ],
            'article'  => [
                'app/article/index',
                ['merge_extra_vars'=>true, 'method'=>'get|post']
            ],
            'article/:_id'  => [
                'app/article/detail',
                ['merge_extra_vars'=>true, 'method'=>'get']
            ],
            '3d' => [
                'app/exhibit/the3d',
                ['merge_extra_vars'=>true, 'method'=>'get']
            ],
        ]
    ];
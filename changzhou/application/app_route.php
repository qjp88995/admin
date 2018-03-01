<?php
    return [
        '[museum]' => [
            'exhibition/select'  => [
                'museum/exhibition/select',
                ['merge_extra_vars'=>true, 'method'=>'get|post']
            ],
            'exhibition/find'  => [
                'museum/exhibition/find',
                ['merge_extra_vars'=>true, 'method'=>'get|post']
            ],
            'exhibit/select'  => [
                'museum/exhibit/select',
                ['merge_extra_vars'=>true, 'method'=>'get|post']
            ],
            'exhibit/find'  => [
                'museum/exhibit/find',
                ['merge_extra_vars'=>true, 'method'=>'get|post']
            ],
            'exhibit/giveLike'  => [
                'museum/exhibit/giveLike',
                ['merge_extra_vars'=>true, 'method'=>'get|post']
            ],
            'exhibit/giveView'  => [
                'museum/exhibit/giveView',
                ['merge_extra_vars'=>true, 'method'=>'get|post']
            ],
            '/'  => [
                'museum/index/index',
                ['method' => 'get']
            ]
        ],
        '[volunteer]' => [
            'category/select' => [
                'volunteer/category/select',
                ['merge_extra_vars'=>true, 'method'=>'get|post']
            ],
            'category/find' => [
                'volunteer/category/find',
                ['merge_extra_vars'=>true, 'method'=>'get|post']
            ],
            'news/select' => [
                'volunteer/news/select',
                ['merge_extra_vars'=>true, 'method'=>'get|post']
            ],
            'news/find' => [
                'volunteer/news/find',
                ['merge_extra_vars'=>true, 'method'=>'get|post']
            ],
            'volunteer/register' => [
                'volunteer/volunteer/register',
                ['merge_extra_vars'=>true, 'method'=>'post']
            ],
            'volunteer/editData' => [
                'volunteer/volunteer/editData',
                ['merge_extra_vars'=>true, 'method'=>'get|post']
            ],
            'volunteer/login' => [
                'volunteer/volunteer/login',
                ['merge_extra_vars'=>true, 'method'=>'post']
            ],
            'volunteer/logout' => [
                'volunteer/volunteer/logout',
                ['merge_extra_vars'=>true, 'method'=>'post']
            ],
            'volunteer/getMyInfo' => [
                'volunteer/volunteer/getMyInfo',
                ['merge_extra_vars'=>true, 'method'=>'post']
            ],
            'volunteer/getMyBooked' => [
                'volunteer/volunteer/getMyBooked',
                ['merge_extra_vars'=>true, 'method'=>'post']
            ],
            'service/select' => [
                'volunteer/service/select',
                ['merge_extra_vars'=>true, 'method'=>'get|post']
            ],
            'service/find' => [
                'volunteer/service/find',
                ['merge_extra_vars'=>true, 'method'=>'get|post']
            ],
            'service/booking' => [
                'volunteer/service/booking',
                ['merge_extra_vars'=>true, 'method'=>'post']
            ],
            'service/cancelBooked' => [
                'volunteer/service/cancelBooked',
                ['merge_extra_vars'=>true, 'method'=>'post']
            ],
            'service/sign' => [
                'volunteer/service/sign',
                ['merge_extra_vars'=>true, 'method'=>'post']
            ],
            '/' => [
                'volunteer/index/index',
                ['method' => 'get']
            ]
        ],
        '[visit]' => [
            'reservation/getDays' => [
                'visit/reservation/getDays',
                ['merge_extra_vars'=>true, 'method'=>'post']
            ],
            'reservation/getTicketType' => [
                'visit/reservation/getTicketType',
                ['merge_extra_vars'=>true, 'method'=>'post']
            ],
            'reservation/getPaperType' => [
                'visit/reservation/getPaperType',
                ['merge_extra_vars'=>true, 'method'=>'post']
            ],
            'reservation/saveBookingInfo' => [
                'visit/reservation/saveBookingInfo',
                ['merge_extra_vars'=>true, 'method'=>'post']
            ],
            'reservation/saveGroupTicket' => [
                'visit/reservation/saveGroupTicket',
                ['merge_extra_vars'=>true, 'method'=>'post']
            ],
            'reservation/searchMesForInter' => [
                'visit/reservation/searchMesForInter',
                ['merge_extra_vars'=>true, 'method'=>'post']
            ],
            'reservation/searchDataForBack' => [
                'visit/reservation/searchDataForBack',
                ['merge_extra_vars'=>true, 'method'=>'post']
            ],
            'reservation/refund' => [
                'visit/reservation/refund',
                ['merge_extra_vars'=>true, 'method'=>'post']
            ],
            '/' => [
                'visit/index/index',
                ['method' => 'get']
            ]
        ],
        '[activity]' => [
            'activity/select' => [
                'activity/activity/select',
                ['merge_extra_vars'=>true, 'method'=>'get|post']
            ],
            'activity/find' => [
                'activity/activity/find',
                ['merge_extra_vars'=>true, 'method'=>'get|post']
            ],
            'activity/booking' => [
                'activity/activity/booking',
                ['merge_extra_vars'=>true, 'method'=>'get|post']
            ],
            'activity/cancelBooked' => [
                'activity/activity/cancelBooked',
                ['merge_extra_vars'=>true, 'method'=>'get|post']
            ],
            'user/getMyInfo' => [
                'activity/user/getMyInfo',
                ['merge_extra_vars'=>true, 'method'=>'get|post']
            ],
            'user/getUserList' => [
                'activity/user/getUserList',
                ['merge_extra_vars'=>true, 'method'=>'get|post']
            ],
            'user/addUser' => [
                'activity/user/addUser',
                ['merge_extra_vars'=>true, 'method'=>'get|post']
            ],
            'user/editUser' => [
                'activity/user/editUser',
                ['merge_extra_vars'=>true, 'method'=>'get|post']
            ],
            'user/delUser' => [
                'activity/user/delUser',
                ['merge_extra_vars'=>true, 'method'=>'get|post']
            ],
            'user/getMyBookeds' => [
                'activity/user/getMyBookeds',
                ['merge_extra_vars'=>true, 'method'=>'get|post']
            ],
            'user/getMyBooked' => [
                'activity/user/getMyBooked',
                ['merge_extra_vars'=>true, 'method'=>'get|post']
            ],
            '/' => [
                'activity/index/index',
                ['method' => 'get']
            ]
        ],
        '[game]' => [
            'puzzle' => [
                'game/puzzle/index',
                ['merge_extra_vars'=>true, 'method'=>'get']
            ],
            'puzzle/select' => [
                'game/puzzle/select',
                ['merge_extra_vars'=>true, 'method'=>'post']
            ],
        ],
        '[3d]' => [
            '/' => [
                'tdmodel/index/index',
                ['method' => 'get']
            ]
        ]
    ];
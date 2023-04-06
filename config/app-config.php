<?php

return [
    'post_status' => [
        'active' => \App\Helper\Status::STATUS_ACTIVE,
        'inactive' => \App\Helper\Status::STATUS_INACTIVE,
        'deleted' => \App\Helper\Status::STATUS_DELETED,
        'draft' => \App\Helper\Status::STATUS_DRAFT,
        'pending' => \App\Helper\Status::STATUS_PENDING,
        'need_modification' => \App\Helper\Status::STATUS_NEED_MODIFICATION,
        'published' => \App\Helper\Status::STATUS_PUBLISHED,
    ]
];

<?php

return [
    'target' => [
        1 => [
            'target_model' => 'App\Models\Lesson',
            'target_controller' => 'LessonsController',
        ],
        2 => [
            'target_model' => 'App\Models\Word',
            'target_controller' => 'WordsController',
        ],
        3 => [
            'target_model' => 'App\Models\User',
            'target_controller' => 'UsersController',
        ],
        4 => [
            'target_model' => 'App\Models\User',
            'target_controller' => 'UsersController',
        ],
    ],
    'target_id' => [
        'new_lesson' => 1,
        'new_word' => 2,
        'follow' => 3,
        'unfollow' => 4,
    ],
];

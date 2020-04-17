<?php

return [
	'mode'                  => 'utf-8',
	'format'                => 'A4',
	'author'                => '',
	'subject'               => '',
	'keywords'              => '',
	'creator'               => 'تیزویران',
	'display_mode'          => 'fullpage',
	'tempDir'               => base_path('../temp/'),
    'font_path'             => base_path('public/fonts/'),
    'font_data'             => [
        'vazir'             => [
            'R'             => 'Vazir.ttf',
            'useOTL'        => 0xFF,
            'useKashida'    => 75,
        ]
    ]
];

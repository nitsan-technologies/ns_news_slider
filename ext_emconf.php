<?php

$EM_CONF[$_EXTKEY] = [
    'title' => '[NITSAN] News Slider',
    'description' => 'Do you want cool sliders for most popular TYPO3 EXT:news? This extension includes nivo-slider, owlcarousel, royal-slider, slidejs, slick-slider etc. You can download PRO version for more-features & free-support at https://t3terminal.com/news-slider-pro/',
    'category' => 'plugin',
    'author' => 'T3:Bhavin Barad, QA:Siddharth Sheth',
	'author_email' => 'sanjay@nitsan.in',
	'author_company' => 'NITSAN Technologies Pvt Ltd',
    'state' => 'stable',
    'internal' => '',
    'uploadfolder' => '0',
    'createDirs' => '',
    'clearCacheOnLoad' => 0,
    'version' => '2.0.1',
    'constraints' => [
        'depends' => [
            'typo3' => '6.2.0-9.5.99',
            'news' => '3.0.0-7.9.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];

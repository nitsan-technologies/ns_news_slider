<?php

$EM_CONF['ns_news_slider'] = [
    'title' => '[NITSAN] News Slider Plugin',
    'description' => 'Do you want cool sliders for most popular TYPO3 EXT:news? This extension includes nivo-slider, owlcarousel, royal-slider, slidejs, slick-slider etc. Demo: https://demo.t3planet.com/t3t-extensions/news-slider/ You can download PRO version for more-features & free-support at https://t3planet.com/news-slider-typo3-extension',
    'category' => 'plugin',
    'author' => 'Team NITSAN',
    'author_email' => 'sanjay@nitsan.in',
    'author_company' => 'NITSAN Technologies Pvt Ltd',
    'state' => 'stable',
    'internal' => '',
    'uploadfolder' => '0',
    'createDirs' => '',
    'version' => '12.0.0',
    'constraints' => [
        'depends' => [
            'typo3' => '12.0.0-12.9.99',
            'news' => '3.0.0-9.9.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];

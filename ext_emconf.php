<?php

$EM_CONF[$_EXTKEY] = [
    'title' => '[NITSAN] News Slider Plugin',
    'description' => 'Do you want cool sliders for most popular TYPO3 EXT:news? This extension includes nivo-slider, owlcarousel, royal-slider, slidejs, slick-slider etc. Demo: https://demo.t3terminal.com/t3t-extensions/news-slider/ You can download PRO version for more-features & free-support at https://t3terminal.com/typo3-news-slider-extension-pro',
    'category' => 'plugin',
    'author' => 'T3: Milan Rathod, QA: Siddhart Sheth',
	'author_email' => 'sanjay@nitsan.in',
	'author_company' => 'NITSAN Technologies Pvt Ltd',
    'state' => 'stable',
    'internal' => '',
    'uploadfolder' => '0',
    'createDirs' => '',
    'clearCacheOnLoad' => 0,
    'version' => '3.0.0',
    'constraints' => [
        'depends' => [
            'typo3' => '6.2.0-9.5.99',
            'news' => '3.0.0-7.9.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];

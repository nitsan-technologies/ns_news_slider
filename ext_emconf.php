<?php

$EM_CONF['ns_news_slider'] = [
    'title' => 'TYPO3 News Slider',
    'description' => 'Easily showcase news items in an interactive and visually appealing slider. This extension supports multiple jQuery sliders including OwlCarousel, RoyalSlider, SlideJS, and Slick Slider—making it simple to integrate a modern news carousel into your TYPO3 website.',

    'category' => 'plugin',
    'author' => 'Team T3Planet',
    'author_email' => 'info@t3planet.de',
    'author_company' => 'T3Planet',
    'state' => 'stable',
    'internal' => '',
    'uploadfolder' => '0',
    'createDirs' => '',
    'version' => '13.0.0',
    'constraints' => [
        'depends' => [
            'typo3' => '12.0.0-13.9.99',
            'news' => '12.0.0-12.9.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];

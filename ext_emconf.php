<?php

$EM_CONF['ns_news_slider'] = [
    'title' => 'News Slider Plugin',
    'description' => 'The TYPO3 News Slider extension lets you create an attractive news slider for your website. It offers several popular JQuery slider plugins like Owlcarousel Slider, Royal Slider, Slidejs Slider, and Slick Slider. It\'s an easy and convenient way to add a news slider to your site!
    
    *** Live Demo: https://demo.t3planet.com/t3-extensions/news-slider *** Premium Version, Documentation & Free Support: https://t3planet.com/typo3-news-slider-extension',
    'category' => 'plugin',
    'author' => 'T3: Himanshu Ramavat, QA: Krishna Dhapa',
    'author_email' => 'sanjay@nitsan.in',
    'author_company' => 'T3Planet // NITSAN',
    'state' => 'stable',
    'internal' => '',
    'uploadfolder' => '0',
    'createDirs' => '',
    'clearCacheOnLoad' => 0,
    'version' => '4.1.2',
    'constraints' => [
        'depends' => [
            'typo3' => '6.2.0-11.5.99',
            'news' => '3.0.0-10.0.3',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];

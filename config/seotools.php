<?php

/**
 * @see https://github.com/artesaos/seotools
 */

$title = "UPT SIT Bhamada";
$description = "Unit Pelaksanaan Teknis Sistem Informasi dan Teknologi | Universitas Bhamada Slawi";

return [
    'meta' => [
        /*
         * The default configurations to be used by the meta generator.
         */
        'defaults'       => [
            'title'        => $title, // set false to total remove
            'titleBefore'  => false, // Put defaults.title before page title, like 'It's Over 9000! - Dashboard'
            'description'  => $description, // set false to total remove
            'separator'    => ' | ',
            'keywords'     => [
                'Unit Pelaksanaan Teknis',
                'UPT',
                'Sistem Informasi dan Teknologi',
                'SIT',
                'Universitas Bhamada Slawi',
                'Universitas Bhamada',
                'Bhamada Slawi',
                'Bhamada',
                'Unit Pelaksanaan Teknis Universitas Bhamada Slawi',
                'Unit Pelaksanaan Teknis Bhamada Slawi',
                'Unit Pelaksanaan Teknis Bhamada',
                'Unit Bhamada Slawi',
                'UPT Bhamada Slawi',
                'Unit Bhamada',
                'Unit Pelaksanaan Teknis Sistem Informasi dan Teknologi',
                'Unit Sistem Informasi dan Teknologi',
                'Unit SIT',
                'UPT SIT'
            ],
            'canonical'    => null, // Set to null or 'full' to use Url::full(), set to 'current' to use Url::current(), set false to total remove
            'robots'       => false, // Set to 'all', 'none' or any combination of index/noindex and follow/nofollow
        ],
        /*
         * Webmaster tags are always added.
         */
        'webmaster_tags' => [
            'google'    => null,
            'bing'      => null,
            'alexa'     => null,
            'pinterest' => null,
            'yandex'    => null,
            'norton'    => null,
        ],

        'add_notranslate_class' => false,
    ],
    'opengraph' => [
        /*
         * The default configurations to be used by the opengraph generator.
         */
        'defaults' => [
            'title'       => $title, // set false to total remove
            'description' => $description, // set false to total remove
            'url'         => null, // Set null for using Url::current(), set false to total remove
            'type'        => 'website',
            'site_name'   => 'UPT SIT Bhamada',
            'images'      => ['http://localhost/website/public/megakit/theme/images/bg/logo-bhamada.png'],
        ],
    ],
    'twitter' => [
        /*
         * The default values to be used by the twitter cards generator.
         */
        'defaults' => [
            //'card'        => 'summary',
            //'site'        => '@LuizVinicius73',
        ],
    ],
    'json-ld' => [
        /*
         * The default configurations to be used by the json-ld generator.
         */
        'defaults' => [
            'title'       => $title, // set false to total remove
            'description' => $description, // set false to total remove
            'url'         => null, // Set to null or 'full' to use Url::full(), set to 'current' to use Url::current(), set false to total remove
            'type'        => 'WebPage',
            'images'      => ['http://localhost/website/public/megakit/theme/images/bg/logo-bhamada.png'],
        ],
    ],
];

<?php

/**
 * ZF2 Plugin Config file
 *
 * This file contains all the configuration for the Module as defined by ZF2.
 * See the docs for ZF2 for more information.
 *
 * PHP version 5.3
 *
 * LICENSE: No License yet
 *
 * @category  Reliv
 * @author    Westin Shafer <wshafer@relivinc.com>
 * @copyright 2012 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: <git_id>
 */

return array(

    'rcmPlugin' => array(
        'RcmRssFeed' => array(
            'type' => 'Social Media',
            'display' => 'Rss Feed Reader',
            'tooltip' => 'Rss Reader and Display',
            'icon' => '',
            'editJs' => '/modules/rcm-rss-feed/edit.js',
            'defaultInstanceConfig' => include
                    __DIR__ . '/defaultInstanceConfig.php',
            'cacheable' => true,
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    'router' => array(
        'routes' => array(
            'rcm-rss-proxy' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route' => '/rcm-rss-proxy',
                    'defaults' => array(
                        'controller' => 'rcmRssFeedProxyController',
                        'action' => 'rssProxy',
                    ),
                ),
            ),
        ),
    ),
    'asset_manager' => array(
        'resolver_configs' => array(
            'aliases' => array(
                'modules/rcm-rss-feed/' => __DIR__ . '/../public/',
            ),
            'collections' => array(
                'modules/rcm-admin/js/rcm-admin.js' => array(
                    'modules/rcm-rss-feed/edit.js',
                ),
            ),
        ),
    ),
);
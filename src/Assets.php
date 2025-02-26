<?php

# -*- coding: utf-8 -*-

declare(strict_types=1);

namespace MultisiteGlobalMedia;

/**
 * Class Assets
 */
class Assets
{
    /**
     * @var PluginProperties
     */
    private $pluginProperties;

    /**
     * Assets constructor
     *
     * @param PluginProperties $pluginProperties
     */
    public function __construct(PluginProperties $pluginProperties)
    {
        $this->pluginProperties = $pluginProperties;

        add_filter('multisite_global_media_should_enqueue_assets', [$this, 'shouldEnqueueAssets'], 10, 2);
    }

    /**
     * Set default screens where we enqueue assets for media modal
     *
     * @param  bool      $enqueue
     * @param  WP_Screen $screen
     * @return bool
     */
    public function shouldEnqueueAssets($enqueue, $screen)
    {
        if ($screen->base === 'post') {
            $enqueue = true;
        }

        return $enqueue;
    }

    /**
     * Enqueue script for media modal
     *
     * @since  2015-01-26
     */
    public function enqueueScripts()
    {
        if (!apply_filters('multisite_global_media_should_enqueue_assets', false, get_current_screen())) {
            return;
        }

        $scriptFile = '/assets/js/global-media.js';
        wp_register_script(
            'global_media',
            $this->pluginProperties->dirUrl() . $scriptFile,
            ['media-views'],
            filemtime($this->pluginProperties->dirPath() . $scriptFile),
            true
        );
        wp_enqueue_script('global_media');
    }

    /**
     * Enqueue script for media modal
     *
     * @since   2015-02-27
     */
    public function enqueueStyles()
    {
        if (!apply_filters('multisite_global_media_enqueue_assets', false, get_current_screen())) {
            return;
        }

        $styleFile = '/assets/css/global-media.css';
        wp_register_style(
            'global_media',
            $this->pluginProperties->dirUrl() . $styleFile,
            [],
            filemtime($this->pluginProperties->dirPath() . $styleFile)
        );
        wp_enqueue_style('global_media');
    }
}

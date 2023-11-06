<?php

namespace G28\WoocommerceMemberkit;

class Plugin
{
    private static ?Plugin $_instance = null;
    private string $root;
    private array $metadata;

    private function __construct()
    {

    }

    public static function getInstance(): ?Plugin
    {
        if(is_null(self::$_instance))
        {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function start(string $root): void
    {
        $this->root = $root;
        $this->metadata = get_file_data($this->root, [
            'name' => 'Plugin Name',
            'version' => 'Version',
        ]);
    }

    public function getVersion()
    {
        return $this->metadata['version'];
    }

    /**
     * @return string
     */
    public function getUrl(): string {
        return plugin_dir_url($this->root);
    }

    /**
     * @return string
     */
    public function getPluginBase(): string {
        return plugin_basename($this->root);
    }

    /**
     * @return string
     */
    public function getTemplateDir(): string {
        return plugin_dir_path($this->root) . 'templates/';
    }

    /**
     * @return string
     */
    public function getLogDir(): string {
        return plugin_dir_path($this->root) . 'logs/';
    }

    /**
     * @return string
     */
    public function getSlug(): string {
        return trim( dirname( $this->getPluginBase() ), '/' );
    }

    /**
     * @return string
     */
    public function getTextDomain(): string {
        return $this->getSlug();
    }

    /**
     * @return string
     */
    public function getAssetsPrefix(): string {
        return 'woo_memberkit';
    }

    /**
     * @return string
     */
    public function getAssetsUrl(): string {
        return $this->getUrl() . 'assets/';
    }
}
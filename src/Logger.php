<?php

namespace G28\WoocommerceMemberkit;

class Logger
{
    private static ?Logger $_instance = null;
    private string $logFile;
    const LOG_DIR = MEMBERKIT_PLUGIN_PATH . "logs/";

    public function __construct()
    {
        $this->logFile = "log_" . date("Ymd") . ".txt";
        if(!file_exists(self::LOG_DIR . $this->logFile)) {
            file_put_contents(self::LOG_DIR . $this->logFile, "");
        }
    }

    public static function getInstance(): ?Logger {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function add( string $message ) {
        date_default_timezone_set('America/Sao_Paulo');
        $timestamp    = date('d/m/Y h:i:s A');
        $actualOutput = file_get_contents( self::LOG_DIR . $this->logFile );
        $output = "[ $timestamp ] $message" . PHP_EOL . $actualOutput;
        file_put_contents( self::LOG_DIR . $this->logFile, $output);
    }

    public function clear(  ) {
        file_put_contents( self::LOG_DIR . $this->logFile, "");
    }

    public function getLogContent(): string
    {
        $filepath = self::LOG_DIR . $this->logFile;
        return nl2br(file_get_contents( $filepath ));
    }
}
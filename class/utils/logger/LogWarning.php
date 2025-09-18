<?php
require_once "ILogger.php";
class LogWarning implements ILogger {
    private bool $_enabled = true;
    private string $_message = "";
    private string $_category = "WARNING";

    public function __construct(string $message = "", string $category = "WARNING", bool $enabled = true) {
        $this->_message = $message;
        $this->_category = $category;
        $this->_enabled = $enabled;
    }

    public function log(): string {
        // Implementation of log method
        return "[LogWarning] $this->_message | $this->_category";
    }
    public function enable(): void {
        $this->_enabled = true;
    }
    public function disable(): void {
        $this->_enabled = false;
    }
    public function isEnabled(): bool {
        return $this->_enabled;
    }
    public function printLog(): void {
        echo $this->log();
    }
}
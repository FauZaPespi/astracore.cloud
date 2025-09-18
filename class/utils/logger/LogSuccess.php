<?php
require_once "ILogger.php";
require_once  __DIR__ . "/../popUp/PopUpSuccess.php";
class LogSuccess implements ILogger
{
    private bool $_enabled = true;
    private string $_message = "";
    private string $_category = "SUCCESS";
    private bool $_showPopUp = false;

    public function __construct(string $message = "", bool $showPopUp = false, string $category = "SUCCESS", bool $enabled = true)
    {
        $this->_message = $message;
        $this->_category = $category;
        $this->_enabled = $enabled;
        $this->_showPopUp = $showPopUp;
        $this->saveLog();
        $this->printPopUp();
    }

    public function log(): string
    {
        // Implementation of log method
        return "[LogSuccess] $this->_message | $this->_category";
    }
    public function enable(): void
    {
        $this->_enabled = true;
    }
    public function disable(): void
    {
        $this->_enabled = false;
    }
    public function isEnabled(): bool
    {
        return $this->_enabled;
    }
    public function printLog(): void
    {
        echo $this->log();
    }
    public function printPopUp(): void
    {
        if ($this->_showPopUp) {
            $err = new PopUpSuccess("Error occurred", "$this->_message", "/home/fauza/web/astracore/pages/home.php", 123);
            $err->print();
        }
    }
    private function saveLog()
    {
        file_put_contents(__DIR__ . '/data/success.log', $this->log() . PHP_EOL, FILE_APPEND);
    }
}

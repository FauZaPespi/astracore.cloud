<?php
require_once "ILogger.php";
require_once  __DIR__ . "/../popUp/PopUpError.php";
class LogError implements ILogger
{
    private bool $_enabled = true;
    private string $_message = "";
    private string $_category = "ERROR";
    private bool $_showPopUp = true;
    private string $_lineBroken = "";
    private string $_fileBroken = "";

    public function __construct(string $message = "", bool $showPopUp = true, string $category = "ERROR", bool $enabled = true)
    {
        $this->_message = $message;
        $this->_category = $category;
        $this->_enabled = $enabled;
        $this->_showPopUp = $showPopUp;
        $this->_lineBroken = debug_backtrace()[0]['line'];
        $this->_fileBroken = debug_backtrace()[0]['file'];
        $this->printPopUp();
    }

    public function log(): string
    {
        // Implementation of log method
        return "[LogError] $this->_message | $this->_category";
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
            $err = new PopUpError("Error occurred", "$this->_message", $this->_fileBroken, $this->_lineBroken);
            $err->print();
        }
    }
}

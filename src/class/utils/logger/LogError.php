<?php
require_once "ILogger.php";
require_once __DIR__ . "/../popUp/PopUpError.php";

class LogError implements ILogger
{
    private bool $_enabled = true;
    private string $_message = "";
    private string $_category = "ERROR";
    private bool $_showPopUp = true;
    private string $_fileBroken = "";
    private string $_lineBroken = "";
    private string $_code = "";

    /**
     * @param string $message   Error message
     * @param string|null $file File where the error occurred (optional, auto-detected if null)
     * @param string|int|null $line Line where the error occurred (optional, auto-detected if null)
     * @param string|int $code Error code or severity
     * @param bool $showPopUp Whether to show popup UI
     * @param string $category Category ("ERROR", "WARNING", etc.)
     * @param bool $enabled Enable or disable logging
     */
    public function __construct(
        string $message = "",
        ?string $file = null,
        ?int $line = null,
        $code = "",
        bool $showPopUp = true,
        string $category = "ERROR",
        bool $enabled = true
    ) {
        $this->_message = $message;
        $this->_category = $category;
        $this->_enabled = $enabled;
        $this->_showPopUp = $showPopUp;
        $this->_code = (string)$code;

        // If file/line are provided, use them, otherwise fallback to debug_backtrace
        if ($file !== null && $line !== null) {
            $this->_fileBroken = $file;
            $this->_lineBroken = (string)$line;
        } else {
            $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 1)[0] ?? null;
            $this->_fileBroken = $trace['file'] ?? 'unknown';
            $this->_lineBroken = (string)($trace['line'] ?? 0);
        }

        $this->saveLog();
        $this->printPopUp();
    }

    public function log(): string
    {
        return "[{$this->_category}] {$this->_message} "
             . "| File: {$this->_fileBroken} "
             . "| Line: {$this->_lineBroken} "
             . "| Code: {$this->_code}";
    }

    public function enable(): void { $this->_enabled = true; }
    public function disable(): void { $this->_enabled = false; }
    public function isEnabled(): bool { return $this->_enabled; }

    public function printLog(): void
    {
        if ($this->_enabled) {
            echo $this->log();
        }
    }

    public function printPopUp(): void
    {
        if ($this->_enabled && $this->_showPopUp) {
            $err = new PopUpError(
                "Error occurred",
                $this->_message,
                $this->_fileBroken,
                $this->_lineBroken,
                $this->_code
            );
            $err->print();
        }
    }

    private function saveLog(): void
    {
        if (!$this->_enabled) return;

        $dir = __DIR__ . '/data';
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        file_put_contents($dir . '/error.log', $this->log() . PHP_EOL, FILE_APPEND);
    }
}

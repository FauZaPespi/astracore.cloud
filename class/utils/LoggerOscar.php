<?php
class log_Oscar
{
    private DateTime $_date;
    private string $_msg;
    private bool $_isEnabled;
    private string $_filePath = __DIR__ . '/../../logs/astracore.log';

    // Getter / Setter pour date
    public function getDate(): DateTime {
        return $this->_date;
    }

    public function setDate(DateTime $date): void {
        $this->_date = $date;
    }

    // Getter / Setter pour msg
    public function getMsg(): string {
        return $this->_msg;
    }

    public function setMsg(string $msg): void {
        $this->_msg = $msg;
    }

    // Getter / Setter pour isEnabled
    public function getIsEnabled(): bool {
        return $this->_isEnabled;
    }

    public function setIsEnabled(bool $isEnabled): void {
        $this->_isEnabled = $isEnabled;
    }

    // Constructeur
    public function __construct(string $msg)
    {
        $this->_isEnabled = true; // activé par défaut
        $this->_date = new DateTime();
        $this->_msg = $msg;
    }

    // __toString
    public function __toString(): string
    {
        if ($this->_isEnabled) {
            return "[ Logger_Oscar - " . $this->_date->format('Y-m-d H:i:s') . " ] " . $this->_msg . "\n";
        }
        return "Currently disabled.";
    }

    public function log(): int
    {
        if ($this->_isEnabled) {
            file_put_contents($this->filePath, $this->__toString(), FILE_APPEND);
            return 1;
        }
        return 0;
    }
}

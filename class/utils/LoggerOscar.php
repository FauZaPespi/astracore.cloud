<?php
class log_Oscar
{
    private DateTime $_date;
    private string $_msg;
    private string $_category;
    private bool $_isEnabled;
    private string $filePath = __DIR__ . '/logs/astracore.log';

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

    // Getter / Setter pour category
    public function getCategory(): string {
        return $this->_category;
    }

    public function setCategory(string $category): void {
        $this->_category = $category;
    }

    // Getter / Setter pour isEnabled
    public function getIsEnabled(): bool {
        return $this->_isEnabled;
    }

    public function setIsEnabled(bool $isEnabled): void {
        $this->_isEnabled = $isEnabled;
    }

    // Constructeur
    public function __construct(string $msg, string $category = 'GENERAL')
    {
        $this->_isEnabled = true; // activé par défaut
        $this->_date = new DateTime();
        $this->_msg = $msg;
        $this->_category = $category;

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    // Récupérer l'URL actuelle
    private function getCurrentUrl(): string
    {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'] ?? 'cli';
        $uri = $_SERVER['REQUEST_URI'] ?? '';
        return "$protocol://$host$uri";
    }

    // __toString
    public function __toString(): string
    {
        if ($this->_isEnabled) {
            $sessionId = session_id() ?: 'no-session';
            return sprintf(
                "[ Logger_Oscar - %s | Category: %s | URL: %s | SessionID: %s ] %s\n",
                $this->_date->format('Y-m-d H:i:s'),
                $this->_category,
                $this->getCurrentUrl(),
                $sessionId,
                $this->_msg
            );
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

    public static function Tlog($message, $cat)
    {
        $logger = new log_Oscar($message, $cat);
        $logger->setIsEnabled(true);
        return $logger->log();
    }
}

<?php

class LogMaksym {
    private DateTime $_date;
    private string $_message;
    private bool $_isEnabled;

    public DateTime $date {
        get {
            return $this->_date;
        }
        
        set {
            $this->_date = $value;
        }
    }

    public string $message {
        get {
            return $this->_message;
        } 
        
        set {
            $this->_message = $value;
        }
    }

    public bool $isEnabled {
        get {
            return $this->_isEnabled;
        } 
        
        set {
            $this->_isEnabled = $value;
        }
    }

    public function __construct(string $message, bool $isEnabled)
    {
        $this->_date = new DateTime();
        $this->_message = $message;
        $this->_isEnabled = $isEnabled;
    }

    public function __toString(): string
    {
        return "Date : {$this->_date} Message : {$this->_message}";
    }
}

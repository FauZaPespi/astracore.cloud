<?php
require_once "PopUp.php";

class PopUpError extends PopUp
{
    private string $_file;
    private string $_line;
    private string $_code = "";

    public function __construct(string $title, string $message, string $file, string $line, string $code = "")
    {
        parent::__construct($title, $message);
        $this->_file = $file;
        $this->_line = $line;
        $this->_code = $code;
    }

    public function print(): void
    {
        ?>
        <div class="error-overlay" id="error-overlay">
            <div class="error-card">
                <div class="error-header">
                    <span class="error-title">
                        <i class="bi bi-bug-fill me-2"></i>
                        <?= htmlspecialchars($this->_title); ?>
                    </span>
                    <button class="btn-close btn-close-white" onclick="document.getElementById('error-overlay').remove();"></button>
                </div>
                <div class="error-body">
                    <div class="error-message"><?= (htmlspecialchars($this->_message)); ?></div>
                    <div class="error-meta">
                        <div><strong>File:</strong> <?= htmlspecialchars($this->_file); ?></div>
                        <div><strong>Line:</strong> <?= htmlspecialchars($this->_line); ?></div>
                        <?php if ($this->_code !== ""): ?>
                            <div><strong>Code:</strong> <?= htmlspecialchars($this->_code); ?></div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}
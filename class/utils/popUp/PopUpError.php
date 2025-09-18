<?php
require_once "PopUp.php";

class PopUpError extends PopUp
{
    private string $_file;
    private string $_line;

    public function __construct(string $title, string $message, string $file, string $line)
    {
        parent::__construct($title, $message);
        $this->_file = $file;
        $this->_line = $line;
    }

    public function print(): void
    {
        ?>
        <div class="error-overlay" id="error-overlay">
            <div class="error-card">
                <div class="error-header">
                    <span class="error-title">
                        <i class="bi bi-bug-fill me-2"></i>
                        <?php echo htmlspecialchars($this->_title); ?>
                    </span>
                    <button class="btn-close btn-close-white" onclick="document.getElementById('error-overlay').remove();"></button>
                </div>
                <div class="error-body">
                    <div class="error-message"><?php echo (htmlspecialchars($this->_message)); ?></div>
                    <div class="error-meta">
                        <div><strong>File:</strong> <?php echo htmlspecialchars($this->_file); ?></div>
                        <div><strong>Line:</strong> <?php echo htmlspecialchars($this->_line); ?></div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}

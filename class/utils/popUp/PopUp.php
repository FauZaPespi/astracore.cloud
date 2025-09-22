<?php

abstract class PopUp
{
    protected string $_title;
    protected string $_message;

    public function __construct(string $title, string $message)
    {
        $this->_title = $title;
        $this->_message = $message;
    }

    public function print(): void
    {
        ?>
        <div class="popup-overlay" id="popup-overlay">
            <div class="popup">
                <div class="popup-header">
                    <h2 class="popup-title"><?= htmlspecialchars($this->_title); ?></h2>
                    <button class="popup-close" onclick="document.getElementById('popup-overlay').remove();">&times;</button>
                </div>
                <div class="popup-body">
                    <p><?= nl2br(htmlspecialchars($this->_message)); ?></p>
                </div>
            </div>
        </div>
        <?php
    }
}
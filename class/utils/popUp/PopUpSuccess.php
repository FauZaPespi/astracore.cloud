<?php
require_once "PopUp.php";

class PopUpSuccess extends PopUp
{
    public function print(): void
    {
        ?>
        <div class="popup-overlay" id="popup-overlay">
            <div class="popup popup-success">
                <div class="popup-header popup-success-header">
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

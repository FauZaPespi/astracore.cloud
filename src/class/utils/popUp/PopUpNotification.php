<?php

class PopUpNotification extends PopUp
{
    protected string $_title;
    protected string $_message;

    public function __construct(string $title, string $message)
    {
        $this->_title = $title;
        $this->_message = $message;
        $this->print();
    }

    public function print(): void
    {
?>
        <div class="popup-overlay overlay-alt" id="popup-overlay">
            <div class="popup-alt">
                <div class="popup-alt-header">
                    <p class="popup-alt-header"><i class="bi bi-bell"></i><span class="invisible">........</span><?= nl2br(htmlspecialchars($this->_message)); ?></p>
                    <button class="popup-alt-close" onclick="removePopupParam()">&times;</button>
                </div>
            </div>
        </div>
        <script>
            function removePopupParam() {
                document.getElementById('popup-overlay').remove();
                const url = new URL(window.location.href);
                if (window.location.search.includes('popup=')) {
                    url.searchParams.delete('popup');
                    window.history.replaceState({}, document.title, url.toString());
                    window.location.href = url.toString();
                }
            }
        </script>
<?php
    }
}

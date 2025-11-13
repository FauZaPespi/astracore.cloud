<?php
interface ILogger
{
    public function log(): string;
    public function enable(): void;
    public function disable(): void;
    public function isEnabled(): bool;
    public function printLog(): void;
}
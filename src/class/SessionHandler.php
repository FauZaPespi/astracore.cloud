<?php
/**
 * Project: Session Handler
 * Description: Basic session handler tool. It is strongly recommended to use this script if you work with sessions.
 * @author: Mellowize Back-End Services
 * @date: 07.10.2024
 * @version: 1.0
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Save one data in the actual session.
 * 
 * @param string $dataName The name of the data.
 * @param mixed $dataContent The content of the data.
 */
function SaveInSession(string $dataName, $dataContent) : void
{
    $_SESSION[$dataName] = $dataContent;
}

/**
 * Delete one or more datas from the actual session.
 * 
 * @param string ...$dataNames The name(s) of the data(s) to remove.
 */
function DeleteFromSession(string ...$dataNames) : void
{
    foreach ($dataNames as $dataName) {
        unset($_SESSION[$dataName]);
    }
}

/**
 * Get one data in the actual session.
 * 
 * @param mixed $dataName The name of the data to get.
 * 
 * @return mixed The value of the data which was in parameter.
 */
function GetDataFromSession($dataName) : mixed
{
    if (array_key_exists($dataName, $_SESSION)) {
        return json_encode([$dataName => $_SESSION[$dataName]], JSON_PRETTY_PRINT);
    } else {
        return json_encode([$dataName => "Data not found"], JSON_PRETTY_PRINT);
    }
}

/**
 * Get all the datas in the actual session.
 * 
 * @return array The array that contains all of the datas in the session.
 */
function GetAllSessionData(): array
{
    $datas = [];
    foreach ($_SESSION as $dataName => $dataValue) {
        $datas[$dataName] = $dataValue;
    }
    return $datas;
}
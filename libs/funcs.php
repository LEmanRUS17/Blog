<?php 

// Функция для проверки получения данных
function debug($data, $die = false) {
    echo "<pre>" . print_r($data, 1) . "</pre>";
    if ($die) {
        die;
    }
}
?>
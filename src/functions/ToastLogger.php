<?php

function makeToast($data)
{
    // Store each toast in a session array
    $_SESSION['_toasts'][] = $data;
}

function outputToasts()
{
    // Check if there are any toasts in the session
    if (!empty($_SESSION['_toasts'])) {
        // Convert the array of toasts to JSON format for JavaScript
        $toastData = json_encode($_SESSION['_toasts']);

        // Output a single <script> tag with all the toasts
        echo <<<HTML
        <script>
            const toastData = $toastData;
            toastData.forEach(({type, message, delay}) => {
                showToast(type, message, delay);
            });
        </script>
        HTML;

        // Clear toasts from the session after outputting them
        unset($_SESSION['_toasts']);
    }
}
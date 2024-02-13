<?php

function myExceptionHandler($e) {
    error_log("{$e->getMessage()} in {$e->getFile()} on line {$e->getLine()}");
    http_response_code(500);
    if (filter_var(ini_get('display_errors'), FILTER_VALIDATE_BOOLEAN)) {
        echo $e;
    } else {
        echo "<h1>500 Internal Server Error</h1>
An internal server error has been occurred.<br>
Please try again later.";
    }
    exit;
}

set_exception_handler('myExceptionHandler');

set_error_handler(function ($level, $message, $file = '', $line = 0) {
    if (!(error_reporting() & $level)) {
// If the error level is not included in error_reporting, don't handle it
        return;
    }
    if ($level & (E_USER_NOTICE | E_WARNING | E_STRICT | E_DEPRECATED)) {
// Handle non-fatal errors (log them or take other actions)
// For example, log the error:
        error_log("Non-fatal error: [$level] $message in $file on line $line\n");
        return false; // Return false to continue script execution
    } else {
// Convert other errors to ErrorException and throw them
        throw new ErrorException($message, 0, $level, $file, $line);
    }
}, E_ALL);

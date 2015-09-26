<?php

$tests = [
    ['test', uniqid(true), 2 + rand(0, 100) / 100],
    ['Numbers special chars: 1234567890 !@#$%^%&*()_+', uniqid(true), 2 + rand(0, 100) / 100],
    ['Latin alphabet (upper): ABCDEFGHIJKLMNOPQRSTUVWXYZ', uniqid(true), 2 + rand(0, 100) / 100],
    ['Latin alphabet (lower): abcdefghijklmnopqrstuvwxyz', uniqid(true), 2 + rand(0, 100) / 100],
    ['Cyrillic alphabet (lower): абвгдежзийклмнопрстуфхцчшщюя', uniqid(true), 4 + rand(0, 100) / 100],
    ['Cyrillic alphabet (upper): АБВГДЕЖЗИЙКЛМНОПРСТУФХЦЧШЩЮЯ', uniqid(true), 5 + rand(0, 100) / 100],
    ['Greek alphabet (lower): αβγδϵζηθικλμνξοπρστυϕχψω', uniqid(), 2 + rand(0, 100) / 100],
    ['Greek alphabet (upper): ΑΒΓΔΕΖΗΘΙΚΛΜΝΞΟΠΡΣΤΥΦΧΨΩ', uniqid(), 2 + rand(0, 100) / 100],
    ['Greek alphabet (upper): ΑΒΓΔΕΖΗΘΙΚΛΜΝΞΟΠΡΣΤΥΦΧΨΩ', "", 2 + rand(0, 100) / 100],
];

foreach ($tests as $test) {
    $pass = $test[0];
    $salt = $test[1];
    $time = $test[2];

    echo 'START: Hashing string "' . $pass . '" salt "' . $salt . '" required seconds "' . $time . '"' . "\n";
    $time_start = microtime(true);

    $hash = SlowHash::hash($pass, $salt, $time);
    echo 'Result ' . strlen($hash) . ' chars: ' . $hash . "\n";
    $time_end = microtime(true);
    echo "Hashed in " . ($time_end - $time_start) . "s\n";


    if (SlowHash::equals($pass, $hash)) {
        echo $pass . ' EQUALS TO ' . $hash . "\n";
    } else {
        echo $pass . ' IS NOT EQUAL TO ' . $hash . "\n";
    }
    echo 'END: Hashing completed for ' . $pass . '-' . $hash . '-' . $time . "\n\n";
}

foreach ($tests as $test) {
    $pass = $test[0];

    echo 'START: Hashing string "' . $pass . " with defaults\n";
    $time_start = microtime(true);

    $hash = SlowHash::hash($pass);
    echo 'Result ' . strlen($hash) . ' chars: ' . $hash . "\n";
    $time_end = microtime(true);
    echo "Hashed in " . ($time_end - $time_start) . "s\n";


    if (SlowHash::equals($pass, $hash)) {
        echo $pass . ' EQUALS TO ' . $hash . "\n";
    } else {
        echo $pass . ' IS NOT EQUAL TO ' . $hash . "\n";
    }
    echo 'END: Hashing completed for ' . $pass . "\n\n";
}

?>

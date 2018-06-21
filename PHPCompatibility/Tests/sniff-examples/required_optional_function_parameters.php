<?php

// These are ok.
preg_match_all('`[a-z]+`', $subject, $matches);
stream_socket_enable_crypto($fp, true, STREAM_CRYPTO_METHOD_SSLv23_CLIENT);

// These are not.
preg_match_all('`[a-z]+`', $subject);
stream_socket_enable_crypto($fp, true);

bcscale( 10 ); // OK.
bcscale(); // PHP 7.3+.

$ip = getenv('REMOTE_ADDR'); // OK.
$ip = getenv(); // PHP 7.1+

array_push($stack, "apple", "raspberry"); // OK.
array_push(...$stack); // PHP 7.3+

array_unshift($queue, "apple", "raspberry"); // OK.
array_unshift(...$queue); // PHP 7.3+

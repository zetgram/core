<?php

function startWith(string $haystack, string $needle) :bool {
    return strpos($haystack, $needle) === 0;
}

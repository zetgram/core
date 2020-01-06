<?php

namespace Zetgram\Filters;

use Zetgram\Types\Update;

class RegExpCallbackDataFilter implements FilterInterface
{
    public function check(Update $update, ...$params): bool
    {
        return $this->privateCheck($update, ...$params);
    }

    private function privateCheck(Update $update, string $pattern, int $flags = 0) :bool
    {
        if(!isset($update->callbackQuery->data))
            return false;

        $pattern = str_replace('#', '\\#', $pattern);
        $pattern = '#' . $pattern . '#';

        return preg_match($pattern, $update->callbackQuery->data, $matches, $flags);
    }
}

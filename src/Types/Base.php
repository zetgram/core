<?php

namespace Zetgram\Types;

use stdClass;

class Base
{
    public function __construct(stdClass $data)
    {
        $this->build($data);
    }
    protected function build(stdClass $data)
    {
    }
}

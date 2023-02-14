<?php

namespace Streply\StreplyMagento\Plugin;

use Streply\StreplyMagento\Helper\Data as StreplyHelper;
use function Streply\Exception as StreplyException;

class AbstractExceptionCatcher
{
    /**
     * @var StreplyHelper;
     */
    protected StreplyHelper $streplyHelper;

    /**
     * @param StreplyHelper $streplyHelper
     */
    public function __construct(StreplyHelper $streplyHelper)
    {
        $this->streplyHelper = $streplyHelper;
    }

    /**
     * @param \Throwable $e
     * @return void
     */
    protected function throwStreplyException(\Throwable $e):void
    {
        try {
            StreplyException($e);
        } catch (\Throwable $bigProblem) {
            // do nothing if streply fails
        }
    }
}

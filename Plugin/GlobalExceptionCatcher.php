<?php

namespace Streply\StreplyMagento\Plugin;

use Magento\Framework\AppInterface;

class GlobalExceptionCatcher extends AbstractExceptionCatcher
{
    /**
     * @param AppInterface $subject
     * @param callable $proceed
     * @return mixed
     * @throws \Throwable
     */
    public function aroundLaunch(AppInterface $subject, callable $proceed)
    {
        if (!$this->streplyHelper->isModuleOutputEnabled() && !$this->streplyHelper->isActive()) {
            return $proceed();
        }
        $this->streplyHelper->initializeStreply();

        try {
            return $proceed();
        } catch (\Throwable $e) {
            $this->throwStreplyException($e);
            $this->streplyHelper->flushStreplyClient();

            throw $e;
        }

    }

}

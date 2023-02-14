<?php

namespace Streply\StreplyMagento\Plugin;

use Magento\Framework\Console\Cli;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CliExceptionCatcher extends AbstractExceptionCatcher
{
    /**
     * @param Cli $subject
     * @param callable $proceed
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return mixed
     * @throws \Throwable
     */
    public function aroundDoRun(Cli $subject, callable $proceed, InputInterface $input, OutputInterface $output)
    {
        if (!$this->streplyHelper->isModuleOutputEnabled() && !$this->streplyHelper->isActive()) {
            return $proceed();
        }
        $this->streplyHelper->initializeStreply();

        try {
            return $proceed();
        } catch (\Throwable $e) {
            $this->throwStreplyException($e);

            throw $e;
        }
    }
}

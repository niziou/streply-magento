<?php

namespace Streply\StreplyMagento\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\App\Helper\Context;
use Streply\Exceptions\InvalidDsnException;

class Data extends AbstractHelper
{
    const XML_PATH_ACTIVE = 'streply/general/active';
    const XML_PATH_API_KEY = 'streply/general/dsnurl';
    const INITIALIZE_URL = 'https://xxx@api.streply.com/48';

    /**
     * @var StoreManagerInterface
     */
    protected StoreManagerInterface $storeManager;

    /**
     * Data constructor.
     *
     * @param Context               $context
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        Context $context,
        StoreManagerInterface $storeManager,
    ) {
        $this->storeManager = $storeManager;
        $this->scopeConfig = $context->getScopeConfig();

        parent::__construct($context);
    }


    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return (bool)$this->getConfigValue(self::XML_PATH_ACTIVE);
    }

    /**
     * @param      $field
     * @param null $storeId
     *
     * @return mixed
     */
    public function getConfigValue($field, $storeId = null): mixed
    {
        return $this->scopeConfig->getValue(
            $field,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function initializeStreply(): void
    {
        $initializeUrl = $this->getInitializeUrl();
        try {
            \Streply\Initialize($initializeUrl);
        } catch (InvalidDsnException $e) {
            throw new \Exception($e);
        }
    }

    /**
     * @return string
     */
    protected function getInitializeUrl(): string
    {
        return $this->getStreplyDSNfromConfig();
    }

    /**
     * @return mixed
     */
    protected function getStreplyDSNfromConfig(): mixed
    {
        return $this->getConfigValue(self::XML_PATH_API_KEY);
    }

    /**
     * @return void
     */
    public function flushStreplyClient(): void
    {
        \Streply\Flush();
    }
}

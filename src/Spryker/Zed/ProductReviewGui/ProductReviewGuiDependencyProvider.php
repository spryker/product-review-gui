<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ProductReviewGui;

use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;
use Spryker\Zed\ProductReviewGui\Dependency\Facade\ProductReviewGuiToLocaleBridge;
use Spryker\Zed\ProductReviewGui\Dependency\Facade\ProductReviewGuiToProductReviewBridge;
use Spryker\Zed\ProductReviewGui\Dependency\QueryContainer\ProductReviewGuiToProductReviewBridge as ProductReviewGuiToProductReviewQueryContainerBridge;
use Spryker\Zed\ProductReviewGui\Dependency\Service\ProductReviewGuiToUtilDateTimeBridge as ServiceProductReviewGuiToDateTimeBridge;
use Spryker\Zed\ProductReviewGui\Dependency\Service\ProductReviewGuiToUtilSanitizeBridge as ServiceProductReviewGuiToUtilSanitizeBridge;

/**
 * @method \Spryker\Zed\ProductReviewGui\ProductReviewGuiConfig getConfig()
 */
class ProductReviewGuiDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const FACADE_PRODUCT_REVIEW = 'FACADE_PRODUCT_REVIEW';

    /**
     * @var string
     */
    public const FACADE_LOCALE = 'FACADE_LOCALE';

    /**
     * @var string
     */
    public const SERVICE_UTIL_SANITIZE = 'SERVICE_UTIL_SANITIZE';

    /**
     * @var string
     */
    public const SERVICE_UTIL_DATE_TIME = 'SERVICE_UTIL_DATE_TIME';

    /**
     * @var string
     */
    public const QUERY_CONTAINER_PRODUCT_REVIEW = 'QUERY_CONTAINER_PRODUCT_REVIEW';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideCommunicationLayerDependencies(Container $container)
    {
        $this->addProductReviewFacade($container);
        $this->addLocaleFacade($container);
        $this->addUtilSanitizeService($container);
        $this->addUtilDateTimeService($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return void
     */
    protected function addUtilSanitizeService(Container $container)
    {
        $container->set(static::SERVICE_UTIL_SANITIZE, function (Container $container) {
            return new ServiceProductReviewGuiToUtilSanitizeBridge($container->getLocator()->utilSanitize()->service());
        });
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return void
     */
    protected function addUtilDateTimeService(Container $container)
    {
        $container->set(static::SERVICE_UTIL_DATE_TIME, function (Container $container) {
            return new ServiceProductReviewGuiToDateTimeBridge($container->getLocator()->utilDateTime()->service());
        });
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function providePersistenceLayerDependencies(Container $container)
    {
        $this->addProductReviewQueryContainer($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return void
     */
    protected function addProductReviewFacade(Container $container)
    {
        $container->set(static::FACADE_PRODUCT_REVIEW, function (Container $container) {
            return new ProductReviewGuiToProductReviewBridge($container->getLocator()->productReview()->facade());
        });
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return void
     */
    protected function addProductReviewQueryContainer(Container $container)
    {
        $container->set(static::QUERY_CONTAINER_PRODUCT_REVIEW, function (Container $container) {
            return new ProductReviewGuiToProductReviewQueryContainerBridge($container->getLocator()->productReview()->queryContainer());
        });
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return void
     */
    protected function addLocaleFacade(Container $container)
    {
        $container->set(static::FACADE_LOCALE, function (Container $container) {
            return new ProductReviewGuiToLocaleBridge($container->getLocator()->locale()->facade());
        });
    }
}

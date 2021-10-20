<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ProductReviewGui\Communication\Controller;

use Generated\Shared\Transfer\ProductReviewTransfer;
use Orm\Zed\ProductReview\Persistence\Map\SpyProductReviewTableMap;
use Spryker\Service\UtilText\Model\Url\Url;
use Spryker\Zed\Kernel\Communication\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \Spryker\Zed\ProductReviewGui\Communication\ProductReviewGuiCommunicationFactory getFactory()
 * @method \Spryker\Zed\ProductReviewGui\Persistence\ProductReviewGuiQueryContainerInterface getQueryContainer()
 */
class UpdateController extends AbstractController
{
    /**
     * @var string
     */
    public const PARAM_ID = 'id';

    /**
     * @var string
     */
    protected const ROUTE_TEMPLATES_LIST = '/product-review-gui';

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function approveAction(Request $request)
    {
        $form = $this->getFactory()->getStatusProductReviewForm()->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            $this->addErrorMessage('CSRF token is not valid.');

            return $this->redirectResponse(static::ROUTE_TEMPLATES_LIST);
        }

        $idProductReview = $this->castId($request->query->get(static::PARAM_ID));

        $productReviewTransfer = new ProductReviewTransfer();
        $productReviewTransfer
            ->setIdProductReview($idProductReview)
            ->setStatus(SpyProductReviewTableMap::COL_STATUS_APPROVED);

        $this->getFactory()
            ->getProductReviewFacade()
            ->updateProductReviewStatus($productReviewTransfer);

        $this->addSuccessMessage('Product Review #%d has been approved.', ['%d' => $idProductReview]);

        return $this->redirectResponse(Url::generate(static::ROUTE_TEMPLATES_LIST)->build());
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function rejectAction(Request $request)
    {
        $form = $this->getFactory()->getStatusProductReviewForm()->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            $this->addErrorMessage('CSRF token is not valid.');

            return $this->redirectResponse(static::ROUTE_TEMPLATES_LIST);
        }

        $idProductReview = $this->castId($request->query->get(static::PARAM_ID));

        $productReviewTransfer = new ProductReviewTransfer();
        $productReviewTransfer
            ->setIdProductReview($idProductReview)
            ->setStatus(SpyProductReviewTableMap::COL_STATUS_REJECTED);

        $this->getFactory()
            ->getProductReviewFacade()
            ->updateProductReviewStatus($productReviewTransfer);

        $this->addSuccessMessage('Product Review #%d has been rejected.', ['%d' => $idProductReview]);

        return $this->redirectResponse(Url::generate(static::ROUTE_TEMPLATES_LIST)->build());
    }
}

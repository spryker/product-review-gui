<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ProductReviewGui\Communication\Controller;

use Generated\Shared\Transfer\ProductReviewTransfer;
use Spryker\Service\UtilText\Model\Url\Url;
use Spryker\Zed\Kernel\Communication\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \Spryker\Zed\ProductReviewGui\Communication\ProductReviewGuiCommunicationFactory getFactory()
 * @method \Spryker\Zed\ProductReviewGui\Persistence\ProductReviewGuiQueryContainerInterface getQueryContainer()
 */
class DeleteController extends AbstractController
{
    /**
     * @var string
     */
    public const PARAM_ID = 'id';

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function indexAction(Request $request)
    {
        $form = $this->getFactory()->createDeleteProductReviewForm()->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            $this->addErrorMessage('CSRF token is not valid');

            return $this->redirectResponse(
                Url::generate('/product-review-gui')->build(),
            );
        }

        $idProductReview = $this->castId($request->query->get(static::PARAM_ID));

        $productSetTransfer = new ProductReviewTransfer();
        $productSetTransfer->setIdProductReview($idProductReview);

        $this->getFactory()
            ->getProductReviewFacade()
            ->deleteProductReview($productSetTransfer);

        $this->addSuccessMessage('Product Review #%id% deleted successfully.', [
            '%id%' => $productSetTransfer->getIdProductReview(),
        ]);

        return $this->redirectResponse(
            Url::generate('/product-review-gui')->build(),
        );
    }
}

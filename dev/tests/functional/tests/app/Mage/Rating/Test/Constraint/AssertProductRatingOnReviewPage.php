<?php
/**
 * Magento Enterprise Edition
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Magento Enterprise Edition End User License Agreement
 * that is bundled with this package in the file LICENSE_EE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.magento.com/license/enterprise-edition
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magento.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magento.com for more information.
 *
 * @category    Tests
 * @package     Tests_Functional
 * @copyright Copyright (c) 2006-2020 Magento, Inc. (http://www.magento.com)
 * @license http://www.magento.com/license/enterprise-edition
 */

namespace Mage\Rating\Test\Constraint;

use Mage\Review\Test\Fixture\Review;
use Mage\Review\Test\Page\Adminhtml\CatalogProductReviewEdit;
use Mage\Review\Test\Page\Adminhtml\CatalogProductReview;
use Magento\Mtf\Constraint\AbstractAssertForm;

/**
 * Assert that product rating is displayed on product review(backend) page.
 */
class AssertProductRatingOnReviewPage extends AbstractAssertForm
{
    /* tags */
    const SEVERITY = 'low';
    /* end tags */

    /**
     * Assert that product rating is displayed on product review(backend) page.
     *
     * @param CatalogProductReview $reviewIndex
     * @param CatalogProductReviewEdit $reviewEdit
     * @param Review $review
     * @return void
     */
    public function processAssert(
        CatalogProductReview $reviewIndex,
        CatalogProductReviewEdit $reviewEdit,
        Review $review
    ) {
        $reviewIndex->open();
        $reviewIndex->getReviewGrid()->searchAndOpen(['title' => $review->getTitle()]);
        $ratingReview = $this->sortDataByPath($review->getRatings(), '::title');
        $ratingForm = $this->sortDataByPath($reviewEdit->getReviewForm()->getData()['ratings'], '::title');
        $error = $this->verifyData($ratingReview, $ratingForm);

        \PHPUnit_Framework_Assert::assertEmpty($error, $error);
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Product rating is displayed on edit review page(backend).';
    }
}
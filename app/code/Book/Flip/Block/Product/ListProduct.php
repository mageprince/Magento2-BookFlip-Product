<?php

namespace Book\Flip\Block\Product;

use Magento\Catalog\Api\CategoryRepositoryInterface;
use Book\Flip\Block\Product\View\Gallery;

/**
 * Product list
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class ListProduct extends \Magento\Catalog\Block\Product\ListProduct
{
    /**
     * Catalog layer
     *
     * @var \Magento\Catalog\Model\Layer
     */
    protected $_catalogLayer;

    /**
     * @var \Magento\Framework\Data\Helper\PostHelper
     */
    protected $_postDataHelper;

    /**
     * @var \Magento\Framework\Url\Helper\Data
     */
    protected $urlHelper;

    /**
     * @var CategoryRepositoryInterface
     */
    protected $categoryRepository;

    /**
     * @param Context $context
     * @param \Magento\Framework\Data\Helper\PostHelper $postDataHelper
     * @param \Magento\Catalog\Model\Layer\Resolver $layerResolver
     * @param CategoryRepositoryInterface $categoryRepository
     * @param \Magento\Framework\Url\Helper\Data $urlHelper
     */
	public function __construct(
		\Magento\Catalog\Block\Product\Context $context,
		\Magento\Framework\Data\Helper\PostHelper $postDataHelper,
		\Magento\Catalog\Model\Layer\Resolver $layerResolver,
		CategoryRepositoryInterface $categoryRepository,
		\Magento\Framework\Url\Helper\Data $urlHelper,
		Gallery $gallery
	)
	{
		$this->_catalogLayer = $layerResolver->get();
		$this->_postDataHelper = $postDataHelper;
		$this->categoryRepository = $categoryRepository;
		$this->urlHelper = $urlHelper;
		$this->gallery = $gallery;
		parent::__construct($context,$postDataHelper,$layerResolver,$categoryRepository,$urlHelper);
	}

	/**
     * Get book collection by sku
     *
     * @return Bookcollection
     */
   	public function getSkuBookCollection($sku)
    {
        $bookCollection = $this->gallery->getSkuBookCollection($sku);
    	/* @var $gallery \Book\Flip\Block\Product\View\Gallery */
    	return $bookCollection;
    }

    /**
     * Get image by loaded book
     */
    public function getThumbnail($book)
    {
        $thumb = $this->gallery->getThumbnail($book);
        /* @var $gallery \Book\Flip\Block\Product\View\Gallery */
        return $thumb;

    }

}

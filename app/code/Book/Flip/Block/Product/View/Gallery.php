<?php

/**
 * Product gallery
 */
namespace Book\Flip\Block\Product\View;

use Book\Flip\Model\FlipFactory;
use Magento\Framework\ObjectManagerInterface;
use Magento\Framework\Json\EncoderInterface;
use Magento\Catalog\Block\Product\Context;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Store\Model\StoreManagerInterface;

class Gallery extends \Magento\Catalog\Block\Product\View\Gallery
{
    /**
    * Flip book model
    */
    protected $_flipModel;

    /**
    * JsonEncoder
    */
    protected $jsonEncoder;
    
    /**
    * Object manager
    */
    private $_objectManager;
    
    /**
    * Store manager
    */
    protected $_storeManager;

    /**
     * @param \Magento\Catalog\Block\Product\Context $context
     * @param \Magento\Framework\Stdlib\ArrayUtils $arrayUtils
     * @param \Magento\Framework\Registry $registry
     * @param EncoderInterface $jsonEncoder
     * @param DirectoryList $directoryList
     * @param ObjectManagerInterface $objectmanager
     * @param StoreManagerInterface $storeManager
     * @param array $data
     */
    public function __construct(
        \Magento\Catalog\Block\Product\Context $context,
        \Magento\Framework\Stdlib\ArrayUtils $arrayUtils,
        \Magento\Framework\Registry $registry,
        FlipFactory $flipModel,
        EncoderInterface $jsonEncoder,
        DirectoryList $directoryList,
        ObjectManagerInterface $objectmanager,
        StoreManagerInterface $storeManager,
        array $data = []
    ) {
        $this->_flipModel = $flipModel;
        $this->_objectManager = $objectmanager;
        $this->directory_list = $directoryList;
        $this->jsonEncoder = $jsonEncoder;
        $this->_registry = $registry;
        $this->_storeManager = $storeManager;
        parent::__construct($context, $arrayUtils, $jsonEncoder, $data);
    }

    /**
     * Retrieve book collection
     */
    public function getCollection()
    {
        $collection = $this->_flipModel->create();
        $items = $collection->getCollection();
        return $items;
    }

    /**
     * Get book collection by id
     */
    public function getBook($id)
    {
        $collection = $this->_flipModel->create();
        $book = $collection->load($id);
        return $book;
    }

    /**
     * Get book directory path
     */
    public function getBookDir(){
        return $this->directory_list->getPath('media').'/book';
    }

    /**
     * Get book media url
     */
    public function getBookPath($folder){
        return $this->getUrl('pub/media').'book'.$folder;
    }

    /**
     * Get uploaded book url
     */
    public function getUploadDir($book)
    {
        $uploadDir = substr($book->getUpload(), 0, -4);
        return $uploadDir;
    }

    /**
     * Get book collection by sku
     */
    public function getSkuBookCollection($sku)
    {
        $collection = $this->getCollection();
        $collection->getSelect()->where( " FIND_IN_SET('".$sku."',productsku) " );
        return $collection->getFirstItem(); 
    }

    /**
     * Get backgound image url
     */
    public function getBackgroundImage($book, $file)
    {   
        $image = "background-image:url('".$this->getBookPath($book->getUpload()).$file."')";
        return $image;
    }

    /**
     * Get book images by loaded book collection
     */
    public function getBookPages($book)
    { 
        $files = $this->getBookDir().$book->getUpload();
        //scan files in directory
        $files_in_directory = scandir($files);
        //count total number of files in directory
        $items_count = count($files_in_directory);
        $fileArray = array();
        if ($items_count <= 2) { return false; }
        else 
        {
            $pages = array_slice(scandir($files),2);
            foreach ($pages as $file) { $fileArray[] = $file; }     
            sort($fileArray, SORT_NUMERIC);
        }
        return $fileArray;
    }

    /**
    * Get image of loaded book
    */
    public function getThumbnail($book)
    {
        $media = $this ->_storeManager-> getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA );
        $thumbUrl = $media.'book'.$book->getThumbnail();
        $thumb = "<img class='top' src='".$thumbUrl."'>";
        return $thumb;

    }

    /**
    * Retrive configuration value
    */
    public function getConfig($value)
    {
        $config = $this->_objectManager->
        get('Magento\Framework\App\Config\ScopeConfigInterface')->getValue($value);
        return $config;
    }
}
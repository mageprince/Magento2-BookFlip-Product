<?php
 
namespace Book\Flip\Block\Adminhtml\Flip\Edit;
 
use Magento\Backend\Block\Widget\Form\Generic;

/**
 * Book form
 */
class Form extends Generic
{
    /**
    * @param \Magento\Backend\Block\Template\Context $context
    * @param \Magento\Framework\Registry $registry
    * @param \Magento\Framework\Data\FormFactory $formFactory
    * @param \Magento\Store\Model\System\Store $systemStore
    * @param array $data
    */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Store\Model\System\Store $systemStore,
        array $data = []
    ) {
        $this->_systemStore = $systemStore;
        parent::__construct($context, $registry, $formFactory, $data);
    }

     protected function _construct()
    {
        parent::_construct();
        $this->setId('flip_form');
        $this->setTitle(__('Book Information'));
    }

    protected function _prepareForm()
    {

        $model = $this->_coreRegistry->registry('book_flip_flip');

        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create(
            [
                'data' => [
                    'id'    => 'edit_form',
                    'action' => $this->getData('action'),
                    'method' => 'post',
                    'enctype' => 'multipart/form-data'
                ]
            ]
        );

        $fieldset = $form->addFieldset(
            'base_fieldset',
            ['legend' => __('General Information'), 'class' => 'fieldset-wide']
        );

        if ($model->getFlipId()) {
           $fieldset->addField('flip_id', 'hidden', ['name' => 'flip_id']);
        }

        $fieldset->addField(
            'title',
            'text',
            ['name' => 'title', 'label' => __('Name'), 'title' => __('Name'), 'required' => true]
        );
        $fieldset->addType(
        'image',
        '\Book\Flip\Block\Adminhtml\Flip\Renderer\Image'
        );

        $fieldset->addField(
            'thumbnail',
            'image',
            ['name' => 'thumbnail', 'label' => __('Thumbnail'), 'title' => __('Thumbnail')]
        );

        $fieldset->addField(
            'upload',
            'image',
            ['name' => 'upload', 'label' => __('Upload'), 'title' => __('Upload'), 'required' => true ]);
        
        $fieldset->addField(
            'productsku',
            'text',
            ['name' => 'productsku', 'label' => __('Applied Products Sku'), 'title' => __('Applied Products Sku'), 'required' => false]
        );

        $fieldset->addField(
            'author',
            'text',
            ['name' => 'author', 'label' => __('Author'), 'title' => __('Author')]
        );

        $fieldset->addField(
            'pages',
            'text',
            ['name' => 'pages', 'label' => __('Page To Display'), 'title' => __('Page To Display'), 'required' => true, 'class' => 'validate-number', 'style' => 'width:100px']
        );

        $fieldset->addField(
            'description',
            'textarea',
            ['name' => 'description', 'label' => __('Description'), 'title' => __('Description')]
        );

        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);
 
        return parent::_prepareForm();
    }
}
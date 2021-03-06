<?php
/**
 * Ultimate_ModuleCreator extension
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE_UMC.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 *
 * @category       Ultimate
 * @package        Ultimate_ModuleCreator
 * @copyright      Copyright (c) 2013
 * @license        http://opensource.org/licenses/mit-license.php MIT License
 */
/**
 * help tab block
 *
 * @category    Ultimate
 * @package     Ultimate_ModuleCreator
 * @author      Marius Strajeru <ultimate.module.creator@gmail.com>
 */
class Ultimate_ModuleCreator_Block_Adminhtml_ModuleCreator_Edit_Tab_Help
    extends Mage_Adminhtml_Block_Widget_Form
    implements Mage_Adminhtml_Block_Widget_Tab_Interface {
    /**
     * constructor
     * @access public
     * @return void
     * @author Marius Strajeru <ultimate.module.creator@gmail.com>
     */
    public function _construct() {
        parent::_construct();
        $this->setTemplate('ultimate_modulecreator/edit/tab/help.phtml');
    }
    /**
     * Return Tab label
     * @access public
     * @return string
     * @author Marius Strajeru <ultimate.module.creator@gmail.com>
     */
    public function getTabLabel() {
        return Mage::helper('modulecreator')->__('Help');
    }
    /**
     * Return Tab title
     * @access public
     * @return string
     * @author Marius Strajeru <ultimate.module.creator@gmail.com>
     */
    public function getTabTitle() {
        return Mage::helper('modulecreator')->__('Help');
    }
    /**
     * Can show tab in tabs
     * @access public
     * @return boolean
     * @author Marius Strajeru <ultimate.module.creator@gmail.com>
     */
    public function canShowTab() {
        return true;
    }

    /**
     * Tab is hidden
     * @access public
     * @return boolean
     * @author Marius Strajeru <ultimate.module.creator@gmail.com>
     */
    public function isHidden() {
        return false;
    }
    /**
     * get UMC version
     * @access public
     * @return string
     * @author Marius Strajeru <ultimate.module.creator@gmail.com>
     */
    public function getVersion(){
        $version    = Mage::app()->getConfig()->getNode('modules/Ultimate_ModuleCreator/version');
        $build      = Mage::app()->getConfig()->getNode('modules/Ultimate_ModuleCreator/build');
        if ($build){
            $version .= ' - '.$build;
        }
        return $version;
    }
    /**
     * prepare tab layout
     * @return Mage_Core_Block_Abstract
     * @author Marius Strajeru <ultimate.module.creator@gmail.com>
     */
    protected function _prepareLayout() {
        $columns = array(
            'label'     => array(
                'header'=>Mage::helper('modulecreator')->__('Field'),
                'key'   =>'label'
            ),
            'type'      => array(
                'header'=>Mage::helper('modulecreator')->__('Type'),
                'key'   =>'type'
            ),
            'required'  => array(
                'header'=>Mage::helper('modulecreator')->__('Required'),
                'type'  => 'bool',
                'key'   =>'required'
            ),
            'system'    => array(
                'header'=>Mage::helper('modulecreator')->__('Has default'),
                'type'  => 'bool',
                'key'   =>'system'
            ),
            'tooltip'   => array(
                'header'=>Mage::helper('modulecreator')->__('Description'),
                'key'   =>'tooltip'
            ),
        );
        $settingsTabHelp = $this->getLayout()->createBlock('modulecreator/adminhtml_modulecreator_edit_tab_help_fieldset')
            ->setFieldsets(Mage::helper('modulecreator')->getFieldsetXmlData('settings'))
            ->setColumns($columns)
            ->setDescription(Mage::helper('modulecreator')->__('General settings tab.'));

        $entityTabHelp = $this->getLayout()->createBlock('modulecreator/adminhtml_modulecreator_edit_tab_help_fieldset')
            ->setFieldsets(Mage::helper('modulecreator')->getFieldsetXmlData('entity'))
            ->setColumns($columns)
            ->setDescription(Mage::helper('modulecreator')->__('Entity management.'));

        $attributeTabHelp = $this->getLayout()->createBlock('modulecreator/adminhtml_modulecreator_edit_tab_help_fieldset')
            ->setFieldsets(Mage::helper('modulecreator')->getFieldsetXmlData('attribute'))
            ->setColumns($columns)
            ->setDescription(Mage::helper('modulecreator')->__('Field/Attribute management.'));

        $fieldTypes = array(
            'field_types'=> array(
                'label'=>Mage::helper('modulecreator')->__('Supported field / attribute types'),
                'fields' => Mage::helper('modulecreator')->getAttributeTypes())
        );
        $fieldTypesHelp = $this->getLayout()->createBlock('modulecreator/adminhtml_modulecreator_edit_tab_help_fieldset')
            ->setFieldsets($fieldTypes)
            ->setColumns(array(
                'label'     => array(
                    'header'=>Mage::helper('modulecreator')->__('Field'),
                    'key'   =>'label'
                ),
                'allow_is_name'     => array(
                    'header'=>Mage::helper('modulecreator')->__('Can behave as name'),
                    'key'   =>'allow_is_name',
                    'type'  => 'bool'
                ),
            ))
            ->setDescription(Mage::helper('modulecreator')->__('Supported field / attribute types'));

        $relationTypes = array(
            'field_types'=> array(
                'label'=>Mage::helper('modulecreator')->__('Relation types'),
                'fields' => Mage::helper('modulecreator')->getRelationTypes()
        ));
        $relationsTypesHelp = $this->getLayout()->createBlock('modulecreator/adminhtml_modulecreator_edit_tab_help_fieldset')
            ->setFieldsets($relationTypes)
            ->setColumns(array(
                'label'     => array(
                    'header'=>Mage::helper('modulecreator')->__('Relation'),
                    'key'   =>'label'
                ),
                'description'     => array(
                    'header'=>Mage::helper('modulecreator')->__('Description'),
                    'key'   =>'description',
                ),
            ))
            ->setDescription(Mage::helper('modulecreator')->__('Entity Relations'));

        $objN = new stdClass();
        $objN->restricted = 'Mage';
        $objN->label = Mage::helper('modulecreator')->__('Disallowed namespace names');

        $routers = (array)Mage::getConfig()->getNode('frontend/routers');
        $objM = new stdClass();
        $objM->restricted = implode(', ',array_keys($routers));
        $objM->label = Mage::helper('modulecreator')->__('Disallowed module names');

        $entityRestrictedNames = implode(', ',array_keys((array)Mage::helper('modulecreator')->getConfig()->getNode('restricted/entity')));
        $objE = new stdClass();
        $objE->restricted = $entityRestrictedNames;
        $objE->label = Mage::helper('modulecreator')->__('Disallowed entity names');

        $attributeRestrictedNames = implode(', ',array_keys((array)Mage::helper('modulecreator')->getConfig()->getNode('restricted/attribute')));
        $objA = new stdClass();
        $objA->restricted = $attributeRestrictedNames;
        $objA->label = Mage::helper('modulecreator')->__('Disallowed field/attribute names');
        $restrictions = array(
            'field_types'=> array(
                'label'=>Mage::helper('modulecreator')->__('Naming restrictions'),
                'fields' => array($objN, $objM, $objE, $objA))
        );

        $restrictionsHelp = $this->getLayout()->createBlock('modulecreator/adminhtml_modulecreator_edit_tab_help_fieldset')
            ->setFieldsets($restrictions)
            ->setColumns(array(
                'label'     => array(
                    'header'=>Mage::helper('modulecreator')->__('Entity'),
                    'key'   =>'label'
                ),
                'description'     => array(
                    'header'=>Mage::helper('modulecreator')->__('Resticted'),
                    'key'   =>'restricted',
                ),
            ))
            ->setDescription(Mage::helper('modulecreator')->__('Naming restrictions'));
        $currentModule = Mage::registry('current_module');
        if (!$currentModule){
            $currentModule = Mage::getModel('modulecreator/module');
        }
        $files = $currentModule->getConfig()->getNode('files');
        $allowedFiles = array();
        foreach ((array)$files as $key=>$file){
            if ($file->scope == 'disabled'){
                continue;
            }
            $allowedFiles[] = $file;
        }

        $filesHelp = $this->getLayout()->createBlock('modulecreator/adminhtml_modulecreator_edit_tab_help_fieldset')
            ->setFieldsets(array(
                'files'=> array(
                    'label'=>Mage::helper('modulecreator')->__('Generated files'),
                    'fields' => $allowedFiles)
            ))
            ->setColumns(array(
                'label'     => array(
                    'header'=>Mage::helper('modulecreator')->__('File'),
                    'key'   =>'title'
                ),
                'destination'=> array(
                    'header'=>Mage::helper('modulecreator')->__('Path'),
                    'key'   =>'destination'
                ),
                'description'     => array(
                    'header'=>Mage::helper('modulecreator')->__('Description'),
                    'key'   =>'description',
                ),
                'condition'     => array(
                    'header'=>Mage::helper('modulecreator')->__('Condition'),
                    'key'   =>'condition',
                ),
            ))
            ->setDescription(Mage::helper('modulecreator')->__('Created files'));

        $this->setChild('settings_tab_help', $settingsTabHelp);
        $this->setChild('entity_tab_help', $entityTabHelp);
        $this->setChild('attribute_tab_help', $attributeTabHelp);
        $this->setChild('attribute_types_help', $fieldTypesHelp);
        $this->setChild('relation_types_help', $relationsTypesHelp);
        $this->setChild('restrictions_help', $restrictionsHelp);
        $this->setChild('files_help', $filesHelp);

        $releaseNotes = (array)Mage::helper('modulecreator')->getReleaseNotes();
        $releaseNotesHelp = $this->getLayout()->createBlock('modulecreator/adminhtml_modulecreator_edit_tab_help_fieldset')
            ->setFieldsets($releaseNotes)
            ->setColumns(array(
                'type'     => array(
                    'header'=>Mage::helper('modulecreator')->__('Type'),
                    'key'   =>'type'
                ),
                'label'     => array(
                    'header'=>Mage::helper('modulecreator')->__('Label'),
                    'key'   =>'label'
                ),
                'comment'   => array(
                    'header'=>Mage::helper('modulecreator')->__('Comment'),
                    'key'   =>'comment'
                ),
            ))
            ->setDescription(Mage::helper('modulecreator')->__('Release notes'))
        ;
        $this->setChild('release_notes', $releaseNotesHelp);

        $thanks = $this->getLayout()->createBlock('modulecreator/adminhtml_modulecreator_edit_tab_help_fieldset')
            ->setFieldsets(array(
                'files'=> array(
                    'label'=>Mage::helper('modulecreator')->__('Thanks'),
                    'fields' => (array)Mage::helper('modulecreator')->getThanks())
            ))
            ->setColumns(array(
                    'type'     => array(
                        'header'=>Mage::helper('modulecreator')->__('To'),
                        'key'   =>'to'
                    ),
                    'label'     => array(
                        'header'=>Mage::helper('modulecreator')->__('Because'),
                        'key'   =>'for'
                    ),
                )
            )
            ->setDescription(Mage::helper('modulecreator')->__('Thank you for your help'));
        $this->setChild('thanks', $thanks);
        return parent::_prepareLayout();
    }
}

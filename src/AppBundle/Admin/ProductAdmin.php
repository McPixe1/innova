<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class ProductAdmin extends AbstractAdmin {

    protected function configureFormFields(FormMapper $formMapper) {
        $formMapper
                ->add('name', 'text', array(
                    'label' => 'Nombre'
                ))
                ->add('description', 'textarea', array(
                    'label' => 'Descripción'
                ))
                ->add('longDescription', 'sonata_simple_formatter_type', array(
                    'format' => 'richhtml',
                    'label' => 'Especificaciones'
                ))
                ->add('specs', 'sonata_simple_formatter_type', array(
                    'format' => 'richhtml',
                    'label' => 'Componentes'
                ))
                ->add('category', 'sonata_type_model', array(
                    'class' => 'AppBundle\Entity\Category',
                    'property' => 'name',
                    'label' => 'Categoría'
                ))
                ->add('isImportant', 'checkbox', array(
                    'label' => 'Destacado',
                    'required' => false
                ))
                ->add('catalogue', 'sonata_media_type', array(
                    'provider' => 'sonata.media.provider.file',
                    'context' => 'default',
                    'label' => 'Catálogo',
                    'required' => false
                ))
                ->add('picture', 'sonata_media_type', array(
                    'provider' => 'sonata.media.provider.image',
                    'context' => 'default',
                    'label' => 'Imagen'
        ));
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper->add('name');
    }

    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
                ->addIdentifier('name')
                ->addIdentifier('description');
    }

}

<?php

/*
 * This file is part of the Integrated package.
 *
 * (c) e-Active B.V. <integrated@e-active.nl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Integrated\Bundle\WebsiteBundle\Form\Type\Grid;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Doctrine\ODM\MongoDB\DocumentManager;

/**
 * @author Ger Jan van den Bosch <gerjan@e-active.nl>
 */
class ColumnType extends AbstractType
{
    /**
     * @var DocumentManager
     */
    protected $dm;

    /**
     * @var int
     */
    protected $depth;

    /**
     * @param DocumentManager $dm
     * @param int $depth
     */
    public function __construct(DocumentManager $dm, $depth = 1)
    {
        $this->dm = $dm;
        $this->depth = $depth;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('size', 'integer');

        $builder->add('items', 'collection', [
            'type'           => new ItemType($this->dm, $this->depth),
            'allow_add'      => true,
            'allow_delete'   => true,
            'prototype_name' => '__name' . $this->depth . '__',
        ]);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Integrated\Bundle\WebsiteBundle\Document\Page\Grid\Column',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'integrated_website_grid_column';
    }
}
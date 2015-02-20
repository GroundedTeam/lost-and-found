<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;

/**
 * Class LostItemType
 *
 * @author Oleg Kachinsky <LogansOleg@gmail.com>
 */
class AreaMapType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'hidden';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'area_map';
    }
}

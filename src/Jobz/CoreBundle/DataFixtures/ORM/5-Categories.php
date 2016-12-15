<?php

namespace Blog\ModelBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Jobz\CoreBundle\Entity\Category;

/**
 * Fixtures for the Category Entity
 */
class Categories extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 5;
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $c1 = new Category();
        $c1->setCategoryName('Developer');
        $c1->setCategoryDescription('Frontend and backand developer ....');

        $c2 = new Category();
        $c2->setCategoryName('Designer');
        $c2->setCategoryDescription('Good designer skill ....');

        $c3 = new Category();
        $c3->setCategoryName('Boss');
        $c3->setCategoryDescription('Boss ... hm ....');


        $manager->persist($c1);
        $manager->persist($c2);
        $manager->persist($c3);

        $manager->flush();
    }
}
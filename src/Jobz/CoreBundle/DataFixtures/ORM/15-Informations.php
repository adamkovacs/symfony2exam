<?php

namespace Blog\ModelBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Jobz\CoreBundle\Entity\Information;

/**
 * Fixtures for the Informations Entity
 */
class Informations extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 15;
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $i1 = new Information();
        $i1->setTitle('information_1');
        $i1->setDescription('Information 1 description');

        $i2 = new Information();
        $i2->setTitle('information_2');
        $i2->setDescription('Information 2 description');

        $i3 = new Information();
        $i3->setTitle('information_3');
        $i3->setDescription('Information 3 description');

        $manager->persist($i1);
        $manager->persist($i2);
        $manager->persist($i3);

        $manager->flush();
    }
}

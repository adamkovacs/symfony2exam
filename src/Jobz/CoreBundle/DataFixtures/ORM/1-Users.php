<?php

namespace Blog\ModelBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Jobz\CoreBundle\Entity\User;

/**
 * Fixtures for the Users Entity
 */
class Users extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 1;
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $u1 = new User();
        $u1->setName('David');
        $u1->setEmail('david@gmail.com');
        $u1->setPassword('david');
        $u1->setRoles('ROLE_USER');

        $u2 = new User();
        $u2->setName('Eddie');
        $u2->setEmail('eddie@gmail.com');
        $u2->setPassword('eddie');
        $u2->setRoles('ROLE_USER');

        $u3 = new User();
        $u3->setName('Adam');
        $u3->setEmail('adam@gmail.com');
        $u3->setPassword('adam');
        $u3->setRoles('ROLE_SUPER_ADMIN');

        $manager->persist($u1);
        $manager->persist($u2);
        $manager->persist($u3);

        $manager->flush();
    }
}
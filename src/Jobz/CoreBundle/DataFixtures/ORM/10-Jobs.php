<?php

namespace Blog\ModelBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Jobz\CoreBundle\Entity\Category;
use Jobz\CoreBundle\Entity\Job;

/**
 * Fixtures for the Job Entity
 */
class Jobs extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 10;
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $j1 = new Job();
        $j1->setCategory($this->getCategory($manager, 'Developer'));
        $j1->setCompany('Innonic');
        $j1->setHowToApply('Email');
        $j1->setJobDescription('Frontend developer ...');
        $j1->setLocation('Debrecen');
        $j1->setPosition('Junior developer');
        $j1->setType('full-time');
        $j1->setUrl('www.innonic.com');
        $j1->setEmail('ads@gmail.com');

        $j2 = new Job();
        $j2->setCategory($this->getCategory($manager, 'Designer'));
        $j2->setCompany('Innonic');
        $j2->setHowToApply('Email');
        $j2->setJobDescription('Designer ...');
        $j2->setLocation('Debrecen');
        $j2->setPosition('Senior designer');
        $j2->setType('full-time');
        $j2->setUrl('www.innonic.com');
        $j2->setEmail('valami@gmail.com');

        $manager->persist($j1);
        $manager->persist($j2);

        $manager->flush();
    }

    /**
     * Get a Category
     *
     * @param ObjectManager $manager
     * @param string $categoryName
     *
     * @return Category
     */
    private function getCategory(ObjectManager $manager, $categoryName)
    {
        return $manager->getRepository('CoreBundle:Category')->findOneBy(
            array(
                'categoryName' => $categoryName
            )
        );
    }
}
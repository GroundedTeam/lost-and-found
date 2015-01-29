<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Item;
use AppBundle\DBAL\Types\ItemTypeType;
use AppBundle\DBAL\Types\ItemStatusType;

/**
 * Load Item fixtures
 *
 * @author Artem Genvald <genvaldartem@gmail.com>
 */
class LoadItemData extends AbstractFixture implements DependentFixtureInterface
{
    /**
     * {@inheritdoc}
     */
    function getDependencies()
    {
        return ['AppBundle\DataFixtures\ORM\LoadCategoryData'];
    }

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        /**
         * @var \AppBundle\Entity\Category $categoryPhone
         * @var \AppBundle\Entity\Category $categoryKeys
         * @var \AppBundle\Entity\Category $categoryDocuments
         * @var \AppBundle\Entity\Category $categoryClothes
         */
        $categoryPhone     = $this->getReference('category-phone');
        $categoryKeys      = $this->getReference('category-keys');
        $categoryDocuments = $this->getReference('category-documents');
        $categoryClothes   = $this->getReference('category-clothes');

        $nexus = (new Item())
            ->setTitle('Телефон Google Nexus 5')
            ->setCategory($categoryPhone)
            ->setLatitude(49.437764)
            ->setLongitude(27.005755)
            ->setType(ItemTypeType::LOST)
            ->setDescription('Загубив телефон Google Nexus 5. Потрібна допомога за винагороду.')
            ->setStatus(ItemStatusType::ACTIVE);
        $manager->persist($nexus);

        $nokia = (new Item())
            ->setTitle('Телефон Nokia 1100')
            ->setCategory($categoryPhone)
            ->setLatitude(50.196532)
            ->setLongitude(26.063656)
            ->setType(ItemTypeType::LOST)
            ->setDescription('Загубив телефон Nokia 1100. Хто знайде - поверніть. Я фанат антикваріату :)')
            ->setStatus(ItemStatusType::RESOLVED);
        $manager->persist($nokia);

        $iPhone = (new Item())
            ->setTitle('iPhone 6')
            ->setCategory($categoryPhone)
            ->setLatitude(50.009795)
            ->setLongitude(25.475887)
            ->setType(ItemTypeType::FOUND)
            ->setDescription('Знайшов новенький-новісінький айфон. Віддам його власнику без винагороди, бо він мені не потрібен. Я фанат андроїда :)')
            ->setStatus(ItemStatusType::ACTIVE);
        $manager->persist($iPhone);

        $keys = (new Item())
            ->setTitle('Ключі від квартири')
            ->setCategory($categoryKeys)
            ->setLatitude(51.437764)
            ->setLongitude(23.005755)
            ->setType(ItemTypeType::LOST)
            ->setDescription('Загубив ключі від квартири.')
            ->setStatus(ItemStatusType::ACTIVE);
        $manager->persist($keys);

        $hat = (new Item())
            ->setTitle('Шапка')
            ->setCategory($categoryClothes)
            ->setLatitude(50.437764)
            ->setLongitude(25.005755)
            ->setType(ItemTypeType::LOST)
            ->setDescription('Загубив улюблену шапку червоного кольору.')
            ->setStatus(ItemStatusType::ACTIVE);
        $manager->persist($hat);

        $passport = (new Item())
            ->setTitle('Паспорт')
            ->setCategory($categoryDocuments)
            ->setLatitude(49.995672)
            ->setLongitude(25.679134)
            ->setType(ItemTypeType::FOUND)
            ->setDescription('Знайшов український національний паспорт на ім\'я Іванов Іван Іванович')
            ->setStatus(ItemStatusType::ACTIVE);
        $manager->persist($passport);

        $manager->flush();
    }
}

<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class UserFixtures extends Fixture implements DependentFixtureInterface
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        $tabRoles = ['SUPERADMIN'];
        foreach ($tabRoles as $role){
            $user = new User();
            $user->setPrenom($faker->firstName)
                ->setNom($faker->lastName)
                ->setEmail($faker->email)
                ->setPassword($this->encoder->encodePassword($user ,'password'))
                ->setTelephone($faker->phoneNumber)
                ->setRole($this->getReference('ROLE_'.$role))
                ->setIsActive(true)
                ->setIsFirstConnexion(true)
                ->setIsDeleted(false);
            $manager->persist($user);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        // TODO: Implement getDependencies() method.
        return [
            RoleFixtures::class,
        ];
    }
}

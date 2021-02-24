<?php

namespace App\DataFixtures;

use App\Entity\Role;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RoleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $tabRoles = ['SUPERADMIN', 'CAISSIER', 'ADMIN', 'UTILISATEUR'];

        //Création des roles
        foreach ($tabRoles as $libelle){
            $role = new Role();
            $role->setLibelle($libelle);
            $this->addReference('ROLE_'.$libelle, $role);
            $manager->persist($role);
        }

        $manager->flush();
    }
}

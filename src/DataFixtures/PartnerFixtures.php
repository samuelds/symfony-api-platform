<?php

namespace App\DataFixtures;

use App\Entity\Partner;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class PartnerFixtures extends Fixture
{
    private UserPasswordEncoderInterface $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        // Admin
        $admin = new Partner();
        $admin->setUsername('admin');
        $admin->setPassword($this->encoder->encodePassword($admin, "admin"));
        $admin->setRoles(["ROLE_ADMIN"]);
        $manager->persist($admin);

        // Simple Partner
        for ($i = 0; $i < 2; $i++)
        {
            $partner = new Partner();
            $partner->setUsername('login'. ($i + 1));
            $partner->setPassword($this->encoder->encodePassword($admin, "0000"));
            $manager->persist($partner);
        }

        $manager->flush();
    }
}

<?php

namespace App\DataFixtures;

use App\Entity\Partner;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class PartnerFixtures extends Fixture
{
    private UserPasswordEncoderInterface $encoder;

    /**
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        // Admin
        $admin = new Partner();
        $admin->setUsername('admin');
        $password = $this->encoder->encodePassword($admin, "admin");
        $admin->setPassword($password);
        $admin->setRoles(["ROLE_ADMIN"]);
        $manager->persist($admin);

        // Simple Partner
        for ($i = 0; $i < 2; $i++)
        {
            $partner = new Partner();
            $partner->setUsername('login'. ($i + 1));
            $password = $this->encoder->encodePassword($partner, "0000");
            $partner->setPassword($password);
            $manager->persist($partner);
        }

        $manager->flush();
    }
}

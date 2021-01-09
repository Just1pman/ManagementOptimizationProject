<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AddUserFixtures extends Fixture
{
    private $encoder;

    const COUNT_USER = 15;

    /**
     * AddUserFixtures constructor.
     * @param $encoder
     */
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < self::COUNT_USER; $i++) {
            $user = (new User())
                ->setEmail("just1pman{$i}@gmail.com")
                ->setRoles(['ROLE_USER']);
            $password = $this->encoder->encodePassword($user, "123");
            $user->setPassword($password);
            $manager->persist($user);
        }

        $managerRole = (new User())
            ->setEmail("manager{$i}@gmail.com")
            ->setRoles(['ROLE_MANAGER']);
        $password = $this->encoder->encodePassword($managerRole, "123");
        $managerRole->setPassword($password);
        $manager->persist($managerRole);

        $adminRole = (new User())
            ->setEmail("admin@gmail.com")
            ->setRoles(['ROLE_ADMIN']);
        $password = $this->encoder->encodePassword($adminRole, "123");
        $adminRole->setPassword($password);
        $manager->persist($adminRole);

        $manager->flush();
    }
}

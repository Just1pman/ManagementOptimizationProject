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

            $password = $this->encoder->encodePassword($user, "123{$i}");
            $user->setPassword($password);

            $manager->persist($user);
        }

        $manager->flush();
    }
}

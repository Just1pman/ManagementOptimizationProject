<?php

namespace App\DataFixtures;

use App\Entity\PersonalData;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AddUserFixtures extends Fixture
{
    private UserPasswordEncoderInterface $encoder;

    const USER_COUNT = 20;

    const USER_NAME_MALE = [
        'Antonio',
        'Brandon',
        'Bruce',
        'Carter',
        'David',
        'Eric',
        'Fred'
    ];

    const USER_NAME_FEMALE = [
        'Elysha',
        'Angelina',
        'Ashley',
        'Beatrice',
        'Bella',
        'Deena',
        'Evelyn'
    ];

    const USER_SURNAME = [
        'Belov',
        'Galkin',
        'Gusev',
        'Yegorov',
        'Volkov',
        'Dubov',
        'Mukhov',
        'Matveyev',
        'Olenev',
        'Savasin',
        'Sizov'
    ];

    /**
     * AddUserFixtures constructor.
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $this->addUser($manager, 'user', self::USER_COUNT);
        $this->addUser($manager, 'manager', 1);
        $this->addUser($manager, 'admin', 1);
    }

    private function addUser(ObjectManager $manager, string $role, $amount = 20)
    {
        for ($i = 0; $i < $amount; $i++) {
            $gender = rand(0, 1) ? 'male' : 'female';
            $role = strtoupper($role);
            $personalData = $this->addPersonalData($gender);
            $email = "{$this->randName($gender)['name']}{$this->randName($gender)['surname']}";

            $email = $role === 'MANAGER' ? 'manager' : $email;
            $email = $role === 'ADMIN' ? 'admin' : $email;

            $user = (new User())
                ->setEmail($email . '@gmail.com')
                ->setRoles(["ROLE_{$role}"])
                ->setPersonalData($personalData);

            if ($manager->getRepository(User::class)->findBy(['email' => $user->getEmail()])) {
                continue;
            }
            $password = $this->encoder->encodePassword($user, "123456");
            $user->setPassword($password);
            $manager->persist($user);
            $manager->flush();
        }
    }

    private function addPersonalData($gender): PersonalData
    {
        $maritalStatus = rand(0, 1) ? 'married' : 'single';

        return (new PersonalData())
            ->setName($this->randName($gender)['name'])
            ->setSurname($this->randName($gender)['surname'])
            ->setGender($gender)
            ->setPhone(+375291234567)
            ->setAbout($content = file_get_contents('http://loripsum.net/api/1/short/headers/plaintext/prude'))
            ->setMaritalStatus($maritalStatus)
            ->setDateOfBirth(new \DateTime());
    }

    private function randName($gender)
    {
        $userName = rand(0, 1) ? self::USER_NAME_MALE : self::USER_NAME_FEMALE;
        $name = $userName[array_rand($userName)];
        $surName = self::USER_SURNAME[array_rand(self::USER_SURNAME)];
        if ($gender === 'female') {
            $surName .= 'a';
        }
        return [
            'name' => $name,
            'surname' => $surName
        ];
    }
}

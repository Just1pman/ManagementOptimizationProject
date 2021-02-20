<?php

namespace App\DataFixtures;

use App\Entity\PersonalData;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AddUserFixtures extends Fixture
{
    private $encoder;

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

    const CATEGORY = [
        'frontend',
        'backend',
        'testing',
        'devops',
        'softskills',
        'hardskills'
    ];

    const SKILLS = [
        'frontend',
        'backend',
        'testing',
        'devops',
        'softskills',
        'hardskills'
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
//        for ($i = 0; $i < self::USER_COUNT; $i++) {
//            $user = (new User())
//                ->setEmail("just1pman{$i}@gmail.com")
//                ->setRoles(['ROLE_USER']);
//            $password = $this->encoder->encodePassword($user, "123");
//            $user->setPassword($password);
//            $manager->persist($user);
//        }
//
//        $managerRole = (new User())
//            ->setEmail("manager{$i}@gmail.com")
//            ->setRoles(['ROLE_MANAGER']);
//        $password = $this->encoder->encodePassword($managerRole, "123456");
//        $managerRole->setPassword($password);
//        $manager->persist($managerRole);
//
//        $adminRole = (new User())
//            ->setEmail("admin@gmail.com")
//            ->setRoles(['ROLE_ADMIN']);
//        $password = $this->encoder->encodePassword($adminRole, "123");
//        $adminRole->setPassword($password);
//        $manager->persist($adminRole);
    }

    private function addUser(ObjectManager $manager, string $role, $amount = 20)
    {
        for ($i = 0; $i < $amount; $i++) {
            $gender = rand(0, 1) ? 'male' : 'female';

            $personalData = $this->addPersonalData($gender, $role);
            $email = "{$this->randName($gender)['name']}{$this->randName($gender)['surname']}";

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

    private function addPersonalData($gender, $role) {
        $maritalStatus = rand(0, 1) ? 'married' : 'single';
        $role = strtoupper($role);
        return (new PersonalData())
            ->setName($this->randName($gender)['name'])
            ->setSurname($this->randName($gender)['surname'])
            ->setGender($gender)
            ->setPhone(+375291234567)
            ->setAbout($content = file_get_contents('http://loripsum.net/api/2/short/headers/plaintext/prude'))
            ->setMaritalStatus($maritalStatus)
            ->setDateOfBirth(new \DateTime());
    }

    private function randName($gender)
    {
        $userName = rand(0, 1) ? self::USER_NAME_MALE : self::USER_NAME_FEMALE;
        $name = $userName[array_rand($userName)];
        $surName = self::USER_SURNAME[array_rand(self::USER_SURNAME)];
        if($gender === 'female') {
            $surName .= 'a';
        }
        return [
            'name' => $name,
            'surname' => $surName
        ];
    }
}

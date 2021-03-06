<?php

namespace App\DataFixtures;


use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        foreach ($this->getUserData() as [$firstname, $lastname, $username, $email, $phone, $photo,  $password, $roles]) {

            $user = new User();

            $user->setFirstname($firstname);
            $user->setLastname($lastname);
            $user->setUsername($username);
            $user->setEmail($email);
            $user->setPhone($phone);
            $user->setPhoto($photo);
            $user->setPassword($this->passwordEncoder->encodePassword($user, $password));
            $user->setRoles($roles);

            $manager->persist($user);
            $this->addReference($username, $user);
        }

        $manager->flush();
    }

    private function getUserData(): array
    {
        return [
            ['Mr.', 'User', 'user', 'user@gmail.com', '0164896538', 'photo2.jpg','passworduser', ['ROLE_USER']],
            ['Mr.', 'User2', 'user2', 'user2@gmail.com', '0164896538', 'photo2.jpg','passworduser2', ['ROLE_USER']],
        ];
    }


}
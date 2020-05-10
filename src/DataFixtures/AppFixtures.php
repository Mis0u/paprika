<?php

namespace App\DataFixtures;

use App\Entity\CompanyActuality;
use Faker;
use App\Entity\Team;
use App\Entity\User;
use App\Entity\Mission;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $passwordEncoder;
    const AVATAR_URL = "https://api.adorable.io/avatars/60/";

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker =  Faker\Factory::create('fr_FR');
        
        for ($i = 1; $i <= 4; $i++){
            $team = new Team();

            for ($j = 1; $j <= 5; $j++){
                $isMale = mt_rand(0,1);
                $user = new User();
                $news = new CompanyActuality();
                $isMale ? $user->setFirstName($faker->firstNameMale) : $user->setFirstName($faker->firstNameFemale);
                $j === 5 ? $user->setIsLeader(1) : $user->setIsLeader(0);

                $user->setLastName($faker->lastName)
                     ->setIsMale($isMale)
                     ->setPassword($this->passwordEncoder->encodePassword($user, $user->getPassword()))
                     ->setAvatar(self::AVATAR_URL. $user->getLastName(). "." .$user->getFirstName(). "@paprika.png");

                if ($user->getIsLeader(1)){
                    $team->setLeaderLastName($user->getLastName())
                     ->setLeaderFirstName($user->getFirstName());
                }

                for ($k = 1; $k <= 7; $k++){
                    $mission = new Mission();
                    $mission->setContent($faker->paragraph(9))
                            ->setMissionUser($user);
                    $manager->persist($mission);

                }
                $news->setNews($faker->realText(500));

                $team->addUser($user);

                $manager->persist($team);
                $manager->persist($user);
                $manager->persist($news);
            }

        }

        $user = new User();
        $team = new Team();
       
        $user->setLastName("norris")
             ->setFirstName("chuck")
             ->setIsMale(1)
             ->setIsLeader(1)
             ->setPassword($this->passwordEncoder->encodePassword($user, $user->getPassword()))
             ->setRoles(["ROLE_ADMIN"])
             ->setAvatar(self::AVATAR_URL. $user->getLastName(). "." .$user->getFirstName(). "@paprika.png");

        $team->setLeaderLastName($user->getLastName())
             ->setLeaderFirstName($user->getFirstName())
             ->setIsBoss(1)
             ->addUser($user);
        $manager->persist($team);
        $manager->persist($user);
       

        $manager->flush();
    }
}

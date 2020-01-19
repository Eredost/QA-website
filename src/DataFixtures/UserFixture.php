<?php

namespace App\DataFixtures;


use App\Entity\User;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixture extends BaseFixture implements DependentFixtureInterface
{
    /** @var UserPasswordEncoderInterface */
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function loadData(ObjectManager $manager)
    {
        $this->createMany(6, 'main_user', function () {
            $userEntity = (new User())
                ->setUsername($this->faker->unique()->userName)
                ->setRoles(['ROLE_USER'])
                ->setFirstname($this->faker->firstName)
                ->setLastname($this->faker->lastName)
            ;
            $userEntity
                ->setGithub('https://github.com/' . $userEntity->getUsername())
                ->setPassword($this->encoder->encodePassword($userEntity, 'password'))
            ;

            return $userEntity;
        });

        // Creating User with moderator roles
        $moderatorUserEntity = (new User())
            ->setUsername('moderator')
            ->setRoles(['ROLE_MODERATOR'])
        ;
        $moderatorUserEntity->setPassword($this->encoder->encodePassword($moderatorUserEntity, 'password'));
        $manager->persist($moderatorUserEntity);

        // Creating User with administrator roles
        $adminUserEntity = (new User())
            ->setUsername('admin')
            ->setRoles(['ROLE_ADMIN'])
        ;
        $adminUserEntity->setPassword($this->encoder->encodePassword($adminUserEntity, 'password'));
        $manager->persist($adminUserEntity);

        $manager->flush();
    }

    /**
     * @inheritDoc
     */
    public function getDependencies()
    {
        return [
            RoleFixture::class,
        ];
    }
}

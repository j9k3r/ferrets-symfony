<?php

namespace App\Tests\Functional\Users\Infrastructure\Repository;

use App\Tests\Resource\Fixture\UserFixture;
use App\Users\Domain\Entity\User;
use App\Users\Domain\Factory\UserFactory;
use App\Users\Infrastructure\Repository\UserRepository;
use Faker\Factory;
use Faker\Generator;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserRepositoryTest extends WebTestCase
{
    private UserRepository $repository;
    private Generator $faker;
    private AbstractDatabaseTool $databaseTool;
    public function setUp(): void
    {
         parent::setUp();
         $this->repository = static::getContainer()->get(UserRepository::class);
         $this->userFactory = static::getContainer()->get(UserFactory::class);
         $this->faker = Factory::create();
         $this->databaseTool = static::getContainer()->get(DatabaseToolCollection::class)->get();
    }
    public function test_user_added_succsessfully(): void
    {
        $email = $this->faker->email();
        $password = $this->faker->password();
        $user = $this->userFactory->create($email, $password);

        // act
        $this->repository->add($user);

        //assert
        $existingUser = $this->repository->findByUlid($user->getUlid());
        $this->assertEquals($user->getUlid(), $existingUser->getUlid());
    }

    public function test_user_found_succsessfully(): void
    {
        //arrange
        $executor = $this->databaseTool->loadFixtures([UserFixture::class]);
        $user = $executor->getReferenceRepository()->getReference(UserFixture::REFERENCE, User::class);

        $us = $user->getUlid();

        //act
        $existingUser = $this->repository->findByUlid($user->getUlid());


        //assert
        $this->assertEquals($user->getUlid(), $existingUser->getUlid());
    }

}

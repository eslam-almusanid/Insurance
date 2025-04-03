<?php

namespace Tests\Feature;

use Mockery;
use Tests\TestCase;
use App\Services\V1\UserService;
use App\Repositories\Interfaces\UserRepositoryInterface;

class UserServiceTest extends TestCase
{
    public function test_create_user()
    {
        $repository = Mockery::mock(UserRepositoryInterface::class);
        $repository->shouldReceive('create')->once()->andReturn((object) ['id' => 1, 'name' => 'Test User']);

        $service = new UserService($repository);
        $user = $service->createUser(['name' => 'Test User', 'password' => 'secret']);

        $this->assertEquals('Test User', $user->name);
    }
}
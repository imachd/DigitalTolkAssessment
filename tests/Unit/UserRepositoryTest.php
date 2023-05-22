<?php

namespace Tests\Unit\Repositories;

use DTApi\Models\User;
use DTApi\Repositories\UserRepository;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class UserRepositoryTest extends TestCase
{
    /**
     * @var UserRepository
     */
    protected $userRepository;

    public function setUp()
    {
        parent::setUp();

        $this->userRepository = new UserRepository();
    }

    /**
     * @test
     */
    public function it_should_create_a_new_user()
    {
        $data = [
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => 'password',
            'user_type' => 1,
        ];

        $user = $this->userRepository->create($data);

        $this->assertTrue($user instanceof User);
        $this->assertEquals($data['name'], $user->name);
        $this->assertEquals($data['email'], $user->email);
        $this->assertEquals($data['password'], $user->password);
        $this->assertEquals($data['user_type'], $user->user_type);
    }

    /**
     * @test
     */
    public function it_should_update_an_existing_user()
    {
        $user = factory(User::class)->create();

        $data = [
            'name' => 'Jane Doe',
            'email' => 'janedoe@example.com',
            'password' => 'password123',
            'user_type' => 2,
        ];

        $this->userRepository->update($user->id, $data);

        $user = User::find($user->id);

        $this->assertEquals($data['name'], $user->name);
        $this->assertEquals($data['email'], $user->email);
        $this->assertEquals($data['password'], $user->password);
        $this->assertEquals($data['user_type'], $user->user_type);
    }

    /**
     * @test
     */
    public function it_should_throw_an_exception_if_the_user_does_not_exist()
    {
        $this->expectException(\Illuminate\Database\Eloquent\ModelNotFoundException::class);

        $this->userRepository->update(123456, []);
    }

    /**
     * @test
     */
    public function it_should_throw_an_exception_if_the_data_is_invalid()
    {
        $this->expectException(\Illuminate\Validation\ValidationException::class);

        $this->userRepository->create([]);
    }
}

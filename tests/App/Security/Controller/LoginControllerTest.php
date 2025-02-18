<?php

namespace App\Tests\App\Security\Controller;

use App\Fixture\Factory\UserFactory;
use App\User\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class LoginControllerTest extends WebTestCase
{
    use ResetDatabase;
    use Factories;

    public function testSomething(): void
    {
        $client = static::createClient();

        $username = 'toto';
        $plainTextPassword = '1234';
        $hashedPassword = '$2y$13$oMHH8lSI/n1iCL8z5.BAguQODSI8xCBgivgzpAF04vL27ZSgs/gt.';

        $user = UserFactory::new([
            'username' => $username,
            'password' => $hashedPassword,
        ])->create()->_real();

        $client->loginUser($user);

        $this->assertTrue(true);
        $crawler = $client->request('POST', '/login', [
            'username' => $username,
            //            'password' => $plainTextPassword,
        ]);

        $this->assertResponseIsSuccessful();
        //        $this->assertSelectorTextContains('h1', 'Hello World');
    }
}

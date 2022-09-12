<?php

declare(strict_types=1);

namespace App\Tests\Form\Type;

use App\Dto\UserDto;
use App\Form\Type\RegistrationFormType;
use Symfony\Component\Form\Test\TypeTestCase;

final class RegistrationFormTypeTest extends TypeTestCase
{
    public function testSubmitValidData()
    {
        $formData = [
            'email' => 'testuser@example.com',
            'password' => [
                'first' => 'test',
                'second' => 'test'
            ]
        ];

        $model = new UserDto();
        $form = $this->factory->create(RegistrationFormType::class, $model);

        $expectedModel = new UserDto();
        $expectedModel->setEmail($formData['email']);
        $expectedModel->setPassword($formData['password']['first']);

        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($expectedModel, $model);
    }
}
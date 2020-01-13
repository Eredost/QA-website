<?php


namespace App\Tests\Entity\Traits;


use Symfony\Component\Validator\ConstraintViolation;

trait AssertsTrait
{
    protected abstract function getEntity();

    /**
     * This method is used to test an object according to the validators which have
     * been attached to it and to display errors if it fails
     *
     * $this->assertHasErrors($user->setEmail('faux-email.fr'), 1);
     *
     * @param     $entity
     * @param int $number
     *
     * @return void
     */
    private function assertHasErrors($entity, int $number = 0): void
    {
        self::bootKernel();
        $errors = self::$container->get('validator')->validate($entity);
        $messages = [];

        /** @var ConstraintViolation $error */
        foreach ($errors as $error) {
            $messages[] = $error->getPropertyPath() . ' => ' . $error->getMessage() . PHP_EOL;
        }
        $this->assertCount($number, $errors, implode('', $messages));
    }
}

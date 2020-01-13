<?php


namespace App\Tests\Entity;


use App\Entity\Answer;
use App\Entity\Question;
use App\Entity\User;
use App\Tests\Entity\Traits\AssertsTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class AnswerTest extends KernelTestCase
{
    use AssertsTrait;

    private function getEntity()
    {
        return (new Answer())
            ->setContent('Placeholder content for test')
            ->setUser(new User())
            ->setQuestion(new Question())
        ;
    }

    public function testValidEntity()
    {
        $this->assertHasErrors($this->getEntity(), 0);
    }

    public function testInvalidBlankContent()
    {
        $this->assertHasErrors($this->getEntity()->setContent(''), 2);
    }

    public function testInvalidLengthContent()
    {
        $this->assertHasErrors($this->getEntity()->setContent('Hello'), 1);
    }

    public function testValidIsValidatedValue()
    {
        $this->assertHasErrors($this->getEntity()->setIsValidated(true), 0);
    }

    public function testValidIsEnableValue()
    {
        $this->assertHasErrors($this->getEntity()->setIsEnable(false), 0);
    }

    public function testInvalidBlankUser()
    {
        $this->assertHasErrors($this->getEntity()->setUser(null), 1);
    }

    public function testInvalidBlankQuestion()
    {
        $this->assertHasErrors($this->getEntity()->setQuestion(null), 1);
    }
}

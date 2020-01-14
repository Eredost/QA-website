<?php


namespace App\Tests\Entity;


use App\Entity\Question;
use App\Tests\Entity\Traits\AssertsTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class QuestionTest extends KernelTestCase
{
    use AssertsTrait;

    private function getEntity()
    {
        return (new Question())
            ->setTitle('Test title')
            ->setContent('Placeholder content for test')
        ;
    }

    public function testValidEntity()
    {
        $this->assertHasErrors($this->getEntity(), 0);
    }

    public function testInvalidBlankTitle()
    {
        $this->assertHasErrors($this->getEntity()->setTitle(''), 2);
    }

    public function testInvalidLengthTitle()
    {
        $this->assertHasErrors($this->getEntity()->setTitle('Ti'), 1);
        $this->assertHasErrors($this->getEntity()->setTitle('Pellentesque quis turpis nisi. Nulla facilisi. Sed dolor ligula, fringilla eget lacus eu, ullamcorper sollicitudin felis. Donec a augue ex. Vivamus condimentum risus non varius pharetra. Ut id tellus lacus. Aenean a congue lectus. Pellentesque vehicula ipsum urna. Nam sit amet orci nisi.'), 1);
    }

    public function testInvalidBlankContent()
    {
        $this->assertHasErrors($this->getEntity()->setContent(''), 2);
    }

    public function testInvalidLengthContent()
    {
        $this->assertHasErrors($this->getEntity()->setContent('Hello'), 1);
    }

    public function testInvalidNegativeVoteValue()
    {
        $this->assertHasErrors($this->getEntity()->setVotes(-1), 1);
    }

    public function testValidIsEnabledValue()
    {
        $this->assertHasErrors($this->getEntity()->setIsEnable(false), 0);
    }
}

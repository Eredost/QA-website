<?php


namespace App\Tests\Entity;


use App\Entity\User;
use App\Tests\Entity\Traits\AssertsTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserTest extends KernelTestCase
{
    use AssertsTrait;

    private function getEntity(): User
    {
        return (new User())
            ->setUsername('username')
            ->setPassword('password')
            ->setFirstname('Michaël')
            ->setLastname('Lastname')
            ->setGithub('https://github.com/Eredost')
        ;
    }

    public function testValidEntity()
    {
        $this->assertHasErrors($this->getEntity(), 0);
    }

    public function testInvalidBlankUsername()
    {
        $this->assertHasErrors($this->getEntity()->setUsername(''), 2);
    }

    public function testInvalidLengthUsername()
    {
        $this->assertHasErrors($this->getEntity()->setUsername('abc'), 1);
        $this->assertHasErrors($this->getEntity()->setUsername('123456789abcdefg'), 1);
    }

    public function testInvalidAlreadyUsedUsername()
    {
        $this->assertHasErrors($this->getEntity()->setUsername('moderator'), 1);
    }

    public function testInvalidBlankPassword()
    {
        $this->assertHasErrors($this->getEntity()->setPassword(''), 2);
    }

    public function testInvalidLengthPassword()
    {
        $this->assertHasErrors($this->getEntity()->setPassword('abc'), 1);
        $this->assertHasErrors($this->getEntity()->setPassword('123456789abcdefghij'), 1);
    }

    public function testValidBlankFirstName()
    {
        $this->assertHasErrors($this->getEntity()->setFirstname(''), 0);
        $this->assertHasErrors($this->getEntity()->setFirstname(null), 0);
    }

    public function testInvalidCharactersFirstName()
    {
        $this->assertHasErrors($this->getEntity()->setFirstname('Mi/p3'), 1);
    }

    public function testInvalidLengthFirstName()
    {
        $this->assertHasErrors($this->getEntity()->setFirstname('ab'), 1);
        $this->assertHasErrors($this->getEntity()->setFirstname('ababababababababababb'), 1);
    }

    public function testValidBlankLastName()
    {
        $this->assertHasErrors($this->getEntity()->setLastname(''), 0);
        $this->assertHasErrors($this->getEntity()->setLastname(null), 0);
    }

    public function testInvalidCharactersLastName()
    {
        $this->assertHasErrors($this->getEntity()->setLastname('Laup3k:'), 1);
    }

    public function testInvalidLengthLastName()
    {
        $this->assertHasErrors($this->getEntity()->setLastname('ab'), 1);
        $this->assertHasErrors($this->getEntity()->setLastname('ababababababababababab'), 1);
    }

    public function testValidBlankGithubLink()
    {
        $this->assertHasErrors($this->getEntity()->setGithub(''), 0);
        $this->assertHasErrors($this->getEntity()->setGithub(null), 0);
    }

    public function testValidRelativeGithubLink()
    {
        $this->assertHasErrors($this->getEntity()->setGithub('github.com/Eredost'), 0);
    }

    public function testInvalidGithubLink()
    {
        $this->assertHasErrors($this->getEntity()->setGithub('https://www.linkedin.com/in/michael-coutin/'), 1);
        $this->assertHasErrors($this->getEntity()->setGithub('Eredost github link'), 1);
    }

    public function testValidEnableValue()
    {
        $this->assertHasErrors($this->getEntity()->setIsEnable(false), 0);
    }
}

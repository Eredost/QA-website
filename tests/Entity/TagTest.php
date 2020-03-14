<?php


namespace App\Tests\Entity;


use App\Entity\Tag;
use App\Tests\Entity\Traits\AssertsTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TagTest extends KernelTestCase
{
    use AssertsTrait;

    private function getEntity()
    {
        return (new Tag())
            ->setName('Test')
            ->setBgColor('blue')
            ->setTextColor('#FFFFFF')
        ;
    }

    public function testValidEntity()
    {
        $this->assertHasErrors($this->getEntity(), 0);
    }

    public function testInvalidBlankName()
    {
        $this->assertHasErrors($this->getEntity()->setName(''), 2);
    }

    public function testInvalidLengthName()
    {
        $this->assertHasErrors($this->getEntity()->setName('Ab'), 1);
        $this->assertHasErrors($this->getEntity()->setName('Very very long tag name'), 1);
    }

    public function testInvalidBlankBgColor()
    {
        $this->assertHasErrors($this->getEntity()->setBgColor(''), 2);
    }

    public function testInvalidLengthBgColor()
    {
        $this->assertHasErrors($this->getEntity()->setBgColor('#00000000000000000000000000'), 1);
        $this->assertHasErrors($this->getEntity()->setBgColor('#0'), 1);
    }

    public function testInvalidBlankTextColor()
    {
        $this->assertHasErrors($this->getEntity()->setTextColor(''), 2);
    }

    public function testInvalidLengthTextColor()
    {
        $this->assertHasErrors($this->getEntity()->setTextColor('#00000000000000000000000000'), 1);
        $this->assertHasErrors($this->getEntity()->setTextColor('#0'), 1);

    }
}

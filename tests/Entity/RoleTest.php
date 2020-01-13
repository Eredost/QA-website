<?php


namespace App\Tests\Entity;


use App\Entity\Role;
use App\Tests\Entity\Traits\AssertsTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class RoleTest extends KernelTestCase
{
    use AssertsTrait;

    private function getEntity()
    {
        return (new Role())
            ->setName('ROLE_ADMIN')
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
        $this->assertHasErrors($this->getEntity()->setName('ROL'), 1);
        $this->assertHasErrors($this->getEntity()->setName('ROLE_ADMINISTRATOR_WITH_LITTLE_BIT_OF_SUPERADMINISTRATOR_POWER'), 1);
    }
}

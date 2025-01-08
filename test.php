<?php
require 'vendor/autoload.php';
use PHPUnit\Framework\TestCase;

require_once 'user.class.php';

class UserTest extends TestCase
{
    private $user;
    private $dbMock;

    protected function setUp(): void
    {
        $this->dbMock = $this->createMock(PDO::class);
        $this->user = new User($this->dbMock);
    }

    public function testUpdateSuccess()
    {
        $id = 1;
        $this->user->first_name = 'John';
        $this->user->middle_name = 'A';
        $this->user->last_name = 'Doe';
        $this->user->email = 'john.doe@example.com';
        $this->user->username = 'johndoe';
        $this->user->user_type = 'admin';
        $this->user->date_of_birth = '1990-01-01';
        $this->user->contact_num = '1234567890';

        $stmtMock = $this->createMock(PDOStatement::class);
        $stmtMock->expects($this->once())->method('execute')->willReturn(true);
        $stmtMock->expects($this->once())->method('rowCount')->willReturn(1);

        $this->dbMock->expects($this->once())->method('prepare')->willReturn($stmtMock);

        $result = $this->user->update($id);
        $this->assertTrue($result);
    }

    public function testUpdateNoChanges()
    {
        $id = 1;
        $this->user->first_name = 'John';
        $this->user->middle_name = 'A';
        $this->user->last_name = 'Doe';
        $this->user->email = 'john.doe@example.com';
        $this->user->username = 'johndoe';
        $this->user->user_type = 'admin';
        $this->user->date_of_birth = '1990-01-01';
        $this->user->contact_num = '1234567890';

        $stmtMock = $this->createMock(PDOStatement::class);
        $stmtMock->expects($this->once())->method('execute')->willReturn(true);
        $stmtMock->expects($this->once())->method('rowCount')->willReturn(0);

        $this->dbMock->expects($this->once())->method('prepare')->willReturn($stmtMock);

        $result = $this->user->update($id);
        $this->assertEquals("No changes were made.", $result);
    }

    public function testUpdateFailure()
    {
        $id = 1;
        $this->user->first_name = 'John';
        $this->user->middle_name = 'A';
        $this->user->last_name = 'Doe';
        $this->user->email = 'john.doe@example.com';
        $this->user->username = 'johndoe';
        $this->user->user_type = 'admin';
        $this->user->date_of_birth = '1990-01-01';
        $this->user->contact_num = '1234567890';

        $stmtMock = $this->createMock(PDOStatement::class);
        $stmtMock->expects($this->once())->method('execute')->willReturn(false);
        $stmtMock->expects($this->once())->method('errorInfo')->willReturn([null, null, 'Some error']);

        $this->dbMock->expects($this->once())->method('prepare')->willReturn($stmtMock);

        $result = $this->user->update($id);
        $this->assertEquals("Update failed: Some error", $result);
    }

    public function testUpdatePDOException()
    {
        $id = 1;
        $this->user->first_name = 'John';
        $this->user->middle_name = 'A';
        $this->user->last_name = 'Doe';
        $this->user->email = 'john.doe@example.com';
        $this->user->username = 'johndoe';
        $this->user->user_type = 'admin';
        $this->user->date_of_birth = '1990-01-01';
        $this->user->contact_num = '1234567890';

        $this->dbMock->expects($this->once())->method('prepare')->will($this->throwException(new PDOException('PDO error')));

        $result = $this->user->update($id);
        $this->assertEquals("PDO Exception: PDO error", $result);
    }
}
$tests=new UserTest();

$tests->testUpdateSuccess();
?>
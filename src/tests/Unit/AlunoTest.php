<?php

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../../app/Models/Aluno.php';

class AlunoTest extends TestCase
{
    /**
     * @var MockObject&PDO
     */
    private MockObject $pdo;

    /**
     * @var Aluno
     */
    private Aluno $aluno;

    protected function setUp(): void
    {
        $this->pdo = $this->createMock(PDO::class);
        $this->aluno = new Aluno();

        $reflection = new \ReflectionClass($this->aluno);
        $pdoProperty = $reflection->getProperty('pdo');
        $pdoProperty->setAccessible(true);
        $pdoProperty->setValue($this->aluno, $this->pdo);
    }

    public function testFindSuccess(): void
    {
        $id = 1;

        $stmt = $this->createMock(\PDOStatement::class);
        $stmt->expects($this->once())
            ->method('execute')
            ->with([$id]);
        $stmt->expects($this->once())
            ->method('fetch')
            ->willReturn(['id' => 1, 'nome' => 'Aluno 1']);

        $this->pdo->expects($this->once())
            ->method('prepare')
            ->willReturn($stmt);

        $result = $this->aluno->find($id);

        $this->assertEquals('Aluno 1', $result['nome']);
    }

    public function testCreateSuccess(): void
    {
        $data = [
            'nome' => 'Aluno 1',
            'data_nascimento' => '2000-01-01',
            'usuario' => 'usuario1'
        ];

        $stmt = $this->createMock(\PDOStatement::class);
        $stmt->expects($this->once())
            ->method('execute')
            ->with([$data['nome'], $data['data_nascimento'], $data['usuario']]);

        $this->pdo->expects($this->once())
            ->method('prepare')
            ->willReturn($stmt);

        $this->aluno->create($data);
    }

    public function testUpdateSuccess(): void
    {
        $id = 1;
        $data = [
            'nome' => 'Aluno 1 Updated',
            'data_nascimento' => '2000-01-01',
            'usuario' => 'usuario1'
        ];

        $stmt = $this->createMock(\PDOStatement::class);
        $stmt->expects($this->once())
            ->method('execute')
            ->with([$data['nome'], $data['data_nascimento'], $data['usuario'], $id]);

        $this->pdo->expects($this->once())
            ->method('prepare')
            ->willReturn($stmt);

        $this->aluno->update($id, $data);
    }

    public function testDeleteSuccess(): void
    {
        $id = 1;

        $stmt = $this->createMock(\PDOStatement::class);
        $stmt->expects($this->once())
            ->method('execute')
            ->with([$id]);

        $this->pdo->expects($this->once())
            ->method('prepare')
            ->willReturn($stmt);

        $this->aluno->delete($id);
    }

    public function testCountSuccess(): void
    {
        $stmt = $this->createMock(\PDOStatement::class);
        $stmt->expects($this->once())
            ->method('fetchColumn')
            ->willReturn(10);

        $this->pdo->expects($this->once())
            ->method('query')
            ->willReturn($stmt);

        $result = $this->aluno->count();

        $this->assertEquals(10, $result);
    }

    public function testCountByNameSuccess(): void
    {
        $name = 'Aluno';

        $stmt = $this->createMock(\PDOStatement::class);
        $stmt->expects($this->once())
            ->method('bindValue')
            ->with($this->equalTo(':name'), $this->equalTo('%' . $name . '%'), $this->equalTo(PDO::PARAM_STR));
        $stmt->expects($this->once())
            ->method('execute');
        $stmt->expects($this->once())
            ->method('fetchColumn')
            ->willReturn(5);

        $this->pdo->expects($this->once())
            ->method('prepare')
            ->willReturn($stmt);

        $result = $this->aluno->countByName($name);

        $this->assertEquals(5, $result);
    }

    public function testAllWithoutPaginationSuccess(): void
    {
        $stmt = $this->createMock(\PDOStatement::class);
        $stmt->expects($this->once())
             ->method('execute')
             ->willReturn(true);
        $stmt->expects($this->once())
             ->method('fetchAll')
             ->willReturn([
                 ['id' => 1, 'nome' => 'Aluno 1'],
                 ['id' => 2, 'nome' => 'Aluno 2']
             ]);
    
        $this->pdo->expects($this->once())
             ->method('prepare')
             ->willReturn($stmt);
    
        $result = $this->aluno->all();
    
        $this->assertCount(2, $result);
        $this->assertEquals('Aluno 1', $result[0]['nome']);
    }

    public function testValidateDataSuccess(): void
    {
        $data = [
            'nome' => 'Aluno 1',
            'data_nascimento' => '2000-01-01',
            'usuario' => 'usuario1'
        ];

        $reflection = new \ReflectionClass($this->aluno);
        $method = $reflection->getMethod('validateData');
        $method->setAccessible(true);

        $this->assertNull($method->invokeArgs(null, [$data]));
    }

    public function testValidateDataFailure(): void
    {
        $data = [
            'nome' => '',
            'data_nascimento' => '',
            'usuario' => ''
        ];

        $reflection = new \ReflectionClass($this->aluno);
        $method = $reflection->getMethod('validateData');
        $method->setAccessible(true);

        $this->expectException(Exception::class);
        $method->invokeArgs(null, [$data]);
    }
}
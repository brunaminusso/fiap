<?php

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../../app/Models/Turma.php';

class TurmaTest extends TestCase
{
     /**
     * @var MockObject&PDO
     */
    private MockObject $pdo;

    /**
     * @var Turma
     */
    private Turma $turma;

    protected function setUp(): void
    {
        $this->pdo = $this->createMock(PDO::class);
        $this->turma = new Turma($this->pdo);

        $reflection = new \ReflectionClass($this->turma);
        $pdoProperty = $reflection->getProperty('pdo');
        $pdoProperty->setAccessible(true);
        $pdoProperty->setValue($this->turma, $this->pdo);
    }

    public function testCountSuccess(): void
    {
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->expects($this->once())
             ->method('fetchColumn')
             ->willReturn(10);

        $this->pdo->expects($this->once())
             ->method('query')
             ->willReturn($stmt);

        $result = $this->turma->count();

        $this->assertEquals(10, $result);
    }

    public function testFindSuccess(): void
    {
        $id = 1;

        $stmt = $this->createMock(PDOStatement::class);
        $stmt->expects($this->once())
             ->method('execute')
             ->with([$id])
             ->willReturn(true);
        $stmt->expects($this->once())
             ->method('fetch')
             ->willReturn(['id' => 1, 'nome' => 'Turma 1']);

        $this->pdo->expects($this->once())
             ->method('prepare')
             ->willReturn($stmt);

        $result = $this->turma->find($id);

        $this->assertEquals('Turma 1', $result['nome']);
    }

    public function testCreateSuccess(): void
    {
        $data = [
            'nome' => 'Turma Nova',
            'descricao' => 'Descrição da nova turma',
            'tipo' => 'Tipo 1'
        ];

        $stmt = $this->createMock(PDOStatement::class);
        $stmt->expects($this->once())
             ->method('execute')
             ->with([$data['nome'], $data['descricao'], $data['tipo']])
             ->willReturn(true);

        $this->pdo->expects($this->once())
             ->method('prepare')
             ->willReturn($stmt);

        $this->turma->create($data);
    }

    public function testUpdateSuccess(): void
    {
        $id = 1;
        $data = [
            'nome' => 'Turma Atualizada',
            'descricao' => 'Descrição atualizada',
            'tipo' => 'Tipo 2'
        ];

        $stmt = $this->createMock(PDOStatement::class);
        $stmt->expects($this->once())
             ->method('execute')
             ->with([$data['nome'], $data['descricao'], $data['tipo'], $id])
             ->willReturn(true);

        $this->pdo->expects($this->once())
             ->method('prepare')
             ->willReturn($stmt);

        $this->turma->update($id, $data);
    }

    public function testDeleteSuccess(): void
    {
        $id = 1;

        $stmtExists = $this->createMock(PDOStatement::class);
        $stmtExists->expects($this->once())
                   ->method('fetchColumn')
                   ->willReturn(1);

        $stmtDelete = $this->createMock(PDOStatement::class);
        $stmtDelete->expects($this->once())
                   ->method('execute')
                   ->with([$id])
                   ->willReturn(true);

        $this->pdo->expects($this->exactly(2))
             ->method('prepare')
             ->will($this->onConsecutiveCalls($stmtExists, $stmtDelete));

        $this->turma->delete($id);
    }
}
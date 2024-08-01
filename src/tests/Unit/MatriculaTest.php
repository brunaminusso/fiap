<?php

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../../app/Models/Matricula.php';

class MatriculaTest extends TestCase
{
    /**
     * @var MockObject&PDO
     */
    private MockObject $pdo;

    /**
     * @var Matricula
     */
    private Matricula $matricula;

    protected function setUp(): void
    {
        $this->pdo = $this->createMock(PDO::class);
        $this->matricula = new Matricula();

        $reflection = new \ReflectionClass($this->matricula);
        $pdoProperty = $reflection->getProperty('pdo');
        $pdoProperty->setAccessible(true);
        $pdoProperty->setValue($this->matricula, $this->pdo);
    }

    public function testGetAllEnrollmentsSuccess(): void
    {
        $stmt = $this->createMock(\PDOStatement::class);
        $stmt->expects($this->once())
             ->method('execute')
             ->willReturn(true);
        $stmt->expects($this->once())
             ->method('fetchAll')
             ->willReturn([
                 ['matricula_id' => 1, 'aluno_nome' => 'Aluno 1', 'turma_nome' => 'Turma 1'],
                 ['matricula_id' => 2, 'aluno_nome' => 'Aluno 2', 'turma_nome' => 'Turma 2']
             ]);

        $this->pdo->expects($this->once())
             ->method('prepare')
             ->willReturn($stmt);

        $result = $this->matricula->getAllEnrollments();

        $this->assertCount(2, $result);
        $this->assertEquals('Aluno 1', $result[0]['aluno_nome']);
    }

    public function testGetTotalCountSuccess(): void
    {
        $stmt = $this->createMock(\PDOStatement::class);
        $stmt->expects($this->once())
             ->method('fetchColumn')
             ->willReturn(10);

        $this->pdo->expects($this->once())
             ->method('query')
             ->willReturn($stmt);

        $result = $this->matricula->getTotalCount();

        $this->assertEquals(10, $result);
    }

    public function testGetAllCoursesSuccess(): void
    {
        $stmt = $this->createMock(\PDOStatement::class);
        $stmt->expects($this->once())
             ->method('fetchAll')
             ->willReturn([
                 ['id' => 1, 'nome' => 'Turma 1'],
                 ['id' => 2, 'nome' => 'Turma 2']
             ]);

        $this->pdo->expects($this->once())
             ->method('query')
             ->willReturn($stmt);

        $result = $this->matricula->getAllCourses();

        $this->assertCount(2, $result);
        $this->assertEquals('Turma 1', $result[0]['nome']);
    }

    public function testEnrollmentExistsSuccess(): void
    {
        $alunoId = 1;
        $turmaId = 1;

        $stmt = $this->createMock(\PDOStatement::class);
        $stmt->expects($this->once())
             ->method('execute')
             ->with([$alunoId, $turmaId]);
        $stmt->expects($this->once())
             ->method('fetchColumn')
             ->willReturn(1);

        $this->pdo->expects($this->once())
             ->method('prepare')
             ->willReturn($stmt);

        $result = $this->matricula->enrollmentExists($alunoId, $turmaId);

        $this->assertTrue($result);
    }

    public function testDeleteEnrollmentSuccess(): void
    {
        $matriculaId = 1;

        $stmt = $this->createMock(\PDOStatement::class);
        $stmt->expects($this->once())
             ->method('execute')
             ->with([$matriculaId]);

        $this->pdo->expects($this->once())
             ->method('prepare')
             ->willReturn($stmt);

        $this->matricula->deleteEnrollment($matriculaId);
    }
}
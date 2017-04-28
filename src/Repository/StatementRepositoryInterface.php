<?php
declare(strict_types = 1);
namespace Financas\Repository;

interface StatementRepositoryInterface
{
    public function all(string $dateStart, $dateEnd, int $userId): array;
}
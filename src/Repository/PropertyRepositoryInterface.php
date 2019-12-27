<?php
declare(strict_types=1);

namespace App\Repository;

use App\Model\Property;

interface PropertyRepositoryInterface {
	public function findAll(): array;
	public function findPropertyOfUuid(string $uuid): ?Property;
	public  function retrieveOneFromDB(array $result): ?Property;
  public static function getFromDBRowObject(object $row): ?Property;
}

<?php
declare(strict_types=1);

namespace App\Repository;
use App\Model\PropertyType;

interface PropertyTypeRepositoryInterface {
	public function findAll(): array;
	public function findPropertyTypeOfId(int $id): ?PropertyType;
	public  function retrieveOneFromDB(object $result): ?PropertyType;
    public static function getFromDBRowObject(object $row): ?PropertyType;
}

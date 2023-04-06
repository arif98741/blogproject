<?php

namespace App\Helper;

use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;

class Status
{
    public const STATUS_INACTIVE = 0;
    public const STATUS_ACTIVE = 1;
    public const STATUS_PENDING = 2;
    public const STATUS_DELETED = 3;
    public const STATUS_DRAFT = 4;
    public const STATUS_REMOVED = 5;
    public const STATUS_NEED_MODIFICATION = 6;
    public const STATUS_PUBLISHED = 6;


    /**
     * @throws Exception
     */
    public static function getStatusName($status): bool|int|string
    {
        $statusArray = self::getStatusArray();

        if (in_array($status, $statusArray, true)) {
            return array_search($status, $statusArray, true);
        }
        throw new \RuntimeException("$status is not a valid status for Bulksms project");
    }

    /**
     * @return mixed
     */
    public static function getStatusArray(): mixed
    {
        return Config::get('app-config.post_status');
    }

    /**
     * @param array $filteredArrayValues
     * @return array
     */
    public static function getSelectedStatuses(array $filteredArrayValues = []): array
    {
        $statuses = self::getStatusArray();
        $searched_array = [];
        foreach ($filteredArrayValues as $value) {

            $key = array_search($value, $statuses);
            $searched_array[$key] = $value;
        }

        return $searched_array;
    }

    /**
     * @return Collection
     */
    public static function getStatusCollection(): Collection
    {
        return collect(Config::get('post_status.status'));
    }

    public static function getStatusIds()
    {
        return array_values(self::getStatusArray());
    }

    public static function getStatusNames()
    {
        return array_keys(self::getStatusArray());
    }

}

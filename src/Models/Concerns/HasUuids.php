<?php

namespace Irimold\LaravelCore\Models\Concerns;

use Illuminate\Database\Eloquent\Concerns\HasUniqueStringIds;
use Illuminate\Support\Str;
use Irimold\LaravelCore\Helpers\Uuid;

trait HasUuids
{
    use HasUniqueStringIds;

     /**
     * Generate a new UUID for the model.
     *
     * @return string
     */
    public function newUniqueId()
    {
        $counter = static::count();
        return (string) Uuid::generate($counter);
    }

    /**
     * Determine if given key is valid.
     *
     * @param  mixed  $value
     * @return bool
     */
    protected function isValidUniqueId($value): bool
    {
        return Str::isUuid($value);
    }
}
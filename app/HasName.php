<?php
namespace App;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;

trait HasName
{
    public static function findFromName(string $name): self
    {
        return self::whereName($name)->firstOrFail();
    }

    public static function findOrCreate(string $name, string $description = ""): self
    {
        try {
            return self::findFromName($name);
        } catch (ModelNotFoundException $e) {
            return self::create(compact('name'));
        }
    }

    public static function wrap($name): self
    {
        if (is_string($name)) {
            $name = self::findOrCreate($name);
        }

        if (is_array($name)) {
            $name = self::firstOrCreate($name);
        }

        if (! $name instanceof self) {
            throw new \InvalidArgumentException("\$name should be string, array, or " . self::class);
        }

        return $name;
    }

    public static function fromArray(array $array): Collection
    {
        return (new Collection($array))->map(fn($item) => self::wrap($item));
    }
}

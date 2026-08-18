<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['group', 'key', 'value', 'type', 'is_public'];

    protected function casts(): array
    {
        return ['is_public' => 'boolean'];
    }

    public function getTypedValueAttribute(): mixed
    {
        return match ($this->type) {
            'bool'      => filter_var($this->value, FILTER_VALIDATE_BOOL),
            'int'       => (int) $this->value,
            'json'      => json_decode((string) $this->value, true),
            'encrypted' => blank($this->value) ? null : decrypt($this->value),
            default     => $this->value,
        };
    }
}

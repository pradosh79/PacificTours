<?php

declare(strict_types=1);

namespace App\DTOs;

use App\Enums\TravelerType;

final class TravelerData extends BaseData
{
    public function __construct(
        public readonly TravelerType $type,
        public readonly string $firstName,
        public readonly ?string $lastName = null,
        public readonly ?string $dateOfBirth = null,
        public readonly ?string $gender = null,
        public readonly ?string $nationality = null,
        public readonly ?string $passportNumber = null,
        public readonly ?string $passportExpiry = null,
        public readonly ?string $dietaryRequirement = null,
        public readonly ?string $specialRequest = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            type: TravelerType::from($data['type'] ?? 'adult'),
            firstName: $data['first_name'],
            lastName: $data['last_name'] ?? null,
            dateOfBirth: $data['date_of_birth'] ?? null,
            gender: $data['gender'] ?? null,
            nationality: $data['nationality'] ?? null,
            passportNumber: $data['passport_number'] ?? null,
            passportExpiry: $data['passport_expiry'] ?? null,
            dietaryRequirement: $data['dietary_requirement'] ?? null,
            specialRequest: $data['special_request'] ?? null,
        );
    }

    public function toModelArray(): array
    {
        return [
            'type'                => $this->type->value,
            'first_name'          => $this->firstName,
            'last_name'           => $this->lastName,
            'date_of_birth'       => $this->dateOfBirth,
            'gender'              => $this->gender,
            'nationality'         => $this->nationality,
            'passport_number'     => $this->passportNumber,
            'passport_expiry'     => $this->passportExpiry,
            'dietary_requirement' => $this->dietaryRequirement,
            'special_request'     => $this->specialRequest,
        ];
    }
}

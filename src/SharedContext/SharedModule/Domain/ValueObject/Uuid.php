<?php

declare(strict_types=1);

namespace Signaturit\LobbyWarsChallenge\SharedContext\SharedModule\Domain\ValueObject;

use Signaturit\LobbyWarsChallenge\SharedContext\SharedModule\Domain\Exception\InvalidUuidException;

final class Uuid extends ValueObject
{
    private const UUID_REGEX = '/^[0-9A-F]{8}-[0-9A-F]{4}-4[0-9A-F]{3}-[89AB][0-9A-F]{3}-[0-9A-F]{12}$/i';

    public function __construct(public readonly string $value)
    {
        parent::__construct();
    }

    public function validate(): void
    {
        if (!preg_match(self::UUID_REGEX, $this->value)) {
            throw InvalidUuidException::byValue($this->value);
        }
    }

    public static function v4(): self
    {
        $data = random_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

        return new self(vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4)));
    }

    public function __toString(): string
    {
        return $this->value;
    }
}

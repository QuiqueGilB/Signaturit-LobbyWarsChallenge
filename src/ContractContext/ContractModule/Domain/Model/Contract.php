<?php

namespace Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Domain\Model;

use DateTimeImmutable;
use Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Domain\Event\ContractCreatedEvent;
use Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Domain\Event\ContractUpdatedEvent;
use Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Domain\Event\ContractWonEvent;
use Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Domain\Exception\ContractAlreadyHasWinnerException;
use Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Domain\Exception\MinContractParticipantsException;
use Signaturit\LobbyWarsChallenge\SharedContext\SharedModule\Domain\Model\AggregateRoot;
use Signaturit\LobbyWarsChallenge\SharedContext\SharedModule\Domain\ValueObject\Uuid;

class Contract extends AggregateRoot
{
    /** @var Participant[] */
    private array $participants;
    private ?Participant $winner;

    public function __construct(Uuid $id, Participant ...$participants)
    {
        parent::__construct($id);
        $this->doUpdate(null, ...$participants);
        $this->record(new ContractCreatedEvent($this));
    }

    public function hasWinner(): bool
    {
        return !is_null($this->winner);
    }

    public function participants(): array
    {
        return $this->participants;
    }

    public function winner(): ?Participant
    {
        return $this->winner;
    }

    public function put(?Participant $winner, Participant ...$participants): void
    {
        $isANewWinner = $winner?->id() !== $this->winner?->id();
        $this->doUpdate($winner, ...$participants);
        $this->record(new ContractUpdatedEvent($this));
        $isANewWinner && $this->record(new ContractWonEvent($this));
    }

    /** @param Participant[] $participants */
    public function patch(Participant $winner = null, array $participants = null): void
    {
        $this->put(
            $winner ?? $this->winner,
            ...($participants ?? $this->participants ?? [])
        );
    }

    private function doUpdate(?Participant $winner, Participant ...$participants): void
    {
        $this->validateNewWinner($winner);
        $this->validateParticipants(...$participants);
        $this->winner = $winner;
        $this->participants = $participants;
        $this->updatedAt = new DateTimeImmutable();
    }

    private function validateNewWinner(?Participant $winner): void
    {
        if (is_null($this->winner) || $this->winner === $winner) {
            return;
        }

        throw ContractAlreadyHasWinnerException::hasAlready($this->id);
    }

    private function validateParticipants(Participant ...$participants)
    {
        $minRequired = 2;
        count($participants) < $minRequired && throw MinContractParticipantsException::byId($this->id, $minRequired);
    }
}

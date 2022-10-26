<?php

declare(strict_types=1);

namespace Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Application\Query\FindContractParticipants;

use Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Domain\Model\Participant;
use Signaturit\LobbyWarsChallenge\ContractContext\SharedModule\Domain\Data\ParticipantData;
use Signaturit\LobbyWarsChallenge\SharedContext\CqrsModule\Domain\Model\ArrayQueryData;

/** @property ParticipantData[] $array */
class FindContractParticipantsQueryResponseData extends ArrayQueryData
{
    /** @param Participant[] $participants */
    public function __construct(array $participants)
    {
        parent::__construct(array_map(static function (Participant $participant): ParticipantData {
            return new ParticipantData($participant->id(), $participant->signatures(), $participant->signaturesToWin());
        }, $participants));
    }
}

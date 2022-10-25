<?php

declare(strict_types=1);

namespace Signaturit\LobbyWarsChallenge\Tests\Unit\src\ContractContext\ContractModule\Application\Command\ResolveContractWinner;

use PHPUnit\Framework\MockObject\MockObject;
use Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Application\Command\ResolveContractWinner\ResolveContractWinnerCommand;
use Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Application\Command\ResolveContractWinner\ResolveContractWinnerCommandHandler;
use Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Domain\Contract\ContractRepository;
use Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Domain\Event\ContractUpdatedEvent;
use Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Domain\Event\ContractWonEvent;
use Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Domain\Exception\CanNotResolveContractWinnerException;
use Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Domain\Exception\ContractAlreadyHasWinnerException;
use Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Domain\Exception\ContractNotFoundException;
use Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Domain\Model\Contract;
use Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Domain\Model\Participant;
use Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Domain\Service\ResolveSignatureScoresService;
use Signaturit\LobbyWarsChallenge\ContractContext\SharedModule\Domain\ValueObject\Signature;
use Signaturit\LobbyWarsChallenge\SharedContext\EventSourcingModule\Domain\Service\EventCollector;
use Signaturit\LobbyWarsChallenge\SharedContext\SharedModule\Domain\ValueObject\Uuid;
use Signaturit\LobbyWarsChallenge\Tests\Shared\BaseUnitTest;
use Signaturit\LobbyWarsChallenge\Tests\Shared\Stub\src\ContractContext\ContractModule\Domain\Model\ContractStub;
use Signaturit\LobbyWarsChallenge\Tests\Shared\Stub\src\ContractContext\ContractModule\Domain\Model\ParticipantStub;

class ResolveContractWinnerCommandHandlerTest extends BaseUnitTest
{
    private ContractRepository & MockObject $contractRepositoryMock;
    private ResolveSignatureScoresService & MockObject $resolveSignatureScoreServiceMock;
    private ResolveContractWinnerCommandHandler $resolveContractWinnerCommandHandler;

    protected function setUp(): void
    {
        parent::setUp();
        $this->contractRepositoryMock = $this->createMock(ContractRepository::class);
        $this->resolveSignatureScoreServiceMock = $this->createMock(ResolveSignatureScoresService::class);
        $this->resolveContractWinnerCommandHandler = new ResolveContractWinnerCommandHandler(
            $this->contractRepositoryMock,
            $this->resolveSignatureScoreServiceMock
        );
    }

    /** @dataProvider stage */
    public function testExceptionIfContractNotFound(ResolveContractWinnerCommand $command, ?Contract $contract): void
    {
        $this->prepareStage(...func_get_args());
        $capsule = self::callIgnoringErrors($this->resolveContractWinnerCommandHandler, $command);
        is_null($contract)
            ? $this->assertInstanceOf(ContractNotFoundException::class, $capsule->throwable)
            : $this->expectNotToPerformAssertions();
    }

    /** @dataProvider stage */
    public function testAlreadyHasWinner(ResolveContractWinnerCommand $command, ?Contract $contract): void
    {
        $this->prepareStage(...func_get_args());
        $hasWinnerBeforeCase = $contract?->hasWinner() ?? false;
        $capsule = self::callIgnoringErrors($this->resolveContractWinnerCommandHandler, $command);
        $hasWinnerBeforeCase
            ? self::assertInstanceOf(ContractAlreadyHasWinnerException::class, $capsule->throwable)
            : $this->expectNotToPerformAssertions();

    }


    /** @dataProvider stage */
    public function testUpdateParticipantScore(ResolveContractWinnerCommand $command, ?Contract $contract): void
    {
        $this->prepareStage(...func_get_args());
        $contract || $this->expectNotToPerformAssertions();
        $hasWinnerBeforeCase = $contract?->hasWinner() ?? false;
        $hasWinnerBeforeCase && $this->expectNotToPerformAssertions();
        empty($contract?->participants()) && $this->expectNotToPerformAssertions();

        self::callIgnoringErrors($this->resolveContractWinnerCommandHandler, $command);
        if (!$contract || $hasWinnerBeforeCase) {
            return;
        }
        foreach ($contract->participants() ?? [] as $participant) {
            self::assertIsInt($participant->score());
        }
    }

    /** @dataProvider stage */
    public function testNewContractWinner(ResolveContractWinnerCommand $command, ?Contract $contract): void
    {
        $this->prepareStage(...func_get_args());
        $contract || $this->expectNotToPerformAssertions();
        $hasWinnerBeforeCase = $contract?->hasWinner() ?? false;
        $hasWinnerBeforeCase && $this->expectNotToPerformAssertions();

        $capsule = self::callIgnoringErrors($this->resolveContractWinnerCommandHandler, $command);

        if (!$contract || $hasWinnerBeforeCase) {
            return;
        }

        empty($contract->participants()) && $this->assertInstanceOf(
            CanNotResolveContractWinnerException::class,
            $capsule->throwable
        );

        $winners = $this->winners($contract);
        1 === count($winners)
            ? self::assertEquals($winners[0], $contract->winner())
            : $this->assertInstanceOf(CanNotResolveContractWinnerException::class, $capsule->throwable);
    }

    /** @dataProvider stage */
    public function testSaveContract(ResolveContractWinnerCommand $command, ?Contract $contract): void
    {
        $this->prepareStage(...func_get_args());
        $this->contractRepositoryMock
            ->expects($this->isHappyPath($contract) ? self::once() : self::never())
            ->method('save')
            ->with($contract);

        self::callIgnoringErrors($this->resolveContractWinnerCommandHandler, $command);
    }


    /** @dataProvider stage */
    public function testPublishDomainEvents(ResolveContractWinnerCommand $command, ?Contract $contract): void
    {
        $this->prepareStage(...func_get_args());
        self::callIgnoringErrors($this->resolveContractWinnerCommandHandler, $command);
        $events = EventCollector::instance()->pull();
        $isHappyPath = $this->isHappyPath($contract);

        $isHappyPath || self::assertEmpty($events);
        if ($isHappyPath) {
            self::assertContainsOnly(ContractWonEvent::class, $events);
            self::assertContainsOnly(ContractUpdatedEvent::class, $events);
        }
    }

    private function prepareStage(ResolveContractWinnerCommand $command, ?Contract $contract): void
    {
        $this->contractRepositoryMock
            ->method('byId')
            ->with($command->contractId)
            ->willReturn($contract);

        $this->resolveSignatureScoreServiceMock
            ->method('acumulate')
            ->willReturnCallback(fn(Signature ...$signatures) => count($signatures));
    }

    public function stage(): iterable
    {
        $contractStub = new ContractStub();
        $participantStub = new ParticipantStub();

        yield 'not found' => [new ResolveContractWinnerCommand(Uuid::v4()), null];
        yield 'already has winner' => [
            new ResolveContractWinnerCommand($uuid = Uuid::v4()),
            $contractStub->withId($uuid)
                ->withWinner($winner = $participantStub->stub())
                ->withParticipants([$winner])
                ->stub()
        ];
        yield 'without participants' => [
            new ResolveContractWinnerCommand($uuid = Uuid::v4()),
            $contractStub->withId($uuid)
                ->withWinner(null)
                ->withParticipants([])
                ->stub()
        ];
        yield 'many winners' => [
            new ResolveContractWinnerCommand($uuid = Uuid::v4()),
            $contractStub->withId($uuid)
                ->withWinner(null)
                ->withParticipants([
                    $participantStub->withSignatures([Signature::King])->stub(),
                    $participantStub->withSignatures([Signature::King])->stub()
                ])
                ->stub()
        ];
        yield 'one winner' => [
            new ResolveContractWinnerCommand($uuid = Uuid::v4()),
            $contractStub->withId($uuid)
                ->withWinner(null)
                ->withParticipants([
                    $participantStub->withSignatures([Signature::Notary])->stub(),
                    $participantStub->withSignatures([Signature::King, Signature::King])->stub()
                ])
                ->stub()
        ];
    }

    private function isHappyPath(?Contract $contract): bool
    {
        if (is_null($contract) || $contract->hasWinner() || empty($contract->participants())) {
            return false;
        }
        return 1 === count($this->winners($contract));
    }

    /** @return Participant[] */
    private function winners(?Contract $contract): array
    {
        $participants = $contract?->participants() ?? [];
        if (empty($participants)) {
            return [];
        }

        $maxScore = max(array_map(
            function (Participant $participant): int {
                return $this->resolveSignatureScoreServiceMock->acumulate(...$participant->signatures());
            },
            $participants
        ));
        return array_values(array_filter(
            $participants,
            static fn($participant) => $participant->score() === $maxScore
        ));
    }
}

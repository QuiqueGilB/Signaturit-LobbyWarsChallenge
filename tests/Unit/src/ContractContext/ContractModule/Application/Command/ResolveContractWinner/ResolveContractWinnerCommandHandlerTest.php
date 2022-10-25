<?php

namespace Signaturit\LobbyWarsChallenge\Tests\Unit\src\ContractContext\ContractModule\Application\Command\ResolveContractWinner;

use PHPUnit\Framework\MockObject\MockObject;
use Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Application\Command\ResolveContractWinner\ResolveContractWinnerCommand;
use Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Application\Command\ResolveContractWinner\ResolveContractWinnerCommandHandler;
use Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Domain\Contract\ContractRepository;
use Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Domain\Exception\ContractNotFoundException;
use Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Domain\Model\Contract;
use Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Domain\Model\Participant;
use Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Domain\Service\ResolveSignatureScoresService;
use Signaturit\LobbyWarsChallenge\ContractContext\SharedModule\Domain\ValueObject\Signature;
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
        $contract || $this->assertInstanceOf(ContractNotFoundException::class, $capsule->throwable);
    }


    /** @dataProvider stage */
    public function testUpdateParticipantScore(ResolveContractWinnerCommand $command, ?Contract $contract): void
    {

    }


    /** @dataProvider stage */
    public function testNewContractWinner(ResolveContractWinnerCommand $command, ?Contract $contract): void
    {

    }


    /** @dataProvider stage */
    public function testSaveContract(ResolveContractWinnerCommand $command, ?Contract $contract): void
    {
        $this->prepareStage(...func_get_args());
        self::callIgnoringErrors($this->resolveContractWinnerCommandHandler, $command);
        $contract && $this->contractRepositoryMock->expects(self::once())->method('save')->with($contract);
    }


    /** @dataProvider stage */
    public function testPublishDomainEvents(ResolveContractWinnerCommand $command, ?Contract $contract): void
    {

    }

    private function prepareStage(ResolveContractWinnerCommand $command, ?Contract $contract): void
    {
        $this->contractRepositoryMock
            ->expects(self::once())
            ->method('byId')
            ->with($command->contractId)
            ->willReturn($contract);

        $contract && $this->resolveSignatureScoreServiceMock
            ->method('acumulate')
            ->willReturnCallback(fn(Signature ...$signatures) => prinr_r($signatures) && count($signatures));
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

}

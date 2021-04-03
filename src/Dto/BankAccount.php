<?php declare(strict_types=1);

namespace TheTahitianPearl\Collector\Dto;

use InvalidArgumentException;
use LogicException;
use PHP_IBAN\IBAN;

class BankAccount
{
    public const IBAN_FORMAT_HUMAN = 'human';
    public const IBAN_FORMAT_MACHINE = 'machine';
    public const IBAN_FORMAT_OBFUSCATED = 'obfuscated';

    public const IBAN_FORMATS = [
      self::IBAN_FORMAT_HUMAN,
      self::IBAN_FORMAT_MACHINE,
      self::IBAN_FORMAT_OBFUSCATED,
    ];

    private IBAN $iban;

    private bool $isVerified = false;

    private string $country = '';

    private string $account = '';

    private string $bank = '';

    private string $branch = '';

    private string $bban = '';

    private string $checksum = '';

    private string $nationalChecksum = '';

    final public function getIban(string $format = self::IBAN_FORMAT_HUMAN): IBAN | string
    {
        if (!in_array($format, self::IBAN_FORMATS, true)) {
            throw new InvalidArgumentException('Unsupported format given');
        }

        return match ($format) {
            self::IBAN_FORMAT_MACHINE => $this->iban->MachineFormat(),
            self::IBAN_FORMAT_OBFUSCATED => $this->iban->ObfuscatedFormat(),
            default => $this->iban->HumanFormat()
        };
    }

    final public function setBankAccountByIban(string $iban): BankAccount
    {
        if (empty($iban)) {
            throw new LogicException('Iban should not be empty');
        }

        $this->iban = New IBAN($iban);
        $this->iban->Verify($iban) ? $this->isVerified = true : $this->isVerified = false;

        $parts = $this->iban->Parts();

        $this->country = $parts['country'] !== false ? $parts['country']  : '';
        $this->account = $parts['account'] !== false ? $parts['account'] : '';
        $this->bank = $parts['bank'] !== false ? $parts['bank'] : '';
        $this->bban = $parts['bban'] !== false ? $parts['bban'] : '';
        $this->branch = $parts['branch'] !== false ? $parts['branch'] : '';
        $this->checksum = $parts['checksum'] !== false ? $parts['checksum'] : '';
        $this->nationalChecksum = $parts['nationalchecksum'] !== false ? $parts['nationalchecksum'] : '';

        return $this;
    }

    final public function isVerified(): bool
    {
        return $this->isVerified;
    }

    final public function getCountry(): string
    {
        return $this->country;
    }

    final public function getAccount(): string
    {
        return $this->account;
    }

    final public function getBank(): string
    {
        return $this->bank;
    }

    final public function getBranch(): string
    {
        return $this->branch;
    }

    final public function getBban(): string
    {
        return $this->bban;
    }

    final public function getChecksum(): string
    {
        return $this->checksum;
    }

    final public function getNationalChecksum(): string
    {
        return $this->nationalChecksum;
    }
}
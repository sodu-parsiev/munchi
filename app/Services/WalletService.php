<?php

namespace App\Services;

use App\Models\Wallet;
use App\Models\WalletTransaction;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;
use RuntimeException;

class WalletService
{
    public function credit(Wallet $wallet, float $amount, array $metadata = []): WalletTransaction
    {
        return $this->recordTransaction($wallet, 'credit', $amount, $metadata);
    }

    public function debit(Wallet $wallet, float $amount, array $metadata = []): WalletTransaction
    {
        return $this->recordTransaction($wallet, 'debit', $amount, $metadata);
    }

    protected function recordTransaction(
        Wallet $wallet,
        string $type,
        float $amount,
        array $metadata = []
    ): WalletTransaction {
        if ($amount <= 0) {
            throw new InvalidArgumentException('Amount must be greater than zero.');
        }

        if (! in_array($type, ['credit', 'debit'], true)) {
            throw new InvalidArgumentException('Transaction type must be credit or debit.');
        }

        return DB::transaction(function () use ($wallet, $type, $amount, $metadata) {
            $lockedWallet = $wallet->newQuery()->lockForUpdate()->findOrFail($wallet->id);
            $currentBalance = (float) $lockedWallet->balance;
            $amountValue = round($amount, 2);

            if ($type === 'debit' && $currentBalance < $amountValue) {
                throw new RuntimeException('Insufficient wallet balance.');
            }

            $newBalance = $type === 'credit'
                ? $currentBalance + $amountValue
                : $currentBalance - $amountValue;

            $lockedWallet->balance = round($newBalance, 2);
            $lockedWallet->save();

            $transaction = $lockedWallet->transactions()->create([
                'type' => $type,
                'amount' => $amountValue,
                'metadata' => $metadata,
            ]);

            $wallet->balance = $lockedWallet->balance;

            return $transaction;
        });
    }
}

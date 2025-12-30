<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;
use RuntimeException;

class Wallet extends Model
{
    /** @use HasFactory<\Database\Factories\WalletFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'balance',
    ];

    protected $casts = [
        'balance' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(WalletTransaction::class);
    }

    public function credit(float $amount, array $metadata = []): WalletTransaction
    {
        return $this->recordTransaction('credit', $amount, $metadata);
    }

    public function debit(float $amount, array $metadata = []): WalletTransaction
    {
        return $this->recordTransaction('debit', $amount, $metadata);
    }

    protected function recordTransaction(string $type, float $amount, array $metadata = []): WalletTransaction
    {
        if ($amount <= 0) {
            throw new InvalidArgumentException('Amount must be greater than zero.');
        }

        if (! in_array($type, ['credit', 'debit'], true)) {
            throw new InvalidArgumentException('Transaction type must be credit or debit.');
        }

        return DB::transaction(function () use ($type, $amount, $metadata) {
            $wallet = $this->newQuery()->lockForUpdate()->findOrFail($this->id);
            $currentBalance = (float) $wallet->balance;
            $amountValue = round($amount, 2);

            if ($type === 'debit' && $currentBalance < $amountValue) {
                throw new RuntimeException('Insufficient wallet balance.');
            }

            $newBalance = $type === 'credit'
                ? $currentBalance + $amountValue
                : $currentBalance - $amountValue;

            $wallet->balance = round($newBalance, 2);
            $wallet->save();

            $transaction = $wallet->transactions()->create([
                'type' => $type,
                'amount' => $amountValue,
                'metadata' => $metadata,
            ]);

            $this->balance = $wallet->balance;

            return $transaction;
        });
    }
}

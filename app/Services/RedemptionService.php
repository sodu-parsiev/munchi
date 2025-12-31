<?php

namespace App\Services;

use App\Models\Redemption;
use App\Models\RewardVariant;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class RedemptionService
{
    public function redeem(
        User $user,
        RewardVariant $rewardVariant,
        float $pointsSpent,
        string $status = 'pending',
        ?string $externalReference = null
    ): Redemption {
        if ($pointsSpent <= 0) {
            throw new RuntimeException('Points spent must be greater than zero.');
        }

        $wallet = $user->wallet;

        if (! $wallet) {
            throw new RuntimeException('User does not have an active wallet.');
        }

        return DB::transaction(function () use ($wallet, $user, $rewardVariant, $pointsSpent, $status, $externalReference) {
            $lockedWallet = $this->lockWallet($wallet);
            $currentBalance = (float) $lockedWallet->balance;
            $amount = round($pointsSpent, 2);

            if ($currentBalance < $amount) {
                throw new RuntimeException('Insufficient wallet balance.');
            }

            $lockedWallet->balance = round($currentBalance - $amount, 2);
            $lockedWallet->save();

            $lockedWallet->transactions()->create([
                'type' => 'debit',
                'amount' => $amount,
                'metadata' => [
                    'reward_variant_id' => $rewardVariant->id,
                    'external_reference' => $externalReference,
                ],
            ]);

            $wallet->balance = $lockedWallet->balance;

            return Redemption::create([
                'user_id' => $user->id,
                'reward_variant_id' => $rewardVariant->id,
                'points_spent' => $amount,
                'status' => $status,
                'external_reference' => $externalReference,
            ]);
        });
    }

    protected function lockWallet(Wallet $wallet): Wallet
    {
        return $wallet->newQuery()->lockForUpdate()->findOrFail($wallet->id);
    }
}

<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

class SubscriptionPlan extends Model
{
    protected string $table = 'subscription_plans';
    protected bool $tenantScoped = false; // Subscription plans are global master data managed by Super Admin

    public function findByKey(string $key): ?array
    {
        return $this->findOneWhere('plan_key', $key);
    }
}

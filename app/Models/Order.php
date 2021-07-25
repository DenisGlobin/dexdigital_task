<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Order
{
    public static function update(string $status, int $id): bool
    {
        $date = now();

        $affected = DB::table('orders')
            ->updateOrInsert(
                ['id' => $id],
                ['status' => $status, 'created_at' => $date, 'updated_at' => $date]
            );

        return $affected > 0;
    }
}

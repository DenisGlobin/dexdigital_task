<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    use HasFactory;

    protected $attributes = [
        'status' => 'pending'
    ];
//
//    public static function updateStatusById(string $status, int $id): bool
//    {
//        /** @var Order $order */
//        $order = self::findOrFail($id);
//        $order->status = $status;
//
//        return $order->save();
//    }
    public function updateStatus(string $status): bool
    {
        $this->status = $status;

        return $this->save();
    }

//    public static function update(array $data, int $id): bool
//    {
//        $order = DB::table('orders')->find($id);
//        if (empty($order)) {
//            throw new \LogicException('Order not found');
//        }
//
//        $affected = DB::table('orders')
//            ->where('id', $id)
//            ->update(['status' => $data['status']]);
//
//        return $affected > 0;
//    }
}

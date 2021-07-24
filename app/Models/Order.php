<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //use HasFactory;

    public function updateStatus(string $status): bool
    {
        $this->status = $status;

        return $this->save();
    }
}

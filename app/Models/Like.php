<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class Like extends Pivot
{
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function proposta()
    {
        return $this->belongsTo(Proposta::class, 'proposta_id');
    }

}

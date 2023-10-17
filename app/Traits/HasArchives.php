<?php

namespace App\Traits;

use App\Models\Archive;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

trait HasArchives
{
    public function archive(): BelongsTo
    {
        return $this->belongsTo(Archive::class);
    }
}

?>

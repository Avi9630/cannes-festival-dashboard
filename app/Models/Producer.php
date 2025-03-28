<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Producer extends Model
{
    protected  $table   =   'producers';
    protected $guarded  =   [];

    public function featureDocuments(): HasMany
    {
        return $this->hasMany(Document::class, 'context_id', 'id')->where(['form_type' => 1, 'document_type' => 5, 'website_type' => 5]);
    }

    public function nonFeatureDocuments(): HasMany
    {
        return $this->hasMany(Document::class, 'context_id', 'id')->where(['form_type' => 2, 'document_type' => 5, 'website_type' => 5]);
    }
}

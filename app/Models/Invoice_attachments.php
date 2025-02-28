<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice_attachments extends Model
{
    use HasFactory;
    protected $table = 'invoice_attachments';

    protected $fillable = [
        'file_name',
        'invoice_number',
        'created_by',
        'invoice_id',
    ];

    
}

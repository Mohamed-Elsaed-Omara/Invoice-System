<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;


class Invoice extends Model
{
    use HasFactory;
    use SoftDeletes;

    const PAID = 1 ;
    const UNPAID = 2 ;
    const PARTIALLYPAID = 3 ;

    protected $fillable = [
        'invoice_number',
        'invoice_date',
        'due_date',
        'product',
        'section_id',
        'amount_collection',
        'amount_commission',
        'discount',
        'rate_vat',
        'value_vat',
        'total',
        'status',
        'note',
        'payment_date',
        'user'
    ];
    protected $appends = ['status_text'];

    protected function statusText(): Attribute
    {
        return new Attribute(
            get: function(){
                switch($this->status){
                    case self::PAID:
                        return 'مدفوعة';
                    case self::UNPAID:
                        return 'غير مدفوعة';
                    case self::PARTIALLYPAID:
                        return ' مدفوعة جزئيأ';
                }
            } 
        );
    
    }

    public function section()
    {
        return $this->belongsTo(section::class);
    }

    public function invoiceDetails()
    {
        return $this->hasMany(Invoice_details::class);
    }

    public function invoiceAttachments()
    {
        return $this->hasMany(Invoice_attachments::class);
    }
}

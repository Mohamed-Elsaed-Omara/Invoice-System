<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;


class Invoice_details extends Model
{
    use HasFactory;
    
    const PAID = 1 ;
    const UNPAID = 2 ;
    const PARTIALLYPAID = 3 ;
    protected $table = 'Invoice_details';

    protected $fillable = [
        'invoice_id',
        'invoice_number',
        'product',
        'section',
        'status',
        'note',
        'user',
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

}

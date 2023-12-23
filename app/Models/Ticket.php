<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $table = 'tickets';
    protected $fillable = [
      'title',
      'type',
      'key',
      'link',
      'payment_details',
      'scanned',
      'status'
    ];
}

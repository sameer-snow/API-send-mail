<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use App\Models\EmailSendQueues;

class EmailSendQueueFiles extends Model
{
    use HasFactory;
    
    /**
     * Get the mail associated with the email(s).
     */
    /*public function email_send_queues()
    {
        return $this->belongsTo(\App\Models\EmailSendQueues::class, 'email_send_queue_id', 'id');
    }*/
}

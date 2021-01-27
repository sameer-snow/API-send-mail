<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\EmailSendQueueEmails;
use App\Models\EmailSendQueueFiles;

class EmailSendQueues extends Model
{
    use HasFactory;

    /**
     * Get the email(s) associated with the mail send.
     */
    public function email_send_queue_emails()
    {
        return $this->hasMany('\App\Models\EmailSendQueueEmails', 'email_send_queue_id', 'id');
    }
    /**
     * Get the file(s) associated with the mail send.
     */
    public function email_send_queue_files()
    {
        return $this->hasMany('\App\Models\EmailSendQueueFiles', 'email_send_queue_id', 'id');
    }
    
}

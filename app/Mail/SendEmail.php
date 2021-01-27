<?php
  
namespace App\Mail;
  
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
  
class SendEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
  
    public $content;
  
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($content)
    {
        $this->content = $content;
    }
  
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $mail = $this->subject($this->content['subject'])
                ->view('emails.mail_body');
        if ($this->content['attachments']) {
            foreach($this->content['attachments'] as $file){
                $mail->attach($file);
                // $mail->attach($file, [
                //     'as' => $file->getClientOriginalName(), 
                //     'mime' => $file->getMimeType()
                // ]);
            }
        }
        return $mail;
    }
}

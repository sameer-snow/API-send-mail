<?php
 
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator,Redirect,Response,File;

use App\Models\EmailSendQueues;
use App\Models\EmailSendQueueEmails;
use App\Models\EmailSendQueueFiles;

class SendBulkMailController extends Controller
{
    /**
     * This function is used to send mail
     * @author SPP
     * @param $request
     * @reviewer
     */
    public function sendBulkMail(Request $request)
    {
        $validator = Validator::make($request->all(), 
        [ 
          'api_token' => 'required',
          'email' => 'required',
          'body' => 'required',
          'subject' => 'required',
          //'attachments' => 'mimes:jpeg,png,jpg,gif|max:2048',
        ]);   
 
        if ($validator->fails()) {          
            return response()->json(['error'=>$validator->errors()], 401);                        
        }
        //store mail info into database
        $emailSendQueues = new EmailSendQueues();
        $emailSendQueues->body = $request->body;
        $emailSendQueues->subject = $request->subject;
        $emailSendQueues->save();

        $filesArray = $emailsArray = array();
        if ($files = $request->attachments) {
            foreach ($files as $key => $file) {
                $savedFile = $this->createImage($file['base64'], $file['name']);
                $filesArray[] = $savedFile;
                //store file into database
                $emailSendQueueFiles = new EmailSendQueueFiles();
                $emailSendQueueFiles->email_send_queue_id = $emailSendQueues->id;
                $emailSendQueueFiles->file = $savedFile;
                $emailSendQueueFiles->save();
            }
        }

        //store email into database
        if(!empty($request->email)){ 
            foreach ($request->email as $key => $email) {
                $emailsArray[] = $email;
                $emailSendQueueEmails = new EmailSendQueueEmails();
                $emailSendQueueEmails->email_send_queue_id = $emailSendQueues->id;
                $emailSendQueueEmails->email = $email;
                $emailSendQueueEmails->save();
            }
        }

        $details = [
            'subject' => $request->subject,
            'body' => $request->body,
            'attachments' => $filesArray
        ];
        \Mail::to($emailsArray)->send(new \App\Mail\SendEmail($details)); 
        return response()->json([
            "success" => true,
            "message" => "Mail sent successfully"
        ]);
    }
    /**
     * This function is used to get mail list
     * @author SPP
     * @param $request
     * @reviewer
     */
    public function getMailList(Request $request)
    {
        $validator = Validator::make($request->all(), 
        [ 
          'api_token' => 'required',
        ]);   
 
        if ($validator->fails()) {          
            return response()->json(['error'=>$validator->errors()], 401);                        
        }
        //get all mail info
        $emailSendQueues = \App\Models\EmailSendQueues::with(['email_send_queue_emails', 'email_send_queue_files'])->orderBy('id', 'DESC')->get();
        $data = array();
        foreach ($emailSendQueues as $key => $value) {
            //get mail realated files
            $filesArray = array();
            if(!empty($value->email_send_queue_files)){
                foreach ($value->email_send_queue_files as $key => $fileValue) {
                    $filesArray[] = url('/'.$fileValue['file']);
                }
            }
            //get mail realated emails, create data array
            if(!empty($value->email_send_queue_emails)){
                foreach ($value->email_send_queue_emails as $key => $emailValue) {
                    $data[$key] = [
                        'subject' => $value['subject'],
                        'body' => $value['body'],
                        'email' => $emailValue['email'],
                        'attachments' => $filesArray
                    ];
                }
            }
        }
        return response()->json([
            "success" => true,
            "data" => $data
        ]);
    }

    /**
     * This function is used to generate an image
     * @author SPP
     * @param $img (base64)
     * @param $imageName (String)
     * @reviewer
     */
    public static function createImage($img, $imageName)
    {
        $folderPath = "attachments/";

        $image_parts = explode(";base64,", $img);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $fileName =  $imageName . '. '.$image_type;
        $file = $folderPath . $imageName;
        file_put_contents($file, $image_base64);
        return $file;
    }

}
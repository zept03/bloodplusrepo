<?php

namespace App\Jobs;

use Log;
use App\User;
use App\phpSerial;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendTextBlast implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user;
    public $message;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user, $message)
    {
        $this->user = $user;
        $this->message = $message;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $serial = new phpSerial;
        $serial->deviceSet("COM25");
        $serial->confBaudRate(115200);

        $serial->deviceOpen();
        Log::info("Niagi dri"); 
        $serial->sendMessage("AT+CMGF=1\r");
        if(strlen($this->message) > 160)
        {
            $messageArr = str_split($this->message,152);
            foreach($messageArr as $message)
            {
                $serial->sendMessage("AT+CMGS=\"0".$this->user->contactinfo."\"\n\r");
                $serial->sendMessage($message."\n\r");
                $serial->sendMessage(chr(26));
                sleep(5);
            }
        }
        else
        {
            $serial->sendMessage("AT+CMGS=\"0".$this->user->contactinfo."\"\n\r");
            $serial->sendMessage($this->message."\n\r");
            $serial->sendMessage(chr(26));
            sleep(5);
        }
        
        // $read=$serial->readPort(3);
        // echo $read;    
        $serial->deviceClose();
    }
}

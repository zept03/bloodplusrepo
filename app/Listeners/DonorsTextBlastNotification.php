<?php

namespace App\Listeners;

use App\phpSerial;
use App\Events\DonorsTextBlasted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class DonorsTextBlastNotification implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  DonorsTextBlasted  $event
     * @return void
     */
    public function handle(DonorsTextBlasted $event)
    {
        $serial = new phpSerial;
        $serial->deviceSet("COM25");
        $serial->confBaudRate(115200);

        $serial->deviceOpen();

        $serial->sendMessage("AT+CMGF=1\r");
        if(strlen($event->message) > 160)
        {
            $messageArr = str_split($event->message,152);
            foreach($messageArr as $message)
            {
                $serial->sendMessage("AT+CMGS=\"0".$event->user->contactinfo."\"\n\r");
                $serial->sendMessage($message."\n\r");
                $serial->sendMessage(chr(26));
                sleep(4);
            }
        }
        else
        {
            $serial->sendMessage("AT+CMGS=\"0".$event->user->contactinfo."\"\n\r");
            $serial->sendMessage($message."\n\r");
            $serial->sendMessage(chr(26));
            sleep(4);
        }
        
        // $read=$serial->readPort(3);
        // echo $read;    
        $serial->deviceClose();
    }
}

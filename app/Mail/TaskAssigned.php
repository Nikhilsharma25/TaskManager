<?php

namespace App\Mail;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;



class TaskAssigned extends Mailable
{
    use Queueable, SerializesModels;

    public $task;  // The task data to pass to the view

    /**
     * Create a new message instance.
     *
     * @param \App\Models\Task $task
     * @return void
     */
    public function __construct(Task $task)
    {
        $this->task = $task;  // Set the task data
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('New Task Assigned')  // Email subject
                    ->view('emails.task_assigned');  // The view for the email content
    }
}

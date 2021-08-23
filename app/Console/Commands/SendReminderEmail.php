<?php

namespace App\Console\Commands;

use App\Mail\ReminderEmailDigest;
use App\Task;
use App\User;
use Illuminate\Console\Command;

class SendReminderEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder:email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email about task to execute.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // get task executor (reminder)
        $reminders = Task::query()->where('complete', '=', false)->get();

        $data = [];
        foreach ($reminders as $reminder) {
            if (!empty($reminder->remind_executor_in)) {
                $comparingDateObject = new \DateTime('+' . $reminder->remind_executor_in);
                $dueDueObject = \DateTime::createFromFormat('Y-m-d', $reminder->due_date);
                $pastDateObject = new \DateTime('-' . $reminder->remind_executor_in);
                if (($comparingDateObject->format('Y-m-d') === $dueDueObject->format('Y-m-d')) || ($pastDateObject->format('Y-m-d') === $dueDueObject->format('Y-m-d'))) {
                    $data[$reminder->executor_id][] = $reminder->toArray();
                }
            }
        }
        // send email
        foreach ($data as $userId => $reminders) {
            $this->sendEmail((int) $userId, $reminders);
        }
    }

    private function sendEmail(int $userId, $reminders)
    {
        $user = User::find($userId);

        \Mail::to($user)->send(new ReminderEmailDigest($reminders));
    }
}

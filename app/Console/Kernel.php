<?php

namespace App\Console;

use App\DashLastUpdate;
use App\Student;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
         $schedule->call(function() {
             $students = Student::all();

             foreach ($students as $student) {
                 foreach ($student->studentOutcomes()->with('performanceIndicators')->get() as $outcome) {
                     $outcome->pivot->Evaluation = 0;
                     $outcome->pivot->P1 = 0;
                     $outcome->pivot->P2 = 0;
                     $outcome->pivot->P3 = 0;
                     $outcome->pivot->EventEval = 0;
                     $p1ctr = 0;
                     $p2ctr = 0;
                     $p3ctr = 0;
                     $eventCtr = 0;

                     foreach ($student->SOEvaluations()->get() as $soEval) {
                         if ($soEval->pivot->Evaluation == 0) {
                             continue;
                         }
                         $index = $outcome->performanceIndicators->search($soEval->performanceIndicator);
                         if ($index === false) {
                             continue;
                         } else {
                             switch ($index) {
                                 case 0:
                                     $outcome->pivot->P1 += $soEval->pivot->Evaluation;
                                     $p1ctr++;
                                     break;
                                 case 1:
                                     $outcome->pivot->P2 += $soEval->pivot->Evaluation;
                                     $p2ctr++;
                                     break;
                                 case 2:
                                     $outcome->pivot->P3 += $soEval->pivot->Evaluation;
                                     $p3ctr++;
                                     break;
                             }
                         }
                     }

                     $outcome->pivot->P1 = round($outcome->pivot->P1 / (($p1ctr == 0) ? 1 : $p1ctr), 2);
                     $outcome->pivot->P2 = round($outcome->pivot->P2 / (($p2ctr == 0) ? 1 : $p2ctr), 2);
                     $outcome->pivot->P3 = round($outcome->pivot->P3 / (($p3ctr == 0) ? 1 : $p3ctr), 2);

                     foreach ($student->events()->where('event_student.Attendance', '<>', 0)->get() as $studentEvent) {
                         if ($studentEvent->studentOutcomes()->get()->contains($outcome)) {
                             $eventCtr++;
                         }
                     }

                     $eventScore = $eventCtr / (($outcome->Events_Minimum == 0) ? 1 : $outcome->Events_Minimum) * 100;

                     if ($eventCtr <= 0) {
                         $outcome->pivot->EventEval = 0;
                     } elseif ($eventScore < 40) {
                         $outcome->pivot->EventEval = 1;
                     } elseif ($eventScore < 60) {
                         $outcome->pivot->EventEval = 2;
                     } elseif ($eventScore < 80) {
                         $outcome->pivot->EventEval = 3;
                     } else {
                         $outcome->pivot->EventEval = 4;
                     }

                     $outcome->pivot->Evaluation = round(
                         (($outcome->pivot->P1 * $outcome->performanceIndicators[0]->Weight / 100) +
                         ($outcome->pivot->P2 * $outcome->performanceIndicators[1]->Weight / 100) +
                         ($outcome->pivot->P3 * $outcome->performanceIndicators[2]->Weight / 100) +
                         ($outcome->pivot->EventEval * $outcome->EventWeight / 100)), 2);

                     $outcome->pivot->update();
                 }
             }

             $update = new DashLastUpdate();
             $update->timestamp = Carbon::now(new \DateTimeZone('PHT'));
             $update->save();

         })->name('Update_Dashboard')->withoutOverlapping();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }

    public function updateDashboard()
    {

    }
}

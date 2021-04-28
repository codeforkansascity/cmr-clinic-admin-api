<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MakeInitialExceptions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cmr:make-initial-exceptions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Load the initial exceptions into the exections table';

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
     * @return int
     */
    public function handle()
    {

        $records = $this->getExceptions();

        foreach ($records AS $record) {
            $record = json_decode(json_encode($record), true);

            $this->getOrAddException(
                $record['id'],
                $record['section'],
                $record['name'],
                $record['short_name'],
                $record['attorney_note'],
                $record['dyi_note'],
                $record['logic'],
                $record['sequence']
            );
        }

        return 0;
    }

    private function getOrAddException($id, $section, $name, $short_name, $attorney_note, $dyi_note, $logic, $sequence)
    {

        if (!$rec = \App\Exception::where([
            'id' => $id,
        ])->first()
        ) {
            $rec = \App\Exception::create([
                'id' => $id,
                'section' => $section,
                'name' => $name,
                'short_name' => $short_name,
                'attorney_note' => $attorney_note,
                'dyi_note' => $dyi_note,
                'logic' => $logic,
                'sequence' => $sequence,
            ]);
        }

        return $rec;
    }

    private function getExceptions() {
        $var = <<< EOM
[{
    "id": 1,
    "section": "2.1",
    "name": "Any class A felony offense",
    "short_name": "2.1 Class A Felony",
    "attorney_note": "",
    "dyi_note": "",
    "logic": "conviction",
    "sequence": 1
},
{
    "id": 2,
    "section": "2.2",
    "name": "Any dangerous felony as that term is defined in section 556.061",
    "short_name": "DangerousFelony in 556.061",
    "attorney_note": "",
    "dyi_note": "",
    "logic": "offense number; conviction level",

    "sequence": 2
},
{
    "id": 3,
    "section": "2.3",
    "name": "Any offense that requires registration as a sex offender;",
    "short_name": "Registration Sex Offender",
    "attorney_note": "",
    "dyi_note": "",
    "logic": "offense number; possibly victims age",
    "sequence": 3
},
{
    "id": 4,
    "section": "2.4",
    "name": "Any felony offense where death is an element of the offense",
    "short_name": "Death is an element of",
    "attorney_note": "Not expungable if a Felony",
    "dyi_note": "If your conviction was a Felony, this cannot be expunged.",
    "logic": "offense number; conviction level",
    "sequence": 4
},
{
    "id": 5,
    "section": "2.5",
    "name": "Any felony offense of assault; misdemeanor or felony offense of domestic assault; or felony offense of kidnapping",
    "short_name": "Any felony misdemeanor assault kidnapping …",
    "attorney_note": "",
    "dyi_note": "",
    "logic": "offense number, conviction level",
    "sequence": 5
},
{
    "id": 6,
    "section": "2.6",
    "name": "Any offense listed, or previously listed, in chapter 566 or section ...",
    "short_name": "Listed Offense",
    "attorney_note": "",
    "dyi_note": "",
    "logic": "offense number",
    "sequence": 6
},
{
    "id": 7,
    "section": "2.7",
    "name": "Any offense eligible for expungement under section 577.054** or 610.130;",
    "short_name": "Alcohol-related driving offenses",
    "attorney_note": "",
    "dyi_note": "",
    "logic": "we are not processing",
    "sequence": 7
},
{
    "id": 8,
    "section": "2.8",
    "name": "Any intoxication-related traffic or boating offense as defined in section 577.001, or any offense of operating an aircraft with an excessive blood alcohol..",
    "short_name": "Intoxication-related traffic or boating 577.001",
    "attorney_note": "",
    "dyi_note": "",
    "logic": "offense number",
    "sequence": 8
},
{
    "id": 9,
    "section": "2.9",
    "name": "Any ordinance violation that is the substantial equivalent of any offense that is not eligible for expungement under this section;",
    "short_name": "Ordinance that is equivalent",
    "attorney_note": "",
    "dyi_note": "",
    "logic": "offense number",
    "sequence": 9
},
{
    "id": 10,
    "section": "2.10",
    "name": "Any violation of any state law or county or municipal ordinance regulating the operation of motor vehicles when committed by an individual w...",
    "short_name": "CDL and operation of motor vehicles",
    "attorney_note": "",
    "dyi_note": "",
    "logic": "offense number; client CDL status",
    "sequence": 10
},
{
    "id": 11,
    "section": "2.11",
    "name": "Any offense of section 571.030, except any offense under subdivision (1) of subsection 1 of section 571.030 where the person was convicted or found guilty prior to January 1, 2017.",
    "short_name": "Unlawful use of weapons",
    "attorney_note": "",
    "dyi_note": "",
    "logic": "conviction date and must review what the conviction ….",
    "sequence": 11
}
]
EOM;



        return json_decode($var);


    }
}

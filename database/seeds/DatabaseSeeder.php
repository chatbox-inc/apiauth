<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $csv = new SplFileObject(__DIR__ . "/jobs.csv");
        $csv->setFlags(SplFileObject::READ_CSV);

        $toInserts = [];
        foreach ($csv as $index => $line) {
            if ($index === 0) {
                continue;
            }
            $toInserts[] = [
                'job_id' => $line[0],
                'pref' => $line[1],
                'city' => $line[2],
                'address' => $line[3],
                'category' => $line[4],
                'branch1' => $line[5],
                'branch2' => $line[6],
                'annual_wage_from' => $line[7],
                'annual_wage_to' => $line[8],
                'monthly_wage' => $line[9],
                'hourly_wage' => $line[10],
                'work_from' => Carbon::parse($line[11])->toDateString(),
                'term' => $line[12],
                'employment_type' => $line[13],
                'work_style' => $line[14],
                'work_at' => $line[15],
                'for_handicapped' => $line[16] === 'TRUE' ? 1 : 0,
                'for_beginner' => $line[17] === 'TRUE' ? 1 : 0,
                'big_offer' => $line[18] === 'TRUE' ? 1 : 0,
                'can_be_regular' => $line[19] === 'TRUE' ? 1 : 0,
                'for_youth' => $line[20] === 'TRUE' ? 1 : 0,
                'for_female' => $line[21] === 'TRUE' ? 1 : 0,
                'title' => $line[22],
                'is_new' => $line[23] === 'TRUE' ? 1 : 0,
                'list_image_1' => $line[24],
                'summary' => $line[25],
                'detail_image_1' => $line[26],
                'advisor_comment' => $line[27],
                'attraction' => $line[28],
                'work_time' => $line[29],
                'holiday' => $line[30],
                'wage' => $line[31],
                'insurance' => $line[32],
                'welfare_1' => $line[33],
                'welfare_2' => $line[34],
                'capacity' => $line[35],
                'reason' => $line[36],
                'required_skill' => $line[37],
                'required_experience' => $line[38],
                'company_name' => $line[39],
                'establishment_year' => $line[40],
                'capital_fund' => $line[41],
                'employees_num' => $line[42],
                'be_listed' => $line[43],
                'business_overview' => $line[44],
                'others' => $line[45],
                'requirement_for_regular' => $line[46],
                'detail_image_2' => $line[47],
                'html_memo' => $line[48],
                'deleted_at' => $line[49] ? Carbon::parse($line[49])->toDateTimeString() : null,
                'synced_at' => Carbon::now()->toDateTimeString(),
            ];
        }
        DB::table('jobs')->insert($toInserts);
    }
}

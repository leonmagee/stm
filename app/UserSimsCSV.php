<?php
namespace App;

use League\Csv\Writer;
use SplTempFileObject;

/**
 * Class UserSimsCSV
 *
 * Loop through all sims assigned to a certain agent and generate a csv
 * file to download.
 *
 */
class UserSimsCSV
{

    private static function get_sims_array($id)
    {
        $sims = SimUser::where('user_id', $id)->pluck('sim_number')->toArray();
        return $sims;
    }

    public static function process_csv_download($id)
    {
        // get sims
        $sims = self::get_sims_array($id);

        // create csv file in memory
        $csv = Writer::createFromFileObject(new SplTempFileObject());

        // add sims to csv
        foreach ($sims as $sim) {
            $csv->insertOne([$sim]);
        }

        // output
        $date = date('m-d-Y');
        $filename = "stm-sims-download-" . $date . ".csv";
        $csv->output($filename);

        die();
    }

}

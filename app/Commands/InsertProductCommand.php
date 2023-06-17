<?php

namespace App\Commands;

use App\Repositories\ProductRepository;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use LaravelZero\Framework\Commands\Command;
use SimpleXMLElement;

class InsertProductCommand extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'product:feed';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // try catch, save error in log file
        try {
            $this->insertProduct();
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $this->error($message);
            Log::error($message);
        }

    }

    /**
     * Define the command's schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    public function schedule(Schedule $schedule): void
    {

    }

    private function insertProduct()
    {
        // Ask the user for the XML file path
        $xmlFilePath = $this->ask('Enter the path to the XML file');

        if (!File::exists($xmlFilePath)) {
            $message = 'XML file does not exist!';
            $this->error($message);
            Log::error($message);
            return 1;
        }

        // Read XML content
        $xmlContent = File::get($xmlFilePath);

        // check if XML is valid
        if (!simplexml_load_string($xmlContent)) {
            $message = 'XML file is not valid!';
            $this->error($message);
            Log::error($message);
            return 1;
        }
        // Parse XML to SimpleXMLElement
        $xml = new SimpleXMLElement($xmlContent);

        // check if XML is empty
        if (empty($xml)) {
            $message = 'XML file is empty!';
            $this->error($message);
            Log::error($message);
            return 1;
        }

        // Convert SimpleXMLElement to JSON
        $json = json_encode($xml, JSON_PRETTY_PRINT);

        // Create a new JSON file
        $jsonFilePath = $this->ask('Enter the path to save the JSON file');
        File::put($jsonFilePath, $json);

        $json = json_encode($xml, JSON_PRETTY_PRINT);

        $data = json_decode($json, true);

        $productRepository = new ProductRepository();

        if(!isset($data['item'])){
            $message = 'XML file is empty!';
            $this->error($message);
            Log::error($message);
            return 1;
        }
        foreach ($data['item'] as $product) {

            $productRepository->insert($product);
        }
        $message = count($data['item']). ' products are saved in '.config( 'database.default' ).' successfully.';

        $this->info($message);
        Log::info($message);
    }
}

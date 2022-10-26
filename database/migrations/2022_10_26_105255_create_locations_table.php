<?php

use App\Models\Location;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        $this->createTable();
        $this->migrateDefaultData();
    }

    public function down()
    {
        Schema::dropIfExists('locations');
    }

    protected function createTable()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->double('latitude');
            $table->double('longitude');
            $table->timestamps();
        });
    }

    protected function migrateDefaultData()
    {
        $locations = $this->readCSVData(database_path('migrations/datasets/data.csv'));

        foreach ($locations as $location) {
           Location::factory([
               'name' => $location[0],
               'latitude' => $location[1],
               'longitude' => $location[2],
           ])->create();
        }
    }

    protected function readCSVData($filePath, $seperator = ','): Collection
    {
        $fileHandle = fopen($filePath, 'r');
        $data = collect();

        while (!feof($fileHandle)) {
            $line = fgetcsv($fileHandle, 0, $seperator);

            if ($line) {
                $data[] = $line;
            }
        }

        fclose($fileHandle);

        return $data;
    }
};

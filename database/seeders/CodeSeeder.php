<?php

namespace Database\Seeders;

use App\Models\Code;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $batchSize = 1000;
        $totalCodes = 100000;
        
        for ($i = 0; $i < $totalCodes; $i += $batchSize) {
            $codes = [];
            $currentBatchSize = min($batchSize, $totalCodes - $i);
            
            for ($j = 1; $j <= $currentBatchSize; $j++) {
                $codeNumber = $i + $j;
                $codes[] = [
                    'code' => $codeNumber,
                    'is_reserved' => true,
                    'price' => 0,
                    'user_id' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
            
            \DB::table('codes')->insert($codes);
        }
    }
}

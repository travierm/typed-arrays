<?php
namespace Tmoorlag\PhpTypedArrays\tests;

use AppGati;
use PHPUnit\Framework\TestCase;
use Tmoorlag\PhpTypedArrays\SongArray;

class SongArrayTest extends TestCase {
    // generate random songs with random values
    private function generateRandomSongs(int $count) {
        $songs = [];
        for($i = 0; $i < $count; $i++) {
            $songs[] = [
                'artist_name' => random_bytes(10),
                'name' => random_bytes(10),
                'test' => random_bytes(10),
                'test' => random_bytes(10),
                'test' => random_bytes(10),
            ];
        }
        return $songs;
    }


    public function test_can_use_song_array()
    {
        $app = new AppGati;

        $songs = $this->generateRandomSongs(300000);

        $app->step('start');
        $songArray = new SongArray($songs);
        $app->step('end');

        $report = $app->getReport('start', 'end');
        print_r($report);
    }
}
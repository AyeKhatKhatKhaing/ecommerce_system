<?php
namespace App\Traits;

use Illuminate\Http\File;
use App\Classes\FakerImageProvider;
use Illuminate\Support\Facades\Storage;

/**
 * @property mixed $faker
 */
trait GenerateSeederImage {
  public function generateImage($faker = null) {
    $faker = $faker ?? $this->faker;
    $faker->addProvider(new FakerImageProvider($faker));
    $image = $faker->image('/tmp', 640, 480);
    return Storage::disk('local')
      ->putFileAs('seeder-images', new File($image), basename($image));
  }
}
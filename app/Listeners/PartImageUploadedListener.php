<?php

namespace App\Listeners;

use App\Events\PartImageUploaded;
use App\Models\Activity;
use App\Models\Supplierscore;
use App\Models\Touchpoint;
use App\Models\Skudetail;
use Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Imagick\Driver;
use Intervention\Image\ImageManager;

class PartImageUploadedListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(PartImageUploaded $event): void
    {
        //create the directory if it doesn't exist
        if(!is_dir(storage_path('/app/public/parts/'))){
            mkdir(storage_path('/app/public/parts/'), 0755, true);
        }
        //upload the file
        $file = $event->request->file('file');
        $file = $file[0];

        $new_filename = uniqid().".".$file->extension();

        $tenant_directory = "tenant".tenancy()->tenant->id;
        $file_path = "/storage/parts/".$new_filename;
        $path_to_file = storage_path('/app/public/parts/'.$new_filename);

        $manager = new ImageManager(new Driver());
        $x = $manager->read($file);
        $temp_file_path = $x->origin()->filePath();
        $img = $manager->read($temp_file_path)->scaleDown(width:400)->save($path_to_file);

        //save the uploaded image to the sku details
        Skudetail::saveImage($event->sku->id, $file_path);

    }
}

<?php

namespace App\Http\Controllers\Admin;

use ZipArchive;
use Illuminate\Http\Request;
use Nwidart\Modules\Facades\Module;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;

class AddonController extends Controller
{
    public function index()
    {
        return view('admin.addons.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'purchase_code' => 'required',
            'file' => 'required|file|mimes:zip',
        ]);

        try {
            $header = array();
            $header[] = 'Accept: application/json';
            $header[] = 'Authorization: Bearer sLAEuLH83WuGmg8iJGDSxQiavZ2TF1ba';

            $api_url = 'https://api.envato.com/v3/market/author/sale?code='.$request->purchase_code;

            $ch = curl_init($api_url);
            curl_setopt($ch, CURLOPT_URL, $api_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

            $responseData = curl_exec($ch);
            if ($responseData !== false) {
                $result = json_decode($responseData, true); // Decode JSON into an associative array
                if ($result['amount'] ?? false) {

                    $uploadedFile = $request->file('file');
                    // Open the ZIP file using ZipArchive without saving it first
                    $zip = new ZipArchive;
                    $tempFilePath = $uploadedFile->getRealPath();

                    // Check if the ZIP file can be opened
                    if ($zip->open($tempFilePath) === TRUE) {

                        // Define the path to the Modules folder
                        $destinationPath = base_path('Modules');

                        // Ensure the Modules folder exists
                        if (!File::exists($destinationPath)) {
                            File::makeDirectory($destinationPath, 0755, true);
                        }

                        $zip->extractTo($destinationPath);
                        $zip->close();
                        $module_name = pathinfo($request->file('file')->getClientOriginalName(), PATHINFO_FILENAME);

                        // Specify the path to the module's migrations folder
                        $moduleMigrationsPath = base_path('Modules/' . $module_name . '/Database/Migrations');
                        // Check if the migrations folder exists and contains migration files
                        if (File::exists($moduleMigrationsPath)) {
                            // Dynamically add the module's migrations path to the migrator
                            $migrator = app('migrator');
                            $migrator->path($moduleMigrationsPath);
                            // Run the migrations from the module's migration path
                            Artisan::call('migrate', ['--force' => true]);
                        }

                        // Update the modules_statuses.json file
                        $filePath = base_path('modules_statuses.json');

                        // Read the contents of the JSON file
                        $jsonContents = File::get($filePath);

                        // Decode the JSON into an associative array
                        $data = json_decode($jsonContents, true);

                        // Add the new key-value pair to the array
                        $data[$module_name] = true;

                        // Encode the array back into JSON format
                        $newJsonContents = json_encode($data, JSON_PRETTY_PRINT);

                        // Write the updated contents back to the file
                        File::put($filePath, $newJsonContents);

                        return response()->json([
                            'message' => 'Addon installed successfully.',
                            'redirect' => route('admin.addons.index'),
                        ]);
                    } else {
                        return response()->json('Failed to open ZIP file', 406);
                    }

                } else {
                    return response()->json(['message' => __('Invalid purchase code.')], 406);
                }
            } else {
                return response()->json(['message' => __('Api request failed')], 406);
            }

            curl_close($ch);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function show($module)
    {
        $module = Module::findOrFail($module);
        if ($module->isEnabled()) {
            $module->disable();
        } else {
            $module->enable();
        }
        return response()->json(true);
    }
}

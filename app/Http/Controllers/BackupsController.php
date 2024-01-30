<?php

namespace App\Http\Controllers;

use App\Cat;
use BackupManager\Manager;
use Illuminate\Http\Request;
use League\Flysystem\FileExistsException;
use App\Http\Requests\BackupUploadRequest;
use BackupManager\Filesystems\Destination;
use Illuminate\Support\Facades\Response;
use League\Flysystem\FileNotFoundException;

/**
 * Database Backups Controller.
 *
 * @author Nafies Luthfi <nafiesL@gmail.com>
 */
class BackupsController extends Controller
{
    /**
     * List of backup files.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        if (!file_exists(storage_path('app/backup/db'))) {
            $backups = [];
        } else {
            $backups = \File::allFiles(storage_path('app/backup/db'));

            // Sort files by modified time DESC
            usort($backups, function ($a, $b) {
                return -1 * strcmp($a->getMTime(), $b->getMTime());
            });
        }

        return view('backups.index', compact('backups'));
    }


    /**
     * Display the specified Backup.
     *
     */
    public function show(Request $request)
    {

        return view('backups.issue', [
        ]);
    }

    /**
     * Create new backup file.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'file_name' => 'nullable|max:30|regex:/^[\w._-]+$/',
        ]);

        try {
            $manager = app()->make(Manager::class);
            $fileName = $request->get('file_name') ?: date('Y-m-d_Hi');

            $manager->makeBackup()->run('mysql', [
                new Destination('local', 'backup/db/'.$fileName),
            ], 'gzip');

            return redirect()->route('backups.index');
        } catch (FileExistsException $e) {
            return redirect()->route('backups.index');
        }
    }

    /**
     * Delete a backup file from storage.
     *
     * @param  string  $fileName
     * @return \Illuminate\Routing\Redirector
     */
    public function destroy($fileName)
    {
        if (file_exists(storage_path('app/backup/db/').$fileName)) {
            unlink(storage_path('app/backup/db/').$fileName);
        }

        return redirect()->route('backups.index');
    }

    /**
     * Download a backup file.
     *
     * @param  string  $fileName
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function download($fileName)
    {
        return response()->download(storage_path('app/backup/db/').$fileName);
    }

    /**
     * Restore database from a backup file.
     *
     * @param  string  $fileName
     * @return \Illuminate\Routing\Redirector
     */
    public function restore($fileName)
    {
        try {
            $manager = app()->make(Manager::class);
            $manager->makeRestore()->run('local', 'backup/db/'.$fileName, 'mysql', 'gzip');
        } catch (FileNotFoundException $e) {
        }

        return redirect()->route('backups.index');
    }

    /**
     * Upload a backup file to the storage.
     *
     * @param  \App\Http\Requests\BackupUploadRequest  $request
     * @return \Illuminate\Routing\Redirector
     */
    public function upload(BackupUploadRequest $request)
    {
        $file = $request->file('backup_file');

        if (file_exists(storage_path('app/backup/db/').$file->getClientOriginalName()) == false) {
            $file->storeAs('backup/db', $file->getClientOriginalName());
        }

        return redirect()->route('backups.index');
    }

    public function import(Request $request)
    {
        try {
            $file = $request->file('file');
            if ($file == null) throw new FileNotFoundException("");
            if ($file->getPathname() == "") throw new FileNotFoundException("");
            $fileContents = file($file->getPathname());
    
            foreach ($fileContents as $key=>$line) {
                if ($key == 0) {
                    continue;
                }
                $data = str_getcsv($line);
    
                Cat::create([
                    'id' => $data[0],
                    'full_name' => $data[1],
                    'gender_id' => $data[2],
                    'father_id' => $data[3],
                    'mother_id' => $data[4],
                    'dob' => $data[5],
                    'titles_before_name' => $data[6],
                    'titles_after_name' => $data[7],
                    'registration_numbers' => $data[8],
                    'ems_color' => $data[9],
                    'breed' => $data[10],
                    'chip_number' => $data[11],
                    'genetic_tests' => $data[12],
                    // Add more fields as needed
                ]);
            }
        } catch (FileNotFoundException $e) {
            return redirect()->route('backups.issue');
        }

        return redirect()->route('backups.index');
    }

    public function export()
    {
        $cats = Cat::all();
        $csvFileName = 'cats.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $csvFileName . '"',
        ];

        $handle = fopen('php://output', 'w');
        fputcsv($handle, ['id', 'full_name', 'gender_id', 'father_id', 'mother_id', 'dob', 'titles_before_name', 'titles_after_name', 'registration_numbers', 'ems_color', 'breed', 'chip_number', 'genetic_tests']); // Add more headers as needed

        foreach ($cats as $cat) {
            fputcsv($handle, [$cat->id, $cat->full_name, $cat->gender_id, $cat->father_id, $cat->mother_id, $cat->dob, $cat->titles_before_name, $cat->titles_after_name, $cat->registration_numbers, $cat->ems_color, $cat->breed, $cat->chip_number, $cat->genetic_tests]); // Add more fields as needed
        }

        fclose($handle);

        return Response::make('', 200, $headers);
    }
}

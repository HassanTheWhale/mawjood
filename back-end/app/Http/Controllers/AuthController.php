<?php

namespace App\Http\Controllers;

use App\Models\att;
use App\Models\events;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;
use FFMpeg\FFMpeg;
use FFMpeg\Format\Audio\Wav;
use JeroenDesloovere\Audio\Audio;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use Acamposm\AudioAnalys\AudioAnalys;
use Illuminate\Http\UploadedFile;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function captureImage(Request $request, $eid, $uid, $iid)
    {
        $myuser = Auth::user();
        $event = events::where('id', $eid)->firstOrFail();

        $already = att::select('atts.id', 'atts.done', 'atts.qr', 'atts.face', 'atts.geo')
            ->join('event_instances', 'atts.instance_id', '=', 'event_instances.id')
            ->where('atts.event_id', $event->id)
            ->where('atts.user_id', $myuser->id)
            ->whereDate('event_instances.date', Carbon::today()->format('Y-m-d'))
            ->firstOrFail();

        if ($already->done == 1 || $already->face == 1 || $already->qr == 0)
            return response('Image cant be captured', 404);


        // update geo
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');

        $loc = $latitude . ',' . $longitude;
        $already->update(['geo' => $loc]);

        // if skipped
        if ($request->input('cancel') == '1') {
            $already->update(['face' => 2]);
            return response('Image captured', 200);
        }


        $imageData = $request->input('image');
        $imageData = str_replace('data:image/png;base64,', '', $imageData);
        $imageData = str_replace(' ', '+', $imageData);
        $imageBinary = base64_decode($imageData);
        $filename = uniqid() . '.png';

        // check if face done
        $client = new Client();
        // Send a POST request to the Flask server with the image file
        $response = $client->request('GET', 'http://localhost:5000/face_recognition', [
            'multipart' => [
                [
                    'name' => 'image',
                    'contents' => $imageBinary,
                    'filename' => $filename,
                ],
                [
                    'name' => 'userImg',
                    'contents' => $myuser->vpicture,
                ],
            ],
        ]);

        // Get the response body as a string
        $body = $response->getBody()->getContents();

        if (strpos($body, '{"match":true}') !== false) {
            // There's a match
            $already->update(['face' => 1]);
            return response('Image captured', 200);
        } else {
            // There's no match
            $already->update(['face' => 3]);
            return response('No match', 404);
        }
    }

    public function captureVoice(Request $request, $eid, $uid, $iid)
    {

        $validatedData = $request->validate([
            'audio' => 'required|file|max:1024', // max file size in KB
            'note' => 'nullable|string|max:255',
        ]);

        // save the audio file to the storage/app/public directory
        // Storage::disk('public')->put($filename, $audioData);

        $myuser = Auth::user();
        $event = events::where('id', $eid)->firstOrFail();

        $already = att::select('atts.id', 'atts.done', 'atts.qr', 'atts.face', 'atts.voice', 'atts.geo', 'atts.note')
            ->join('event_instances', 'atts.instance_id', '=', 'event_instances.id')
            ->where('atts.event_id', $event->id)
            ->where('atts.user_id', $myuser->id)
            ->whereDate('event_instances.date', Carbon::today()->format('Y-m-d'))
            ->firstOrFail();

        if ($already->done == 1 || $already->face == 0 || $already->qr == 0 || $already->voice == 1)
            return response('Image cant be captured', 404);

        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');
        $loc = $latitude . ',' . $longitude;
        $geo = $already->geo;

        list($lat1, $long1) = explode(',', $loc);
        list($lat2, $long2) = explode(',', $geo);

        $avgLat = ($lat1 + $lat2) / 2;
        $avgLong = ($long1 + $long2) / 2;

        $avgGeoLocation = $avgLat . ',' . $avgLong;
        $already->update(['geo' => $avgGeoLocation]);

        $note = $request->input('note');
        $already->update(['note' => $note]);

        if ($request->input('cancel') == '1') {
            $already->update(['voice' => 2]);
            return response('Voice captured', 200);
        }

        // $audio = new Audio($request->file('audio')->getPathname());
        // $filename = uniqid() . '.wav';
        // $audio->toWav(storage_path('public/audio/' . $filename));
        $request->file('audio')->storeAs('public/profile', uniqid() . '.webm');

        // Set the paths to the input and output files
        $inputPath = $request->file('audio')->getPathname();
        $outputPath = storage_path('public/audio/') . uniqid() . '.wav';

        // Set the conversion command
        $command = "ffmpeg -i $inputPath -vn -ar 44100 -ac 2 -ab 192k -f wav $outputPath";

        // Execute the command as a separate process
        $descriptorspec = [
            0 => ['pipe', 'r'],
            1 => ['pipe', 'w'],
            2 => ['pipe', 'w']
        ];

        $process = proc_open($command, $descriptorspec, $pipes);

        // Check if the command executed successfully
        if (is_resource($process)) {
            // Wait for the process to finish
            fclose($pipes[0]);
            $stdout = stream_get_contents($pipes[1]);
            $stderr = stream_get_contents($pipes[2]);
            fclose($pipes[1]);
            fclose($pipes[2]);
            $status = proc_get_status($process);
            while ($status['running']) {
                $status = proc_get_status($process);
            }

            if ($status['exitcode'] === 0) {
                // Conversion succeeded
            } else {
                // Conversion failed
            }
            proc_close($process);
        }

        // // check if face done
        // $client = new Client();
        // // Send a POST request to the Flask server with the image files
        // $response = $client->request('GET', 'http://localhost:5000/voice_recognition', [
        //     'multipart' => [
        //         [
        //             'name' => 'voice',
        //             'contents' => $wav,
        //             'filename' => $filename,
        //             'headers' => [
        //                 'Content-Type' => 'audio/wav'
        //             ],
        //         ],
        //         [
        //             'name' => 'userVoice',
        //             'contents' => $myuser->vaudio,
        //         ],
        //     ],
        // ]);

        // // Get the response body as a string
        // $body = $response->getBody()->getContents();
        // return $body;
        // if (strpos($body, '{"match":true}') !== false) {
        //     // There's a match
        //     $already->update(['voice' => 1]);
        //     return response('voice captured', 200);
        // } else {
        //     // There's no match
        //     $already->update(['voice' => 3]);
        //     return response('No match', 404);
        // }
    }
}
<?php

namespace App\Jobs;

use Carbon\Carbon;

use FFMpeg\Format\Video\X264;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use FFMpeg\Filters\Video\VideoFilters;

class ConvertVideoForStreaming implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $post;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function  __construct($post)
    {
        $this->post = $post;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $params = json_decode($this->post->params);
        $file = $params->video_s3;

        $filename = explode('.', basename($file))[0];

        //FFMpeg::openUrl(url(\Storage::disk('local')->url($this->video)))
        //$video = FFMpeg::openUrl(asset_url('fake.mp4'));


        $video = FFMpeg::fromDisk('s3')->open($file);

        $paths = ["convert_videos\\{$filename}-720.mp4", "convert_videos\\{$filename}-480.mp4"/*, "convert_videos\\{$filename}-360.mp4"*/];

        $video->export()
            ->toDisk('s3')
            ->withVisibility('public')
            ->inFormat(new \FFMpeg\Format\Video\X264)
            ->resize(1280, 720)
            ->save($paths[0]);

        $video->export()
            ->toDisk('s3')
            ->withVisibility('public')
            ->inFormat(new \FFMpeg\Format\Video\X264)
            ->resize(854, 480)
            ->save($paths[1]);

        /*$video->export()
            ->toDisk('s3')
            ->withVisibility('public')
            ->inFormat(new \FFMpeg\Format\Video\X264)
            ->resize(640, 360)
            ->save($paths[2]);*/

        $params->videos_s3 = $paths;
        $this->post->params = json_encode($params);
        $this->post->save();

        /*$video->getFrameFromSeconds(10)
        ->export()
        ->toDisk('public')
        ->save('videos/thumbnail.png');*/

            /*$video->addFilter(function (VideoFilters $filters) {
                $filters->resize(new \FFMpeg\Coordinate\Dimension(640, 480));
            })
            ->export()
            ->toDisk('public')
            ->inFormat(new \FFMpeg\Format\Video\X264)
            ->save("videos\\{$filename}-640-480.mp4");*/

        FFMpeg::cleanupTemporaryFiles();

    }
}

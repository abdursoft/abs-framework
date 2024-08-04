<?php
/**
 * ABS PHP Framework
 *
 * @created      2023
 * @updated      2024-08-04
 * @version      1.0.7
 * @author       abdursoft <support@abdursoft.com>
 * @authorURI    https://abdursoft.com/author
 * @copyright    2024 abdursoft
 * @license      MIT
 *
 * @Written by Abdur Rahim
 */

namespace ABS\Framework\Core\Files;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Streaming\HLSSubtitle;
use Streaming\Representation;

class FFmpeg {
    protected $ffmpeg;
    protected $ffprobe;
    protected $format;
    public function __construct() {

        $config = [
            'ffmpeg.binaries'  => FFMPEG,
            'ffprobe.binaries' => FFMPEGPROBE,
            'timeout'          => 3600, // The timeout for the underlying process
            'ffmpeg.threads' => 12, // The number of threads that FFmpeg should use
        ];

        $log = new Logger( 'FFmpeg_Streaming' );
        $log->pushHandler( new StreamHandler( '/var/log/ffmpeg-streaming.log' ) ); // path to log file

        $this->ffmpeg = \Streaming\FFMpeg::create( $config, $log );
        $this->format = new \FFMpeg\Format\Video\X264( 'libmp3lame', 'libx264' );
    }

    /**
     * load video file with ffmpeg
     * @param file name of the file or file temprory name
     * will return the video
     */
    public function load( $file ) {
        $this->ffmpeg->open( $file );
    }

    /**
     * load video file with ffmpeg
     * @param url cloud video url
     * will return the video
     */
    public function loadCloud( $url ) {
        $this->ffmpeg->openFromCloud( $url );
    }

    /**
     * load video file with ffmpeg
     * @param source name of the camera source
     * will return the video
     */
    public function camera( $source ) {
        $this->ffmpeg->capture( $source );
    }

    /**
     * generating dash with ffmpeg
     * @param path path of the video
     * @param dir destination of the dash video
     * @param is_tmp true for temporary file or false
     */
    public function dash( $path, $dir, $is_tmp ) {
        $video = $this->ffmpeg->open( $path, $is_tmp );
        $video->dash()
            ->x264()
            ->autoGenerateRepresentations( [720] )
            ->save( $dir );
    }

    /**
     * generating dash with ffmpeg multiple
     * @param path path of the video
     * @param dir destination of the dash video
     * @param is_tmp true for temporary file or false
     */
    public function multiDash( $path, $dir, $is_tmp ) {
        $r_144p  = ( new Representation )->setKiloBitrate( 95 )->setResize( 256, 144 );
        $r_240p  = ( new Representation )->setKiloBitrate( 150 )->setResize( 426, 240 );
        $r_360p  = ( new Representation )->setKiloBitrate( 276 )->setResize( 640, 360 );
        $r_480p  = ( new Representation )->setKiloBitrate( 750 )->setResize( 854, 480 );
        $r_720p  = ( new Representation )->setKiloBitrate( 2048 )->setResize( 1280, 720 );
        $r_1080p = ( new Representation )->setKiloBitrate( 4096 )->setResize( 1920, 1080 );
        $r_2k    = ( new Representation )->setKiloBitrate( 6144 )->setResize( 2560, 1440 );
        $r_4k    = ( new Representation )->setKiloBitrate( 17408 )->setResize( 3840, 2160 );

        $video = $this->ffmpeg->open( $path, $is_tmp );

        $video->dash()
            ->x264()
            ->addRepresentations( [$r_144p, $r_240p, $r_360p, $r_480p, $r_720p, $r_1080p, $r_2k] )
            ->save( $dir );
    }

    /**
     * generating hls with ffmpeg
     * @param path path of the video
     * @param dir destination of the dash video
     * @param is_tmp true for temporary file or false
     */
    public function hls( $path, $dir, $is_tmp, ) {
        $video = $this->ffmpeg->open( $path, $is_tmp );
        $video->hls()
            ->x264()
            ->autoGenerateRepresentations( [720] )
            ->save( $dir );
    }

    /**
     * generating hls with ffmpeg multiple
     * @param path path of the video
     * @param dir destination of the dash video
     * @param is_tmp true for temporary file or false
     */
    public function multiHLS( $path, $dir, $is_tmp ) {
        $r_144p  = ( new Representation )->setKiloBitrate( 95 )->setResize( 256, 144 );
        $r_240p  = ( new Representation )->setKiloBitrate( 150 )->setResize( 426, 240 );
        $r_360p  = ( new Representation )->setKiloBitrate( 276 )->setResize( 640, 360 );
        $r_480p  = ( new Representation )->setKiloBitrate( 750 )->setResize( 854, 480 );
        $r_720p  = ( new Representation )->setKiloBitrate( 2048 )->setResize( 1280, 720 );
        $r_1080p = ( new Representation )->setKiloBitrate( 4096 )->setResize( 1920, 1080 );
        $r_2k    = ( new Representation )->setKiloBitrate( 6144 )->setResize( 2560, 1440 );
        $r_4k    = ( new Representation )->setKiloBitrate( 17408 )->setResize( 3840, 2160 );

        $video = $this->ffmpeg->open( $path, $is_tmp );

        $video->hls()
            ->x264()
            ->addRepresentations( [$r_144p, $r_240p, $r_360p, $r_480p, $r_720p, $r_1080p, $r_2k, $r_4k] )
            ->save( $dir );
    }

    /**
     * generating hlsDRM with ffmpeg
     * @param license_path path of the license
     * @param save_license save the new license to verify
     * @param path video path for the hls video
     * @param is_tmp true if the video is temporary file or false
     * @param dir destination of the hlsDRM files
     */
    public function hlsDRM( $license_path, $save_license_path, $path, $is_tmp, $dir ) {
        //A path you want to save a random key to your local machine
        $save_to = $save_license_path;

        //An URL (or a path) to access the key on your website
        $url = $license_path;
        // or $url = '/"PATH TO THE KEY DIRECTORY"/key';
        $video = $this->ffmpeg->open( $path, $is_tmp );
        $video->hls()
            ->encryption( $save_to, $url )
            ->x264()
            ->autoGenerateRepresentations( [1080, 480, 240] )
            ->save( $dir );
    }

    /**
     * generating hls subtitle with ffmpeg
     * @param path path of the video
     * @param dir destination of the dash video
     * @param is_tmp true for temporary file or false
     * @param subtitles a list of subtitle with an array
     * @param default index of the default subtitle
     */
    public function hlsSubtitle( $path, $dir, $is_tmp, array $subtitls, int $default ) {
        $captions = [];
        foreach ( $subtitls as $caption ) {
            array_push( $captions, new HLSSubtitle( $caption['src'], $caption['label'], $caption['language'] ) );
        }
        $captions[$default]->default();
        $video = $this->ffmpeg->open( $path, $is_tmp );
        $video->hls()
            ->subtitles( $captions )
            ->x264()
            ->autoGenerateRepresentations( [1080, 720] )
            ->save( $dir );
    }

    /**
     * file uploading with ffmpeg
     * @param file name of the input file
     * @param filename name of the new file content
     */
    public function upload( $file, $filename ) {
        $f = $_FILES[$file]['tmp_name'];
        try {
            shell_exec( $this->ffmpeg . " -i $f public/resource/storage/$filename" );
            return "public/resource/storage/$filename";
        } catch ( \Throwable $th ) {
            return $th->getMessage();
        }
    }

    /**
     * single file hls
     * @param file name of the input files
     * @param path destination of the files
     * @param filename new file name for the hls file
     */
    public function singleHLS( $file, $path, $filename ) {
        $f = $_FILES[$file]['tmp_name'];
        if ( !is_dir( "public/resource/$path" ) ) {
            mkdir( "public/resource/$path", 0777, true );
        }
        try {
            if ( shell_exec( $this->ffmpeg . " -i $f -codec: copy -start_number 0 -hls_time 10 -hls_list_size 0 -f hls public/resource/$path/$filename" ) ) {
                return "public/resource/$path/$filename";
            }

        } catch ( \Throwable $th ) {
            return $th->getMessage();
        }
    }

    /**
     * multiple file hls
     * @param file name of the input files
     * @param path destination of the files
     * @param filename new file name for the hls file
     */
    public function multipleHLS( $file, $path, $filename ) {
        $f = $_FILES[$file]['tmp_name'];
        if ( !is_dir( "public/resource/stream/" . $path ) ) {
            mkdir( "public/resource/stream/" . $path, 0777, true );
            try {
                $ffmpeg = FFMPEG;
                shell_exec(
                    $ffmpeg . " -i $f \
                    -preset veryfast -g 25 -sc_threshold 0 \
                    -map v:0 -c:v:0 libx264 -b:v:0 2000k \
                    -map v:0 -c:v:1 libx264 -b:v:1 6000k \
                    -map a:0 -map a:0 -c:a aac -b:a 128k -ac 2 \
                    -f hls -hls_time 4 -hls_playlist_type event \
                    -master_pl_name $filename \
                    -var_stream_map 'v:0,a:0 v:1,a:1' public/resource/stream/$path/stream_%v.m3u8"
                );
                return "public/resource/stream/$path/$filename";
            } catch ( \Throwable $th ) {
                return $th->getMessage();
            }
        }
    }

    /**
     * lowHigh hls file
     * @param file name of the input files
     * @param path destination of the files
     */
    public function lowHighHLS( $file, $path ) {
        $f = $_FILES[$file]['tmp_name'];
        if ( !is_dir( "public/resource/stream/" . $path ) ) {
            mkdir( "public/resource/stream/" . $path, 0777, true );
            shell_exec(
                $this->ffmpeg . " -i $f \
                -map 0:v:0 -map 0:a:0 -map 0:v:0 -map 0:a:0 -map 0:v:0 -map 0:a:0 \
                -c:v libx264 -crf 22 -c:a aac -ar 48000 \
                -filter:v:0 scale=w=480:h=360  -maxrate:v:0 600k -b:a:0 500k \
                -filter:v:1 scale=w=640:h=480  -maxrate:v:1 1500k -b:a:1 1000k \
                -filter:v:2 scale=w=1280:h=720 -maxrate:v:2 3000k -b:a:2 2000k \
                -var_stream_map 'v:0,a:0,name:360p v:1,a:1,name:480p v:2,a:2,name:720p' \
                -preset fast -hls_list_size 0 -threads 0 -f hls \
                -hls_time 3 -hls_flags independent_segments \
                -master_pl_name livestream.m3u8 \
                -y public/resource/stream/$path/livestream-%v.m3u8"
            );
            return "public/resource/stream/" . $path . '/livestream.m3u8';
        } else {
            shell_exec(
                $this->ffmpeg . " -i $f \
                -map 0:v:0 -map 0:a:0 -map 0:v:0 -map 0:a:0 -map 0:v:0 -map 0:a:0 \
                -c:v libx264 -crf 22 -c:a aac -ar 48000 \
                -filter:v:0 scale=w=480:h=360  -maxrate:v:0 600k -b:a:0 500k \
                -filter:v:1 scale=w=640:h=480  -maxrate:v:1 1500k -b:a:1 1000k \
                -filter:v:2 scale=w=1280:h=720 -maxrate:v:2 3000k -b:a:2 2000k \
                -var_stream_map 'v:0,a:0,name:360p v:1,a:1,name:480p v:2,a:2,name:720p' \
                -preset fast -hls_list_size 0 -threads 0 -f hls \
                -hls_time 3 -hls_flags independent_segments \
                -master_pl_name livestream.m3u8 \
                -y public/resource/stream/$path/livestream-%v.m3u8"
            );
            return "public/resource/stream/" . $path . '/livestream.m3u8';
        }
    }

    /**
     * thumbnail generator with ffmpeg
     * @param file name of the input files
     * @param path destination of the files
     */
    public function thumbnailGenerator( $file, $path ) {
        $f = $_FILES[$file]['tmp_name'];
        if ( !is_dir( "public/resource/stream/" . $path ) ) {
            mkdir( "public/resource/stream/" . $path, 0777, true );
            shell_exec(
                $this->ffmpeg . " -ss 5 -t 7 -i $f \
                -vf 'fps=10,scale=720:-1:flags=lanczos,split[s0][s1];[s0]palettegen[p];[s1][p]paletteuse' \
                -loop 0 public/resource/stream/$path"
            );
            return "public/resource/stream/$path";
        } else {
            shell_exec(
                $this->ffmpeg . " -ss 5 -t 7 -i $f \
                -vf 'fps=10,scale=720:-1:flags=lanczos,split[s0][s1];[s0]palettegen[p];[s1][p]paletteuse' \
                -loop 0 public/resource/stream/$path"
            );
            return "public/resource/stream/$path";
        }
    }

    /**
     * extract image from a video with ffmpeg
     * @param file name of the input files
     * @param path destination of the files
     * @param interval interval time of the image
     */
    public function imageExtract( $file, $path, $interval ) {
        $f         = $_FILES[$file]['tmp_name'];
        $file_size = "340x220";
        if ( !is_dir( "public/resource/stream/" . $path ) ) {
            mkdir( "public/resource/stream/" . $path, 0777, true );
            shell_exec( $this->ffmpeg . " -i $f -an -ss $interval  -s $file_size public/resource/stream/$path" );
            return "public/resource/stream/$path";
        } else {
            shell_exec( $this->ffmpeg . " -i $f -an -ss $interval  -s $file_size public/resource/stream/$path" );
            return "public/resource/stream/$path";
        }
    }

    /**
     * prelive a video with ffmpeg
     * @param file name of the input files
     * will return a new rtmp url
     */
    public function preLIVE( $file ) {
        $stream = "rtmp://" . $_SERVER['HTTP_HOST'] . "/streaming/stream";
        $f      = $_FILES[$file]['tmp_name'];
        shell_exec( $this->ffmpeg . " -re -i $f -c:v libx264 -c:v aac -f flv $stream" );
        echo $stream;
    }

    /**
     * rtmpHLS a video with ffmpeg
     * @param url path of the video
     * @param name new name of the generated video
     */
    public function rtmpHLS( $url, $name ) {
        $rtmp = $this->ffmpeg . " -i $url
        -map 0:v:0 -map 0:a:0 -map 0:v:0 -map 0:a:0 -map 0:v:0 -map 0:a:0
        -c:v libx264 -crf 22 -c:a aac -ar 48000
        -filter:v:0 scale=w=480:h=360  -maxrate:v:0 600k -b:a:0 500k
        -filter:v:1 scale=w=640:h=480  -maxrate:v:1 1500k -b:a:1 1000k
        -filter:v:2 scale=w=1280:h=720 -maxrate:v:2 3000k -b:a:2 2000k
        -var_stream_map 'v:0,a:0,name:360p v:1,a:1,name:480p v:2,a:2,name:720p'
        -preset fast -hls_list_size 10 -threads 0 -f hls
        -hls_time 3 -hls_flags independent_segments
        -master_pl_name 'public/resource/stream/$name.m3u8'
        -y 'public/resource/stream/$name-%v.m3u8'";
        return $rtmp;
    }
}

//FFMPEG URL : https://gist.github.com/Andrey2G/78d42b5c87850f8fbadd0b670b0e6924

// ffmpeg -i zara.mp4 -preset veryfast -g 25 -sc_threshold 0 -map v:0 -c:v:0 libx264 -b:v:0 2000k -map v:0 -c:v:1 libx264 -b:v:1 6000k -map a:0 -map a:0 -c:a aac -b:a 128k -ac 2 -f hls -hls_time 4 -hls_playlist_type event -master_pl_name master.m3u8 -var_stream_map 'v:0,a:0 v:1,a:1' stream/stream_%v.m3u8
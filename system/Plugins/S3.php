<?php
/**
 * ABS PHP Framework
 *
 * @created      2023
 * @updated      2024-08-01
 * @version      1.0.6
 * @author       abdursoft <support@abdursoft.com>
 * @authorURI    https://abdursoft.com/author
 * @copyright    2024 abdursoft
 * @license      MIT
 *
 * @Written by Abdur Rahim
 */

namespace ABS\Framework\System\Plugins;

use Aws\ElasticTranscoder\ElasticTranscoderClient;
use Aws\S3\Exception\S3Exception;
use Aws\S3\S3Client;
use Coconut\Client;
use Exception;

include "vendor/autoload.php";

class S3 {
    public $aws;
    public $elastic;
    public function __construct() {
        $this->aws = new S3Client( [
            'version'     => 'latest',
            'region'      => 'auto',
            'endpoint'    => CLOUD_ENDPOINT,
            'credentials' => [
                'key'    => CLOUD_ACCESS_KEY,
                'secret' => CLOUD_SECRET_KEY,
            ],
        ] );

        $this->elastic = new ElasticTranscoderClient( [
            'version'     => 'latest',
            'region'      => AWS_REGION,
            'credentials' => [
                'key'    => AWS_KEY,
                'secret' => AWS_SECRET,
            ],
        ] );
    }

    public function awsUpload( $location, $tmp ) {
        try {
            $this->aws->putObject( [
                'Bucket' => CLOUD_BUCKET,
                'Key'    => $location,
                'Body'   => fopen( $tmp, 'rb' ),
                'ACL'    => 'public-read',
            ] );
            return true;
        } catch ( S3Exception $e ) {
            return false;
        }
    }

    public function awsUploadout( $location, $tmp ) {
        try {
            $this->aws->putObject( [
                'Bucket' => CLOUD_BUCKET,
                'Key'    => $location,
                'Body'   => fopen( $tmp, 'rb' ),
                'ACL'    => 'public-read',
            ] );
            return true;
        } catch ( S3Exception $e ) {
            return false;
        }
    }

    public function aws_bucket() {
        $contents = $this->aws->listObjectsV2( [
            'Bucket' => CLOUD_BUCKET,
        ] );

        var_dump( $contents['Contents'] );
    }

    public function cloud_upload( $bucket, $location, $tmp ) {
        try {
            $this->aws->putObject( [
                'Bucket' => $bucket,
                'Key'    => $location,
                'Body'   => fopen( $tmp, 'rb' ),
            ] );
            return true;
        } catch ( \Throwable $th ) {
            return false;
        }
    }

    public function coconut_upload( $file_bucket, $file, $new_name, $poster, $time ) {
        $new    = time() . ".mp4";
        $upload = $this->cloud_upload( CLOUD_BUCKET, $new, $file );
        if ( $upload ) {
            $coconut               = new Client( COCONUT_API_KEY );
            $coconut->notification = [
                'type' => 'http',
                'url'  => 'http://localhost:9000',
            ];
            $coconut->storage = [
                'service'     => 's3other',
                'bucket'      => $file_bucket,
                'region'      => 'auto',
                'credentials' => [
                    'access_key_id'     => CLOUD_ACCESS_KEY,
                    'secret_access_key' => CLOUD_SECRET_KEY,
                ],
                'endpoint'    => CLOUD_ENDPOINT,
            ];
            try {
                $jobs = $coconut->job->create( [
                    'input'   => ['url' => CLOUD_TEMP_URL . $new],
                    'outputs' => [
                        'webp'                 => [
                            [
                                'key'    => 'webp:cover',
                                'path'   => $poster,
                                'number' => 1,
                                'format' => [
                                    'resolution' => '600x',
                                ],
                            ],
                            [
                                'key'      => 'webp:thumbs',
                                'path'     => '/thumb/' . $time . '.webp',
                                'interval' => 10,
                                'format'   => [
                                    'resolution' => '200x',
                                ],
                                'sprite'   => [
                                    'limit'   => 100,
                                    'columns' => 10,
                                ],
                            ],
                        ],
                        "mp4:1080p::quality=4" => [
                            "key"  => "mp4:1080p",
                            "path" => $new_name,
                        ],
                    ],
                ] );
                return true;
            } catch ( Exception $d ) {
                return $d->getMessage();
            }
        }
    }

    public function elasticUpload( $location, $tmp, $s3_location, $videoFA, $imageFF ) {
        try {
            $this->aws->putObject( [
                'Bucket' => AWS_BUCKET_INPUT,
                'Key'    => $location,
                'Body'   => fopen( $tmp, 'rb' ),
                'ACL'    => 'public-read',
            ] );
            $this->elastic->createJob( array(
                'PipelineId' => AWS_PIPELINE,
                'Input'      => array(
                    'Key'         => $location,
                    'FrameRate'   => 'auto',
                    'Resolution'  => 'auto',
                    'AspectRatio' => 'auto',
                    'Interlaced'  => 'auto',
                    'Container'   => 'auto',
                ),
                'Output'     => array(
                    'Key'              => $s3_location . $videoFA,
                    'Rotate'           => '0',
                    'PresetId'         => '1684771800607-2ilzcg',
                    'OutputKeyPrefix'  => md5( rand( 100, 99999999 ) ),
                    'ThumbnailPattern' => $s3_location . $imageFF . '-700thumb-{count}',
                ),
            ) );
            return true;
        } catch ( S3Exception $e ) {
            return false;
        }
    }

    public function elasticTranscoder() {
    }

    public function awsDelete( $bucket, $location ) {
        try {
            $this->aws->deleteObject( [
                'Bucket' => $bucket,
                'Key'    => $location,
            ] );
            return true;
        } catch ( S3Exception $e ) {
            return false;
        }
    }

    public static function imageResize( $url, $size ) {
        $x_url = 'https://d1qjop2xj.cloudfront.net/partner_bill_com/image_30773654_1695293278.webp';
        $dl    = "https://dhvr16.cloudfront.net/filters:quality(80)/fit-in/";
        $alt   = "https://d1qjovqxj.cloudfront.net";

        $final = str_replace( $alt, '', $url );
        $final = $dl . $size . $final;
        return $final;
    }
}

<?php
// use Aws\S3\S3Client;
// use Aws\S3\Exception\S3Exception;

class aws_s3 {
    public $bucket = 'salon-de-ahn';
    public $url = 'https://salon-de-ahn.s3.ap-northeast-2.amazonaws.com/';

    // Constructor
    public function __construct() {
        require 'aws/aws-autoloader.php';

        $info = $this->s3Info();
        $this->s3Client = new \Aws\S3\S3Client($info);
    }

    /** S3 접속 정보 반환
    * @return array
    */
    public function s3Info() {
        return [
            'profile' => 'default',
            'region' => 'ap-northeast-2',
            'version' => 'latest',            
        ];
    }

    /** S3 버킷에 파일 업로드
     * 
     * @param string $bucket // 업로드할 버킷 이름
     * @param File $file // 업로드할 파일의 로컬 경로
     * @param string $path // (버킷 제외) 저장될 S3 폴더 경로 + 파일명
     * @return Object
     */
    public function put($bucket, $file, $path) {
        $options = [
            'Bucket' => $bucket,
            'SourceFile' => $file,
            'Key' => $path,
            'ACL' => 'private', // 업로드 시 파일 권한 설정
        ];

        return $this->s3Client->putObject($options);
    }

    // S3 버킷에서 파일 다운로드
    public function download($bucket, $keyname, $filename) {
        $result = $this->s3Client->getObject([
            'Bucket' => $bucket, // 다운로드 할 객체의 버킷명
            'Key' => $keyname, // (버킷 제외) 저장된 S3 폴더 경로+파일명
            'SaveAs' => fopen($filename, 'w') // 임시로 S3에서 파일 저장. 사용자가 파일 다운로드하고서 삭제됨
        ]);

        return $result['Body'];
    }

    // S3 버킷 내 파일 복사하기
    public function copy($bucket, $keyname, $original) {
        $options = [
            'Bucket'     => $bucket,
            'Key'        => "{$keyname}",
            'CopySource' => "{$bucket}/{$original}",
        ];

        return $this->s3Client->copyObject($options);
    }

    /** 파일 존재 확인
     * 
     * @param string $bucket
     * @param string $path
     * @return boolean
     */
    public function exist($bucket, $path) {
        return $this->s3Client->doesObjectExist($bucket, $path);
    }

    /** S3 버킷 내 파일 삭제
     * 
     * @param string $bucket
     * @param string|array $keys // S3 폴더 경로+파일명
     * @return Object
     */
    public function delete($bucket, $keys) {
        $keys = (array)$keys;

        $objects = [];
        foreach ($keys as $key) {
            array_push($objects, ['Key' => $key]);
        }

        $options = [
            'Bucket' => $bucket,
            'Delete' => [
                'Objects' => $objects,
            ],
        ];

        return $this->s3Client->deleteObjects($options);
    }
}
?>
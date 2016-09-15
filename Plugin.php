<?php namespace JumpLink\DownloadBundle;


use System\Classes\PluginBase;


class Plugin extends PluginBase
{
    /**
     * Registers custom twig functions
     *
     * @return array
     */
    public function registerMarkupTags()
    {
        return [

            'functions' => [
                'downloadAll' => function ( $downloads ) { 
                    // Bundel File Name 
                    $bundle_file_name = 'BrebLinerSevicesDocuments.zip';
                    $root = $_SERVER['DOCUMENT_ROOT'];
                    $public_path = 'storage/temp/public/';
                    $server_zip_path =  temp_path() . '/public/'. $bundle_file_name;

                    // check if file exists and delte it
                    if ( file_exists($server_zip_path) ) {
                        unlink( $server_zip_path );
                    }

                    // Initalize new ZIP File
                    $zip = new \ZipArchive;
                    $zip->open( $server_zip_path, \ZipArchive::CREATE );
            
                    // add Files to the above created ZIP
                    foreach ( $downloads as $download ) {
                        $filename = basename( $download['file']);
                        $server_file_path = $root . '/storage/app/media'. $download['file'];
                        $zip->addFile( $server_file_path, $filename );
                    }  

                    $zip->close();    
                    // return the public path 
                    echo  $public_path . $bundle_file_name;
                }
            ]
        ];
    }
}

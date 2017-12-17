<?php

/**
 * Created by PhpStorm.
 * User: contact@smaine.me
 * Date: 17/12/2017
 * Time: 16:34
 */
class FtpExport
{
    /**
     * @var string
     */
    protected $stream;

    /**
     * @var string
     */
    protected $user;

    /**
     * @var string
     */
    protected $password;

    /**
     * FtpExport constructor.
     * @param $stream
     * @param $user
     * @param $password
     */
    public function __construct($stream = null, $user = null, $password = null)
    {
        $this->stream = isset($stream) ? $stream : null;
        $this->user = isset($user) ? $user : null;
        $this->password = isset($password) ? $password : null;
    }


    /**
     *  Send the file to the ftp server
     *
     * @param $remoteFileName path and file name that yu want in the ftp
     * @param $file file that you want send
     *
     * @throws Exception
     */
    public function sendToFtp($remoteFileName, $file)
    {

        $connec = $this->connecToFtp();

        ftp_pasv ( $connec , true );

        if (ftp_put($connec, $remoteFileName, $file, FTP_ASCII) == false) {
            throw new \Exception("Cannot send $file");
        }

        ftp_close($connec);

        return true;

    }


    /**
     * @param null|string $stream
     * @param null|string $user
     * @param null|string $password
     *
     */
    public function connecToFtp($stream = null, $user = null, $password =  null)
    {
        $stream = isset($stream) ? $stream : $this->stream;
        $user  = isset($user) ? $user : $this->user;
        $password = isset($password) ? $password : $this->password;

        $connection = ftp_connect($stream);

        if (ftp_login (  $connection, $user , $password ) == false ) {
            throw new \Exception("Cannot connect to $stream");
        }

        return $connection;
    }
}
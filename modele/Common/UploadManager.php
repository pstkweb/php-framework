<?php
namespace Pstweb\Common;

use Pstweb\Exifer\Image\Image;
use Pstweb\Common\PathParser;

class UploadManager
{
    const DEST = 'images/';

    public static function factory()
    {
        if (!isset($_FILES)) {
            throw new \Exception("Aucun fichier téléchargé.", 1);
        }

        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $files = array();

        foreach ($_FILES as $name => $infos) {
            if ($_FILES[$name]['error'] == UPLOAD_ERR_OK) {
                $type = $finfo->file($_FILES[$name]['tmp_name']);
                $filename = BASE_FILE . UploadManager::DEST . md5(uniqid());

                switch ($type) {
                    case 'image/gif':
                    case 'image/jpeg':
                    case 'image/pjpeg':
                    case 'image/png':
                    case 'image/x-png':
                    case 'image/tiff':
                    case 'image/vnd.microsoft.icon':
                    case 'image/svg+xml':
                        $filename .= self::getFileExtension($type);
                        move_uploaded_file($_FILES[$name]['tmp_name'], $filename);

                        $files[$name] = Image::initialize(array(
                            "filename" => PathParser::getFileFromPath($filename)
                        ));
                        break;
                    default:
                        throw new \Exception("Ce type de fichier n'est pas pris en charge.", 1);
                }
            } else {
                switch ($_FILES[$name]['error']) {
                    case UPLOAD_ERR_INI_SIZE:
                        throw new \Exception("Le fichier dépasse la taille maximum autorisée par le serveur.", $_FILES[$name]['error']);
                    case UPLOAD_ERR_FORM_SIZE:
                        throw new \Exception("Le fichier dépasse la taille maximum autorisée par le formulaire.", $_FILES[$name]['error']);
                    case UPLOAD_ERR_PARTIAL:
                        throw new \Exception("Le fichier n'a pas été complètement téléchargé.", $_FILES[$name]['error']);
                    case UPLOAD_ERR_NO_FILE:
                        throw new \Exception("Aucun fichier n'a été téléchargé.", $_FILES[$name]['error']);
                    case UPLOAD_ERR_NO_TMP_DIR:
                        throw new \Exception("Il manque un dossier sur le serveur.", $_FILES[$name]['error']);
                    case UPLOAD_ERR_CANT_WRITE:
                        throw new \Exception("Impossible d'écrire le fichier sur le disque.", $_FILES[$name]['error']);
                    case UPLOAD_ERR_EXTENSION:
                        throw new \Exception("Une extension a stoppé le téléchargement du fichier.", $_FILES[$name]['error']);
                    default:
                        throw new \Exception("Une erreur inconnue est survenue.", $_FILES[$name]['error']);
                }
            }
        }

        return $files;
    }

    private static function getFileExtension($type)
    {
        switch ($type) {
            case 'image/gif':
                return '.gif';
            case 'image/jpeg':
            case 'image/pjpeg':
                return '.jpg';
            case 'image/png':
            case 'image/x-png':
                return '.png';
            case 'image/tiff':
                return '.tiff';
            case 'image/vnd.microsoft.icon':
                return '.ico';
            case 'image/svg+xml':
                return '.svg';
            default:
                throw new \Exception("Impossible de déterminer le type du fichier", 1);
        }
    }
}

<?php

namespace App\Infra\Forms\Client;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class Import extends Model
{
    /**
     * @var UploadedFile
     */
    public $file;

    /**
     * @var string
     */
    private $fullPathName;

    /**
     * @var string
     */
    private $fileName;

    /**
     * @var array
     */
    private $data;

    public function rules()
    {
        return [
            ['file', 'required'],
            ['file', 'file', 'skipOnEmpty' => false]
            //['file', 'file', 'skipOnEmpty' => false, 'extensions' => 'csv']
        ];
    }

    public function attributeLabels()
    {
        return [
            'file' => 'Selecione um arquivo'
        ];
    }

    public function attributeHints()
    {
        return [
            'file' => 'Somente arquivos no formato <strong>CSV</strong>
                com no máximo <strong>' . ini_get('upload_max_filesize') . '</strong>'
        ];
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    public function upload()
    {
        $tmpPath = Yii::getAlias('@runtime/tmp');
        $this->fileName = Yii::$app->getSecurity()->generateRandomString(15) . '.' . $this->file->extension;
        $this->fullPathName = $tmpPath . DS . $this->fileName;

        return $this->file->saveAs($this->fullPathName);
    }

    public function parseFile()
    {
        $rows = [];
        $fileHandler = fopen($this->fullPathName, 'r');

        while ($data = fgetcsv($fileHandler, 1000, ',')) {
            $rows[] = $data;
        }

        fclose($fileHandler);

        $total = count($rows);
        $lineNumber = 1;

        for ($i = 0; $i < $total; $i++) {
            if ($lineNumber === 1) {
                $lineNumber++;
                continue;
            }

            $this->data[] = [
                'name' => trim($rows[$i][0]),
                'cpf' => trim($rows[$i][1]),
                'email' => trim($rows[$i][2]),
                'phone_home' => trim($rows[$i][3]),
                'phone_cell' => trim($rows[$i][4]),
                'address_street' => trim($rows[$i][5]),
                'address_number' => trim($rows[$i][6]),
                'address_neighborhood' => trim($rows[$i][7]),
                'address_zipcode' => trim($rows[$i][8]),
                'address_complement' => trim($rows[$i][9])
            ];

            $lineNumber++;
        }

        return true;
    }
}

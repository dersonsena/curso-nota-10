<?php

namespace App\Application\Http\Client;

use App\Domains\Client\Client;
use Yii;
use yii\base\Action;
use App\Infra\Forms\Client\Import;
use yii\web\UploadedFile;

class ImportAction extends Action
{
    public function run()
    {
        $this->controller->setActionDescription('Importação de Clientes');

        /** @var Import $importForm */
        $importForm = Yii::$container->get(Import::class);

        if (Yii::$app->getRequest()->getIsPost()) {
            $importForm->file = UploadedFile::getInstance($importForm, 'file');

            if (!$importForm->upload()) {
                Yii::$app->getSession()->addFlash('error', 'Houve um erro ao enviar o arquivo.');
                return $this->controller->refresh();
            }

            if (!$importForm->parseFile()) {
                Yii::$app->getSession()->addFlash('error', 'Houve um erro ao ler arquivo de importação.');
                return $this->controller->refresh();
            }

            $transaction = Yii::$app->getDb()->beginTransaction();

            foreach ($importForm->getData() as $i => $row) {
                $lineNumber = $i + 1;
                $client = new Client();

                foreach ($row as $attribute => $value) {
                    $client->setAttribute($attribute, $value);
                }

                if (!$client->save()) {
                    Yii::$app->getSession()->addFlash('error', 'Erro ao inserir cliente da linha ' . $lineNumber . $client->getErrorsToHTMLList());
                    $transaction->rollBack();
                    return $this->controller->refresh();
                }
            }

            $transaction->commit();

            Yii::$app->getSession()->addFlash('success', "Foram importado(s) {$importForm->count()} cliente(s) com sucesso no sistema.");
            return $this->controller->redirect(['index']);
        }

        return $this->controller->render('import', [
            'importForm' => $importForm
        ]);
    }
}

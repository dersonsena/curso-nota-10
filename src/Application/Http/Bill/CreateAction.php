<?php

namespace App\Application\Http\Bill;

use App\Domains\Bill\Bill;
use DateTime;
use Yii;
use Exception;
use App\Infra\Forms\Bill\Form;
use yii\base\Action;

class CreateAction extends Action
{
    public function run()
    {
        $this->controller->setActionDescription('Nova Conta');

        /** @var Form $model */
        $model = Yii::$container->get(Form::class);
        $post = Yii::$app->getRequest()->post();
        $this->controller->setModel($model);

        if ($model->load($post) && $model->validate()) {
            $transaction = Yii::$app->getDb()->beginTransaction();
            $registration = (bool)$model->hasRegistration;
            $generateBills = (bool)$model->generateBills;

            try {
                $this->controller->saveFormData();

                if ($registration === false && $generateBills === false) {
                    $transaction->commit();
                    Yii::$app->getSession()->setFlash('success', 'Seus dados foram cadastrados com sucesso!');
                    return $this->controller->redirect(['index']);
                }

                if ($registration === true) {
                    $this->saveRegistration();
                }

                if ($generateBills === true) {
                    $this->generateBills();
                }

                $transaction->commit();
                Yii::$app->getSession()->setFlash('success', 'Seus dados foram cadastrados com sucesso!');
                return $this->controller->redirect(['index']);

            } catch (Exception $e) {
                $transaction->rollBack();
                Yii::$app->getSession()->setFlash('error', $e->getMessage());
                return $this->controller->redirect([$this->controller->action->id]);
            }
        }

        return $this->controller->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * @return bool
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\di\NotInstantiableException
     */
    private function saveRegistration()
    {
        /** @var Bill $billRegistration */
        $billRegistration = Yii::$container->get(Bill::class);
        $billRegistration->setAttributes($this->controller->getModel()->getAttributes());

        $billRegistration->description .= ' [Matrícula]';
        $billRegistration->bill_parent_id = $this->controller->getModel()->id;
        $billRegistration->observations = 'Essa conta representa uma matrícula referente a conta ' . $this->controller->getModel()->id;
        $billRegistration->amount = $this->controller->getModel()->registrationAmount;

        return $this->controller->getRepository()->save($billRegistration);
    }

    /**
     * @return bool
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\di\NotInstantiableException
     */
    private function generateBills()
    {
        /** @var Form $parentBill */
        $parentBill = $this->controller->getModel();
        $totalBills = (int)$parentBill->numberOfBills;

        for ($i = 0; $i < ($totalBills - 1); $i++) {
            /** @var Bill $bill */
            $bill = Yii::$container->get(Bill::class);
            $bill->setAttributes($parentBill->getAttributes());
            $parcelNumber = ($i + 2);

            $bill->due_date = (new DateTime($parentBill->due_date))
                ->modify('+' . ($i + 1) . ' month')
                ->format('d/m/Y');

            $bill->parcel_number = $parcelNumber;
            $bill->bill_parent_id = $parentBill->id;
            $bill->description .= " {$parcelNumber}/{$totalBills}";
            $bill->observations = 'Essa conta é referente a conta ' . $parentBill->id;

            $this->controller->getRepository()->save($bill);
        }

        $parentBill->parcel_number .= 1;
        $parentBill->description .= " 1/{$totalBills}";
        $this->controller->getRepository()->save($parentBill);

        return true;
    }
}

<?php

namespace App\Domains\User;

use Yii;
use App\Domains\User\Behaviors\CryptPassword;
use App\Domains\User\Behaviors\RefreshAuthKey;
use App\Application\ActiveRecord\ActiveRecordAbstract;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "{{%users}}".
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $auth_key
 * @property string $reset_token
 * @property int $status
 * @property int $deleted
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property string $created_by
 * @property string $updated_by
 * @property string $deleted_by
 */
class User extends ActiveRecordAbstract implements IdentityInterface
{
    /**
     * @var string
     */
    const SCENARIO_CREATE = 'create';

    /**
     * @var string
     */
    public $currentPassword = '';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%users}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'email'], 'required'],
            [['id', 'status', 'deleted'], 'integer'],
            ['id', 'unique'],
            ['email', 'email'],
            ['password', 'required', 'on' => self::SCENARIO_CREATE],
            ['email', 'unique', 'message' => '{attribute} {value} já está sendo utilizado.'],
            ['auth_key', 'string'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['name', 'email', 'password'], 'string', 'max' => 60],
            [['reset_token', 'created_by', 'updated_by', 'deleted_by'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return $this->buildAttributeLabels([
            'name' => 'Nome',
            'email' => 'E-mail',
            'password' => 'Senha'
        ]);
    }

    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            ['class' => CryptPassword::class],
            ['class' => RefreshAuthKey::class]
        ]);
    }

    public function fields()
    {
        $fields = parent::fields();
        unset($fields['password'], $fields['auth_key'], $fields['reset_token']);

        return $fields;
    }

    public function validatePassword(string $password)
    {
        return Yii::$app->getSecurity()->validatePassword($password, $this->password);
    }

    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne([
            'auth_key' => $token,
            'status' => 1
        ]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $authKey === $this->auth_key;
    }
}

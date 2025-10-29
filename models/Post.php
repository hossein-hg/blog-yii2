<?php

namespace app\models;
use yii\web\UploadedFile;
use Yii;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "posts".
 *
 * @property int $id
 * @property string $title
 * @property string $content
 * @property string|null $image_path
 * @property int $author_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Users $author
 * @property Comments[] $comments
 */
class Post extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'posts';
    }
    public $imageFile;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['image_path'], 'default', 'value' => null],
            [['title', 'content', 'author_id'], 'required'],
            [['content'], 'string'],
            [['author_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title', 'image_path'], 'string', 'max' => 255],
            [['imageFile'], 'file', 'skipOnEmpty' => true],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['author_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'content' => 'Content',
            'image_path' => 'Image Path',
            'author_id' => 'Author ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            
        ];
    }

    /**
     * Gets query for [[Author]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(User::class, ['id' => 'author_id']);
    }

    /**
     * Gets query for [[Comments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::class, ['post_id' => 'id']);
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new Expression('NOW()'), 
            ],
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            
            $this->imageFile = UploadedFile::getInstance($this, 'imageFile');
            
            if ($this->imageFile) {
                
                $fileName = 'uploads/' . time() . '_' . $this->imageFile->baseName . '.' . $this->imageFile->extension;
                
                $this->imageFile->saveAs($fileName);
                
                $this->image_path = $fileName; // ذخیره مسیر در ستون image_path
                
                return true;
                
            }
            return true; // اگر فایلی آپلود نشده باشد
        }
        return false;
    }

}

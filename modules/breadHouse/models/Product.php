<?php

namespace app\modules\breadHouse\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use app\modules\breadHouse\models\Categories;
use app\modules\breadHouse\models\Reviews;
use app\modules\breadHouse\models\ProductImages;

/**
 * This is the model class for table "products".
 *
 * @property int $id
 * @property int $category_id
 * @property string $name
 * @property string|null $description
 * @property string|null $composition
 * @property string|null $allergens
 * @property string|null $nutrition
 * @property float $price
 * @property string|null $image
 * @property float $rating
 * @property int $stock
 * @property string $created_at
 *
 * @property Categories $category
 * @property OrderItem[] $orderItems
 * @property Reviews[] $reviews
 */
class Product extends ActiveRecord
{
    public $imageFiles;
    public $oldImage;

    /**
     * {@inheritdoc}
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            // Set default values
            if ($this->stock === null) {
                $this->stock = 0;
            }
            if ($this->rating === null) {
                $this->rating = 0;
            }
            return true;
        }
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%products}}';
    }
    
    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('breadHouse');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id', 'name', 'price'], 'required'],
            [['category_id', 'stock'], 'integer'],
            [['description', 'composition', 'allergens', 'nutrition'], 'string'],
            [['price', 'rating'], 'number'],
            [['created_at'], 'safe'],
            [['name', 'image'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::class, 'targetAttribute' => ['category_id' => 'id']],
            [['imageFiles'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, gif', 'maxSize' => 2 * 1024 * 1024, 'maxFiles' => 5, 'checkExtensionByMimeType' => false],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Категория',
            'name' => 'Название',
            'description' => 'Описание',
            'composition' => 'Состав',
            'allergens' => 'Аллергены',
            'nutrition' => 'Пищевая ценность',
            'price' => 'Цена',
            'image' => 'Изображение',
            'imageFiles' => 'Изображения',
            'rating' => 'Рейтинг',
            'stock' => 'Остаток',
            'created_at' => 'Создано',
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Categories::class, ['id' => 'category_id']);
    }

    /**
     * Gets query for [[OrderItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrderItems()
    {
        return $this->hasMany(OrderItem::class, ['product_id' => 'id']);
    }

    /**
     * Gets query for [[Reviews]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Reviews::class, ['product_id' => 'id']);
    }

    /**
     * Gets query for [[ProductImages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductImages()
    {
        return $this->hasMany(ProductImages::class, ['product_id' => 'id'])->orderBy(['sort_order' => SORT_ASC]);
    }

    /**
     * Get main image (first image or fallback to single image field)
     */
    public function getMainImage()
    {
        $firstImage = $this->productImages->one();
        return $firstImage ? $firstImage->image : $this->image;
    }

    /**
     * Get all images as array
     */
    public function getAllImages()
    {
        $images = [];
        foreach ($this->productImages as $productImage) {
            $images[] = $productImage->image;
        }
        
        // Add single image if exists and not already in array
        if ($this->image && !in_array($this->image, $images)) {
            $images[] = $this->image;
        }
        
        return $images;
    }

    /**
     * Ensure upload directory exists
     */
    private function ensureUploadDir()
    {
        $uploadPath = Yii::getAlias('@webroot/uploads/products/');
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }
        return $uploadPath;
    }

    /**
     * Upload image file
     */
    public function uploadImage()
    {
        if ($this->imageFile) {
            $this->ensureUploadDir();
            
            $fileName = time() . '_' . $this->imageFile->baseName . '.' . $this->imageFile->extension;
            $uploadPath = Yii::getAlias('@webroot/uploads/products/');
            
            if ($this->imageFile->saveAs($uploadPath . $fileName)) {
                // Delete old image if exists
                $this->deleteOldImage();
                
                $this->image = '/uploads/products/' . $fileName;
                return true;
            }
        }
        return false;
    }

    /**
     * Delete old image file
     */
    private function deleteOldImage()
    {
        if ($this->oldImage && file_exists(Yii::getAlias('@webroot') . $this->oldImage)) {
            unlink(Yii::getAlias('@webroot') . $this->oldImage);
        }
    }

    /**
     * Upload multiple image files
     */
    public function uploadMultipleImages()
    {
        if (empty($this->imageFiles)) {
            return false;
        }
        
        $this->ensureUploadDir();
        $uploadedCount = 0;
        $allowedExtensions = ['png', 'jpg', 'jpeg', 'gif'];
        
        foreach ($this->imageFiles as $index => $file) {
            // Check if file was actually uploaded
            if (!$file instanceof UploadedFile || $file->error !== UPLOAD_ERR_OK) {
                continue;
            }
            
            // Validate file extension manually
            $extension = strtolower($file->extension);
            if (!in_array($extension, $allowedExtensions)) {
                continue;
            }
            
            $fileName = time() . '_' . $index . '_' . $file->baseName . '.' . $file->extension;
            $uploadPath = Yii::getAlias('@webroot/uploads/products/');
            
            try {
                if ($file->saveAs($uploadPath . $fileName)) {
                    $productImage = new ProductImages();
                    $productImage->product_id = $this->id;
                    $productImage->image = '/uploads/products/' . $fileName;
                    $productImage->sort_order = $index;
                    
                    if ($productImage->save()) {
                        $uploadedCount++;
                    }
                }
            } catch (\Exception $e) {
                // Log error but continue with other files
                error_log('Error uploading file: ' . $e->getMessage());
                continue;
            }
        }
        
        return $uploadedCount > 0;
    }

    /**
     * Delete image file
     */
    public function deleteImage()
    {
        if ($this->image && file_exists(Yii::getAlias('@webroot') . $this->image)) {
            unlink(Yii::getAlias('@webroot') . $this->image);
        }
    }

    /**
     * Delete all product images
     */
    public function deleteAllImages()
    {
        // Delete single image
        $this->deleteImage();
        
        // Delete multiple images
        foreach ($this->productImages as $productImage) {
            if (file_exists(Yii::getAlias('@webroot') . $productImage->image)) {
                unlink(Yii::getAlias('@webroot') . $productImage->image);
            }
            $productImage->delete();
        }
    }
}
